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
        return (float) number_format($this->items->sum(fn($item) => $item->design->price), 2);
    }
    public function getTotalPriceAfterAttribute()
    {
        return (float) number_format($this->items->sum(fn($item) => $item->price), 2);
    }
}
