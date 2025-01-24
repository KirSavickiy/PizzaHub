<?php

namespace App\Services\Cart;

use App\Exceptions\Cart\ProductNotFoundException;
use App\Exceptions\Cart\CartNotFoundException;
use App\Exceptions\Auth\UnauthorizedException;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductItem;
use App\Repositories\Cart\CartRepository;
use App\Services\Auth\AuthService;
use Illuminate\Support\Str;


class CartService implements CartServiceInterface
{
    protected Cart $cart;
    protected CartRepository $cartRepository;
    protected AuthService $authService;
    public function __construct(Cart $cart, AuthService $authService, CartRepository $cartRepository)
    {
        $this->authService = $authService;
        $this->cart = $cart;
        $this->cartRepository = $cartRepository;
    }

    public function createNewCart(): Cart
    {
        return $this->cart->create([
            'session_id' => (string) Str::uuid(),
            'user_id' => null,
        ]);
    }

    public function getCartForAuthenticatedUser(): Cart
    {
        $userId = $this->authService->getAuthenticatedUserId();
        if (!$userId) {
            throw new UnauthorizedException('User is not authenticated');
        }
        $cart = $this->cartRepository->getCartByUserId($userId);

        if (!$cart) {
            throw new CartNotFoundException('Cart not found for authenticated user');
        }

        return $cart;
    }

    public function getCartForGuest(string $sessionId): Cart
    {
        $cart = $this->cartRepository->getCartBySessionId($sessionId);

        if (!$cart) {
            throw new CartNotFoundException();
        }
        return $cart;
    }
    public function addProduct(int $productId, int $quantity = 1, ?string $cartId = null): CartItem
    {
        $product = ProductItem::find($productId);
        if (!$product) {
            throw new ProductNotFoundException($productId);
        }

        $cart = $this->authService->isAuthenticated()
            ? $this->getCartForAuthenticatedUser()
            : $this->getCartForGuest($cartId);

        $item = $cart->items()->where('product_item_id', $productId)->first();

        if (!$item) {
            $item = $cart->items()->create([
                'product_item_id' => $productId,
                'quantity' => $quantity,
                'price' => $product->price,
            ]);
        } else {
            $item->quantity += $quantity;
            $item->save();
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

}