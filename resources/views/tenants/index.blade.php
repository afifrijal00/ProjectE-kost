@extends('layouts.app')
@section('title', 'Tenants List - e-Kost')
@section('header_title', 'Tenants')

@section('content')
        <div class="bg-white rounded-2xl shadow-md overflow-hidden">

            <!-- Table Header Actions -->
            <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="relative w-full sm:w-64">
                    <form method="GET" action="{{ route('tenants.index') }}" class="relative w-full sm:w-64">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari tenant..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-xl focus:ring-[#30BF62] focus:border-[#30BF62] transition text-sm">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </form>
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <div class="flex gap-2 w-full sm:w-auto">
                    <select name="status" onchange="this.form.submit()" form="filter-form"
                        class="border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-[#30BF62]">
                        <option value="">Semua status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu konfirmasi</option>
                        <option value="past" {{ request('status') == 'past' ? 'selected' : '' }}>Tenant keluar</option>
                    </select>
                    <form id="filter-form" method="GET" action="{{ route('tenants.index') }}"></form>
                    <a href="{{ route('tenants.create') }}" class="bg-[#ad3333] text-white hover:bg-[#400000] rounded-xl px-4 py-2 text-sm font-medium transition shadow-sm flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Tambah tenant
                    </a>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead class="bg-[#400000] text-white text-left text-sm uppercase font-semibold">
                        <tr>
                            <th class="px-6 py-4 rounded-tl-xl sm:rounded-none">Nama Tenant</th>
                            <th class="px-6 py-4">Kamar</th>
                            <th class="px-6 py-4">Masa Sewa</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                        @forelse($tenants as $tenant)
                            <tr class="hover:bg-gray-50 transition even:bg-gray-50/50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            <div
                                                class="h-10 w-10 rounded-full bg-green-100 text-[#188C4A] flex items-center justify-center font-bold">
                                                {{ strtoupper(substr($tenant->name, 0, 2)) }}
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="font-medium text-gray-900">{{ $tenant->name }}</div>
                                            <div class="text-gray-500">{{ $tenant->phone }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    Room {{ $tenant->room->room_number ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $tenant->end_date->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($tenant->status == 'active')
                                        <span class="bg-green-100 text-[#188C4A] px-3 py-1 rounded-full text-xs font-semibold">Active</span>
                                    @elseif($tenant->status == 'pending')
                                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Pending</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-semibold">Past</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center space-x-2" x-data>
                                        <a href="{{ route('tenants.show', $tenant->id) }}" class="text-gray-400 hover:text-blue-500 transition p-1"
                                            title="View">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('tenants.edit', $tenant->id) }}"
                                            class="text-gray-400 hover:text-yellow-500 transition p-1" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('tenants.destroy', $tenant->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus tenant ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-500 transition p-1" title="Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-400">Belum ada data tenant.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Static Pagination Footer -->
            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between text-sm">
                <span class="text-gray-500">Showing {{ $tenants->firstItem() }} to {{ $tenants->lastItem() }} of {{ $tenants->total() }} results</span>
    {{ $tenants->links() }}
            </div>
        </div>

        @include('partials.modal', ['id' => 'delete-modal', 'title' => 'Delete Tenant', 'slot' => 'Are you sure you want to delete this tenant? All data will be permanently removed.'])
@endsection
