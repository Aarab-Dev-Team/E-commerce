<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category ; 
use Illuminate\Database\Eloquent\Factories\HasFactory; 

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
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'images' => 'array',       
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function category() { return $this->belongsTo(Category::class); }
    public function reviews() { return $this->hasMany(Review::class); }
    public function cartItems() { return $this->hasMany(CartItem::class); }

}
