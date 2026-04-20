<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product ; 


class ProductController extends Controller
{
    

    public function index(){

        $cart = session()->get("cart" ,[]) ; 

        $products = Product::where('is_active' , true)->with('categories')->latest()->paginate(6) ; 
        return view('products.index' , [
            "products"=>$products , 
            "count" => count($cart) ,
        ]) ; 


    }

     public function show(string $slug)
    {
        $product = Product::with(['category', 'reviews.user'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Average rating and count
        $averageRating = $product->reviews()->avg('rating') ?? 0;
        $reviewsCount = $product->reviews()->count();

        // Related products
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        // Check if authenticated user has purchased this product (delivered orders only)
        $hasPurchased = false;
        $userReview = null;
        $canReview = false;

        if (auth()->check()) {
            // Has the user bought this product?
            $hasPurchased = auth()->user()->orders()
                ->where('status', 'delivered')
                ->whereHas('items', function ($query) use ($product) {
                    $query->where('product_id', $product->id);
                })->exists();

            // Has the user already reviewed this product?
            $userReview = $product->reviews()
                ->where('user_id', auth()->id())
                ->first();

            // Can review = logged in + purchased + not already reviewed
            $canReview = $hasPurchased && !$userReview;
        }

        return view('shop.product', compact(
            'product',
            'averageRating',
            'reviewsCount',
            'relatedProducts',
            'hasPurchased',
            'userReview',
            'canReview'
        ));
    }


}
