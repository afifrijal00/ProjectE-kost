<header class="sticky top-0 z-30 bg-white border-b border-gray-200 shadow-sm">
    <div class="flex items-center justify-between px-4 sm:px-6 h-16">
        
        <div class="flex items-center">
            <!-- Mobile Menu Toggler (Only in Admin/App Layout) -->
            @if(!isset($isTenant))
            <button class="text-gray-500 hover:text-[#035949] focus:outline-none lg:hidden mr-4" @click.stop="sidebarOpen = !sidebarOpen">
                <svg class="w-6 h-6" fill="none" class="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            @else
            <!-- Tenant Logo -->
            <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center cursor-pointer hover:opacity-90 transition">
                <svg class="h-8 w-8 text-[#012619]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="ml-2 font-bold text-xl text-[#012619]">eKost Tenant</span>
            </a>
            @endif

            <h1 class="text-xl font-bold text-[#012619] hidden sm:block">
                @isset($isTenant)
                    <!-- Tenant specific secondary nav or empty -->
                @else
                    @yield('header_title', 'Dashboard')
                @endisset
            </h1>
        </div>

        <div class="flex items-center space-x-4">
            
            <!-- Notification Bell -->
            <button class="relative p-2 text-gray-400 hover:text-[#035949] transition duration-200 focus:outline-none rounded-full hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <!-- Red dot wrapper -->
                <span class="absolute top-1 right-1.5 block h-2.5 w-2.5 rounded-full bg-red-500 ring-2 ring-white"></span>
            </button>

            <!-- Profile Dropdown -->
            <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none rounded-full ring-2 ring-transparent focus:ring-[#30BF62] transition duration-200 p-1">
                    <img class="h-8 w-8 rounded-full border border-gray-200 object-cover" src="https://placehold.co/100x100?text=US" alt="User avatar">
                    <span class="text-sm font-medium text-gray-700 hidden sm:block">{{ Auth::user()->name }}</span>
                    <svg class="w-4 h-4 text-gray-500 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-100" 
                     x-transition:enter-start="transform opacity-0 scale-95" 
                     x-transition:enter-end="transform opacity-100 scale-100" 
                     x-transition:leave="transition ease-in duration-75" 
                     x-transition:leave-start="transform opacity-100 scale-100" 
                     x-transition:leave-end="transform opacity-0 scale-95" 
                     class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50 ring-1 ring-black ring-opacity-5" 
                     x-cloak>
                    <div class="px-4 py-2 border-b border-gray-100 sm:hidden">
                        <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                    </div>
                    <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#035949] transition duration-200">Your Profile</a>
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#035949] transition duration-200">Settings</a>
                    <hr class="my-1 border-gray-100">
                    <form action="{{ route('logout') }}" method="POST">
    @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition duration-200">Sign out</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</header>
