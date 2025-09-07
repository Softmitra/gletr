@extends('layouts.marketplace')

@section('title', 'Gletr Jewels - Product Listing')
@section('description', 'Browse our extensive collection of authenticated luxury jewelry. Filter by metal, purity, price, and seller to find your perfect piece.')

@push('styles')
<style>
    :root {
        --primary-color: #f2e2d0;
        --secondary-color: #1a1a1a;
        --accent-color: #c4a185;
    }
    .custom-radio:checked {
        background-image: url('data:image/svg+xml,%3csvg viewBox=%270 0 16 16%27 fill=%27%23c4a185%27 xmlns=%27http://www.w3.org/2000/svg%27%3e%3ccircle cx=%278%27 cy=%278%27 r=%273%27/%3e%3c/svg%3e');
        border-color: var(--accent-color);
    }
</style>
@endpush

@section('content')
<div class="relative flex size-full min-h-screen flex-col overflow-x-hidden">
    <main class="container mx-auto flex flex-col lg:flex-row gap-8 px-4 sm:px-6 lg:px-8 py-8">
        <!-- Sidebar Filters -->
        <aside class="w-full lg:w-72 xl:w-80 flex-shrink-0">
            <div class="sticky top-28">
                <h2 class="text-2xl font-bold tracking-tight text-stone-900 mb-6">Filter Results</h2>
                <div class="space-y-6">
                    <!-- Price Range -->
                    <div>
                        <h3 class="text-lg font-semibold text-stone-800 mb-3">Price Range</h3>
                        <div class="relative pt-1">
                            <input class="w-full h-2 bg-stone-200 rounded-lg appearance-none cursor-pointer accent-amber-500" max="85000" min="0" type="range"/>
                            <div class="flex justify-between text-sm text-stone-500 mt-2">
                                <span>₹0</span>
                                <span>₹85,000</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Metal Filter -->
                    <div>
                        <h3 class="text-lg font-semibold text-stone-800 mb-3">Metal</h3>
                        <div class="space-y-2 text-stone-600">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input checked class="h-4 w-4 border-stone-300 bg-stone-100 custom-radio text-amber-500 focus:ring-amber-500" name="metal" type="radio"/>
                                <span>Gold</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input class="h-4 w-4 border-stone-300 bg-stone-100 custom-radio text-amber-500 focus:ring-amber-500" name="metal" type="radio"/>
                                <span>Silver</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input class="h-4 w-4 border-stone-300 bg-stone-100 custom-radio text-amber-500 focus:ring-amber-500" name="metal" type="radio"/>
                                <span>Platinum</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input class="h-4 w-4 border-stone-300 bg-stone-100 custom-radio text-amber-500 focus:ring-amber-500" name="metal" type="radio"/>
                                <span>Rose Gold</span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Stone Filter -->
                    <div>
                        <h3 class="text-lg font-semibold text-stone-800 mb-3">Stone</h3>
                        <div class="space-y-2 text-stone-600">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input checked class="h-4 w-4 border-stone-300 bg-stone-100 custom-radio text-amber-500 focus:ring-amber-500" name="stone" type="radio"/>
                                <span>Diamond</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input class="h-4 w-4 border-stone-300 bg-stone-100 custom-radio text-amber-500 focus:ring-amber-500" name="stone" type="radio"/>
                                <span>Sapphire</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input class="h-4 w-4 border-stone-300 bg-stone-100 custom-radio text-amber-500 focus:ring-amber-500" name="stone" type="radio"/>
                                <span>Emerald</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input class="h-4 w-4 border-stone-300 bg-stone-100 custom-radio text-amber-500 focus:ring-amber-500" name="stone" type="radio"/>
                                <span>Ruby</span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Style Filter -->
                    <div>
                        <h3 class="text-lg font-semibold text-stone-800 mb-3">Style</h3>
                        <div class="space-y-2 text-stone-600">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input checked class="h-4 w-4 border-stone-300 bg-stone-100 custom-radio text-amber-500 focus:ring-amber-500" name="style" type="radio"/>
                                <span>Classic</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input class="h-4 w-4 border-stone-300 bg-stone-100 custom-radio text-amber-500 focus:ring-amber-500" name="style" type="radio"/>
                                <span>Modern</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input class="h-4 w-4 border-stone-300 bg-stone-100 custom-radio text-amber-500 focus:ring-amber-500" name="style" type="radio"/>
                                <span>Vintage</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input class="h-4 w-4 border-stone-300 bg-stone-100 custom-radio text-amber-500 focus:ring-amber-500" name="style" type="radio"/>
                                <span>Bohemian</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
        
        <!-- Product Grid -->
        <div class="flex-1">
            <!-- Header with Breadcrumb and Sort -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                <div>
                    <nav class="text-sm text-stone-500 mb-2">
                        <a class="hover:text-amber-500" href="#">Jewelry</a>
                        <span class="mx-2">/</span>
                        <span class="font-medium text-stone-800">Rings</span>
                    </nav>
                    <h1 class="text-4xl font-extrabold tracking-tighter text-stone-900">Rings</h1>
                </div>
                <div class="mt-4 sm:mt-0">
                    <select class="form-select rounded-md border-stone-300 bg-white shadow-sm focus:border-amber-500 focus:ring-amber-500 text-sm text-stone-800">
                        <option>Sort: Featured</option>
                        <option>Sort: Price (Low to High)</option>
                        <option>Sort: Price (High to Low)</option>
                        <option>Sort: Newest</option>
                    </select>
                </div>
            </div>
            
            <!-- Product Grid matching reference design -->
            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-x-4 gap-y-8">
                <!-- Product 1 -->
                <div class="group">
                    <a class="block" href="#">
                        <div class="w-full bg-stone-100 rounded-lg overflow-hidden mb-3">
                            <div class="w-full bg-center bg-no-repeat aspect-square bg-cover product-hover" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); display: flex; align-items: center; justify-content: center;">
                                <span class="text-4xl">💍</span>
                            </div>
                        </div>
                        <h3 class="text-sm font-semibold text-stone-800 group-hover:text-amber-500">Elegant Diamond Ring</h3>
                        <p class="text-sm text-stone-500">₹71,000.00</p>
                    </a>
                </div>
                
                <!-- Product 2 -->
                <div class="group">
                    <a class="block" href="#">
                        <div class="w-full bg-stone-100 rounded-lg overflow-hidden mb-3">
                            <div class="w-full bg-center bg-no-repeat aspect-square bg-cover product-hover" style="background: linear-gradient(135deg, #fef3c7 0%, #fbbf24 100%); display: flex; align-items: center; justify-content: center;">
                                <span class="text-4xl">💍</span>
                            </div>
                        </div>
                        <h3 class="text-sm font-semibold text-stone-800 group-hover:text-amber-500">Classic Gold Band</h3>
                        <p class="text-sm text-stone-500">₹26,700.00</p>
                    </a>
                </div>
                
                <!-- Product 3 -->
                <div class="group">
                    <a class="block" href="#">
                        <div class="w-full bg-stone-100 rounded-lg overflow-hidden mb-3">
                            <div class="w-full bg-center bg-no-repeat aspect-square bg-cover product-hover" style="background: linear-gradient(135deg, #dbeafe 0%, #93c5fd 100%); display: flex; align-items: center; justify-content: center;">
                                <span class="text-4xl">💎</span>
                            </div>
                        </div>
                        <h3 class="text-sm font-semibold text-stone-800 group-hover:text-amber-500">Sapphire Halo Ring</h3>
                        <p class="text-sm text-stone-500">₹81,800.00</p>
                    </a>
                </div>
                
                <!-- Product 4 -->
                <div class="group">
                    <a class="block" href="#">
                        <div class="w-full bg-stone-100 rounded-lg overflow-hidden mb-3">
                            <div class="w-full bg-center bg-no-repeat aspect-square bg-cover product-hover" style="background: linear-gradient(135deg, #f3f4f6 0%, #d1d5db 100%); display: flex; align-items: center; justify-content: center;">
                                <span class="text-4xl">⚪</span>
                            </div>
                        </div>
                        <h3 class="text-sm font-semibold text-stone-800 group-hover:text-amber-500">Modern Silver Ring</h3>
                        <p class="text-sm text-stone-500">₹20,900.00</p>
                    </a>
                </div>
                
                <!-- Product 5 -->
                <div class="group">
                    <a class="block" href="#">
                        <div class="w-full bg-stone-100 rounded-lg overflow-hidden mb-3">
                            <div class="w-full bg-center bg-no-repeat aspect-square bg-cover product-hover" style="background: linear-gradient(135deg, #ecfdf5 0%, #6ee7b7 100%); display: flex; align-items: center; justify-content: center;">
                                <span class="text-4xl">💚</span>
                            </div>
                        </div>
                        <h3 class="text-sm font-semibold text-stone-800 group-hover:text-amber-500">Emerald Cut Ring</h3>
                        <p class="text-sm text-stone-500">₹1,00,200.00</p>
                    </a>
                </div>
                
                <!-- Product 6 -->
                <div class="group">
                    <a class="block" href="#">
                        <div class="w-full bg-stone-100 rounded-lg overflow-hidden mb-3">
                            <div class="w-full bg-center bg-no-repeat aspect-square bg-cover product-hover" style="background: linear-gradient(135deg, #fef2f2 0%, #fca5a5 100%); display: flex; align-items: center; justify-content: center;">
                                <span class="text-4xl">❤️</span>
                            </div>
                        </div>
                        <h3 class="text-sm font-semibold text-stone-800 group-hover:text-amber-500">Ruby Solitaire Ring</h3>
                        <p class="text-sm text-stone-500">₹1,29,500.00</p>
                    </a>
                </div>
                
                <!-- Product 7 -->
                <div class="group">
                    <a class="block" href="#">
                        <div class="w-full bg-stone-100 rounded-lg overflow-hidden mb-3">
                            <div class="w-full bg-center bg-no-repeat aspect-square bg-cover product-hover" style="background: linear-gradient(135deg, #f5f3ff 0%, #c4b5fd 100%); display: flex; align-items: center; justify-content: center;">
                                <span class="text-4xl">💜</span>
                            </div>
                        </div>
                        <h3 class="text-sm font-semibold text-stone-800 group-hover:text-amber-500">Vintage Style Ring</h3>
                        <p class="text-sm text-stone-500">₹65,100.00</p>
                    </a>
                </div>
                
                <!-- Product 8 -->
                <div class="group">
                    <a class="block" href="#">
                        <div class="w-full bg-stone-100 rounded-lg overflow-hidden mb-3">
                            <div class="w-full bg-center bg-no-repeat aspect-square bg-cover product-hover" style="background: linear-gradient(135deg, #fffbeb 0%, #fed7aa 100%); display: flex; align-items: center; justify-content: center;">
                                <span class="text-4xl">🧡</span>
                            </div>
                        </div>
                        <h3 class="text-sm font-semibold text-stone-800 group-hover:text-amber-500">Bohemian Gemstone Ring</h3>
                        <p class="text-sm text-stone-500">₹35,100.00</p>
                    </a>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection

@push('scripts')
<script>
// Filter functionality for radio buttons
document.querySelectorAll('input[type="radio"]').forEach(radio => {
    radio.addEventListener('change', function() {
        // Here you would typically make an AJAX call to filter products
        console.log('Filter changed:', this.name, '=', this.parentElement.textContent.trim());
    });
});

// Price range functionality
document.querySelector('input[type="range"]').addEventListener('input', function() {
    console.log('Price range changed:', this.value);
    // Update price display and filter products
});

// Sort functionality
document.querySelector('select').addEventListener('change', function() {
    console.log('Sort changed:', this.value);
    // Here you would typically reload the product grid with new sorting
});

// Product hover effects
document.querySelectorAll('.product-hover').forEach(product => {
    product.addEventListener('mouseenter', function() {
        this.style.transform = 'scale(1.05)';
    });
    
    product.addEventListener('mouseleave', function() {
        this.style.transform = 'scale(1)';
    });
});
</script>
@endpush
