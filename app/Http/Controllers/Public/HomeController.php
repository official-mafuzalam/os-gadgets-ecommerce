<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Carousel;
use App\Models\Category;
use App\Models\Deal;
use App\Models\Product;
use App\Models\Review;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $carousels = Carousel::active()->ordered()->get();
        $deal = Deal::getCurrentDeal();

        $allProducts = Product::with(['category', 'brand', 'images'])
            ->where('is_active', true)
            ->latest()
            ->take(24)
            ->get();

        $featuredProducts = Product::with(['category', 'brand', 'images'])
            ->where('is_featured', true)
            ->where('is_active', true)
            ->take(12)
            ->get();

        // Get categories that have active products
        $categories = Category::whereHas('products', function ($query) {
            $query->where('is_active', true);
        })->withCount([
                    'products' => function ($query) {
                        $query->where('is_active', true);
                    }
                ])
            ->where('is_active', true)
            ->take(9)
            ->get();

        $allDeals = Deal::featured()->latest()->take(10)->get();

        $leftDeals = $allDeals->slice(0, 2);     // first 2 deals for left sidebar
        $rightDeals = $allDeals->slice(2, 2);    // next 2 deals for right sidebar
        $bottomDeals = $allDeals->slice(4, 6);   // next 6 deals for bottom grid

        return view('public.index', compact(
            'carousels',
            'deal',
            'allProducts',
            'featuredProducts',
            'categories',
            'leftDeals',
            'rightDeals',
            'bottomDeals'
        ));
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

    public function about()
    {
        return view('public.extra.about');
    }

    public function contact()
    {
        return view('public.extra.contact');
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

    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribers,email',
        ]);

        Subscriber::create([
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'Thank you for subscribing to our newsletter!');
    }

    public function privacyPolicy()
    {
        return view('public.extra.privacy-policy');
    }
    public function termsOfService()
    {
        return view('public.extra.terms-of-service');
    }
    public function returnPolicy()
    {
        return view('public.extra.return-policy');
    }

}
