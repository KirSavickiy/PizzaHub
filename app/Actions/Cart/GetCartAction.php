<?php

namespace App\Actions\Cart;

use App\Http\Requests\Cart\GetCartRequest;
use App\Http\Resources\Cart\CartResource;
use Illuminate\Http\JsonResponse;

class GetCartAction extends CartAction
{
    public function handle(GetCartRequest $request): JsonResponse
    {
        $cartId = $request->query('cart-id');

        $cart = $this->getCart($cartId);

        $totalPrice = $this->cartService->calculateTotalPrice($cart);

        return response()->json([
            'success' => true,
            'data' => new CartResource($cart),
            'total_price' => $totalPrice,
            'message' => 'Products retrieved successfully',
        ], 200);
    }

}