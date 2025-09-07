<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\SellerSession;
use App\Contracts\SellerSessionServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SellerSessionController extends Controller
{
    use AuthorizesRequests;

    protected SellerSessionServiceInterface $sessionService;

    public function __construct(SellerSessionServiceInterface $sessionService)
    {
        $this->sessionService = $sessionService;
    }

    /**
     * Display seller sessions overview
     */
    public function index(Request $request)
    {
        // Prepare filters from request
        $filters = [
            'status' => $request->get('status', 'all'),
            'seller_id' => $request->get('seller_id'),
            'date_from' => $request->get('date_from'),
            'date_to' => $request->get('date_to'),
            'device_type' => $request->get('device_type'),
            'search' => $request->get('search'),
        ];

        // Remove empty filters
        $filters = array_filter($filters, function($value) {
            return !is_null($value) && $value !== '';
        });

        // Get sessions using service
        $sessions = $this->sessionService->getSessionsWithFilters($filters, 20);

        // Get statistics using service
        $stats = $this->sessionService->getDashboardStats();

        // Get sellers for filter dropdown
        $sellers = Seller::select('id', 'business_name', 'email')
            ->whereHas('sessions')
            ->orderBy('business_name')
            ->get();

        return view('admin.seller-sessions.index', compact('sessions', 'stats', 'sellers'));
    }

    /**
     * Show detailed session information
     */
    public function show(SellerSession $session)
    {
        // Get session details with analytics using service
        $sessionDetails = $this->sessionService->getSessionDetails($session->id);

        if (!$sessionDetails) {
            abort(404, 'Session not found');
        }

        return view('admin.seller-sessions.show', $sessionDetails);
    }

    /**
     * Terminate a seller session
     */
    public function terminate(Request $request, SellerSession $session)
    {
        $this->authorize('terminate seller sessions');

        $success = $this->sessionService->terminateSession(
            $session->id,
            Auth::id(),
            $request->get('reason')
        );

        if (!$success) {
            return back()->withErrors(['error' => 'Session could not be terminated or is already inactive.']);
        }

        return back()->with('success', 'Session terminated successfully.');
    }

    /**
     * Terminate all sessions for a seller
     */
    public function terminateAllForSeller(Request $request, Seller $seller)
    {
        $this->authorize('terminate seller sessions');

        $terminatedCount = $this->sessionService->terminateAllSellerSessions(
            $seller->id,
            Auth::id(),
            $request->get('reason')
        );

        return back()->with('success', "Terminated {$terminatedCount} active sessions for {$seller->business_name}.");
    }

    /**
     * Show session analytics dashboard
     */
    public function analytics(Request $request)
    {
        $period = (int) $request->get('period', 7);

        // Get analytics data using service
        $analyticsData = $this->sessionService->getAnalyticsData($period);

        return view('admin.seller-sessions.analytics', array_merge($analyticsData, [
            'period' => $period
        ]));
    }


}
