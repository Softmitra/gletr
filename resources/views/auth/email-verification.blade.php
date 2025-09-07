@extends('layouts.marketplace')

@section('title', 'Email Verification')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-amber-50 to-orange-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <div class="mx-auto h-16 w-16 bg-gradient-to-r from-amber-500 to-orange-500 rounded-full flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-white text-2xl">mark_email_unread</span>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Verify Your Email</h2>
            <p class="text-gray-600">We've sent a 6-digit verification code to</p>
            <p class="text-amber-600 font-semibold">{{ session('verification_email', 'your email address') }}</p>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 flex items-center">
                <span class="material-symbols-outlined text-green-500 mr-3">check_circle</span>
                <span class="text-green-700">{{ session('success') }}</span>
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

        <!-- OTP Form -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <form action="{{ route('seller.verify-email') }}" method="POST" id="otpForm">
                @csrf
                
                <div class="space-y-6">
                    <!-- OTP Input -->
                    <div>
                        <label for="otp" class="block text-sm font-medium text-gray-700 mb-2">
                            Enter Verification Code
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   id="otp" 
                                   name="otp" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent text-center text-2xl font-mono tracking-widest @error('otp') border-red-500 @enderror" 
                                   placeholder="000000"
                                   maxlength="6"
                                   required
                                   autocomplete="off">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <span class="material-symbols-outlined text-gray-400">key</span>
                            </div>
                        </div>
                        @error('otp')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Timer -->
                    <div class="text-center">
                        <div id="timer" class="text-sm text-gray-600 mb-2">
                            Code expires in: <span id="countdown" class="font-semibold text-amber-600">10:00</span>
                        </div>
                        <p class="text-xs text-gray-500">Didn't receive the code? <button type="button" id="resendBtn" class="text-amber-600 hover:text-amber-700 font-medium" disabled>Resend</button></p>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            id="verifyBtn"
                            class="w-full bg-gradient-to-r from-amber-500 to-orange-500 text-white py-3 px-4 rounded-lg font-semibold hover:from-amber-600 hover:to-orange-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span id="verifyText">Verify Email</span>
                        <span id="verifySpinner" class="hidden">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Verifying...
                        </span>
                    </button>
                </div>
            </form>

            <!-- Alternative Actions -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="text-center space-y-3">
                    <p class="text-sm text-gray-600">Having trouble?</p>
                    <div class="space-y-2">
                        <button type="button" id="resendOtpBtn" class="block w-full text-amber-600 hover:text-amber-700 text-sm font-medium">
                            Send new verification code
                        </button>
                        <a href="{{ route('seller.register') }}" class="block w-full text-gray-600 hover:text-gray-700 text-sm">
                            Back to registration
                        </a>
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
                    <p class="text-sm text-blue-700">Never share your verification code with anyone. Our team will never ask for this code.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden form for resend OTP -->
<form id="resendForm" action="{{ route('seller.resend-otp') }}" method="POST" style="display: none;">
    @csrf
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const otpInput = document.getElementById('otp');
    const otpForm = document.getElementById('otpForm');
    const verifyBtn = document.getElementById('verifyBtn');
    const verifyText = document.getElementById('verifyText');
    const verifySpinner = document.getElementById('verifySpinner');
    const resendBtn = document.getElementById('resendBtn');
    const resendOtpBtn = document.getElementById('resendOtpBtn');
    const resendForm = document.getElementById('resendForm');
    const countdown = document.getElementById('countdown');
    const timer = document.getElementById('timer');

    let timeLeft = 600; // 10 minutes in seconds
    let countdownInterval;

    // Format time as MM:SS
    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = seconds % 60;
        return `${minutes.toString().padStart(2, '0')}:${remainingSeconds.toString().padStart(2, '0')}`;
    }

    // Start countdown timer
    function startCountdown() {
        countdownInterval = setInterval(function() {
            timeLeft--;
            countdown.textContent = formatTime(timeLeft);
            
            if (timeLeft <= 0) {
                clearInterval(countdownInterval);
                countdown.textContent = '00:00';
                timer.innerHTML = '<span class="text-red-600 font-semibold">Code expired</span>';
                resendBtn.disabled = false;
                resendBtn.textContent = 'Resend Code';
                resendBtn.classList.remove('text-gray-400');
                resendBtn.classList.add('text-amber-600', 'hover:text-amber-700');
            }
        }, 1000);
    }

    // Auto-format OTP input (only numbers, max 6 digits)
    otpInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
        if (value.length > 6) {
            value = value.substring(0, 6);
        }
        e.target.value = value;
        
        // Auto-submit when 6 digits are entered
        if (value.length === 6) {
            setTimeout(() => {
                otpForm.submit();
            }, 500);
        }
    });

    // Handle form submission
    otpForm.addEventListener('submit', function(e) {
        if (otpInput.value.length !== 6) {
            e.preventDefault();
            otpInput.focus();
            return;
        }

        // Show loading state
        verifyBtn.disabled = true;
        verifyText.classList.add('hidden');
        verifySpinner.classList.remove('hidden');
    });

    // Handle resend OTP
    function resendOtp() {
        if (resendBtn.disabled) return;

        resendBtn.disabled = true;
        resendBtn.textContent = 'Sending...';
        
        fetch('{{ route("seller.resend-otp") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reset timer
                timeLeft = 600;
                countdown.textContent = formatTime(timeLeft);
                timer.innerHTML = 'Code expires in: <span id="countdown" class="font-semibold text-amber-600">' + formatTime(timeLeft) + '</span>';
                
                // Restart countdown
                clearInterval(countdownInterval);
                startCountdown();
                
                // Show success message
                showMessage('New verification code sent!', 'success');
                
                // Reset resend button
                setTimeout(() => {
                    resendBtn.disabled = true;
                    resendBtn.textContent = 'Resend';
                    resendBtn.classList.add('text-gray-400');
                    resendBtn.classList.remove('text-amber-600', 'hover:text-amber-700');
                }, 1000);
            } else {
                showMessage(data.message || 'Failed to send new code', 'error');
                resendBtn.disabled = false;
                resendBtn.textContent = 'Resend Code';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('Failed to send new code. Please try again.', 'error');
            resendBtn.disabled = false;
            resendBtn.textContent = 'Resend Code';
        });
    }

    // Handle resend button clicks
    resendBtn.addEventListener('click', resendOtp);
    resendOtpBtn.addEventListener('click', resendOtp);

    // Show message function
    function showMessage(message, type) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
            type === 'success' ? 'bg-green-50 border border-green-200 text-green-700' : 'bg-red-50 border border-red-200 text-red-700'
        }`;
        messageDiv.innerHTML = `
            <div class="flex items-center">
                <span class="material-symbols-outlined mr-3">${type === 'success' ? 'check_circle' : 'error'}</span>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(messageDiv);
        
        setTimeout(() => {
            messageDiv.remove();
        }, 5000);
    }

    // Start the countdown
    startCountdown();

    // Focus on OTP input
    otpInput.focus();
});
</script>
@endpush
