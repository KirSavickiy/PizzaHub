<?php

namespace App\Exceptions\Product;

use App\Exceptions\BaseException;

class ProductItemNotFoundException extends BaseException
{
    public function __construct(int $itemId = null, string $message = 'Product not found', int $code = 404)
    {
        if ($itemId) {
            $message = "Product Item with ID {$itemId} not found";
        }

        parent::__construct($message, $code);
    }
}
