<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class WishlistController extends Controller
{
    /**
     * Display user's wishlist.
     */
    public function index()
    {
        $wishlistItems = auth()->user()
            ->wishlist()
            ->with('product')
            ->latest()
            ->get();

        return view('profile.wishlist.index', compact('wishlistItems'));
    }

    /**
     * Toggle wishlist item (add/remove).
     */
    public function toggle(Request $request, Product $product)
    {
        $user = auth()->user();

        $exists = $user->wishlist()
            ->where('product_id', $product->id)
            ->exists();

        if ($exists) {
            $user->wishlist()
                ->where('product_id', $product->id)
                ->delete();

            $message = 'Removed from wishlist';
            $added = false;
        } else {
            $user->wishlist()->create([
                'product_id' => $product->id
            ]);

            $message = 'Added to wishlist';
            $added = true;
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'added' => $added
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Remove a specific wishlist item.
     */
    public function destroy(Request $request, Product $product)
    {
        $deleted = auth()->user()
            ->wishlist()
            ->where('product_id', $product->id)
            ->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => (bool) $deleted,
                'message' => $deleted ? 'Removed from wishlist' : 'Item not found in wishlist',
            ], $deleted ? 200 : 404);
        }

        if ($deleted) {
            return redirect()->back()->with('success', 'Removed from wishlist');
        }

        return redirect()->back()->with('error', 'Item not found in wishlist');
    }
}