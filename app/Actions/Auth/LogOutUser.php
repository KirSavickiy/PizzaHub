<?php

namespace App\Actions\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Laravel\Sanctum\PersonalAccessToken;

class LogOutUser
{
    public function handle(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->currentAccessToken() instanceof PersonalAccessToken) {
            $user->currentAccessToken()->delete();
        }
        return response()->json([
            'message' => 'Successfully logged out'
        ],Response::HTTP_OK);
    }
}