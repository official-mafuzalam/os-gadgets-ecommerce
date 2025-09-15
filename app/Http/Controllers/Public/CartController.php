<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = ShoppingCart::content();
        $subtotal = ShoppingCart::subtotal();
        $tax = ShoppingCart::tax();
        $total = ShoppingCart::total();

        return view('public.cart.index', compact('cartItems', 'subtotal', 'tax', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock_quantity
        ]);

        CartItem::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => $request->quantity,
            'price' => $product->final_price,
            'options' => [
                'image' => $product->image,
                'slug' => $product->slug,
                'sku' => $product->sku,
                'stock' => $product->stock_quantity
            ]
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart',
            'cart_count' => ShoppingCart::count()
        ]);
    }

    public function update(Request $request, $rowId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $item = ShoppingCart::get($rowId);
        $product = Product::find($item->id);

        if ($request->quantity > $product->stock_quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Requested quantity exceeds available stock'
            ], 422);
        }

        ShoppingCart::update($rowId, $request->quantity);

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully',
            'cart_count' => ShoppingCart::count(),
            'subtotal' => ShoppingCart::subtotal(),
            'total' => ShoppingCart::total()
        ]);
    }

    public function remove($rowId)
    {
        ShoppingCart::remove($rowId);

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart',
            'cart_count' => ShoppingCart::count(),
            'subtotal' => ShoppingCart::subtotal(),
            'total' => ShoppingCart::total()
        ]);
    }

    public function clear()
    {
        ShoppingCart::destroy();

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully',
            'cart_count' => ShoppingCart::count()
        ]);
    }
}