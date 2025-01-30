<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Design;
use Illuminate\Support\Facades\DB;

class CartService
{
    public function getAll()
    {
        return Cart::with('items.design')->firstOrCreate(['user_id' => auth()->id()]);
    }

    public function addItemToCart($cartId, $designId, $quantity)
    {
        $design = Design::findOrFail($designId);
        $unitPrice = $design->discountPrice();
        $cartItem = CartItem::where('cart_id', $cartId)->where('design_id', $designId)->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->price = number_format($cartItem->quantity * $unitPrice, 2);
            $cartItem->save();
        } else {
            $cartItem = CartItem::create([
                'cart_id' => $cartId,
                'design_id' => $designId,
                'quantity' => $quantity,
                'price' => number_format($quantity * $unitPrice, 2),
            ]);
        }

        return $cartItem;
    }

    public function removeItemFromCart($cartId, $designId)
    {
        CartItem::where('cart_id', $cartId)->where('design_id', $designId)->delete();
    }

    public function emptyCart($cartId)
    {
        CartItem::where('cart_id', $cartId)->delete();
    }
}
