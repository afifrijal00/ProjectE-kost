@extends('layouts.tenant')
@section('title', 'My Payments - e-Kost')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Header Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-2xl shadow-md p-5 border-l-4 border-yellow-400">
                <h3 class="text-gray-500 text-sm font-medium">Tagihan Bulan Ini</h3>
                <p class="text-2xl font-bold text-[#012619] mt-1">
                    Rp {{ number_format($currentPayment->amount ?? 0, 0, ',', '.') }}
                </p>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-5 border-l-4 border-[#30BF62]">
                <h3 class="text-gray-500 text-sm font-medium">Status</h3>
                <p class="text-2xl font-bold text-[#012619] mt-1">
                    @if(($currentPayment->status ?? '') == 'paid')
                        <span class="text-[#188C4A]">Lunas</span>
                    @elseif(($currentPayment->status ?? '') == 'verify')
                        <span class="text-blue-500">Diverifikasi</span>
                    @elseif(($currentPayment->status ?? '') == 'overdue')
                        <span class="text-red-500">Overdue</span>
                    @else
                        <span class="text-yellow-500">Belum Bayar</span>
                    @endif
                </p>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-5 border-l-4 border-blue-400">
                <h3 class="text-gray-500 text-sm font-medium">Jatuh Tempo</h3>
                <p class="text-2xl font-bold text-[#012619] mt-1">
                    {{ isset($currentPayment) ? $currentPayment->due_date->format('d M Y') : '-' }}
                </p>
            </div>
        </div>

        <!-- Current Invoice -->
        @if(isset($currentPayment) && in_array($currentPayment->status, ['pending', 'overdue']))
            <div class="bg-white rounded-2xl shadow-md p-6 border border-yellow-200">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-[#012619] text-lg">Tagihan Aktif</h3>
                    @if($currentPayment->status == 'overdue')
                        <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-bold">Overdue</span>
                    @else
                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">Belum Dibayar</span>
                    @endif
                </div>
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500">Invoice #{{ $currentPayment->invoice_number }}</p>
                        <p class="text-sm text-gray-500 mt-1">Jatuh tempo: {{ $currentPayment->due_date->format('d M Y') }}</p>
                        <p class="text-2xl font-extrabold text-[#30BF62] mt-2">Rp
                            {{ number_format($currentPayment->amount, 0, ',', '.') }}</p>
                    </div>
                    <a href="{{ route('payments.pay', $currentPayment->id) }}"
                        class="bg-[#30BF62] text-white hover:bg-[#188C4A] rounded-xl px-6 py-3 font-bold transition duration-200 shadow-md flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        Bayar Sekarang
                    </a>
                </div>
            </div>
        @endif

        <!-- Payment History -->
        <div class="bg-white rounded-2xl shadow-md overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h3 class="font-bold text-[#012619] text-lg">Riwayat Pembayaran</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead class="bg-[#012619] text-white text-left text-sm uppercase font-semibold">
                        <tr>
                            <th class="px-6 py-4">Invoice</th>
                            <th class="px-6 py-4">Periode</th>
                            <th class="px-6 py-4">Amount</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                        @forelse($payments as $payment)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-medium">#{{ $payment->invoice_number }}</td>
                                <td class="px-6 py-4">{{ $payment->due_date->format('M Y') }}</td>
                                <td class="px-6 py-4 font-semibold text-[#012619]">Rp
                                    {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    @if($payment->status == 'paid')
                                        <span
                                            class="bg-green-100 text-[#188C4A] px-3 py-1 rounded-full text-xs font-semibold">Paid</span>
                                    @elseif($payment->status == 'overdue')
                                        <span
                                            class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-semibold">Overdue</span>
                                    @elseif($payment->status == 'pending')
                                        <span
                                            class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Pending</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($payment->status == 'paid')
                                        <a href="{{ route('payments.show', $payment->id) }}" class="text-gray-400 hover:text-blue-500 transition"
                                            title="View">
                                            <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                    @elseif($payment->status == 'verify')
                                        <span class="text-gray-400 text-xs italic">Menunggu admin</span>
                                    @elseif(in_array($payment->status, ['pending', 'overdue']))
                                        <a href="{{ route('payments.pay', $payment->id) }}"
                                            class="inline-block bg-[#30BF62] text-white px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-[#188C4A] transition">Bayar</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-400">Belum ada riwayat pembayaran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
@endsection