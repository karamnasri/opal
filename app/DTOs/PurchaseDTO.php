<?php

namespace App\DTOs;

use App\Models\Purchase;
use App\Models\User;
use App\Traits\DtoRequestTrait;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class PurchaseDTO
{
    use DtoRequestTrait;
    public readonly User $user;
    public Collection $purchases;

    public function __construct()
    {
        $this->user = Auth::user();
        $this->purchases = collect();
    }
}
