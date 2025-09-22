<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Deal;
use App\Models\Product;
use App\Models\Review;
use App\Services\FacebookCapiService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $perPageProducts = 20;

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

        $products = $query->paginate($this->perPageProducts);

        $categories = Category::withCount('products')->active()->get();
        $brands = Brand::withCount('products')->active()->get();

        return view('public.products.index', compact('products', 'categories', 'brands'));
    }

    public function productShow($slug, FacebookCapiService $fbService)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        // Eager load relationships
        $product->load(['category', 'brand', 'attributes', 'reviews.user']);

        // Related products
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->take(4)
            ->get();

        // Group attributes
        $groupedAttributes = $product->attributes
            ->groupBy('id')
            ->map(function ($items) {
                return [
                    'id' => $items->first()->id,
                    'name' => $items->first()->name,
                    'values' => $items->pluck('pivot.value')->unique()->toArray(),
                ];
            })
            ->values();

        // 🔹 Facebook Pixel + CAPI Event
        if (setting('fb_pixel_id') && setting('facebook_access_token')) {
            $eventId = fb_event_id();

            // Fire Pixel in Blade view (pass eventId to JS)
            // and fire CAPI from backend
            $fbService->sendEvent('ViewContent', $eventId, [
                'em' => [hash('sha256', strtolower(auth()->user()->email ?? ''))],
                'ph' => [hash('sha256', auth()->user()->phone ?? '')],
                'client_ip_address' => request()->ip(),
                'client_user_agent' => request()->userAgent(),
            ], [
                'currency' => 'USD',
                'value' => $product->price,
                'content_type' => 'product',
                'content_ids' => [$product->sku],
                'contents' => [
                    [
                        'id' => $product->sku,
                        'quantity' => 1,
                    ]
                ],
            ]);
        }

        // dd($eventId);
        return view('public.products.show', compact('product', 'relatedProducts', 'groupedAttributes', 'eventId'));
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

        $products = $query->paginate($this->perPageProducts);
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

        $products = $query->paginate(20);
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

        $products = $query->paginate($this->perPageProducts);

        $categories = Category::withCount('products')->active()->get();
        $brands = Brand::withCount('products')->active()->get();

        return view('public.products.index', compact('products', 'categories', 'brands'))->with('is_featured', true);
    }

    public function deals()
    {
        // Get active deals
        $activeDeals = Deal::active()
            ->ordered()
            ->get();

        // Get featured products from all active deals
        $featuredProducts = Product::whereHas('deals', function ($query) {
            $query->where('is_active', true)
                ->where(function ($q) {
                    $q->whereNull('starts_at')
                        ->orWhere('starts_at', '<=', now());
                })
                ->where(function ($q) {
                    $q->whereNull('ends_at')
                        ->orWhere('ends_at', '>=', now());
                })
                ->where('deal_product.is_featured', true);
        })
            ->with([
                'deals' => function ($query) {
                    $query->where('is_active', true);
                }
            ])
            ->active()
            ->inStock()
            ->take(8)
            ->get();

        // Get all products from active deals (paginated)
        $allDealProducts = Product::whereHas('deals', function ($query) {
            $query->where('is_active', true)
                ->where(function ($q) {
                    $q->whereNull('starts_at')
                        ->orWhere('starts_at', '<=', now());
                })
                ->where(function ($q) {
                    $q->whereNull('ends_at')
                        ->orWhere('ends_at', '>=', now());
                });
        })
            ->with([
                'deals' => function ($query) {
                    $query->where('is_active', true);
                }
            ])
            ->active()
            ->orderBy('name')
            ->paginate(10);

        return view('public.deals.index', compact('activeDeals', 'featuredProducts', 'allDealProducts'));
    }

    public function dealShow(Deal $deal, Request $request)
    {
        $query = $deal->products()->with(['category', 'brand', 'reviews'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->active();

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
        $products = $query->paginate($this->perPageProducts);

        $categories = Category::withCount('products')->active()->get();
        $brands = Brand::withCount('products')->active()->get();

        return view('public.products.index', compact('products', 'categories', 'brands'))->with('deal', $deal);
    }

    public function submitReview(Request $request, $productId)
    {
        try {
            $request->validate([
                'order_number' => 'required|exists:orders,order_number',
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'required|string|max:1000',
            ]);

            $product = Product::findOrFail($productId);

            $review = new Review();
            $review->product_id = $product->id;
            $review->rating = $request->rating;
            $review->comment = $request->comment;

            if (auth()->check()) {
                // Logged-in user review
                $review->user_id = auth()->id();
            } else {
                // Guest review
                $review->guest_name = $request->guest_name ?? 'Anonymous';
                $review->guest_email = $request->guest_email;
            }

            // Default: require approval before showing
            $review->is_approved = false;
            $review->save();

            return redirect()->back()->with('success', 'Your review has been submitted and is pending approval.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to submit review: ' . $e->getMessage());
        }
    }


}
