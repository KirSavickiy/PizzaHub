<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use App\Exceptions\Cart\CartNotFoundException;

class CartRepository implements CartRepositoryInterface
{
    protected Cart $cart;
    protected CartItem $cartItem;

    public function __construct(Cart $cart, CartItem $cartItem)
    {
        $this->cart = $cart;
        $this->cartItem = $cartItem;
    }

    /**
     * @throws CartNotFoundException
     */
    public function getCartByUserId(int $userId): Cart
    {
        $cart = $this->cart->where('user_id', $userId)->first();

        if (!$cart) {
            throw new CartNotFoundException('Cart not found for authenticated user');
        }

        return $cart;
    }

    /**
     * @throws CartNotFoundException
     */
    public function getCartBySessionId(string $sessionId): Cart
    {
        $cart = $this->cart->where('session_id', $sessionId)->first();

        if (!$cart) {
            throw new CartNotFoundException('Cart not found for session ID ' . $sessionId);
        }

        return $cart;
    }

    public function getCartByCartItemId(string $cartItemId): ?Cart
    {
        $cartItem = $this->cartItem->find($cartItemId);

        return $cartItem ? $this->cart->find($cartItem->cart_id) : null;
    }

    public function create(array $data): Cart
    {
        return $this->cart->create($data);
    }

    public function save(Cart $cart): void
    {
        $cart->save();
    }

    public function delete(Cart $cart): void
    {
        $cart->delete();
    }
}
