<?php

namespace App\Exceptions\Product;

use App\Exceptions\BaseException;

class ProductOutOfStockException extends BaseException
{
    public function __construct(string $productName)
    {
        $message = "Товара: $productName недостаточно на складе.";
        parent::__construct($message, 409);
    }

}
