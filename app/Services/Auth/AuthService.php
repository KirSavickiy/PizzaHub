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
     * Retrieves the ID of the authenticated user.
     *
     * @return int|null Returns the user's ID if authenticated, or `null` if not.
     */
    public function getAuthenticatedUserId(): ?int
    {
        return Auth::id();
    }
}