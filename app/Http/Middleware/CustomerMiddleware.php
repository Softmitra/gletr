<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return $this->unauthorizedResponse($request);
        }

        // Check if user has customer role (or admin/seller - they can access customer areas)
        if (!auth()->user()->hasAnyRole(['customer', 'seller', 'admin'])) {
            return $this->forbiddenResponse($request);
        }

        return $next($request);
    }

    /**
     * Handle unauthorized response for both web and API
     */
    private function unauthorizedResponse(Request $request): Response
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Authentication required',
                'error' => 'Unauthorized'
            ], 401);
        }

        return redirect()->guest(route('admin.login'));
    }

    /**
     * Handle forbidden response for both web and API
     */
    private function forbiddenResponse(Request $request): Response
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Customer access required',
                'error' => 'Forbidden'
            ], 403);
        }

        abort(403, 'Customer access required');
    }
}
