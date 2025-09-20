<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:reviews_manage')->only(['index', 'approve', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::with('product', 'user')->paginate(10);
        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Approve a review.
     */
    public function approve(Review $review)
    {
        $isApproved = !$review->is_approved;
        $review->is_approved = $isApproved;
        $review->save();
        return redirect()->route('admin.reviews.index')->with('success', $isApproved ? 'Review approved successfully.' : 'Review unapproved successfully.');
    }


}
