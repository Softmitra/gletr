<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\UserTrackingService;
use App\Models\UserSession;
use App\Models\UserActivity;

class UserActivityMiddleware
{
    protected $userTrackingService;

    public function __construct(UserTrackingService $userTrackingService)
    {
        $this->userTrackingService = $userTrackingService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only track if user is authenticated
        if (Auth::check()) {
            $user = Auth::user();
            
            try {
                // Get or create user session
                $session = $this->getOrCreateSession($user, $request);
                
                // Update session activity
                if ($session) {
                    $this->userTrackingService->updateSessionActivity($session);
                }

                // Log page view activity (skip for AJAX requests and certain paths)
                if (!$request->ajax() && !$this->shouldSkipActivityLogging($request)) {
                    $this->userTrackingService->logPageView($user, $session, $request->path());
                }

            } catch (\Exception $e) {
                // Log error but don't break the application
                Log::error('User activity tracking error: ' . $e->getMessage());
            }
        }

        return $response;
    }

    /**
     * Get or create user session
     */
    protected function getOrCreateSession($user, Request $request)
    {
        $sessionId = $request->session()->getId();
        
        // Try to find existing active session
        $session = UserSession::where('user_id', $user->id)
            ->where('session_id', $sessionId)
            ->where('is_active', true)
            ->first();

        if (!$session) {
            // Create new session
            $session = $this->userTrackingService->createSession($user, $request);
            
            // Update user's last login info
            $user->updateLastLogin($request->ip(), $request->userAgent());
        }

        return $session;
    }

    /**
     * Check if activity logging should be skipped for this request
     */
    protected function shouldSkipActivityLogging(Request $request): bool
    {
        $skipPaths = [
            'admin/users/activity-chart',
            'admin/users/export',
            'admin/logs',
            'admin/logs/download',
            'admin/logs/delete',
            'admin/logs/clear',
            'admin/logs/generate-test',
        ];

        $skipPatterns = [
            '/^api\//',
            '/^_debugbar\//',
            '/^telescope\//',
        ];

        $path = $request->path();

        // Check exact paths
        if (in_array($path, $skipPaths)) {
            return true;
        }

        // Check patterns
        foreach ($skipPatterns as $pattern) {
            if (preg_match($pattern, $path)) {
                return true;
            }
        }

        return false;
    }
}
