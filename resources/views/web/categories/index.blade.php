@extends('layouts.web')

@section('title', 'Categories - Gletr Jewellery Marketplace')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Shop by Category</h1>
        <p class="text-gray-600">Discover our extensive collection of fine jewellery across all categories</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($categories as $category)
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-3">{{ $category->name }}</h2>
                <p class="text-gray-600 mb-4">{{ $category->description }}</p>
                
                @if($category->children->count() > 0)
                <div class="mb-4">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Subcategories:</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($category->children->take(3) as $subcategory)
                        <a href="{{ route('categories.show', $subcategory) }}" 
                           class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded hover:bg-gray-200 transition-colors">
                            {{ $subcategory->name }}
                        </a>
                        @endforeach
                        @if($category->children->count() > 3)
                        <span class="text-xs text-gray-500">+{{ $category->children->count() - 3 }} more</span>
                        @endif
                    </div>
                </div>
                @endif
                
                <a href="{{ route('categories.show', $category) }}" 
                   class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
                    Browse {{ $category->name }}
                </a>
            </div>
        </div>
        @endforeach
    </div>

    @if($categories->isEmpty())
    <div class="text-center py-12">
        <div class="text-gray-400 mb-4">
            <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">No Categories Available</h3>
        <p class="text-gray-600">Categories will be available soon.</p>
    </div>
    @endif
</div>
@endsection
