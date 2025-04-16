<?php

namespace App\DTOs;

use App\Exceptions\EmptyCartException;
use App\Models\Cart;
use App\Models\User;
use App\Traits\DtoRequestTrait;
use Illuminate\Support\Facades\Auth;

class PointsDTO
{
    use DtoRequestTrait;
    public readonly User $user;
    public readonly ?Cart $cart;
    public readonly int $required_points;

    public function __construct()
    {
        $this->user = Auth::user();
        $this->cart = $this->user->cart;

        if (!$this->cart || $this->cart->items->count() === 0) {
            throw new EmptyCartException();
        }

        $this->required_points = $this->cart->items->count();
    }
}
