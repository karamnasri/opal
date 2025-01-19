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
        $unitPrice = $design->discounted_price ?? $design->price ?? 0;
        $cartItem = CartItem::where('cart_id', $cartId)->where('design_id', $designId)->first();

        if ($cartItem) {
            // Update the existing cart item
            $cartItem->quantity += $quantity;
            $cartItem->price = $cartItem->quantity * $unitPrice; // Update total price
            $cartItem->save();
        } else {
            $cartItem = CartItem::create([
                'cart_id' => $cartId,
                'design_id' => $designId,
                'quantity' => $quantity,
                'price' => $unitPrice,
            ]);
        }

        $this->updateCartTotal($cartId);

        return $cartItem;
    }

    public function updateCartTotal($cartId)
    {
        $cart = Cart::with('items')->findOrFail($cartId);
        $total = $cart->items->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        $cart->update(['total_price' => $total]);
    }

    public function removeItemFromCart($cartId, $designId)
    {
        CartItem::where('cart_id', $cartId)->where('design_id', $designId)->delete();
        $this->updateCartTotal($cartId);
    }

    public function emptyCart($cartId)
    {
        CartItem::where('cart_id', $cartId)->delete();
        Cart::where('id', $cartId)->update(['total_price' => 0]);
    }
}
