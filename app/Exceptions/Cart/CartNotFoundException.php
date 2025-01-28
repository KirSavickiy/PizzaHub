<?php

namespace App\Exceptions\Cart;

use App\Exceptions\BaseException;
use RuntimeException;

class CartNotFoundException extends BaseException
{
    public function __construct(string $message = 'Cart not found', int $code = 404, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
