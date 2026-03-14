<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Throwable;

class ErrorHandlingService
{
    /**
     * Handle and log errors with context
     */
    public static function handle(Throwable $e, array $context = []): void
    {
        $errorData = [
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
            'context' => $context,
            'timestamp' => now()->toISOString(),
        ];

        // Determine log level based on exception type
        $level = self::determineLogLevel($e);

        Log::log($level, 'Application Error', $errorData);

        // Send to external error tracking service (e.g., Sentry)
        if (config('services.sentry.enabled')) {
            self::sendToSentry($e, $context);
        }

        // Send critical errors to admin
        if ($level === 'critical' || $level === 'emergency') {
            self::notifyAdmin($e, $context);
        }
    }

    /**
     * Determine log level based on exception type
     */
    private static function determineLogLevel(Throwable $e): string
    {
        return match (true) {
            $e instanceof \Illuminate\Database\QueryException => 'critical',
            $e instanceof \Illuminate\Auth\AuthenticationException => 'warning',
            $e instanceof \Illuminate\Validation\ValidationException => 'info',
            $e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException => 'info',
            $e instanceof \App\Exceptions\PaymentException => 'error',
            $e instanceof \App\Exceptions\InsufficientStockException => 'warning',
            default => 'error',
        };
    }

    /**
     * Send error to Sentry
     */
    private static function sendToSentry(Throwable $e, array $context): void
    {
        if (function_exists('\\Sentry\\captureException')) {
            \Sentry\captureException($e);
        }
    }

    /**
     * Notify admin of critical errors
     */
    private static function notifyAdmin(Throwable $e, array $context): void
    {
        try {
            $admins = \App\Models\User::where('role', \App\Models\User::ROLE_ADMIN)->get();
            
            foreach ($admins as $admin) {
                $admin->notify(new \App\Notifications\CriticalErrorNotification($e, $context));
            }
        } catch (\Exception $notificationError) {
            Log::error('Failed to send admin notification', [
                'error' => $notificationError->getMessage(),
            ]);
        }
    }

    /**
     * Format error for API response
     */
    public static function formatForApi(Throwable $e): array
    {
        $response = [
            'success' => false,
            'message' => $e->getMessage(),
            'error' => class_basename($e),
        ];

        // Add debug info in development
        if (config('app.debug')) {
            $response['debug'] = [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => collect($e->getTrace())->take(5)->toArray(),
            ];
        }

        return $response;
    }

    /**
     * Log database query errors
     */
    public static function logQueryError(Throwable $e, string $sql, array $bindings = []): void
    {
        Log::error('Database Query Error', [
            'message' => $e->getMessage(),
            'sql' => $sql,
            'bindings' => $bindings,
            'trace' => $e->getTraceAsString(),
        ]);
    }

    /**
     * Log API errors
     */
    public static function logApiError(string $service, Throwable $e, array $request = []): void
    {
        Log::error('External API Error', [
            'service' => $service,
            'message' => $e->getMessage(),
            'request' => $request,
            'trace' => $e->getTraceAsString(),
        ]);
    }
}
