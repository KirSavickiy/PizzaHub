<?php

namespace App\Actions\Cart;

use App\Http\Requests\Cart\CreateCartRequest;
use App\Http\Resources\Cart\CartResource;
use App\Services\Auth\AuthService;
use App\Services\Cart\CartServiceInterface;

class CreateCartAction
{
    protected CartServiceInterface $cartService;

    protected AuthService $authService;

    public function __construct(CartServiceInterface $cartService, AuthService $authService)
    {
        $this->cartService = $cartService;
        $this->authService = $authService;
    }

    public function handle(CreateCartRequest $request)
    {
        if ($this->authService->isAuthenticated()){
            $existingCart = $this->cartService->getCartForAuthenticatedUser();
            return response()->json([
                'success' => true,
                'data' => new CartResource($existingCart),
                'total_price' => $this->cartService->calculateTotalPrice($existingCart),
                'message' => 'Cart already exists.',
            ], 200);
        }

        $newCart = $this->cartService->createNewCart();

        return response()->json([
            'success' => true,
            'data' => new CartResource($newCart),
            'total_price' => 0.0,
            'message' => 'New cart created.',
        ], 201);

    }
}