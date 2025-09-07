@extends('layouts.marketplace')

@section('title', 'Email Verification Recovery')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-amber-50 to-orange-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <div class="mx-auto h-16 w-16 bg-gradient-to-r from-amber-500 to-orange-500 rounded-full flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-white text-2xl">email_lock</span>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Email Verification Recovery</h2>
            <p class="text-gray-600">Lost your verification window? No problem!</p>
            <p class="text-sm text-gray-500 mt-2">Enter your email to continue verification</p>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 flex items-center">
                <span class="material-symbols-outlined text-green-500 mr-3">check_circle</span>
                <span class="text-green-700">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('info'))
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 flex items-center">
                <span class="material-symbols-outlined text-blue-500 mr-3">info</span>
                <span class="text-blue-700">{{ session('info') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 flex items-center">
                <span class="material-symbols-outlined text-red-500 mr-3">error</span>
                <span class="text-red-700">{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-center mb-2">
                    <span class="material-symbols-outlined text-red-500 mr-3">error</span>
                    <span class="text-red-700 font-medium">Please correct the following errors:</span>
                </div>
                <ul class="text-red-600 text-sm list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Recovery Form -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <form action="{{ route('seller.verification.recovery') }}" method="POST" id="recoveryForm">
                @csrf
                
                <div class="space-y-6">
                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address
                        </label>
                        <div class="relative">
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('email') border-red-500 @enderror" 
                                   placeholder="Enter your registered email"
                                   value="{{ old('email') }}"
                                   required
                                   autocomplete="email">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <span class="material-symbols-outlined text-gray-400">email</span>
                            </div>
                        </div>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status Check -->
                    <div id="statusCheck" class="hidden">
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-amber-500 mr-3"></div>
                                <span class="text-sm text-gray-600">Checking verification status...</span>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            id="recoveryBtn"
                            class="w-full bg-gradient-to-r from-amber-500 to-orange-500 text-white py-3 px-4 rounded-lg font-semibold hover:from-amber-600 hover:to-orange-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span id="recoveryText">Continue Verification</span>
                        <span id="recoverySpinner" class="hidden">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                        </span>
                    </button>
                </div>
            </form>

            <!-- Alternative Actions -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="text-center space-y-3">
                    <p class="text-sm text-gray-600">Need help?</p>
                    <div class="space-y-2">
                        <a href="{{ route('seller.register') }}" class="block w-full text-amber-600 hover:text-amber-700 text-sm font-medium">
                            Register new account
                        </a>
                        <a href="{{ route('seller.login') }}" class="block w-full text-gray-600 hover:text-gray-700 text-sm">
                            Already verified? Login
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Help Section -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <span class="material-symbols-outlined text-amber-500 mr-2">help</span>
                What happens next?
            </h3>
            <div class="space-y-3 text-sm text-gray-600">
                <div class="flex items-start">
                    <span class="material-symbols-outlined text-amber-500 mr-3 mt-0.5 text-sm">looks_one</span>
                    <div>
                        <p class="font-medium">We'll check your account status</p>
                        <p class="text-xs text-gray-500">Verify if your email needs verification</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <span class="material-symbols-outlined text-amber-500 mr-3 mt-0.5 text-sm">looks_two</span>
                    <div>
                        <p class="font-medium">Send verification code</p>
                        <p class="text-xs text-gray-500">New OTP will be sent to your email</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <span class="material-symbols-outlined text-amber-500 mr-3 mt-0.5 text-sm">looks_3</span>
                    <div>
                        <p class="font-medium">Complete verification</p>
                        <p class="text-xs text-gray-500">Enter the code to activate your account</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Notice -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start">
                <span class="material-symbols-outlined text-blue-500 mr-3 mt-0.5">security</span>
                <div>
                    <h4 class="text-sm font-medium text-blue-800 mb-1">Security Notice</h4>
                    <p class="text-sm text-blue-700">We'll only send verification codes to registered email addresses. If you don't receive an email, check your spam folder.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('email');
    const recoveryForm = document.getElementById('recoveryForm');
    const recoveryBtn = document.getElementById('recoveryBtn');
    const recoveryText = document.getElementById('recoveryText');
    const recoverySpinner = document.getElementById('recoverySpinner');
    const statusCheck = document.getElementById('statusCheck');

    // Check status when email is entered
    let checkTimeout;
    emailInput.addEventListener('input', function() {
        clearTimeout(checkTimeout);
        const email = this.value.trim();
        
        if (email && email.includes('@')) {
            checkTimeout = setTimeout(() => {
                checkVerificationStatus(email);
            }, 1000);
        } else {
            statusCheck.classList.add('hidden');
        }
    });

    // Check verification status
    function checkVerificationStatus(email) {
        statusCheck.classList.remove('hidden');
        
        fetch('{{ route("seller.verification.status") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => {
            statusCheck.classList.add('hidden');
            
            if (data.verified) {
                showStatusMessage('This email is already verified. You can login to your account.', 'success');
                recoveryText.textContent = 'Go to Login';
                recoveryBtn.onclick = function(e) {
                    e.preventDefault();
                    window.location.href = '{{ route("seller.login") }}';
                };
            } else if (data.has_pending_otp) {
                showStatusMessage('Found pending verification. Click to continue.', 'info');
                recoveryText.textContent = 'Continue Verification';
            } else if (data.exists) {
                showStatusMessage('Account found. We\'ll send a new verification code.', 'info');
                recoveryText.textContent = 'Send Verification Code';
            } else {
                showStatusMessage('No account found with this email.', 'error');
                recoveryText.textContent = 'Register New Account';
                recoveryBtn.onclick = function(e) {
                    e.preventDefault();
                    window.location.href = '{{ route("seller.register") }}';
                };
            }
        })
        .catch(error => {
            console.error('Error:', error);
            statusCheck.classList.add('hidden');
        });
    }

    // Show status message
    function showStatusMessage(message, type) {
        // Remove existing status messages
        const existingMessages = document.querySelectorAll('.status-message');
        existingMessages.forEach(msg => msg.remove());
        
        const messageDiv = document.createElement('div');
        messageDiv.className = `status-message p-3 rounded-lg text-sm ${
            type === 'success' ? 'bg-green-50 text-green-700 border border-green-200' :
            type === 'info' ? 'bg-blue-50 text-blue-700 border border-blue-200' :
            'bg-red-50 text-red-700 border border-red-200'
        }`;
        messageDiv.innerHTML = `
            <div class="flex items-center">
                <span class="material-symbols-outlined mr-2 text-sm">${
                    type === 'success' ? 'check_circle' :
                    type === 'info' ? 'info' : 'error'
                }</span>
                <span>${message}</span>
            </div>
        `;
        
        emailInput.parentNode.parentNode.appendChild(messageDiv);
    }

    // Handle form submission
    recoveryForm.addEventListener('submit', function(e) {
        // Show loading state
        recoveryBtn.disabled = true;
        recoveryText.classList.add('hidden');
        recoverySpinner.classList.remove('hidden');
    });
});
</script>
@endpush
