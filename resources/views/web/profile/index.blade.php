@extends('layouts.web')

@section('title', 'Profile - Gletr Jewellery Marketplace')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center py-12">
        <div class="text-gray-400 mb-4">
            <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-4">User Profile</h1>
        <p class="text-gray-600 mb-8">Profile management will be implemented soon.</p>
        <a href="{{ route('home') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
            Back to Home
        </a>
    </div>
</div>
@endsection
