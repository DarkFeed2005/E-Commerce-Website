<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'discount_price',
        'stock',
        'images',
        'rating',
        'rating_count',
        'is_active',
        'is_approved',
        'views',
        'sales',
        'category_id',
        'vendor_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'rating' => 'decimal:2',
        'images' => 'array',
        'is_active' => 'boolean',
        'is_approved' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Category::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'vendor_id');
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(\App\Models\CartItem::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(\App\Models\OrderItem::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(\App\Models\Review::class);
    }

    public function getFinalPrice(): float
    {
        return $this->discount_price ?? $this->price;
    }

    public function getDiscountPercentage(): ?float
    {
        if (!$this->discount_price) return null;
        
        return round((($this->price - $this->discount_price) / $this->price) * 100, 2);
    }

    public function getMainImage(): ?string
    {
        if (!$this->images || empty($this->images)) return null;
        
        return $this->images[0];
    }

    public function isInStock(): bool
    {
        return $this->stock > 0;
    }
}
