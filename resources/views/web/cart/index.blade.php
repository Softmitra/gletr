@extends('layouts.web')

@section('title', 'Shopping Cart - Gletr Jewellery Marketplace')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center py-12">
        <div class="text-gray-400 mb-4">
            <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01" />
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Shopping Cart</h1>
        <p class="text-gray-600 mb-8">Cart functionality will be implemented soon.</p>
        <a href="{{ route('products.index') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
            Continue Shopping
        </a>
    </div>
</div>
@endsection
