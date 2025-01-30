<?php

namespace App\Exceptions\Address;

use App\Exceptions\BaseException;

class AddressCreationException extends BaseException
{
    public function __construct($message = "Failed to create address", $code = 422)
    {
        parent::__construct($message, $code);
    }
}
