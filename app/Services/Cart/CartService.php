<?php

namespace App\Services\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use App\Repositories\Cart\CartItemRepositoryInterface;
use App\Repositories\Cart\CartRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Support\Str;


class CartService implements CartServiceInterface
{
    protected CartRepositoryInterface $cartRepository;
    protected  CartItemRepositoryInterface $cartItemRepository;
    protected ProductRepositoryInterface $productRepository;
    public function __construct(
        CartRepositoryInterface $cartRepository,
        ProductRepositoryInterface $productRepository,
        CartItemRepositoryInterface $cartItemRepository,
    ) {
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

    public function getCartForAuthenticatedUser(): Cart
    {
        return $this->cartRepository->getCartByUserId(auth()->id());

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

    public function removeProduct(Cart $cart, string $id): CartItem
    {
        $item = $this->cartItemRepository->getCartItemById($cart, $id);

        $item->delete();

        return $item;
    }

    public function updateQuantity(Cart $cart, string $id, int $quantity): CartItem
    {
        $item = $this->cartItemRepository->getCartItemById($cart, $id);

        if ($quantity === 0) {
            return $this->removeProduct($cart, $id);
        }

        $item->quantity = $quantity;
        $this->cartItemRepository->save($item);

        return $item;
    }

    public function calculateTotalPrice(Cart $cart): float
    {
        return round($cart->items->sum(fn($item) => $item->price * $item->quantity), 2);
    }
}