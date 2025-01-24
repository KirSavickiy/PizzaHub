<?php

namespace App\Actions\Auth;

use App\Models\User;


class GenerateUserToken
{
    public function handle(User $user): string
    {
        return $user->createToken('api')->plainTextToken;
    }
}