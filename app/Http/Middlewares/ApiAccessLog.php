<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ApiAccessLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('api/me')) {
            return $next($request);
        }

        $start = microtime(true);

        $response = $next($request);

        $responseTime = round((microtime(true) - $start) * 1000, 3);

        Log::channel('api-access')->info(
            sprintf(
                '%s - %s | %s ms | %s | %s | %s',
                $request->ip(),
                $response->getStatusCode(),
                $responseTime,
                $request->method(),
                $request->getRequestUri(),
                optional($request->user())->id ?? 'guest'
            )
        );

        return $response;
    }
}