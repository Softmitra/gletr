<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\SellerDocument;
use App\Constants\DocumentStatus;
use App\Constants\SellerStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class VerificationController extends Controller
{
    use AuthorizesRequests;
    
    public function __construct()
    {
        // Middleware is handled by route groups
    }

    /**
     * Show seller verification status dashboard
     */
    public function index(): View
    {
        /** @var Seller $seller */
        $seller = Auth::guard('seller')->user();
        
        // Load relationships
        $seller->load(['sellerDocuments', 'expertReviewer', 'verificationLogs.user']);
        
        // Get document statistics
        $documentStats = [
            'total' => $seller->sellerDocuments->count(),
            'pending' => $seller->sellerDocuments->where('verification_status', DocumentStatus::PENDING)->count(),
            'verified' => $seller->sellerDocuments->where('verification_status', DocumentStatus::VERIFIED)->count(),
            'rejected' => $seller->sellerDocuments->where('verification_status', DocumentStatus::REJECTED)->count(),
        ];
        
        // Calculate verification progress
        $progress = $this->calculateVerificationProgress($seller, $documentStats);
        
        // Get recent verification activities
        $recentActivities = $seller->verificationLogs()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        return view('seller.verification.status', compact(
            'seller', 
            'documentStats', 
            'progress', 
            'recentActivities'
        ));
    }

    /**
     * Show document details
     */
    public function documents(): View
    {
        /** @var Seller $seller */
        $seller = Auth::guard('seller')->user();
        $documents = $seller->sellerDocuments()->orderBy('created_at', 'desc')->get();
        
        return view('seller.verification.documents', compact('seller', 'documents'));
    }

    /**
     * Download document
     */
    public function downloadDocument(SellerDocument $document)
    {
        /** @var Seller $seller */
        $seller = Auth::guard('seller')->user();
        
        // Check if document belongs to current seller
        if ($document->seller_id !== $seller->id) {
            abort(403, 'Unauthorized access to document');
        }
        
        if (!Storage::disk('public')->exists($document->document_path)) {
            abort(404, 'Document file not found');
        }
        
        $filePath = Storage::disk('public')->path($document->document_path);
        $fileName = $document->original_filename ?? 'document';
        
        return response()->download($filePath, $fileName);
    }

    /**
     * Show document resubmission form
     */
    public function resubmitDocument(SellerDocument $document)
    {
        /** @var Seller $seller */
        $seller = Auth::guard('seller')->user();
        
        // Check if document belongs to current seller and is rejected
        if ($document->seller_id !== $seller->id) {
            abort(403, 'Unauthorized access to document');
        }
        
        if (!$document->isRejected()) {
            return redirect()->route('seller.verification.documents')
                ->with('error', 'Only rejected documents can be resubmitted.');
        }
        
        return view('seller.verification.resubmit', compact('seller', 'document'));
    }

    /**
     * Handle document resubmission
     */
    public function storeResubmission(Request $request, SellerDocument $document)
    {
        /** @var Seller $seller */
        $seller = Auth::guard('seller')->user();
        
        // Validate access
        if ($document->seller_id !== $seller->id || !$document->isRejected()) {
            abort(403, 'Unauthorized action');
        }
        
        $request->validate([
            'document_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
        ]);
        
        try {
            $file = $request->file('document_file');
            $filename = time() . '_resubmit_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('sellers/documents', $filename, 'public');
            
            // Delete old file if exists
            if ($document->document_path && Storage::disk('public')->exists($document->document_path)) {
                Storage::disk('public')->delete($document->document_path);
            }
            
            // Update document with new file
            $document->update([
                'document_path' => $path,
                'original_filename' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'verification_status' => DocumentStatus::PENDING,
                'admin_comments' => null,
                'expert_reviewer_id' => null,
                'verified_at' => null,
                'uploaded_at' => now(),
            ]);
            
            // Log the resubmission
            $seller->logVerificationActivity('document_resubmitted', $seller->id, [
                'document_id' => $document->id,
                'document_type' => $document->document_type,
                'resubmitted_at' => now(),
            ]);
            
            return redirect()->route('seller.verification.documents')
                ->with('success', 'Document resubmitted successfully. It will be reviewed again.');
                
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to resubmit document: ' . $e->getMessage()]);
        }
    }

    /**
     * Calculate verification progress
     */
    private function calculateVerificationProgress(Seller $seller, array $documentStats): array
    {
        $totalSteps = 4; // Registration, Documents Upload, Document Review, Final Approval
        $completedSteps = 1; // Registration is always complete
        
        // Step 2: Documents uploaded
        if ($documentStats['total'] > 0) {
            $completedSteps++;
        }
        
        // Step 3: Documents reviewed (all documents either verified or rejected)
        if ($documentStats['total'] > 0 && ($documentStats['pending'] === 0)) {
            $completedSteps++;
        }
        
        // Step 4: Final approval
        if ($seller->verification_status === SellerStatus::VERIFIED) {
            $completedSteps++;
        }
        
        $percentage = ($completedSteps / $totalSteps) * 100;
        
        return [
            'total_steps' => $totalSteps,
            'completed_steps' => $completedSteps,
            'percentage' => round($percentage, 1),
            'current_step' => $this->getCurrentStep($seller, $documentStats),
        ];
    }

    /**
     * Get current verification step
     */
    private function getCurrentStep(Seller $seller, array $documentStats): array
    {
        if ($seller->verification_status === SellerStatus::VERIFIED) {
            return [
                'step' => 4,
                'title' => 'Verification Complete',
                'description' => 'Your account is fully verified and active.',
                'status' => 'completed'
            ];
        }
        
        if ($documentStats['total'] > 0 && $documentStats['pending'] === 0) {
            if ($documentStats['rejected'] > 0) {
                return [
                    'step' => 3,
                    'title' => 'Document Review - Action Required',
                    'description' => 'Some documents were rejected. Please resubmit them.',
                    'status' => 'action_required'
                ];
            }
            
            return [
                'step' => 4,
                'title' => 'Final Approval Pending',
                'description' => 'All documents verified. Waiting for final approval.',
                'status' => 'pending'
            ];
        }
        
        if ($documentStats['total'] > 0) {
            return [
                'step' => 3,
                'title' => 'Document Review in Progress',
                'description' => 'Your documents are being reviewed by our team.',
                'status' => 'in_progress'
            ];
        }
        
        return [
            'step' => 2,
            'title' => 'Documents Upload Required',
            'description' => 'Please upload your required documents to continue.',
            'status' => 'pending'
        ];
    }
}
