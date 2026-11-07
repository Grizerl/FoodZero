<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // The admin login route is named `admin.login.form`; there is no `login` route.
        $middleware->redirectGuestsTo(fn () => route('admin.login.form'));

        // One-click unsubscribe is POSTed by mail clients without a CSRF token; the URL is signed instead.
        $middleware->validateCsrfTokens(except: ['newsletter/unsubscribe/*']);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // API clients always get JSON (401 for guests), even without an `Accept: application/json` header.
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request, Throwable $e) => $request->is('api/*') || $request->expectsJson()
        );
    })->create();
