<?php

namespace App\Repositories\Product;


use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductItem;

interface ProductRepositoryInterface
{
    public function getProductItemById($id): ProductItem;
    public function getProductItemName(ProductItem $item): string;
    public function getProductItemByCartItem(CartItem $cartItem): ProductItem;
}