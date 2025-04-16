<?php

namespace App\Services;

use App\DTOs\CartDTO;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Design;

class CartService
{
    public function getAll()
    {
        return Cart::with('items.design')->firstOrCreate(['user_id' => auth()->id()]);
    }

    public function addItemToCart(CartDTO $dto)
    {
        CartItem::where('cart_id', $dto->cart_id)->where('design_id', $dto->design_id)->exists() ?: $this->buildItem($dto);
    }

    private function buildItem(CartDTO $dto)
    {
        CartItem::create([
            'cart_id' => $dto->cart_id,
            'design_id' => $dto->design_id,
        ]);
    }

    public function removeItemFromCart(CartDTO $dto)
    {
        CartItem::where('cart_id', $dto->cart_id)->where('design_id', $dto->design_id)->delete();
    }

    public function emptyCart($cartId)
    {
        CartItem::where('cart_id', $cartId)->delete();
    }
}
