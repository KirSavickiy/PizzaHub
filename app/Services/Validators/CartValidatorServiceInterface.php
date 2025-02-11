<?php

namespace App\Services\Validators;

use App\Exceptions\Product\ProductOutOfLimitsException;
use App\Exceptions\Product\ProductOutOfStockException;
use App\Models\Cart;

interface CartValidatorServiceInterface
{
    /**
     * Validates if the requested quantity of a product is available in stock.
     *
     * @param Cart $cart The user's cart.
     * @param int $id The ID of the product item.
     * @param int $quantity The requested quantity.
     * @param string $action The action being performed ("add" or "update").
     *
     * @throws ProductOutOfStockException If the requested quantity exceeds available stock.
     */
    public function validateStock(Cart $cart, int $id, int $quantity, string $action): void;

    /**
     * Validates if adding or updating the product in the cart complies with category limits.
     *
     * @param Cart $cart The user's cart.
     * @param int $id The ID of the product item.
     * @param int $quantity The requested quantity.
     * @param string $action The action being performed ("add" or "update").
     *
     * @throws ProductOutOfLimitsException If the requested quantity exceeds the category limit.
     */
    public function validateCartLimits(Cart $cart, int $id, int $quantity, string $action): void;
}