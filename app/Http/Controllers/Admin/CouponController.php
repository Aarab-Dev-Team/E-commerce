<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->get();
        return view('admin.coupons.index', compact('coupons'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code'             => 'required|string|unique:coupons,code|max:32',
            'type'             => 'required|in:percentage,fixed',
            'value'            => 'required|numeric|min:0.01',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_uses'         => 'nullable|integer|min:1',
            'expires_at'       => 'nullable|date|after:today',
            'is_active'        => 'boolean',
        ]);

        $data['code'] = strtoupper($data['code']);
        $data['is_active'] = $request->boolean('is_active', true);

        Coupon::create($data);

        return back()->with('alert', [
            'type'    => 'success',
            'message' => 'Coupon created successfully.',
            'icon'    => 'check',
        ]);
    }

    public function update(Request $request, Coupon $coupon)
    {
        $data = $request->validate([
            'type'             => 'required|in:percentage,fixed',
            'value'            => 'required|numeric|min:0.01',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_uses'         => 'nullable|integer|min:1',
            'expires_at'       => 'nullable|date',
            'is_active'        => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active', false);

        $coupon->update($data);

        return back()->with('alert', [
            'type'    => 'success',
            'message' => 'Coupon updated.',
            'icon'    => 'check',
        ]);
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return back()->with('alert', [
            'type'    => 'success',
            'message' => 'Coupon deleted.',
            'icon'    => 'check',
        ]);
    }
}
