<?php

namespace App\Services\Auth;

class AuthCheckService
{
    /**
     * Checks if the user is authenticated
     *
     * @return bool
     */
    public function isAuthenticated(): bool
    {
        return auth()->check();
    }

}