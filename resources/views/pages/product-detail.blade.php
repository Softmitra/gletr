@extends('layouts.marketplace')

@section('title', 'Diamond Gold Ring - Premium Jewels - Gletr')
@section('description', 'Exquisite diamond gold ring with hallmark certification. Authentic luxury jewelry from verified seller with warranty and free shipping.')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-8 text-sm">
            <a href="/" class="text-gray-500 hover:text-gray-700">Home</a>
            <span class="mx-2 text-gray-400">/</span>
            <a href="/rings" class="text-gray-500 hover:text-gray-700">Rings</a>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-gray-900">Diamond Gold Ring</span>
        </nav>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Product Gallery -->
            <div>
                <!-- Main Image -->
                <div class="luxury-card p-4 mb-4">
                    <div class="w-full h-96 bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg flex items-center justify-center">
                        <span class="text-8xl">💍</span>
                    </div>
                </div>
                
                <!-- Thumbnail Gallery -->
                <div class="grid grid-cols-4 gap-3">
                    <div class="luxury-card p-2 border-2 border-yellow-500">
                        <div class="w-full h-20 bg-gradient-to-br from-yellow-50 to-yellow-100 rounded flex items-center justify-center">
                            <span class="text-2xl">💍</span>
                        </div>
                    </div>
                    <div class="luxury-card p-2 hover:border-yellow-300 cursor-pointer">
                        <div class="w-full h-20 bg-gradient-to-br from-yellow-50 to-yellow-100 rounded flex items-center justify-center">
                            <span class="text-2xl">💍</span>
                        </div>
                    </div>
                    <div class="luxury-card p-2 hover:border-yellow-300 cursor-pointer">
                        <div class="w-full h-20 bg-gradient-to-br from-yellow-50 to-yellow-100 rounded flex items-center justify-center">
                            <span class="text-2xl">💍</span>
                        </div>
                    </div>
                    <div class="luxury-card p-2 hover:border-yellow-300 cursor-pointer">
                        <div class="w-full h-20 bg-gradient-to-br from-yellow-50 to-yellow-100 rounded flex items-center justify-center">
                            <span class="text-2xl">💍</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Product Details -->
            <div>
                <div class="luxury-card p-8">
                    <!-- Product Title & Rating -->
                    <div class="mb-6">
                        <h1 class="heading-2 mb-2">Elegant Diamond Gold Ring</h1>
                        <div class="flex items-center mb-4">
                            <div class="flex items-center mr-4">
                                <div class="flex">
                                    <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                    <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                    <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                    <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                    <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-600 ml-2">4.8 (127 reviews)</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-2">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <span class="text-body-sm text-gray-700 font-medium">Premium Jewels</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Price Breakdown -->
                    <div class="mb-8">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="heading-6 mb-3">Price Breakdown</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Base Price:</span>
                                    <span class="font-medium">₹38,500</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Making Charges:</span>
                                    <span class="font-medium">₹5,200</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">GST (3%):</span>
                                    <span class="font-medium">₹1,311</span>
                                </div>
                                <div class="border-t border-gray-200 pt-2 flex justify-between">
                                    <span class="font-semibold">Total Price:</span>
                                    <span class="font-bold text-lg text-gray-900">₹45,011</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product Options -->
                    <div class="mb-8 space-y-6">
                        <!-- Ring Size -->
                        <div>
                            <label class="form-label mb-2 block">Ring Size</label>
                            <div class="grid grid-cols-6 gap-2">
                                @for($size = 10; $size <= 21; $size++)
                                <button class="border border-gray-300 rounded-lg py-2 text-sm hover:border-yellow-500 hover:bg-yellow-50 {{ $size == 16 ? 'border-yellow-500 bg-yellow-50' : '' }}">
                                    {{ $size }}
                                </button>
                                @endfor
                            </div>
                        </div>
                        
                        <!-- Purity -->
                        <div>
                            <label class="form-label mb-2 block">Gold Purity</label>
                            <div class="flex space-x-3">
                                <button class="border border-gray-300 rounded-lg px-4 py-2 text-sm hover:border-yellow-500 hover:bg-yellow-50 border-yellow-500 bg-yellow-50">
                                    22K Gold
                                </button>
                                <button class="border border-gray-300 rounded-lg px-4 py-2 text-sm hover:border-yellow-500 hover:bg-yellow-50">
                                    18K Gold
                                </button>
                            </div>
                        </div>
                        
                        <!-- Stone -->
                        <div>
                            <label class="form-label mb-2 block">Diamond Quality</label>
                            <select class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-yellow-500">
                                <option>VVS1 - Premium Quality</option>
                                <option>VVS2 - Excellent Quality</option>
                                <option>VS1 - Very Good Quality</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="space-y-4 mb-8">
                        <button class="luxury-button w-full text-lg py-4">
                            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5-5M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"></path>
                            </svg>
                            Add to Cart
                        </button>
                        <button class="w-full bg-gray-900 text-white py-4 rounded-lg font-semibold text-lg hover:bg-gray-800 transition-colors">
                            Buy Now
                        </button>
                    </div>
                    
                    <!-- Trust Badges -->
                    <div class="grid grid-cols-2 gap-4 text-center">
                        <div class="flex items-center justify-center space-x-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            <span>Hallmark Certified</span>
                        </div>
                        <div class="flex items-center justify-center space-x-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            <span>1 Year Warranty</span>
                        </div>
                        <div class="flex items-center justify-center space-x-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Free Shipping</span>
                        </div>
                        <div class="flex items-center justify-center space-x-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            <span>Easy Returns</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Product Details Tabs -->
        <div class="mt-12">
            <div class="luxury-card">
                <!-- Tab Navigation -->
                <div class="border-b border-gray-200">
                    <nav class="flex space-x-8 px-6">
                        <button class="py-4 text-sm font-medium text-yellow-600 border-b-2 border-yellow-600">
                            Details
                        </button>
                        <button class="py-4 text-sm font-medium text-gray-500 hover:text-gray-700">
                            Specifications
                        </button>
                        <button class="py-4 text-sm font-medium text-gray-500 hover:text-gray-700">
                            Reviews (127)
                        </button>
                        <button class="py-4 text-sm font-medium text-gray-500 hover:text-gray-700">
                            Care Instructions
                        </button>
                    </nav>
                </div>
                
                <!-- Tab Content -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h4 class="heading-5 mb-4">Product Details</h4>
                            <ul class="space-y-3 text-body-sm text-gray-700">
                                <li class="flex items-start">
                                    <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span><strong>Metal:</strong> 22K Gold with hallmark certification</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span><strong>Diamond:</strong> 0.25 Carat, VVS1 clarity, F color</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span><strong>Weight:</strong> 3.2 grams total weight</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span><strong>Size:</strong> Available in sizes 10-21</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span><strong>Warranty:</strong> 1 year manufacturer warranty</span>
                                </li>
                            </ul>
                        </div>
                        
                        <div>
                            <h4 class="heading-5 mb-4">Certifications</h4>
                            <div class="space-y-3">
                                <div class="flex items-center p-3 bg-green-50 rounded-lg">
                                    <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                    </svg>
                                    <div>
                                        <div class="font-medium text-green-800">BIS Hallmark Certified</div>
                                        <div class="text-sm text-green-600">Certificate #: BIS2024567890</div>
                                    </div>
                                </div>
                                <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                                    <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                    </svg>
                                    <div>
                                        <div class="font-medium text-blue-800">GIA Diamond Certificate</div>
                                        <div class="text-sm text-blue-600">Certificate #: GIA567890123</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Related Products -->
        <div class="mt-16">
            <h3 class="heading-3 mb-8">Related Products</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @for($i = 1; $i <= 4; $i++)
                <div class="product-card">
                    <div class="w-full h-48 bg-gradient-to-br from-yellow-50 to-yellow-100 flex items-center justify-center">
                        <span class="text-3xl">{{ ['💍', '📿', '👂', '⌚'][$i-1] }}</span>
                    </div>
                    <div class="p-4">
                        <h4 class="heading-6 mb-1">{{ ['Gold Band Ring', 'Diamond Pendant', 'Gold Studs', 'Silver Chain'][$i-1] }}</h4>
                        <p class="text-caption text-gray-600 mb-2">by Premium Jewels</p>
                        <div class="text-lg font-bold text-gray-900">₹{{ number_format(15000 + $i * 10000) }}</div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
        
        <!-- Reviews Section -->
        <div class="mt-16">
            <div class="luxury-card p-8">
                <h3 class="heading-3 mb-6">Customer Reviews</h3>
                
                <!-- Review Summary -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                    <div class="text-center">
                        <div class="text-4xl font-bold text-yellow-600 mb-2">4.8</div>
                        <div class="flex justify-center mb-2">
                            @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                            @endfor
                        </div>
                        <div class="text-body-sm text-gray-600">Based on 127 reviews</div>
                    </div>
                    
                    <div class="md:col-span-2">
                        <div class="space-y-2">
                            @for($star = 5; $star >= 1; $star--)
                            <div class="flex items-center">
                                <span class="text-sm w-8">{{ $star }}</span>
                                <svg class="w-4 h-4 text-yellow-400 fill-current mr-2" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                                <div class="flex-1 bg-gray-200 rounded-full h-2 mr-4">
                                    <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ $star == 5 ? '75%' : ($star == 4 ? '15%' : ($star == 3 ? '8%' : '2%')) }}"></div>
                                </div>
                                <span class="text-sm text-gray-600 w-8">{{ $star == 5 ? '95' : ($star == 4 ? '19' : ($star == 3 ? '10' : '3')) }}</span>
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>
                
                <!-- Individual Reviews -->
                <div class="space-y-6">
                    @for($i = 1; $i <= 3; $i++)
                    <div class="border border-gray-200 rounded-lg p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                                    <span class="font-bold text-gray-600">{{ ['S', 'M', 'A'][$i-1] }}</span>
                                </div>
                                <div>
                                    <div class="font-medium">{{ ['Sneha Patel', 'Mohan Singh', 'Arti Sharma'][$i-1] }}</div>
                                    <div class="text-sm text-gray-600">{{ ['2 days ago', '1 week ago', '2 weeks ago'][$i-1] }}</div>
                                </div>
                            </div>
                            <div class="flex">
                                @for($star = 1; $star <= 5; $star++)
                                <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                                @endfor
                            </div>
                        </div>
                        <p class="text-gray-700 leading-relaxed">
                            {{ [
                                'Beautiful ring with excellent craftsmanship. The diamond sparkles beautifully and the gold quality is top-notch. Very satisfied with my purchase!',
                                'Great quality and fast delivery. The ring fits perfectly and looks exactly like the photos. Highly recommend this seller.',
                                'Absolutely love this ring! The design is elegant and the certification documents give complete peace of mind. Will definitely shop again.'
                            ][$i-1] }}
                        </p>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Image gallery functionality
document.querySelectorAll('.grid .luxury-card').forEach((thumbnail, index) => {
    if (index > 0) { // Skip the first one which is the main image
        thumbnail.addEventListener('click', function() {
            // Remove active state from all thumbnails
            document.querySelectorAll('.grid .luxury-card').forEach(thumb => {
                thumb.classList.remove('border-yellow-500');
                thumb.classList.add('hover:border-yellow-300');
            });
            
            // Add active state to clicked thumbnail
            this.classList.add('border-yellow-500');
            this.classList.remove('hover:border-yellow-300');
            
            // Here you would typically update the main image
            console.log('Thumbnail clicked:', index);
        });
    }
});

// Size selector
document.querySelectorAll('[class*="grid-cols-6"] button').forEach(button => {
    button.addEventListener('click', function() {
        // Remove active state from all size buttons
        document.querySelectorAll('[class*="grid-cols-6"] button').forEach(btn => {
            btn.classList.remove('border-yellow-500', 'bg-yellow-50');
            btn.classList.add('border-gray-300');
        });
        
        // Add active state to clicked button
        this.classList.add('border-yellow-500', 'bg-yellow-50');
        this.classList.remove('border-gray-300');
    });
});

// Purity selector
document.querySelectorAll('[class*="flex space-x-3"] button').forEach(button => {
    button.addEventListener('click', function() {
        // Remove active state from all purity buttons
        document.querySelectorAll('[class*="flex space-x-3"] button').forEach(btn => {
            btn.classList.remove('border-yellow-500', 'bg-yellow-50');
            btn.classList.add('border-gray-300');
        });
        
        // Add active state to clicked button
        this.classList.add('border-yellow-500', 'bg-yellow-50');
        this.classList.remove('border-gray-300');
    });
});
</script>
@endpush
