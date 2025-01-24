<?php

namespace App\Repositories\Product;


use App\Models\ProductItem;

interface ProductRepositoryInterface
{
    public function getProductItemBytId($id): ProductItem;

}