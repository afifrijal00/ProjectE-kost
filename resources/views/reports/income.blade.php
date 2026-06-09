@extends('layouts.app')
@section('title', 'Income Report - e-Kost')
@section('header_title', 'Income Report')

@section('content')
    <div class="mb-4">
        <a href="{{ route('reports.index') }}" class="text-sm font-medium text-gray-500 hover:text-[#012619] inline-flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg> Back to Reports
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-md p-6 mb-8 flex flex-col sm:flex-row justify-between items-end gap-4">
        <form method="GET" action="{{ route('reports.income') }}" class="flex items-center gap-4 w-full sm:w-auto">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Start Month</label>
                <input type="month" name="start_month" value="{{ $startMonth }}"
                    class="border border-gray-300 rounded-xl px-4 py-2 focus:ring-[#30BF62] focus:border-[#30BF62] text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">End Month</label>
                <input type="month" name="end_month" value="{{ $endMonth }}"
                    class="border border-gray-300 rounded-xl px-4 py-2 focus:ring-[#30BF62] focus:border-[#30BF62] text-sm">
            </div>
            <button type="submit"
                class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-4 py-2 mt-6 rounded-xl font-medium transition text-sm">Filter</button>
        </form>

        <a href="{{ route('reports.income.export-pdf', ['start_month' => $startMonth, 'end_month' => $endMonth]) }}"
            class="bg-[#188C4A] text-white hover:bg-[#035949] rounded-xl px-4 py-2 font-medium transition shadow-sm flex items-center text-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
            Export PDF
        </a>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-[#012619] text-white rounded-2xl shadow-md p-6 relative overflow-hidden">
            <div class="absolute -right-4 -bottom-4 opacity-10">
                <svg class="w-32 h-32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <h3 class="text-gray-300 text-sm font-medium mb-1">Total Income Selected Period</h3>
            <p class="text-3xl font-bold text-[#30BF62]">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
            <h3 class="text-gray-500 text-sm font-medium mb-1">Average Monthly Income</h3>
            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($avgMonthly, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
            <h3 class="text-gray-500 text-sm font-medium mb-1">Total Transactions</h3>
            <p class="text-2xl font-bold text-gray-900">{{ $totalTransactions }}</p>
        </div>
    </div>

    <!-- Dummy Chart -->
    <!-- Dummy Chart -->
    <div class="bg-white rounded-2xl shadow-md p-6 mb-8 h-[350px] flex flex-col">
        <h3 class="font-bold text-[#012619] mb-4">Income Trend (2026)</h3>
        <div class="flex-grow flex items-end justify-between space-x-2 border-b border-gray-200 pb-2 px-4">
            @foreach($incomeChart as $data)
                @php $height = $maxIncome > 0 ? round(($data['amount'] / $maxIncome) * 100) : 5; @endphp
                <div class="w-full bg-[#30BF62] rounded-t relative group" style="height: {{ max($height, 5) }}%">
                    <div
                        class="hidden group-hover:block absolute -top-10 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded whitespace-nowrap">
                        Rp {{ number_format($data['amount'], 0, ',', '.') }}
                    </div>
                </div>
            @endforeach
        </div>
        <div class="flex justify-between mt-2 text-sm text-gray-500 px-4">
            @foreach($incomeChart as $data)
                <span class="w-full text-center text-xs">{{ $data['month'] }}</span>
            @endforeach
        </div>
    </div> {{-- ✅ penutup div chart container --}}

@endsection
