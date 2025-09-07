@extends('layouts.marketplace')

@section('title', 'Shopping Cart - Gletr')
@section('description', 'Review your selected jewelry items and proceed to secure checkout with trusted payment options.')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="heading-2 mb-2">Shopping Cart</h1>
            <p class="text-body text-gray-600">Review your items and proceed to checkout</p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                <div class="luxury-card p-6">
                    <h2 class="heading-4 mb-6">Your Items (3)</h2>
                    
                    <!-- Cart Item 1 -->
                    <div class="flex items-center border-b border-gray-200 pb-6 mb-6">
                        <div class="w-24 h-24 bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg flex items-center justify-center mr-4">
                            <span class="text-2xl">💍</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="heading-6 mb-1">Diamond Gold Ring</h3>
                            <p class="text-caption text-gray-600 mb-2">by Premium Jewels</p>
                            <div class="flex items-center space-x-4 text-sm text-gray-600">
                                <span>22K Gold</span>
                                <span>Size: 16</span>
                                <span>VVS1 Diamond</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <!-- Quantity Selector -->
                            <div class="flex items-center border border-gray-300 rounded-lg">
                                <button class="px-3 py-2 hover:bg-gray-50">-</button>
                                <span class="px-4 py-2 border-x border-gray-300">1</span>
                                <button class="px-3 py-2 hover:bg-gray-50">+</button>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-bold">₹45,011</div>
                                <button class="text-red-600 hover:text-red-700 text-sm">Remove</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Cart Item 2 -->
                    <div class="flex items-center border-b border-gray-200 pb-6 mb-6">
                        <div class="w-24 h-24 bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg flex items-center justify-center mr-4">
                            <span class="text-2xl">📿</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="heading-6 mb-1">Diamond Necklace Set</h3>
                            <p class="text-caption text-gray-600 mb-2">by Royal Gems</p>
                            <div class="flex items-center space-x-4 text-sm text-gray-600">
                                <span>18K Gold</span>
                                <span>Length: 16 inches</span>
                                <span>SI1 Diamonds</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <!-- Quantity Selector -->
                            <div class="flex items-center border border-gray-300 rounded-lg">
                                <button class="px-3 py-2 hover:bg-gray-50">-</button>
                                <span class="px-4 py-2 border-x border-gray-300">1</span>
                                <button class="px-3 py-2 hover:bg-gray-50">+</button>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-bold">₹89,999</div>
                                <button class="text-red-600 hover:text-red-700 text-sm">Remove</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Cart Item 3 -->
                    <div class="flex items-center">
                        <div class="w-24 h-24 bg-gradient-to-br from-pink-50 to-pink-100 rounded-lg flex items-center justify-center mr-4">
                            <span class="text-2xl">👂</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="heading-6 mb-1">Rose Gold Earrings</h3>
                            <p class="text-caption text-gray-600 mb-2">by Elite Designs</p>
                            <div class="flex items-center space-x-4 text-sm text-gray-600">
                                <span>18K Rose Gold</span>
                                <span>Push Back</span>
                                <span>VS2 Diamonds</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <!-- Quantity Selector -->
                            <div class="flex items-center border border-gray-300 rounded-lg">
                                <button class="px-3 py-2 hover:bg-gray-50">-</button>
                                <span class="px-4 py-2 border-x border-gray-300">1</span>
                                <button class="px-3 py-2 hover:bg-gray-50">+</button>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-bold">₹25,999</div>
                                <button class="text-red-600 hover:text-red-700 text-sm">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Continue Shopping -->
                <div class="mt-8">
                    <a href="/products" class="luxury-gold hover:underline flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Continue Shopping
                    </a>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="luxury-card p-6 sticky top-24">
                    <h3 class="heading-4 mb-6">Order Summary</h3>
                    
                    <!-- Price Breakdown -->
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between text-body-sm">
                            <span class="text-gray-600">Subtotal (3 items):</span>
                            <span class="font-medium">₹1,61,009</span>
                        </div>
                        <div class="flex justify-between text-body-sm">
                            <span class="text-gray-600">Shipping:</span>
                            <span class="font-medium text-green-600">Free</span>
                        </div>
                        <div class="flex justify-between text-body-sm">
                            <span class="text-gray-600">GST (3%):</span>
                            <span class="font-medium">₹4,830</span>
                        </div>
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex justify-between">
                                <span class="text-lg font-semibold">Total:</span>
                                <span class="text-xl font-bold text-gray-900">₹1,65,839</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Promo Code -->
                    <div class="mb-6">
                        <label class="form-label mb-2 block">Promo Code</label>
                        <div class="flex">
                            <input 
                                type="text" 
                                placeholder="Enter code" 
                                class="flex-1 border border-gray-300 rounded-l-lg px-3 py-2 focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                            >
                            <button class="bg-gray-900 text-white px-4 py-2 rounded-r-lg hover:bg-gray-800">
                                Apply
                            </button>
                        </div>
                    </div>
                    
                    <!-- Checkout Button -->
                    <button class="luxury-button w-full text-lg py-4 mb-4">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Proceed to Checkout
                    </button>
                    
                    <!-- Trust Indicators -->
                    <div class="text-center space-y-2">
                        <div class="flex items-center justify-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            Secure Checkout
                        </div>
                        <div class="flex items-center justify-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Easy Returns
                        </div>
                        <div class="flex items-center justify-center text-sm text-gray-600">
                            <svg class="w-4 h-4 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Free Shipping
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recently Viewed -->
        <div class="mt-16">
            <h3 class="heading-3 mb-8">Recently Viewed</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @for($i = 1; $i <= 4; $i++)
                <div class="product-card">
                    <div class="w-full h-48 bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center">
                        <span class="text-3xl">{{ ['⌚', '💎', '🔗', '👂'][$i-1] }}</span>
                    </div>
                    <div class="p-4">
                        <h4 class="heading-6 mb-1">{{ ['Silver Watch', 'Diamond Studs', 'Gold Chain', 'Pearl Earrings'][$i-1] }}</h4>
                        <p class="text-caption text-gray-600 mb-2">{{ ['Luxury Craft', 'Diamond Palace', 'Golden Touch', 'Elite Designs'][$i-1] }}</p>
                        <div class="flex items-center justify-between">
                            <div class="text-lg font-bold text-gray-900">₹{{ number_format(20000 + $i * 15000) }}</div>
                            <button class="text-yellow-600 hover:text-yellow-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5-5M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Quantity controls
document.querySelectorAll('.flex.items-center.border button').forEach(button => {
    button.addEventListener('click', function() {
        const isIncrement = this.textContent.trim() === '+';
        const quantitySpan = this.parentElement.querySelector('span');
        let quantity = parseInt(quantitySpan.textContent);
        
        if (isIncrement) {
            quantity++;
        } else if (quantity > 1) {
            quantity--;
        }
        
        quantitySpan.textContent = quantity;
        
        // Update totals (simplified for demo)
        updateCartTotals();
    });
});

// Remove item
document.querySelectorAll('button').forEach(button => {
    if (button.textContent.includes('Remove')) {
        button.addEventListener('click', function() {
            if (confirm('Are you sure you want to remove this item?')) {
                this.closest('.flex.items-center.border-b').remove();
                updateCartTotals();
            }
        });
    }
});

function updateCartTotals() {
    // Simplified total calculation for demo
    console.log('Updating cart totals...');
    // In real implementation, this would recalculate all prices
}

// Promo code application
document.querySelector('.bg-gray-900').addEventListener('click', function() {
    const promoCode = this.previousElementSibling.value;
    if (promoCode) {
        // Simulate promo code validation
        alert(`Promo code "${promoCode}" applied! (Demo)`);
    }
});
</script>
@endpush
