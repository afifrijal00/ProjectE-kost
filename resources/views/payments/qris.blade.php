@extends('layouts.tenant')
@section('title', 'Pembayaran - e-Kost')
@section('page-title', 'Pembayaran')

@section('content')
    <div class="max-w-md mx-auto space-y-6">

        <div class="mb-2">
            <a href="{{ route('payments.my') }}"
                class="text-sm font-medium text-gray-500 hover:text-[#400000] inline-flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>

        {{-- Info Tagihan --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
            <p class="text-sm text-gray-500 mb-1">Total Pembayaran</p>
            <p class="text-3xl font-bold text-[#400000]">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-400 mt-1">Kamar {{ $payment->tenant->room->room_number ?? '-' }} &middot;
                {{ $payment->due_date->translatedFormat('F Y') }}</p>
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
        <a href="{{ route('payments.upload-proof', $payment->id) }}"
            class="block w-full text-center bg-[#400000] text-white hover:bg-[#5c0000] rounded-xl px-6 py-3 font-bold transition shadow-md">
            Kirim Bukti Pembayaran
        </a>

    </div>
@endsection