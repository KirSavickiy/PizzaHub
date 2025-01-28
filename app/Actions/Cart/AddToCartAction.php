<?php

namespace App\Actions\Cart;

use App\Http\Requests\Cart\AddToCartRequest;
use App\Http\Resources\Cart\ItemResource;
use App\Repositories\Cart\CartRepositoryInterface;
use App\Services\Auth\AuthService;
use App\Services\Cart\CartServiceInterface;
use Illuminate\Http\JsonResponse;

class AddToCartAction extends CartAction
{
    public function handle(AddToCartRequest $request): JsonResponse
    {
        $cartId = $request->query('cart-id');
        $productId = $request->input('product_id');

        $cart = $this->getCart($cartId);
        $item = $this->cartService->addProduct($cart, $productId);

        $cart = $this->cartRepository->getCartByCartItemId($item->id);
        $totalPrice = $this->cartService->calculateTotalPrice($cart);
        $itemsCount = $cart->items->sum('quantity');

        $cartData = [
            'id' => $cart->id,
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