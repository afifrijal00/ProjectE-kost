@extends('layouts.app')
@use('Illuminate\Support\Facades\Storage')
@section('title', 'Payment Detail - e-Kost')
@section('header_title', 'Payment Detail')

@section('content')
    @if(session('success'))
        <div class="max-w-3xl mx-auto mb-4">
            <div class="bg-green-50 text-green-700 px-4 py-3 rounded-xl text-sm">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="max-w-3xl mx-auto">
        <a href="{{ route('admin.payments.index') }}" class="text-sm font-medium text-gray-500 hover:text-[#012619] inline-flex items-center mb-6">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg> Back to Payments
        </a>

        <div class="bg-white rounded-2xl shadow-md p-6 sm:p-8">
            <div class="flex justify-between items-start mb-8 pb-6 border-b border-gray-100">
                <div>
                    <h2 class="text-2xl font-bold text-[#012619]">Invoice #{{ $payment->invoice_number }}</h2>
                    <p class="text-gray-500 mt-1">
                        @if($payment->verified_at)
                            Paid on {{ $payment->verified_at->format('d M Y, H:i') }}
                        @else
                            Submitted on {{ $payment->created_at->format('d M Y, H:i') }}
                        @endif
                    </p>
                </div>
                @if($payment->status == 'paid')
                    <span class="bg-green-100 text-[#188C4A] px-4 py-2 rounded-xl font-bold border border-green-200">Verified Paid</span>
                @elseif($payment->status == 'verify')
                    <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-xl font-bold border border-yellow-200">Pending
                        Verify</span>
                @elseif($payment->status == 'overdue')
                    <span class="bg-red-100 text-red-600 px-4 py-2 rounded-xl font-bold border border-red-200">Overdue</span>
                @else
                    <span class="bg-gray-100 text-gray-600 px-4 py-2 rounded-xl font-bold border border-gray-200">Pending</span>
                @endif
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mb-8">
                <div>
                    <h3 class="text-sm text-gray-500 mb-1">Billed To</h3>
                    <p class="font-bold text-[#012619] text-lg">{{ $payment->tenant->name }}</p>
                    <p class="text-gray-600">Room {{ $payment->tenant->room->room_number ?? '-' }}
                        ({{ $payment->tenant->room->type ?? '-' }})</p>
                    <p class="text-gray-600">{{ $payment->tenant->email }}</p>
                </div>
                <div class="sm:text-right">
                    <h3 class="text-sm text-gray-500 mb-1">Period</h3>
                    <p class="font-medium text-gray-800">{{ $payment->due_date->format('d M Y') }} -
                        {{ $payment->due_date->copy()->addMonth()->format('d M Y') }}</p>
                    <h3 class="text-sm text-gray-500 mb-1 mt-4">Due Date</h3>
                    <p class="font-medium text-gray-800">{{ $payment->due_date->format('d M Y') }}</p>
                </div>
            </div>

            <table class="w-full text-left mb-8">
                <thead>
                    <tr class="border-b border-gray-200 text-gray-500 text-sm">
                        <th class="font-normal pb-3 w-3/4">Description</th>
                        <th class="font-normal pb-3 text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800">
                    <tr>
                        <td class="py-4 border-b border-gray-100">Monthly Rent Fee - Room
                            {{ $payment->tenant->room->room_number ?? '-' }}</td>
                        <td class="py-4 border-b border-gray-100 text-right">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                    </tr>
                    @if($payment->transfer_date)
                        <tr>
                            <td class="py-4 border-b border-gray-100 text-sm text-gray-500">Transfer Date</td>
                            <td class="py-4 border-b border-gray-100 text-right text-sm text-gray-500">
                                {{ $payment->transfer_date->format('d M Y') }}</td>
                        </tr>
                    @endif
                    @if($payment->sender_name)
                        <tr>
                            <td class="py-4 border-b border-gray-100 text-sm text-gray-500">Sender Name</td>
                            <td class="py-4 border-b border-gray-100 text-right text-sm text-gray-500">{{ $payment->sender_name }}</td>
                        </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr class="text-lg">
                        <td class="py-4 font-bold text-[#012619] text-right">Total</td>
                        <td class="py-4 font-extrabold text-[#30BF62] text-right">Rp {{ number_format($payment->amount, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>

            <!-- Proof Image Link / Modal trigger -->
            @if($payment->proof_photo)
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center">
                            <svg class="w-8 h-8 text-[#188C4A] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <div>
                                <p class="font-medium text-gray-900">Transfer Proof</p>
                                <p class="text-xs text-gray-500">{{ basename($payment->proof_photo) }}</p>
                            </div>
                        </div>
                        <a href="{{ Storage::url($payment->proof_photo) }}" target="_blank"
                            class="text-[#035949] hover:underline text-sm font-medium">View Image</a>
                    </div>
                    <img src="{{ Storage::url($payment->proof_photo) }}" alt="Proof"
                        class="w-full max-h-64 object-contain rounded-xl border border-gray-200 bg-white">
                </div>
            @else
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 text-center text-gray-400 text-sm">
                    Belum ada bukti pembayaran diupload.
                </div>
            @endif

            <!-- Approve / Reject Actions -->
            @if($payment->status == 'verify')
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <h3 class="font-bold text-[#012619] mb-4">Verifikasi Pembayaran</h3>

                    <div class="flex flex-col sm:flex-row gap-3">
                        {{-- Approve --}}
                        <form action="{{ route('admin.payments.approve', $payment->id) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit"
                                onclick="return confirm('Konfirmasi pembayaran ini sebagai LUNAS?')"
                                class="w-full bg-[#30BF62] text-white hover:bg-[#188C4A] rounded-xl px-6 py-3 font-bold transition shadow-md flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Setujui Pembayaran
                            </button>
                        </form>

                        {{-- Reject --}}
                        <button type="button" onclick="document.getElementById('reject-modal').classList.remove('hidden')"
                            class="flex-1 bg-white border-2 border-red-300 text-red-600 hover:bg-red-50 rounded-xl px-6 py-3 font-bold transition flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Tolak
                        </button>
                    </div>
                </div>

                {{-- Reject Modal --}}
                <div id="reject-modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
                    <div class="bg-white rounded-2xl p-6 w-full max-w-md">
                        <h3 class="font-bold text-[#012619] text-lg mb-4">Tolak Pembayaran</h3>
                        <form action="{{ route('admin.payments.reject', $payment->id) }}" method="POST">
                            @csrf
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alasan Penolakan</label>
                            <textarea name="notes" rows="3" required
                                class="w-full border border-gray-300 rounded-xl px-4 py-2 mb-4 focus:ring-2 focus:ring-red-400 focus:border-transparent transition"
                                placeholder="Contoh: Bukti transfer tidak jelas / nominal tidak sesuai"></textarea>

                            <div class="flex gap-3">
                                <button type="button" onclick="document.getElementById('reject-modal').classList.add('hidden')"
                                    class="flex-1 border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-xl px-4 py-2.5 font-medium transition">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="flex-1 bg-red-500 text-white hover:bg-red-600 rounded-xl px-4 py-2.5 font-bold transition">
                                    Tolak Pembayaran
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            @if($payment->notes && $payment->status == 'pending')
                <div class="mt-4 bg-red-50 border border-red-200 rounded-xl p-4">
                    <p class="text-sm font-medium text-red-700 mb-1">Catatan Penolakan Sebelumnya:</p>
                    <p class="text-sm text-red-600">{{ $payment->notes }}</p>
                </div>
            @endif

        </div>
    </div>
@endsection