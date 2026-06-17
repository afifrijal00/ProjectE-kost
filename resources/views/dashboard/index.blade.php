@extends('layouts.app')
@section('title', 'Admin Dashboard - e-Kost')
@section('header_title', 'Dashboard')

@section('content')
    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-md p-6 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <h3 class="text-gray-500 font-medium">Pendapatan Bulanan</h3>
                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-[#188C4A]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-2xl font-bold text-gray-900">Rp {{ number_format($monthlyIncome, 0, ',', '.') }}</span>
                <div class="flex items-center mt-1 text-sm text-green-500">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                    <span>Bulan ini</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-md p-6 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <h3 class="text-gray-500 font-medium">Kamar Tersedia</h3>
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-2xl font-bold text-gray-900">{{ $availableRooms }} <span
                        class="text-sm font-normal text-gray-500 border-l border-gray-300 pl-2 ml-2">Total:
                        {{ $totalRooms }}</span></span>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-md p-6 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <h3 class="text-gray-500 font-medium">Tenant Aktif</h3>
                <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-2xl font-bold text-gray-900">{{ $totalTenants }}</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-md p-6 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <h3 class="text-gray-500 font-medium">Komplain</h3>
                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-2xl font-bold text-gray-900">{{ $openComplaints }}</span>
                <div class="mt-1 text-sm text-red-500 flex items-center">Requires attention</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Chart Section (Dummy) -->
        <div class="bg-white rounded-2xl shadow-md p-6 lg:col-span-2 flex flex-col h-[400px]">
            <h3 class="font-bold text-[#012619] mb-6">Pendapatan vs Tingkat Hunian</h3>
            <div class="flex-grow flex items-end justify-between border-b border-gray-200 pb-2 space-x-2 px-2 relative" style="background: repeating-linear-gradient(0deg, transparent, transparent 38px, #f9fafb 38px, #f9fafb 40px);">
                @foreach($incomeChart as $data)
                    @php $height = $maxIncome > 0 ? round(($data['amount'] / $maxIncome) * 100) : 5; @endphp
                    <div class="w-1/12 bg-[#30BF62] rounded-t-sm hover:opacity-80 transition relative group"
                        style="height: {{ max($height, 5) }}%">
                        <div
                            class="hidden group-hover:block absolute -top-10 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded whitespace-nowrap">
                            {{ $data['month'] }}: Rp {{ number_format($data['amount'], 0, ',', '.') }}
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="flex justify-between mt-2 text-xs text-gray-400 px-2">
                @foreach($incomeChart as $data)
                    <span>{{ $data['month'] }}</span>
                @endforeach
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-2xl shadow-md p-6 h-[400px] overflow-hidden flex flex-col">
            <h3 class="font-bold text-[#012619] mb-4">Aktifitas Terbaru</h3>
            <div class="flex-grow overflow-y-auto pr-2 space-y-4">

                @forelse($recentPayments as $payment)
                    <div class="flex items-start">
                        <div
                            class="w-8 h-8 rounded-full bg-green-100 text-[#188C4A] flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Payment Verified</p>
                            <p class="text-xs text-gray-500">{{ $payment->tenant->name ?? '-' }} paid Rp
                                {{ number_format($payment->amount, 0, ',', '.') }}</p>
                            <span class="text-xs text-gray-400 mt-1 block">{{ $payment->verified_at?->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-gray-400">Belum ada pembayaran.</p>
                @endforelse

                @forelse($recentComplaints as $complaint)
                    <div class="flex items-start">
                        <div
                            class="w-8 h-8 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">New Complaint</p>
                            <p class="text-xs text-gray-500">{{ $complaint->tenant->name ?? '-' }} - {{ $complaint->title }}</p>
                            <span class="text-xs text-gray-400 mt-1 block">{{ $complaint->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-gray-400">Belum ada complaint.</p>
                @endforelse

                @forelse($recentBookings as $booking)
                    <div class="flex items-start">
                        <div
                            class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">New Booking</p>
                            <p class="text-xs text-gray-500">{{ $booking->user->name ?? '-' }} booked Room
                                {{ $booking->room->room_number ?? '-' }}</p>
                            <span class="text-xs text-gray-400 mt-1 block">{{ $booking->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-gray-400">Belum ada booking.</p>
                @endforelse

            </div>


            
    </div>
@endsection
