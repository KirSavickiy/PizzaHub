<?php

namespace App\Exceptions\Cart;

use App\Exceptions\BaseException;

class EmptyCartException extends BaseException
{
    public function __construct(string $message = 'Cart is empty', int $code = 400, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
