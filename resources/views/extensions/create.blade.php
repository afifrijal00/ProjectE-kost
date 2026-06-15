@extends('layouts.tenant')
@section('title', 'Perpanjang Kontrak - e-Kost')
@section('page-title', 'Perpanjang Kontrak')

@section('content')
    <div class="max-w-md mx-auto space-y-6">

        <div class="mb-2">
            <a href="{{ route('tenant.dashboard') }}"
                class="text-sm font-medium text-gray-500 hover:text-[#400000] inline-flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
            <h3 class="font-bold text-[#400000] text-lg mb-1">Perpanjang Masa Sewa</h3>
            <p class="text-sm text-gray-500 mb-6">
                Kamar {{ $tenant->room->room_number ?? '-' }} &middot; Berakhir
                {{ $tenant->end_date->translatedFormat('d F Y') }}
            </p>

            @if ($errors->any())
                <div class="mb-4 bg-red-50 text-red-700 px-4 py-3 rounded-xl text-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('extensions.store') }}" method="POST" class="space-y-5"
                x-data="{ duration: '1', price: {{ $tenant->room->price ?? 0 }} }">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Durasi Perpanjangan</label>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach([1 => '1 Bulan', 3 => '3 Bulan', 6 => '6 Bulan', 12 => '12 Bulan'] as $val => $label)
                            <label class="cursor-pointer">
                                <input type="radio" name="duration" value="{{ $val }}" x-model="duration" class="hidden peer" {{ $val == 1 ? 'checked' : '' }}>
                                <div
                                    class="border-2 border-gray-200 peer-checked:border-[#400000] peer-checked:bg-[#F5E6E6] rounded-xl px-4 py-3 text-center transition">
                                    <span class="font-semibold text-gray-700 peer-checked:text-[#400000]">{{ $label }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="bg-[#F5E6E6] rounded-xl p-4 text-center">
                    <p class="text-sm text-gray-600 mb-1">Total Pembayaran</p>
                    <p class="text-2xl font-bold text-[#400000]"
                        x-text="'Rp ' + (price * duration).toLocaleString('id-ID')"></p>
                </div>

                <button type="submit"
                    class="w-full bg-[#400000] text-white hover:bg-[#5c0000] rounded-xl px-6 py-3 font-bold transition shadow-md">
                    Lanjut ke Pembayaran
                </button>
            </form>
        </div>

    </div>
@endsection