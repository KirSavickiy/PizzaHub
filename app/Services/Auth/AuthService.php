<?php

namespace App\Services\Auth;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthService
{
    /**
     * Authenticates the user and returns a token
     *
     * @param array $credentials
     * @return User
     * @throws AuthenticationException
     */
    public function login(array $credentials)
    {
        $login = Auth::attempt($credentials);

        if (!$login) {
            throw new AuthenticationException('Invalid credentials');
        }

        /** @var User $user */
        $user = Auth::user();

        return $user;
    }


}