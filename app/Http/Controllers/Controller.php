<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use OpenApi\Attributes as OA;

#[OA\Info(
    title: 'OJAS Indonesia API', 
    version: '1.0.0',
    description: 'API Documentation for OJAS Indonesia Backend'
)]
#[OA\Server(
    url: 'http://localhost:8000',
    description: 'Local Development Server'
)]
#[OA\Server(
    url: 'http://35.186.156.82:8000',
    description: 'Staging Server'
)]
#[OA\SecurityScheme(
    securityScheme: 'bearerAuth',
    type: 'http',
    scheme: 'bearer',
    bearerFormat: 'JWT'
)]

abstract class Controller
{
    use AuthorizesRequests;

    // Success Response
    protected function success(
        mixed $data = null,
        bool $success = true,
        int $code = 200,
        string $message = 'Request was successful'
    ) {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    // Error Response
    protected function error(
        string $message = 'Request failed',
        bool $success = false,
        int $code = 500,
        mixed $error = null
    ) {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'error' => $error,
        ], $code);
    }

    // Created Response
    protected function created(
        mixed $data = null,
        bool $success = true,
        int $code = 201,
        string $message = 'Resource created successfully'
    ) {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
