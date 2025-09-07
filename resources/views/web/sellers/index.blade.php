@extends('layouts.web')

@section('title', 'Our Sellers - Gletr Jewellery Marketplace')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center py-12">
        <div class="text-gray-400 mb-4">
            <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Our Verified Sellers</h1>
        <p class="text-gray-600 mb-8">Seller directory will be implemented soon.</p>
        <a href="{{ route('home') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
            Back to Home
        </a>
    </div>
</div>
@endsection
