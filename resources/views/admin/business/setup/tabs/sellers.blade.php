<!-- Sellers Tab -->
<div class="tab-pane fade {{ $activeTab === 'sellers' ? 'show active' : '' }}" id="sellers" role="tabpanel" aria-labelledby="sellers-tab">
    <div class="p-4">
        <!-- Page Header -->
        <div class="page-header mb-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 >
                        <i class="fas fa-users-cog text-primary me-3"></i>
                        Seller Management Settings
                    </h4>
                    <p class="page-subtitle text-muted mb-0">
                        Configure seller registration, approval process, and document verification requirements.
                    </p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="header-actions">
                        <button type="button" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save All Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Seller Registration Settings -->
        <div class="modern-card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">
                            <i class="fas fa-user-plus text-primary me-2"></i>
                            Registration Settings
                        </h5>
                        <p class="card-subtitle mb-0">Configure how sellers can register and join your platform</p>
                    </div>
                    <div class="header-badge">
                        <span class="badge bg-primary">Active</span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="settings-section">
                            <h6 class="settings-section-title">
                                <i class="fas fa-toggle-on text-success me-2"></i>
                                Registration Controls
                            </h6>
                            <div class="settings-items">
                                <div class="setting-item">
                                    <div class="setting-item-content">
                                        <div class="setting-item-info">
                                            <h6 class="setting-item-title">Allow Seller Registration</h6>
                                            <p class="setting-item-description">Enable new sellers to register on your platform</p>
                                        </div>
                                        <div class="setting-item-control">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="allow_seller_registration" name="allow_seller_registration" checked>
                                                <label class="form-check-label" for="allow_seller_registration"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="setting-item">
                                    <div class="setting-item-content">
                                        <div class="setting-item-info">
                                            <h6 class="setting-item-title">Require Admin Approval</h6>
                                            <p class="setting-item-description">New sellers need admin approval before they can start selling</p>
                                        </div>
                                        <div class="setting-item-control">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="require_seller_approval" name="require_seller_approval" checked>
                                                <label class="form-check-label" for="require_seller_approval"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="setting-item">
                                    <div class="setting-item-content">
                                        <div class="setting-item-info">
                                            <h6 class="setting-item-title">Require Document Verification</h6>
                                            <p class="setting-item-description">Sellers must upload and verify business documents</p>
                                        </div>
                                        <div class="setting-item-control">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="require_seller_verification" name="require_seller_verification" checked>
                                                <label class="form-check-label" for="require_seller_verification"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="settings-section">
                            <h6 class="settings-section-title">
                                <i class="fas fa-calculator text-info me-2"></i>
                                Fee Structure
                            </h6>
                            <div class="settings-items">
                                <div class="form-group">
                                    <label for="seller_registration_fee" class="form-label">
                                        <i class="fas fa-rupee-sign text-success me-1"></i>
                                        Registration Fee
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" class="form-control" id="seller_registration_fee" name="seller_registration_fee" value="0" min="0" step="0.01" placeholder="0.00">
                                    </div>
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        One-time fee for seller registration (0 for free registration)
                                    </small>
                                </div>
                                
                                <div class="form-group">
                                    <label for="seller_monthly_fee" class="form-label">
                                        <i class="fas fa-calendar-alt text-warning me-1"></i>
                                        Monthly Subscription Fee
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" class="form-control" id="seller_monthly_fee" name="seller_monthly_fee" value="0" min="0" step="0.01" placeholder="0.00">
                                    </div>
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Monthly fee for maintaining seller account (0 for free)
                                    </small>
                                </div>
                                
                                <div class="form-group">
                                    <label for="max_products_per_seller" class="form-label">
                                        <i class="fas fa-boxes text-primary me-1"></i>
                                        Max Products per Seller
                                    </label>
                                    <input type="number" class="form-control" id="max_products_per_seller" name="max_products_per_seller" value="1000" min="1" placeholder="1000">
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Maximum number of products a seller can list
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            </div>
        </div>

        <!-- Seller Verification Setup -->
        <div class="modern-card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">
                            <i class="fas fa-shield-alt text-primary me-2"></i>
                            Document Verification Setup
                        </h5>
                        <p class="card-subtitle mb-0">Configure document requirements for different seller types during registration</p>
                    </div>
                    <div class="header-badge">
                        <span class="badge bg-success">Configured</span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="verification-overview">
                            <p class="text-muted mb-4">
                                <i class="fas fa-info-circle me-2"></i>
                                Configure which documents are required for different seller types (gold dealer, diamond dealer, etc.) to ensure proper verification during registration.
                            </p>
                            
                            <div class="verification-actions">
                                <div class="action-buttons">
                                    <button type="button" class="btn btn-primary btn-lg me-3" id="configure-documents-btn">
                                        <i class="fas fa-cog me-2"></i>
                                        Configure Documents
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-lg">
                                        <i class="fas fa-eye me-2"></i>
                                        View Requirements
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="verification-sidebar">
                            <div class="quick-info-card">
                                <h6 class="quick-info-title">
                                    <i class="fas fa-lightbulb text-warning me-2"></i>
                                    Quick Tips
                                </h6>
                                <ul class="quick-info-list">
                                    <li>
                                        <i class="fas fa-check text-success me-2"></i>
                                        Configure mandatory documents for each seller type
                                    </li>
                                    <li>
                                        <i class="fas fa-check text-success me-2"></i>
                                        Set verification requirements based on business type
                                    </li>
                                    <li>
                                        <i class="fas fa-check text-success me-2"></i>
                                        Enable AI-powered document verification
                                    </li>
                                    <li>
                                        <i class="fas fa-check text-success me-2"></i>
                                        Track verification status and compliance
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        
    </div>

    <!-- Include Document Configuration Modal -->
    @include('admin.business.setup.modals.document-configuration')
</div>
