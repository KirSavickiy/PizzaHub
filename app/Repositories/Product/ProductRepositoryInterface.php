<?php

namespace App\Repositories\Product;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductItem;

interface ProductRepositoryInterface
{
    public function getProductById(string $id): Product;
    public function getProductItemById(string $id): ProductItem;
    public function getProductItemName(ProductItem $item): string;
    public function getProductItemByCartItem(CartItem $cartItem): ProductItem;
    public function getProductItemIdByCartItemId(Cart $cart, string $id): int;
}