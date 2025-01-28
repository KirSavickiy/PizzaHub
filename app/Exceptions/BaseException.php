<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class BaseException extends Exception
{
    protected int $httpStatusCode;

    protected array $details = [];

    public function __construct($message = "", $code = 0, Exception $previous = null, $httpStatusCode = 400)
    {
        $this->httpStatusCode = $httpStatusCode;
        parent::__construct($message, $code, $previous);
    }

    public function setDetails(array $details): void
    {
        $this->details = $details;
    }

    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $this->getMessage(),
            'code' => $this->getCode(),
            'details' => $this->details,
        ], $this->getCode(), [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
