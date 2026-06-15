<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Welcome to e-Kost')</title>
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F2F2F2; color: #1a1a1a; }
        [x-cloak] { display: none !important; }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.0/dist/cdn.min.js"></script>
</head>
<body class="antialiased font-sans bg-[#FFFFFF] text-[#1a1a1a] flex flex-col min-h-screen">
    
    <!-- Guest Navbar -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
    <img src="{{ asset('logo.png') }}"
         alt="E-Kost Logo"
         class="h-10 w-auto">

    <span class="ml-2 font-bold text-xl text-[#012619]">
        E-Kost
    </span>
</div>
                
                <div class="hidden sm:flex sm:space-x-8 items-center">
                    <a href="{{ route('home') }}"
                        class="{{ request()->routeIs('home') ? 'text-[#400000] border-b-2 border-[#400000]' : 'text-gray-500 hover:text-[#400000]' }} px-3 py-2 rounded-md font-medium transition duration-200">Home</a>
                    <a href="{{ route('rooms') }}"
                        class="{{ request()->routeIs('rooms') ? 'text-[#400000] border-b-2 border-[#400000]' : 'text-gray-500 hover:text-[#400000]' }} px-3 py-2 rounded-md font-medium transition duration-200">Rooms</a>
                    <a href="{{ route('contact') }}"
                        class="{{ request()->routeIs('contact') ? 'text-[#400000] border-b-2 border-[#400000]' : 'text-gray-500 hover:text-[#400000]' }} px-3 py-2 rounded-md font-medium transition duration-200">Contact</a>
                
                    @auth
                        <a href="{{ Auth::user()->isAdmin() ? route('dashboard.index') : route('tenant.dashboard') }}"
                            class="bg-[#30BF62] text-white hover:bg-[#188C4A] px-4 py-2 rounded-xl font-medium transition duration-200">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-[#400000] border border-[#400000] hover:bg-[#400000] hover:text-white px-4 py-2 rounded-xl font-medium transition duration-200">Login</a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="-mr-2 flex items-center sm:hidden" x-data="{ mobileMenuOpen: false }">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-200" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <!-- Mobile menu panel could go here using Alpine -->
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="flex-grow w-full">
        @yield('content')
    </main>
 <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>
    <!-- Footer -->
    @include('partials.footer')
</body>
</html>
