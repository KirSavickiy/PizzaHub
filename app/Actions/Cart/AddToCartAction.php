<?php

namespace App\Actions\Cart;

use App\Http\Requests\CartRequest;
use App\Http\Resources\Cart\ItemResource;
use App\Services\Cart\CartServiceInterface;
use Illuminate\Http\JsonResponse;

class AddToCartAction
{
    protected CartServiceInterface $cartService;

    public function __construct(CartServiceInterface $cartService)
    {
        $this->cartService = $cartService;
    }

    public function handle(CartRequest $request): JsonResponse
    {
        $cartId = $request->query('cart-id');
        $productId = $request->input('product-id');

        if (is_null($productId) || !is_numeric($productId)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product ID is required and must be a valid number.',
            ], 400);
        }

        $cart = $this->cartService->getCart($cartId);
        $itemsCount = $cart->items->count();
        if (!$cart) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart not found.',
            ], 404);
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

        $cartData = [
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