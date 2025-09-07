<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
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

        // Check if user has admin role (super_admin or ops_admin)
        if (!auth()->user()->hasAnyRole(['super_admin', 'ops_admin'])) {
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
                'message' => 'Admin access required. You need super_admin or ops_admin role.',
                'error' => 'Forbidden'
            ], 403);
        }

        abort(403, 'Admin access required. You need super_admin or ops_admin role.');
    }
}
