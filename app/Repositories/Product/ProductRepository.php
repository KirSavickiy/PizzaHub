<?php

namespace App\Repositories\Product;

use App\Exceptions\Product\ProductNotFoundException;
use App\Models\CartItem;
use App\Models\ProductItem;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @throws ProductNotFoundException
     */
    public function getProductItemById($id): ProductItem
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

    /**
     * @throws ProductNotFoundException
     */
    public function getProductItemByCartItem(CartItem $cartItem): ProductItem
    {
       $productItemId = $cartItem->product_item_id;
       $productItem = $this->getProductItemById($productItemId);
       if (!$productItem) {
           throw new ProductNotFoundException($productItemId);
       }
       return $productItem;
    }

}