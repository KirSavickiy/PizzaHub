<?php

namespace App\Exceptions\General;

use App\Exceptions\BaseException;

class CreationException extends BaseException
{
    public function __construct($message = "", $code = 500)
    {
        parent::__construct($message, $code);
    }
}
