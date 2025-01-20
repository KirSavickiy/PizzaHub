<?php

namespace App\Exceptions\Auth;

use Exception;

class ValidationException extends Exception
{
    protected $errors;

    public function __construct($message = "Validation failed", $errors = [], $code = 422)
    {
        parent::__construct($message, $code);
        $this->errors = $errors;
    }

    public function render($request)
    {
        return response()->json([
            'error' => $this->getMessage(),
            'messages' => $this->errors,
        ], $this->getCode());
    }
}
