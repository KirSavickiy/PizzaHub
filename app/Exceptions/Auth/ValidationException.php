<?php

namespace App\Exceptions\Auth;

use App\Exceptions\BaseException;

class ValidationException extends BaseException
{
    protected array $errors;

    public function __construct($errors = [], $code = 422)
    {
        $message = "Validation failed";
        parent::__construct($message, $code);
        $this->setDetails($errors);
    }

}
