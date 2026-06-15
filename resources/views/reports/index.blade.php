@extends('layouts.app')
@section('title', 'Reports Overview - e-Kost')
@section('header_title', 'Reports')

@section('content')
<div class="max-w-5xl mx-auto">
    <h1 class="text-2xl font-bold text-[#012619] mb-6">Select Report Type</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        
        <!-- Income Report Card -->
        <div class="bg-white rounded-2xl shadow-md p-8 hover:shadow-lg transition duration-300 border border-transparent hover:border-[#30BF62] group flex flex-col items-center text-center">
            <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center text-[#188C4A] mb-6 group-hover:scale-110 transition duration-300">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <h2 class="text-xl font-bold text-[#012619] mb-2">Income Report</h2>
            <p class="text-gray-500 mb-8 max-w-sm">Detailed financial records of all monthly rent payments, deposits, and overall revenue generated.</p>
            <a href="{{ route('reports.income') }}" class="mt-auto w-full max-w-xs bg-[#ad3333] text-white hover:bg-[#400000] rounded-xl px-4 py-3 font-semibold transition duration-200">
                View Income Report
            </a>
        </div>

        <!-- Occupancy Report Card -->
        <div class="bg-white rounded-2xl shadow-md p-8 hover:shadow-lg transition duration-300 border border-transparent hover:border-[#30BF62] group flex flex-col items-center text-center">
            <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 mb-6 group-hover:scale-110 transition duration-300">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" /></svg>
            </div>
            <h2 class="text-xl font-bold text-[#012619] mb-2">Occupancy Report</h2>
            <p class="text-gray-500 mb-8 max-w-sm">Analyze room availability, active tenant numbers, and calculate the overall occupancy rate for your property.</p>
            <a href="{{ route('reports.occupancy') }}" class="mt-auto w-full max-w-xs border border-[#ad3333] text-[#400000] hover:bg-[#400000] hover:text-white rounded-xl px-4 py-3 font-semibold transition duration-200">
                View Occupancy Report
            </a>
        </div>

    </div>
</div>
@endsection
