@extends('layouts.tenant')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

                <div class="space-y-5 max-w-5xl mx-auto">

                    {{-- ===================== WELCOME BANNER ===================== --}}
                    <div class="bg-[#400000] rounded-2xl px-7 py-6 text-white flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-bold mb-1">Halo, {{ $user->name }} 👋</h2>
                            <p class="text-white/60 text-sm">Selamat datang kembali di eKost.</p>
                        </div>

                        @if($booking && $booking->room)
                            <div class="bg-white/10 rounded-xl px-5 py-3 text-center flex-shrink-0">
                                <div class="text-[10px] text-white/50 uppercase tracking-widest mb-1">Kamar</div>
                                <div class="text-3xl font-bold">{{ $booking->room->room_number }}</div>
                            </div>
                        @endif
                    </div>

                    {{-- ===================== STATUS SEWA KAMAR ===================== --}}
                    @if($tenant && $tenant->status == 'active')
                        <div
                            class="bg-white rounded-2xl border border-gray-100 p-5 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div>
                                <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-1">Masa Sewa Berakhir</p>
                                <p class="text-lg font-bold text-[#400000]">{{ $tenant->end_date->translatedFormat('d F Y') }}</p>
                                @php
        $daysLeft = now()->diffInDays($tenant->end_date, false);
                                @endphp
                                @if($daysLeft <= 14 && $daysLeft >= 0)
                                    <span
                                        class="mt-1 inline-block bg-yellow-100 text-yellow-800 text-[11px] font-semibold px-2.5 py-1 rounded-full">
                                        ⚠️ {{ $daysLeft }} hari lagi
                                    </span>
                                @elseif($daysLeft < 0)
                                    <span class="mt-1 inline-block bg-red-100 text-red-700 text-[11px] font-semibold px-2.5 py-1 rounded-full">
                                        Sudah berakhir {{ abs($daysLeft) }} hari lalu
                                    </span>
                                @endif
                            </div>

                            <div class="flex gap-2 w-full sm:w-auto">
                                <a href="{{ route('extensions.create') }}"
                                    class="flex-1 sm:flex-none text-center bg-[#400000] text-white hover:bg-[#5c0000] rounded-xl px-5 py-2.5 font-semibold text-sm transition">
                                    Perpanjang Kontrak
                                </a>
                                <button type="button" onclick="document.getElementById('checkout-modal').classList.remove('hidden')"
                                    class="flex-1 sm:flex-none text-center bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-xl px-5 py-2.5 font-semibold text-sm transition">
                                    Akhiri Sewa
                                </button>
                            </div>
                        </div>
                    @elseif($tenant && $tenant->status == 'checkout_requested')
                        <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-5 text-center">
                            <p class="text-sm text-yellow-700 font-medium">Permintaan akhiri sewa sedang diproses admin.</p>
                        </div>
                    @endif

                    {{-- Modal Akhiri Sewa --}}
                    @if($tenant && $tenant->status == 'active')
                        <div id="checkout-modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
                            <div class="bg-white rounded-2xl p-6 w-full max-w-md">
                                <h3 class="font-bold text-[#400000] text-lg mb-2">Akhiri Sewa Kamar</h3>
                                <p class="text-sm text-gray-500 mb-4">Permintaan ini akan dikirim ke admin untuk diproses. Pastikan kamu sudah
                                    menyelesaikan semua pembayaran.</p>
                                <form action="{{ route('checkout.request') }}" method="POST">
                                    @csrf
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Alasan / Tanggal Rencana Keluar</label>
                                    <textarea name="checkout_reason" rows="3" required
                                        class="w-full border border-gray-300 rounded-xl px-4 py-2 mb-4 focus:ring-2 focus:ring-[#400000] focus:border-transparent transition"
                                        placeholder="Contoh: Sudah lulus kuliah, rencana keluar tanggal 30 Juni 2026"></textarea>
                                    <div class="flex gap-3">
                                        <button type="button" onclick="document.getElementById('checkout-modal').classList.add('hidden')"
                                            class="flex-1 border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-xl px-4 py-2.5 font-medium transition">
                                            Batal
                                        </button>
                                        <button type="submit"
                                            class="flex-1 bg-[#400000] text-white hover:bg-[#5c0000] rounded-xl px-4 py-2.5 font-bold transition">
                                            Kirim Permintaan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif

                    {{-- ===================== STAT CARDS ===================== --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        {{-- Status Booking --}}
                        <div class="bg-white rounded-xl border border-gray-100 p-5">
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-2">Status Booking</p>
                            <p class="text-xl font-bold text-[#400000]">
                                {{ $booking ? ucfirst($booking->status) : 'Belum Booking' }}
                            </p>
                            @if($booking)
                                <span class="mt-2 inline-block bg-green-100 text-green-800 text-[11px] font-semibold px-2.5 py-1 rounded-full">
                                    ✓ Terkonfirmasi
                                </span>
                            @else
                                <span class="mt-2 inline-block bg-gray-100 text-gray-500 text-[11px] font-semibold px-2.5 py-1 rounded-full">
                                    Belum ada booking
                                </span>
                            @endif
                        </div>

                        {{-- Kamar --}}
                        <div class="bg-white rounded-xl border border-gray-100 p-5">
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-2">Kamar</p>
                            <p class="text-xl font-bold text-[#400000]">
                                {{ $booking->room->room_number ?? '-' }}
                            </p>
                            @if($booking && $booking->room)
                                <p class="mt-2 text-[12px] text-gray-400">
                                    Lantai {{ $booking->room->floor ?? '-' }}
                                </p>
                            @endif
                        </div>

                        {{-- Pembayaran --}}
                        <div class="bg-white rounded-xl border border-gray-100 p-5">
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-2">Pembayaran</p>
                            <p class="text-xl font-bold text-[#400000]">{{ $payments->count() }} Riwayat</p>
                            @php
    $pending = $payments->where('status', 'pending')->count();
                            @endphp
                            @if($pending > 0)
                                <span class="mt-2 inline-block bg-yellow-100 text-yellow-800 text-[11px] font-semibold px-2.5 py-1 rounded-full">
                                    {{ $pending }} menunggu
                                </span>
                            @else
                                <span class="mt-2 inline-block bg-green-100 text-green-800 text-[11px] font-semibold px-2.5 py-1 rounded-full">
                                    Semua lunas
                                </span>
                            @endif
                        </div>

                    </div>

                    {{-- ===================== QUICK ACTIONS ===================== --}}
                    <div>
                        <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-3">Quick actions</p>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">

                            @php
    $actions = [
        ['route' => 'rooms', 'label' => 'Booking Room', 'desc' => 'Cari & pesan kamar', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
        ['route' => 'payments.my', 'label' => 'Payments', 'desc' => 'Lihat pembayaran', 'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z'],
        ['route' => 'tenant.complaints.index', 'label' => 'Complaints', 'desc' => 'Ajukan komplain', 'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'],
        ['route' => 'profile.index', 'label' => 'Profile', 'desc' => 'Kelola akun kamu', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
    ];
                            @endphp

                            @foreach($actions as $action)
                            <a href="{{ route($action['route']) }}"
                                class="bg-white rounded-xl border border-gray-100 p-4 hover:shadow-sm hover:border-[#F5E6E6] transition-all duration-150 group">
                                <div class="w-9 h-9 bg-[#F5E6E6] rounded-lg flex items-center justify-center mb-3 group-hover:bg-[#ecd5d5] transition-colors duration-150">
                                    <svg class="w-5 h-5 text-[#400000]" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $action['icon'] }}"/>
                                    </svg>
                                </div>
                                <p class="text-[13px] font-semibold text-[#400000]">{{ $action['label'] }}</p>
                                <p class="text-[11px] text-gray-400 mt-0.5">{{ $action['desc'] }}</p>
                            </a>
                            @endforeach

                        </div>
                    </div>

                    {{-- ===================== PAYMENT HISTORY ===================== --}}
                    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">

                        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                            <h2 class="text-[14px] font-bold text-[#400000]">Riwayat Pembayaran</h2>
                            <a href="{{ route('payments.my') }}"
                                class="text-[12px] text-[#400000] font-semibold hover:underline">
                                Lihat semua →
                            </a>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full text-[13px]">
                                <thead>
                                    <tr class="bg-[#F5E6E6]">
                                        <th class="px-6 py-3 text-left text-[11px] font-semibold text-[#400000] uppercase tracking-wider">Tanggal</th>
                                        <th class="px-6 py-3 text-left text-[11px] font-semibold text-[#400000] uppercase tracking-wider">Keterangan</th>
                                        <th class="px-6 py-3 text-right text-[11px] font-semibold text-[#400000] uppercase tracking-wider">Jumlah</th>
                                        <th class="px-6 py-3 text-left text-[11px] font-semibold text-[#400000] uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($payments as $payment)
                                                                        <tr class="hover:bg-gray-50 transition-colors duration-100">
                                                                            <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                                                                {{ $payment->created_at->translatedFormat('d M Y') }}
                                                                            </td>
                                                                            <td class="px-6 py-4 font-medium text-gray-800">
                                                                                {{ $payment->description ?? 'Pembayaran sewa' }}
                                                                            </td>
                                                                            <td class="px-6 py-4 text-right font-semibold text-[#400000] whitespace-nowrap mono">
                                                                                Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                                                            </td>
                                                                            <td class="px-6 py-4">
                                                                                @php
                                        $statusColor = match ($payment->status) {
                                            'paid', 'lunas' => 'bg-green-100 text-green-800',
                                            'verify' => 'bg-blue-100 text-blue-800',
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'overdue', 'failed', 'gagal' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100 text-gray-600',
                                        };
                                                                                @endphp
                                                                                <span class="inline-block px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $statusColor }}">
                                                                                    {{ $payment->status == 'verify' ? 'Menunggu Verifikasi' : ucfirst($payment->status) }}
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-10 text-center text-gray-400 text-sm">
                                                Belum ada riwayat pembayaran.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>

@endsection