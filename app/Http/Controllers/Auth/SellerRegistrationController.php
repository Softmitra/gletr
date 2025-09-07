<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Seller;
use App\Models\SellerType;
use App\Models\DocumentRequirement;
use App\Services\EmailService;
use App\Services\OtpService;
use App\Models\SellerDocument;
use App\Constants\DocumentStatus;
use App\Services\SellerStoreService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class SellerRegistrationController extends Controller
{
    protected $storeService;
    protected $otpService;

    public function __construct(SellerStoreService $storeService, OtpService $otpService)
    {
        $this->storeService = $storeService;
        $this->otpService = $otpService;
    }

    /**
     * Display the seller registration view.
     */
    public function create(): View
    {
        $sellerTypes = SellerType::where('status', true)
            ->orderBy('sort_order', 'asc')
            ->get();
            
        return view('auth.seller-register', compact('sellerTypes'));
    }

    /**
     * Get document requirements for a specific seller type
     */
    public function getDocumentRequirements(Request $request)
    {
        $sellerTypeId = $request->input('seller_type_id');
        
        if (!$sellerTypeId) {
            return response()->json(['documents' => []]);
        }

        $sellerType = SellerType::find($sellerTypeId);
        
        if (!$sellerType) {
            return response()->json(['documents' => []]);
        }

        // Get document requirements that apply to this seller type
        $documentRequirements = DocumentRequirement::where('is_active', true)
            ->where(function($query) use ($sellerType) {
                $query->whereJsonContains('applicable_seller_types', $sellerType->slug)
                      ->orWhereJsonContains('applicable_seller_types', 'all');
            })
            ->orderBy('is_mandatory', 'desc')
            ->orderBy('document_name')
            ->get();

        // Debug log
        Log::info('Document requirements for seller type: ' . $sellerType->slug, [
            'seller_type_id' => $sellerTypeId,
            'seller_type_slug' => $sellerType->slug,
            'documents_count' => $documentRequirements->count(),
            'documents' => $documentRequirements->toArray()
        ]);

        $documents = $documentRequirements->map(function($doc) {
            return [
                'id' => $doc->id,
                'name' => $doc->document_name,
                'type' => $doc->document_type,
                'mandatory' => $doc->is_mandatory,
                'description' => $doc->description,
                'validation_rules' => $doc->validation_rules
            ];
        })->unique('id')->values(); // Ensure unique documents by ID

        return response()->json([
            'documents' => $documents
        ]);
    }

    /**
     * Check if email is already registered
     */
    public function checkEmail(Request $request)
    {
        $email = $request->input('email');
        
        if (!$email) {
            return response()->json(['available' => false, 'message' => 'Email is required']);
        }

        $exists = User::where('email', $email)->exists();
        
        return response()->json([
            'available' => !$exists,
            'message' => $exists ? 'This email is already registered' : 'Email is available'
        ]);
    }

    /**
     * Check if phone number is already registered
     */
    public function checkPhone(Request $request)
    {
        $phone = $request->input('phone');
        
        if (!$phone) {
            return response()->json(['available' => false, 'message' => 'Phone number is required']);
        }

        // Validate phone format
        if (!preg_match('/^[6-9]\d{9}$/', $phone)) {
            return response()->json([
                'available' => false, 
                'message' => 'Please enter a valid 10-digit Indian mobile number starting with 6, 7, 8, or 9'
            ]);
        }

        $exists = Seller::where('phone', $phone)->exists();
        
        return response()->json([
            'available' => !$exists,
            'message' => $exists ? 'This phone number is already registered' : 'Phone number is available'
        ]);
    }

    /**
     * Check if PAN number is already registered
     */
    public function checkPan(Request $request)
    {
        $panNumber = $request->input('pan_number');
        
        if (!$panNumber) {
            return response()->json(['available' => false, 'message' => 'PAN number is required']);
        }

        // Validate PAN format
        if (!preg_match('/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/', $panNumber)) {
            return response()->json([
                'available' => false, 
                'message' => 'Please enter a valid PAN number format (e.g., ABCDE1234F)'
            ]);
        }

        $exists = Seller::where('pan_number', $panNumber)->exists();
        
        return response()->json([
            'available' => !$exists,
            'message' => $exists ? 'This PAN number is already registered' : 'PAN number is available'
        ]);
    }

    /**
     * Check if GST number is already registered
     */
    public function checkGst(Request $request)
    {
        $gstNumber = $request->input('gst_number');
        
        if (!$gstNumber) {
            return response()->json(['available' => true, 'message' => 'GST number is optional']);
        }

        // Validate GST format
        if (!preg_match('/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/', $gstNumber)) {
            return response()->json([
                'available' => false, 
                'message' => 'Please enter a valid GST number format (e.g., 22ABCDE1234F1Z5)'
            ]);
        }

        $exists = Seller::where('gst_number', $gstNumber)->exists();
        
        return response()->json([
            'available' => !$exists,
            'message' => $exists ? 'This GST number is already registered' : 'GST number is available'
        ]);
    }

    /**
     * Handle an incoming seller registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Check for upload errors first
        if ($request->server('CONTENT_LENGTH') > $this->getMaxPostSize()) {
            return back()->withErrors([
                'file_size' => 'The total file size exceeds the server limit. Please reduce file sizes and try again.'
            ])->withInput();
        }
        // Validate the request
        $validationRules = [
            // Step 1: Login Details
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'regex:/^[6-9]\d{9}$/', 'unique:sellers,phone'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            
            // Step 2: Personal Information
            'name' => ['required', 'string', 'max:255'],
            'seller_type_id' => ['required', 'exists:seller_types,id'],
            'pincode' => ['required', 'string', 'regex:/^[1-9][0-9]{5}$/'],
            'address' => ['required', 'string', 'max:500'],
            'area' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'country' => ['required', 'string', 'max:100'],
            
            // Step 3: Store Details
            'business_name' => ['required', 'string', 'max:255'],
            
            // Step 4: Bank Details
            'bank_name' => ['required', 'string', 'max:100'],
            'holder_name' => ['required', 'string', 'max:255'],
            'account_no' => ['required', 'string', 'min:9', 'max:18', 'regex:/^[0-9]+$/'],
            'ifsc_code' => ['required', 'string', 'size:11', 'regex:/^[A-Z]{4}0[A-Z0-9]{6}$/'],
            'branch' => ['nullable', 'string', 'max:255'],
            'pan_number' => ['required', 'string', 'size:10', 'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/', 'unique:sellers,pan_number'],
            'gst_number' => ['nullable', 'string', 'size:15', 'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/', 'unique:sellers,gst_number'],
            
            // Step 6: Terms
            'terms_accepted' => ['required', 'accepted'],
        ];

        // Add document validation rules dynamically
        $sellerTypeId = $request->input('seller_type_id');
        if ($sellerTypeId) {
            $sellerType = SellerType::find($sellerTypeId);
            if ($sellerType) {
                $documentRequirements = DocumentRequirement::where('is_active', true)
                    ->where(function($query) use ($sellerType) {
                        $query->whereJsonContains('applicable_seller_types', $sellerType->slug)
                              ->orWhereJsonContains('applicable_seller_types', 'all');
                    })
                    ->get();

                foreach ($documentRequirements as $doc) {
                    $fieldName = 'documents.' . $doc->id; // Laravel array notation for validation
                    if ($doc->is_mandatory) {
                        $validationRules[$fieldName] = ['required', 'file', 'mimes:pdf,jpeg,png,jpg', 'max:5120']; // 5MB max
                    } else {
                        $validationRules[$fieldName] = ['nullable', 'file', 'mimes:pdf,jpeg,png,jpg', 'max:5120']; // 5MB max
                    }
                }
                
                // Add validation for other file uploads
                $validationRules['seller_image'] = ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048']; // 2MB max
                $validationRules['store_logo'] = ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048']; // 2MB max
                $validationRules['store_banner'] = ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048']; // 2MB max
            }
        }

        // Custom validation messages
        $customMessages = [
            'phone.regex' => 'Please enter a valid 10-digit Indian mobile number starting with 6, 7, 8, or 9.',
            'phone.unique' => 'This phone number is already registered.',
            'pincode.regex' => 'Please enter a valid 6-digit pincode.',
            'account_no.regex' => 'Account number must contain only digits.',
            'account_no.min' => 'Account number must be at least 9 digits.',
            'account_no.max' => 'Account number must not exceed 18 digits.',
            'ifsc_code.size' => 'IFSC code must be exactly 11 characters.',
            'ifsc_code.regex' => 'Please enter a valid IFSC code format (e.g., SBIN0001234).',
            'pan_number.size' => 'PAN number must be exactly 10 characters.',
            'pan_number.regex' => 'Please enter a valid PAN number format (e.g., ABCDE1234F).',
            'pan_number.unique' => 'This PAN number is already registered.',
            'gst_number.size' => 'GST number must be exactly 15 characters.',
            'gst_number.regex' => 'Please enter a valid GST number format (e.g., 22ABCDE1234F1Z5).',
            'gst_number.unique' => 'This GST number is already registered.',
            'documents.*.required' => 'This document is required.',
            'documents.*.file' => 'Please upload a valid file.',
            'documents.*.mimes' => 'Document must be a PDF, JPG, PNG, or JPEG file.',
            'documents.*.max' => 'Document file size must not exceed 5MB.',
            'store_logo.image' => 'Store logo must be an image file.',
            'store_banner.image' => 'Store banner must be an image file.',
        ];

        $request->validate($validationRules, $customMessages);

        // Check for duplicate sellers
        $existingSeller = $this->checkDuplicateSeller($request);
        if ($existingSeller) {
            return back()->withErrors([
                'duplicate' => 'A seller with this email, phone, or PAN number already exists.'
            ])->withInput();
        }

        try {
            Log::info('Starting seller registration process', [
                'email' => $request->email,
                'phone' => $request->phone,
                'seller_type_id' => $request->seller_type_id
            ]);

            DB::beginTransaction();

            // Handle seller image upload if provided
            $sellerImagePath = null;
            if ($request->hasFile('seller_image')) {
                $sellerImagePath = $this->uploadFile($request->file('seller_image'), 'sellers/images');
                Log::info('Seller image uploaded', ['path' => $sellerImagePath]);
            }

            // Create seller profile directly (no user account needed)
            Log::info('Creating seller profile');
            $seller = Seller::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'seller_type_id' => $request->seller_type_id,
                'pincode' => $request->pincode,
                'address_line_1' => $request->address,
                'area' => $request->area,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'business_name' => $request->business_name,
                'bank_name' => $request->bank_name,
                'holder_name' => $request->holder_name,
                'account_no' => $request->account_no,
                'ifsc_code' => $request->ifsc_code,
                'branch' => $request->branch,
                'image' => $sellerImagePath, // Add seller image
                'is_verified' => false, // Admin will verify
                'status' => 'pending',   // Activate after verification
                'verification_status' => 'pending',
            ]);
            Log::info('Seller profile created successfully', ['seller_id' => $seller->id]);

            // Create seller store
            Log::info('Creating seller store');
            $storeData = [
                'seller_id' => $seller->id,
                'store_name' => $request->business_name,
                'store_address' => $request->store_address ?? $request->address,
                'store_phone' => $request->phone,
                'store_email' => $request->email,
                'store_description' => $request->store_description ?? null,
                'store_categories' => $request->store_categories ?? [],
                'is_active' => false, // Will be activated after verification
            ];

            // Handle store logo and banner uploads if provided
            $logo = $request->hasFile('store_logo') ? $request->file('store_logo') : null;
            $banner = $request->hasFile('store_banner') ? $request->file('store_banner') : null;

            $store = $this->storeService->createStore($storeData, $logo, $banner);
            Log::info('Seller store created successfully', ['store_id' => $store->id]);

            // Handle document uploads - Fix: Get document requirements again
            Log::info('Processing document uploads');
            $sellerType = SellerType::find($request->seller_type_id);
            if ($sellerType) {
                $documentRequirements = DocumentRequirement::where('is_active', true)
                    ->where(function($query) use ($sellerType) {
                        $query->whereJsonContains('applicable_seller_types', $sellerType->slug)
                              ->orWhereJsonContains('applicable_seller_types', 'all');
                    })
                    ->get();

                Log::info('Found document requirements', ['count' => $documentRequirements->count()]);
                
                if ($documentRequirements->count() > 0) {
                    $this->handleDocumentUploads($request, $seller, $documentRequirements);
                    Log::info('Document uploads processed successfully');
                }
            }

            DB::commit();
            Log::info('Seller registration completed successfully', [
                'seller_id' => $seller->id,
                'store_id' => $store->id
            ]);

            // Send registration received notification
            try {
                $seller->sendRegistrationReceivedNotification();
                Log::info('Registration notification sent', ['seller_id' => $seller->id]);
            } catch (\Exception $e) {
                Log::warning('Failed to send registration notification', [
                    'seller_id' => $seller->id,
                    'error' => $e->getMessage()
                ]);
            }

            // Generate and send OTP for email verification
            $otpResult = $this->otpService->generateAndSendOtp($seller->email, 'email_verification');
            
            if (!$otpResult['success']) {
                Log::warning('Failed to send OTP during registration', [
                    'seller_id' => $seller->id,
                    'email' => $seller->email,
                    'error' => $otpResult['message']
                ]);
                
                // Still redirect to verification page, user can resend OTP
                session(['verification_email' => $seller->email]);
                return redirect()->route('seller.verify-email')
                    ->with('warning', 'Registration completed but email verification failed. Please try resending the verification code.');
            }

            // Store verification email in session
            session(['verification_email' => $seller->email]);

            // Redirect to email verification page
            return redirect()->route('seller.verify-email')
                ->with('success', 'Registration completed! Please check your email for the verification code.');

        } catch (\Throwable $e) {
            DB::rollBack();
            
            Log::error('Seller registration failed', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except(['password', 'password_confirmation'])
            ]);
            
            return back()->withErrors([
                'error' => 'Registration failed: ' . $e->getMessage()
            ])->withInput();
        }
    }

    /**
     * Check for duplicate sellers
     */
    private function checkDuplicateSeller(Request $request)
    {
        Log::info('Checking for duplicate sellers', [
            'email' => $request->email,
            'phone' => $request->phone
        ]);
        
        $existingSeller = Seller::where('email', $request->email)
                    ->orWhere('phone', $request->phone)
                    ->first();
                    
        if ($existingSeller) {
            Log::warning('Duplicate seller found', [
                'existing_seller_id' => $existingSeller->id,
                'existing_email' => $existingSeller->email,
                'existing_phone' => $existingSeller->phone,
                'requested_email' => $request->email,
                'requested_phone' => $request->phone
            ]);
        } else {
            Log::info('No duplicate sellers found');
        }
        
        return $existingSeller;
    }

    /**
     * Upload file and return path
     */
    private function uploadFile($file, $directory)
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($directory, $filename, 'public');
    }

    /**
     * Handle document uploads
     */
    private function handleDocumentUploads(Request $request, Seller $seller, $documentRequirements)
    {
        try {
            $uploadedFiles = [];
            
            Log::info('Processing document uploads for seller', [
                'seller_id' => $seller->id,
                'document_requirements_count' => $documentRequirements->count()
            ]);
            
            foreach ($documentRequirements as $doc) {
                $fieldName = 'documents.' . $doc->id; // Laravel array notation for accessing files
                $hasFile = $request->hasFile('documents') && isset($request->file('documents')[$doc->id]);
                
                Log::info('Checking for document upload', [
                    'field_name' => $fieldName,
                    'document_name' => $doc->document_name,
                    'has_file' => $hasFile
                ]);
                
                if ($hasFile) {
                    $file = $request->file('documents')[$doc->id];
                    
                    // Validate file
                    if (!$file->isValid()) {
                        Log::warning('Invalid file upload', [
                            'field_name' => $fieldName,
                            'error' => $file->getError()
                        ]);
                        continue;
                    }
                    
                    $filename = time() . '_' . $doc->id . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    
                    try {
                        $path = $file->storeAs('sellers/documents', $filename, 'public');
                        $uploadedFiles[] = $path; // Track for cleanup on error
                        
                        // Create record in seller_documents table
                        SellerDocument::create([
                            'seller_id' => $seller->id,
                            'document_type' => $doc->document_name,
                            'document_path' => $path,
                            'original_filename' => $file->getClientOriginalName(),
                            'file_size' => $file->getSize(),
                            'mime_type' => $file->getMimeType(),
                            'verification_status' => DocumentStatus::PENDING,
                            'is_mandatory' => $doc->is_required ?? true,
                            'uploaded_at' => now(),
                        ]);
                        
                        Log::info('Document uploaded successfully', [
                            'document_name' => $doc->document_name,
                            'file_path' => $path,
                            'file_size' => $file->getSize()
                        ]);
                        
                    } catch (\Exception $e) {
                        Log::error('Failed to upload document', [
                            'document_name' => $doc->document_name,
                            'error' => $e->getMessage()
                        ]);
                        throw $e;
                    }
                }
            }
            
            Log::info('Document upload process completed', [
                'seller_id' => $seller->id
            ]);
            
        } catch (\Exception $e) {
            // Cleanup uploaded files on error
            foreach ($uploadedFiles as $filePath) {
                try {
                    Storage::disk('public')->delete($filePath);
                } catch (\Exception $cleanupError) {
                    Log::warning('Failed to cleanup uploaded file', [
                        'file_path' => $filePath,
                        'error' => $cleanupError->getMessage()
                    ]);
                }
            }
            
            Log::error('Document upload process failed', [
                'seller_id' => $seller->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            throw $e;
        }
    }

    /**
     * Get the maximum POST size in bytes
     */
    private function getMaxPostSize()
    {
        $postMaxSize = ini_get('post_max_size');
        
        if (is_numeric($postMaxSize)) {
            return (int) $postMaxSize;
        }
        
        $suffix = strtoupper(substr($postMaxSize, -1));
        $value = (int) substr($postMaxSize, 0, -1);
        
        switch ($suffix) {
            case 'G':
                return $value * 1024 * 1024 * 1024;
            case 'M':
                return $value * 1024 * 1024;
            case 'K':
                return $value * 1024;
            default:
                return $value;
        }
    }
}
