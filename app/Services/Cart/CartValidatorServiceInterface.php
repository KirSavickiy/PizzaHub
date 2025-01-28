<?php

namespace App\Services\Cart;

use App\Models\ProductItem;
use App\Models\Cart;
interface CartValidatorServiceInterface
{
    public function validateStock(ProductItem $productItem, int $quantity): void;

    public function validateCartLimits(Cart $cart): void;
}