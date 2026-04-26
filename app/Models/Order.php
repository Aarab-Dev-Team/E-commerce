<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User ; 
use App\Models\OrderItem ; 

class Order extends Model
{
    

    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'status',
        'payment_status',
        'payment_method',
        'shipping_address',
        'billing_address',
        'notes',
        'coupon_code',
        'discount_amount',
    ];


    public function user() { return $this->belongsTo(User::class); }
    public function items() { return $this->hasMany(OrderItem::class); }


    //this is used automatically in  research : 
    public function getRouteKeyName(): string
    {
        return 'order_number';
    }

}
