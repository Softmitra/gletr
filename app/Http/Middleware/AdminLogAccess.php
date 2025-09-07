<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminLogAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and has admin role
        if (!auth()->check()) {
            return redirect()->route('admin.login')->with('error', 'Please login to access this area.');
        }

        // Check if user has admin permissions (super_admin or ops_admin)
        if (!auth()->user()->hasAnyRole(['super_admin', 'ops_admin'])) {
            abort(403, 'Access denied. Admin privileges required to view system logs.');
        }

        return $next($request);
    }
}
