<?php

namespace App\Actions\Cart;

use App\Http\Resources\Cart\CartResource;
use App\Services\Auth\AuthCheckService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Services\Cart\CartServiceInterface;

class GetCartAction
{
    protected AuthCheckService $authCheckService;
    protected CartServiceInterface $cartService;

    public function __construct(AuthCheckService $authCheckService, CartServiceInterface $cartService)
    {
        $this->authCheckService = $authCheckService;
        $this->cartService = $cartService;
    }

    public function handle(Request $request): JsonResponse
    {
        $cartId = $request->query('cart-id');
        $cart = $this->cartService->getCart($cartId);
        $totalPrice = $this->cartService->calculateTotalPrice($cart);

        return response()->json([
            'success' => true,
            'data' => new CartResource($cart),
            'total_price' => $totalPrice,
            'message' => 'Products retrieved successfully',
        ], 200);
    }

}