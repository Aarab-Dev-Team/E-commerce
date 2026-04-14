<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock_quantity',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the category that owns the product
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all images for the product
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Get the primary image for the product
     */
    public function primaryImage()
    {
        return $this->images()->where('is_primary', true)->first();
    }

    /**
     * Get the route key for the model
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Check if product is in stock
     */
    public function inStock(): bool
    {
        return $this->stock_quantity > 0;
    }

    /**
     * Check if product is low stock (less than 10)
     */
    public function isLowStock(): bool
    {
        return $this->stock_quantity < 10;
    }

    /**
     * Scope to get only active products
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get only in-stock products
     */
    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }
}