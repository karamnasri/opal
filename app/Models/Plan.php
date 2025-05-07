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
        'points',
        'price',
        'interval',
    ];

    protected $casts = [
        'price' => PriceCast::class,
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
