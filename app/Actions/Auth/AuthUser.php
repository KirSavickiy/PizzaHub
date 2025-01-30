<?php

namespace App\Actions\Auth;

use App\Exceptions\Auth\AuthenticationException;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\AuthUserResource;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;

class AuthUser
{
    protected AuthService $authService;
    protected GenerateUserToken $generateUserToken;

    public function __construct(AuthService $authService, GenerateUserToken $generateUserToken)
    {
        $this->authService = $authService;
        $this->generateUserToken = $generateUserToken;
    }

    /**
     * @throws AuthenticationException
     */
    public function handle(LoginRequest $request): JsonResponse
    {
        $user = $this->authService->login($request->loginData());

        $token = $this->generateUserToken->handle($user);

        return (new AuthUserResource($user))
            ->additional([
                'success' => true,
                'message' => 'Login successful',
                'token' => $token,
            ])
            ->response()
            ->setStatusCode(200);
    }
}