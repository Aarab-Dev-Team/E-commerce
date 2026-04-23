<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coupon;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        $coupons = [
            [
                'code'             => 'TUNA10',
                'type'             => 'percentage',
                'value'            => 10,
                'min_order_amount' => 5.00,
                'max_uses'         => null,
                'expires_at'       => null,
                'is_active'        => true,
            ],
            [
                'code'             => 'SAVE2',
                'type'             => 'fixed',
                'value'            => 2.00,
                'min_order_amount' => 10.00,
                'max_uses'         => null,
                'expires_at'       => null,
                'is_active'        => true,
            ],
            [
                'code'             => 'WELCOME15',
                'type'             => 'percentage',
                'value'            => 15,
                'min_order_amount' => null,
                'max_uses'         => 100,
                'expires_at'       => now()->addMonths(6),
                'is_active'        => true,
            ],
            [
                'code'             => 'BULK5',
                'type'             => 'fixed',
                'value'            => 5.00,
                'min_order_amount' => 25.00,
                'max_uses'         => null,
                'expires_at'       => null,
                'is_active'        => true,
            ],
        ];

        foreach ($coupons as $coupon) {
            Coupon::updateOrCreate(['code' => $coupon['code']], $coupon);
        }
    }
}
