<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Mail\OrderPlaced;
use App\Models\ShoppingCart;
use App\Models\Product;
use App\Models\ShippingAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\FacebookCapiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    protected function getCart()
    {
        $sessionId = session()->getId();
        return ShoppingCart::firstOrCreate(['session_id' => $sessionId]);
    }

    // Show checkout page for cart items
    public function index(FacebookCapiService $fbService)
    {
        $cart = $this->getCart();
        $items = $cart->items()->with('product')->get();

        if ($items->isEmpty()) {
            return redirect()->route('public.products')->with('error', 'Your cart is empty.');
        }

        // 🔹 Facebook Pixel + CAPI InitiateCheckout Event
        if (setting('fb_pixel_id') && setting('facebook_access_token')) {
            $eventId = fb_event_id();

            $fbService->sendEvent('InitiateCheckout', $eventId, [
                'em' => [hash('sha256', strtolower(auth()->user()->email ?? ''))],
                'ph' => [hash('sha256', auth()->user()->phone ?? '')],
                'client_ip_address' => request()->ip(),
                'client_user_agent' => request()->userAgent(),
            ], [
                'currency' => 'USD',
                'value' => $cart->subtotal,
                'content_type' => 'product',
                'num_items' => $items->sum('quantity'),
                'content_ids' => $items->pluck('product.sku')->toArray(),
                'contents' => $items->map(function ($item) {
                    return [
                        'id' => $item->product->sku,
                        'quantity' => $item->quantity,
                    ];
                })->toArray(),
            ]);

            // Pass eventId to view for Pixel script
            session()->flash('fb_event_id', $eventId);
        }

        return view('public.checkout', [
            'cart' => $cart,
            'cartItems' => $items,
            'subtotal' => $cart->subtotal,
            'tax' => 0,
            'total' => $cart->subtotal,
        ]);
    }


    // Buy now for a single product
    public function buyNow(Product $product, Request $request)
    {
        $quantity = $request->input('quantity', 1);

        if ($quantity < 1)
            $quantity = 1;
        if ($quantity > $product->stock_quantity) {
            return redirect()->back()->with('error', 'Requested quantity exceeds available stock.');
        }

        $cart = $this->getCart();

        // Clear current cart for single product checkout
        $cart->clear();

        $cart->addItem($product->id, $quantity);

        return redirect()->route('public.checkout')->with('success', $product->name . ' added for checkout.');
    }

    // Process checkout (cart or single product)
    public function process(Request $request, FacebookCapiService $fbService)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'required|string|size:11',
            'full_address' => 'required|string|max:500',
            'delivery_area' => 'required|in:inside_dhaka,outside_dhaka',
            'payment_method' => 'nullable|in:cash_on_delivery,bkash,nagad,sslcommerz',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Determine delivery charge
        $deliveryCharge = $request->delivery_area === 'inside_dhaka' ? 80 : 150;

        // Start transaction
        DB::beginTransaction();

        try {
            // Create Shipping Address
            $shippingAddress = ShippingAddress::create([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'full_address' => $request->full_address,
                'delivery_area' => $request->delivery_area,
            ]);

            // Determine order items
            $cart = $this->getCart();
            $items = $cart->items()->with('product')->get();

            if ($items->isEmpty() && !$request->has('product_id')) {
                return redirect()->route('public.products')->with('error', 'Your cart is empty.');
            }

            // Calculate subtotal
            $subtotal = 0;
            $orderItemsData = [];

            if ($items->count() > 0) {
                // Cart checkout
                foreach ($items as $item) {
                    $subtotal += $item->total_price;
                    $orderItemsData[] = [
                        'product_id' => $item->product_id,
                        'unit_price' => $item->product->final_price,
                        'quantity' => $item->quantity,
                        'total_price' => $item->total_price,
                    ];
                }
            } else {
                // Single product checkout
                $product = Product::findOrFail($request->product_id);
                $quantity = $request->quantity ?? 1;
                $subtotal = $product->final_price * $quantity;

                $orderItemsData[] = [
                    'product_id' => $product->id,
                    'unit_price' => $product->final_price,
                    'quantity' => $quantity,
                    'total_price' => $subtotal,
                ];
            }

            // Create Order
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'customer_email' => $request->email,
                'customer_phone' => $request->phone,
                'subtotal' => $subtotal,
                'shipping_cost' => $deliveryCharge,
                'discount_amount' => 0,
                'total_amount' => $subtotal + $deliveryCharge,
                'shipping_address_id' => $shippingAddress->id,
                'payment_method' => $request->payment_method ?? 'cash_on_delivery',
                'status' => 'pending',
                'notes' => $request->notes,
                'payment_status' => 'pending',
            ]);

            // Create Order Items
            foreach ($orderItemsData as $itemData) {
                $order->items()->create($itemData);

                // Reduce stock
                $product = Product::find($itemData['product_id']);
                if ($product) {
                    $product->decreaseStock($itemData['quantity']);
                }
            }

            // Clear cart after checkout
            if ($items->count() > 0) {
                $cart->clear();
            }

            setMailConfigFromDB();

            if ($request->email) {
                Mail::to($request->email)->send(new OrderPlaced($order));
            }

            DB::commit();

            // After creating order
            $eventId = fb_event_id(); // generate unique event ID

            // Send Facebook CAPI Purchase event
            if (setting('fb_pixel_id') && setting('facebook_access_token')) {
                $fbService->sendEvent('Purchase', $eventId, [
                    'em' => [hash('sha256', strtolower($order->customer_email))],
                    'ph' => [hash('sha256', $order->customer_phone)],
                    'client_ip_address' => request()->ip(),
                    'client_user_agent' => request()->userAgent(),
                ], [
                    'currency' => 'USD',
                    'value' => $order->total_amount,
                    'content_ids' => $order->items->pluck('product.sku')->toArray(),
                    'contents' => $order->items->map(fn($i) => ['id' => $i->product->sku, 'quantity' => $i->quantity])->toArray(),
                ]);

                // Pass eventId to view via session
                session()->flash('fb_event_id', $eventId);
            }

            return redirect()->route('public.order.complete', ['order_number' => $order->order_number]);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }

    // Show order completion page
    public function orderComplete(Request $request)
    {
        $orderNumber = $request->query('order_number');
        $order = Order::with('items.product', 'shippingAddress')->where('order_number', $orderNumber)->first();

        if (!$order) {
            return redirect()->route('public.products')->with('error', 'Order not found.');
        }

        return view('public.order-complete', compact('order'));
    }


    // Show order tracking form
    public function orderTrack()
    {
        return view('public.parcel-tracking');
    }

    public function track(Request $request)
    {
        $request->validate([
            'tracking_number' => 'required|string|max:255'
        ]);

        // Find order by tracking number
        $order = Order::where('order_number', $request->tracking_number)
            ->first();

        if (!$order) {
            return back()->withErrors(['message' => 'No order found with provided tracking number.'])->withInput();
        }

        return view('public.parcel-tracking', ['order' => $order]);
    }

}
