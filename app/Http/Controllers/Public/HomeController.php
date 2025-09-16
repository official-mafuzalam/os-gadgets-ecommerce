<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $allProducts = Product::latest()
            ->where('is_active', true)
            ->take(8)
            ->get();

        $featuredProducts = Product::where('is_featured', true)
            ->where('is_active', true)
            ->take(8)
            ->get();

        return view('public.index', compact('allProducts', 'featuredProducts'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->where('is_active', true)
            ->get();

        return view('public.search', compact('query', 'products'));
    }

    public function products(Request $request)
    {
        $query = Product::with(['category', 'brand', 'reviews'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->active();

        // Filter by category
        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)->firstOrFail();
            $query->where('category_id', $category->id);
        }

        // Filter by brand
        if ($request->has('brand')) {
            $brand = Brand::where('slug', $request->brand)->firstOrFail();
            $query->where('brand_id', $brand->id);
        }

        // Price filter
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sorting
        switch ($request->get('sort', 'newest')) {
            case 'price_low_high':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high_low':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12);

        $categories = Category::withCount('products')->active()->get();
        $brands = Brand::withCount('products')->active()->get();

        return view('public.products.index', compact('products', 'categories', 'brands'));
    }

    public function productShow($product)
    {
        $product = Product::where('slug', $product)->firstOrFail();
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

        return view('public.products.show', compact('product', 'relatedProducts'));
    }

    public function brands()
    {
        $brands = Brand::withCount('products')
            ->active()
            ->orderBy('name')
            ->paginate(24);

        $featuredBrands = Brand::withCount('products')
            ->active()
            ->take(8)
            ->get();
        return view('public.brands.index', compact('brands', 'featuredBrands'));
    }
    public function brandShow($brand)
    {
        $brand = Brand::where('slug', $brand)->firstOrFail();

        $query = Product::with(['category', 'brand', 'reviews'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->active()
            ->where('brand_id', $brand->id);

        // Sorting
        switch (request()->get('sort', 'newest')) {
            case 'price_low_high':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high_low':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12);
        $categories = Category::withCount('products')->active()->get();
        $brands = Brand::withCount('products')->active()->get();

        return view('public.products.index', compact('products', 'categories', 'brands', 'brand'));
    }

    public function categories()
    {
        $categories = Category::withCount('products')
            ->active()
            ->orderBy('name')
            ->paginate(12);

        $featuredCategories = Category::withCount('products')
            ->active()
            ->take(6)
            ->get();

        return view('public.categories.index', compact('categories', 'featuredCategories'));
    }

    public function categoryShow($category)
    {
        $category = Category::where('slug', $category)->firstOrFail();

        $query = Product::with(['category', 'brand', 'reviews'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->active()
            ->where('category_id', $category->id);

        // Sorting
        switch (request()->get('sort', 'newest')) {
            case 'price_low_high':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high_low':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12);
        $categories = Category::withCount('products')->active()->get();
        $brands = Brand::withCount('products')->active()->get();

        return view('public.products.index', compact('products', 'categories', 'brands', 'category'));
    }

    public function featuredProducts(Request $request)
    {
        $query = Product::with(['category', 'brand', 'reviews'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->active()
            ->where('is_featured', true);

        // Sorting
        switch ($request->get('sort', 'newest')) {
            case 'price_low_high':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high_low':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12);

        $categories = Category::withCount('products')->active()->get();
        $brands = Brand::withCount('products')->active()->get();

        // Pass a flag to indicate these are featured products
        return view('public.products.index', compact('products', 'categories', 'brands'))->with('is_featured', true);
    }

    public function deals()
    {
        return view('public.deals.index');
    }

    public function about()
    {
        return view('public.about');
    }

    public function contact()
    {
        return view('public.contact');
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // Here you can handle the contact form submission,
        // like sending an email or storing the message in the database.

        return redirect()->route('public.contact')->with('success', 'Your message has been sent successfully!');
    }

}
