<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Trait ApiResponse
 * 
 * Provides consistent API response formatting across all controllers.
 * All responses follow the structure: { success, message, data }
 * 
 * @package App\Traits
 */
trait ApiResponse
{
    /**
     * Return a success response.
     *
     * @param mixed $data The data to return
     * @param string $message Success message
     * @param int $code HTTP status code (default: 200)
     * @return JsonResponse
     */
    protected function success(mixed $data = null, string $message = 'Success', int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Return a created response (201).
     *
     * @param mixed $data The created resource data
     * @param string $message Success message
     * @return JsonResponse
     */
    protected function created(mixed $data = null, string $message = 'Resource created successfully'): JsonResponse
    {
        return $this->success($data, $message, 201);
    }

    /**
     * Return an error response.
     *
     * @param string $message Error message
     * @param int $code HTTP status code (default: 400)
     * @param mixed $errors Additional error details
     * @return JsonResponse
     */
    protected function error(string $message = 'Error', int $code = 400, mixed $errors = null): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }

    /**
     * Return a validation error response (422).
     *
     * @param mixed $errors Validation errors
     * @param string $message Error message
     * @return JsonResponse
     */
    protected function validationError(mixed $errors, string $message = 'Validation failed'): JsonResponse
    {
        return $this->error($message, 422, $errors);
    }

    /**
     * Return an unauthorized response (401).
     *
     * @param string $message Error message
     * @return JsonResponse
     */
    protected function unauthorized(string $message = 'Unauthenticated'): JsonResponse
    {
        return $this->error($message, 401);
    }

    /**
     * Return a forbidden response (403).
     *
     * @param string $message Error message
     * @return JsonResponse
     */
    protected function forbidden(string $message = 'Forbidden'): JsonResponse
    {
        return $this->error($message, 403);
    }

    /**
     * Return a not found response (404).
     *
     * @param string $message Error message
     * @return JsonResponse
     */
    protected function notFound(string $message = 'Resource not found'): JsonResponse
    {
        return $this->error($message, 404);
    }

    /**
     * Return a server error response (500).
     *
     * @param string $message Error message
     * @return JsonResponse
     */
    protected function serverError(string $message = 'Internal server error'): JsonResponse
    {
        return $this->error($message, 500);
    }

    /**
     * Return a paginated response.
     *
     * @param LengthAwarePaginator $paginator The paginator instance
     * @param string $message Success message
     * @return JsonResponse
     */
    protected function paginated(LengthAwarePaginator $paginator, string $message = 'Success'): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $paginator->items(),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
            ],
            'links' => [
                'first' => $paginator->url(1),
                'last' => $paginator->url($paginator->lastPage()),
                'prev' => $paginator->previousPageUrl(),
                'next' => $paginator->nextPageUrl(),
            ]
        ], 200);
    }

    /**
     * Return a no content response (204).
     *
     * @return JsonResponse
     */
    protected function noContent(): JsonResponse
    {
        return response()->json(null, 204);
    }
}
