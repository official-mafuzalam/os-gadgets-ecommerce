<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DealController extends Controller
{
    /**
     * Display a listing of the deals.
     */
    public function index()
    {
        $deals = Deal::orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.deals.index', compact('deals'));
    }

    /**
     * Show the form for creating a new deal.
     */
    public function create()
    {
        return view('admin.deals.create');
    }

    /**
     * Store a newly created deal in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_text' => 'nullable|string|max:255',
            'discount_percentage' => 'nullable|integer|min:0|max:100',
            'discount_details' => 'nullable|string|max:255',
            'button_text' => 'required|string|max:50',
            'button_link' => 'required|url',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'background_color' => 'required|string|max:100',
            'is_active' => 'boolean',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'priority' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('deals', 'public');
        }

        $deal = Deal::create([
            'title' => $request->title,
            'description' => $request->description,
            'discount_text' => $request->discount_text,
            'discount_percentage' => $request->discount_percentage,
            'discount_details' => $request->discount_details,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'image_url' => $imagePath ? Storage::url($imagePath) : null,
            'background_color' => $request->background_color,
            'is_active' => $request->has('is_active'),
            'starts_at' => $request->starts_at,
            'ends_at' => $request->ends_at,
            'priority' => $request->priority,
        ]);

        return redirect()->route('admin.deals.index')
            ->with('success', 'Deal created successfully.');
    }

    /**
     * Display the specified deal.
     */
    public function show(Deal $deal)
    {
        return view('admin.deals.show', compact('deal'));
    }

    /**
     * Show the form for editing the specified deal.
     */
    public function edit(Deal $deal)
    {
        return view('admin.deals.edit', compact('deal'));
    }

    /**
     * Update the specified deal in storage.
     */
    public function update(Request $request, Deal $deal)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_text' => 'nullable|string|max:255',
            'discount_percentage' => 'nullable|integer|min:0|max:100',
            'discount_details' => 'nullable|string|max:255',
            'button_text' => 'required|string|max:50',
            'button_link' => 'required|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'background_color' => 'required|string|max:100',
            'is_active' => 'boolean',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'priority' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($deal->image_url) {
                $oldImagePath = str_replace('/storage/', '', $deal->image_url);
                Storage::disk('public')->delete($oldImagePath);
            }

            $imagePath = $request->file('image')->store('deals', 'public');
            $deal->image_url = Storage::url($imagePath);
        }

        $deal->update([
            'title' => $request->title,
            'description' => $request->description,
            'discount_text' => $request->discount_text,
            'discount_percentage' => $request->discount_percentage,
            'discount_details' => $request->discount_details,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'background_color' => $request->background_color,
            'is_active' => $request->has('is_active'),
            'starts_at' => $request->starts_at,
            'ends_at' => $request->ends_at,
            'priority' => $request->priority,
        ]);

        return redirect()->route('admin.deals.index')
            ->with('success', 'Deal updated successfully.');
    }

    /**
     * Remove the specified deal from storage.
     */
    public function destroy(Deal $deal)
    {
        // Delete associated image
        if ($deal->image_url) {
            $imagePath = str_replace('/storage/', '', $deal->image_url);
            Storage::disk('public')->delete($imagePath);
        }

        $deal->delete();

        return redirect()->route('admin.deals.index')
            ->with('success', 'Deal deleted successfully.');
    }

    /**
     * Toggle the active status of a deal.
     */
    public function toggleStatus(Deal $deal)
    {
        $deal->is_active = !$deal->is_active;
        $deal->save();

        return redirect()->back()
            ->with('success', 'Deal status updated successfully.');
    }

    /**
     * Toggle the featured status of a deal.
     */
    public function toggleDealFeatured(Deal $deal)
    {
        $deal->is_featured = !$deal->is_featured;
        $deal->save();

        return redirect()->back()
            ->with('success', 'Deal featured status updated successfully.');
    }

    /**
     * Display products associated with a specific deal.
     */
    public function productsShow(Deal $deal)
    {
        $allProducts = $deal->products()->paginate(20);
        return view('admin.deals.products', compact('deal', 'allProducts'));
    }

    /**
     * Show form to manage products for a deal.
     */
    public function manageProducts(Deal $deal)
    {
        $allProducts = Product::active()->orderBy('name')->get();

        return view('admin.deals.products', compact('deal', 'allProducts'));
    }

    /**
     * Assign products to a deal.
     */
    public function assignProducts(Request $request, Deal $deal)
    {
        $request->validate([
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id',
        ]);

        // Get current product count to set order for new products
        $currentCount = $deal->products()->count();
        $syncData = [];

        foreach ($request->product_ids as $index => $productId) {
            $syncData[$productId] = [
                'order' => $currentCount + $index,
                'is_featured' => false
            ];
        }

        // Attach new products without detaching existing ones
        $deal->products()->syncWithoutDetaching($syncData);

        return redirect()->back()
            ->with('success', 'Products added to deal successfully.');
    }

    /**
     * Remove a product from a deal.
     */
    public function removeProduct(Deal $deal, Product $product)
    {
        $deal->products()->detach($product->id);

        return redirect()->back()
            ->with('success', 'Product removed from deal successfully.');
    }

    /**
     * Toggle featured status for a product in a deal.
     */
    public function toggleFeatured(Deal $deal, Product $product)
    {
        $isFeatured = !$deal->products()->where('product_id', $product->id)->first()->pivot->is_featured;

        $deal->products()->updateExistingPivot($product->id, ['is_featured' => $isFeatured]);

        return redirect()->back()
            ->with('success', 'Featured status updated successfully.');
    }
}