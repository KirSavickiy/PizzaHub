<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\AuthUser;
use App\Actions\Auth\RegisterUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;


class AuthController extends Controller
{
    public function login(LoginRequest $request, AuthUser $action)
    {
        return $action->handle($request);
    }

    public function register(RegisterRequest $request, RegisterUser $action)
    {
        return $action->handle($request);
    }
}
