@extends('layouts.marketplace')

@section('title', 'Gletr - India\'s Premier Jewellery Marketplace')
@section('description', 'Join India\'s most trusted jewellery marketplace. Connect with verified sellers, discover authentic pieces, and experience the future of jewellery shopping.')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-yellow-50 to-yellow-100 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <div class="inline-block bg-yellow-600 text-white px-4 py-2 rounded-full text-sm font-semibold mb-4">
                    🚀 Now Launching - Join the Revolution!
                </div>
                <h4 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-6">
                    India's <span class="text-yellow-600">Premier</span><br>
                    Jewellery Marketplace
                </h4>
                <p class="text-xl text-gray-600 mb-8">
                    Where tradition meets technology. Gletr is revolutionizing how India discovers, buys, and sells authentic jewellery. Join thousands of verified sellers and millions of discerning customers.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('seller.promotion') }}" class="bg-yellow-600 text-white px-8 py-3 rounded-lg hover:bg-yellow-700 transition duration-300 text-center font-semibold">
                        Become a Seller
                    </a>
                    <a href="{{ route('categories.index') }}" class="border border-yellow-600 text-yellow-600 px-8 py-3 rounded-lg hover:bg-yellow-600 hover:text-white transition duration-300 text-center font-semibold">
                        Explore Categories
                    </a>
                </div>
            </div>
            <div class="relative">
                <img src="{{ asset('images/gletr_hero_banner.svg') }}" alt="Gletr Jewellery Marketplace" class="rounded-lg shadow-2xl">
                <div class="absolute -top-4 -right-4 bg-white p-4 rounded-lg shadow-lg">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-yellow-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <div>
                            <div class="text-sm font-bold">Coming Soon</div>
                            <div class="text-xs text-gray-500">Launching 2025</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h4 class="text-3xl font-bold text-gray-900 mb-4">Why Choose Gletr?</h2>
            <p class="text-xl text-gray-600">The future of jewellery commerce is here</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">100% Verified Sellers</h3>
                <p class="text-gray-600">Every seller undergoes rigorous verification. Only trusted, authenticated jewellery businesses join our platform.</p>
            </div>
            <div class="text-center">
                <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Blockchain Authentication</h3>
                <p class="text-gray-600">Advanced blockchain technology ensures every piece is traceable, authentic, and certified with digital hallmarks.</p>
            </div>
            <div class="text-center">
                <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Lightning Fast</h3>
                <p class="text-gray-600">Instant transactions, real-time inventory, and seamless shopping experience powered by cutting-edge technology.</p>
            </div>
        </div>
    </div>
</section>

<!-- Launch Benefits Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Early Bird Benefits</h2>
            <p class="text-xl text-gray-600">Join now and unlock exclusive advantages</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow-lg p-6 text-center hover:shadow-xl transition duration-300">
                <div class="bg-yellow-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl">🎯</span>
                </div>
                <h3 class="text-lg font-semibold mb-2">Zero Commission</h3>
                <p class="text-gray-600 text-sm">First 1000 sellers get 0% commission for 6 months</p>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg p-6 text-center hover:shadow-xl transition duration-300">
                <div class="bg-yellow-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl">⚡</span>
                </div>
                <h3 class="text-lg font-semibold mb-2">Priority Listing</h3>
                <p class="text-gray-600 text-sm">Your products appear first in search results</p>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg p-6 text-center hover:shadow-xl transition duration-300">
                <div class="bg-yellow-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl">🏆</span>
                </div>
                <h3 class="text-lg font-semibold mb-2">Featured Badge</h3>
                <p class="text-gray-600 text-sm">Get "Early Adopter" badge on your profile</p>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg p-6 text-center hover:shadow-xl transition duration-300">
                <div class="bg-yellow-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl">💎</span>
                </div>
                <h3 class="text-lg font-semibold mb-2">Premium Support</h3>
                <p class="text-gray-600 text-sm">Dedicated account manager for early sellers</p>
            </div>
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('seller.promotion') }}" class="bg-yellow-600 text-white px-8 py-3 rounded-lg hover:bg-yellow-700 transition duration-300 font-semibold">
                Claim Your Early Bird Benefits
            </a>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Coming Soon - Shop by Category</h2>
            <p class="text-xl text-gray-600">Be the first to explore these exclusive categories</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            <div class="group text-center">
                <div class="bg-gray-100 rounded-full w-20 h-20 mx-auto mb-4 flex items-center justify-center group-hover:bg-yellow-100 transition duration-300">
                    <span class="text-2xl">💍</span>
                </div>
                <h3 class="font-medium text-gray-900">Rings</h3>
                <p class="text-xs text-gray-500 mt-1">Engagement & Wedding</p>
            </div>
            
            <div class="group text-center">
                <div class="bg-gray-100 rounded-full w-20 h-20 mx-auto mb-4 flex items-center justify-center group-hover:bg-yellow-100 transition duration-300">
                    <span class="text-2xl">📿</span>
                </div>
                <h3 class="font-medium text-gray-900">Necklaces</h3>
                <p class="text-xs text-gray-500 mt-1">Traditional & Modern</p>
            </div>
            
            <div class="group text-center">
                <div class="bg-gray-100 rounded-full w-20 h-20 mx-auto mb-4 flex items-center justify-center group-hover:bg-yellow-100 transition duration-300">
                    <span class="text-2xl">👂</span>
                </div>
                <h3 class="font-medium text-gray-900">Earrings</h3>
                <p class="text-xs text-gray-500 mt-1">Studs & Drops</p>
            </div>
            
            <div class="group text-center">
                <div class="bg-gray-100 rounded-full w-20 h-20 mx-auto mb-4 flex items-center justify-center group-hover:bg-yellow-100 transition duration-300">
                    <span class="text-2xl">💫</span>
                </div>
                <h3 class="font-medium text-gray-900">Bracelets</h3>
                <p class="text-xs text-gray-500 mt-1">Bangles & Chains</p>
            </div>
            
            <div class="group text-center">
                <div class="bg-gray-100 rounded-full w-20 h-20 mx-auto mb-4 flex items-center justify-center group-hover:bg-yellow-100 transition duration-300">
                    <span class="text-2xl">💎</span>
                </div>
                <h3 class="font-medium text-gray-900">Diamonds</h3>
                <p class="text-xs text-gray-500 mt-1">Certified & Natural</p>
            </div>
            
            <div class="group text-center">
                <div class="bg-gray-100 rounded-full w-20 h-20 mx-auto mb-4 flex items-center justify-center group-hover:bg-yellow-100 transition duration-300">
                    <span class="text-2xl">🥇</span>
                </div>
                <h3 class="font-medium text-gray-900">Gold</h3>
                <p class="text-xs text-gray-500 mt-1">Hallmark Certified</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="py-16 bg-gradient-to-r from-yellow-600 to-yellow-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-white mb-6">Ready to Join the Revolution?</h2>
        <p class="text-xl text-yellow-100 mb-8 max-w-3xl mx-auto">
            Be part of India's most trusted jewellery marketplace. Connect with millions of customers, 
            showcase your authentic pieces, and grow your business with cutting-edge technology.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('seller.promotion') }}" class="bg-white text-yellow-600 px-8 py-3 rounded-lg hover:bg-gray-100 transition duration-300 font-semibold">
                Start Selling Today
            </a>
            <a href="{{ route('categories.index') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg hover:bg-white hover:text-yellow-600 transition duration-300 font-semibold">
                Explore Platform
            </a>
        </div>
        
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8 text-white">
            <div>
                <div class="text-3xl font-bold mb-2">10,000+</div>
                <div class="text-yellow-100">Expected Sellers</div>
            </div>
            <div>
                <div class="text-3xl font-bold mb-2">₹1000Cr+</div>
                <div class="text-yellow-100">Expected GMV</div>
            </div>
            <div>
                <div class="text-3xl font-bold mb-2">50+</div>
                <div class="text-yellow-100">Cities Coverage</div>
            </div>
        </div>
    </div>
</section>


@endsection

@push('styles')
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endpush
