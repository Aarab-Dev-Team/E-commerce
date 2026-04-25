<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;

class ReviewController extends Controller
{
    /**
     * Store a newly created review.
     * Only customers who have purchased and not yet reviewed may submit.
     */
    public function store(Request $request, Product $product)
    {
        // Block admin & employee from adding reviews
        if (in_array(auth()->user()->role, ['admin', 'employee'])) {
            return redirect()->back()->with('error', 'Staff members cannot submit customer reviews.');
        }

        $validated = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // Must have a delivered order containing this product
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

        $product->reviews()->create([
            'user_id'     => auth()->id(),
            'rating'      => $validated['rating'],
            'comment'     => $validated['comment'],
            'is_approved' => true,
        ]);

        return redirect()->back()->with('success', 'Thank you for sharing your perspective!');
    }

    /**
     * Update own review (customer only).
     */
    public function update(Request $request, Review $review)
    {
        // Block admin & employee
        if (in_array(auth()->user()->role, ['admin', 'employee'])) {
            abort(403);
        }

        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $review->update($validated);

        return redirect()->back()->with('success', 'Your review has been updated.');
    }

    /**
     * Delete own review (customer only).
     */
    public function destroy(Review $review)
    {
        // Block admin & employee
        if (in_array(auth()->user()->role, ['admin', 'employee'])) {
            abort(403);
        }

        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $review->delete();

        return redirect()->back()->with('success', 'Your review has been removed.');
    }

    /**
     * Admin / Employee reply to a review.
     * Customers cannot access this endpoint.
     */
    public function reply(Request $request, Review $review)
    {
        // Only admin or employee
        if (!in_array(auth()->user()->role, ['admin', 'employee'])) {
            abort(403, 'Only staff can reply to reviews.');
        }

        $validated = $request->validate([
            'admin_reply' => 'required|string|max:1000',
        ]);

        $review->update([
            'admin_reply'    => $validated['admin_reply'],
            'admin_reply_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Reply posted successfully.');
    }
}
