<?php

namespace App\Services\Cart;

use App\Exceptions\Auth\AuthenticationException;
use App\Exceptions\Cart\CartNotFoundException;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductItem;
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
    protected CartValidatorServiceInterface $cartValidator;
    protected AuthService $authService;
    public function __construct(
        AuthService $authService,
        CartRepositoryInterface $cartRepository,
        ProductRepositoryInterface $productRepository,
        CartItemRepositoryInterface $cartItemRepository,
        CartValidatorServiceInterface $cartValidator
    ) {
        $this->authService = $authService;
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
        $this->cartItemRepository = $cartItemRepository;
        $this->cartValidator = $cartValidator;
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
        $product = $this->productRepository->getProductItemBytId($productId);

        $item = $this->cartItemRepository->getCartItemByProductId($cart, $productId);

        $data = [
            'product_item_id' => $productId,
            'cart_id' => $cart->id,
            'quantity' => $quantity,
            'price' => $product->price,
        ];

        $this->cartValidator->validateStock($product, $this->cartItemRepository->getQuantity($item));
        $this->cartValidator->validateCartLimits($cart);

        if (!$item) {
            $item = $this->cartItemRepository->create($data);
        } else {
            $this->cartItemRepository->addQuantity($item, $quantity);
            $this->cartItemRepository->save($item);
        }

        return $item;
    }
    public function removeProduct(int $productId, ?string $cartId = null): void
    {
        $product = ProductItem::find($productId);
        if (!$product) {
            throw new \Exception('Product not found');
        }
        $cart = $this->getCart($cartId);
        $item = $cart->items()->where('product_item_id', $productId)->first();
        if ($item) {
            $item->delete();
        }else{
            throw new \Exception('Product not found');
        }
    }

    public function updatedQuantity(int $productId, int $quantity): void
    {
        $cart = $this->getCart();
        $item = $cart->items()->where('product_item_id', $productId)->first();

        if (!$item) {
            throw new \Exception('Product not found in cart');
        }

        if ($quantity === 0) {
            $item->delete();
            return;
        }

        $item->quantity = $quantity;
        $item->save();
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

    public function resolveCart(?string $cartId): Cart
    {
        if ($this->authService->isAuthenticated()) {
            return $this->getCartForAuthenticatedUser();
        }

        if (!$cartId) {
            throw new CartNotFoundException('Cart ID is required for guest users.');
        }

        return $this->getCartForGuest($cartId);
    }

}