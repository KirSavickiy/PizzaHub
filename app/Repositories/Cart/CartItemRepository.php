<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\CartItem;

class CartItemRepository implements CartItemRepositoryInterface
{
    public function getCartItemByProductId(Cart $cart, int $productId): ?CartItem
    {
        return $cart->items()->where('product_item_id', $productId)->first();
    }

    public function addQuantity(CartItem $item, int $quantity): void
    {
        $item->quantity += $quantity;
    }

    public function create(array $data): CartItem
    {
        return CartItem::create($data);
    }
    public function save(CartItem $item): void
    {
        $item->save();
    }
}