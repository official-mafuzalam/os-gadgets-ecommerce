<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarouselController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:settings_manage')->only([
            'index',
            'create',
            'store',
            'edit',
            'update',
            'destroy',
            'reorder'
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carousels = Carousel::ordered()->get();
        return view('admin.carousels.index', compact('carousels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.carousels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:600',
            'button_text' => 'nullable|string|max:50',
            'button_url' => 'nullable|url|max:255',
            'secondary_button_text' => 'nullable|string|max:50',
            'secondary_button_url' => 'nullable|url|max:255',
            'background_color' => 'nullable|string|max:100',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('carousels', 'public');
        }

        Carousel::create($validated);

        return redirect()->route('admin.carousels.index')
            ->with('success', 'Carousel item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Carousel $carousel)
    {
        return view('admin.carousels.edit', compact('carousel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Carousel $carousel)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:600',
            'button_text' => 'nullable|string|max:50',
            'button_url' => 'nullable|url|max:255',
            'secondary_button_text' => 'nullable|string|max:50',
            'secondary_button_url' => 'nullable|url|max:255',
            'background_color' => 'nullable|string|max:100',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($carousel->image) {
                Storage::disk('public')->delete($carousel->image);
            }
            $validated['image'] = $request->file('image')->store('carousels', 'public');
        }

        $carousel->update($validated);

        return redirect()->route('admin.carousels.index')
            ->with('success', 'Carousel item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Carousel $carousel)
    {
        // Delete image
        if ($carousel->image) {
            Storage::disk('public')->delete($carousel->image);
        }

        $carousel->delete();

        return redirect()->route('admin.carousels.index')
            ->with('success', 'Carousel item deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $order = $request->input('order');

        foreach ($order as $index => $id) {
            Carousel::where('id', $id)->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
