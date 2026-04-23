<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order_amount',
        'max_uses',
        'uses',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'value'            => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'discount_amount'  => 'decimal:2',
        'is_active'        => 'boolean',
        'expires_at'       => 'datetime',
    ];

    /**
     * Check whether this coupon is currently valid for a given cart total.
     */
    public function isValid(float $cartTotal): bool
    {
        if (!$this->is_active) return false;

        if ($this->expires_at && $this->expires_at->isPast()) return false;

        if ($this->max_uses !== null && $this->uses >= $this->max_uses) return false;

        if ($this->min_order_amount !== null && $cartTotal < $this->min_order_amount) return false;

        return true;
    }

    /**
     * Calculate the discount amount for a given cart total.
     */
    public function calculateDiscount(float $cartTotal): float
    {
        if ($this->type === 'percentage') {
            return round($cartTotal * ($this->value / 100), 2);
        }
        // fixed — cannot exceed cart total
        return min((float) $this->value, $cartTotal);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'coupon_code', 'code');
    }
}
