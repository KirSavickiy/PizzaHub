<?php

namespace App\Services\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class IdValidatorService
{
    /**
     * Validate the given ID to ensure it is a required integer.
     *
     * @param string $id The ID to validate.
     * @return int The validated ID as an integer.
     *
     * @throws ValidationException If the ID is not a valid integer.
     */
    public static function validateId(string $id): int
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