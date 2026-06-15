<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — eKost</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .mono { font-family: 'DM Mono', monospace; }
    </style>
</head>
<body class="bg-[#F5F5F5] antialiased">

<div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">

    {{-- ===================== SIDEBAR ===================== --}}
    <aside
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed lg:static z-40 w-[220px] bg-[#400000] h-full flex flex-col transition-transform duration-300 lg:translate-x-0 flex-shrink-0"
    >
        {{-- Logo --}}
        <div class="px-5 py-6 border-b border-white/10">
    <div class="flex items-center gap-3">
        <img
            src="{{ asset('logo.png') }}"
            alt="E-Kost Logo"
            class="w-10 h-10 object-contain">

        <div>
            <div class="text-[22px] font-bold text-white tracking-tight">
                eKost.
            </div>
            <div class="text-[11px] text-white/50 uppercase tracking-widest">
                Tenant Portal
            </div>
        </div>
    </div>
</div>
        {{-- Nav links --}}
        @php
                    $navItems = [
                        ['route' => 'tenant.dashboard', 'label' => 'Dashboard',    'icon' => 'layout-dashboard'],
                        ['route' => 'booking.status',   'label' => 'My Bookingg',   'icon' => 'calendar-check'],
                        ['route' => 'payments.my',      'label' => 'Payments',     'icon' => 'receipt'],
                        ['route' => 'tenant.complaints.index', 'label' => 'Complaints', 'icon' => 'message-report'],
                        ['route' => 'profile.index',    'label' => 'Profile',      'icon' => 'user'],
                    ];
        @endphp

        <nav class="flex-1 px-3 py-4 flex flex-col gap-1">
            @foreach($navItems as $item)
                @php
                    $isActive = request()->routeIs($item['route'])
                        || request()->routeIs($item['route'] . '.*');
                @endphp
                <a
                    href="{{ route($item['route']) }}"
                    class="flex items-center gap-2.5 px-3 py-2.5 rounded-[10px] text-[13px] font-medium transition-colors duration-150
                        {{ $isActive
                            ? 'bg-[#F5E6E6] text-[#400000] font-semibold'
                            : 'text-white/70 hover:bg-white/10 hover:text-white' }}"
                >
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        @if($item['icon'] === 'layout-dashboard')
                            <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
                        @elseif($item['icon'] === 'calendar-check')
                            <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18M9 16l2 2 4-4"/>
                        @elseif($item['icon'] === 'receipt')
                            <path d="M4 4v16l4-2 4 2 4-2 4 2V4M9 12h6M9 8h6"/>
                        @elseif($item['icon'] === 'message-report')
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><path d="M12 8v4M12 16h.01"/>
                        @elseif($item['icon'] === 'user')
                            <circle cx="12" cy="7" r="4"/><path d="M5 21a7 7 0 0 1 14 0"/>
                        @endif
                    </svg>
                    {{ $item['label'] }}
                </a>
            @endforeach

            <div class="flex-1"></div>

            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-[10px] text-[13px] text-white/40 hover:text-white/70 hover:bg-white/10 transition-colors duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/>
                    </svg>
                    Logout
                </button>
            </form>
        </nav>
    </aside>

    {{-- Overlay mobile --}}
    <div
        x-show="sidebarOpen"
        @click="sidebarOpen = false"
        x-transition:enter="transition-opacity duration-200"
        x-transition:leave="transition-opacity duration-200"
        class="fixed inset-0 z-30 bg-black/40 lg:hidden"
        style="display:none"
    ></div>

    {{-- ===================== MAIN ===================== --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        {{-- Topbar --}}
        <header class="bg-white border-b border-gray-200 px-6 h-14 flex items-center justify-between flex-shrink-0">

            <div class="flex items-center gap-4">
                {{-- Hamburger mobile --}}
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-[#400000]" aria-label="Toggle menu">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <h1 class="text-[15px] font-semibold text-[#400000]">@yield('page-title')</h1>
            </div>

            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-green-500"></div>
                </div>
                <div class="w-8 h-8 rounded-full bg-[#400000] text-white flex items-center justify-center text-xs font-bold">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div class="hidden sm:block">
                    <div class="text-[13px] font-semibold leading-tight">{{ Auth::user()->name }}</div>
                    <div class="text-[11px] text-gray-400">Tenant aktif</div>
                </div>
            </div>
        </header>

        {{-- Content --}}
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>

    </div>
</div>

</body>
</html>