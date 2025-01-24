<?php

namespace App\Exceptions\Cart;

use Exception;

class ProductNotFoundException extends Exception
{
    public function __construct(int $productId = null, string $message = 'Product not found')
    {
        if ($productId) {
            $message = "Product with ID {$productId} not found";
        }

        parent::__construct($message);
    }
}
