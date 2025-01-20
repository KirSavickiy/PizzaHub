<?php

use App\Exceptions\Auth\AuthenticationException;
use App\Exceptions\Auth\ValidationException;
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
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            throw new AuthenticationException($e->getMessage());
        });

        $exceptions->renderable(function (\Illuminate\Validation\ValidationException $e, $request) {
            throw new ValidationException(
                "Validation failed",
                $e->errors()
            );
        });
    })->create();
