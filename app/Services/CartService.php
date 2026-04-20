<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Collection;

class CartService
{
    protected ?Cart $cart = null;

    /**
     * Initialize the service by loading or creating the current cart.
     */
    public function __construct()
    {
        $this->cart = $this->getOrCreateCart();
    }

    /**
     * Get the current cart instance.
     */
    public function getCart(): Cart
    {
        return $this->cart;
    }

    /**
     * Retrieve or create a cart for the current user/guest.
     */
    protected function getOrCreateCart(): Cart
    {
        if (auth()->check()) {
            $userCart = Cart::firstOrCreate(['user_id' => auth()->id()]);

            // If a guest cart exists with the current session, merge it into the user's cart
            $sessionCart = Cart::where('session_id', session()->getId())->first();
            if ($sessionCart && $sessionCart->id !== $userCart->id) {
                $this->mergeCarts($sessionCart, $userCart);
            }

            return $userCart;
        }

        // Guest user: cart identified by session_id
        return Cart::firstOrCreate(['session_id' => session()->getId()]);
    }

    /**
     * Merge items from a guest cart into a user cart.
     */
    protected function mergeCarts(Cart $from, Cart $to): void
    {
        foreach ($from->items as $item) {
            $existingItem = $to->items()->where('product_id', $item->product_id)->first();

            if ($existingItem) {
                $existingItem->update([
                    'quantity' => $existingItem->quantity + $item->quantity,
                ]);
            } else {
                $to->items()->create([
                    'product_id'    => $item->product_id,
                    'quantity'      => $item->quantity,
                    'price_at_time' => $item->price_at_time,
                ]);
            }
        }

        // Delete the guest cart after merging
        $from->delete();
    }

    /**
     * Add a product to the cart.
     */
    public function add(Product $product, int $quantity = 1): CartItem
    {
        $existingItem = $this->cart->items()->where('product_id', $product->id)->first();

        if ($existingItem) {
            $existingItem->update([
                'quantity' => $existingItem->quantity + $quantity,
            ]);
            return $existingItem;
        }

        return $this->cart->items()->create([
            'product_id'    => $product->id,
            'quantity'      => $quantity,
            'price_at_time' => $product->price,
        ]);
    }

    /**
     * Update the quantity of a specific cart item.
     */
    public function updateQuantity(int $itemId, int $quantity): bool
    {
        $item = $this->cart->items()->find($itemId);
        if (!$item) {
            return false;
        }

        if ($quantity <= 0) {
            return $this->remove($itemId);
        }

        return $item->update(['quantity' => $quantity]);
    }

    /**
     * Remove an item from the cart.
     */
    public function remove(int $itemId): bool
    {
        $item = $this->cart->items()->find($itemId);
        return $item ? $item->delete() : false;
    }

    /**
     * Remove all items from the cart.
     */
    public function clear(): void
    {
        $this->cart->items()->delete();
    }

    /**
     * Get all items in the cart with their related product.
     */
    public function items(): Collection
    {
        return $this->cart->items()->with('product')->get();
    }

    /**
     * Get the total number of items (sum of quantities) in the cart.
     */
    public function count(): int
    {
        return $this->cart->items()->sum('quantity');
    }

    /**
     * Calculate the subtotal of all items in the cart.
     */
    public function subtotal(): float
    {
        return $this->cart->items->sum(function ($item) {
            return $item->quantity * $item->price_at_time;
        });
    }

    /**
     * Calculate the total price (subtotal + any additional fees).
     * Override this method to add shipping, tax, etc.
     */
    public function total(): float
    {
        return $this->subtotal();
    }

    /**
     * Check if the cart is empty.
     */
    public function isEmpty(): bool
    {
        return $this->cart->items()->count() === 0;
    }

    /**
     * Transfer the current cart to a user (used after login/registration).
     */
    public function transferToUser(int $userId): void
    {
        $this->cart->update([
            'user_id'    => $userId,
            'session_id' => null,
        ]);
    }

    /**
     * Refresh the cart instance (useful after login).
     */
    public function refresh(): void
    {
        $this->cart = $this->getOrCreateCart();
    }
}