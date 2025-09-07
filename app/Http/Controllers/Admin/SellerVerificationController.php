<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\SellerDocument;
use App\Models\User;
use App\Constants\DocumentStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SellerVerificationController extends Controller
{
    use AuthorizesRequests;
    
    public function __construct()
    {
        // Remove middleware from constructor since it's already applied in routes
        // The routes are already protected by admin middleware
    }

    /**
     * Display seller verification dashboard
     */
    public function index(Request $request)
    {
        // Build query with filters
        $query = Seller::with(['sellerType', 'expertReviewer']);
        
        // Filter by verification status
        $verificationStatus = $request->get('verification_status', 'pending');
        if ($verificationStatus !== 'all') {
            $query->where('verification_status', $verificationStatus);
        }
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('business_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $sellers = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // Calculate statistics
        $stats = [
            'total_pending' => Seller::where('verification_status', 'pending')->count(),
            'documents_pending' => Seller::where('verification_status', 'pending')
                ->whereJsonLength('documents', '>', 0)->count(),
            'ready_for_approval' => Seller::where('verification_status', 'documents_verified')->count(),
            'verified_today' => Seller::where('verification_status', 'verified')
                ->whereDate('verification_completed_at', today())->count(),
            'rejected' => Seller::where('verification_status', 'rejected')->count(),
        ];
        
        return view('admin.seller-verification.index', compact('sellers', 'stats', 'verificationStatus'));
    }

    /**
     * Show seller verification details
     */
    public function show(Seller $seller)
    {
        $seller->load(['sellerType', 'expertReviewer', 'sellerDocuments']);
        
        // Get documents from seller_documents table
        $documents = $seller->sellerDocuments;
        
        // Get verification logs
        $verificationLogs = $seller->verificationLogs()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.seller-verification.show', compact('seller', 'documents', 'verificationLogs'));
    }

    /**
     * Verify a specific document
     */
    public function verifyDocument(Request $request, Seller $seller)
    {
        $this->authorize('verify seller documents');
        
        $request->validate([
            'document_id' => 'required|integer',
            'status' => 'required|in:verified,rejected,pending',
            'comments' => 'nullable|string|max:1000',
        ]);
        
        try {
            DB::beginTransaction();
            
            // Find the document in seller_documents table
            $document = SellerDocument::where('id', $request->document_id)
                ->where('seller_id', $seller->id)
                ->first();
            
            if (!$document) {
                return back()->withErrors(['error' => 'Document not found.']);
            }
            
            // Update the document status
            if ($request->status === 'verified') {
                $document->approve(Auth::id(), $request->comments);
            } elseif ($request->status === 'rejected') {
                $document->reject(Auth::id(), $request->comments);
            } else {
                // Reset to pending
                $document->update([
                    'verification_status' => DocumentStatus::PENDING,
                    'admin_comments' => $request->comments,
                    'expert_reviewer_id' => null,
                    'verified_at' => null,
                ]);
            }
            
            // Update seller verification status based on document status
            $seller->updateVerificationStatus();
            
            // Log the verification action
            $seller->logVerificationActivity('document_verified', Auth::id(), [
                'document_id' => $request->document_id,
                'document_type' => $document->document_type,
                'status' => $request->status,
                'comments' => $request->comments,
            ]);

            // Send notification to seller about document status
            try {
                $seller->sendDocumentStatusNotification($document->document_type, $request->status, $request->comments);
                Log::info('Document status notification sent', [
                    'seller_id' => $seller->id,
                    'document_type' => $document->document_type,
                    'status' => $request->status
                ]);
            } catch (\Exception $e) {
                Log::warning('Failed to send document status notification', [
                    'seller_id' => $seller->id,
                    'error' => $e->getMessage()
                ]);
            }
            
            DB::commit();
            
            return back()->with('success', 'Document verification updated successfully.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Document verification failed', [
                'seller_id' => $seller->id,
                'document_id' => $request->document_id,
                'error' => $e->getMessage()
            ]);
            
            return back()->withErrors(['error' => 'Verification failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Final seller approval
     */
    public function approveSeller(Request $request, Seller $seller)
    {
        Log::info('=== SELLER APPROVAL PROCESS START ===', [
            'seller_id' => $seller->id,
            'seller_name' => $seller->name,
            'current_status' => $seller->verification_status,
            'user_id' => Auth::id(),
            'request_data' => $request->all()
        ]);
        
        try {
            $this->authorize('approve seller verification');
            Log::info('Authorization passed for seller approval', ['user_id' => Auth::id()]);
        } catch (\Exception $e) {
            Log::error('Authorization failed for seller approval', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);
            return back()->withErrors(['error' => 'You do not have permission to approve sellers.']);
        }
        
        $request->validate([
            'comments' => 'nullable|string|max:1000',
        ]);
        Log::info('Validation passed for seller approval');
        
        try {
            DB::beginTransaction();
            Log::info('Database transaction started');
            
            // Check current seller status
            Log::info('Current seller verification status', [
                'verification_status' => $seller->verification_status,
                'is_verified' => $seller->is_verified,
                'status' => $seller->status
            ]);
            
            // Check document status
            $documents = $seller->sellerDocuments;
            Log::info('Seller documents status', [
                'total_documents' => $documents->count(),
                'documents_status' => $documents->pluck('verification_status', 'document_type')->toArray()
            ]);
            
            // Use model method to approve verification
            $approvalResult = $seller->approveVerification(Auth::id(), $request->comments);
            Log::info('Seller approveVerification method result', ['result' => $approvalResult]);
            
            if (!$approvalResult) {
                Log::warning('Seller approval failed - documents not ready', [
                    'seller_id' => $seller->id,
                    'documents_status' => $documents->pluck('verification_status', 'document_type')->toArray()
                ]);
                return back()->withErrors(['error' => 'All documents must be approved before final seller approval.']);
            }

            // Refresh seller model to get updated data
            $seller->refresh();
            Log::info('Seller status after approval', [
                'verification_status' => $seller->verification_status,
                'is_verified' => $seller->is_verified,
                'status' => $seller->status,
                'verification_completed_at' => $seller->verification_completed_at
            ]);

            // Send approval notification
            try {
                $seller->sendVerificationApprovedNotification($request->comments);
                Log::info('Seller approval notification sent', ['seller_id' => $seller->id]);
            } catch (\Exception $e) {
                Log::warning('Failed to send approval notification', [
                    'seller_id' => $seller->id,
                    'error' => $e->getMessage()
                ]);
            }
            
            DB::commit();
            Log::info('Database transaction committed successfully');
            
            Log::info('=== SELLER APPROVAL PROCESS SUCCESS ===', ['seller_id' => $seller->id]);
            
            return redirect()->route('admin.seller-verification.index')
                ->with('success', 'Seller approved successfully!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('=== SELLER APPROVAL PROCESS FAILED ===', [
                'seller_id' => $seller->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withErrors(['error' => 'Approval failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Reject seller verification
     */
    public function rejectSeller(Request $request, Seller $seller)
    {
        $this->authorize('approve seller verification');
        
        $request->validate([
            'comments' => 'required|string|max:1000',
        ]);
        
        try {
            DB::beginTransaction();
            
            // Use model method to reject verification
            $seller->rejectVerification(Auth::id(), $request->comments);

            // Send rejection notification
            try {
                $seller->sendVerificationRejectedNotification($request->comments);
                Log::info('Seller rejection notification sent', ['seller_id' => $seller->id]);
            } catch (\Exception $e) {
                Log::warning('Failed to send rejection notification', [
                    'seller_id' => $seller->id,
                    'error' => $e->getMessage()
                ]);
            }
            
            DB::commit();
            
            return redirect()->route('admin.seller-verification.index')
                ->with('success', 'Seller verification rejected.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Seller rejection failed', [
                'seller_id' => $seller->id,
                'error' => $e->getMessage()
            ]);
            
            return back()->withErrors(['error' => 'Rejection failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Assign expert reviewer
     */
    public function assignReviewer(Request $request, Seller $seller)
    {
        $this->authorize('manage verification workflow');
        
        $request->validate([
            'reviewer_id' => 'required|exists:users,id',
        ]);
        
        $reviewer = User::find($request->reviewer_id);
        
        // Check if user has verification permissions
        if (!$reviewer->can('verify seller documents')) {
            return back()->withErrors(['error' => 'Selected user does not have document verification permissions.']);
        }
        
        $assigned = $seller->assignReviewer($request->reviewer_id, Auth::id());
        
        if ($assigned) {
            return back()->with('success', 'Expert reviewer assigned successfully.');
        } else {
            return back()->with('info', 'This reviewer is already assigned to this seller.');
        }
    }

    /**
     * Get verification statistics
     */
    public function getStats()
    {
        $stats = [
            'pending_verification' => Seller::where('verification_status', 'pending')->count(),
            'documents_verified' => Seller::where('verification_status', 'documents_verified')->count(),
            'fully_verified' => Seller::where('verification_status', 'verified')->count(),
            'rejected' => Seller::where('verification_status', 'rejected')->count(),
            'total_documents' => DB::table('sellers')
                ->whereNotNull('documents')
                ->where('documents', '!=', '[]')
                ->count(),
        ];
        
        return response()->json($stats);
    }

    /**
     * Download document file
     */
    public function downloadDocument(Seller $seller, $documentId)
    {
        $this->authorize('view seller documents');
        
        $documents = $seller->documents ?? [];
        if (empty($documents)) {
            abort(404, 'No documents found');
        }
        
        $document = null;
        foreach ($documents as $doc) {
            if ($doc['document_requirement_id'] == $documentId) {
                $document = $doc;
                break;
            }
        }
        
        if (!$document || !isset($document['file_path'])) {
            abort(404, 'Document not found');
        }
        
        if (!Storage::disk('public')->exists($document['file_path'])) {
            abort(404, 'Document file not found');
        }
        
        $filePath = Storage::disk('public')->path($document['file_path']);
        $fileName = $document['original_filename'] ?? 'document';
        
        return response()->download($filePath, $fileName);
    }


}
