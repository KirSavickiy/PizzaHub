<?php

namespace App\Actions\User\Cart;

use App\Exceptions\Cart\CartNotFoundException;
use App\Exceptions\Cart\ProductNotFoundInCartException;
use App\Http\Requests\User\Cart\RemoveItemCartRequest;
use App\Http\Resources\Cart\CartResource;
use Illuminate\Http\JsonResponse;

class DeleteItemCartAction extends CartAction
{
    /**
     * @throws CartNotFoundException
     */
    public function handle(?string $cartId, string $id):JsonResponse
    {

        $cart = $this->getCart($cartId);

        if(!$cart) {
            throw new CartNotFoundException();
        }

        $this->cartService->removeProduct($cart, $id);

        return response()->json([
            'success' => true,
            'data' => new CartResource($cart),
            'total_price' => $this->cartService->calculateTotalPrice($cart),
            'message' => 'Product successfully removed from the cart.',
        ], 200);
    }
}