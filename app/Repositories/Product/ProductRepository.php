<?php

namespace App\Repositories\Product;

use App\Models\ProductItem;

class ProductRepository implements ProductRepositoryInterface
{
    public function getProductItemBytId($id): ProductItem
    {
        return ProductItem::where('id', $id)->first();
    }
}