<?php

namespace App\Actions\User\Cart;

use App\Http\Requests\User\Cart\CreateCartRequest;
use App\Http\Resources\Cart\CartResource;
use Illuminate\Http\JsonResponse;

class CreateCartAction extends CartAction
{
    public function handle(CreateCartRequest $request): JsonResponse
    {
        $cart = $this->getCart();
        if ($cart){
           return response()->json([
               'success' => true,
               'data' => new CartResource($cart),
               'total_price' => $this->cartService->calculateTotalPrice($cart),
               'message' => 'Cart already exists.',
           ], 200);
        }

        $newCart = $this->cartService->createNewGuestCart();

        return response()->json([
            'success' => true,
            'data' => new CartResource($newCart),
            'total_price' => 0.0,
            'message' => 'New cart created.',
        ], 201);

    }
}