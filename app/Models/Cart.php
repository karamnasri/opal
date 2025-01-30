<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function getTotalPriceBeforeAttribute()
    {
        return $this->items->sum(fn($item) => $item->design->price * $item->quantity);
    }
    public function getTotalPriceAfterAttribute()
    {
        return $this->items->sum(fn($item) => $item->price);
    }
}
