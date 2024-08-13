<?php

use App\Http\Middleware\IsitGmail;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('api')
                ->prefix('api/V1')
                ->name('V1')
                ->group(__DIR__.'/../routes/api_V1.php');
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias(['isitGmail'=>IsitGmail::class]);
        // $middleware->web([IsitGmail::class]);


    })
    ->withExceptions(function (Exceptions $exceptions) {
        //for multiple exception
        $handlers = [
            NotFoundHttpException::class => fn($e) => response()->json(['error' => 'Not Found'], 404),
            AuthenticationException::class => fn($e) => response()->json(['error' => 'Authentication failed'], 401),
            ValidationException::class => fn($e) => response()->json(['errors' => $e->errors()], 422),
            // Add more exceptions as needed
        ];
    
        $exceptions->render(function (Throwable $e) use ($handlers) {
            $className = get_class($e);

            if (isset($handlers[$className])) {
                return $handlers[$className]($e);
            }

            return response()->json([
                'error' => 'An unexpected error occurred.',
                'message' => $e->getMessage(),
            ], 500);
        });

        //only for one exception 
        // $exceptions->render(function ($key ,  $e) {        
        //     return response()->json(['error' => $e->getMessage().'Not Found in '], 404);
        // });
        
        
    })->create();
