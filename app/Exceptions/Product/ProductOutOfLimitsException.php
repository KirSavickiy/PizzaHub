<?php

namespace App\Exceptions\Product;

use App\Exceptions\BaseException;
class ProductOutOfLimitsException extends BaseException
{
    public function __construct(string $productName, int $quantity)
    {
        $message = "Товар категории ($productName) превышает лимит $quantity";
        parent::__construct($message, 409);
    }
}
