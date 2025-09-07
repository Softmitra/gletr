<!-- General Tab -->
<div class="tab-pane fade {{ $activeTab === 'general' ? 'show active' : '' }}" id="general" role="tabpanel" aria-labelledby="general-tab">
    <div class="p-4">
        <!-- Page Header -->
        <div class="mb-4">
            <h4 class="fw-bold text-dark mb-1">General Setup</h4>
            <p class="text-muted mb-0" style="font-size: 14px;">Complete the basic settings for sellers</p>
        </div>

        <!-- General Settings -->
        <div class="bg-white rounded-3 p-4 mb-4" style="border: 1px solid #e9ecef;">
            <div class="row">
                <div class="col-lg-6">
                    <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div>
                            <h6 class="mb-1 fw-semibold" style="font-size: 15px;">Active Pos For Seller</h6>
                            <p class="mb-0 text-muted" style="font-size: 13px;">If enabled pos will be available on the seller panel</p>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="active_pos_for_seller" name="active_pos_for_seller">
                            <label class="form-check-label" for="active_pos_for_seller"></label>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center py-3">
                        <div>
                            <h6 class="mb-1 fw-semibold" style="font-size: 15px;">Minimum order amount</h6>
                            <p class="mb-0 text-muted" style="font-size: 13px;">If enabled sellers can set minimum order amount for their sellers</p>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="minimum_order_amount" name="minimum_order_amount">
                            <label class="form-check-label" for="minimum_order_amount"></label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div>
                            <h6 class="mb-1 fw-semibold" style="font-size: 15px;">Enable seller registration</h6>
                            <p class="mb-0 text-muted" style="font-size: 13px;">Enabling this option allows users to send requests to become registered</p>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="enable_seller_registration" name="enable_seller_registration" checked>
                            <label class="form-check-label" for="enable_seller_registration"></label>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center py-3">
                        <div>
                            <h6 class="mb-1 fw-semibold" style="font-size: 15px;">Seller can reply on review</h6>
                            <p class="mb-0 text-muted" style="font-size: 13px;">Enable this option to allow sellers to reply to customer reviews</p>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="seller_can_reply_review" name="seller_can_reply_review">
                            <label class="form-check-label" for="seller_can_reply_review"></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Seller Verification Setup -->
        <div class="mb-4">
            <h5 class="fw-bold text-dark mb-1" style="font-size: 16px;">Seller verification setup</h5>
            <p class="text-muted mb-3" style="font-size: 14px;">Configure document requirements for different seller types during registration.</p>
            
            <div class="bg-white rounded-3 p-4" style="border: 1px solid #e9ecef;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1 fw-semibold" style="font-size: 15px;">Seller document verification</h6>
                        <p class="mb-0 text-muted" style="font-size: 13px;">Configure which documents are required for different seller types (gold dealer, diamond dealer, etc.)</p>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="configure-documents-btn" style="font-size: 13px;">
                        <i class="fas fa-cog me-1"></i>
                        Configure documents
                    </button>
                </div>
            </div>
        </div>

        <!-- Forget Password Setup -->
        <div class="mb-4">
            <h5 class="fw-bold text-dark mb-1" style="font-size: 16px;">Forget password setup</h5>
            <p class="text-muted mb-3" style="font-size: 14px;">Setup how sellers can recover their forgotten passwords.</p>
            
            <div class="bg-white rounded-3 p-4" style="border: 1px solid #e9ecef;">
                <h6 class="mb-3 fw-semibold" style="font-size: 15px;">Select verification option</h6>
                <div class="verification-options">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="password_recovery_method" id="email_verification" value="email" checked>
                        <label class="form-check-label" for="email_verification" style="font-size: 14px;">
                            <span class="fw-semibold">Email Verification</span>
                            <br><small class="text-muted" style="font-size: 12px;">Send password reset link via email</small>
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="password_recovery_method" id="sms_verification" value="sms">
                        <label class="form-check-label" for="sms_verification" style="font-size: 14px;">
                            <span class="fw-semibold">SMS Verification</span>
                            <br><small class="text-muted" style="font-size: 12px;">Send verification code via SMS</small>
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="password_recovery_method" id="both_verification" value="both">
                        <label class="form-check-label" for="both_verification" style="font-size: 14px;">
                            <span class="fw-semibold">Both Email & SMS</span>
                            <br><small class="text-muted" style="font-size: 12px;">Allow sellers to choose their preferred method</small>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="text-center mt-4">
            <button type="button" class="btn btn-primary px-4 py-2">
                <i class="fas fa-save me-2"></i>
                Save All Changes
            </button>
        </div>

    </div>
</div>

