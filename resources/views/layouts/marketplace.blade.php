<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Gletr')) - Premium Jewellery Marketplace</title>
    <meta name="description" content="@yield('description', 'Discover exquisite jewellery from trusted sellers. Gold, Silver, Diamond and Platinum jewellery with hallmark certification and guaranteed authenticity.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500;700;900&family=Spline+Sans:wght@400;500;700&display=swap"
        rel="stylesheet">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">

    <!-- Font Awesome - Primary -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <!-- Font Awesome CDN Fallback -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <!-- Font Awesome Webfont Preload -->
    <link rel="preload" href="{{ asset('vendor/fontawesome-free/webfonts/fa-solid-900.woff2') }}" as="font"
        type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('vendor/fontawesome-free/webfonts/fa-regular-400.woff2') }}" as="font"
        type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('vendor/fontawesome-free/webfonts/fa-brands-400.woff2') }}" as="font"
        type="font/woff2" crossorigin>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Alpine.js cloak to prevent flashing */
        [x-cloak] {
            display: none !important;
        }

        /* Reference Design Styles */
        .stone-header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--stone-200);
        }

        .stone-card {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--stone-100);
            transition: all 0.3s ease;
        }

        .stone-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .product-hover:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }

        .accent-button {
            background-color: var(--amber-500);
            color: white;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .accent-button:hover {
            background-color: var(--amber-600);
            transform: translateY(-1px);
        }
        }

        @layer components {
            .material-icon {
                font-family: 'Material Symbols Outlined';
                font-weight: normal;
                font-style: normal;
                font-size: 24px;
                line-height: 1;
                letter-spacing: normal;
                text-transform: none;
                display: inline-block;
                white-space: nowrap;
                word-wrap: normal;
                direction: ltr;
            }

            .stone-button {
                @apply bg-amber-500 text-white px-4 py-2 rounded-lg font-semibold text-sm hover:bg-amber-600 transition-all duration-300;
            }

            .stone-input {
                @apply border-stone-300 bg-stone-100 focus:ring-amber-500 focus:border-amber-500 transition;
            }

            .stone-nav-link {
                @apply text-sm font-medium text-stone-600 hover:text-amber-500 transition-colors;
            }

            .stone-nav-active {
                @apply text-sm font-medium text-amber-500 font-semibold;
            }
    </style>

    @stack('styles')
</head>

<body class="bg-white text-stone-800" style='font-family: "Spline Sans", "Noto Sans", sans-serif;'>
    <!-- Mobile-First Header Design -->
    <header class="sticky top-0 z-50 w-full bg-white shadow-sm" x-data="{ mobileOpen: false, searchOpen: false }">
        <!-- Mobile Header -->
        <div class="md:hidden">
            <div class="flex items-center justify-between px-4 py-3">
                <!-- Logo -->
                <a class="flex items-center gap-2" href="/">
                    <span class="material-symbols-outlined text-2xl text-amber-500">diamond</span>
                    <h1 class="text-lg font-bold">Gletr</h1>
                </a>

                <!-- Mobile Icons -->
                <div class="flex items-center gap-1">
                    <!-- Search Toggle -->
                    <button @click="searchOpen = !searchOpen" class="p-2 rounded-full hover:bg-gray-100">
                        <span class="material-symbols-outlined text-gray-600">search</span>
                    </button>
                    <!-- Wishlist -->
                    <button class="p-2 rounded-full hover:bg-gray-100">
                        <span class="material-symbols-outlined text-gray-600">favorite_border</span>
                    </button>
                    <!-- Cart -->
                    <button class="relative p-2 rounded-full hover:bg-gray-100">
                        <span class="material-symbols-outlined text-gray-600">shopping_bag</span>
                        <span
                            class="absolute top-1 right-1 h-4 w-4 bg-amber-500 text-white text-xs rounded-full flex items-center justify-center">2</span>
                    </button>
                    <!-- Menu
                    <button @click="mobileOpen = !mobileOpen" class="p-2 rounded-full hover:bg-gray-100">
                        <span class="material-symbols-outlined text-gray-600"
                            x-text="mobileOpen ? 'close' : 'menu'">menu</span>
                    </button> -->
                </div>
            </div>

            <!-- Mobile Search Bar (Hidden by default) -->
            <div x-show="searchOpen" x-transition class="px-4 pb-3 border-t">
                <form action="{{ route('products.search') }}" method="GET" class="relative">
                    <input type="text" name="q" placeholder="Search diamonds, gold, silver..."
                        class="w-full px-4 py-2.5 pr-10 border border-gray-300 rounded-full text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                        value="{{ request('q') }}">
                    <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 p-1">
                        <span class="material-symbols-outlined text-gray-500 text-xl">search</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Desktop Header -->
        <div class="hidden md:block">
            <div class="container mx-auto flex items-center justify-between px-4 sm:px-6 lg:px-8 py-3">
                <!-- Logo Section -->
                <div class="flex items-center justify-between gap-8 w-full">
                    <!-- Logo -->
                    <a class="flex items-center gap-3 text-stone-900" href="/">
                        <span class="material-symbols-outlined text-3xl text-amber-500">diamond</span>
                        <h1 class="text-xl font-bold tracking-tighter">Gletr</h1>
                    </a>

                    <!-- Navigation Menu -->
                    <nav class="hidden lg:flex flex-1 justify-center items-center gap-6">
                        <a class="stone-nav-link" href="/new-arrivals">New Arrivals</a>
                        <a class="stone-nav-link" href="/bestsellers">Best Sellers</a>
                        <a class="stone-nav-link" href="/rings">Rings</a>
                        <a class="stone-nav-link" href="/necklaces">Necklaces</a>
                        <a class="stone-nav-link" href="/earrings">Earrings</a>
                        <a class="stone-nav-link" href="/bracelets">Bracelets</a>
                    </nav>
                </div>


                <!-- Right Section -->
                <div class="flex items-center justify-end gap-4">
                    <!-- Search Bar -->
                    <div class="relative items-center hidden lg:flex">
                        <span class="material-symbols-outlined absolute left-3 text-stone-500">search</span>
                        <input
                            class="form-input w-48 xl:w-64 rounded-full border-stone-300 bg-stone-100 pl-10 pr-4 py-2 text-sm text-stone-800 focus:ring-amber-500 focus:border-amber-500 transition"
                            placeholder="Search..." value="" />
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center gap-2">
                        <button class="lg:hidden p-2 rounded-full hover:bg-stone-100">
                            <span class="material-symbols-outlined text-stone-500">search</span>
                        </button>
                        <button class="p-2 rounded-full hover:bg-stone-100">
                            <span class="material-symbols-outlined text-stone-500">favorite_border</span>
                        </button>
                        <button class="relative p-2 rounded-full hover:bg-stone-100">
                            <span class="material-symbols-outlined text-stone-500">shopping_bag</span>
                            <span
                                class="absolute top-1 right-1 h-4 w-4 bg-amber-500 text-white text-xs rounded-full flex items-center justify-center">2</span>
                        </button>

                        <!-- Seller Login
                        <a href="{{ route('seller.login') }}"
                            class="hidden sm:flex items-center gap-2 px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition duration-300 text-sm font-medium">
                            <span class="material-symbols-outlined text-sm">store</span>
                            Seller Login
                        </a> -->

                        <!-- User Profile Dropdown -->
                        @auth
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open"
                                    class="flex items-center gap-2 p-2 rounded-full hover:bg-stone-100 transition-colors">
                                    @if (Auth::user()->profile_image)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_image) }}"
                                            alt="{{ Auth::user()->name }}" class="w-8 h-8 rounded-full object-cover">
                                    @else
                                        <div class="w-8 h-8 bg-amber-500 rounded-full flex items-center justify-center">
                                            <span
                                                class="text-white text-sm font-semibold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                    <span class="material-symbols-outlined text-stone-600 text-sm">expand_more</span>
                                </button>

                                <!-- Dropdown Menu -->
                                <div x-show="open" @click.away="open = false"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg border border-stone-200 py-2 z-50"
                                    style="display: none;">
                                    <!-- User Info -->
                                    <div class="px-4 py-3 border-b border-stone-100">
                                        <div class="flex items-center gap-3">
                                            @if (Auth::user()->profile_image)
                                                <img src="{{ asset('storage/' . Auth::user()->profile_image) }}"
                                                    alt="{{ Auth::user()->name }}"
                                                    class="w-10 h-10 rounded-full object-cover">
                                            @else
                                                <div
                                                    class="w-10 h-10 bg-amber-500 rounded-full flex items-center justify-center">
                                                    <span
                                                        class="text-white font-semibold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-semibold text-stone-900">{{ Auth::user()->name }}</p>
                                                <p class="text-sm text-stone-500">{{ Auth::user()->email }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Menu Items -->
                                    <div class="py-2">
                                        <!-- Profile -->
                                        <a href="{{ route('profile.edit') }}"
                                            class="flex items-center gap-3 px-4 py-2 text-sm text-stone-700 hover:bg-stone-50 transition-colors">
                                            <span class="material-symbols-outlined text-stone-500">person</span>
                                            Profile
                                        </a>

                                        <!-- Dashboard based on user role -->
                                        @if (Auth::user()->hasAnyRole(['super_admin', 'ops_admin']))
                                            <a href="{{ route('admin.dashboard') }}"
                                                class="flex items-center gap-3 px-4 py-2 text-sm text-stone-700 hover:bg-stone-50 transition-colors">
                                                <span
                                                    class="material-symbols-outlined text-stone-500">admin_panel_settings</span>
                                                Admin Dashboard
                                            </a>
                                        @elseif(Auth::user()->hasAnyRole(['seller_owner', 'seller_staff']))
                                            <a href="{{ route('seller.dashboard') }}"
                                                class="flex items-center gap-3 px-4 py-2 text-sm text-stone-700 hover:bg-stone-50 transition-colors">
                                                <span class="material-symbols-outlined text-stone-500">store</span>
                                                Seller Dashboard
                                            </a>
                                        @else
                                            <a href="{{ route('dashboard') }}"
                                                class="flex items-center gap-3 px-4 py-2 text-sm text-stone-700 hover:bg-stone-50 transition-colors">
                                                <span class="material-symbols-outlined text-stone-500">dashboard</span>
                                                Dashboard
                                            </a>
                                        @endif

                                        <!-- Orders -->
                                        <a href="#"
                                            class="flex items-center gap-3 px-4 py-2 text-sm text-stone-700 hover:bg-stone-50 transition-colors">
                                            <span class="material-symbols-outlined text-stone-500">shopping_bag</span>
                                            My Orders
                                        </a>

                                        <!-- Wishlist -->
                                        <a href="#"
                                            class="flex items-center gap-3 px-4 py-2 text-sm text-stone-700 hover:bg-stone-50 transition-colors">
                                            <span class="material-symbols-outlined text-stone-500">favorite</span>
                                            Wishlist
                                        </a>

                                        <div class="border-t border-stone-100 my-2"></div>

                                        <!-- Logout -->
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit"
                                                class="flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors w-full text-left">
                                                <span class="material-symbols-outlined text-red-500">logout</span>
                                                Logout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Guest User -->
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.login') }}"
                                    class="flex items-center gap-2 px-3 py-2 text-sm text-stone-600 hover:text-amber-500 transition-colors">
                                    <span class="material-symbols-outlined text-sm">login</span>
                                    Login
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Navigation Menu -->
    <div class="md:hidden fixed inset-0 z-40" x-show="mobileOpen" x-cloak style="display: none;">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-black bg-opacity-50" @click="mobileOpen = false"></div>

        <!-- Menu Panel -->
        <div class="fixed right-0 top-0 h-full w-80 max-w-full bg-white shadow-xl overflow-y-auto" x-show="mobileOpen"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">

            <!-- Menu Header -->
            <div class="flex items-center justify-between p-4 border-b">
                <h2 class="text-lg font-semibold">Menu</h2>
                <button @click="mobileOpen = false" class="p-2 rounded-full hover:bg-gray-100">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- Categories -->
            <div class="p-4">
                <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">Categories</h3>
                <div class="grid grid-cols-2 gap-3">
                    <a href="/rings"
                        class="flex flex-col items-center p-3 bg-gray-50 rounded-lg hover:bg-amber-50 transition">
                        <span class="text-2xl mb-1">💍</span>
                        <span class="text-sm">Rings</span>
                    </a>
                    <a href="/necklaces"
                        class="flex flex-col items-center p-3 bg-gray-50 rounded-lg hover:bg-amber-50 transition">
                        <span class="text-2xl mb-1">📿</span>
                        <span class="text-sm">Necklaces</span>
                    </a>
                    <a href="/earrings"
                        class="flex flex-col items-center p-3 bg-gray-50 rounded-lg hover:bg-amber-50 transition">
                        <span class="text-2xl mb-1">👂</span>
                        <span class="text-sm">Earrings</span>
                    </a>
                    <a href="/bracelets"
                        class="flex flex-col items-center p-3 bg-gray-50 rounded-lg hover:bg-amber-50 transition">
                        <span class="text-2xl mb-1">💫</span>
                        <span class="text-sm">Bracelets</span>
                    </a>
                </div>
            </div>

            <!-- Account Section -->
            <div class="p-4 border-t">
                @auth
                    <div class="mb-4">
                        <div class="flex items-center gap-3">
                            @if (Auth::user()->profile_image)
                                <img src="{{ asset('storage/' . Auth::user()->profile_image) }}"
                                    alt="{{ Auth::user()->name }}" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <div class="w-10 h-10 bg-amber-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-semibold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <div>
                                <p class="font-semibold">{{ Auth::user()->name }}</p>
                                <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                    </div>
                    <nav class="space-y-2">
                        <!-- Dashboard based on user role -->
                        @if (Auth::user()->hasAnyRole(['super_admin', 'ops_admin']))
                            <a href="{{ route('admin.dashboard') }}"
                                class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50">
                                <span class="material-symbols-outlined text-gray-600">admin_panel_settings</span>
                                <span>Admin Dashboard</span>
                            </a>
                        @elseif(Auth::user()->hasAnyRole(['seller_owner', 'seller_staff']))
                            <a href="{{ route('seller.dashboard') }}"
                                class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50">
                                <span class="material-symbols-outlined text-gray-600">store</span>
                                <span>Seller Dashboard</span>
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}"
                                class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50">
                                <span class="material-symbols-outlined text-gray-600">dashboard</span>
                                <span>Dashboard</span>
                            </a>
                        @endif

                        <a href="#" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50">
                            <span class="material-symbols-outlined text-gray-600">shopping_bag</span>
                            <span>My Orders</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50">
                            <span class="material-symbols-outlined text-gray-600">favorite</span>
                            <span>Wishlist</span>
                        </a>
                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50">
                            <span class="material-symbols-outlined text-gray-600">person</span>
                            <span>Profile</span>
                        </a>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 text-red-600 w-full text-left">
                                <span class="material-symbols-outlined">logout</span>
                                <span>Logout</span>
                            </button>
                        </form>
                    </nav>
                @else
                    <div class="space-y-3">
                        <a href="{{ route('admin.login') }}"
                            class="block w-full text-center py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                            Admin Login
                        </a>
                        <a href="{{ route('register') }}"
                            class="block w-full text-center py-3 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition">
                            Admin Sign Up
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Seller Section -->
            <div class="p-4 border-t">
                <div class="space-y-3">
                    <a href="{{ route('seller.login') }}"
                        class="flex items-center justify-center gap-2 w-full py-3 border border-amber-500 text-amber-500 rounded-lg hover:bg-amber-50 transition">
                        <span class="material-symbols-outlined text-sm">login</span>
                        <span>Seller Login</span>
                    </a>
                    <a href="{{ route('seller.promotion') }}"
                        class="flex items-center justify-center gap-2 w-full py-3 bg-stone-900 text-white rounded-lg hover:bg-stone-800 transition">
                        <span class="material-symbols-outlined text-sm">store</span>
                        <span>Become a Seller</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer matching reference design -->
    <footer class="bg-stone-50 text-stone-600">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
            <!-- Mobile-First Design -->
            <div class="space-y-8">
                <!-- Company Info - Always First on Mobile -->
                <div class="text-center sm:text-left">
                    <a class="flex items-center justify-center sm:justify-start gap-3 text-stone-900 mb-4"
                        href="/">
                        <span class="material-symbols-outlined text-3xl text-amber-500">diamond</span>
                        <h1 class="text-xl font-bold tracking-tighter">Gletr</h1>
                    </a>
                    <p class="text-sm max-w-sm mx-auto sm:mx-0 mb-6">Discover timeless elegance with our exquisite
                        collection of handcrafted jewelry.</p>
                    <div class="flex justify-center sm:justify-start space-x-4">
                        <!-- Facebook -->
                        <a class="hover:text-blue-600 transition-colors p-2 rounded-full hover:bg-blue-50"
                            href="#" title="Follow us on Facebook">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>

                        <!-- Instagram -->
                        <a class="hover:text-pink-600 transition-colors p-2 rounded-full hover:bg-pink-50"
                            href="#" title="Follow us on Instagram">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.347-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001 12.017.001z" />
                            </svg>
                        </a>

                        <!-- X (Twitter) -->
                        <a class="hover:text-gray-900 transition-colors p-2 rounded-full hover:bg-gray-50"
                            href="#" title="Follow us on X">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                            </svg>
                        </a>

                        <!-- YouTube -->
                        <a class="hover:text-red-600 transition-colors p-2 rounded-full hover:bg-red-50"
                            href="#" title="Subscribe to our YouTube">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                            </svg>
                        </a>

                        <!-- LinkedIn -->
                        <a class="hover:text-blue-700 transition-colors p-2 rounded-full hover:bg-blue-50"
                            href="#" title="Connect on LinkedIn">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Mobile: 2-Column Grid for Links, Desktop: Multi-Column -->
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6 lg:gap-8">
                    <!-- Quick Links -->
                    <div>
                        <h3 class="text-sm font-semibold text-stone-900 tracking-wider uppercase mb-3 sm:mb-4">Quick
                            Links</h3>
                        <nav class="space-y-2">
                            <a class="text-sm hover:text-amber-500 transition-colors block py-1"
                                href="/profile">Profile Info</a>
                            <a class="text-sm hover:text-amber-500 transition-colors block py-1"
                                href="/track-order">Track Order</a>
                            <a class="text-sm hover:text-amber-500 transition-colors block py-1" href="/wishlist">My
                                Wishlist</a>
                            <a class="text-sm hover:text-amber-500 transition-colors block py-1" href="/orders">My
                                Orders</a>
                            <a class="text-sm hover:text-amber-500 transition-colors block py-1" href="/help">Help
                                Center</a>
                        </nav>
                    </div>

                    <!-- Products -->
                    <div>
                        <h3 class="text-sm font-semibold text-stone-900 tracking-wider uppercase mb-3 sm:mb-4">Products
                        </h3>
                        <nav class="space-y-2">
                            <a class="text-sm hover:text-amber-500 transition-colors block py-1"
                                href="/featured">Featured Products</a>
                            <a class="text-sm hover:text-amber-500 transition-colors block py-1"
                                href="/bestsellers">Best Selling</a>
                            <a class="text-sm hover:text-amber-500 transition-colors block py-1" href="/latest">Latest
                                Products</a>
                            <a class="text-sm hover:text-amber-500 transition-colors block py-1" href="/top-rated">Top
                                Rated</a>
                            <a class="text-sm hover:text-amber-500 transition-colors block py-1"
                                href="/new-arrivals">New Arrivals</a>
                        </nav>
                    </div>

                    <!-- Policies -->
                    <div class="col-span-2 sm:col-span-1">
                        <h3 class="text-sm font-semibold text-stone-900 tracking-wider uppercase mb-3 sm:mb-4">Policies
                        </h3>
                        <nav class="space-y-2">
                            <a class="text-sm hover:text-amber-500 transition-colors block py-1" href="/about">About
                                Us</a>
                            <a class="text-sm hover:text-amber-500 transition-colors block py-1" href="/terms">Terms
                                & Conditions</a>
                            <a class="text-sm hover:text-amber-500 transition-colors block py-1"
                                href="/privacy">Privacy Policy</a>
                            <a class="text-sm hover:text-amber-500 transition-colors block py-1" href="/refund">Refund
                                Policy</a>
                            <a class="text-sm hover:text-amber-500 transition-colors block py-1" href="/return">Return
                                Policy</a>
                        </nav>
                    </div>

                    <!-- Other - Hidden on Mobile, Shown on SM+ -->
                    <div class="hidden sm:block">
                        <h3 class="text-sm font-semibold text-stone-900 tracking-wider uppercase mb-3 sm:mb-4">Other
                        </h3>
                        <nav class="space-y-2">
                            <a class="text-sm hover:text-amber-500 transition-colors block py-1"
                                href="/cancellation">Cancellation Policy</a>
                            <a class="text-sm hover:text-amber-500 transition-colors block py-1"
                                href="/shipping">Shipping Info</a>
                            <a class="text-sm hover:text-amber-500 transition-colors block py-1"
                                href="/size-guide">Size Guide</a>
                            <a class="text-sm hover:text-amber-500 transition-colors block py-1"
                                href="/care-guide">Care Instructions</a>
                            <a class="text-sm hover:text-amber-500 transition-colors block py-1"
                                href="/contact">Contact Us</a>
                        </nav>
                    </div>

                    <!-- Support - Mobile Only -->
                    <div class="sm:hidden">
                        <h3 class="text-sm font-semibold text-stone-900 tracking-wider uppercase mb-3">Support</h3>
                        <nav class="space-y-2">
                            <a class="text-sm hover:text-amber-500 transition-colors block py-1"
                                href="/shipping">Shipping Info</a>
                            <a class="text-sm hover:text-amber-500 transition-colors block py-1"
                                href="/size-guide">Size Guide</a>
                            <a class="text-sm hover:text-amber-500 transition-colors block py-1"
                                href="/contact">Contact Us</a>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Newsletter and Seller CTA Section -->
            <div class="mt-8 pt-6 sm:mt-12 sm:pt-8 border-t border-stone-200">
                <div class="space-y-6 sm:space-y-8">
                    <!-- Newsletter -->
                    <div class="flex flex-col sm:flex-row justify-between gap-8">
                        <!-- Newsletter -->
                        <div class="flex-1 text-center sm:text-left">
                            <h3 class="text-sm font-semibold text-stone-900 tracking-wider uppercase mb-3 sm:mb-4">
                                Stay Connected
                            </h3>
                            <p class="text-sm text-stone-600 mb-4">Get exclusive offers and updates</p>
                            <form class="flex flex-col sm:flex-row gap-3 sm:gap-2 max-w-md sm:max-w-full">
                                <input
                                    class="flex-1 px-4 py-3 sm:py-2 border border-stone-300 rounded-lg bg-white text-sm text-stone-800 focus:ring-amber-500 focus:border-amber-500 transition"
                                    placeholder="Enter your email..." type="email" required />
                                <button type="submit"
                                    class="bg-amber-500 text-white px-6 py-3 sm:py-2 rounded-lg hover:bg-amber-600 transition-colors text-sm font-semibold flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined text-sm">mail</span>
                                    Subscribe
                                </button>
                            </form>
                        </div>

                        <!-- Become Seller -->
                        <div class="flex-1 text-center sm:text-center">
                            <h4 class="text-sm font-semibold text-stone-900 tracking-wider uppercase mb-3 sm:mb-4">
                                Join Our Marketplace
                            </h4>
                            <p class="text-sm text-stone-600 mb-4">Start selling your jewelry today</p>
                            <a href="{{ route('seller.promotion') }}"
                                class="inline-flex items-center justify-center gap-2 bg-stone-900 text-white px-8 py-3 rounded-lg hover:bg-stone-800 transition-all duration-300 text-sm font-semibold group w-full sm:w-auto">
                                <span
                                    class="material-symbols-outlined text-sm group-hover:scale-110 transition-transform">store</span>
                                Become a Seller
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="mt-8 pt-6 sm:mt-12 sm:pt-8 border-t border-stone-200">
                <!-- Mobile: Stacked Layout -->
                <div class="flex flex-col items-center gap-4 sm:hidden">
                    <!-- Copyright -->
                    <p class="text-xs text-stone-500 text-center">© 2025 Gletr Marketplace. All rights reserved.</p>

                    <!-- Trust Badges -->
                    <div class="flex flex-wrap justify-center gap-4">
                        <div class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm text-green-600">verified_user</span>
                            <span class="text-xs">Secure Shopping</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm text-green-600">local_shipping</span>
                            <span class="text-xs">Free Shipping</span>
                        </div>
                    </div>
                </div>

                <!-- Desktop: Horizontal Layout -->
                <div class="hidden sm:flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="flex flex-col sm:flex-row items-center gap-4">
                        <p class="text-xs text-stone-500">© 2025 Gletr Marketplace. All rights reserved.</p>
                        <div class="flex gap-4">
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm text-green-600">verified_user</span>
                                <span class="text-xs">Secure Shopping</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm text-green-600">local_shipping</span>
                                <span class="text-xs">Free Shipping</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')

    <!-- Global FontAwesome Fallback System -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // FontAwesome Fallback System
            setTimeout(function() {
                const icons = document.querySelectorAll(
                    '.fa, .fas, .far, .fab, .fal, .fad, [class*="fa-"]');
                icons.forEach(function(icon) {
                    const computedStyle = window.getComputedStyle(icon);
                    if (computedStyle.fontFamily.indexOf('Font Awesome') === -1) {
                        // Add fallback based on icon class
                        const classList = icon.className;
                        let fallback = '•';

                        if (classList.includes('fa-home')) fallback = '🏠';
                        else if (classList.includes('fa-user')) fallback = '👤';
                        else if (classList.includes('fa-search')) fallback = '🔍';
                        else if (classList.includes('fa-shopping-cart')) fallback = '🛒';
                        else if (classList.includes('fa-shopping-bag')) fallback = '🛍️';
                        else if (classList.includes('fa-heart')) fallback = '❤️';
                        else if (classList.includes('fa-star')) fallback = '⭐';
                        else if (classList.includes('fa-phone')) fallback = '📞';
                        else if (classList.includes('fa-envelope')) fallback = '✉️';
                        else if (classList.includes('fa-map-marker')) fallback = '📍';
                        else if (classList.includes('fa-gem')) fallback = '💎';
                        else if (classList.includes('fa-crown')) fallback = '👑';
                        else if (classList.includes('fa-ring')) fallback = '💍';
                        else if (classList.includes('fa-certificate')) fallback = '🏆';
                        else if (classList.includes('fa-shield')) fallback = '🛡️';
                        else if (classList.includes('fa-check')) fallback = '✅';
                        else if (classList.includes('fa-times')) fallback = '❌';
                        else if (classList.includes('fa-plus')) fallback = '➕';
                        else if (classList.includes('fa-minus')) fallback = '➖';
                        else if (classList.includes('fa-arrow-right')) fallback = '→';
                        else if (classList.includes('fa-arrow-left')) fallback = '←';
                        else if (classList.includes('fa-arrow-up')) fallback = '↑';
                        else if (classList.includes('fa-arrow-down')) fallback = '↓';
                        else if (classList.includes('fa-menu') || classList.includes('fa-bars'))
                            fallback = '☰';

                        icon.innerHTML = fallback;
                        icon.className = icon.className.replace(/fa[srlab]?/g, '').replace(
                            /fa-[\w-]+/g, '') + ' emoji-icon';
                        icon.style.fontFamily =
                            '"Apple Color Emoji", "Segoe UI Emoji", "Noto Color Emoji", sans-serif';
                        icon.style.fontSize = '1.1em';
                    }
                });
            }, 1000);
        });
    </script>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>

</html>
