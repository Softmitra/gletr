<!-- Website Setup Tab -->
<div class="tab-pane fade {{ $activeTab === 'website-setup' ? 'show active' : '' }}" id="website-setup" role="tabpanel" aria-labelledby="website-setup-tab">
    <div class="p-4">
        <div class="modern-card">
            <div class="card-header">
                <h4 class="card-title">
                    <i class="fas fa-globe text-primary"></i>
                    Website Configuration
                </h4>
                <p class="card-subtitle">Configure your website settings and SEO information.</p>
            </div>
            <div class="card-body">
            <form action="{{ route('admin.business.setup.website-setup.update') }}" method="POST" data-form-type="website-setup">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="site_title">Site Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="site_title" name="site_title" value="Vijaa - Multi-Vendor Marketplace" required>
                            <small class="text-muted">This will appear in browser title bar and search results</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="site_tagline">Site Tagline</label>
                            <input type="text" class="form-control" id="site_tagline" name="site_tagline" value="Your One-Stop Shopping Destination">
                            <small class="text-muted">Short description of your website</small>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="site_description">Site Description <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="site_description" name="site_description" rows="3" required>Vijaa is a comprehensive multi-vendor marketplace offering a wide range of products from trusted sellers. Shop with confidence and discover amazing deals on electronics, fashion, home goods, and more.</textarea>
                    <small class="text-muted">This description will be used for SEO meta tags (max 160 characters recommended)</small>
                </div>

                <div class="form-group mb-3">
                    <label for="site_keywords">SEO Keywords</label>
                    <input type="text" class="form-control" id="site_keywords" name="site_keywords" value="marketplace, ecommerce, online shopping, multi-vendor, vijaa">
                    <small class="text-muted">Comma-separated keywords for SEO (e.g., marketplace, ecommerce, shopping)</small>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="default_language">Default Language</label>
                            <select class="form-control" id="default_language" name="default_language">
                                <option value="en" selected>English</option>
                                <option value="hi">Hindi</option>
                                <option value="es">Spanish</option>
                                <option value="fr">French</option>
                                <option value="de">German</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="default_currency">Default Currency</label>
                            <select class="form-control" id="default_currency" name="default_currency">
                                <option value="INR" selected>INR (₹) - Indian Rupee</option>
                                <option value="USD">USD ($) - US Dollar</option>
                                <option value="EUR">EUR (€) - Euro</option>
                                <option value="GBP">GBP (£) - British Pound</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="date_format">Date Format</label>
                            <select class="form-control" id="date_format" name="date_format">
                                <option value="d/m/Y" selected>DD/MM/YYYY (Indian Format)</option>
                                <option value="m/d/Y">MM/DD/YYYY (US Format)</option>
                                <option value="Y-m-d">YYYY-MM-DD (ISO Format)</option>
                                <option value="d-M-Y">DD-MMM-YYYY</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="time_format">Time Format</label>
                            <select class="form-control" id="time_format" name="time_format">
                                <option value="12" selected>12 Hour (AM/PM)</option>
                                <option value="24">24 Hour</option>
                            </select>
                        </div>
                    </div>
                </div>

            </form>
            </div>
        </div>

        <!-- Website Features -->
        <div class="modern-card mt-4">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-puzzle-piece text-primary"></i>
                    Website Features
                </h5>
            </div>
            <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="enable_reviews" name="enable_reviews" checked>
                                    <label class="form-check-label" for="enable_reviews">
                                        Enable Product Reviews
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="enable_wishlist" name="enable_wishlist" checked>
                                    <label class="form-check-label" for="enable_wishlist">
                                        Enable Wishlist
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="enable_compare" name="enable_compare" checked>
                                    <label class="form-check-label" for="enable_compare">
                                        Enable Product Compare
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="enable_guest_checkout" name="enable_guest_checkout">
                                    <label class="form-check-label" for="enable_guest_checkout">
                                        Enable Guest Checkout
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="enable_newsletter" name="enable_newsletter" checked>
                                    <label class="form-check-label" for="enable_newsletter">
                                        Enable Newsletter Subscription
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="enable_social_login" name="enable_social_login">
                                    <label class="form-check-label" for="enable_social_login">
                                        Enable Social Media Login
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Logo and Favicon Upload -->
        <div class="modern-card mt-4">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-palette text-primary"></i>
                    Branding
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.business.setup.website-setup.update') }}" method="POST" data-form-type="website-setup" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="site_logo">Site Logo</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="site_logo" name="site_logo" accept="image/*">
                                        <label class="custom-file-label" for="site_logo">Choose logo file...</label>
                                    </div>
                                    <small class="text-muted">Recommended size: 200x60px, PNG or JPG format</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="site_favicon">Favicon</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="site_favicon" name="site_favicon" accept="image/*">
                                        <label class="custom-file-label" for="site_favicon">Choose favicon file...</label>
                                    </div>
                                    <small class="text-muted">Recommended size: 32x32px, ICO or PNG format</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-4 text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Website Settings
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
