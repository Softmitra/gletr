<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentRequirement;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DocumentRequirementController extends Controller
{
    /**
     * Get all document requirements
     */
    public function index(): JsonResponse
    {
        $documentRequirements = DocumentRequirement::where('is_active', true)->get();
        
        return response()->json([
            'success' => true,
            'data' => $documentRequirements
        ]);
    }

    /**
     * Store a new document requirement
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'document_name' => 'required|string|max:255',
            'document_type' => 'required|string|max:255',
            'applicable_seller_types' => 'required|array',
            'description' => 'nullable|string',
            'is_mandatory' => 'boolean'
        ]);

        $documentRequirement = DocumentRequirement::create([
            'document_type' => $request->document_type,
            'document_name' => $request->document_name,
            'is_mandatory' => $request->boolean('is_mandatory'),
            'applicable_seller_types' => $request->applicable_seller_types,
            'description' => $request->description,
            'validation_rules' => null, // Can be added later if needed
            'is_active' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Document requirement created successfully',
            'data' => $documentRequirement
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(DocumentRequirement $documentRequirement): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $documentRequirement
        ]);
    }

    /**
     * Update a document requirement
     */
    public function update(Request $request, DocumentRequirement $documentRequirement): JsonResponse
    {
        $request->validate([
            'document_name' => 'required|string|max:255',
            'document_type' => 'required|string|max:255',
            'applicable_seller_types' => 'required|array',
            'description' => 'nullable|string',
            'is_mandatory' => 'boolean'
        ]);

        $documentRequirement->update([
            'document_type' => $request->document_type,
            'document_name' => $request->document_name,
            'is_mandatory' => $request->boolean('is_mandatory'),
            'applicable_seller_types' => $request->applicable_seller_types,
            'description' => $request->description
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Document requirement updated successfully',
            'data' => $documentRequirement
        ]);
    }

    /**
     * Delete a document requirement
     */
    public function destroy(DocumentRequirement $documentRequirement): JsonResponse
    {
        $documentRequirement->update(['is_active' => false]);

        return response()->json([
            'success' => true,
            'message' => 'Document requirement deleted successfully'
        ]);
    }

    /**
     * Get document types
     */
    public function getDocumentTypes(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => DocumentRequirement::DOCUMENT_TYPES
        ]);
    }

    /**
     * Get seller types
     */
    public function getSellerTypes(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => DocumentRequirement::SELLER_TYPES
        ]);
    }
}
