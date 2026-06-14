@extends('layouts.app')
@section('title', 'Payments List - e-Kost')
@section('header_title', 'Payments')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-yellow-400">
            <h3 class="text-gray-500 text-sm font-medium">Pending Verifications</h3>
            <p class="text-2xl font-bold text-[#012619] mt-1">{{ $pendingCount }} <span
                    class="text-sm font-normal text-gray-500">tickets</span></p>
        </div>
        <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-[#30BF62]">
            <h3 class="text-gray-500 text-sm font-medium">Verified This Month</h3>
            <p class="text-2xl font-bold text-[#012619] mt-1">Rp {{ number_format($verifiedTotal, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-red-500">
            <h3 class="text-gray-500 text-sm font-medium">Overdue Payments</h3>
            <p class="text-2xl font-bold text-[#012619] mt-1">{{ $overdueCount }} <span
                    class="text-sm font-normal text-gray-500">tenant</span></p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-md overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
            <form method="GET" action="{{ route('admin.payments.index') }}" class="relative w-full sm:w-64">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search invoice/tenant..."
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-xl focus:ring-[#30BF62] focus:border-[#30BF62] text-sm">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </form>
            <div class="flex gap-2 w-full sm:w-auto">
                <form method="GET" action="{{ route('admin.payments.index') }}">
                    <select name="status" onchange="this.form.submit()"
                        class="border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-[#30BF62]">
                        <option value="">All Status</option>
                        <option value="verify" {{ request('status') == 'verify' ? 'selected' : '' }}>Pending Verify</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead class="bg-[#012619] text-white text-left text-sm uppercase font-semibold">
                    <tr>
                        <th class="px-6 py-4">Invoice ID</th>
                        <th class="px-6 py-4">Tenant</th>
                        <th class="px-6 py-4">Amount</th>
                        <th class="px-6 py-4">Due Date</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-700">

                    @forelse($payments as $payment)
                        <tr
                            class="hover:bg-gray-50 transition {{ $payment->status == 'overdue' ? 'bg-red-50/20' : ($payment->status == 'paid' ? 'bg-green-50/20' : '') }}">
                            <td class="px-6 py-4 font-medium">#{{ $payment->invoice_number }}</td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $payment->tenant->name }}</div>
                                <div class="text-xs text-gray-500">Room {{ $payment->tenant->room->room_number ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-[#012619]">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 {{ $payment->status == 'overdue' ? 'text-red-500' : '' }}">
                                {{ $payment->due_date->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($payment->status == 'verify')
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Verify</span>
                                @elseif($payment->status == 'paid')
                                    <span class="bg-green-100 text-[#188C4A] px-3 py-1 rounded-full text-xs font-semibold">Paid</span>
                                @elseif($payment->status == 'overdue')
                                    <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-semibold">Overdue</span>
                                @else
                                    <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-semibold">Pending</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($payment->status == 'paid')
                                    <a href="{{ route('admin.payments.show', $payment->id) }}" class="text-gray-400 hover:text-blue-500 transition px-2"
                                        title="View">
                                        <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                @elseif($payment->status == 'verify')
                                    <a href="{{ route('admin.payments.show', $payment->id) }}"
                                        class="inline-block bg-yellow-500 text-white px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-yellow-600 transition">
                                        Review
                                    </a>
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-400">Belum ada data pembayaran.</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
@endsection
