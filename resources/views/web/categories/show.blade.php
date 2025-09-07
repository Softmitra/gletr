@extends('layouts.web')

@section('title', $category->name . ' - Gletr Jewellery Marketplace')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li><a href="{{ route('home') }}" class="hover:text-blue-600">Home</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="{{ route('categories.index') }}" class="hover:text-blue-600">Categories</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-900">{{ $category->name }}</li>
        </ol>
    </nav>

    <!-- Category Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $category->name }}</h1>
        @if($category->description)
        <p class="text-gray-600 text-lg">{{ $category->description }}</p>
        @endif
    </div>

    @if(isset($subcategories) && $subcategories->count() > 0)
    <!-- Subcategories -->
    <div class="mb-12">
        <h2 class="text-2xl font-semibold text-gray-900 mb-6">Subcategories</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($subcategories as $subcategory)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $subcategory->name }}</h3>
                    @if($subcategory->description)
                    <p class="text-gray-600 text-sm mb-4">{{ $subcategory->description }}</p>
                    @endif
                    <a href="{{ route('categories.show', $subcategory) }}" 
                       class="inline-block bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700 transition-colors">
                        Browse {{ $subcategory->name }}
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @if(isset($products) && $products->count() > 0)
    <!-- Products -->
    <div>
        <h2 class="text-2xl font-semibold text-gray-900 mb-6">Products in {{ $category->name }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="aspect-w-1 aspect-h-1 bg-gray-200">
                    <!-- Product image placeholder -->
                    <div class="w-full h-48 bg-gray-300 flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $product->name }}</h3>
                    <p class="text-gray-600 text-sm mb-3">{{ Str::limit($product->description, 100) }}</p>
                    
                    @if($product->seller)
                    <p class="text-sm text-gray-500 mb-3">by {{ $product->seller->business_name }}</p>
                    @endif
                    
                    <div class="flex items-center justify-between">
                        <div class="text-lg font-bold text-gray-900">
                            @if($product->variants->count() > 0)
                                From ${{ number_format($product->variants->min('price'), 2) }}
                            @else
                                ${{ number_format($product->price ?? 0, 2) }}
                            @endif
                        </div>
                        <a href="{{ route('products.show', $product) }}" 
                           class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition-colors">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
        <div class="mt-8">
            {{ $products->links() }}
        </div>
        @endif
    </div>
    @else
    <!-- No Products -->
    <div class="text-center py-12">
        <div class="text-gray-400 mb-4">
            <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">No Products Available</h3>
        <p class="text-gray-600">Products in this category will be available soon.</p>
    </div>
    @endif
</div>
@endsection
