<?php

namespace App\DTOs;

use App\Exceptions\AllItemsAlreadyOwnedException;
use App\Exceptions\EmptyCartException;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PointsDTO
{
    public readonly User $user;
    public readonly Cart $cart;
    public readonly array $unpurchasedItems;
    public readonly int $requiredPoints;

    public function __construct()
    {
        $this->user = Auth::user();
        $this->cart = $this->user->cart;

        if (!$this->cart || $this->cart->items->isEmpty()) {
            throw new EmptyCartException("Your cart is empty.");
        }

        $this->unpurchasedItems = $this->cart->unpurchasedItemsFor($this->user);

        if (empty($this->unpurchasedItems)) {
            throw new AllItemsAlreadyOwnedException();
        }

        $this->requiredPoints = count($this->unpurchasedItems);
    }
}
