<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogRequests
{
    /**
     * Handle an incoming request and log details.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);
        
        // Generate unique request ID
        $requestId = uniqid('req_', true);
        $request->attributes->set('request_id', $requestId);

        // Log incoming request
        Log::info('Incoming Request', [
            'request_id' => $requestId,
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'user_id' => $request->user()?->id,
            'timestamp' => now()->toISOString(),
        ]);

        // Process request
        $response = $next($request);

        // Calculate execution time
        $executionTime = round((microtime(true) - $startTime) * 1000, 2);

        // Log response
        Log::info('Outgoing Response', [
            'request_id' => $requestId,
            'status_code' => $response->getStatusCode(),
            'execution_time_ms' => $executionTime,
            'memory_usage_mb' => round(memory_get_peak_usage(true) / 1024 / 1024, 2),
        ]);

        // Add request ID to response headers
        $response->headers->set('X-Request-ID', $requestId);
        $response->headers->set('X-Execution-Time', $executionTime . 'ms');

        return $response;
    }
}
