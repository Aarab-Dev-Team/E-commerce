<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product ;
use App\Models\Wishlist;

class WishlistController extends Controller
{
  

    /**
     * Display user's wishlist.
     */
    public function index()
    {
        $wishlistItems = auth()->user()->wishlist()->with('product')->latest()->get();
        return view('profile.wishlist.index', compact('wishlistItems'));
    }

    /**
     * Toggle wishlist item (add if not exists, remove if exists).
     */
    public function toggle(Request $request, Product $product)
    {
        $user = auth()->user();
        $exists = $user->wishlist()->where('product_id', $product->id)->exists();

        if ($exists) {
            $user->wishlist()->where('product_id', $product->id)->delete();
            $message = 'Product removed from wishlist.';
            $added = false;
        } else {
            $user->wishlist()->create(['product_id' => $product->id]);
            $message = 'Product added to wishlist.';
            $added = true;
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message, 'added' => $added]);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Remove a specific wishlist item.
     */
    public function destroy(Product $product)
    {
        auth()->user()->wishlist()->where('product_id', $product->id)->delete();
        return redirect()->back()->with('success', 'Product removed from wishlist.');
    }
}
