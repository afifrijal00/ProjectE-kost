@extends('layouts.guest')
@section('title', 'Reset Password - e-Kost')

@section('content')
<div class="min-h-[calc(100vh-64px)] flex items-center justify-center bg-[#F2F2F2] py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">

    <div class="absolute -top-24 -right-24 w-72 h-72 bg-[#400000]/5 rounded-full"></div>
    <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-[#400000]/5 rounded-full"></div>

    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8 sm:p-10 text-center relative z-10 border-t-8 border-[#400000]">

        <div class="mx-auto w-20 h-20 bg-[#F5E6E6] text-[#400000] rounded-full flex items-center justify-center mb-6 shadow-sm">
            <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
            </svg>
        </div>

        <h2 class="text-2xl font-bold text-[#400000] mb-2">Reset Password</h2>
        <p class="text-gray-500 text-sm mb-8">Masukkan password baru kamu di bawah ini.</p>

        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm text-left">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST" class="space-y-5 text-left" x-data="{ showPassword: false, showConfirm: false }">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email', $email) }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 bg-gray-50 text-gray-500 focus:ring-2 focus:ring-[#400000] focus:border-transparent transition"
                    required readonly>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" name="password" placeholder="Min. 8 characters"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 pr-11 focus:ring-2 focus:ring-[#400000] focus:border-transparent transition"
                        required autofocus>
                    <button type="button" @click="showPassword = !showPassword"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#400000] transition">
                        <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                        </svg>
                    </button>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                <div class="relative">
                    <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation" placeholder="Re-type new password"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 pr-11 focus:ring-2 focus:ring-[#400000] focus:border-transparent transition"
                        required>
                    <button type="button" @click="showConfirm = !showConfirm"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#400000] transition">
                        <svg x-show="!showConfirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="showConfirm" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit"
                class="w-full bg-[#400000] text-white hover:bg-[#5c0000] rounded-xl px-4 py-3 font-bold transition duration-200 shadow-md">
                Reset Password
            </button>
        </form>

        <div class="mt-8 flex items-center justify-center text-sm font-medium">
            <a href="{{ route('login') }}" class="text-gray-500 hover:text-[#400000] transition flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke login
            </a>
        </div>
    </div>
</div>
@endsection