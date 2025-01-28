<?php

namespace App\Actions\Auth;

use App\Exceptions\Auth\ValidationException;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\RegisterUserResource;
use App\Services\Auth\RegisterService;
use Illuminate\Http\JsonResponse;

class RegisterUser
{
    protected RegisterService $registerService;
    protected GenerateUserToken $generateUserToken;

    public function __construct(RegisterService $registerService, GenerateUserToken $generateUserToken)
    {
        $this->registerService = $registerService;
        $this->generateUserToken = $generateUserToken;
    }

    /**
     * Handle the registration process
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function handle(RegisterRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        try{
            $user = $this->registerService->register($validatedData);
            $token = $this->generateUserToken->handle($user);
        }catch (\Exception $e){
            throw new ValidationException($e);
        }

        return (new RegisterUserResource($user))
            ->additional([
                'success' => true,
                'message' => 'User registered successfully',
                'token' => $token,
            ])
            ->response()
            ->setStatusCode(201);
    }
}