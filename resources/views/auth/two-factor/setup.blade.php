@extends('layouts.marketplace')

@section('title', 'Setup Two-Factor Authentication - Gletr')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="text-center mb-8">
                <div class="flex items-center justify-center w-16 h-16 mx-auto bg-green-100 rounded-full mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900">Setup Two-Factor Authentication</h2>
                <p class="mt-2 text-gray-600">Add an extra layer of security to your account</p>
            </div>

            <div class="space-y-6">
                <!-- Step 1 -->
                <div class="border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <span class="inline-flex items-center justify-center w-6 h-6 bg-yellow-600 text-white text-sm font-medium rounded-full mr-3">1</span>
                        Install an Authenticator App
                    </h3>
                    <p class="text-gray-600 mb-4">
                        Download and install one of these authenticator apps on your mobile device:
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="flex items-center p-3 border border-gray-200 rounded-lg">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Google Authenticator</p>
                                <p class="text-xs text-gray-500">Free & Secure</p>
                            </div>
                        </div>
                        <div class="flex items-center p-3 border border-gray-200 rounded-lg">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Authy</p>
                                <p class="text-xs text-gray-500">Multi-device</p>
                            </div>
                        </div>
                        <div class="flex items-center p-3 border border-gray-200 rounded-lg">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Microsoft Authenticator</p>
                                <p class="text-xs text-gray-500">Enterprise grade</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <span class="inline-flex items-center justify-center w-6 h-6 bg-yellow-600 text-white text-sm font-medium rounded-full mr-3">2</span>
                        Scan QR Code
                    </h3>
                    <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-6">
                        <div class="flex-shrink-0">
                            <div class="bg-white p-4 border-2 border-gray-200 rounded-lg">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($qrCodeUrl) }}" 
                                     alt="2FA QR Code" 
                                     class="w-48 h-48">
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-600 mb-4">
                                Open your authenticator app and scan this QR code to add your Gletr account.
                            </p>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm font-medium text-gray-900 mb-2">Can't scan? Enter this code manually:</p>
                                <code class="text-sm bg-white px-2 py-1 rounded border font-mono">{{ $secret }}</code>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <span class="inline-flex items-center justify-center w-6 h-6 bg-yellow-600 text-white text-sm font-medium rounded-full mr-3">3</span>
                        Verify Setup
                    </h3>
                    <p class="text-gray-600 mb-4">
                        Enter the 6-digit code from your authenticator app to complete the setup:
                    </p>
                    
                    <form method="POST" action="{{ route('two-factor.enable') }}">
                        @csrf
                        <div class="flex items-center space-x-4">
                            <div class="flex-1 max-w-xs">
                                <input type="text" 
                                       name="code" 
                                       id="code"
                                       placeholder="000000"
                                       maxlength="6"
                                       class="block w-full px-3 py-2 border border-gray-300 rounded-md text-center text-lg font-mono focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                                       required
                                       autocomplete="off">
                                @error('code')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" 
                                    class="px-6 py-2 bg-yellow-600 text-white font-medium rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition duration-200">
                                Enable 2FA
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Security Notice -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Security Notice</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Keep your authenticator app secure and backed up</li>
                                    <li>You'll receive recovery codes after enabling 2FA</li>
                                    <li>Store recovery codes in a safe place</li>
                                    <li>2FA will be required for all future logins</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-between">
                <a href="{{ route('profile.edit') }}" 
                   class="px-4 py-2 text-gray-600 hover:text-gray-800 transition duration-200">
                    ← Back to Profile
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('code').addEventListener('input', function(e) {
    // Only allow numbers
    e.target.value = e.target.value.replace(/[^0-9]/g, '');
    
    // Auto-submit when 6 digits are entered
    if (e.target.value.length === 6) {
        e.target.form.submit();
    }
});
</script>
@endsection
