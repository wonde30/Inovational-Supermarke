<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTokenExpiration
{
    /**
     * Handle an incoming request and check if token is expired.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->currentAccessToken()) {
            $token = $user->currentAccessToken();
            
            // Check if token has expired
            if ($token->expires_at && $token->expires_at->isPast()) {
                // Delete expired token
                $token->delete();
                
                return response()->json([
                    'success' => false,
                    'message' => 'Token has expired. Please login again.',
                    'error' => 'token_expired'
                ], 401);
            }
        }

        return $next($request);
    }
}
