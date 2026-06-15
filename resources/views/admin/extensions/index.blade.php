@extends('layouts.app')
@section('title', 'Extensions - e-Kost')
@section('header_title', 'Perpanjangan Kontrak')

@section('content')
    @if(session('success'))
        <div class="mb-4 bg-green-50 text-green-700 px-4 py-3 rounded-xl text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-md overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-[#012619] text-lg">Daftar Request Perpanjangan</h3>
            <form method="GET" action="{{ route('admin.extensions.index') }}">
                <select name="status" onchange="this.form.submit()"
                    class="border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-[#30BF62]">
                    <option value="">All Status</option>
                    <option value="verify" {{ request('status') == 'verify' ? 'selected' : '' }}>Pending Verify</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead class="bg-[#012619] text-white text-left text-sm uppercase font-semibold">
                    <tr>
                        <th class="px-6 py-4">Tenant</th>
                        <th class="px-6 py-4">Durasi</th>
                        <th class="px-6 py-4">Amount</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                    @forelse($extensions as $extension)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $extension->tenant->name }}</div>
                                <div class="text-xs text-gray-500">Room {{ $extension->tenant->room->room_number ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">{{ $extension->duration }} Bulan</td>
                            <td class="px-6 py-4 font-semibold text-[#012619]">Rp {{ number_format($extension->amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @if($extension->status == 'verify')
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Pending Verify</span>
                                @elseif($extension->status == 'approved')
                                    <span class="bg-green-100 text-[#188C4A] px-3 py-1 rounded-full text-xs font-semibold">Approved</span>
                                @elseif($extension->status == 'rejected')
                                    <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-semibold">Rejected</span>
                                @else
                                    <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-semibold">Pending</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($extension->status == 'verify')
                                    <a href="{{ route('admin.extensions.show', $extension->id) }}"
                                        class="inline-block bg-yellow-500 text-white px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-yellow-600 transition">
                                        Review
                                    </a>
                                @else
                                    <a href="{{ route('admin.extensions.show', $extension->id) }}" class="text-gray-400 hover:text-blue-500 transition" title="View">
                                        <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-400">Belum ada request perpanjangan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-100">
            {{ $extensions->links() }}
        </div>
    </div>
@endsection