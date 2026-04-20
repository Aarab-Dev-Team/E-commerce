<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product  ; 
use App\Models\Review ; 

class ReviewController extends Controller
{
      /**
     * Store a newly created review in storage.
     */
    public function store(Request $request, Product $product)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // Check if the user has purchased this product (order delivered)
        $hasPurchased = auth()->user()->orders()
            ->where('status', 'delivered')
            ->whereHas('items', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->exists();

        if (!$hasPurchased) {
            return redirect()->back()
                ->with('error', 'You can only review products you have purchased and received.');
        }

        // Prevent duplicate reviews
        $existingReview = $product->reviews()
            ->where('user_id', auth()->id())
            ->first();

        if ($existingReview) {
            return redirect()->back()
                ->with('error', 'You have already submitted a review for this product.');
        }

        // Create the review
        $review = $product->reviews()->create([
            'user_id'     => auth()->id(),
            'rating'      => $validated['rating'],
            'comment'     => $validated['comment'],
            'is_approved' => true, // Auto-approve for simplicity
        ]);

        return redirect()->back()
            ->with('success', 'Thank you for sharing your perspective!');
    }

    /**
     * Update the specified review (optional – if you allow editing later).
     */
    public function update(Request $request, Review $review)
    {
        // Ensure the authenticated user owns the review
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $review->update($validated);

        return redirect()->back()
            ->with('success', 'Your review has been updated.');
    }

    /**
     * Remove the specified review (optional).
     */
    public function destroy(Review $review)
    {
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $review->delete();

        return redirect()->back()
            ->with('success', 'Your review has been removed.');
    }
}
