<?php

namespace App\Exceptions\Auth;

use Exception;

class AuthenticationException extends Exception
{
    public function __construct($message = "Authentication failed", $code = 401)
    {
        parent::__construct($message, $code);
    }

    public function render($request)
    {
        return response()->json(['error' => $this->getMessage()], $this->getCode());
    }
}
