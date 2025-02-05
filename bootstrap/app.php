<?php

use App\Exceptions\Auth\AuthenticationException;
use App\Exceptions\Auth\ValidationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\ApiJsonResponse;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'guest' => App\Http\Middleware\CustomGuestMiddleware::class,
            'guest_or_authenticated' => App\Http\Middleware\OptionalAuth::class,
            'admin' => App\Http\Middleware\AdminMiddleware::class,
        ]);
        $middleware->append(ApiJsonResponse::class);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            throw new AuthenticationException($e);
        });
        $exceptions->renderable(function (\Illuminate\Validation\ValidationException $e, $request) {
            $errors = $e->errors();
            throw new ValidationException($errors);
        }
        );
    })->create();
