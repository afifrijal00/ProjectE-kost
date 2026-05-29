@extends('layouts.app')
@section('title', 'Complaints - e-Kost')
@section('header_title', 'Complaints Management')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <div class="flex gap-2 w-full sm:w-auto">
            <span class="text-sm text-gray-500 self-center">Total: {{ $open->count() + $process->count() + $resolved->count() }}
                complaints</span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Unresolved column -->
        <div class="bg-gray-100 rounded-2xl p-4 flex flex-col max-h-[80vh]">
            <h3 class="font-bold text-[#012619] mb-4 flex items-center justify-between">
                Open / Pending <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $open->count() }}</span>
            </h3>

            <div class="space-y-4 overflow-y-auto pr-1">
                @forelse($open as $complaint)
                    <a href="{{ route('admin.complaints.show', $complaint->id) }}"
                        class="block bg-white border-l-4 border-red-500 rounded-xl shadow-sm p-4 hover:shadow-md transition">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-xs font-bold text-gray-500">Room {{ $complaint->tenant->room->room_number ?? '-' }}</span>
                            <span class="text-xs text-gray-400">{{ $complaint->created_at->diffForHumans() }}</span>
                        </div>
                        <h4 class="font-bold text-[#012619] text-sm mb-1">{{ $complaint->title }}</h4>
                        <p class="text-xs text-gray-500 line-clamp-2">{{ $complaint->description }}</p>
                        <span class="text-xs text-gray-400 mt-1 block">{{ $complaint->category }}</span>
                    </a>
                @empty
                    <div class="text-center text-gray-400 text-xs py-4">Tidak ada complaint.</div>
                @endforelse
            </div>
        </div>

        <!-- In Progress column -->
        <div class="bg-gray-100 rounded-2xl p-4 flex flex-col max-h-[80vh]">
            <h3 class="font-bold text-[#012619] mb-4 flex items-center justify-between">
                In Progress <span class="bg-blue-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $process->count() }}</span>
            </h3>
            <div class="space-y-4 overflow-y-auto pr-1">
                @forelse($process as $complaint)
                    <a href="{{ route('admin.complaints.show', $complaint->id) }}"
                        class="block bg-white border-l-4 border-blue-500 rounded-xl shadow-sm p-4 hover:shadow-md transition">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-xs font-bold text-gray-500">Room {{ $complaint->tenant->room->room_number ?? '-' }}</span>
                            <span class="text-xs text-gray-400">{{ $complaint->created_at->diffForHumans() }}</span>
                        </div>
                        <h4 class="font-bold text-[#012619] text-sm mb-1">{{ $complaint->title }}</h4>
                        <p class="text-xs text-gray-500 line-clamp-2">{{ $complaint->description }}</p>
                        @if($complaint->admin_response)
                            <div class="mt-3 text-xs text-blue-600 bg-blue-50 px-2 py-1 rounded inline-block">
                                {{ Str::limit($complaint->admin_response, 30) }}</div>
                        @endif
                    </a>
                @empty
                    <div class="text-center text-gray-400 text-xs py-4">Tidak ada complaint.</div>
                @endforelse
            </div>
        </div>

        <!-- Resolved column -->
        <div class="bg-gray-100 rounded-2xl p-4 flex flex-col max-h-[80vh]">
            <h3 class="font-bold text-[#012619] mb-4 flex items-center justify-between">
                Resolved <span class="bg-[#30BF62] text-white text-xs px-2 py-0.5 rounded-full">{{ $resolved->count() }}</span>
            </h3>
            <div class="space-y-4 overflow-y-auto pr-1">
                @forelse($resolved as $complaint)
                    <a href="{{ route('admin.complaints.show', $complaint->id) }}"
                        class="block bg-white border-l-4 border-[#30BF62] opacity-80 rounded-xl shadow-sm p-4 hover:shadow-md transition">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-xs font-bold text-gray-500">Room {{ $complaint->tenant->room->room_number ?? '-' }}</span>
                            <span class="text-xs text-gray-400">{{ $complaint->created_at->diffForHumans() }}</span>
                        </div>
                        <h4 class="font-bold text-gray-700 text-sm mb-1 {{ $complaint->status == 'resolved' ? 'line-through' : '' }}">
                            {{ $complaint->title }}</h4>
                        <p class="text-xs text-gray-400 line-clamp-2">{{ $complaint->description }}</p>
                    </a>
                @empty
                    <div class="text-center text-gray-400 text-xs py-4">Belum ada complaint resolved.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
