<?php

namespace App\Models;

use App\Casts\PriceCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['cart_id', 'design_id'];

    protected $casts = [];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function design()
    {
        return $this->belongsTo(Design::class);
    }
}
