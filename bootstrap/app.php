<?php

use App\Traits\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'doctor' => \App\Http\Middleware\DoctorMiddleware::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'nurse' => \App\Http\Middleware\NurseMiddleware::class,
            'super_admin' => \App\Http\Middleware\SuperAdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        // 1. Handling 404 (Resource Not Found)
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return ApiResponse::errorResponse(
                    'The requested resource was not found.',
                    404
                );
            }
        });

        // 2. Handling Validation Errors
        $exceptions->render(function (ValidationException $e, Request $request) {
            if ($request->is('api/*')) {
                return ApiResponse::errorResponse(
                    'The given data was invalid.',
                    422,
                    $e->errors()
                );
            }
        });

        // 3. Handling Unauthorized Access
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                return ApiResponse::errorResponse(
                    'Unauthenticated. Please log in to access this resource.',
                    401
                );
            }
        });

    })->create();
