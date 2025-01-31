<?php

namespace App\Exceptions\Order;

use Exception;

class GetOrdersException extends Exception
{
    public function __construct($message = "Failed to get orders", $code = 404)
    {
        parent::__construct($message, $code);
    }
}
