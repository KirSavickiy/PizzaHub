<?php

namespace App\Actions\Cart;

use App\Http\Requests\Cart\CreateCartRequest;
use App\Http\Resources\Cart\CartResource;
use App\Services\Cart\CartServiceInterface;

class CreateCartAction
{
    protected CartServiceInterface $cartService;

    public function __construct(CartServiceInterface $cartService)
    {
        $this->cartService = $cartService;
    }

    public function handle(CreateCartRequest $request)
    {
        $existingCart = $this->cartService->getCart();

        if ($existingCart) {
            return response()->json([
                'success' => true,
                'data' => new CartResource($existingCart),
                'total_price' => $this->cartService->calculateTotalPrice($existingCart),
                'message' => 'Cart already exists.',
            ], 200);
        }

        $newCart = $this->cartService->createCart();

        return response()->json([
            'success' => true,
            'data' => new CartResource($newCart),
            'total_price' => 0.0,
            'message' => 'New cart created.',
        ], 201);

    }
}