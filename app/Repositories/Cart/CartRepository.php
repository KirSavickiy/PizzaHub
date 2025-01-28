<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use App\Exceptions\Cart\CartNotFoundException;

class CartRepository implements CartRepositoryInterface
{
    public function getCartByUserId(int $userId): Cart
    {
        $cart = Cart::where('user_id', $userId)->first();

        if (!$cart) {
            throw new CartNotFoundException('Cart not found for authenticated user');
        }

        return $cart;
    }

    public function getCartBySessionId(string $sessionId): Cart
    {
        $cart = Cart::where('session_id', $sessionId)->first();

        if (!$cart) {
            throw new CartNotFoundException('Cart not found for session ID ' . $sessionId);
        }

        return $cart;
    }

    public function getCartByCartItemId(string $cartItemId): ?Cart
    {
        $cartItem = CartItem::where('id', $cartItemId)->first();

        if (!$cartItem) {
            return null;
        }

        return Cart::where('id', $cartItem->cart_id)->first();
    }

    public function create(array $data): Cart
    {
        return Cart::create($data);
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