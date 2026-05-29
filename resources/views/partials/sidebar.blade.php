<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="absolute z-40 flex flex-col w-64 h-screen px-4 py-8 overflow-y-auto bg-[#400000] border-r border-[#035949] transition-transform duration-300 ease-in-out lg:static lg:translate-x-0">

    <!-- Logo area -->
    <div class="flex items-center justify-between lg:justify-center mb-6 px-2">
        <a href="{{ route('dashboard.index') }}" class="flex items-center text-white space-x-2">
            <svg class="w-8 h-8 text-[#ad3333]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="text-2xl font-bold tracking-wider">eKost.</span>
        </a>

        <button @click="sidebarOpen = false"
            class="lg:hidden text-gray-300 hover:text-white rounded-md p-1 transition duration-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-[#30BF62]">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Navigation Links -->
    <div class="flex flex-col flex-1 mt-6">
        <nav class="space-y-1">

            <!-- Dashboard -->
            <a href="{{ route('dashboard.index') }}"
                class="group flex items-center px-4 py-3 rounded-xl border-l-4 transition duration-200
                {{ request()->routeIs('dashboard.index')
                    ? 'text-white bg-[#6d0000] border-[#ad3333]'
                    : 'text-gray-300 border-transparent hover:bg-[#6d0000] hover:text-white hover:border-[#ad3333]' }}">

                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>

                <span class="mx-4 font-medium">Dashboard</span>
            </a>

            <!-- Rooms -->
            <a href="{{ route('dashboard.rooms') }}"
                class="group flex items-center px-4 py-3 rounded-xl border-l-4 transition duration-200
                {{ request()->routeIs('dashboard.rooms*')
                    ? 'text-white bg-[#6d0000] border-[#ad3333]'
                    : 'text-gray-300 border-transparent hover:bg-[#6d0000] hover:text-white hover:border-[#ad3333]' }}">

                <svg class="w-5 h-5 group-hover:text-[#f5f5f5] transition duration-200"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>

                <span class="mx-4 font-medium">Rooms</span>
            </a>

            <!-- Tenants -->
            <a href="{{ route('tenants.index') }}"
                class="group flex items-center px-4 py-3 rounded-xl border-l-4 transition duration-200
                {{ request()->routeIs('tenants.*')
                    ? 'text-white bg-[#6d0000] border-[#ad3333]'
                    : 'text-gray-300 border-transparent hover:bg-[#6d0000] hover:text-white hover:border-[#ad3333]' }}">

                <svg class="w-5 h-5 group-hover:text-[#f5f5f5] transition duration-200"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>

                <span class="mx-4 font-medium">Tenants</span>
            </a>

            <!-- Bookings -->
            <a href="{{ route('admin.bookings.index') }}"
                class="group flex items-center px-4 py-3 rounded-xl border-l-4 transition duration-200
                {{ request()->routeIs('admin.bookings.*')
                    ? 'text-white bg-[#6d0000] border-[#ad3333]'
                    : 'text-gray-300 border-transparent hover:bg-[#6d0000] hover:text-white hover:border-[#ad3333]' }}">

                <svg class="w-5 h-5 group-hover:text-[#f5f5f5] transition duration-200"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>

                <span class="mx-4 font-medium">Bookings</span>
            </a>

            <!-- Payments -->
            <a href="{{ route('admin.payments.index') }}"
                class="group flex items-center px-4 py-3 rounded-xl border-l-4 transition duration-200
                {{ request()->routeIs('admin.payments.*')
                    ? 'text-white bg-[#6d0000] border-[#ad3333]'
                    : 'text-gray-300 border-transparent hover:bg-[#6d0000] hover:text-white hover:border-[#ad3333]' }}">

                <svg class="w-5 h-5 group-hover:text-[#f5f5f5] transition duration-200"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>

                <span class="mx-4 font-medium">Payments</span>
            </a>

            <!-- Complaints -->
            <a href="{{ route('admin.complaints.index') }}"
                class="group flex items-center px-4 py-3 rounded-xl border-l-4 transition duration-200
                {{ request()->routeIs('complaints.*')
                    ? 'text-white bg-[#6d0000] border-[#ad3333]'
                    : 'text-gray-300 border-transparent hover:bg-[#6d0000] hover:text-white hover:border-[#ad3333]' }}">

                <svg class="w-5 h-5 group-hover:text-[#f5f5f5] transition duration-200"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>

                <span class="mx-4 font-medium">Complaints</span>

                @php
                    $unreadComplaints = \App\Models\Complaint::where('is_read', false)->count();
                @endphp

                <span id="complaint-badge"
                    class="ml-auto py-0.5 px-2 bg-red-500 text-white text-xs rounded-full font-bold
                    {{ $unreadComplaints > 0 ? 'inline-block' : 'hidden' }}">

                    {{ $unreadComplaints > 0 ? $unreadComplaints : '' }}
                </span>
            </a>

            <!-- Reminders -->
            <a href="{{ route('reminders.index') }}"
                class="group flex items-center px-4 py-3 rounded-xl border-l-4 transition duration-200
                {{ request()->routeIs('reminders.*')
                    ? 'text-white bg-[#6d0000] border-[#ad3333]'
                    : 'text-gray-300 border-transparent hover:bg-[#6d0000] hover:text-white hover:border-[#ad3333]' }}">

                <svg class="w-5 h-5 group-hover:text-[#f5f5f5] transition duration-200"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>

                <span class="mx-4 font-medium">Reminders</span>
            </a>

            <!-- Reports -->
            <a href="{{ route('reports.index') }}"
                class="group flex items-center px-4 py-3 rounded-xl border-l-4 transition duration-200
                {{ request()->routeIs('reports.*')
                    ? 'text-white bg-[#6d0000] border-[#ad3333]'
                    : 'text-gray-300 border-transparent hover:bg-[#6d0000] hover:text-white hover:border-[#ad3333]' }}">

                <svg class="w-5 h-5 group-hover:text-[#f5f5f5] transition duration-200"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>

                <span class="mx-4 font-medium">Reports</span>
            </a>

        </nav>
    </div>

</aside>

<script>
    function loadComplaintBadge() {
        fetch('/admin/complaints/unread-count')
            .then(response => response.json())
            .then(data => {

                const badge = document.getElementById('complaint-badge');

                if (data.count > 0) {
                    badge.innerText = data.count;
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            })
            .catch(error => console.log(error));
    }

    loadComplaintBadge();
    setInterval(loadComplaintBadge, 5000);
</script>

<!-- Black Overlay (Mobile) -->
<div x-show="sidebarOpen"
    x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-30 bg-gray-900 bg-opacity-50 lg:hidden"
    @click="sidebarOpen = false"
    x-cloak>
</div>