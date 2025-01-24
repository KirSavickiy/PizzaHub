<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\CartItem;

interface CartRepositoryInterface
{
    public function getCartByUserId(int $userId): ?Cart;
    public function getCartBySessionId(string $sessionId): ?Cart;
    public function getCartByCartItemId(string $cartItemId): ?Cart;
    public function create(array $data): Cart;
    public function save(Cart $cart): void;
    public function delete(Cart $cart): void;

}