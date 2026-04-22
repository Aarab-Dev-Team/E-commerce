<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CartService;
use App\Models\Product  ; 


class CartController extends Controller
{
       protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Display the cart page.
     */
    public function index()
    {
        $cart = $this->cartService->getCart();
        $items = $this->cartService->items();
        $subtotal = $this->cartService->subtotal();
        $count = $this->cartService->count();

        // Get recommended products (e.g., random active products)
        $recommended = Product::where('is_active', true)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('shop.cart', compact('cart', 'items', 'subtotal', 'count', 'recommended'));
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request, Product $product)
    {
        $quantity = (int) $request->input('quantity', 1);
        $this->cartService->add($product, $quantity);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart',
                'cart_count' => $this->cartService->count()
            ]);
        }

        return redirect()->back()->with('alert', [
            'type'=> "success" , 
            'message'=> 'Product added to cart.'
        ]);
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, int $itemId)
    {
        $quantity = (int) $request->input('quantity');
        $this->cartService->updateQuantity($itemId, $quantity);

        return redirect()->route('cart.index')->with('success', 'Cart updated.');
    }

    /**
     * Remove an item from the cart.
     */
    public function remove(int $itemId)
    {
        $this->cartService->remove($itemId);

        return redirect()->route('cart.index')->with('success', 'Item removed.');
    }

    /**
     * Clear the entire cart.
     */
    public function clear()
    {
        $this->cartService->clear();

        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }
}
