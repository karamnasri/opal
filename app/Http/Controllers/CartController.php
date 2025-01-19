<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\RemoveFromCartRequest;
use App\Http\Resources\CartResource;
use App\Models\Design;
use App\Services\CartService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use ApiResponseTrait;
    public function __construct(private CartService $cartService) {}

    /**
     * Get the current cart.
     */
    public function index()
    {
        $data = $this->cartService->getAll();

        return $this->successResponse(new CartResource($data), 'Cart retrieved successfully.');
    }

    /**
     * Add an item to the cart.
     */
    public function add(AddToCartRequest $request)
    {
        $cart = $this->cartService->getAll();

        $cartItem = $this->cartService->addItemToCart(
            $cart->id,
            $request->design_id,
            $request->quantity
        );

        return $this->successResponse([], 'Item added to cart successfully.');
    }

    /**
     * Remove an item from the cart.
     */
    public function remove(RemoveFromCartRequest $request)
    {
        $cart = $this->cartService->getAll();
        $this->cartService->removeItemFromCart($cart->id, $request->design_id);

        return $this->successResponse([], 'Item removed from cart successfully.');
    }

    /**
     * Empty the cart.
     */
    public function empty()
    {
        $cart = $this->cartService->getAll();
        $this->cartService->emptyCart($cart->id);

        return $this->successResponse([], 'Cart emptied successfully.');
    }
}
