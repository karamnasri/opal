<?php

namespace App\DTOs;

use App\Models\Cart;
use App\Models\Design;
use App\Traits\DtoRequestTrait;

class CartDTO
{
    use DtoRequestTrait;
    public int $design_id;
    public Cart $cart;
    public Design $design;
}
