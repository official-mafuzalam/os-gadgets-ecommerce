<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::latest()
            ->where('is_active', true)
            ->take(8)
            ->get();
        return view('public.index', compact('products'));
    }

    public function productShow(Product $product)
    {
        // Eager load relationships to avoid N+1 queries
        $product->load(['category', 'brand', 'reviews.user']);

        // Get related products (products from the same category)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->take(4)
            ->get();

        return view('public.product', compact('product', 'relatedProducts'));
    }

    public function category($category)
    {
        return view('public.category', compact('category'));
    }

    public function brand($brand)
    {
        return view('public.brand', compact('brand'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        return view('public.search', compact('query'));
    }
}
