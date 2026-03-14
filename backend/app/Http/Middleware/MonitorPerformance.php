<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class MonitorPerformance
{
    /**
     * Handle an incoming request and monitor performance.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);
        $startMemory = memory_get_usage(true);

        $response = $next($request);

        $executionTime = (microtime(true) - $startTime) * 1000; // Convert to ms
        $memoryUsed = (memory_get_usage(true) - $startMemory) / 1024 / 1024; // Convert to MB

        // Log slow requests (> 1 second)
        if ($executionTime > 1000) {
            Log::warning('Slow Request Detected', [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'execution_time_ms' => round($executionTime, 2),
                'memory_used_mb' => round($memoryUsed, 2),
                'user_id' => $request->user()?->id,
            ]);
        }

        // Log high memory usage (> 50MB)
        if ($memoryUsed > 50) {
            Log::warning('High Memory Usage Detected', [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'memory_used_mb' => round($memoryUsed, 2),
                'execution_time_ms' => round($executionTime, 2),
            ]);
        }

        // Store performance metrics in cache for monitoring dashboard
        $this->storeMetrics($request, $executionTime, $memoryUsed);

        return $response;
    }

    /**
     * Store performance metrics
     */
    private function storeMetrics(Request $request, float $executionTime, float $memoryUsed): void
    {
        $key = 'performance_metrics_' . now()->format('Y-m-d-H');
        
        $metrics = Cache::get($key, [
            'total_requests' => 0,
            'total_execution_time' => 0,
            'total_memory_used' => 0,
            'slow_requests' => 0,
            'endpoints' => [],
        ]);

        $metrics['total_requests']++;
        $metrics['total_execution_time'] += $executionTime;
        $metrics['total_memory_used'] += $memoryUsed;
        
        if ($executionTime > 1000) {
            $metrics['slow_requests']++;
        }

        $endpoint = $request->method() . ' ' . $request->path();
        if (!isset($metrics['endpoints'][$endpoint])) {
            $metrics['endpoints'][$endpoint] = [
                'count' => 0,
                'avg_time' => 0,
                'max_time' => 0,
            ];
        }

        $metrics['endpoints'][$endpoint]['count']++;
        $metrics['endpoints'][$endpoint]['avg_time'] = 
            ($metrics['endpoints'][$endpoint]['avg_time'] * ($metrics['endpoints'][$endpoint]['count'] - 1) + $executionTime) 
            / $metrics['endpoints'][$endpoint]['count'];
        $metrics['endpoints'][$endpoint]['max_time'] = max(
            $metrics['endpoints'][$endpoint]['max_time'],
            $executionTime
        );

        Cache::put($key, $metrics, now()->addHours(24));
    }
}
