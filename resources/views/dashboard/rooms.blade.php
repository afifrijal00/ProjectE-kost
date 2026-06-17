@extends('layouts.app')
@section('title', 'Manage Rooms - e-Kost')
@section('header_title', 'Manage Rooms')
@use('Illuminate\Support\Facades\Storage')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
        <!-- Filter -->
        <div class="flex space-x-2 w-full sm:w-auto mb-4 sm:mb-0">
            <form method="GET" action="{{ route('dashboard.rooms') }}">
        <select name="status" onchange="this.form.submit()" class="border border-gray-300 rounded-xl px-4 py-2 focus:ring-[#30BF62] focus:border-[#30BF62] text-sm">
            <option value="">Semua status</option>
            <option value="available"    {{ request('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
            <option value="occupied"     {{ request('status') == 'occupied' ? 'selected' : '' }}>Ditempati</option>
            <option value="maintenance"  {{ request('status') == 'maintenance' ? 'selected' : '' }}>Perbaikan</option>
        </select>
    </form>
        </div>

        <a href="{{ route('dashboard.rooms.form') }}" class="bg-[#ad3333] text-white hover:bg-[#400000] rounded-xl px-4 py-2 font-medium transition duration-200 shadow-sm flex items-center w-full sm:w-auto justify-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah kamar baru
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($rooms as $room)
            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition flex flex-col">
                <div class="h-40 bg-gray-200 relative">
                    @if($room->photo)
                        <img src="{{ Storage::url($room->photo) }}" class="w-full h-full object-cover">
                    @else
                        <img src="https://placehold.co/400x300/e2e8f0/475569?text=Room+{{ $room->room_number }}"
                            class="w-full h-full object-cover">
                    @endif

                    @if($room->status == 'available')
                        <div
                            class="absolute top-3 right-3 bg-green-100 text-[#188C4A] px-2 py-0.5 rounded-md text-xs font-bold ring-1 ring-green-400">
                            Available</div>
                    @elseif($room->status == 'occupied')
                        <div
                            class="absolute top-3 right-3 bg-gray-100 text-gray-700 px-2 py-0.5 rounded-md text-xs font-bold ring-1 ring-gray-400">
                            Occupied</div>
                    @else
                        <div
                            class="absolute top-3 right-3 bg-red-100 text-red-600 px-2 py-0.5 rounded-md text-xs font-bold ring-1 ring-red-400">
                            Maintenance</div>
                    @endif
                </div>
                <div class="p-5 flex-grow">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-bold text-lg text-[#012619]">Room {{ $room->room_number }}</h3>
                        <span class="text-sm font-semibold text-[#188C4A]">Rp {{ number_format($room->price, 0, ',', '.') }}</span>
                    </div>

                    <p class="text-sm text-gray-500 mb-4 line-clamp-2">
                        {{ $room->type }} Type
                        @if($room->facilities)
                            • {{ implode(', ', $room->facilities) }}
                        @endif
                    </p>

                    @if($room->activeTenant)
                        <div class="flex items-center text-xs text-gray-600 bg-gray-50 p-2 rounded-lg mb-4">
                            <div
                                class="w-6 h-6 rounded-full bg-green-100 text-[#188C4A] flex items-center justify-center font-bold mr-2 text-xs">
                                {{ strtoupper(substr($room->activeTenant->name, 0, 2)) }}
                            </div>
                            <span>By: <strong>{{ $room->activeTenant->name }}</strong></span>
                        </div>
                    @endif

                    <div class="mt-auto pt-4 border-t border-gray-100 flex justify-between space-x-2">
                        <a href="{{ route('dashboard.rooms.edit', $room->id) }}"
                            class="flex-1 text-center border border-[#035949] text-[#035949] hover:bg-[#035949] hover:text-white rounded-xl px-2 py-1.5 text-sm font-medium transition duration-200">Edit</a>
                        <form action="{{ route('dashboard.rooms.destroy', $room->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus room ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="flex-none bg-red-50 text-red-600 hover:bg-red-500 hover:text-white rounded-xl px-3 py-1.5 transition duration-200"
                                title="Delete">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-4 text-center py-16 text-gray-400">
                Belum ada data room.
            </div>
        @endforelse
    </div>
@endsection
