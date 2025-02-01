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
    public function handle(UpdateCartItemRequest $request): JsonResponse
    {
        $id = $request->route('id');
        $cartId = $request->query('cart-id') ?? null;
        $quantity = $request->input('quantity');
        $cart = $this->getCart($cartId);


        $cartItem = CartItem::where('id', $id)->first();

        if (!$cartItem) {
            throw new ProductNotFoundInCartException();
        }

        $productId = $cartItem->product_item_id;

        if (!$productId) {
            throw new ProductNotFoundInCartException();
        }

        if(!$cart) {
            throw new CartNotFoundException();
        }

        $this->cartValidatorService->validateStock($cart, $productId, $quantity, 'update');
        $this->cartValidatorService->validateCartLimits($cart, $productId, $quantity, 'update');


        if(!$this->cartService->updatedQuantity($cart, $id, $quantity)){
            throw new ProductNotFoundInCartException();
        }

        return response()->json([
            'success' => true,
            'data' => new CartResource($cart),
            'total_price' => $this->cartService->calculateTotalPrice($cart),
            'message' => 'Product successfully updated in the cart.',
        ], 200);
    }


}