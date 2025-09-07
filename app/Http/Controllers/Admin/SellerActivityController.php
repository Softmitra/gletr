<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\SellerActivity;
use App\Models\SellerSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SellerActivityController extends Controller
{
    /**
     * Display seller activities overview
     */
    public function index(Request $request)
    {
        $query = SellerActivity::with(['seller', 'session'])
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($request->filled('seller')) {
            $query->whereHas('seller', function ($q) use ($request) {
                $q->where('business_name', 'like', '%' . $request->seller . '%')
                  ->orWhere('email', 'like', '%' . $request->seller . '%');
            });
        }

        if ($request->filled('type')) {
            switch ($request->type) {
                case 'login':
                    $query->where('activity_type', 'login');
                    break;
                case 'product':
                    $query->where('resource_type', 'product');
                    break;
                case 'order':
                    $query->where('resource_type', 'order');
                    break;
                default:
                    $query->where('activity_type', $request->type);
                    break;
            }
        }

        if ($request->filled('activity_type')) {
            $query->where('activity_type', $request->activity_type);
        }

        if ($request->filled('action')) {
            $query->where('action', 'like', '%' . $request->action . '%');
        }

        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        $activities = $query->paginate(20)->withQueryString();

        // Statistics
        $stats = [
            'total_activities' => SellerActivity::count(),
            'total_logins' => SellerActivity::where('activity_type', 'login')->count(),
            'total_page_views' => SellerActivity::where('activity_type', 'page_view')->count(),
            'total_actions' => SellerActivity::where('activity_type', 'action')->count(),
            'today_activities' => SellerActivity::whereDate('created_at', today())->count(),
            'active_sellers_today' => SellerActivity::whereDate('created_at', today())
                ->distinct('seller_id')->count('seller_id'),
        ];

        // Get activity types for filter
        $activityTypes = SellerActivity::select('activity_type')
            ->distinct()
            ->pluck('activity_type');

        // Get sellers for filter dropdown
        $sellers = Seller::select('id', 'business_name', 'email')
            ->whereHas('activities')
            ->orderBy('business_name')
            ->get();

        return view('admin.seller-activities.index', compact('activities', 'stats', 'activityTypes', 'sellers'));
    }

    /**
     * Show detailed activity information
     */
    public function show(SellerActivity $activity)
    {
        $activity->load(['seller', 'session']);
        
        return view('admin.seller-activities.show', compact('activity'));
    }

    /**
     * Show seller activities analytics
     */
    public function analytics(Request $request)
    {
        $dateFrom = $request->get('date_from', now()->subDays(30)->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));

        // Activity trends over time
        $activityTrends = SellerActivity::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Activity by type
        $activityByType = SellerActivity::selectRaw('activity_type, COUNT(*) as count')
            ->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
            ->groupBy('activity_type')
            ->get();

        // Activity by resource type
        $activityByResource = SellerActivity::selectRaw('resource_type, COUNT(*) as count')
            ->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
            ->whereNotNull('resource_type')
            ->groupBy('resource_type')
            ->get();

        // Top active sellers
        $topActiveSellers = SellerActivity::select('seller_id', DB::raw('COUNT(*) as activity_count'))
            ->with('seller:id,business_name,email')
            ->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
            ->groupBy('seller_id')
            ->orderBy('activity_count', 'desc')
            ->limit(10)
            ->get();

        // Hourly activity distribution
        $hourlyActivity = SellerActivity::selectRaw('HOUR(created_at) as hour, COUNT(*) as count')
            ->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

        // Daily login trends
        $loginTrends = SellerActivity::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('activity_type', 'login')
            ->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Statistics
        $stats = [
            'total_activities' => SellerActivity::whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])->count(),
            'unique_active_sellers' => SellerActivity::whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
                ->distinct('seller_id')->count('seller_id'),
            'avg_activities_per_seller' => SellerActivity::whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
                ->count() / max(1, SellerActivity::whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
                ->distinct('seller_id')->count('seller_id')),
            'peak_activity_hour' => $hourlyActivity->sortByDesc('count')->first()?->hour ?? 'N/A',
        ];

        return view('admin.seller-activities.analytics', compact(
            'activityTrends',
            'activityByType',
            'activityByResource',
            'topActiveSellers',
            'hourlyActivity',
            'loginTrends',
            'stats',
            'dateFrom',
            'dateTo'
        ));
    }

    /**
     * Show activities for a specific seller
     */
    public function sellerActivities(Seller $seller, Request $request)
    {
        $query = $seller->activities()->with('session');

        // Filter by activity type
        if ($request->filled('activity_type')) {
            $query->where('activity_type', $request->activity_type);
        }

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by resource type
        if ($request->filled('resource_type')) {
            $query->where('resource_type', $request->resource_type);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        $activities = $query->latest()->paginate(50)->withQueryString();

        $stats = [
            'total_activities' => $seller->activities()->count(),
            'today_activities' => $seller->activities()->whereDate('created_at', today())->count(),
            'this_week_activities' => $seller->activities()->where('created_at', '>=', now()->startOfWeek())->count(),
            'this_month_activities' => $seller->activities()->where('created_at', '>=', now()->startOfMonth())->count(),
        ];

        // Get activity types for filter
        $activityTypes = $seller->activities()
            ->select('activity_type')
            ->distinct()
            ->pluck('activity_type');

        return view('admin.seller-activities.seller', compact('seller', 'activities', 'stats', 'activityTypes'));
    }
}
