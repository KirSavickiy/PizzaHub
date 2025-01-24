<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\CartItem;

interface CartItemRepositoryInterface
{
    public function getCartItemByProductId(Cart $cart, int $productId): ?CartItem;
    public function create(array $data): CartItem;
    public function addQuantity(CartItem $item, int $quantity): void;
    public function save(CartItem $item): void;
}