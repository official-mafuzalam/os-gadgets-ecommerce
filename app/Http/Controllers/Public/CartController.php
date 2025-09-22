<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ShoppingCart;
use App\Models\Product;
use App\Services\FacebookCapiService;
use Illuminate\Http\Request;

use function Symfony\Component\String\b;

class CartController extends Controller
{
    // Get or create the current session cart
    protected function getCart()
    {
        $sessionId = session()->getId();
        return ShoppingCart::firstOrCreate(['session_id' => $sessionId]);
    }

    // Show cart page
    public function index()
    {
        $cart = $this->getCart();
        $items = $cart->items()->with('product')->get();

        return view('public.cart.index', [
            'cart' => $cart,
            'cartItems' => $items,
            'subtotal' => $cart->subtotal,
            'total' => $cart->subtotal,
            'tax' => 0,
        ]);
    }

    // Add product to cart
    public function add(Request $request, Product $product, FacebookCapiService $fbService)
    {
        try {
            $request->validate([
                'quantity' => 'required|integer|min:1|max:' . $product->stock_quantity
            ]);

            $cart = $this->getCart();
            $cart->addItem($product->id, $request->quantity);

            // 🔹 Facebook Pixel + CAPI AddToCart Event
            if (setting('fb_pixel_id') && setting('facebook_access_token')) {
                $eventId = fb_event_id();

                // Send to Facebook CAPI
                $fbService->sendEvent('AddToCart', $eventId, [
                    'em' => [hash('sha256', strtolower(auth()->user()->email ?? ''))],
                    'ph' => [hash('sha256', auth()->user()->phone ?? '')],
                    'client_ip_address' => request()->ip(),
                    'client_user_agent' => request()->userAgent(),
                ], [
                    'currency' => 'USD',
                    'value' => $product->price * $request->quantity,
                    'content_type' => 'product',
                    'content_ids' => [$product->sku],
                    'contents' => [
                        [
                            'id' => $product->sku,
                            'quantity' => $request->quantity,
                        ]
                    ],
                ]);

                // Save eventId to flash session for Blade use
                session()->flash('fb_event_id', $eventId);
            }

            return back()->with('success', 'Product added to cart!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to add product to cart: ' . $e->getMessage());
        }
    }


    // Update quantity of a cart item
    public function update(Request $request, $itemId)
    {
        try {
            $request->validate([
                'quantity' => 'required|integer|min:1'
            ]);

            $cart = $this->getCart();
            $item = $cart->items()->find($itemId);

            if (!$item) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart item not found'
                ], 404);
            }

            $product = $item->product;

            if ($request->quantity > $product->stock_quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Requested quantity exceeds available stock'
                ], 422);
            }

            $cart->updateItem($product->id, $request->quantity);

            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully',
                'cart_count' => $cart->total_quantity,
                'subtotal' => $cart->subtotal,
                'total' => $cart->subtotal,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update cart: ' . $e->getMessage()
            ], 500);
        }
    }

    // Remove a cart item
    public function remove($itemId)
    {
        try {
            $cart = $this->getCart();
            $item = $cart->items()->find($itemId);

            if (!$item) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart item not found'
                ], 404);
            }

            $cart->removeItem($item->product_id);

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart',
                'cart_count' => $cart->total_quantity,
                'subtotal' => $cart->subtotal,
                'total' => $cart->subtotal,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove item: ' . $e->getMessage()
            ], 500);
        }
    }

    // Clear the cart
    public function clear()
    {
        try {
            $cart = $this->getCart();
            $cart->clear();

            return response()->json([
                'success' => true,
                'message' => 'Cart cleared successfully',
                'cart_count' => 0,
                'subtotal' => 0,
                'total' => 0,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear cart: ' . $e->getMessage()
            ], 500);
        }
    }


}