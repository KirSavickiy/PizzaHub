<?php

namespace App\Exceptions\Order;

use Exception;

class OrderCreationException extends Exception
{
    public function __construct($message = "Failed to create order", $code = 422)
    {
        parent::__construct($message, $code);
    }
}
