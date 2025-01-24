<?php

use App\Exceptions\Auth\AuthenticationException;
use App\Exceptions\Auth\ValidationException;
use App\Exceptions\Cart\CartNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(App\Http\Middleware\OptionalAuth::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            return response()->json([
                'error' => 'Authentication required',
                'message' => $e->getMessage()
            ], 401);
        });

        $exceptions->renderable(function (\App\Exceptions\Cart\CartNotFoundException $e, $request) {
            return response()->json([
                'error' => 'Cart not found',
                'message' => $e->getMessage()
            ], 404);
        });

        $exceptions->renderable(function (\App\Exceptions\Auth\UnauthorizedException $e, $request) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => $e->getMessage()
            ], 404);
        });

        $exceptions->renderable(function (\Illuminate\Validation\ValidationException $e, $request) {
            throw new ValidationException(
                "Validation failed",
                $e->errors()
            );
        });
    })->create();
