<?php

namespace App\Exceptions\Product;

use App\Exceptions\BaseException;

class ProductNotFoundException extends BaseException
{
    public function __construct(int $productId = null, string $message = 'Product not found', int $code = 404)
    {
        if ($productId) {
            $message = "Product with ID {$productId} not found";
        }

        parent::__construct($message, $code);
    }
}
