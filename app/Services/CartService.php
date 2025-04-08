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
        $dto->design = Design::findOrFail($dto->design_id);
        CartItem::where('cart_id', $dto->cart->id)->where('design_id', $dto->design_id)->exists() ?: $this->buildItem($dto);
    }

    private function buildItem(CartDTO $dto)
    {
        CartItem::create([
            'cart_id' => $dto->cart->id,
            'design_id' => $dto->design_id,
            'price' => $dto->design->discountPrice(),
        ]);
    }

    public function removeItemFromCart(CartDTO $dto)
    {
        CartItem::where('cart_id', $dto->cart->id)->where('design_id', $dto->design_id)->delete();
    }

    public function emptyCart($cartId)
    {
        CartItem::where('cart_id', $cartId)->delete();
    }
}
