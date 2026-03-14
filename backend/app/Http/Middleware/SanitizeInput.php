<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SanitizeInput
{
    /**
     * Handle an incoming request and sanitize all input data.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $input = $request->all();
        $isRichText = $this->isRichTextField($request);
        
        array_walk_recursive($input, function (&$value) use ($isRichText) {
            if (is_string($value)) {
                // Remove null bytes
                $value = str_replace("\0", '', $value);
                
                // Trim whitespace
                $value = trim($value);
                
                // Strip HTML tags except for specific allowed fields
                if (!$isRichText) {
                    $value = strip_tags($value);
                }
            }
        });

        $request->merge($input);

        return $next($request);
    }

    /**
     * Check if the field should allow rich text (HTML)
     */
    private function isRichTextField(Request $request): bool
    {
        // Add fields that should allow HTML (like product descriptions)
        $richTextFields = ['description', 'notes', 'content'];
        
        foreach ($richTextFields as $field) {
            if ($request->has($field)) {
                return true;
            }
        }
        
        return false;
    }
}
