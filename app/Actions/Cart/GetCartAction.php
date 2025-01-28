<?php

namespace App\Actions\Cart;

use App\Http\Requests\Cart\GetCartRequest;
use App\Http\Resources\Cart\CartResource;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;

use App\Services\Cart\CartServiceInterface;

class GetCartAction
{
    protected AuthService $authService;
    protected CartServiceInterface $cartService;

    public function __construct(AuthService $authService, CartServiceInterface $cartService)
    {
        $this->authService = $authService;
        $this->cartService = $cartService;
    }

    public function handle(GetCartRequest $request): JsonResponse
    {
        $cartId = $request->query('cart-id');

        if (!$cartId) {
            $cart = $this->cartService->getCartForAuthenticatedUser();
        } else{
            $cart = $this->cartService->getCartForGuest($cartId);
        }

        $totalPrice = $this->cartService->calculateTotalPrice($cart);

        return response()->json([
            'success' => true,
            'data' => new CartResource($cart),
            'total_price' => $totalPrice,
            'message' => 'Products retrieved successfully',
        ], 200);
    }

}