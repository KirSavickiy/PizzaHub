<?php

namespace App\Exceptions\Auth;

use App\Exceptions\BaseException;

class AuthenticationException extends BaseException
{
    public function __construct($message = "Authentication failed", $code = 401)
    {
        parent::__construct($message, $code);
    }

}
