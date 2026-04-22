<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory; 


use App\Models\CartItem ; 
use App\Models\Category ; 
use App\Models\Review ; 
use App\Models\Wishlist ; 

class Product extends Model
{
    
    use HasFactory;

      protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stock_quantity',
        'category_id',
        'origin',
        'color',
        'material',
        'images',
        'is_active',
        'pending_status',
        'pending_data',
        'original_data',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'images' => 'array',       
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'pending_data' => 'array',
        'original_data' => 'array',
    ];

    public function category() { return $this->belongsTo(Category::class); }
    public function reviews() { return $this->hasMany(Review::class); }
    public function cartItems() { return $this->hasMany(CartItem::class); }

    public function wishlistedBy()
    {
        return $this->hasMany(Wishlist::class);
    }

    // helper method
    public function isWishlistedBy(?User $user): bool
    {
        if (!$user) return false;
        return $this->wishlistedBy()->where('user_id', $user->id)->exists();
    }

  
}
