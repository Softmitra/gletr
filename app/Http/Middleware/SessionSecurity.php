<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SessionSecurity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (Auth::check()) {
            $user = Auth::user();
            
            // Check for session hijacking by comparing IP addresses
            $currentIp = $request->ip();
            $sessionIp = Session::get('user_ip');
            
            if ($sessionIp && $sessionIp !== $currentIp) {
                // Log suspicious activity
                \Log::warning('Potential session hijacking detected', [
                    'user_id' => $user->id,
                    'session_ip' => $sessionIp,
                    'current_ip' => $currentIp,
                    'user_agent' => $request->userAgent()
                ]);
                
                // Logout user and regenerate session
                Auth::logout();
                Session::invalidate();
                Session::regenerateToken();
                
                return redirect()->route('admin.login')->with('error', 'Session security violation detected. Please login again.');
            }
            
            // Store IP address in session if not set
            if (!$sessionIp) {
                Session::put('user_ip', $currentIp);
            }
            
            // Check for user agent changes (potential session hijacking)
            $currentUserAgent = $request->userAgent();
            $sessionUserAgent = Session::get('user_agent');
            
            if ($sessionUserAgent && $sessionUserAgent !== $currentUserAgent) {
                \Log::warning('User agent change detected', [
                    'user_id' => $user->id,
                    'session_user_agent' => $sessionUserAgent,
                    'current_user_agent' => $currentUserAgent
                ]);
                
                // For user agent changes, we'll just log but not logout (could be legitimate)
                // Update the session with new user agent
                Session::put('user_agent', $currentUserAgent);
            }
            
            // Store user agent in session if not set
            if (!$sessionUserAgent) {
                Session::put('user_agent', $currentUserAgent);
            }
            
            // Update last activity timestamp
            Session::put('last_activity', now());
            
            // Check for session timeout (additional to Laravel's built-in timeout)
            $lastActivity = Session::get('last_activity');
            if ($lastActivity && now()->diffInMinutes($lastActivity) > config('session.lifetime')) {
                Auth::logout();
                Session::invalidate();
                Session::regenerateToken();
                
                return redirect()->route('admin.login')->with('error', 'Your session has expired. Please login again.');
            }
        }
        
        return $next($request);
    }
}