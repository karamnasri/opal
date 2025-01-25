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
        'billing_cycle',
        'designs_limit',
    ];

    protected $casts = [
        'price' => PriceCast::class,
    ];
}
