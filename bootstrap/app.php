<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->remove(\Illuminate\Session\Middleware\AuthenticateSession::class);
        $middleware->remove(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
        $middleware->append(\App\Http\Middlewares\HtmxMiddleware::class);
        $middleware->validateCsrfTokens(except: [
            '*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException $e, Request $request) {
            return response()
                ->view('parts.alert', [
                'type' => 'error',
                'message' => "Vous n'avez pas la permission de faire cette action",
            ], \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN);
        });
    })->create();
