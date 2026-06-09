@extends('layouts.app')
@section('title', 'Edit Profile - e-Kost')
@section('header_title', 'Edit Profile')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">

        <div class="mb-4">
            <a href="{{ route('profile.index') }}"
                class="text-sm font-medium text-gray-500 hover:text-[#012619] inline-flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Profile
            </a>
        </div>

        {{-- Basic Info --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
            <h3 class="font-bold text-[#012619] text-lg mb-6 pb-2 border-b border-gray-100">Informasi Dasar</h3>

            <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                @if(session('success'))
                    <div class="mb-4 bg-green-50 text-green-700 px-4 py-3 rounded-xl text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-[#30BF62] focus:border-transparent transition"
                            required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" value="{{ $user->email }}"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 bg-gray-50 text-gray-400 cursor-not-allowed"
                            readonly>
                        <p class="text-xs text-gray-400 mt-1">Email tidak bisa diubah.</p>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <a href="{{ route('profile.index') }}"
                        class="border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 rounded-xl px-6 py-2.5 font-medium transition duration-200">
                        Cancel
                    </a>
                    <button type="submit"
                        class="bg-[#012619] text-white hover:bg-[#035949] rounded-xl px-6 py-2.5 font-bold transition duration-200 shadow-md">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

        {{-- Change Password --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
            <h3 class="font-bold text-[#012619] text-lg mb-6 pb-2 border-b border-gray-100">Ganti Password</h3>

            <form action="{{ route('profile.update.password') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                        <input type="password" name="current_password" placeholder="••••••••"
                            class="w-full md:w-1/2 border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-[#30BF62] focus:border-transparent transition">
                        @error('current_password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                        <input type="password" name="password" placeholder="Min. 8 characters"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-[#30BF62] focus:border-transparent transition">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                        <input type="password" name="password_confirmation" placeholder="Re-type new password"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-[#30BF62] focus:border-transparent transition">
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <button type="submit"
                        class="bg-[#012619] text-white hover:bg-[#035949] rounded-xl px-6 py-2.5 font-bold transition duration-200 shadow-md">
                        Update Password
                    </button>
                </div>
            </form>
        </div>

    </div>
@endsection