<?php

namespace App\Actions\Cart;

use App\Http\Requests\Cart\AddToCartRequest;
use App\Http\Resources\Cart\ItemResource;
use Illuminate\Http\JsonResponse;

class AddToCartAction extends CartAction
{
    public function handle(AddToCartRequest $request): JsonResponse
    {
        $cartId = $request->query('cart-id');
        $productId = $request->input('product_id');

        $cart = $this->getCart($cartId);

        if (!$cart) {
            $cart = $this->cartService->createNewGuestCart();
        }

        $this->cartValidatorService->validateStock($cart, $productId, 1, 'add');
        $this->cartValidatorService->validateCartLimits($cart, $productId, 1, 'add');

        $item = $this->cartService->addProduct($cart, $productId);

        $totalPrice = $this->cartService->calculateTotalPrice($cart);
        $itemsCount = $cart->items->sum('quantity');

        $cartData = [
            'id' => $cart->id,
            'session_id' => $cart->session_id,
            'items_count' => $itemsCount,
            'total_price' => $totalPrice,
            'item' => new ItemResource($item),
        ];

        return response()->json([
            'status' => 'success',
            'message' => 'The product has been successfully added to your cart.',
            'cart' => $cartData,
        ], 200);
    }

}