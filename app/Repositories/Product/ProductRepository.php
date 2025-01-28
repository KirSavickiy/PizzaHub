<?php

namespace App\Repositories\Product;

use App\Exceptions\Product\ProductNotFoundException;
use App\Models\ProductItem;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @throws ProductNotFoundException
     */
    public function getProductItemBytId($id): ProductItem
    {
        $productItem = ProductItem::where('id', $id)->first();
        if (!$productItem) {
            throw new ProductNotFoundException($id);
        }
        return $productItem;
    }

    public function getProductItemName(ProductItem $item): string
    {
        return $item->name;
    }

}