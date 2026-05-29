@extends('layouts.app')
@use('Illuminate\Support\Facades\Storage')
@section('title', 'Complaint Detail - e-Kost')
@section('header_title', 'Complaint Detail')

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.complaints.index') }}"
            class="text-sm font-medium text-gray-500 hover:text-[#012619] inline-flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg> Back
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">

            <div class="bg-white rounded-2xl shadow-md p-6 sm:p-8">
                <div class="flex justify-between items-start mb-6 pb-4 border-b border-gray-100">
                    <div>
                        <h2 class="text-2xl font-bold text-[#012619]">{{ $complaint->title }}</h2>
                        <p class="text-gray-500 text-sm mt-1">
                            Submitted {{ $complaint->created_at->diffForHumans() }} by {{ $complaint->tenant->name }}
                            (Room {{ $complaint->tenant->room->room_number ?? '-' }})
                        </p>
                        <p class="text-xs text-gray-400 mt-1">Category: {{ $complaint->category }}</p>
                    </div>
                    @if($complaint->status == 'pending')
                        <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-bold ring-1 ring-red-400">Open</span>
                    @elseif($complaint->status == 'process')
                        <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-xs font-bold ring-1 ring-blue-400">In Progress</span>
                    @elseif($complaint->status == 'resolved')
                        <span class="bg-green-100 text-[#188C4A] px-3 py-1 rounded-full text-xs font-bold ring-1 ring-green-400">Resolved</span>
                    @else
                        <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-bold ring-1 ring-gray-400">Rejected</span>
                    @endif
                </div>

                <div class="text-gray-700 leading-relaxed text-sm mb-6">
                    {{ $complaint->description }}
                </div>

                @if($complaint->photo)
                    <div class="mb-6">
                        <img src="{{ Storage::url($complaint->photo) }}" class="rounded-xl border border-gray-200 max-h-80 object-cover">
                    </div>
                @endif

                <!-- Update Status Actions -->
                @if($complaint->status != 'resolved' && $complaint->status != 'rejected')
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                        <h3 class="font-bold text-gray-900 mb-3 text-sm">Update Status</h3>
                        <div class="flex flex-wrap gap-2">
                            @if($complaint->status == 'pending')
                                <form action="{{ route('admin.complaints.status', $complaint->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="process">
                                    <button type="submit"
                                        class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition">Mark
                                        In Progress</button>
                                </form>
                            @endif
                            <form action="{{ route('admin.complaints.status', $complaint->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="resolved">
                                <button type="submit"
                                    class="bg-[#30BF62] text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-[#188C4A] transition">Mark
                                    Resolved</button>
                            </form>
                            <form action="{{ route('admin.complaints.status', $complaint->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit"
                                    class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition">Reject/Invalid</button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>

        </div>

        <!-- Timeline/Comments Sidebar -->
        <div class="bg-white rounded-2xl shadow-md p-6">
            <h3 class="font-bold text-[#012619] mb-6">Activity Logs</h3>

            <div class="space-y-6 relative pl-4 border-l-2 border-gray-200 ml-2">
                <div class="relative">
                    <span class="absolute -left-[25px] bg-gray-400 w-3 h-3 rounded-full ring-4 ring-gray-100"></span>
                    <h4 class="font-bold text-gray-800 text-sm">Ticket Created</h4>
                    <p class="text-xs text-gray-500 my-0.5">By {{ $complaint->tenant->name }}</p>
                    <span class="text-xs text-gray-400">{{ $complaint->created_at->format('d M Y, H:i') }}</span>
                </div>

                @if($complaint->admin_response)
                    <div class="relative">
                        <span class="absolute -left-[25px] bg-blue-500 w-3 h-3 rounded-full ring-4 ring-blue-100"></span>
                        <h4 class="font-bold text-gray-800 text-sm">Admin Replied</h4>
                        <p class="text-xs bg-gray-50 p-2 rounded border border-gray-100 mt-2">{{ $complaint->admin_response }}</p>
                        <span class="text-xs text-gray-400 block mt-1">{{ $complaint->responded_at?->format('d M Y, H:i') }}</span>
                    </div>
                @endif

                @if($complaint->status == 'resolved')
                    <div class="relative">
                        <span class="absolute -left-[25px] bg-green-500 w-3 h-3 rounded-full ring-4 ring-green-100"></span>
                        <h4 class="font-bold text-gray-800 text-sm">Complaint Resolved</h4>
                        <span class="text-xs text-gray-400">{{ $complaint->responded_at?->format('d M Y, H:i') }}</span>
                    </div>
                @endif
            </div>

            <form action="{{ route('admin.complaints.reply', $complaint->id) }}" method="POST"
                class="mt-8 pt-4 border-t border-gray-100">
                @csrf
                <label class="block text-sm font-medium text-gray-700 mb-2">Leave a comment/reply</label>
                <textarea name="admin_response" rows="3"
                    class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:ring-[#30BF62]"
                    placeholder="Message to tenant..." required>{{ $complaint->admin_response }}</textarea>
                <button type="submit"
                    class="mt-3 w-full bg-[#012619] text-white py-2 rounded-xl text-sm font-bold hover:bg-[#035949] transition">Send
                    Reply</button>
            </form>
        </div>
    </div>
@endsection
