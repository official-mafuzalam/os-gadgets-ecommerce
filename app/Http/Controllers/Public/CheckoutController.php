<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ShoppingCart;
use App\Models\Product;
use App\Models\ShippingAddress;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    protected function getCart()
    {
        $sessionId = session()->getId();
        return ShoppingCart::firstOrCreate(['session_id' => $sessionId]);
    }

    // Show checkout page for cart items
    public function index()
    {
        $cart = $this->getCart();
        $items = $cart->items()->with('product')->get();

        if ($items->isEmpty()) {
            return redirect()->route('public.products')->with('error', 'Your cart is empty.');
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
    public function process(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'required|string|max:20',
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

            DB::commit();

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
