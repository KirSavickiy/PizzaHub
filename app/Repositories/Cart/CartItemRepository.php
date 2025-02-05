<?php

namespace App\Repositories\Cart;

use App\Exceptions\Cart\ProductNotFoundInCartException;
use App\Models\Cart;
use App\Models\CartItem;
use App\Services\Validators\IdValidatorService;
use Illuminate\Validation\ValidationException;

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

    /**
     * @throws ValidationException
     * @throws ProductNotFoundInCartException
     */
    public function getCartItemById(Cart $cart, string $id): CartItem
    {
        $id = IdValidatorService::validateId($id, 'cart_items');

        $item = CartItem::query()->find($id);

        if (!$item || !$cart->items->contains('id', $item->id)) {
            throw new ProductNotFoundInCartException($id);
        }

        return $item;
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