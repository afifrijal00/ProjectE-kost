@extends('layouts.tenant')
@section('title', 'My Profile - e-Kost')
@section('page-title', 'Profile')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">

        {{-- Profile Header --}}
        <div
            class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8 flex flex-col sm:flex-row items-center sm:items-start gap-6 border-t-8 border-[#400000]">
            <div class="relative">
                <div
                    class="w-24 h-24 sm:w-32 sm:h-32 rounded-full bg-[#400000] text-white flex items-center justify-center text-4xl font-bold border-4 border-white shadow-sm ring-2 ring-gray-100">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div
                    class="absolute bottom-1 right-1 bg-green-500 w-4 h-4 sm:w-5 sm:h-5 rounded-full border-2 border-white">
                </div>
            </div>

            <div class="flex-grow text-center sm:text-left">
                <h1 class="text-2xl font-bold text-[#400000] mb-1">{{ $user->name }}</h1>
                <p class="text-gray-500 mb-3">{{ $user->email }}</p>
                @if($tenant && $tenant->status == 'active')
                    <span
                        class="bg-[#400000] text-white px-3 py-1 rounded-full text-xs font-semibold tracking-wider uppercase">Tenant
                        Aktif</span>
                @else
                    <span
                        class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold tracking-wider uppercase">Pending</span>
                @endif
            </div>

            <div class="sm:self-stretch flex items-start">
                <a href="{{ route('profile.edit') }}"
                    class="bg-[#400000] text-white hover:bg-[#5c0000] px-4 py-2 rounded-xl text-sm font-medium transition flex items-center shadow-sm">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    Edit Profile
                </a>
            </div>
        </div>

        {{-- Contact Information --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
            <h3 class="font-bold text-[#400000] text-lg mb-6 pb-2 border-b border-gray-100">Informasi Akun</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-12">
                <div>
                    <span class="text-sm text-gray-500 block mb-1">Full Name</span>
                    <span class="font-medium text-gray-900">{{ $user->name }}</span>
                </div>
                <div>
                    <span class="text-sm text-gray-500 block mb-1">Email Address</span>
                    <span class="font-medium text-gray-900">{{ $user->email }}</span>
                </div>
                <div>
                    <span class="text-sm text-gray-500 block mb-1">Phone Number</span>
                    <span class="font-medium text-gray-900">{{ $tenant->phone ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-sm text-gray-500 block mb-1">Status</span>
                    <span class="font-medium text-gray-900">{{ ucfirst($tenant->status ?? 'pending') }}</span>
                </div>
                <div>
                    <span class="text-sm text-gray-500 block mb-1">Room</span>
                    <span class="font-medium text-gray-900">
                        {{ $tenant && $tenant->room ? 'Room ' . $tenant->room->room_number : '-' }}
                    </span>
                </div>
                <div>
                    <span class="text-sm text-gray-500 block mb-1">Joined Date</span>
                    <span class="font-medium text-gray-900">{{ $user->created_at->format('d M Y') }}</span>
                </div>
            </div>
        </div>

    </div>
@endsection