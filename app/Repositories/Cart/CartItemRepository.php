<?php

namespace App\Repositories\Cart;

use App\Exceptions\Cart\ProductNotFoundInCartException;
use App\Models\CartItem;
use App\Services\Validators\IdValidatorService;
use Illuminate\Validation\ValidationException;

class CartItemRepository implements CartItemRepositoryInterface
{
    protected CartItem $cartItem;

    public function __construct(CartItem $cartItem)
    {
        $this->cartItem = $cartItem;
    }

    public function getCartItemByProductId($cart, int $productId): ?CartItem
    {
        return $cart->items()->where('product_item_id', $productId)->first();
    }

    /**
     * @throws ValidationException
     * @throws ProductNotFoundInCartException
     */
    public function getCartItemById($cart, string $id): CartItem
    {
        $id = IdValidatorService::validateId($id, 'cart_items');
        $item = $cart->items()->find($id);

        if (!$item) {
            throw new ProductNotFoundInCartException($id);
        }

        /** @var CartItem $item */
        return $item;
    }

    public function getQuantity(?CartItem $item): int
    {
        return $item->quantity ?? 0;
    }

    public function addQuantity(CartItem $item, int $quantity): void
    {
        $item->increment('quantity', $quantity);
    }

    public function create(array $data): CartItem
    {
        return $this->cartItem->create($data);
    }

    public function save(CartItem $item): void
    {
        $item->save();
    }
}
