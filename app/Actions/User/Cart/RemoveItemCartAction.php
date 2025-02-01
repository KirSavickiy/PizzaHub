<?php

namespace App\Actions\User\Cart;

use App\Exceptions\Cart\CartNotFoundException;
use App\Exceptions\Cart\ProductNotFoundInCartException;
use App\Http\Requests\User\Cart\RemoveItemCartRequest;
use App\Http\Resources\Cart\CartResource;
use Illuminate\Http\JsonResponse;

class RemoveItemCartAction extends CartAction
{
    /**
     * @throws ProductNotFoundInCartException
     * @throws CartNotFoundException
     */
    public function handle(RemoveItemCartRequest $request):JsonResponse
    {
        $id = $request->route('id');
        $cartId = $request->query('cart-id') ?? null;
        $cart = $this->getCart($cartId);

        if(!$cart) {
            throw new CartNotFoundException();
        }

        if(!$this->cartService->removeProduct($cart, $id)){
            throw new ProductNotFoundInCartException();
        }

        return response()->json([
            'success' => true,
            'data' => new CartResource($cart),
            'total_price' => $this->cartService->calculateTotalPrice($cart),
            'message' => 'Product successfully removed from the cart.',
        ], 200);
    }
}