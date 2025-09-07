<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Seller Dashboard') - {{ config('app.name') }}</title>
    
    <!-- Fonts -->
    <link crossorigin="" href="https://fonts.gstatic.com/" rel="preconnect"/>
    <link as="style" href="https://fonts.googleapis.com/css2?display=swap&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900&amp;family=Spline+Sans%3Awght%40400%3B500%3B700" onload="this.rel='stylesheet'" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <!-- Custom Styles -->
    <style type="text/tailwindcss">
        :root {
            --primary-color: #667eea;
        }
        
        .nav-link-active {
            @apply bg-gray-100 text-gray-900;
        }
        
        .nav-link-inactive {
            @apply hover:bg-gray-100 text-gray-600 hover:text-gray-900;
        }
        
        .metric-card {
            @apply bg-white p-6 rounded-lg border border-gray-200 flex flex-col gap-2;
        }
        
        .status-badge {
            @apply px-2 py-1 text-xs font-medium rounded-full;
        }
        
        .status-pending {
            @apply text-yellow-800 bg-yellow-100;
        }
        
        .status-processing {
            @apply text-blue-800 bg-blue-100;
        }
        
        .status-shipped {
            @apply text-purple-800 bg-purple-100;
        }
        
        .status-delivered {
            @apply text-green-800 bg-green-100;
        }
        
        .status-cancelled {
            @apply text-red-800 bg-red-100;
        }
        
        .status-active {
            @apply text-green-800 bg-green-100;
        }
        
        .status-inactive {
            @apply text-gray-800 bg-gray-100;
        }
        
        .status-draft {
            @apply text-yellow-800 bg-yellow-100;
        }
        
        .status-verified {
            @apply text-green-800 bg-green-100;
        }
        
        .status-rejected {
            @apply text-red-800 bg-red-100;
        }
    </style>
    
    @yield('css')
</head>
<body class="bg-gray-50" style='font-family: "Spline Sans", "Noto Sans", sans-serif;'>
    <div class="relative flex size-full min-h-screen flex-col group/design-root overflow-x-hidden">
        <div class="flex flex-1">
            <!-- Sidebar -->
            <aside class="flex flex-col w-64 bg-white border-r border-gray-200 p-4">
                <!-- User Profile -->
                <div class="flex items-center gap-3 mb-8">
                    <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center">
                        @if(Auth::guard('seller')->user()->profile_image)
                            <img src="{{ asset('storage/' . Auth::guard('seller')->user()->profile_image) }}" 
                                 alt="Profile" class="w-full h-full rounded-full object-cover">
                        @else
                            <span class="text-white font-semibold text-lg">
                                {{ substr(Auth::guard('seller')->user()->business_name ?? 'S', 0, 1) }}
                            </span>
                        @endif
                    </div>
                    <div>
                        <h1 class="text-gray-800 text-sm font-semibold">
                            {{ Auth::guard('seller')->user()->business_name ?? 'Seller' }}
                        </h1>
                        <p class="text-gray-500 text-xs">Seller Account</p>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex flex-col gap-2">
                    <a class="flex items-center gap-3 px-3 py-2 rounded-md {{ request()->routeIs('seller.dashboard') ? 'nav-link-active' : 'nav-link-inactive' }}" 
                       href="{{ route('seller.dashboard') }}">
                        <span class="material-symbols-outlined text-xl">dashboard</span>
                        <span class="text-sm font-medium">Dashboard</span>
                    </a>
                    
                    <a class="flex items-center gap-3 px-3 py-2 rounded-md {{ request()->routeIs('seller.products.*') ? 'nav-link-active' : 'nav-link-inactive' }}" 
                       href="{{ route('seller.products.index') }}">
                        <span class="material-symbols-outlined text-xl">inventory_2</span>
                        <span class="text-sm font-medium">My Products</span>
                    </a>
                    
                    <a class="flex items-center gap-3 px-3 py-2 rounded-md {{ request()->routeIs('seller.orders.*') ? 'nav-link-active' : 'nav-link-inactive' }}" 
                       href="{{ route('seller.orders.index') }}">
                        <span class="material-symbols-outlined text-xl">shopping_bag</span>
                        <span class="text-sm font-medium">Orders</span>
                    </a>
                    
                    <a class="flex items-center gap-3 px-3 py-2 rounded-md {{ request()->routeIs('seller.store.*') ? 'nav-link-active' : 'nav-link-inactive' }}" 
                       href="{{ route('seller.store.show') }}">
                        <span class="material-symbols-outlined text-xl">store</span>
                        <span class="text-sm font-medium">My Store</span>
                    </a>
                    
                    <a class="flex items-center gap-3 px-3 py-2 rounded-md {{ request()->routeIs('seller.analytics.*') ? 'nav-link-active' : 'nav-link-inactive' }}" 
                       href="#">
                        <span class="material-symbols-outlined text-xl">bar_chart</span>
                        <span class="text-sm font-medium">Analytics</span>
                    </a>
                    
                    <!-- Account Submenu -->
                    <div class="mt-2">
                        <div class="text-xs font-medium text-gray-400 uppercase tracking-wider px-3 py-2">Account</div>
                        
                        <a class="flex items-center gap-3 px-3 py-2 rounded-md {{ request()->routeIs('seller.profile.*') ? 'nav-link-active' : 'nav-link-inactive' }}" 
                           href="{{ route('seller.profile.show') }}">
                            <span class="material-symbols-outlined text-xl">person</span>
                            <span class="text-sm font-medium">Profile</span>
                        </a>
                        
                        <a class="flex items-center gap-3 px-3 py-2 rounded-md {{ request()->routeIs('seller.verification.*') ? 'nav-link-active' : 'nav-link-inactive' }}" 
                           href="{{ route('seller.verification.status') }}">
                            <span class="material-symbols-outlined text-xl">verified</span>
                            <span class="text-sm font-medium">Verification</span>
                        </a>
                        
                        <a class="flex items-center gap-3 px-3 py-2 rounded-md {{ request()->routeIs('seller.sessions.*') ? 'nav-link-active' : 'nav-link-inactive' }}" 
                           href="{{ route('seller.sessions.index') }}">
                            <span class="material-symbols-outlined text-xl">security</span>
                            <span class="text-sm font-medium">Sessions</span>
                        </a>
                        
                        <a class="flex items-center gap-3 px-3 py-2 rounded-md nav-link-inactive" 
                           href="{{ route('seller.logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <span class="material-symbols-outlined text-xl">logout</span>
                            <span class="text-sm font-medium">Logout</span>
                        </a>
                        
                        <form id="logout-form" action="{{ route('seller.logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 p-8">
                <!-- Header -->
                <header class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                    @if(View::hasSection('page-subtitle'))
                        <p class="text-gray-600 mt-1">@yield('page-subtitle')</p>
                    @endif
                </header>

                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <span class="material-symbols-outlined text-green-500 mr-3">check_circle</span>
                            <div class="text-green-800">{{ session('success') }}</div>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <span class="material-symbols-outlined text-red-500 mr-3">error</span>
                            <div class="text-red-800">{{ session('error') }}</div>
                        </div>
                    </div>
                @endif

                @if (session('warning'))
                    <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <span class="material-symbols-outlined text-yellow-500 mr-3">warning</span>
                            <div class="text-yellow-800">{{ session('warning') }}</div>
                        </div>
                    </div>
                @endif

                @if (session('info'))
                    <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <span class="material-symbols-outlined text-blue-500 mr-3">info</span>
                            <div class="text-blue-800">{{ session('info') }}</div>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <span class="material-symbols-outlined text-red-500 mr-3 mt-0.5">error</span>
                            <div>
                                <div class="text-red-800 font-medium mb-2">Please fix the following errors:</div>
                                <ul class="text-red-700 text-sm list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Content -->
                @yield('content')
            </main>
        </div>
    </div>

    @yield('js')
    
    <script>
        // Auto-dismiss flash messages after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('[class*="bg-green-50"], [class*="bg-red-50"], [class*="bg-yellow-50"], [class*="bg-blue-50"]');
            alerts.forEach(function(alert) {
                if (alert.classList.contains('mb-6')) {
                    alert.style.transition = 'opacity 0.5s ease-out';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.remove();
                    }, 500);
                }
            });
        }, 5000);
    </script>
</body>
</html>
