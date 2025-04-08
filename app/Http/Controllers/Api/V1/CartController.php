<?php

namespace App\Http\Controllers\Api\V1;

use App\DTOs\CartDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\RemoveFromCartRequest;
use App\Http\Resources\CartResource;
use App\Services\CartService;
use App\Traits\ApiResponseTrait;

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
        $dto = CartDTO::fromRequest($request);
        $dto->cart = $this->cartService->getAll($dto);
        $this->cartService->addItemToCart($dto);

        return $this->successResponse([], 'Item added to cart successfully.');
    }

    /**
     * Remove an item from the cart.
     */
    public function remove(RemoveFromCartRequest $request)
    {
        $dto = CartDTO::fromRequest($request);
        $dto->cart = $this->cartService->getAll();
        $this->cartService->removeItemFromCart($dto);

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
