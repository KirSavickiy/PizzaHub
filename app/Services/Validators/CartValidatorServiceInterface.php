<?php

namespace App\Services\Validators;

use App\Models\Cart;

interface CartValidatorServiceInterface
{
    public function validateStock(Cart $cart, int $id, int $quantity, string $action): void;
    public function validateCartLimits(Cart $cart, int $id, int $quantity, string $action): void;
}