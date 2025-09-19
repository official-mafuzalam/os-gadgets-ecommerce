<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Deal;
use App\Models\ProductAttribute;
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
    public function index(Request $request)
    {
        $brands = Brand::where('is_active', true)->get();
        $categories = Category::where('is_active', true)->get();

        $products = Product::with(['category', 'brand'])
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->when($request->brand, function ($query, $brand) {
                $query->where('brand_id', $brand);
            })
            ->when($request->category, function ($query, $category) {
                $query->where('category_id', $category);
            })
            ->when($request->status, function ($query, $status) {
                if ($status === 'active') {
                    $query->where('is_active', true);
                } elseif ($status === 'inactive') {
                    $query->where('is_active', false);
                }
            })
            ->latest()
            ->paginate(10)
            ->appends($request->all());

        return view('admin.products.index', compact('products', 'brands', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        $brands = Brand::where('is_active', true)->get();
        $allAttributes = Attribute::where('is_active', true)->get();
        $product = new Product();

        return view('admin.products.create', compact('categories', 'brands', 'product', 'allAttributes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        logger('All request data:', $request->all());
        logger('Product attributes:', ['product_attributes' => $request->input('product_attributes')]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'sku' => 'required|string|unique:products,sku',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'image_gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:400',
            'specifications' => 'nullable|json',
            'is_active' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean',
            'product_attributes' => 'nullable|array',
            'product_attributes.*.id' => 'required|exists:attributes,id',
            'product_attributes.*.values' => 'required|array',
            'product_attributes.*.values.*' => 'string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $validated['slug'] = Str::slug($validated['name']);
            $validated['is_active'] = $request->boolean('is_active');
            $validated['is_featured'] = $request->boolean('is_featured');

            if (!empty($validated['specifications'])) {
                $validated['specifications'] = json_decode($validated['specifications'], true);
            }

            // Create product
            $product = Product::create($validated);

            if ($request->filled('product_attributes')) { // Changed from attributes
                foreach ($request->product_attributes as $index => $attributeData) { // Changed from attributes
                    if (!empty($attributeData['id']) && !empty($attributeData['values'])) {
                        foreach ($attributeData['values'] as $valueIndex => $value) {
                            ProductAttribute::create([
                                'product_id' => $product->id,
                                'attribute_id' => $attributeData['id'],
                                'value' => trim($value),
                                'order' => $valueIndex
                            ]);
                        }
                    }
                }
            }


            // Handle gallery images
            if ($request->hasFile('image_gallery')) {
                foreach ($request->file('image_gallery') as $index => $image) {
                    $galleryPath = $image->store('products/gallery', 'public');

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $galleryPath,
                        'is_primary' => $index === 0,
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
        $allAttributes = Attribute::where('is_active', true)->get();

        // Load product attributes with pivot values
        $product->load('attributes');

        // Group attributes by attribute_id and collect values
        $groupedAttributes = $product->attributes
            ->groupBy('id')
            ->map(function ($items) {
                return [
                    'id' => $items->first()->id,
                    'name' => $items->first()->name,
                    'values' => $items->pluck('pivot.value')->toArray()
                ];
            })->values(); // reset keys

        return view('admin.products.edit', compact(
            'product',
            'categories',
            'brands',
            'allAttributes',
            'groupedAttributes'
        ));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Debug the request data
        logger('Request all data:', $request->all());
        logger('Product attributes in request:', $request->input('product_attributes', []));

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'image_gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:400',
            'specifications' => 'nullable|json',
            'is_active' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean',
            'product_attributes' => 'nullable|array', // Changed from attributes
            'product_attributes.*.id' => 'required|exists:attributes,id',
            'product_attributes.*.values' => 'required|array',
            'product_attributes.*.values.*' => 'string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $validated['slug'] = Str::slug($validated['name']);
            $validated['is_active'] = $request->boolean('is_active');
            $validated['is_featured'] = $request->boolean('is_featured');

            // Decode specifications JSON
            if (!empty($validated['specifications'])) {
                $validated['specifications'] = json_decode($validated['specifications'], true);
            }

            // Update product
            $product->update($validated);

            // --- Handle product attributes ---
            // Remove all old attributes
            ProductAttribute::where('product_id', $product->id)->delete();

            if ($request->filled('product_attributes')) { // Changed from attributes
                foreach ($request->product_attributes as $order => $attributeData) { // Changed from attributes
                    $attrId = $attributeData['id'] ?? null;
                    $values = $attributeData['values'] ?? [];

                    if ($attrId && !empty($values)) {
                        foreach ($values as $valueIndex => $value) {
                            ProductAttribute::create([
                                'product_id' => $product->id,
                                'attribute_id' => (int) $attrId,
                                'value' => trim($value),
                                'order' => $valueIndex,
                            ]);
                        }
                    }
                }

                Log::info('Product attributes synced', [
                    'product_id' => $product->id,
                    'product_attributes' => $request->input('product_attributes', []) // Changed from attributes
                ]);
            }

            // Handle gallery images
            if ($request->hasFile('image_gallery')) {
                foreach ($request->file('image_gallery') as $index => $image) {
                    $galleryPath = $image->store('products/gallery', 'public');

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $galleryPath,
                        'is_primary' => $index === 0 && $product->images()->where('is_primary', true)->doesntExist(),
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
     * Display a listing of soft-deleted products.
     */
    public function trash()
    {
        $products = Product::onlyTrashed()
            ->with(['category', 'brand'])
            ->latest()
            ->paginate(10);

        return view('admin.products.trash', compact('products'));
    }
    /**
     * Restore a soft-deleted product.
     */
    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();
        return redirect()->route('admin.products.trash')
            ->with('success', 'Product restored successfully.');
    }
    /**
     * Permanently delete a soft-deleted product.
     */
    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->forceDelete();

        return redirect()->route('admin.products.trash')
            ->with('success', 'Product permanently deleted successfully.');
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
        $prompt = "Write a professional product description for the following product, highlighting its key features and benefits: " . $productName;

        $apiKey = null;
        $model = null;
        $url = null;
        $apiName = null;
        $postData = [];

        if (setting('api_openai_enabled') === '1') {
            $apiKey = setting('api_openai_key');
            $model = setting('api_openai_model');
            $url = 'https://api.openai.com/v1/chat/completions';
            $apiName = 'openai';
            $postData = [
                'model' => $model,
                'messages' => [['role' => 'user', 'content' => $prompt]],
                'max_tokens' => 250, // Added for OpenAI compatibility
                'temperature' => 0.7,
            ];
        } elseif (setting('api_mistral_enabled') === '1') {
            $apiKey = setting('api_mistral_key');
            $model = setting('api_mistral_model');
            $url = 'https://api.mistral.ai/v1/chat/completions';
            $apiName = 'mistral';
            $postData = [
                'model' => $model,
                'messages' => [['role' => 'user', 'content' => $prompt]],
                'max_tokens' => 250, // Added for Mistral compatibility
                'temperature' => 0.7,
            ];
        } elseif (setting('api_deepseek_enabled') === '1') {
            $apiKey = setting('api_deepseek_key');
            $model = setting('api_deepseek_model');
            $url = 'https://api.deepseek.com/v1/chat/completions';
            $apiName = 'deepseek';
            $postData = [
                'model' => $model,
                'messages' => [['role' => 'user', 'content' => $prompt]],
                'max_tokens' => 250, // Added for DeepSeek compatibility
                'temperature' => 0.7,
            ];
        } elseif (setting('api_gemini_enabled') === '1') {
            $apiKey = setting('api_gemini_key');
            $model = setting('api_gemini_model', 'gemini-1.5-flash');
            // Use the correct endpoint for Gemini with API key in URL
            $url = 'https://generativelanguage.googleapis.com/v1beta/models/' . $model . ':generateContent?key=' . $apiKey;
            $apiName = 'gemini';
            $postData = [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'maxOutputTokens' => 500, // Increased token limit
                    'temperature' => 0.8,     // Slightly higher temperature for more varied output
                    'topP' => 0.95,           // Add topP for more control
                ],
                // **Crucial: Explicitly set safety settings to BLOCK_NONE for testing if needed**
                // WARNING: Adjust these based on your application's actual safety requirements.
                // Setting to BLOCK_NONE will allow potentially unsafe content.
                'safetySettings' => [
                    ['category' => 'HARM_CATEGORY_HATE_SPEECH', 'threshold' => 'BLOCK_NONE'],
                    ['category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT', 'threshold' => 'BLOCK_NONE'],
                    ['category' => 'HARM_CATEGORY_HARASSMENT', 'threshold' => 'BLOCK_NONE'],
                    ['category' => 'HARM_CATEGORY_DANGEROUS_CONTENT', 'threshold' => 'BLOCK_NONE'],
                ]
            ];
            $apiKey = null; // Unset it for the header if using URL param
        } else {
            return response()->json(['error' => 'No API is enabled in settings'], 500);
        }

        if (!$apiKey && $apiName !== 'gemini') {
            return response()->json(['error' => ucfirst($apiName) . ' API key is not configured.'], 500);
        }
        if ($apiName === 'gemini' && !setting('api_gemini_key')) {
            return response()->json(['error' => 'Gemini API key is not configured.'], 500);
        }

        try {
            $headers = ['Content-Type' => 'application/json'];
            if ($apiKey) {
                $headers['Authorization'] = 'Bearer ' . $apiKey;
            }

            $response = Http::withHeaders($headers)
                ->withOptions([
                    'verify' => !app()->environment('local'),
                ])
                ->post($url, $postData);

            Log::info("{$apiName} API Raw Response Status: " . $response->status());
            Log::info("{$apiName} API Raw Response Body: " . $response->body());

            if ($response->failed()) {
                Log::error("{$apiName} API HTTP error: " . $response->status(), ['response' => $response->json()]);
                return response()->json([
                    'error' => 'API call failed with HTTP status ' . $response->status(),
                    'api_response' => $response->json()
                ], $response->status());
            }

            $result = $response->json();
            $description = null;

            if ($apiName === 'gemini') {
                if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                    $description = trim($result['candidates'][0]['content']['parts'][0]['text']);
                } elseif (isset($result['promptFeedback']['blockReason'])) {
                    // Check if content was blocked by safety settings
                    Log::warning("Gemini API: Prompt or response blocked by safety settings.", [
                        'blockReason' => $result['promptFeedback']['blockReason'],
                        'safetyRatings' => $result['promptFeedback']['safetyRatings'],
                        'prompt' => $prompt
                    ]);
                    return response()->json([
                        'error' => 'Gemini API blocked content due to safety settings.',
                        'block_reason' => $result['promptFeedback']['blockReason']
                    ], 400); // 400 Bad Request is appropriate for content policy violation
                } else {
                    Log::error($apiName . ' API: No text or explicit block reason found in Gemini response.', ['response' => $result]);
                    return response()->json(['error' => 'Failed to extract description from Gemini API response or no content generated.'], 500);
                }
            } elseif (isset($result['choices'][0]['message']['content'])) {
                $description = trim($result['choices'][0]['message']['content']);
            }

            if ($description) {
                return response()->json(['description' => $description]);
            } else {
                Log::error($apiName . ' API: Failed to extract description (final check).', ['response' => $result]);
                return response()->json(['error' => 'Failed to generate description from ' . ucfirst($apiName) . ' API.'], 500);
            }
        } catch (\Exception $e) {
            Log::error('API call failed: ' . $e->getMessage(), ['exception' => $e, 'apiName' => $apiName]);
            return response()->json(['error' => 'API call failed due to an exception: ' . $e->getMessage()], 500);
        }
    }

    private function setting(string $key, $default = null): ?string
    {
        // YOUR ACTUAL IMPLEMENTATION HERE
        // Example using Laravel's config helper:
        if (str_starts_with($key, 'api_openai'))
            return config('services.openai.' . str_replace('api_openai_', '', $key), $default);
        if (str_starts_with($key, 'api_mistral'))
            return config('services.mistral.' . str_replace('api_mistral_', '', $key), $default);
        if (str_starts_with($key, 'api_deepseek'))
            return config('services.deepseek.' . str_replace('api_deepseek_', '', $key), $default);
        if (str_starts_with($key, 'api_gemini'))
            return config('services.gemini.' . str_replace('api_gemini_', '', $key), $default);

        return $default;
    }

}