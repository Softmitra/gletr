@extends('layouts.marketplace')

@section('title', 'Secure Checkout - Gletr')
@section('description', 'Complete your jewelry purchase with our secure checkout process. Multiple payment options and guaranteed safe delivery.')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex items-center justify-center">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-yellow-500 text-white rounded-full flex items-center justify-center text-sm font-medium">1</div>
                        <span class="ml-2 text-sm font-medium text-gray-900">Cart</span>
                    </div>
                    <div class="w-12 h-px bg-yellow-500"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-yellow-500 text-white rounded-full flex items-center justify-center text-sm font-medium">2</div>
                        <span class="ml-2 text-sm font-medium text-gray-900">Checkout</span>
                    </div>
                    <div class="w-12 h-px bg-gray-300"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gray-300 text-white rounded-full flex items-center justify-center text-sm font-medium">3</div>
                        <span class="ml-2 text-sm font-medium text-gray-500">Payment</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Checkout Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Shipping Address -->
                <div class="luxury-card p-6">
                    <h2 class="heading-4 mb-6">Shipping Address</h2>
                    <form class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="form-label mb-1 block">First Name *</label>
                                <input type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-yellow-500" required>
                            </div>
                            <div>
                                <label class="form-label mb-1 block">Last Name *</label>
                                <input type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-yellow-500" required>
                            </div>
                        </div>
                        <div>
                            <label class="form-label mb-1 block">Email Address *</label>
                            <input type="email" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-yellow-500" required>
                        </div>
                        <div>
                            <label class="form-label mb-1 block">Phone Number *</label>
                            <input type="tel" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-yellow-500" required>
                        </div>
                        <div>
                            <label class="form-label mb-1 block">Address *</label>
                            <textarea rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-yellow-500" required></textarea>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="form-label mb-1 block">City *</label>
                                <input type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-yellow-500" required>
                            </div>
                            <div>
                                <label class="form-label mb-1 block">State *</label>
                                <select class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-yellow-500" required>
                                    <option value="">Select State</option>
                                    <option>Maharashtra</option>
                                    <option>Delhi</option>
                                    <option>Karnataka</option>
                                    <option>Gujarat</option>
                                    <option>Tamil Nadu</option>
                                </select>
                            </div>
                            <div>
                                <label class="form-label mb-1 block">PIN Code *</label>
                                <input type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-yellow-500" required>
                            </div>
                        </div>
                    </form>
                </div>
                
                <!-- Delivery Method -->
                <div class="luxury-card p-6">
                    <h2 class="heading-4 mb-6">Delivery Method</h2>
                    <div class="space-y-4">
                        <label class="flex items-center p-4 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                            <input type="radio" name="delivery" class="text-yellow-600 focus:ring-yellow-500" checked>
                            <div class="ml-3 flex-1">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="font-medium">Standard Delivery</div>
                                        <div class="text-sm text-gray-600">5-7 business days</div>
                                    </div>
                                    <div class="text-green-600 font-medium">Free</div>
                                </div>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                            <input type="radio" name="delivery" class="text-yellow-600 focus:ring-yellow-500">
                            <div class="ml-3 flex-1">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="font-medium">Express Delivery</div>
                                        <div class="text-sm text-gray-600">2-3 business days</div>
                                    </div>
                                    <div class="font-medium">₹500</div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
                
                <!-- Payment Options -->
                <div class="luxury-card p-6">
                    <h2 class="heading-4 mb-6">Payment Method</h2>
                    <div class="space-y-4">
                        <!-- UPI -->
                        <label class="flex items-center p-4 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                            <input type="radio" name="payment" class="text-yellow-600 focus:ring-yellow-500" checked>
                            <div class="ml-3 flex-1">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-green-100 rounded flex items-center justify-center mr-3">
                                        <span class="text-green-600 text-sm font-bold">UPI</span>
                                    </div>
                                    <div>
                                        <div class="font-medium">UPI Payment</div>
                                        <div class="text-sm text-gray-600">Pay using any UPI app</div>
                                    </div>
                                </div>
                            </div>
                        </label>
                        
                        <!-- Credit/Debit Card -->
                        <label class="flex items-center p-4 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                            <input type="radio" name="payment" class="text-yellow-600 focus:ring-yellow-500">
                            <div class="ml-3 flex-1">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 rounded flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium">Credit/Debit Card</div>
                                        <div class="text-sm text-gray-600">Visa, Mastercard, RuPay</div>
                                    </div>
                                </div>
                            </div>
                        </label>
                        
                        <!-- Cash on Delivery -->
                        <label class="flex items-center p-4 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                            <input type="radio" name="payment" class="text-yellow-600 focus:ring-yellow-500">
                            <div class="ml-3 flex-1">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-orange-100 rounded flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium">Cash on Delivery</div>
                                        <div class="text-sm text-gray-600">Pay when you receive</div>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="luxury-card p-6 sticky top-24">
                    <h3 class="heading-4 mb-6">Order Summary</h3>
                    
                    <!-- Items List -->
                    <div class="space-y-4 mb-6">
                        <div class="flex items-center">
                            <div class="w-16 h-16 bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg flex items-center justify-center mr-3">
                                <span class="text-lg">💍</span>
                            </div>
                            <div class="flex-1">
                                <div class="text-sm font-medium">Diamond Gold Ring</div>
                                <div class="text-xs text-gray-600">Size: 16, 22K Gold</div>
                            </div>
                            <div class="text-sm font-medium">₹45,011</div>
                        </div>
                        <div class="flex items-center">
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <span class="text-lg">📿</span>
                            </div>
                            <div class="flex-1">
                                <div class="text-sm font-medium">Diamond Necklace Set</div>
                                <div class="text-xs text-gray-600">18K Gold, 16 inches</div>
                            </div>
                            <div class="text-sm font-medium">₹89,999</div>
                        </div>
                        <div class="flex items-center">
                            <div class="w-16 h-16 bg-gradient-to-br from-pink-50 to-pink-100 rounded-lg flex items-center justify-center mr-3">
                                <span class="text-lg">👂</span>
                            </div>
                            <div class="flex-1">
                                <div class="text-sm font-medium">Rose Gold Earrings</div>
                                <div class="text-xs text-gray-600">18K Rose Gold</div>
                            </div>
                            <div class="text-sm font-medium">₹25,999</div>
                        </div>
                    </div>
                    
                    <!-- Price Summary -->
                    <div class="border-t border-gray-200 pt-6 space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal:</span>
                            <span class="font-medium">₹1,61,009</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Shipping:</span>
                            <span class="font-medium text-green-600">Free</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">GST (3%):</span>
                            <span class="font-medium">₹4,830</span>
                        </div>
                        <div class="border-t border-gray-200 pt-3">
                            <div class="flex justify-between">
                                <span class="text-lg font-semibold">Total:</span>
                                <span class="text-xl font-bold text-gray-900">₹1,65,839</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Place Order Button -->
                    <button class="luxury-button w-full text-lg py-4 mt-6">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Place Order Securely
                    </button>
                    
                    <!-- Trust Badges -->
                    <div class="mt-6 space-y-3">
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            256-bit SSL Encryption
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            PCI DSS Compliant
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            100% Authentic Guarantee
                        </div>
                    </div>
                    
                    <!-- Payment Security Icons -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="text-xs text-gray-500 text-center mb-3">Secured by:</div>
                        <div class="flex justify-center space-x-4">
                            <div class="w-12 h-8 bg-gray-100 rounded flex items-center justify-center">
                                <span class="text-xs font-bold text-blue-600">VISA</span>
                            </div>
                            <div class="w-12 h-8 bg-gray-100 rounded flex items-center justify-center">
                                <span class="text-xs font-bold text-red-600">MC</span>
                            </div>
                            <div class="w-12 h-8 bg-gray-100 rounded flex items-center justify-center">
                                <span class="text-xs font-bold text-orange-600">UPI</span>
                            </div>
                            <div class="w-12 h-8 bg-gray-100 rounded flex items-center justify-center">
                                <span class="text-xs font-bold text-green-600">SSL</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Additional Trust Section -->
        <div class="mt-12 bg-white rounded-xl p-8 border border-gray-200">
            <h3 class="heading-4 text-center mb-8">Why Shop with Confidence</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h4 class="heading-6 mb-2">Authentic Guarantee</h4>
                    <p class="text-body-sm text-gray-600">All jewelry is certified and authenticated by experts</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h4 class="heading-6 mb-2">Secure Payment</h4>
                    <p class="text-body-sm text-gray-600">Your payment information is protected with bank-level security</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </div>
                    <h4 class="heading-6 mb-2">Easy Returns</h4>
                    <p class="text-body-sm text-gray-600">30-day hassle-free return policy on all purchases</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Basic validation
    const requiredFields = this.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.classList.add('border-red-500');
            isValid = false;
        } else {
            field.classList.remove('border-red-500');
        }
    });
    
    if (isValid) {
        // Proceed to payment
        alert('Proceeding to payment... (Demo)');
    } else {
        alert('Please fill in all required fields.');
    }
});

// Payment method selection
document.querySelectorAll('input[name="payment"]').forEach(radio => {
    radio.addEventListener('change', function() {
        console.log('Payment method selected:', this.parentElement.querySelector('.font-medium').textContent);
    });
});

// Delivery method selection
document.querySelectorAll('input[name="delivery"]').forEach(radio => {
    radio.addEventListener('change', function() {
        console.log('Delivery method selected:', this.parentElement.querySelector('.font-medium').textContent);
        // Update total if express delivery is selected
        updateTotal();
    });
});

function updateTotal() {
    const expressDelivery = document.querySelector('input[name="delivery"]:checked').parentElement.querySelector('.font-medium').textContent.includes('Express');
    const totalElement = document.querySelector('.text-xl.font-bold');
    const baseTotal = 165839;
    const expressCharge = 500;
    
    if (expressDelivery) {
        totalElement.textContent = `₹${(baseTotal + expressCharge).toLocaleString('en-IN')}`;
    } else {
        totalElement.textContent = `₹${baseTotal.toLocaleString('en-IN')}`;
    }
}
</script>
@endpush
