<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\AuthUser;
use App\Actions\Auth\LogOutUser;
use App\Actions\Auth\RegisterUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class AuthController extends Controller
{
    public function login(LoginRequest $request, AuthUser $action): JsonResponse
    {
        return $action->handle($request);
    }

    public function register(RegisterRequest $request, RegisterUser $action): JsonResponse
    {
        return $action->handle($request);
    }

    public function logout(Request $request, LogOutUser $action): JsonResponse
    {
        return $action->handle($request);
    }
}
