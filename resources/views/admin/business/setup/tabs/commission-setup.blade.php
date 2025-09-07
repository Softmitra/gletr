<!-- Commission Setup Tab -->
<div class="tab-pane fade {{ $activeTab === 'commission-setup' ? 'show active' : '' }}" id="commission-setup" role="tabpanel" aria-labelledby="commission-setup-tab">
    <div class="p-4">
        <div class="modern-card">
            <div class="card-header">
                <h4 class="card-title">
                    <i class="fas fa-percentage text-primary"></i>
                    Commission Structure
                </h4>
                <p class="card-subtitle">Configure commission rates and payout settings for sellers.</p>
            </div>
            <div class="card-body">
            <form action="{{ route('admin.business.setup.commission-setup.update') }}" method="POST" data-form-type="commission-setup">
                @csrf
                @method('PUT')
                
            </form>
            </div>
        </div>

        <!-- Default Commission Settings -->
        <div class="modern-card mb-4">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-cogs text-primary"></i>
                    Default Commission Settings
                </h5>
            </div>
            <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="commission_type">Commission Type <span class="text-danger">*</span></label>
                                    <select class="form-control" id="commission_type" name="commission_type" required>
                                        <option value="percentage" selected>Percentage (%)</option>
                                        <option value="fixed">Fixed Amount (₹)</option>
                                    </select>
                                    <small class="text-muted">Choose how commission is calculated</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="default_commission">Default Commission Rate <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="default_commission" name="default_commission" value="10" min="0" max="100" step="0.01" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text commission-symbol">%</span>
                                        </div>
                                    </div>
                                    <small class="text-muted">Default commission rate for all products</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="minimum_commission">Minimum Commission (₹)</label>
                                    <input type="number" class="form-control" id="minimum_commission" name="minimum_commission" value="5" min="0" step="0.01">
                                    <small class="text-muted">Minimum commission amount per transaction</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="maximum_commission">Maximum Commission (₹)</label>
                                    <input type="number" class="form-control" id="maximum_commission" name="maximum_commission" value="1000" min="0" step="0.01">
                                    <small class="text-muted">Maximum commission amount per transaction (0 for unlimited)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Category-wise Commission -->
        <div class="modern-card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">
                    <i class="fas fa-tags text-primary"></i>
                    Category-wise Commission
                </h5>
                <button type="button" class="btn btn-sm btn-outline-primary" id="add-category-commission">
                    <i class="fas fa-plus me-1"></i>Add Category
                </button>
            </div>
            <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="category-commission-table">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Commission Rate</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select class="form-control" name="category_commissions[0][category_id]">
                                                <option value="1">Electronics</option>
                                                <option value="2">Fashion</option>
                                                <option value="3">Home & Garden</option>
                                                <option value="4">Sports & Outdoors</option>
                                                <option value="5">Books</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="category_commissions[0][rate]" value="15" min="0" step="0.01">
                                        </td>
                                        <td>
                                            <select class="form-control" name="category_commissions[0][type]">
                                                <option value="percentage" selected>Percentage</option>
                                                <option value="fixed">Fixed</option>
                                            </select>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-danger remove-category-commission">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Payout Settings -->
        <div class="modern-card mb-4">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-money-check-alt text-primary"></i>
                    Payout Settings
                </h5>
            </div>
            <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="minimum_payout">Minimum Payout Amount (₹) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="minimum_payout" name="minimum_payout" value="500" min="0" step="0.01" required>
                                    <small class="text-muted">Minimum amount required to process payout</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="payout_schedule">Payout Schedule</label>
                                    <select class="form-control" id="payout_schedule" name="payout_schedule">
                                        <option value="weekly" selected>Weekly</option>
                                        <option value="bi-weekly">Bi-weekly</option>
                                        <option value="monthly">Monthly</option>
                                        <option value="manual">Manual</option>
                                    </select>
                                    <small class="text-muted">How often payouts are processed</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="payout_delay_days">Payout Delay (Days)</label>
                                    <input type="number" class="form-control" id="payout_delay_days" name="payout_delay_days" value="7" min="0" max="30">
                                    <small class="text-muted">Days to wait after order completion before payout</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="payout_method">Default Payout Method</label>
                                    <select class="form-control" id="payout_method" name="payout_method">
                                        <option value="bank_transfer" selected>Bank Transfer</option>
                                        <option value="paypal">PayPal</option>
                                        <option value="upi">UPI</option>
                                        <option value="wallet">Digital Wallet</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Commission Calculation Settings -->
        <div class="modern-card mb-4">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-calculator text-primary"></i>
                    Commission Calculation
                </h5>
            </div>
            <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="include_shipping_in_commission" name="include_shipping_in_commission">
                                    <label class="form-check-label" for="include_shipping_in_commission">
                                        <strong>Include Shipping in Commission</strong>
                                        <br><small class="text-muted">Calculate commission on shipping charges as well</small>
                                    </label>
                                </div>
                                
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="include_tax_in_commission" name="include_tax_in_commission" checked>
                                    <label class="form-check-label" for="include_tax_in_commission">
                                        <strong>Include Tax in Commission</strong>
                                        <br><small class="text-muted">Calculate commission on tax amount</small>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="deduct_refund_commission" name="deduct_refund_commission" checked>
                                    <label class="form-check-label" for="deduct_refund_commission">
                                        <strong>Deduct Commission on Refunds</strong>
                                        <br><small class="text-muted">Deduct commission when orders are refunded</small>
                                    </label>
                                </div>
                                
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="commission_on_partial_refund" name="commission_on_partial_refund" checked>
                                    <label class="form-check-label" for="commission_on_partial_refund">
                                        <strong>Adjust Commission on Partial Refunds</strong>
                                        <br><small class="text-muted">Proportionally adjust commission for partial refunds</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Additional Fees -->
        <div class="modern-card mb-4">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-receipt text-primary"></i>
                    Additional Fees
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.business.setup.commission-setup.update') }}" method="POST" data-form-type="commission-setup">
                    @csrf
                    @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="transaction_fee">Transaction Fee (₹)</label>
                                    <input type="number" class="form-control" id="transaction_fee" name="transaction_fee" value="2" min="0" step="0.01">
                                    <small class="text-muted">Fixed fee per transaction</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="listing_fee">Product Listing Fee (₹)</label>
                                    <input type="number" class="form-control" id="listing_fee" name="listing_fee" value="0" min="0" step="0.01">
                                    <small class="text-muted">Fee charged for listing each product</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="payment_processing_fee">Payment Processing Fee (%)</label>
                                    <input type="number" class="form-control" id="payment_processing_fee" name="payment_processing_fee" value="2.5" min="0" max="10" step="0.01">
                                    <small class="text-muted">Percentage fee for payment processing</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="refund_processing_fee">Refund Processing Fee (₹)</label>
                                    <input type="number" class="form-control" id="refund_processing_fee" name="refund_processing_fee" value="10" min="0" step="0.01">
                                    <small class="text-muted">Fixed fee for processing refunds</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Commission Settings
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Update commission symbol based on type
    $('#commission_type').on('change', function() {
        const symbol = $(this).val() === 'percentage' ? '%' : '₹';
        $('.commission-symbol').text(symbol);
    });
    
    // Add new category commission row
    $('#add-category-commission').on('click', function() {
        const rowCount = $('#category-commission-table tbody tr').length;
        const newRow = `
            <tr>
                <td>
                    <select class="form-control" name="category_commissions[${rowCount}][category_id]">
                        <option value="1">Electronics</option>
                        <option value="2">Fashion</option>
                        <option value="3">Home & Garden</option>
                        <option value="4">Sports & Outdoors</option>
                        <option value="5">Books</option>
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control" name="category_commissions[${rowCount}][rate]" value="10" min="0" step="0.01">
                </td>
                <td>
                    <select class="form-control" name="category_commissions[${rowCount}][type]">
                        <option value="percentage" selected>Percentage</option>
                        <option value="fixed">Fixed</option>
                    </select>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger remove-category-commission">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        $('#category-commission-table tbody').append(newRow);
    });
    
    // Remove category commission row
    $(document).on('click', '.remove-category-commission', function() {
        if ($('#category-commission-table tbody tr').length > 1) {
            $(this).closest('tr').remove();
        } else {
            Swal.fire('Error', 'At least one category commission must be configured.', 'error');
        }
    });
});
</script>
@endpush
