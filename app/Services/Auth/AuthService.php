<?php

namespace App\Services\Auth;

use App\Exceptions\Auth\AuthenticationException;
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
    public function login(array $credentials): User
    {
        $login = Auth::attempt($credentials);

        if (!$login) {
            throw new AuthenticationException('Invalid credentials');
        }

        /** @var User $user */
        $user = Auth::user();

        return $user;
    }
    /**
     * Checks if the user is authenticated
     *
     * @return bool
     */
    public function isAuthenticated(): bool
    {
        return auth()->check();
    }

    /**
     * Retrieves the ID of the currently authenticated user.
     *
     * @return int
     * @throws AuthenticationException If the user is not authenticated.
     */
    public function getAuthenticatedUserId(): int
    {
        $userId = Auth::id();

        if (!$userId) {
            throw new AuthenticationException("User is not authenticated.");
        }

        return $userId;
    }
}