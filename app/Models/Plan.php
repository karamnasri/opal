<?php

namespace App\Models;

use App\Casts\PriceCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'price',
        'stripe_product_id',
        'stripe_price_id',
        'designs_limit',
        'is_yearly',
    ];

    protected $casts = [
        'price' => PriceCast::class,
    ];
}
