@extends('layouts.tenant')
@section('title', 'Upload Bukti DP - e-Kost')
@section('page-title', 'Upload Bukti DP')

@section('content')
    <div class="max-w-md mx-auto space-y-6">

        <div class="mb-2">
            <a href="{{ route('booking.upload-dp', $booking->id) }}"
                class="text-sm font-medium text-gray-500 hover:text-[#400000] inline-flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
            <h3 class="font-bold text-[#400000] text-lg mb-1">Konfirmasi Pembayaran DP</h3>
            <p class="text-sm text-gray-500 mb-6">Rp {{ number_format($booking->dp_amount, 0, ',', '.') }} &middot; Booking
                {{ $booking->booking_code }}</p>

            @if ($errors->any())
                <div class="mb-4 bg-red-50 text-red-700 px-4 py-3 rounded-xl text-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('booking.store-dp-proof', $booking->id) }}" method="POST" enctype="multipart/form-data"
                class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pengirim</label>
                    <input type="text" name="sender_name" value="{{ old('sender_name') }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-[#400000] focus:border-transparent transition"
                        placeholder="Nama sesuai rekening/akun pengirim" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Transfer</label>
                    <input type="date" name="transfer_date" value="{{ old('transfer_date', date('Y-m-d')) }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-[#400000] focus:border-transparent transition"
                        required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload Bukti Transfer</label>
                    <input type="file" name="proof_photo" accept="image/png,image/jpeg,image/jpg"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-[#F5E6E6] file:text-[#400000] file:font-medium"
                        required>
                    <p class="text-xs text-gray-400 mt-1">Format JPG/PNG, maksimal 2MB</p>
                </div>

                <button type="submit"
                    class="w-full bg-[#400000] text-white hover:bg-[#5c0000] rounded-xl px-6 py-3 font-bold transition shadow-md">
                    Kirim Bukti Pembayaran
                </button>
            </form>
        </div>

    </div>
@endsection