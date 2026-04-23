<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Apply a coupon to the current session cart.
     */
    public function apply(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $code   = strtoupper(trim($request->coupon_code));
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return back()->withErrors(['coupon_code' => 'This coupon code is invalid.'])->withInput();
        }

        // Calculate current cart total
        $cart = session('cart', []);
        $cartTotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        if (!$coupon->isValid((float) $cartTotal)) {
            $message = 'This coupon is not valid';
            if ($coupon->min_order_amount && $cartTotal < $coupon->min_order_amount) {
                $message .= ' — minimum order amount is $' . number_format($coupon->min_order_amount, 2);
            } elseif ($coupon->expires_at && $coupon->expires_at->isPast()) {
                $message .= ' — this coupon has expired';
            } elseif (!$coupon->is_active) {
                $message .= ' — this coupon is no longer active';
            } elseif ($coupon->max_uses !== null && $coupon->uses >= $coupon->max_uses) {
                $message .= ' — this coupon has reached its usage limit';
            }
            return back()->withErrors(['coupon_code' => $message . '.'])->withInput();
        }

        // Store coupon code in session
        session(['applied_coupon' => $code]);

        return back()->with('alert', [
            'type'    => 'success',
            'message' => 'Coupon applied successfully!',
            'icon'    => 'check',
        ]);
    }

    /**
     * Remove the applied coupon from the session.
     */
    public function remove()
    {
        session()->forget('applied_coupon');

        return back()->with('alert', [
            'type'    => 'success',
            'message' => 'Coupon removed.',
            'icon'    => 'check',
        ]);
    }
}
