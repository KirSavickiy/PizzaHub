<?php

namespace App\Exceptions\Address;

use App\Exceptions\BaseException;

class GetAddressException extends BaseException
{
    public function __construct($message = "Address not found", $code = 404)
    {
        parent::__construct($message, $code);
    }
}
