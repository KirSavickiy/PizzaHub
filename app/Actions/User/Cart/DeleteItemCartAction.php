<?php

namespace App\Actions\User\Cart;

use App\Exceptions\Cart\CartNotFoundException;
use App\Http\Resources\Cart\CartResource;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class DeleteItemCartAction extends CartAction
{
    use AuthorizesRequests;
    /**
     * @throws CartNotFoundException
     * @throws AuthorizationException
     */
    public function handle(?string $cartId, string $id):JsonResponse
    {

        $cart = $this->getCart($cartId);

        if(!$cart) {
            throw new CartNotFoundException();
        }

        $item = $this->cartService->removeProduct($cart, $id);
        $this->authorize('delete', [$cart, $item]);

        return response()->json([
            'success' => true,
            'data' => new CartResource($cart),
            'total_price' => $this->cartService->calculateTotalPrice($cart),
            'message' => 'Product successfully removed from the cart.',
        ], 200);
    }
}