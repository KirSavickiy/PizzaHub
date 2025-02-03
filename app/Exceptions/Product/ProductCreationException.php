<?php

namespace App\Exceptions\Product;

use App\Exceptions\BaseException;

class ProductCreationException extends BaseException
{
    public function __construct($message = "", $code = 500)
    {
        parent::__construct($message, $code);
    }
}
