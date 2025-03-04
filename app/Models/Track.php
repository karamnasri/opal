<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    use HasFactory;

    protected $fillable = [
        'action',
        'ip_address',
        'details',
    ];

    protected $casts = [
        'ip_address' => 'encrypted'
    ];
}
