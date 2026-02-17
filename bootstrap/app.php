<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->appendToGroup('api', [
            \App\Http\Middleware\ApiAccessLog::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Validation Exception
        $exceptions->render(function (ValidationException $e, $request) {
            $count = collect($e->errors())->flatten()->count();
            
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => "Validasi gagal dengan $count kesalahan.",
                    'errors' => $e->errors(),
                ], 422);
            }

            return null;
        });
        
        // Throttle Exception
        $exceptions->render(function (ThrottleRequestsException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terlalu banyak percobaan. Silakan coba lagi nanti.',
                ], 429);
            }

            return null;
        });
        
        // Authentication Exception
        $exceptions->render(function (AuthenticationException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak terautentikasi. Silakan login terlebih dahulu.',
                    'error' => $e->getMessage(),
                ], 401);
            }

            return null;
        });
        
        // Model Not Found Exception
        $exceptions->render(function (ModelNotFoundException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan.',
                    'error' => 'Resource not found',
                ], 404);
            }

            return null;
        });
        
        // Not Found HTTP Exception
        $exceptions->render(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Endpoint tidak ditemukan.',
                    'error' => 'Route not found',
                ], 404);
            }

            return null;
        });
        
        // Access Denied Exception
        $exceptions->render(function (AccessDeniedHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak. Anda tidak memiliki izin untuk mengakses resource ini.',
                    'error' => $e->getMessage(),
                ], 403);
            }

            return null;
        });
    })->create();
