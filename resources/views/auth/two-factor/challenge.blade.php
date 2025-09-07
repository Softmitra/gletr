@extends('layouts.marketplace')

@section('title', 'Two-Factor Authentication - Gletr')

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="text-center">
            <div class="flex items-center justify-center w-16 h-16 mx-auto bg-yellow-100 rounded-full mb-4">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-900">Two-Factor Authentication</h2>
            <p class="mt-2 text-sm text-gray-600">
                Please enter your authentication code to continue
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow-lg sm:rounded-lg sm:px-10">
            <form method="POST" action="{{ route('two-factor.verify') }}" class="space-y-6">
                @csrf

                <!-- Authentication Code -->
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                        Authentication Code
                    </label>
                    <div class="mt-1">
                        <input id="code" 
                               name="code" 
                               type="text" 
                               placeholder="000000"
                               maxlength="10"
                               autocomplete="off"
                               required 
                               class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-md placeholder-gray-400 text-center text-lg font-mono focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                    </div>
                    <p class="mt-2 text-xs text-gray-500">
                        Enter the 6-digit code from your authenticator app
                    </p>
                    @error('code')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-200">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-yellow-500 group-hover:text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                            </svg>
                        </span>
                        Verify & Continue
                    </button>
                </div>

                <!-- Recovery Code Option -->
                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Having trouble?</span>
                        </div>
                    </div>

                    <div class="mt-6 text-center">
                        <button type="button" 
                                onclick="toggleRecoveryMode()"
                                class="text-sm text-yellow-600 hover:text-yellow-500 font-medium">
                            Use a recovery code instead
                        </button>
                    </div>
                </div>
            </form>

            <!-- Recovery Code Form (Hidden by default) -->
            <form method="POST" action="{{ route('two-factor.verify') }}" id="recoveryForm" class="hidden space-y-6">
                @csrf
                <div>
                    <label for="recovery_code" class="block text-sm font-medium text-gray-700 mb-2">
                        Recovery Code
                    </label>
                    <div class="mt-1">
                        <input id="recovery_code" 
                               name="code" 
                               type="text" 
                               placeholder="recovery-code"
                               maxlength="10"
                               autocomplete="off"
                               class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-md placeholder-gray-400 text-center font-mono focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                    </div>
                    <p class="mt-2 text-xs text-gray-500">
                        Enter one of your 10-character recovery codes
                    </p>
                </div>

                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-200">
                        Use Recovery Code
                    </button>
                </div>

                <div class="text-center">
                    <button type="button" 
                            onclick="toggleRecoveryMode()"
                            class="text-sm text-yellow-600 hover:text-yellow-500 font-medium">
                        ← Back to authenticator code
                    </button>
                </div>
            </form>

            <!-- Help Section -->
            <div class="mt-8 p-4 bg-gray-50 rounded-md">
                <h3 class="text-sm font-medium text-gray-900 mb-2">Need Help?</h3>
                <ul class="text-xs text-gray-600 space-y-1">
                    <li>• Make sure your device's time is synchronized</li>
                    <li>• Try refreshing your authenticator app</li>
                    <li>• Use a recovery code if you can't access your authenticator</li>
                    <li>• Contact support if you're still having issues</li>
                </ul>
            </div>
        </div>

        <!-- Additional Links -->
        <div class="mt-8 text-center">
            <div class="text-xs text-gray-500">
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-yellow-600 hover:text-yellow-500">
                        Sign out
                    </button>
                </form>
                |
                <a href="#" class="text-yellow-600 hover:text-yellow-500">Contact Support</a>
            </div>
        </div>
    </div>
</div>

<script>
function toggleRecoveryMode() {
    const authForm = document.querySelector('form:not(#recoveryForm)');
    const recoveryForm = document.getElementById('recoveryForm');
    
    authForm.classList.toggle('hidden');
    recoveryForm.classList.toggle('hidden');
}

// Auto-format and submit codes
document.getElementById('code').addEventListener('input', function(e) {
    e.target.value = e.target.value.replace(/[^0-9]/g, '');
    if (e.target.value.length === 6) {
        e.target.form.submit();
    }
});

document.getElementById('recovery_code').addEventListener('input', function(e) {
    e.target.value = e.target.value.replace(/[^a-zA-Z0-9]/g, '').toLowerCase();
    if (e.target.value.length === 10) {
        e.target.form.submit();
    }
});
</script>
@endsection
