<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AdminCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        if ($request->user() && $request->user()->id == 1) {
            return $next($request);
        }
    
        return response()->json([
            'error' => [
                'message' => 'Unauthorized user',
                'code' => 401, // Unauthorized HTTP status code
            ]
        ], 401);
    }
}
