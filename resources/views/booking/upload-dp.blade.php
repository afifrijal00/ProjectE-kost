@extends('layouts.tenant')
@section('title', 'Pembayaran DP - e-Kost')
@section('page-title', 'Pembayaran DP')

@section('content')
    <div class="max-w-md mx-auto space-y-6">

        {{-- Info Booking --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
            <p class="text-sm text-gray-500 mb-1">Total DP (50%)</p>
            <p class="text-3xl font-bold text-[#400000]">Rp {{ number_format($booking->dp_amount, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-400 mt-1">
                Kamar {{ $booking->room->room_number }} &middot; {{ $booking->duration }} bulan
            </p>
            <p class="text-xs text-gray-400 mt-1">Booking Code: {{ $booking->booking_code }}</p>
        </div>

        {{-- QRIS --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
            <h3 class="font-bold text-[#400000] mb-4">Scan QRIS</h3>
            <img src="{{ asset('images/payment/qris-kost.png') }}" alt="QRIS e-Kost"
                class="w-full max-w-xs mx-auto rounded-xl border border-gray-100">
            <p class="text-xs text-gray-400 mt-3">Scan menggunakan aplikasi e-wallet atau m-banking</p>
        </div>

        {{-- Transfer Bank --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-[#400000] mb-4 text-center">Atau Transfer Bank</h3>
            <div class="bg-[#F5E6E6] rounded-xl p-4 text-center">
                <p class="text-sm text-gray-600">Bank BCA</p>
                <p class="text-xl font-bold text-[#400000] tracking-wider my-1">1234567890</p>
                <p class="text-sm text-gray-600">a.n. Admin e-Kost</p>
            </div>
        </div>

        {{-- Tombol Kirim Bukti --}}
        <a href="{{ route('booking.upload-dp-proof', $booking->id) }}"
            class="block w-full text-center bg-[#400000] text-white hover:bg-[#5c0000] rounded-xl px-6 py-3 font-bold transition shadow-md">
            Kirim Bukti Pembayaran DP
        </a>

    </div>
@endsection