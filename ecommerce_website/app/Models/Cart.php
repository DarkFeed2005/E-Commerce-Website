<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(\App\Models\CartItem::class);
    }

    public function calculateTotal(): void
    {
        $this->total = $this->cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        $this->save();
    }
}
