<?php

namespace App\Exceptions\Auth;

use App\Exceptions\BaseException;

class UnauthorizedException extends BaseException
{
    public function __construct(string $message = 'Unauthorized', int $code = 401)
    {
        parent::__construct($message, $code);
    }
}
