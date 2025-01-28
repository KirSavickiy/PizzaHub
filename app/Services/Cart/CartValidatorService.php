<?php

namespace App\Services\Cart;

use App\Exceptions\Product\ProductOutOfLimitsException;
use App\Exceptions\Product\ProductOutOfStockException;
use App\Models\ProductItem;
use App\Models\Cart;

class CartValidatorService implements CartValidatorServiceInterface
{
    /**
     * @throws ProductOutOfStockException
     */
    public function validateStock(ProductItem $productItem, int $quantity): void
    {
        if ($quantity >= $productItem->stock)
        {
            throw new ProductOutOfStockException($productItem->product->name);
        }
    }

    /**
     * @throws ProductOutOfLimitsException
     */
    public function validateCartLimits(Cart $cart): void
    {
        $categories = [
            'Пиццы' => 10,
            'Напитки' => 20,
        ];
        foreach ($categories as $name => $quantity){
            $items = $cart->items()
                ->whereHas('productItem.product.category', function ($query) use ($name) {
                    $query->where('name', $name);
                })
                ->sum('quantity');

            if ($items >= $quantity){
                throw new ProductOutOfLimitsException($name, $quantity);
            }
        }
    }
}