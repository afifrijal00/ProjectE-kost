@extends('layouts.app')
@section('title', 'Reminders - e-Kost')
@section('header_title', 'Reminders')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <div class="flex gap-2 w-full sm:w-auto">
            <form method="GET" action="{{ route('reminders.index') }}">
                <select name="status" onchange="this.form.submit()"
                    class="border border-gray-300 rounded-xl px-4 py-2 focus:ring-[#30BF62] focus:border-[#30BF62] text-sm">
                    <option value="">All Status</option>
                    <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </form>
        </div>

        <a href="{{ route('reminders.settings') }}" class="bg-[#ad3333] text-white hover:bg-[#400000] rounded-xl px-4 py-2 text-sm font-medium transition shadow-sm flex items-center w-full sm:w-auto justify-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
            Reminder Settings
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-md overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="font-bold text-[#012619]">Reminder Logs</h3>
            <p class="text-sm text-gray-500">History of automated billing reminders sent to tenants.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left whitespace-nowrap">
                <thead class="bg-[#400000] text-white text-sm uppercase font-semibold">
                    <tr>
                        <th class="px-6 py-4">Tenant</th>
                        <th class="px-6 py-4">Type</th>
                        <th class="px-6 py-4">Channel</th>
                        <th class="px-6 py-4">Scheduled Date</th>
                        <th class="px-6 py-4 border-b">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-700">

                    @forelse($reminders as $reminder)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $reminder->tenant->name }}</div>
                                <div class="text-xs text-gray-500">Room {{ $reminder->tenant->room->room_number ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">{{ $reminder->type }}</td>
                            <td class="px-6 py-4">
                                <span class="flex items-center text-blue-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    Email
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ $reminder->sent_at?->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-4">
                                @if($reminder->status == 'sent')
                                    <span class="bg-green-100 text-[#188C4A] px-3 py-1 rounded-full text-xs font-semibold">Sent</span>
                                @else
                                    <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-semibold">Failed</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-400">Belum ada reminder log.</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $reminders->links() }}
            </div>
        </div>
    </div>
@endsection
