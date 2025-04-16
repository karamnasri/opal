<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'status'];

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function getTotalPriceBeforeAttribute(): float
    {
        return $this->items->sum(
            fn($item) =>
            $item->design->original_price->inDollars()
        );
    }

    public function getTotalPriceAfterAttribute(): float
    {
        return $this->items->sum(
            fn($item) =>
            $item->design->final_price->inDollars()
        );
    }
}
