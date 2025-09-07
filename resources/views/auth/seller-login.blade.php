<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - Seller Login</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500;700;900&family=Spline+Sans:wght@400;500;700&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <style type="text/tailwindcss">
        :root {
            --primary-color: #f59e0b;
            --primary-dark: #d97706;
        }
        body {
            font-family: "Spline Sans", "Noto Sans", sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="relative flex size-full min-h-screen flex-col bg-white group/design-root overflow-x-hidden">
        <div class="layout-container flex h-full grow flex-col">
            <!-- Header -->
            <header class="absolute top-0 left-0 right-0 z-10 flex items-center justify-between whitespace-nowrap px-10 py-6 text-gray-800">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-3xl text-amber-500">diamond</span>
                    <h1 class="text-2xl font-bold tracking-tighter">{{ config('app.name', 'Gletr') }}</h1>
                </div>
                <div class="flex items-center gap-6">
                    <a class="hover:text-gray-600 text-sm font-medium transition-colors" href="{{ route('home') }}">Shop</a>
                    <a class="hover:text-gray-600 text-sm font-medium transition-colors" href="{{ route('seller.promotion') }}">Sell</a>
                    <a class="hover:text-gray-600 text-sm font-medium transition-colors" href="#">About</a>
                  
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 grid grid-cols-1 lg:grid-cols-2">
                <!-- Login Form Section -->
                <div class="flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8">
                    <div class="w-full max-w-md space-y-8">
                        <div class="text-center">
                            <h2 class="text-4xl font-bold text-gray-900 tracking-tight">Seller Login</h2>
                            <p class="mt-2 text-gray-600">Access your dashboard to manage your jewelry store.</p>
                        </div>

                        <!-- Alert Messages -->
                        @if (session('success'))
                            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if (session('warning'))
                            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-lg">
                                {{ session('warning') }}
                            </div>
                        @endif

                        <!-- Login Form -->
                        <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-200">
                            <form action="{{ route('seller.login.store') }}" method="post" class="space-y-6">
                                @csrf
                                
                                <!-- Email Field -->
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-gray-700" for="email">Email</label>
                                    <input 
                                        class="form-input w-full rounded-md border-gray-300 bg-gray-50 h-12 px-4 text-gray-900 placeholder:text-gray-400 focus:ring-2 focus:ring-[var(--primary-color)] focus:border-transparent @error('email') border-red-300 focus:ring-red-500 @enderror" 
                                        id="email" 
                                        name="email"
                                        placeholder="you@example.com" 
                                        type="email"
                                        value="{{ old('email') }}"
                                        required 
                                        autofocus
                                    />
                                    @error('email')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Password Field -->
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between">
                                        <label class="text-sm font-medium text-gray-700" for="password">Password</label>
                                        <a class="text-sm text-[var(--primary-color)] hover:underline" href="{{ route('password.request') }}">Forgot password?</a>
                                    </div>
                                    <input 
                                        class="form-input w-full rounded-md border-gray-300 bg-gray-50 h-12 px-4 text-gray-900 placeholder:text-gray-400 focus:ring-2 focus:ring-[var(--primary-color)] focus:border-transparent @error('password') border-red-300 focus:ring-red-500 @enderror" 
                                        id="password" 
                                        name="password"
                                        placeholder="••••••••" 
                                        type="password"
                                        required
                                    />
                                    @error('password')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Remember Me -->
                                <div class="flex items-center">
                                    <input 
                                        id="remember" 
                                        name="remember" 
                                        type="checkbox" 
                                        class="h-4 w-4 text-[var(--primary-color)] focus:ring-[var(--primary-color)] border-gray-300 rounded transition-colors"
                                        {{ old('remember') ? 'checked' : '' }}
                                    >
                                    <label for="remember" class="ml-2 block text-sm text-gray-700 transition-colors cursor-pointer">
                                        Remember me
                                    </label>
                                </div>

                                <!-- Login Button -->
                                <button 
                                    type="submit"
                                    class="w-full flex items-center justify-center rounded-md h-12 px-6 bg-[var(--primary-color)] text-white text-base font-bold hover:bg-[var(--primary-dark)] transition-all duration-200 hover:transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-400 focus:ring-offset-gray-50"
                                >
                                    Log in
                                </button>
                            </form>

                            <!-- Sign Up Link -->
                            <div class="mt-6 text-center">
                                <p class="text-sm text-gray-600">
                                    Don't have an account? 
                                    <a class="font-medium text-[var(--primary-color)] hover:underline" href="{{ route('seller.register') }}">Sign up</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image Section -->
                <div class="hidden lg:block">
                    <img 
                        alt="Jewelry Collection" 
                        class="h-full w-full object-cover" 
                        src="https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80"
                    />
                </div>
            </main>
        </div>
    </div>

    <script>
        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('[class*="bg-green-50"], [class*="bg-red-50"], [class*="bg-yellow-50"]');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease-out';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);

        // Remember me checkbox functionality
        document.addEventListener('DOMContentLoaded', function() {
            const rememberCheckbox = document.getElementById('remember');
            const rememberLabel = document.querySelector('label[for="remember"]');
            
            // Add visual feedback on checkbox interaction
            rememberCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    rememberLabel.classList.add('text-amber-600');
                    rememberLabel.classList.remove('text-gray-700');
                } else {
                    rememberLabel.classList.add('text-gray-700');
                    rememberLabel.classList.remove('text-amber-600');
                }
            });

            // Form submission handling
            const loginForm = document.querySelector('form');
            const submitButton = loginForm.querySelector('button[type="submit"]');
            
            loginForm.addEventListener('submit', function(e) {
                // Add loading state to button
                submitButton.disabled = true;
                submitButton.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Logging in...
                `;
                
                // Re-enable button after 10 seconds as fallback
                setTimeout(() => {
                    submitButton.disabled = false;
                    submitButton.innerHTML = 'Log in';
                }, 10000);
            });
        });
    </script>
</body>
</html>