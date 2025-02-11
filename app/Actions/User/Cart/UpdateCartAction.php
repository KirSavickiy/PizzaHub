<?php

namespace App\Actions\User\Cart;

use App\Exceptions\Cart\CartNotFoundException;
use App\Exceptions\Cart\ProductNotFoundInCartException;
use App\Exceptions\Product\ProductOutOfLimitsException;
use App\Exceptions\Product\ProductOutOfStockException;
use App\Http\Resources\Cart\CartResource;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class UpdateCartAction extends CartAction
{
    use AuthorizesRequests;

    /**
     * @throws CartNotFoundException
     * @throws ProductOutOfStockException
     * @throws ProductOutOfLimitsException
     * @throws ProductNotFoundInCartException
     * @throws AuthorizationException
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

        $item = $this->cartService->updateQuantity($cart, $id, $quantity)
            ?? throw new ProductNotFoundInCartException();

        $this->authorize('delete', [$cart, $item]);
        $cart->load('items');

        return response()->json([
            'success' => true,
            'data' => new CartResource($cart),
            'total_price' => $this->cartService->calculateTotalPrice($cart),
            'message' => 'Product successfully updated in the cart.',
        ], 200);
    }
}
