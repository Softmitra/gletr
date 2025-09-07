@extends('layouts.marketplace')

@section('title', 'Become a Gletr Seller')
@section('meta_description', 'Join our curated marketplace and share your unique jewelry with the world.')

@push('styles')
<style>
    :root {
        --primary-color: #6366F1;
        --secondary-color: #4F46E5;
    }
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
</style>
@endpush

@section('content')
<main class="flex-1 bg-white">
    <div class="container mx-auto px-6 py-16">
        <div class="max-w-3xl mx-auto text-center">
            <h4 class="text-4xl md:text-4xl font-bold text-gray-900 mb-4">Become a Gletr Seller</h4>
            <p class="text-lg text-gray-600 mb-12">Join our curated marketplace and share your unique jewelry with the world.</p>
                    </div>
                    
        <div class="max-w-4xl mx-auto bg-gray-50 rounded-2xl p-8 md:p-12 shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-1">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Getting Started</h2>
                    <p class="text-gray-500">Follow these steps to set up your seller account.</p>
                </div>
                
                <div class="md:col-span-2">
                    <div class="space-y-10">
                        <!-- Step 1 - Active -->
                        <div class="flex items-start gap-6">
                            <div class="flex-shrink-0 w-12 h-12 bg-indigo-100 text-[var(--primary-color)] rounded-full flex items-center justify-center">
                                <span class="material-symbols-outlined text-3xl">person</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-1">1. Create Your Profile</h3>
                                <p class="text-gray-600 mb-4">Tell us about yourself and your brand. This information will be displayed on your public seller page.</p>
                                <a href="{{ route('seller.register') }}" class="font-semibold text-[var(--primary-color)] hover:text-[var(--secondary-color)] flex items-center gap-2 transition-colors">
                                    <span>Create Profile</span>
                                    <span class="material-symbols-outlined">arrow_forward</span>
                                </a>
                        </div>
                    </div>
                    
                        <!-- Step 2 - Inactive -->
                        <div class="flex items-start gap-6 opacity-50">
                            <div class="flex-shrink-0 w-12 h-12 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center">
                                <span class="material-symbols-outlined text-3xl">storefront</span>
                    </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-1">2. Set Up Your Shop</h3>
                                <p class="text-gray-600">Customize your shop's appearance, add a banner, and set your policies.</p>
        </div>
    </div>
    
                        <!-- Step 3 - Inactive -->
                        <div class="flex items-start gap-6 opacity-50">
                            <div class="flex-shrink-0 w-12 h-12 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center">
                                <span class="material-symbols-outlined text-3xl">diamond</span>
        </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-1">3. List Your Products</h3>
                                <p class="text-gray-600">Start uploading your beautiful jewelry. Add high-quality photos and detailed descriptions.</p>
            </div>
        </div>
        
                        <!-- Step 4 - Inactive -->
                        <div class="flex items-start gap-6 opacity-50">
                            <div class="flex-shrink-0 w-12 h-12 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center">
                                <span class="material-symbols-outlined text-3xl">account_balance</span>
                </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-1">4. Link Payout Method</h3>
                                <p class="text-gray-600">Connect your bank account to receive payments for your sales securely.</p>
                    </div>
                </div>
            </div>
        </div>
            </div>
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('seller.register') }}" class="bg-[var(--primary-color)] text-white font-semibold py-3 px-8 rounded-lg hover:bg-[var(--secondary-color)] transition-colors text-lg inline-block">
                Start Selling
            </a>
        </div>
    </div>
</main>
@endsection
