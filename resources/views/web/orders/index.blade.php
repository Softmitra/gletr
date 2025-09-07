@extends('layouts.web')

@section('title', 'My Orders - Gletr Jewellery Marketplace')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center py-12">
        <div class="text-gray-400 mb-4">
            <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-4">My Orders</h1>
        <p class="text-gray-600 mb-8">Order management will be implemented soon.</p>
        <a href="{{ route('home') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
            Back to Home
        </a>
    </div>
</div>
@endsection
