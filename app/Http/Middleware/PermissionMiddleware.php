<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$permissions
     */
    public function handle(Request $request, Closure $next, string ...$permissions): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return $this->unauthorizedResponse($request);
        }

        // If no permissions specified, just check authentication
        if (empty($permissions)) {
            return $next($request);
        }

        $user = auth()->user();

        // Check if user has any of the required permissions
        $hasPermission = false;
        foreach ($permissions as $permission) {
            if ($user->can($permission)) {
                $hasPermission = true;
                break;
            }
        }

        if (!$hasPermission) {
            return $this->forbiddenResponse($request, $permissions);
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
    private function forbiddenResponse(Request $request, array $permissions): Response
    {
        $permissionsList = implode(', ', $permissions);
        
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => "Access denied. Required permissions: {$permissionsList}",
                'error' => 'Forbidden',
                'required_permissions' => $permissions
            ], 403);
        }

        // For web requests, show a proper error page
        return response()->view('errors.403', [
            'message' => "You don't have permission to access this resource.",
            'required_permissions' => $permissions
        ], 403);
    }
}