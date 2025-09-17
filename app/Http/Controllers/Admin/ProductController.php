<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Deal;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['category', 'brand'])->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        $brands = Brand::where('is_active', true)->get();
        $product = new Product();
        return view('admin.products.create', compact('categories', 'brands', 'product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'sku' => 'required|string|unique:products,sku',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'image_gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'specifications' => 'nullable|json',
            'is_active' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean'
        ]);

        try {
            DB::beginTransaction();

            // Auto-generate SKU if not provided
            if (empty($validated['sku'])) {
                $validated['sku'] = 'SKU-' . strtoupper(uniqid());
            }

            // Generate slug from name
            $validated['slug'] = Str::slug($validated['name']);

            // Ensure unique slug
            $originalSlug = $validated['slug'];
            $count = 1;
            while (Product::where('slug', $validated['slug'])->exists()) {
                $validated['slug'] = $originalSlug . '-' . $count++;
            }

            // Handle main image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('products', 'public');
                $validated['image'] = $imagePath;
            }

            // Set boolean fields
            $validated['is_active'] = $request->boolean('is_active');
            $validated['is_featured'] = $request->boolean('is_featured');

            // Parse specifications JSON
            if ($request->has('specifications')) {
                $validated['specifications'] = json_decode($validated['specifications'], true);
            }

            // Create product
            $product = Product::create($validated);

            // Handle gallery images upload
            if ($request->hasFile('image_gallery')) {
                foreach ($request->file('image_gallery') as $index => $image) {
                    $galleryPath = $image->store('products/gallery', 'public');

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $galleryPath,
                        'is_primary' => $index === 0 // Set first image as primary
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Product created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Product creation failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'Something went wrong while creating the product.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $allDeals = Deal::active()->ordered()->get();
        $product->load(['category', 'brand', 'images']);
        return view('admin.products.show', compact('product', 'allDeals'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->get();
        $brands = Brand::where('is_active', true)->get();
        $product->load('images');

        return view('admin.products.create', compact('categories', 'brands', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'specifications' => 'nullable|json',
            'is_active' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean'
        ]);

        try {
            DB::beginTransaction();

            // Generate slug if name changed
            if ($product->name !== $validated['name']) {
                $validated['slug'] = Str::slug($validated['name']);

                // Ensure unique slug
                $originalSlug = $validated['slug'];
                $count = 1;
                while (Product::where('slug', $validated['slug'])->where('id', '!=', $product->id)->exists()) {
                    $validated['slug'] = $originalSlug . '-' . $count++;
                }
            }

            // Handle main image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }

                $imagePath = $request->file('image')->store('products', 'public');
                $validated['image'] = $imagePath;
            }

            // Set boolean fields
            $validated['is_active'] = $request->boolean('is_active');
            $validated['is_featured'] = $request->boolean('is_featured');

            // Parse specifications JSON
            if ($request->has('specifications')) {
                $validated['specifications'] = json_decode($validated['specifications'], true);
            }

            // Update product
            $product->update($validated);

            // Handle gallery images upload
            if ($request->hasFile('image_gallery')) {
                foreach ($request->file('image_gallery') as $image) {
                    $galleryPath = $image->store('products/gallery', 'public');

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $galleryPath,
                        'is_primary' => false
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Product updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Product update failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'Something went wrong while updating the product.']);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete associated images
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        if ($product->image_gallery) {
            foreach ($product->image_gallery as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Toggle the active status of the product.
     */
    public function toggleStatus(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);

        return back()->with('success', 'Product status updated successfully');
    }

    /**
     * Toggle the featured status of the product.
     */
    public function toggleFeatured(Product $product)
    {
        $product->update(['is_featured' => !$product->is_featured]);

        return back()->with('success', 'Product featured status updated successfully');
    }

    /**
     * Set primary image for the product.
     */
    public function setPrimaryImage(Request $request, Product $product)
    {
        $request->validate([
            'image_id' => 'required|exists:product_images,id'
        ]);

        try {
            DB::beginTransaction();

            // Reset all images to non-primary
            ProductImage::where('product_id', $product->id)
                ->update(['is_primary' => false]);

            // Set the selected image as primary
            $image = ProductImage::find($request->image_id);
            $image->is_primary = true;
            $image->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Primary image updated successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Failed to set primary image: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to set primary image'
            ], 500);
        }
    }

    /**
     * Show form to assign deals to a product.
     */
    public function editDeals(Product $product)
    {
        $allDeals = Deal::orderBy('priority', 'desc')->get();

        return view('admin.products.show', compact('product', 'allDeals'));
    }

    /**
     * Assign deals to a product.
     */
    public function assignDeals(Request $request, Product $product)
    {
        $request->validate([
            'deal_ids' => 'nullable|array',
            'deal_ids.*' => 'exists:deals,id',
        ]);

        // Sync the deals (replace existing assignments)
        $syncData = [];
        if ($request->has('deal_ids')) {
            foreach ($request->deal_ids as $dealId) {
                $syncData[$dealId] = ['is_featured' => false]; // Default values
            }
        }

        $product->deals()->sync($syncData);

        return redirect()->back()
            ->with('success', 'Deal assignments updated successfully.');
    }

    /**
     * Remove a product from a deal.
     */
    public function removeDeal(Product $product, Deal $deal)
    {
        $product->deals()->detach($deal->id);

        return redirect()->back()
            ->with('success', 'Product removed from deal successfully.');
    }


    public function generateDescription(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string'
        ]);

        $productName = $request->product_name;
        $prompt = "Write a professional product description for: " . $productName;

        // -----------------------------
        // Determine which API is enabled
        // -----------------------------
        if (setting('api_openai_enabled') === '1') {
            $apiKey = setting('api_openai_key');
            $model = setting('api_openai_model');
            $url = 'https://api.openai.com/v1/chat/completions';
            $apiName = 'openai';
        } elseif (setting('api_mistral_enabled') === '1') {
            $apiKey = setting('api_mistral_key');
            $model = setting('api_mistral_model');
            $url = 'https://api.mistral.ai/v1/chat/completions';
            $apiName = 'mistral';
        } elseif (setting('api_deepseek_enabled') === '1') {
            $apiKey = setting('api_deepseek_key');
            $model = setting('api_deepseek_model');
            $url = 'https://api.deepseek.com/v1/chat/completions';
            $apiName = 'deepseek';
        } else {
            return response()->json(['error' => 'No API is enabled'], 500);
        }

        try {
            // -----------------------------
            // Call the selected API
            // -----------------------------
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json'
            ])->withOptions([
                        'verify' => false, // Disable SSL verification
                    ])->post($url, [
                        'model' => $model,
                        'messages' => [
                            ['role' => 'user', 'content' => $prompt]
                        ]
                    ]);



            $result = $response->json();

            // -----------------------------
            // Extract the description
            // -----------------------------
            $description = null;

            if (isset($result['choices'][0]['message']['content'])) {
                $description = trim($result['choices'][0]['message']['content']);
            } elseif (isset($result['output_text'])) { // DeepSeek format
                $description = trim($result['output_text']);
            }

            if ($description) {
                return response()->json(['description' => $description]);
            } else {
                Log::error($apiName . ' API error: ', $result);
                return response()->json(['error' => 'Failed to generate description'], 500);
            }
        } catch (\Exception $e) {
            Log::error('API call failed: ' . $e->getMessage());
            return response()->json(['error' => 'API call failed'], 500);
        }
    }

}