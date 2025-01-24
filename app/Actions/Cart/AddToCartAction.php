<?php

namespace App\Actions\Cart;

use App\Http\Requests\Cart\AddToCartRequest;
use App\Http\Resources\Cart\ItemResource;
use App\Repositories\Cart\CartRepositoryInterface;
use App\Services\Auth\AuthService;
use App\Services\Cart\CartServiceInterface;
use Illuminate\Http\JsonResponse;

class AddToCartAction
{
    protected CartServiceInterface $cartService;

    protected AuthService $authCheckService;

    protected CartRepositoryInterface $cartRepository;

    public function __construct(CartServiceInterface $cartService, AuthService $authCheckService, CartRepositoryInterface $cartRepository)
    {
        $this->cartService = $cartService;
        $this->authCheckService = $authCheckService;
        $this->cartRepository = $cartRepository;
    }

    public function handle(AddToCartRequest $request): JsonResponse
    {
        $cartId = $request->query('cart-id');
        $productId = $request->input('product_id');

        try {
            $item = $this->cartService->addProduct((int) $productId, 1, $cartId);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 404);
        }

        $cart = $this->cartRepository->getCartByCartItemId($item->id);
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