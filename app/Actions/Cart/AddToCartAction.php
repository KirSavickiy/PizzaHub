<?php

namespace App\Actions\Cart;

use App\Http\Requests\Cart\AddToCartRequest;
use App\Http\Resources\Cart\ItemResource;
use App\Services\Auth\AuthCheckService;
use App\Services\Cart\CartServiceInterface;
use Illuminate\Http\JsonResponse;

class AddToCartAction
{
    protected CartServiceInterface $cartService;

    protected AuthCheckService $authCheckService;

    public function __construct(CartServiceInterface $cartService, AuthCheckService $authCheckService)
    {
        $this->cartService = $cartService;
        $this->authCheckService = $authCheckService;
    }

    public function handle(AddToCartRequest $request): JsonResponse
    {
        $cartId = $request->query('cart-id');
        $productId = $request->input('product_id');

        $request->validated();

        $cart = $this->cartService->getCart($cartId);

        if (!$cart) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart not found.',
            ], 404);
        }

        if (!$cartId) {
            $cartId = $cart->id;
        } else {
            $cartId = $cart->session_id ?? null;
        }
        try {
            $item = $this->cartService->addProduct((int) $productId, 1, $cartId);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 404);
        }

        $totalPrice = $this->cartService->calculateTotalPrice($cart);
        $itemsCount = $cart->items->sum('quantity');
        $cartData = [
            'cart_id' => $cartId,
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