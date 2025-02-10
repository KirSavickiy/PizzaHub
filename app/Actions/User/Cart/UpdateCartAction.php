<?php

namespace App\Actions\User\Cart;

use App\Exceptions\Cart\CartNotFoundException;
use App\Exceptions\Cart\ProductNotFoundInCartException;
use App\Http\Requests\User\Cart\UpdateCartItemRequest;
use App\Http\Resources\Cart\CartResource;
use App\Models\CartItem;
use Illuminate\Http\JsonResponse;

class UpdateCartAction extends CartAction
{
    /**
     * @throws CartNotFoundException
     * @throws ProductNotFoundInCartException
     */
    public function handle(array $data, ?string $cartId, string $id): JsonResponse
    {
        $quantity = $data['quantity'];
        $cart = $this->getCart($cartId);

        if(!$cart) {
            throw new CartNotFoundException();
        }

        $productId = $this->productRepository->getProductItemIdByCartItemId($cart, $id);

        $this->cartValidatorService->validateStock($cart, $productId, $quantity, 'update');
        $this->cartValidatorService->validateCartLimits($cart, $productId, $quantity, 'update');


        if(!$this->cartService->updatedQuantity($cart, $id, $quantity)){
            throw new ProductNotFoundInCartException();
        }

        $cart->load('items');

        return response()->json([
            'success' => true,
            'data' => new CartResource($cart),
            'total_price' => $this->cartService->calculateTotalPrice($cart),
            'message' => 'Product successfully updated in the cart.',
        ], 200);
    }


}