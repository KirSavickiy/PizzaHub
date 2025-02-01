<?php

namespace App\Services\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class IdValidatorService
{
    /**
     * @throws ValidationException
     */
    public static function validateId(string $id, string $table, string $column = 'id'): string
    {
        $validator = Validator::make(['id' => $id], [
            'id' => "required|integer|exists:$table,$column",
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $id;
    }
}