<?php

namespace App\Repositories\Product;


use App\Models\Product;
use App\Models\ProductItem;

interface ProductRepositoryInterface
{
    public function getProductItemBytId($id): ProductItem;
    public function getProductItemName(ProductItem $item): string;
}