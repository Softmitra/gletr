<!-- Document Configuration Modal -->
<div class="modal fade" id="documentConfigModal" tabindex="-1" aria-labelledby="documentConfigModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content" style="max-height: 90vh;">
            <div class="modal-header border-0 pb-0">
                <div class="w-100">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="modal-title fw-bold text-dark mb-1" id="documentConfigModalLabel" style="font-size: 18px;">
                                Seller document configuration
                            </h4>
                            <p class="text-muted mb-0" style="font-size: 14px;">Configure which documents are required for different seller types during registration.</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-primary btn-sm" id="manageTypesBtn">
                                <i class="fas fa-cog me-1"></i>
                                Manage types
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal" id="mainModalCloseBtn">
                                <i class="fas fa-times me-1"></i>
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body pt-3" style="max-height: 70vh; overflow-y: auto;">
                <!-- Add new document requirement -->
                <div class="mb-4">
                    <h5 class="fw-bold text-dark mb-3" style="font-size: 16px;">Add new document requirement</h5>
                    
                    <form id="addDocumentRequirementForm">
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="document_name" class="form-label fw-semibold" style="font-size: 14px;">Document name</label>
                                <input type="text" class="form-control" id="document_name" name="document_name" placeholder="Enter document name" style="font-size: 14px;">
                            </div>
                            <div class="col-md-6">
                                <label for="document_type" class="form-label fw-semibold" style="font-size: 14px;">Document Type</label>
                                <select class="form-control" id="document_type" name="document_type" style="font-size: 14px; min-height: 38px;">
                                    <option value="">Select options</option>
                                    <option value="business_license">Business License</option>
                                    <option value="gst_certificate">GST Certificate</option>
                                    <option value="bis_hallmark_license">BIS Hallmark License</option>
                                    <option value="gold_dealer_license">Gold Dealer License</option>
                                    <option value="diamond_certification">Diamond Certification</option>
                                    <option value="import_export_license">Import Export License</option>
                                    <option value="gemological_certificates">Gemological Certificates</option>
                                    <option value="identity_proof">Identity Proof</option>
                                    <option value="address_proof">Address Proof</option>
                                    <option value="bank_documents">Bank Documents</option>
                                </select>
                            </div>
                        </div>
                        
                                                 <div class="row g-3 mb-4">
                             <div class="col-md-12">
                                 <label class="form-label fw-semibold" style="font-size: 14px;">Applicable seller types</label>
                                 <div class="seller-types-checkboxes" style="border: 1px solid #dee2e6; border-radius: 0.375rem; padding: 15px; background-color: #f8f9fa;">
                                     <div class="row">
                                         <div class="col-md-6">
                                             <div class="form-check mb-2">
                                                 <input class="form-check-input" type="checkbox" id="seller_type_gold_dealer" name="applicable_seller_types[]" value="gold_dealer">
                                                 <label class="form-check-label" for="seller_type_gold_dealer" style="font-size: 14px;">Gold Dealer</label>
                                             </div>
                                             <div class="form-check mb-2">
                                                 <input class="form-check-input" type="checkbox" id="seller_type_diamond_dealer" name="applicable_seller_types[]" value="diamond_dealer">
                                                 <label class="form-check-label" for="seller_type_diamond_dealer" style="font-size: 14px;">Diamond Dealer</label>
                                             </div>
                                             <div class="form-check mb-2">
                                                 <input class="form-check-input" type="checkbox" id="seller_type_general_jewelry" name="applicable_seller_types[]" value="general_jewelry">
                                                 <label class="form-check-label" for="seller_type_general_jewelry" style="font-size: 14px;">General Jewelry</label>
                                             </div>
                                             <div class="form-check mb-2">
                                                 <input class="form-check-input" type="checkbox" id="seller_type_artisan_craftsman" name="applicable_seller_types[]" value="artisan_craftsman">
                                                 <label class="form-check-label" for="seller_type_artisan_craftsman" style="font-size: 14px;">Artisan/Craftsman</label>
                                             </div>
                                             <div class="form-check mb-2">
                                                 <input class="form-check-input" type="checkbox" id="seller_type_platinum_dealer" name="applicable_seller_types[]" value="platinum_dealer">
                                                 <label class="form-check-label" for="seller_type_platinum_dealer" style="font-size: 14px;">Platinum Dealer</label>
                                             </div>
                                         </div>
                                         <div class="col-md-6">
                                             <div class="form-check mb-2">
                                                 <input class="form-check-input" type="checkbox" id="seller_type_silver_dealer" name="applicable_seller_types[]" value="silver_dealer">
                                                 <label class="form-check-label" for="seller_type_silver_dealer" style="font-size: 14px;">Silver Dealer</label>
                                             </div>
                                             <div class="form-check mb-2">
                                                 <input class="form-check-input" type="checkbox" id="seller_type_gemstone_dealer" name="applicable_seller_types[]" value="gemstone_dealer">
                                                 <label class="form-check-label" for="seller_type_gemstone_dealer" style="font-size: 14px;">Gemstone Dealer</label>
                                             </div>
                                             <div class="form-check mb-2">
                                                 <input class="form-check-input" type="checkbox" id="seller_type_watch_dealer" name="applicable_seller_types[]" value="watch_dealer">
                                                 <label class="form-check-label" for="seller_type_watch_dealer" style="font-size: 14px;">Watch Dealer</label>
                                             </div>
                                             <div class="form-check mb-2">
                                                 <input class="form-check-input" type="checkbox" id="seller_type_antique_jewelry" name="applicable_seller_types[]" value="antique_jewelry">
                                                 <label class="form-check-label" for="seller_type_antique_jewelry" style="font-size: 14px;">Antique Jewelry</label>
                                             </div>
                                             <div class="form-check mb-2">
                                                 <input class="form-check-input" type="checkbox" id="seller_type_costume_jewelry" name="applicable_seller_types[]" value="costume_jewelry">
                                                 <label class="form-check-label" for="seller_type_costume_jewelry" style="font-size: 14px;">Costume Jewelry</label>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <small class="form-text text-muted" style="font-size: 12px;">
                                     <i class="fas fa-info-circle me-1"></i>
                                     Select all applicable seller types for this document requirement
                                 </small>
                             </div>
                         </div>
                        
                        <div class="row g-3 mb-4">
                            <div class="col-md-8">
                                <label for="description" class="form-label fw-semibold" style="font-size: 14px;">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter document description" style="font-size: 14px;"></textarea>
                            </div>
                            <div class="col-md-4 d-flex flex-column justify-content-between">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_mandatory" name="is_mandatory">
                                    <label class="form-check-label fw-semibold" for="is_mandatory" style="font-size: 14px;">
                                        Mandatory document
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-primary w-100" style="font-size: 14px;">
                                    <i class="fas fa-plus me-2"></i>
                                    Add requirement
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Configured document requirements -->
                <div class="mb-4">
                    <h5 class="fw-bold text-dark mb-3" style="font-size: 16px;">Configured document requirements</h5>
                    
                    <div class="table-responsive">
                        <table class="table table-hover" style="font-size: 14px;">
                            <thead class="table-light">
                                <tr>
                                    <th class="fw-semibold" style="width: 25%;">Document name</th>
                                    <th class="fw-semibold" style="width: 20%;">Document Type</th>
                                    <th class="fw-semibold" style="width: 40%;">Applicable seller types</th>
                                    <th class="fw-semibold" style="width: 15%;">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="documentRequirementsTable">
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p class="mt-2 text-muted">Loading document requirements...</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Document Requirement Modal -->
<div class="modal fade" id="editDocumentModal" tabindex="-1" aria-labelledby="editDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content" style="max-height: 90vh;">
            <div class="modal-header border-0 pb-0">
                <div class="w-100">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="modal-title fw-bold text-dark mb-1" id="editDocumentModalLabel" style="font-size: 18px;">
                                Edit Document Requirement
                            </h4>
                            <p class="text-muted mb-0" style="font-size: 14px;">Update document requirement details</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal" id="editModalCloseBtn">
                                <i class="fas fa-times me-1"></i>
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body pt-3" style="max-height: 70vh; overflow-y: auto;">
                <form id="editDocumentRequirementForm">
                    <input type="hidden" id="edit_document_id" name="document_id">
                    
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="edit_document_name" class="form-label fw-semibold" style="font-size: 14px;">Document name</label>
                            <input type="text" class="form-control" id="edit_document_name" name="document_name" placeholder="Enter document name" style="font-size: 14px;">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_document_type" class="form-label fw-semibold" style="font-size: 14px;">Document Type</label>
                            <select class="form-control" id="edit_document_type" name="document_type" style="font-size: 14px; min-height: 38px;">
                                <option value="">Select options</option>
                                <option value="business_license">Business License</option>
                                <option value="gst_certificate">GST Certificate</option>
                                <option value="bis_hallmark_license">BIS Hallmark License</option>
                                <option value="gold_dealer_license">Gold Dealer License</option>
                                <option value="diamond_certification">Diamond Certification</option>
                                <option value="import_export_license">Import Export License</option>
                                <option value="gemological_certificates">Gemological Certificates</option>
                                <option value="identity_proof">Identity Proof</option>
                                <option value="address_proof">Address Proof</option>
                                <option value="bank_documents">Bank Documents</option>
                            </select>
                        </div>
                    </div>
                    
                                         <div class="row g-3 mb-4">
                         <div class="col-md-12">
                             <label class="form-label fw-semibold" style="font-size: 14px;">Applicable seller types</label>
                             <div class="seller-types-checkboxes" style="border: 1px solid #dee2e6; border-radius: 0.375rem; padding: 15px; background-color: #f8f9fa;">
                                 <div class="row">
                                     <div class="col-md-6">
                                         <div class="form-check mb-2">
                                             <input class="form-check-input" type="checkbox" id="edit_seller_type_gold_dealer" name="applicable_seller_types[]" value="gold_dealer">
                                             <label class="form-check-label" for="edit_seller_type_gold_dealer" style="font-size: 14px;">Gold Dealer</label>
                                         </div>
                                         <div class="form-check mb-2">
                                             <input class="form-check-input" type="checkbox" id="edit_seller_type_diamond_dealer" name="applicable_seller_types[]" value="diamond_dealer">
                                             <label class="form-check-label" for="edit_seller_type_diamond_dealer" style="font-size: 14px;">Diamond Dealer</label>
                                         </div>
                                         <div class="form-check mb-2">
                                             <input class="form-check-input" type="checkbox" id="edit_seller_type_general_jewelry" name="applicable_seller_types[]" value="general_jewelry">
                                             <label class="form-check-label" for="edit_seller_type_general_jewelry" style="font-size: 14px;">General Jewelry</label>
                                         </div>
                                         <div class="form-check mb-2">
                                             <input class="form-check-input" type="checkbox" id="edit_seller_type_artisan_craftsman" name="applicable_seller_types[]" value="artisan_craftsman">
                                             <label class="form-check-label" for="edit_seller_type_artisan_craftsman" style="font-size: 14px;">Artisan/Craftsman</label>
                                         </div>
                                         <div class="form-check mb-2">
                                             <input class="form-check-input" type="checkbox" id="edit_seller_type_platinum_dealer" name="applicable_seller_types[]" value="platinum_dealer">
                                             <label class="form-check-label" for="edit_seller_type_platinum_dealer" style="font-size: 14px;">Platinum Dealer</label>
                                         </div>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="form-check mb-2">
                                             <input class="form-check-input" type="checkbox" id="edit_seller_type_silver_dealer" name="applicable_seller_types[]" value="silver_dealer">
                                             <label class="form-check-label" for="edit_seller_type_silver_dealer" style="font-size: 14px;">Silver Dealer</label>
                                         </div>
                                         <div class="form-check mb-2">
                                             <input class="form-check-input" type="checkbox" id="edit_seller_type_gemstone_dealer" name="applicable_seller_types[]" value="gemstone_dealer">
                                             <label class="form-check-label" for="edit_seller_type_gemstone_dealer" style="font-size: 14px;">Gemstone Dealer</label>
                                         </div>
                                         <div class="form-check mb-2">
                                             <input class="form-check-input" type="checkbox" id="edit_seller_type_watch_dealer" name="applicable_seller_types[]" value="watch_dealer">
                                             <label class="form-check-label" for="edit_seller_type_watch_dealer" style="font-size: 14px;">Watch Dealer</label>
                                         </div>
                                         <div class="form-check mb-2">
                                             <input class="form-check-input" type="checkbox" id="edit_seller_type_antique_jewelry" name="applicable_seller_types[]" value="antique_jewelry">
                                             <label class="form-check-label" for="edit_seller_type_antique_jewelry" style="font-size: 14px;">Antique Jewelry</label>
                                         </div>
                                         <div class="form-check mb-2">
                                             <input class="form-check-input" type="checkbox" id="edit_seller_type_costume_jewelry" name="applicable_seller_types[]" value="costume_jewelry">
                                             <label class="form-check-label" for="edit_seller_type_costume_jewelry" style="font-size: 14px;">Costume Jewelry</label>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <small class="form-text text-muted" style="font-size: 12px;">
                                 <i class="fas fa-info-circle me-1"></i>
                                 Select all applicable seller types for this document requirement
                             </small>
                         </div>
                     </div>
                    
                    <div class="row g-3 mb-4">
                        <div class="col-md-8">
                            <label for="edit_description" class="form-label fw-semibold" style="font-size: 14px;">Description</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="3" placeholder="Enter document description" style="font-size: 14px;"></textarea>
                        </div>
                        <div class="col-md-4 d-flex flex-column justify-content-between">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="edit_is_mandatory" name="is_mandatory">
                                <label class="form-check-label fw-semibold" for="edit_is_mandatory" style="font-size: 14px;">
                                    Mandatory document
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100" style="font-size: 14px;">
                                <i class="fas fa-save me-2"></i>
                                Update requirement
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Manage Types Modal -->
<div class="modal fade" id="manageTypesModal" tabindex="-1" aria-labelledby="manageTypesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content" style="max-height: 90vh;">
            <div class="modal-header border-0 pb-0">
                <div class="w-100">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="modal-title fw-bold text-dark mb-1" id="manageTypesModalLabel" style="font-size: 18px;">
                                Manage Document & Seller Types
                            </h4>
                            <p class="text-muted mb-0" style="font-size: 14px;">Add, edit, or remove document types and seller types</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal" id="manageTypesCloseBtn">
                                <i class="fas fa-times me-1"></i>
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body pt-3" style="max-height: 70vh; overflow-y: auto;">
                <!-- Tabs for Document Types and Seller Types -->
                <ul class="nav nav-tabs" id="manageTypesTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="document-types-tab" data-tab="document-types" type="button" role="tab" aria-controls="document-types" aria-selected="true">
                            <i class="fas fa-file-alt me-2"></i>Document Types
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="seller-types-tab" data-tab="seller-types" type="button" role="tab" aria-controls="seller-types" aria-selected="false">
                            <i class="fas fa-users me-2"></i>Seller Types
                        </button>
                    </li>
                </ul>
                
                <div class="tab-content" id="manageTypesTabContent">
                    <!-- Document Types Tab -->
                    <div class="tab-pane fade show active" id="document-types" role="tabpanel" aria-labelledby="document-types-tab">
                        <div class="mt-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold text-dark mb-0" style="font-size: 16px;">Document Types</h5>
                                <button type="button" class="btn btn-primary btn-sm" id="addDocumentTypeBtn">
                                    <i class="fas fa-plus me-1"></i>Add New Type
                                </button>
                            </div>
                            
                            <!-- Add Document Type Form -->
                            <div class="mb-4" id="addDocumentTypeForm" style="display: none;">
                                <form id="documentTypeForm">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="doc_type_key" class="form-label fw-semibold" style="font-size: 14px;">Type Key</label>
                                            <input type="text" class="form-control" id="doc_type_key" name="type_key" placeholder="e.g., passport_copy" style="font-size: 14px;">
                                            <small class="text-muted">Unique identifier (lowercase, underscores only)</small>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="doc_type_name" class="form-label fw-semibold" style="font-size: 14px;">Display Name</label>
                                            <input type="text" class="form-control" id="doc_type_name" name="type_name" placeholder="e.g., Passport Copy" style="font-size: 14px;">
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex gap-2">
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fas fa-save me-1"></i>Save Type
                                                </button>
                                                <button type="button" class="btn btn-secondary btn-sm" id="cancelDocTypeBtn">
                                                    <i class="fas fa-times me-1"></i>Cancel
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            
                            <!-- Document Types List -->
                            <div class="table-responsive">
                                <table class="table table-hover" style="font-size: 14px;">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="fw-semibold">Type Key</th>
                                            <th class="fw-semibold">Display Name</th>
                                            <th class="fw-semibold" style="width: 100px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="documentTypesTable">
                                        <tr>
                                            <td>business_license</td>
                                            <td>Business License</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-danger" disabled>
                                                    <i class="fas fa-lock"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>gst_certificate</td>
                                            <td>GST Certificate</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-danger" disabled>
                                                    <i class="fas fa-lock"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>bis_hallmark_license</td>
                                            <td>BIS Hallmark License</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-danger" disabled>
                                                    <i class="fas fa-lock"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>gold_dealer_license</td>
                                            <td>Gold Dealer License</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-danger" disabled>
                                                    <i class="fas fa-lock"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>diamond_certification</td>
                                            <td>Diamond Certification</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-danger" disabled>
                                                    <i class="fas fa-lock"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>identity_proof</td>
                                            <td>Identity Proof</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-danger" disabled>
                                                    <i class="fas fa-lock"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>address_proof</td>
                                            <td>Address Proof</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-danger" disabled>
                                                    <i class="fas fa-lock"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>bank_documents</td>
                                            <td>Bank Documents</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-danger" disabled>
                                                    <i class="fas fa-lock"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Default document types are protected and cannot be deleted. You can add custom types.
                            </small>
                        </div>
                    </div>
                    
                    <!-- Seller Types Tab -->
                    <div class="tab-pane fade" id="seller-types" role="tabpanel" aria-labelledby="seller-types-tab">
                        <div class="mt-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold text-dark mb-0" style="font-size: 16px;">Seller Types</h5>
                                <button type="button" class="btn btn-primary btn-sm" id="addSellerTypeBtn">
                                    <i class="fas fa-plus me-1"></i>Add New Type
                                </button>
                            </div>
                            
                            <!-- Add Seller Type Form -->
                            <div class="mb-4" id="addSellerTypeForm" style="display: none;">
                                <form id="sellerTypeForm">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="seller_type_key" class="form-label fw-semibold" style="font-size: 14px;">Type Key</label>
                                            <input type="text" class="form-control" id="seller_type_key" name="type_key" placeholder="e.g., precious_stone_dealer" style="font-size: 14px;">
                                            <small class="text-muted">Unique identifier (lowercase, underscores only)</small>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="seller_type_name" class="form-label fw-semibold" style="font-size: 14px;">Display Name</label>
                                            <input type="text" class="form-control" id="seller_type_name" name="type_name" placeholder="e.g., Precious Stone Dealer" style="font-size: 14px;">
                                        </div>
                                        <div class="col-12">
                                            <label for="seller_type_desc" class="form-label fw-semibold" style="font-size: 14px;">Description</label>
                                            <textarea class="form-control" id="seller_type_desc" name="description" rows="2" placeholder="Brief description of this seller type" style="font-size: 14px;"></textarea>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex gap-2">
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fas fa-save me-1"></i>Save Type
                                                </button>
                                                <button type="button" class="btn btn-secondary btn-sm" id="cancelSellerTypeBtn">
                                                    <i class="fas fa-times me-1"></i>Cancel
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            
                            <!-- Seller Types List -->
                            <div class="table-responsive">
                                <table class="table table-hover" style="font-size: 14px;">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="fw-semibold">Type Key</th>
                                            <th class="fw-semibold">Display Name</th>
                                            <th class="fw-semibold">Description</th>
                                            <th class="fw-semibold" style="width: 100px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sellerTypesTable">
                                        <tr>
                                            <td>gold_dealer</td>
                                            <td>Gold Dealer</td>
                                            <td>Dealers specializing in gold jewelry and ornaments</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-danger" disabled>
                                                    <i class="fas fa-lock"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>diamond_dealer</td>
                                            <td>Diamond Dealer</td>
                                            <td>Dealers specializing in diamond jewelry</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-danger" disabled>
                                                    <i class="fas fa-lock"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>general_jewelry</td>
                                            <td>General Jewelry</td>
                                            <td>General jewelry dealers with mixed products</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-danger" disabled>
                                                    <i class="fas fa-lock"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>artisan_craftsman</td>
                                            <td>Artisan/Craftsman</td>
                                            <td>Individual artisans and craftsmen</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-danger" disabled>
                                                    <i class="fas fa-lock"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>platinum_dealer</td>
                                            <td>Platinum Dealer</td>
                                            <td>Dealers specializing in platinum jewelry</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-danger" disabled>
                                                    <i class="fas fa-lock"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>silver_dealer</td>
                                            <td>Silver Dealer</td>
                                            <td>Dealers specializing in silver jewelry</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-danger" disabled>
                                                    <i class="fas fa-lock"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Default seller types are protected and cannot be deleted. You can add custom types.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom scrollbar styles */
.modal-body::-webkit-scrollbar {
    width: 8px;
}

.modal-body::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.modal-body::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 4px;
}

.modal-body::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Ensure table is responsive within scrollable area */
.table-responsive {
    max-width: 100%;
    overflow-x: auto;
}

/* Smooth scrolling */
.modal-body {
    scroll-behavior: smooth;
}

/* Fix for modal height on smaller screens */
@media (max-height: 600px) {
    .modal-content {
        max-height: 95vh !important;
    }
    
    .modal-body {
        max-height: 60vh !important;
    }
}

/* Ensure close button is visible and clickable */
.modal-header .btn {
    z-index: 1050;
    position: relative;
}

.modal-header .btn-outline-secondary {
    border-color: #6c757d;
    color: #6c757d;
}

.modal-header .btn-outline-secondary:hover {
    background-color: #6c757d;
    color: white;
}

/* Fix modal backdrop issues */
.modal-backdrop {
    z-index: 1040;
}

.modal {
    z-index: 1050;
}

/* Tab styling improvements */
.nav-tabs {
    border-bottom: 2px solid #dee2e6;
    margin-bottom: 0;
}

.nav-tabs .nav-link {
    border: none;
    border-bottom: 3px solid transparent;
    color: #6c757d;
    font-weight: 500;
    padding: 12px 20px;
    transition: all 0.3s ease;
}

.nav-tabs .nav-link:hover {
    border-bottom-color: #007bff;
    color: #007bff;
    background-color: transparent;
}

.nav-tabs .nav-link.active {
    color: #007bff;
    background-color: transparent;
    border-bottom-color: #007bff;
    font-weight: 600;
}

.tab-content {
    padding-top: 20px;
}

/* Form improvements */
#addDocumentTypeForm, #addSellerTypeForm {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configure documents button click handler
    const configureBtn = document.getElementById('configure-documents-btn');
    if (configureBtn) {
        configureBtn.addEventListener('click', function() {
            const modal = new bootstrap.Modal(document.getElementById('documentConfigModal'));
            modal.show();
            loadDocumentRequirements(); // Load documents when modal opens
        });
    }
    
    // Add document requirement form submission
    const form = document.getElementById('addDocumentRequirementForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
                                         // Get form data
                const formData = {
                    document_name: document.getElementById('document_name').value,
                    document_type: document.getElementById('document_type').value,
                    applicable_seller_types: Array.from(document.querySelectorAll('#documentConfigModal input[name="applicable_seller_types[]"]:checked')).map(checkbox => checkbox.value),
                    description: document.getElementById('description').value,
                    is_mandatory: document.getElementById('is_mandatory').checked
                };
            
            // Validate form
            if (!formData.document_name || !formData.document_type || formData.applicable_seller_types.length === 0) {
                alert('Please fill in all required fields');
                return;
            }
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Adding...';
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
            
            // Make API call using fetch
            fetch('/admin/document-requirements', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Add new row to table
                    const newRow = createDocumentRequirementRow(data.data);
                    document.getElementById('documentRequirementsTable').insertAdjacentHTML('beforeend', newRow);
                    
                    // Reset form
                    form.reset();
                    // Uncheck all checkboxes
                    document.querySelectorAll('#documentConfigModal input[name="applicable_seller_types[]"]').forEach(checkbox => checkbox.checked = false);
                    
                    showToast('Document requirement added successfully!', 'success');
                } else {
                    showToast('Error adding document requirement', 'error');
                }
            })
            .catch(error => {
                showToast('Error adding document requirement: ' + error.message, 'error');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });
    }
    
    // Edit document requirement
    document.addEventListener('click', function(e) {
        if (e.target.closest('.edit-document-btn')) {
            const documentId = e.target.closest('.edit-document-btn').dataset.documentId;
            editDocumentRequirement(documentId);
        }
    });
    
    // Delete document requirement
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-document-btn')) {
            const documentId = e.target.closest('.delete-document-btn').dataset.documentId;
            deleteDocumentRequirement(documentId);
        }
    });
    
    // Handle modal close buttons - improved
    document.addEventListener('click', function(e) {
        if (e.target.closest('[data-bs-dismiss="modal"]')) {
            e.preventDefault();
            const button = e.target.closest('[data-bs-dismiss="modal"]');
            const modalElement = button.closest('.modal');
            
            console.log('Close button clicked', modalElement.id);
            
            if (modalElement) {
                // Try multiple methods to close the modal
                let modal = bootstrap.Modal.getInstance(modalElement);
                if (!modal) {
                    modal = new bootstrap.Modal(modalElement);
                }
                
                try {
                    modal.hide();
                } catch (error) {
                    console.error('Error hiding modal:', error);
                    // Force close
                    forceCloseModal(modalElement);
                }
            }
        }
    });
    
    // Force close modal function
    function forceCloseModal(modalElement) {
        modalElement.style.display = 'none';
        modalElement.classList.remove('show');
        modalElement.setAttribute('aria-hidden', 'true');
        modalElement.removeAttribute('aria-modal');
        
        // Remove backdrop
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove();
        }
        
        // Remove modal-open class from body
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
    }
    
    // Direct event listeners for modal close buttons
    document.addEventListener('click', function(e) {
        if (e.target && e.target.id === 'editModalCloseBtn') {
            console.log('Edit modal close button clicked');
            const editModalElement = document.getElementById('editDocumentModal');
            forceCloseModal(editModalElement);
        }
        
        if (e.target && e.target.id === 'mainModalCloseBtn') {
            console.log('Main modal close button clicked');
            const mainModalElement = document.getElementById('documentConfigModal');
            forceCloseModal(mainModalElement);
        }
        
        if (e.target && e.target.id === 'manageTypesCloseBtn') {
            console.log('Manage types modal close button clicked');
            const manageTypesModalElement = document.getElementById('manageTypesModal');
            forceCloseModal(manageTypesModalElement);
        }
    });
    
    // Manage Types button click handler
    document.addEventListener('click', function(e) {
        if (e.target && e.target.id === 'manageTypesBtn') {
            console.log('Manage types button clicked');
            const manageTypesModal = new bootstrap.Modal(document.getElementById('manageTypesModal'));
            manageTypesModal.show();
        }
    });
    
    // Tab switching functionality
    document.addEventListener('click', function(e) {
        if (e.target.closest('[data-tab]')) {
            const tabButton = e.target.closest('[data-tab]');
            const targetTab = tabButton.dataset.tab;
            
            console.log('Tab clicked:', targetTab);
            
            // Remove active class from all tabs and content
            document.querySelectorAll('#manageTypesTab .nav-link').forEach(tab => {
                tab.classList.remove('active');
                tab.setAttribute('aria-selected', 'false');
            });
            
            document.querySelectorAll('#manageTypesTabContent .tab-pane').forEach(pane => {
                pane.classList.remove('show', 'active');
            });
            
            // Add active class to clicked tab
            tabButton.classList.add('active');
            tabButton.setAttribute('aria-selected', 'true');
            
            // Show corresponding content
            const targetContent = document.getElementById(targetTab);
            if (targetContent) {
                targetContent.classList.add('show', 'active');
            }
        }
    });
    
    // Add Document Type button handler
    document.addEventListener('click', function(e) {
        if (e.target && e.target.id === 'addDocumentTypeBtn') {
            const form = document.getElementById('addDocumentTypeForm');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
        
        if (e.target && e.target.id === 'cancelDocTypeBtn') {
            const form = document.getElementById('addDocumentTypeForm');
            form.style.display = 'none';
            document.getElementById('documentTypeForm').reset();
        }
    });
    
    // Add Seller Type button handler
    document.addEventListener('click', function(e) {
        if (e.target && e.target.id === 'addSellerTypeBtn') {
            const form = document.getElementById('addSellerTypeForm');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
        
        if (e.target && e.target.id === 'cancelSellerTypeBtn') {
            const form = document.getElementById('addSellerTypeForm');
            form.style.display = 'none';
            document.getElementById('sellerTypeForm').reset();
        }
    });
    
    // Document Type Form submission
    document.addEventListener('submit', function(e) {
        if (e.target && e.target.id === 'documentTypeForm') {
            e.preventDefault();
            
            const typeKey = document.getElementById('doc_type_key').value.trim();
            const typeName = document.getElementById('doc_type_name').value.trim();
            
            if (!typeKey || !typeName) {
                showToast('Please fill in all required fields', 'error');
                return;
            }
            
            // Validate type key format
            if (!/^[a-z_]+$/.test(typeKey)) {
                showToast('Type key must contain only lowercase letters and underscores', 'error');
                return;
            }
            
            // Add to table (in real implementation, this would be saved to database)
            const tableBody = document.getElementById('documentTypesTable');
            const newRow = `
                <tr>
                    <td>${typeKey}</td>
                    <td>${typeName}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-danger delete-custom-type" data-type="${typeKey}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            tableBody.insertAdjacentHTML('beforeend', newRow);
            
            // Reset form and hide
            document.getElementById('documentTypeForm').reset();
            document.getElementById('addDocumentTypeForm').style.display = 'none';
            
            showToast('Document type added successfully!', 'success');
        }
    });
    
    // Seller Type Form submission
    document.addEventListener('submit', function(e) {
        if (e.target && e.target.id === 'sellerTypeForm') {
            e.preventDefault();
            
            const typeKey = document.getElementById('seller_type_key').value.trim();
            const typeName = document.getElementById('seller_type_name').value.trim();
            const description = document.getElementById('seller_type_desc').value.trim();
            
            if (!typeKey || !typeName) {
                showToast('Please fill in all required fields', 'error');
                return;
            }
            
            // Validate type key format
            if (!/^[a-z_]+$/.test(typeKey)) {
                showToast('Type key must contain only lowercase letters and underscores', 'error');
                return;
            }
            
            // Add to table (in real implementation, this would be saved to database)
            const tableBody = document.getElementById('sellerTypesTable');
            const newRow = `
                <tr>
                    <td>${typeKey}</td>
                    <td>${typeName}</td>
                    <td>${description || 'No description provided'}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-danger delete-custom-type" data-type="${typeKey}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            tableBody.insertAdjacentHTML('beforeend', newRow);
            
            // Reset form and hide
            document.getElementById('sellerTypeForm').reset();
            document.getElementById('addSellerTypeForm').style.display = 'none';
            
            showToast('Seller type added successfully!', 'success');
        }
    });
    
    // Delete custom type handler
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-custom-type')) {
            const button = e.target.closest('.delete-custom-type');
            const typeKey = button.dataset.type;
            
            if (confirm(`Are you sure you want to delete the type "${typeKey}"?`)) {
                button.closest('tr').remove();
                showToast('Type deleted successfully!', 'success');
            }
        }
    });
    
    // Function to edit document requirement
    function editDocumentRequirement(documentId) {
        // Fetch document data by ID
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
        
        fetch('/admin/document-requirements/' + documentId, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Populate form with existing data
                populateEditForm(data.data);
                
                // Show edit modal
                const editModal = new bootstrap.Modal(document.getElementById('editDocumentModal'));
                editModal.show();
            } else {
                showToast('Error loading document data', 'error');
            }
        })
        .catch(error => {
            showToast('Error loading document data: ' + error.message, 'error');
        });
    }
    
    // Function to populate edit form with existing data
    function populateEditForm(data) {
        document.getElementById('edit_document_id').value = data.id;
        document.getElementById('edit_document_name').value = data.document_name;
        document.getElementById('edit_document_type').value = data.document_type;
        document.getElementById('edit_description').value = data.description || '';
        document.getElementById('edit_is_mandatory').checked = data.is_mandatory;
        
        // Handle checkboxes for seller types
        // Clear all checkboxes first
        document.querySelectorAll('#editDocumentModal input[name="applicable_seller_types[]"]').forEach(checkbox => {
            checkbox.checked = false;
        });
        
        // Set checkboxes based on data
        if (data.applicable_seller_types && data.applicable_seller_types.length > 0) {
            data.applicable_seller_types.forEach(type => {
                const checkbox = document.querySelector(`#editDocumentModal input[name="applicable_seller_types[]"][value="${type}"]`);
                if (checkbox) {
                    checkbox.checked = true;
                }
            });
        }
    }
    
    // Edit document requirement form submission
    const editForm = document.getElementById('editDocumentRequirementForm');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = editForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
                         // Get form data
             const formData = {
                 document_name: document.getElementById('edit_document_name').value,
                 document_type: document.getElementById('edit_document_type').value,
                 applicable_seller_types: Array.from(document.querySelectorAll('#editDocumentModal input[name="applicable_seller_types[]"]:checked')).map(checkbox => checkbox.value),
                 description: document.getElementById('edit_description').value,
                 is_mandatory: document.getElementById('edit_is_mandatory').checked
             };
            
            const documentId = document.getElementById('edit_document_id').value;
            
            // Validate form
            if (!formData.document_name || !formData.document_type || formData.applicable_seller_types.length === 0) {
                alert('Please fill in all required fields');
                return;
            }
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
            
            // Make API call using fetch
                            fetch('/admin/document-requirements/' + documentId, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the row in the table
                    updateTableRow(documentId, data.data);
                    
                    // Close modal after successful update
                    const editModalElement = document.getElementById('editDocumentModal');
                    console.log('Closing edit modal after update');
                    
                    try {
                        let editModal = bootstrap.Modal.getInstance(editModalElement);
                        if (!editModal) {
                            editModal = new bootstrap.Modal(editModalElement);
                        }
                        editModal.hide();
                    } catch (error) {
                        console.error('Error closing modal:', error);
                        // Use force close as fallback
                        forceCloseModal(editModalElement);
                    }
                    
                    showToast('Document requirement updated successfully!', 'success');
                } else {
                    showToast('Error updating document requirement', 'error');
                }
            })
            .catch(error => {
                showToast('Error updating document requirement: ' + error.message, 'error');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });
    }
    
    // Function to update table row with new data
    function updateTableRow(documentId, data) {
        const row = document.querySelector(`tr[data-document-id="${documentId}"]`);
        if (row) {
            const sellerTypes = data.applicable_seller_types.map(type => 
                `<span class="badge bg-primary" style="font-size: 11px;">${getSellerTypeDisplay(type)}</span>`
            ).join('');
            
            const mandatoryBadge = data.is_mandatory ? '<span class="badge bg-warning ms-2">Mandatory</span>' : '';
            
            row.innerHTML = `
                <td style="vertical-align: top;">
                    <div class="fw-semibold text-dark mb-1">${data.document_name}</div>${mandatoryBadge}
                    <small class="text-muted">${data.description || ''}</small>
                </td>
                <td style="vertical-align: top;">
                    <span class="badge bg-primary" style="font-size: 12px;">${getDocumentTypeDisplay(data.document_type)}</span>
                </td>
                <td style="vertical-align: top;">
                    <div class="d-flex flex-wrap gap-1">
                        ${sellerTypes}
                    </div>
                </td>
                <td style="vertical-align: top;">
                    <div class="d-flex gap-1">
                        <button type="button" class="btn btn-sm btn-outline-primary edit-document-btn" data-document-id="${data.id}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger delete-document-btn" data-document-id="${data.id}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            `;
        }
    }
    
    // Function to delete document requirement
    function deleteDocumentRequirement(documentId) {
        if (confirm('Are you sure you want to delete this document requirement?')) {
            const row = document.querySelector(`tr[data-document-id="${documentId}"]`);
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
            
            fetch('/admin/document-requirements/' + documentId, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    row.remove();
                    showToast('Document requirement deleted successfully!', 'success');
                } else {
                    showToast('Error deleting document requirement', 'error');
                }
            })
            .catch(error => {
                showToast('Error deleting document requirement: ' + error.message, 'error');
            });
        }
    }
    
    // Load document requirements from API
    function loadDocumentRequirements() {
        const tableBody = document.getElementById('documentRequirementsTable');
        console.log('Loading document requirements...');
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
        
        fetch('/admin/document-requirements', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);
            if (!response.ok) {
                return response.text().then(text => {
                    console.log('Error response:', text);
                    throw new Error(`HTTP ${response.status}: ${text}`);
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                tableBody.innerHTML = '';
                if (data.data && data.data.length > 0) {
                    data.data.forEach(function(requirement) {
                        const row = createDocumentRequirementRow(requirement);
                        tableBody.insertAdjacentHTML('beforeend', row);
                    });
                } else {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                <p class="text-muted">No document requirements found</p>
                                <small class="text-muted">Add your first document requirement above</small>
                            </td>
                        </tr>
                    `;
                }
            } else {
                throw new Error(data.message || 'Failed to load document requirements');
            }
        })
        .catch(error => {
            console.error('Error loading document requirements:', error);
            tableBody.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center py-4">
                        <i class="fas fa-exclamation-triangle fa-2x text-warning mb-2"></i>
                        <p class="text-danger">Error loading document requirements</p>
                        <small class="text-muted">${error.message}</small>
                        <br>
                        <button class="btn btn-sm btn-outline-primary mt-2" onclick="loadDocumentRequirements()">
                            <i class="fas fa-redo me-1"></i>Retry
                        </button>
                        <br>
                        <small class="text-muted mt-2 d-block">Check browser console for more details</small>
                    </td>
                </tr>
            `;
        });
    }
    
    // Helper function to create document requirement row
    function createDocumentRequirementRow(data) {
        const sellerTypes = data.applicable_seller_types.map(type => 
            `<span class="badge bg-primary" style="font-size: 11px;">${getSellerTypeDisplay(type)}</span>`
        ).join('');
        
        const mandatoryBadge = data.is_mandatory ? '<span class="badge bg-warning ms-2">Mandatory</span>' : '';
        
        return `
            <tr data-document-id="${data.id}">
                <td style="vertical-align: top;">
                    <div class="fw-semibold text-dark mb-1">${data.document_name}</div>${mandatoryBadge}
                    <small class="text-muted">${data.description || ''}</small>
                </td>
                <td style="vertical-align: top;">
                    <span class="badge bg-primary" style="font-size: 12px;">${getDocumentTypeDisplay(data.document_type)}</span>
                </td>
                <td style="vertical-align: top;">
                    <div class="d-flex flex-wrap gap-1">
                        ${sellerTypes}
                    </div>
                </td>
                <td style="vertical-align: top;">
                    <div class="d-flex gap-1">
                        <button type="button" class="btn btn-sm btn-outline-primary edit-document-btn" data-document-id="${data.id}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger delete-document-btn" data-document-id="${data.id}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    }
    
    // Helper function to get document type display name
    function getDocumentTypeDisplay(type) {
        const types = {
            'business_license': 'Business License',
            'gst_certificate': 'GST Certificate',
            'bis_hallmark_license': 'BIS Hallmark License',
            'gold_dealer_license': 'Gold Dealer License',
            'diamond_certification': 'Diamond Certification',
            'import_export_license': 'Import Export License',
            'gemological_certificates': 'Gemological Certificates',
            'identity_proof': 'Identity Proof',
            'address_proof': 'Address Proof',
            'bank_documents': 'Bank Documents'
        };
        return types[type] || type;
    }
    
    // Helper function to get seller type display name
    function getSellerTypeDisplay(type) {
        const types = {
            'gold_dealer': 'Gold Dealer',
            'diamond_dealer': 'Diamond Dealer',
            'general_jewelry': 'General Jewelry',
            'artisan_craftsman': 'Artisan/Craftsman',
            'platinum_dealer': 'Platinum Dealer',
            'silver_dealer': 'Silver Dealer',
            'gemstone_dealer': 'Gemstone Dealer',
            'watch_dealer': 'Watch Dealer',
            'antique_jewelry': 'Antique Jewelry',
            'costume_jewelry': 'Costume Jewelry'
        };
        return types[type] || type;
    }
    
    // Helper function to show toast notification
    function showToast(message, type = 'info') {
        // Create toast element
        const toastContainer = document.getElementById('toast-container') || createToastContainer();
        
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} border-0`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;
        
        toastContainer.appendChild(toast);
        
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 5000);
    }
    
    // Helper function to create toast container
    function createToastContainer() {
        const container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'toast-container position-fixed top-0 end-0 p-3';
        container.style.zIndex = '9999';
        document.body.appendChild(container);
        return container;
    }
});
</script>
