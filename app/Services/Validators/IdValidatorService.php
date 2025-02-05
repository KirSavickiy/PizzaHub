<?php

namespace App\Services\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class IdValidatorService
{
    /**
     * @throws ValidationException
     */
    public static function validateId(string $id, string $table): int
    {
        $validator = Validator::make(['id' => $id], [
            'id' => "required|integer",
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return (int) $id;
    }

}