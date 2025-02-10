<?php

namespace App\Exceptions\Order;

use App\Exceptions\BaseException;


class GetOrdersException extends BaseException
{
    public function __construct($message = "Failed to get orders", $code = 404)
    {
        parent::__construct($message, $code);
    }
}
