<?php

namespace App\Services\Cart;

use App\Exceptions\Auth\AuthenticationException;
use App\Models\Cart;
use App\Models\CartItem;
use App\Repositories\Cart\CartItemRepositoryInterface;
use App\Repositories\Cart\CartRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Services\Auth\AuthService;
use Illuminate\Support\Str;


class CartService implements CartServiceInterface
{
    protected CartRepositoryInterface $cartRepository;
    protected  CartItemRepositoryInterface $cartItemRepository;
    protected ProductRepositoryInterface $productRepository;
    protected AuthService $authService;
    public function __construct(
        AuthService $authService,
        CartRepositoryInterface $cartRepository,
        ProductRepositoryInterface $productRepository,
        CartItemRepositoryInterface $cartItemRepository,
    ) {
        $this->authService = $authService;
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
        $this->cartItemRepository = $cartItemRepository;
    }
    public function createNewGuestCart(): Cart
    {
        return $this->cartRepository->create([
            'session_id' => (string) Str::uuid(),
        ]);
    }


    /**
     * @throws AuthenticationException
     */
    public function getCartForAuthenticatedUser(): Cart
    {
        $userId = $this->authService->getAuthenticatedUserId();

        return $this->cartRepository->getCartByUserId($userId);

    }

    public function getCartForGuest(string $sessionId): Cart
    {
        return $this->cartRepository->getCartBySessionId($sessionId);

    }

    public function addProduct(Cart $cart, int $productId, int $quantity = 1): CartItem
    {
        $product = $this->productRepository->getProductItemById($productId);

        $item = $this->cartItemRepository->getCartItemByProductId($cart, $productId);

        $data = [
            'product_item_id' => $productId,
            'cart_id' => $cart->id,
            'quantity' => $quantity,
            'price' => $product->price,
        ];

        if (!$item) {
            $item = $this->cartItemRepository->create($data);
        } else {
            $this->cartItemRepository->addQuantity($item, $quantity);
            $this->cartItemRepository->save($item);
        }

        return $item;
    }
    public function removeProduct(Cart $cart, int $item_id): ?CartItem
    {
        $item = $this->cartItemRepository->getCartItemById($item_id);

        $item?->delete();

        return $item;
    }

    public function updatedQuantity(Cart $cart, int $item_id, int $quantity): ?CartItem
    {
        $item = $this->cartItemRepository->getCartItemById($item_id);

        if ($item === null) {
            return null;
        }

        if ($quantity === 0) {
            $item->delete();
            return $item;
        }

        $item->quantity = $quantity;
        $item->save();
        return $item;
    }

    public function calculateTotalPrice(Cart $cart): float
    {
        $items = $cart->items;

        return round($items->sum(function ($item) {
            $price = max(0, (float) $item->price);
            $quantity = max(0, (int) $item->quantity);
            return $price * $quantity;
        }), 2);
    }

}