<?php

namespace App\Exceptions\Cart;

use App\Exceptions\BaseException;

class ProductNotFoundInCartException extends BaseException
{
    public function __construct(int $productId = null, string $message = "Product not found in the Cart ", int $code = 404)
    {
        if ($productId) {
            $message = "Product with ID {$productId} not found in the Cart ";
        }
        parent::__construct($message, $code);
    }
}
