@extends('layouts.guest')
@use('Illuminate\Support\Facades\Storage')
@section('title', 'Rooms - e-Kost')

@section('content')
    <div class="bg-[#F2F2F2] min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header & Filter Bar -->
            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-[#012619]">Kamar Tersedia</h1>
                    <p class="text-gray-500 mt-1">Showing {{ $rooms->total() }} results</p>
                </div>
                <form method="GET" action="{{ route('rooms') }}" class="flex space-x-2">
                    <select name="type" onchange="this.form.submit()"
                        class="border border-gray-300 rounded-xl px-4 py-2 focus:ring-[#30BF62] focus:border-[#30BF62] text-sm">
                        <option value="">Semua tipe</option>
                        <option value="Regular" {{ request('type') == 'Regular' ? 'selected' : '' }}>Regular</option>
                        <option value="VIP" {{ request('type') == 'VIP' ? 'selected' : '' }}>VIP</option>
                        <option value="Suite" {{ request('type') == 'Suite' ? 'selected' : '' }}>Suite</option>
                    </select>
                    <select name="sort" onchange="this.form.submit()"
                        class="border border-gray-300 rounded-xl px-4 py-2 focus:ring-[#30BF62] focus:border-[#30BF62] text-sm">
                        <option value="lowest" {{ request('sort') == 'lowest' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="highest" {{ request('sort') == 'highest' ? 'selected' : '' }}>Harga Tertinggi</option>
                    </select>
                </form>
            </div>

            <!-- Room Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($rooms as $room)
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition duration-200 group flex flex-col">
                        <div class="relative overflow-hidden h-48">
                            @if($room->photo)
                                <img src="{{ Storage::url($room->photo) }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <img src="https://placehold.co/400x300/e2e8f0/475569?text=Room+{{ $room->room_number }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @endif
                            <div
                                class="absolute top-3 right-3 bg-green-100 text-[#188C4A] px-2.5 py-1 rounded-full text-xs font-bold shadow-sm">
                                Available</div>
                        </div>
                        <div class="p-5 flex-grow flex flex-col justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-[#012619] mb-1">{{ $room->type }} Room {{ $room->room_number }}</h3>
                                <p class="text-[#30BF62] font-semibold mb-3">Rp {{ number_format($room->price, 0, ',', '.') }} <span
                                        class="text-xs font-normal text-gray-500">/ mo</span></p>

                                <ul class="text-sm text-gray-600 mb-4 space-y-1">
                                    @if($room->facilities)
                                        @foreach(array_slice($room->facilities, 0, 3) as $facility)
                                            <li class="flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-[#188C4A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                {{ $facility }}
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <a href="{{ route('rooms.show', $room->id) }}"
                                class="block w-full text-center border border-[#035949] text-[#035949] hover:bg-[#035949] hover:text-white rounded-xl px-4 py-2 transition duration-200">View
                                Detail</a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 text-center py-16 text-gray-400">
                        Belum ada kamar tersedia.
                    </div>
                @endforelse
            </div>

            <!-- Pagination (Static) -->
            <div class="mt-12 flex justify-center">
                {{ $rooms->links() }}
            </div>

        </div>
    </div>
@endsection
