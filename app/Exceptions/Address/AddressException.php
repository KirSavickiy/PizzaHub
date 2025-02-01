<?php

namespace App\Exceptions\Address;

use App\Exceptions\BaseException;

class AddressException extends BaseException
{
    public function __construct($message = "", $code = 422)
    {
        parent::__construct($message, $code);
    }
}
