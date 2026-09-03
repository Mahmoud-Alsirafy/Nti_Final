<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        channels: __DIR__ . '/../routes/channels.php',
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            // 'auth.type' => \App\Http\Middleware\CheckUserType::class,
            // add middelware here
        ]);
        $middleware->validateCsrfTokens(except: [
            // '/webhook/callback',
        ]);
        $middleware->web(append: [
            // Append to work auto
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
