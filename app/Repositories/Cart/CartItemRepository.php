<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\CartItem;

class CartItemRepository implements CartItemRepositoryInterface
{
    public function getCartItemByProductId(Cart $cart, int $productId): ?CartItem
    {
        $cartItem = $cart->items()->where('product_item_id', $productId)->first();
        if (!$cartItem) {
            return null;
        }else{
            return $cartItem;
        }
    }

    public function getCartItemById(int $id): ?CartItem
    {
        return CartItem::where('id', $id)->first();
    }


    public function getQuantity(?CartItem $item): int
    {
        return $item->quantity ?? 0;
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