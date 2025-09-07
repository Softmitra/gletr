@extends('layouts.marketplace')

@section('title', 'Premium Jewelry Marketplace - Gletr')
@section('description', 'Discover exquisite jewelry from verified sellers. Gold, Silver, Diamond and Platinum jewelry with hallmark certification and guaranteed authenticity.')

@push('styles')
<style>
    /* CaratLane Inspired Design */
    .caratlane-hero {
        background: linear-gradient(135deg, #fdf2f8 0%, #fef7cd 50%, #ffffff 100%);
        position: relative;
    }
    
    .caratlane-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="sparkles" width="50" height="50" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(212,175,55,0.1)"/><circle cx="75" cy="75" r="0.5" fill="rgba(212,175,55,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23sparkles)"/></svg>');
        opacity: 0.3;
    }
    
    .collection-card-caratlane {
        background: white;
        border-radius: 20px;
        transition: all 0.4s ease;
        border: 1px solid #f1f5f9;
        overflow: hidden;
    }
    
    .collection-card-caratlane:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
        border-color: #fbbf24;
    }
    
    .product-card-caratlane {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid #f8fafc;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }
    
    .product-card-caratlane:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        border-color: #fbbf24;
    }
    
    .caratlane-section {
        background: linear-gradient(180deg, #ffffff 0%, #fefbf3 100%);
    }
    
    .caratlane-cta {
        background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
        box-shadow: 0 10px 30px rgba(245, 158, 11, 0.3);
    }
    
    .caratlane-cta:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 40px rgba(245, 158, 11, 0.4);
    }
    
    .category-banner {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-radius: 24px;
        position: relative;
        overflow: hidden;
    }
    
    .category-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%);
        animation: gentle-rotate 10s linear infinite;
    }
    
    @keyframes gentle-rotate {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .trending-badge {
        background: linear-gradient(135deg, #ec4899 0%, #f472b6 100%);
        animation: pulse-glow 2s ease-in-out infinite;
    }
    
    @keyframes pulse-glow {
        0%, 100% { box-shadow: 0 0 0 0 rgba(236, 72, 153, 0.4); }
        50% { box-shadow: 0 0 0 8px rgba(236, 72, 153, 0); }
    }
    
    .price-highlight {
        background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        color: white;
        border-radius: 8px;
        padding: 4px 8px;
        font-size: 12px;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<!-- CaratLane Style Hero Banner -->
<section class="caratlane-hero py-20 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <!-- Hero Content -->
            <div class="text-center lg:text-left">
                <div class="inline-block mb-6">
                    <span class="bg-pink-100 text-pink-800 px-4 py-2 rounded-full text-sm font-medium">
                        ✨ India's Trusted Jewelry Destination
                    </span>
                </div>
                <div class="relative">
                    <!-- Background SVG -->
                    <div class="absolute inset-0 opacity-10 pointer-events-none">
                        <img 
                            src="{{ asset('images/Gletr Hero Banner.svg') }}" 
                            alt="" 
                            class="w-full h-full object-cover"
                        />
                    </div>
                    <!-- Heading with reduced font size -->
                    <h1 class="relative z-10 text-3xl lg:text-4xl font-bold text-gray-900 mb-6 leading-tight">
                        Discover
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-500 to-yellow-500">
                            Exquisite
                        </span>
                        <br>Jewellery Collection
                    </h1>
                </div>
                <p class="text-xl text-gray-600 mb-8 leading-relaxed max-w-lg">
                    Discover stunning collections of certified jewelry. From everyday elegance to special occasions, find pieces that tell your story.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="/products" class="caratlane-cta text-white px-8 py-4 rounded-full font-semibold text-lg transition-all duration-300 inline-flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Explore Collection
                    </a>
                    <a href="/rings" class="bg-white text-gray-700 border-2 border-gray-200 px-8 py-4 rounded-full font-semibold text-lg hover:border-yellow-400 hover:text-yellow-600 transition-all duration-300 inline-flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Shop Rings
                    </a>
                </div>
                
                <!-- Trust Indicators - CaratLane Style -->
                <div class="mt-12 flex flex-wrap justify-center lg:justify-start gap-8">
                    <div class="flex items-center text-gray-600">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-sm">Certified Authentic</div>
                            <div class="text-xs text-gray-500">BIS Hallmarked</div>
                        </div>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-sm">Free Shipping</div>
                            <div class="text-xs text-gray-500">On orders above ₹5,000</div>
                        </div>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-sm">Easy Returns</div>
                            <div class="text-xs text-gray-500">30-day policy</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Hero Visual with SVG -->
            <div class="relative">
                <div class="bg-white rounded-2xl p-8 shadow-lg">
                    <!-- Gletr Hero Banner SVG -->
                    <div class="w-full h-96 flex items-center justify-center mb-6">
                        <img 
                            src="{{ asset('images/Gletr Hero Banner.svg') }}" 
                            alt="Gletr Premium Jewelry Collection" 
                            class="max-w-full max-h-full object-contain"
                        />
                    </div>
                    <div class="text-center">
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Premium Collection</h3>
                        <p class="text-gray-700 mb-6">Handcrafted luxury jewelry with authentic certification</p>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-stone-50 rounded-lg p-4">
                                <div class="text-lg font-bold text-amber-600">500+</div>
                                <div class="text-xs text-stone-600">New Designs</div>
                            </div>
                            <div class="bg-stone-50 rounded-lg p-4">
                                <div class="text-lg font-bold text-amber-600">4.9★</div>
                                <div class="text-xs text-stone-600">Customer Rating</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CaratLane Style Category Strip -->
<section class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <a href="/rings" class="group flex flex-col items-center p-4 rounded-xl hover:bg-pink-50 transition-colors">
                <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <span class="text-2xl">💍</span>
                </div>
                <span class="font-medium text-gray-900 group-hover:text-pink-600">Rings</span>
                <span class="text-xs text-gray-500">1,200+ designs</span>
            </a>
            <a href="/necklaces" class="group flex flex-col items-center p-4 rounded-xl hover:bg-yellow-50 transition-colors">
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <span class="text-2xl">📿</span>
                </div>
                <span class="font-medium text-gray-900 group-hover:text-yellow-600">Necklaces</span>
                <span class="text-xs text-gray-500">800+ designs</span>
            </a>
            <a href="/earrings" class="group flex flex-col items-center p-4 rounded-xl hover:bg-blue-50 transition-colors">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <span class="text-2xl">👂</span>
                </div>
                <span class="font-medium text-gray-900 group-hover:text-blue-600">Earrings</span>
                <span class="text-xs text-gray-500">950+ designs</span>
            </a>
            <a href="/bracelets" class="group flex flex-col items-center p-4 rounded-xl hover:bg-purple-50 transition-colors">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <span class="text-2xl">⌚</span>
                </div>
                <span class="font-medium text-gray-900 group-hover:text-purple-600">Bracelets</span>
                <span class="text-xs text-gray-500">600+ designs</span>
            </a>
        </div>
    </div>
</section>

<!-- Featured Collections - CaratLane Style -->
<section class="caratlane-section py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Shop by Metal</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Choose from our premium metal collections, each crafted with excellence
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Gold Collection -->
            <div class="collection-card-caratlane group">
                <div class="relative overflow-hidden">
                    <div class="w-full h-64 bg-gradient-to-br from-yellow-100 via-yellow-200 to-yellow-300 flex items-center justify-center">
                        <div class="text-6xl transform group-hover:scale-110 transition-transform duration-500">🥇</div>
                    </div>
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300"></div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Gold Collection</h3>
                    <p class="text-gray-600 mb-4">22K & 18K gold jewelry with traditional and contemporary designs</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Starting ₹15,000</span>
                        <a href="/gold" class="text-yellow-600 hover:text-yellow-700 font-semibold text-sm">
                            Shop Now →
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Diamond Collection -->
            <div class="collection-card-caratlane group">
                <div class="relative overflow-hidden">
                    <div class="w-full h-64 bg-gradient-to-br from-blue-100 via-blue-200 to-blue-300 flex items-center justify-center">
                        <div class="text-6xl transform group-hover:scale-110 transition-transform duration-500">💎</div>
                    </div>
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300"></div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Diamond Collection</h3>
                    <p class="text-gray-600 mb-4">Certified diamonds in stunning settings for every celebration</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Starting ₹25,000</span>
                        <a href="/diamond" class="text-blue-600 hover:text-blue-700 font-semibold text-sm">
                            Shop Now →
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Silver Collection -->
            <div class="collection-card-caratlane group">
                <div class="relative overflow-hidden">
                    <div class="w-full h-64 bg-gradient-to-br from-gray-100 via-gray-200 to-gray-300 flex items-center justify-center">
                        <div class="text-6xl transform group-hover:scale-110 transition-transform duration-500">🥈</div>
                    </div>
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300"></div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Silver Collection</h3>
                    <p class="text-gray-600 mb-4">925 sterling silver pieces perfect for daily wear</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Starting ₹2,500</span>
                        <a href="/silver" class="text-gray-600 hover:text-gray-700 font-semibold text-sm">
                            Shop Now →
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Platinum Collection -->
            <div class="collection-card-caratlane group">
                <div class="relative overflow-hidden">
                    <div class="w-full h-64 bg-gradient-to-br from-purple-100 via-purple-200 to-purple-300 flex items-center justify-center">
                        <div class="text-6xl transform group-hover:scale-110 transition-transform duration-500">⭐</div>
                    </div>
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300"></div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Platinum Collection</h3>
                    <p class="text-gray-600 mb-4">Rare platinum jewelry for life's most precious moments</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Starting ₹45,000</span>
                        <a href="/platinum" class="text-purple-600 hover:text-purple-700 font-semibold text-sm">
                            Shop Now →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Trending Products - CaratLane Style -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-block mb-4">
                <span class="trending-badge text-white px-4 py-2 rounded-full text-sm font-medium">
                    🔥 Trending Now
                </span>
            </div>
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Bestsellers This Month</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Discover what everyone's talking about - our most loved pieces
            </p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Product 1 -->
            <div class="product-card-caratlane group">
                <div class="relative overflow-hidden">
                    <div class="w-full h-72 bg-gradient-to-br from-pink-50 to-pink-100 flex items-center justify-center">
                        <span class="text-5xl transform group-hover:scale-110 transition-transform duration-500">💍</span>
                    </div>
                    <div class="absolute top-4 left-4">
                        <span class="trending-badge text-white px-3 py-1 rounded-full text-xs font-medium">
                            Trending
                        </span>
                    </div>
                    <div class="absolute top-4 right-4">
                        <button class="w-8 h-8 bg-white rounded-full shadow-md flex items-center justify-center hover:bg-gray-50 transition-colors">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="absolute bottom-4 left-4">
                        <div class="price-highlight">
                            25% OFF
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-3">
                        <div class="flex text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                            @endfor
                        </div>
                        <span class="text-sm text-gray-600 ml-2">(4.8)</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Rose Gold Solitaire Ring</h3>
                    <p class="text-sm text-gray-500 mb-3">Premium Jewels • 18K Rose Gold</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="text-lg font-bold text-gray-900">₹33,749</span>
                            <span class="text-sm text-gray-500 line-through">₹44,999</span>
                        </div>
                        <button class="caratlane-cta text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300">
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Product 2 -->
            <div class="product-card-caratlane group">
                <div class="relative overflow-hidden">
                    <div class="w-full h-72 bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center">
                        <span class="text-5xl transform group-hover:scale-110 transition-transform duration-500">📿</span>
                    </div>
                    <div class="absolute top-4 right-4">
                        <button class="w-8 h-8 bg-white rounded-full shadow-md flex items-center justify-center hover:bg-gray-50 transition-colors">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-3">
                        <div class="flex text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                            @endfor
                        </div>
                        <span class="text-sm text-gray-600 ml-2">(4.9)</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Diamond Tennis Necklace</h3>
                    <p class="text-sm text-gray-500 mb-3">Royal Gems • 18K White Gold</p>
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-lg font-bold text-gray-900">₹89,999</span>
                        </div>
                        <button class="caratlane-cta text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300">
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Product 3 -->
            <div class="product-card-caratlane group">
                <div class="relative overflow-hidden">
                    <div class="w-full h-72 bg-gradient-to-br from-yellow-50 to-yellow-100 flex items-center justify-center">
                        <span class="text-5xl transform group-hover:scale-110 transition-transform duration-500">👂</span>
                    </div>
                    <div class="absolute top-4 left-4">
                        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-medium">
                            New
                        </span>
                    </div>
                    <div class="absolute top-4 right-4">
                        <button class="w-8 h-8 bg-white rounded-full shadow-md flex items-center justify-center hover:bg-gray-50 transition-colors">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-3">
                        <div class="flex text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                            @endfor
                        </div>
                        <span class="text-sm text-gray-600 ml-2">(4.7)</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Gold Drop Earrings</h3>
                    <p class="text-sm text-gray-500 mb-3">Elite Designs • 22K Gold</p>
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-lg font-bold text-gray-900">₹25,999</span>
                        </div>
                        <button class="caratlane-cta text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300">
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Product 4 -->
            <div class="product-card-caratlane group">
                <div class="relative overflow-hidden">
                    <div class="w-full h-72 bg-gradient-to-br from-purple-50 to-purple-100 flex items-center justify-center">
                        <span class="text-5xl transform group-hover:scale-110 transition-transform duration-500">⌚</span>
                    </div>
                    <div class="absolute top-4 right-4">
                        <button class="w-8 h-8 bg-white rounded-full shadow-md flex items-center justify-center hover:bg-gray-50 transition-colors">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-3">
                        <div class="flex text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                            @endfor
                        </div>
                        <span class="text-sm text-gray-600 ml-2">(5.0)</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Platinum Tennis Bracelet</h3>
                    <p class="text-sm text-gray-500 mb-3">Luxury Craft • Pure Platinum</p>
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-lg font-bold text-gray-900">₹1,25,999</span>
                        </div>
                        <button class="caratlane-cta text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300">
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- View All Button -->
        <div class="text-center mt-12">
            <a href="/products" class="bg-gray-900 text-white px-8 py-4 rounded-full font-semibold text-lg hover:bg-gray-800 transition-colors inline-flex items-center">
                View All Products
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Special Offers - CaratLane Style -->
<section class="py-20 bg-gradient-to-br from-pink-50 to-yellow-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Special Offers</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Don't miss out on these exclusive deals on premium jewelry
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Offer 1 -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between mb-6">
                    <div class="bg-pink-100 text-pink-800 px-4 py-2 rounded-full text-sm font-medium">
                        💕 Valentine Special
                    </div>
                    <div class="text-2xl font-bold text-pink-600">30% OFF</div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Couple Rings Collection</h3>
                <p class="text-gray-600 mb-6">Perfect matching rings for your special someone. Limited time offer on all couple ring sets.</p>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-500">Valid till Feb 28</span>
                    <a href="/rings" class="caratlane-cta text-white px-6 py-3 rounded-full font-semibold transition-all duration-300">
                        Shop Now
                    </a>
                </div>
            </div>
            
            <!-- Offer 2 -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between mb-6">
                    <div class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full text-sm font-medium">
                        ✨ Gold Rush
                    </div>
                    <div class="text-2xl font-bold text-yellow-600">₹5,000 OFF</div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Gold Jewelry Bonanza</h3>
                <p class="text-gray-600 mb-6">Flat ₹5,000 off on all gold jewelry above ₹50,000. Plus free insurance for 1 year.</p>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-500">Limited period</span>
                    <a href="/gold" class="caratlane-cta text-white px-6 py-3 rounded-full font-semibold transition-all duration-300">
                        Shop Gold
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Customer Reviews - CaratLane Style -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">What Our Customers Say</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Real stories from real customers who found their perfect jewelry
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Review 1 -->
            <div class="bg-white rounded-2xl p-8 shadow-md hover:shadow-lg transition-shadow border border-gray-100">
                <div class="flex items-center mb-6">
                    <div class="w-14 h-14 bg-gradient-to-br from-pink-400 to-pink-600 rounded-full flex items-center justify-center mr-4">
                        <span class="text-white font-bold text-lg">P</span>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900">Priya Sharma</div>
                        <div class="text-sm text-gray-500">Mumbai • Verified Buyer</div>
                    </div>
                </div>
                <div class="flex items-center mb-4">
                    <div class="flex text-yellow-400 mr-2">
                        @for($i = 1; $i <= 5; $i++)
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                        </svg>
                        @endfor
                    </div>
                    <span class="text-sm text-gray-600">"Absolutely stunning!"</span>
                </div>
                <p class="text-gray-700 leading-relaxed mb-4">
                    "The diamond necklace I ordered is absolutely beautiful. The quality exceeded my expectations and the certification documents provided complete peace of mind."
                </p>
                <div class="text-sm text-gray-500">Purchased: Diamond Necklace Set</div>
            </div>
            
            <!-- Review 2 -->
            <div class="bg-white rounded-2xl p-8 shadow-md hover:shadow-lg transition-shadow border border-gray-100">
                <div class="flex items-center mb-6">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center mr-4">
                        <span class="text-white font-bold text-lg">R</span>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900">Rajesh Kumar</div>
                        <div class="text-sm text-gray-500">Delhi • Verified Buyer</div>
                    </div>
                </div>
                <div class="flex items-center mb-4">
                    <div class="flex text-yellow-400 mr-2">
                        @for($i = 1; $i <= 5; $i++)
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                        </svg>
                        @endfor
                    </div>
                    <span class="text-sm text-gray-600">"Fast delivery!"</span>
                </div>
                <p class="text-gray-700 leading-relaxed mb-4">
                    "Ordered wedding rings for my fiancée and myself. The quality is outstanding and delivery was incredibly fast. Great platform for authentic jewelry."
                </p>
                <div class="text-sm text-gray-500">Purchased: Gold Wedding Ring Set</div>
            </div>
            
            <!-- Review 3 -->
            <div class="bg-white rounded-2xl p-8 shadow-md hover:shadow-lg transition-shadow border border-gray-100">
                <div class="flex items-center mb-6">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center mr-4">
                        <span class="text-white font-bold text-lg">A</span>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900">Anita Desai</div>
                        <div class="text-sm text-gray-500">Bangalore • Verified Buyer</div>
                    </div>
                </div>
                <div class="flex items-center mb-4">
                    <div class="flex text-yellow-400 mr-2">
                        @for($i = 1; $i <= 5; $i++)
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                        </svg>
                        @endfor
                    </div>
                    <span class="text-sm text-gray-600">"Perfect for gifting!"</span>
                </div>
                <p class="text-gray-700 leading-relaxed mb-4">
                    "Bought earrings as a gift for my daughter's birthday. The packaging was beautiful and the quality is excellent. She absolutely loves them!"
                </p>
                <div class="text-sm text-gray-500">Purchased: Diamond Stud Earrings</div>
            </div>
        </div>
        
        <!-- Review Stats -->
        <div class="mt-16 text-center">
            <div class="bg-gray-50 rounded-2xl p-8 max-w-4xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <div class="text-3xl font-bold text-gray-900 mb-2">4.8★</div>
                        <div class="text-sm text-gray-600">Average Rating</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gray-900 mb-2">50K+</div>
                        <div class="text-sm text-gray-600">Happy Customers</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gray-900 mb-2">98%</div>
                        <div class="text-sm text-gray-600">Satisfaction Rate</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gray-900 mb-2">24/7</div>
                        <div class="text-sm text-gray-600">Customer Support</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section with Soft UI -->
<section class="py-20 bg-gradient-to-br from-stone-50 to-amber-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative">
            <!-- Background SVG -->
            <div class="absolute inset-0 opacity-5 pointer-events-none">
                <img 
                    src="{{ asset('images/gletr_hero_banner.svg') }}" 
                    alt="" 
                    class="w-full h-full object-cover"
                />
            </div>
            
            <!-- Newsletter Content -->
            <div class="relative z-10 bg-white bg-opacity-80 backdrop-blur-sm rounded-3xl p-12 text-center shadow-lg border border-stone-200">
                <h2 class="text-3xl font-bold text-stone-900 mb-4">Stay Updated</h2>
                <p class="text-lg text-stone-600 mb-8 max-w-2xl mx-auto">
                    Get notified about new collections, exclusive offers, and jewellery care tips
                </p>
                
                <!-- Newsletter Form -->
                <form class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                    <input 
                        type="email" 
                        placeholder="Enter your email" 
                        class="flex-1 px-6 py-4 border border-stone-300 rounded-full focus:ring-2 focus:ring-amber-500 focus:border-amber-500 bg-white text-stone-800 placeholder-stone-400 transition-all duration-300"
                        required
                    />
                    <button 
                        type="submit" 
                        class="bg-amber-500 hover:bg-amber-600 text-white px-8 py-4 rounded-full font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl"
                    >
                        Subscribe
                    </button>
                </form>
                
                <!-- Trust Indicators -->
                <div class="mt-8 flex items-center justify-center space-x-6 text-sm text-stone-500">
                    <div class="flex items-center">
                        <span class="material-symbols-outlined text-green-500 mr-1">security</span>
                        <span>No spam, ever</span>
                    </div>
                    <div class="flex items-center">
                        <span class="material-symbols-outlined text-blue-500 mr-1">mail</span>
                        <span>Weekly updates</span>
                    </div>
                    <div class="flex items-center">
                        <span class="material-symbols-outlined text-amber-500 mr-1">cancel</span>
                        <span>Unsubscribe anytime</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
// CaratLane Style Interactions
document.addEventListener('DOMContentLoaded', function() {
    // Add to cart functionality
    document.querySelectorAll('.caratlane-cta').forEach(button => {
        if (button.textContent.includes('Add to Cart')) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Add visual feedback
                const originalText = this.textContent;
                this.textContent = 'Added!';
                this.classList.add('bg-green-500');
                
                setTimeout(() => {
                    this.textContent = originalText;
                    this.classList.remove('bg-green-500');
                }, 1500);
                
                // Update cart count in header
                const cartCount = document.querySelector('.absolute.-top-2.-right-2');
                if (cartCount) {
                    let count = parseInt(cartCount.textContent) || 0;
                    cartCount.textContent = count + 1;
                }
            });
        }
    });
    
    // Wishlist functionality - simplified
    document.querySelectorAll('button').forEach(button => {
        const svg = button.querySelector('svg');
        if (svg && svg.querySelector('path[stroke-linecap="round"]')) {
            // Check if it's a heart icon (wishlist button)
            const path = svg.querySelector('path');
            if (path && path.getAttribute('d') && path.getAttribute('d').includes('4.318')) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Toggle wishlist state
                    const isLiked = this.classList.contains('text-red-500');
                    
                    if (isLiked) {
                        this.classList.remove('text-red-500');
                        this.classList.add('text-gray-600');
                    } else {
                        this.classList.remove('text-gray-600');
                        this.classList.add('text-red-500');
                    }
                });
            }
        }
    });
    
    // Smooth scrolling for category navigation
    document.querySelectorAll('a[href^="/"]').forEach(link => {
        link.addEventListener('click', function(e) {
            // Add loading state for demo
            if (this.href.includes('/products') || this.href.includes('/rings') || this.href.includes('/necklaces')) {
                e.preventDefault();
                
                const originalText = this.textContent;
                this.style.opacity = '0.7';
                this.textContent = 'Loading...';
                
                setTimeout(() => {
                    this.style.opacity = '1';
                    this.textContent = originalText;
                    // In real app, you would navigate here
                    console.log('Navigate to:', this.href);
                }, 1000);
            }
        });
    });
});
</script>
@endpush
