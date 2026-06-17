@extends('layouts.app')
@section('title', 'Bookings - e-Kost')
@section('header_title', 'Manage Bookings')

@section('content')
    <div class="bg-white rounded-2xl shadow-md overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
            <form method="GET" action="{{ route('admin.bookings.index') }}" class="relative w-full sm:w-64">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari booking/tenant..."
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-xl focus:ring-[#30BF62] focus:border-[#30BF62] text-sm">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </form>
            <form method="GET" action="{{ route('admin.bookings.index') }}">
                <select name="status" onchange="this.form.submit()"
                    class="border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-[#30BF62]">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                    <option value="dp_paid" {{ request('status') == 'dp_paid' ? 'selected' : '' }}>Sudah DP</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead class="bg-[#400000] text-white text-left text-sm uppercase font-semibold">
                    <tr>
                        <th class="px-6 py-4">ID Booking</th>
                        <th class="px-6 py-4">Tenant</th>
                        <th class="px-6 py-4">Kamar</th>
                        <th class="px-6 py-4">Masa sewa</th>
                        <th class="px-6 py-4">Jumlah DP</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium">#{{ $booking->booking_code }}</td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $booking->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $booking->user->email }}</div>
                            </td>
                            <td class="px-6 py-4">Room {{ $booking->room->room_number }}</td>
                            <td class="px-6 py-4">{{ $booking->duration }} Month(s)</td>
                            <td class="px-6 py-4 font-semibold text-[#012619]">Rp
                                {{ number_format($booking->dp_amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @if($booking->status == 'pending')
                                    <span
                                        class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-semibold">Pending</span>
                                @elseif($booking->status == 'dp_paid')
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">DP
                                        Paid</span>
                                @elseif($booking->status == 'approved')
                                    <span
                                        class="bg-green-100 text-[#188C4A] px-3 py-1 rounded-full text-xs font-semibold">Approved</span>
                                @elseif($booking->status == 'rejected')
                                    <span
                                        class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-semibold">Rejected</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}"
                                    class="text-gray-400 hover:text-blue-500 transition p-1" title="View">
                                    <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-gray-400">Belum ada data booking.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-100">
            {{ $bookings->links() }}
        </div>
    </div>
@endsection