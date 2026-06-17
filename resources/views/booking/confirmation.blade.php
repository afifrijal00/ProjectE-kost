@extends('layouts.guest')
@section('title', 'Booking Confirmation - e-Kost')

@section('content')
    <div class="bg-[#F2F2F2] min-h-[calc(100vh-64px)] py-12 flex items-center justify-center">
        <div class="max-w-xl w-full mx-auto px-4">

            <div class="bg-white rounded-2xl shadow-md p-8 text-center relative overflow-hidden">
                <!-- Decorative Background Top -->
                <div class="absolute top-0 left-0 w-full h-2 bg-[#30BF62]"></div>

                <div class="mx-auto w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-[#30BF62]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                </div>

                <h1 class="text-3xl font-bold text-[#012619] mb-2">Booking Success!</h1>
                <p class="text-gray-500 mb-6">Your payment proof has been submitted and is currently under review by our admin. We will notify you once it's verified.</p>

                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 mb-8 max-w-sm mx-auto text-left">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-500 text-sm">ID Booking</span>
                        <span class="font-bold text-[#012619] text-sm">#{{ $booking->booking_code }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-500 text-sm">Kamar</span>
                        <span class="font-bold text-[#012619] text-sm">{{ $booking->room->type }} Room
                            {{ $booking->room->room_number }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-500 text-sm">Duration</span>
                        <span class="font-bold text-[#012619] text-sm">{{ $booking->duration }} Month(s)</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-500 text-sm">Start Date</span>
                        <span class="font-bold text-[#012619] text-sm">{{ $booking->start_date->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-500 text-sm">DP Amount</span>
                        <span class="font-bold text-[#30BF62] text-sm">Rp {{ number_format($booking->dp_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 text-sm">Status</span>
                        @if($booking->status == 'dp_paid')
                            <span class="bg-yellow-100 text-yellow-700 font-bold px-2 py-0.5 rounded text-xs">Waiting Admin Approval</span>
                        @elseif($booking->status == 'approved')
                            <span class="bg-green-100 text-[#188C4A] font-bold px-2 py-0.5 rounded text-xs">Approved</span>
                        @elseif($booking->status == 'rejected')
                            <span class="bg-red-100 text-red-600 font-bold px-2 py-0.5 rounded text-xs">Rejected</span>
                        @else
                            <span class="bg-gray-100 text-gray-600 font-bold px-2 py-0.5 rounded text-xs">Pending</span>
                        @endif
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('booking.status') }}"
                        class="bg-[#30BF62] text-white hover:bg-[#188C4A] px-6 py-2.5 rounded-xl font-medium transition duration-200">
                        Track Status
                    </a>
                    <button onclick="window.print()"
                        class="border border-[#035949] text-[#035949] hover:bg-[#035949] hover:text-white px-6 py-2.5 rounded-xl font-medium transition duration-200 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Print Receipt
                    </button>
                </div>
            </div>

        </div>
    </div>
@endsection
