@extends('layouts.tenant')
@section('title', 'Tenant Dashboard - e-Kost')

@section('content')
<div class="space-y-6" data-aos="fade-up" data-aos-duration="800">
    <!-- Welcome Section -->
    <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-[#30BF62]">
        <h1 class="text-2xl font-bold text-[#012619]">Welcome back, {{ $tenant->name ?? 'Tenant' }}!</h1>
        <p class="text-gray-500 mt-1">Here is the summary of your rental and recent activities.</p>
    </div>

    <!-- Info Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Room Info Card -->
        <div class="bg-white rounded-2xl shadow-md p-6 flex flex-col justify-between" data-aos="fade-up" data-aos-delay="100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-500 font-medium">My Room</h3>
                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-[#188C4A]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                </div>
            </div>
            <div>
                <span class="text-2xl font-bold text-gray-900">Room {{ $room->number }}</span>
                <div class="mt-4 space-y-2">
                    <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                        <span class="text-sm text-gray-500">Monthly Price</span>
                        <span class="font-semibold text-gray-800">Rp {{ number_format($room->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-1">
                        <span class="text-sm text-gray-500">Contract Ends</span>
                        <span class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($room->contract_end)->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
            <div class="mt-6">
                <button onclick="window.location.href='{{ route('rooms.show', 1) }}'" class="w-full bg-[#f3f4f6] text-gray-700 hover:bg-gray-200 rounded-xl px-4 py-2 font-semibold transition duration-200 flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    <span>Lihat Kamar Saya</span>
                </button>
            </div>
        </div>

        <!-- Payment Status Card -->
        <div class="bg-white rounded-2xl shadow-md p-6 flex flex-col justify-between" data-aos="fade-up" data-aos-delay="200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-500 font-medium">Payment Status</h3>
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div>
                <span class="text-2xl font-bold text-gray-900">Rp {{ number_format($lastPayment->amount, 0, ',', '.') }}</span>
                <div class="mt-4 space-y-2">
                    <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                        <span class="text-sm text-gray-500">Last Payment</span>
                        <div class="text-right">
                            <span class="font-semibold text-gray-800 block">{{ \Carbon\Carbon::parse($lastPayment->date)->format('d M Y') }}</span>
                            <span class="text-xs font-medium text-green-600">{{ $lastPayment->status }}</span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center pt-1">
                        <span class="text-sm text-gray-500">Next Due</span>
                        <span class="font-semibold text-red-600">{{ \Carbon\Carbon::parse($nextDueDate)->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
            <div class="mt-6">
                <button onclick="window.location.href='{{ route('payments.upload') }}'" class="w-full bg-[#30BF62] text-white hover:bg-[#188C4A] rounded-xl px-4 py-2 font-semibold transition duration-200 shadow-sm shadow-green-200 flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    <span>Bayar Sewa</span>
                </button>
            </div>
        </div>

        <!-- Recent Complaints Card -->
        <div class="bg-white rounded-2xl shadow-md p-6 flex flex-col justify-between h-full" data-aos="fade-up" data-aos-delay="300">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-500 font-medium">Recent Complaints</h3>
                <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
            </div>
            
            <div class="flex-grow space-y-3 overflow-y-auto pr-1">
                @forelse($complaints as $complaint)
                    <div class="border-b border-gray-50 pb-3 last:border-0 last:pb-0">
                        <div class="flex justify-between items-start">
                            <p class="text-sm font-semibold text-gray-800 line-clamp-1 flex-1 pr-2">{{ $complaint->title }}</p>
                            <span class="text-[10px] uppercase tracking-wider font-bold px-2 py-1 rounded-md {{ $complaint->status === 'Resolved' ? 'bg-green-50 text-green-600 border border-green-100' : 'bg-yellow-50 text-yellow-600 border border-yellow-100' }}">
                                {{ $complaint->status }}
                            </span>
                        </div>
                        <div class="flex items-center mt-1.5 text-xs text-gray-400">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            {{ \Carbon\Carbon::parse($complaint->date)->format('d M Y') }}
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center h-full text-center py-4">
                        <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mb-2">
                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <p class="text-sm text-gray-500">No recent complaints.</p>
                        <p class="text-xs text-gray-400 mt-1">Everything is running smoothly.</p>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-4 pt-4 border-t border-gray-100">
                <button onclick="window.location.href='{{ route('complaints.create') }}'" class="w-full bg-white border-2 border-[#30BF62] text-[#30BF62] hover:bg-green-50 rounded-xl px-4 py-2 font-semibold transition duration-200 flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                    <span>Ajukan Komplain</span>
                </button>
            </div>
        </div>

    </div>
</div>
@endsection
