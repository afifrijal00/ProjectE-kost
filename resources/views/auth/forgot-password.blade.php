@extends('layouts.guest')
@section('title', 'Forgot Password - e-Kost')

@section('content')
<div class="min-h-[calc(100vh-64px)] flex items-center justify-center bg-[#F2F2F2] py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">

    {{-- Decorative background --}}
    <div class="absolute -top-24 -right-24 w-72 h-72 bg-[#400000]/5 rounded-full"></div>
    <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-[#400000]/5 rounded-full"></div>

    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8 sm:p-10 text-center relative z-10 border-t-8 border-[#400000]">

        <div class="mx-auto w-20 h-20 bg-[#F5E6E6] text-[#400000] rounded-full flex items-center justify-center mb-6 shadow-sm">
            <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
            </svg>
        </div>

        <h2 class="text-2xl font-bold text-[#400000] mb-2">Lupa Password?</h2>
        <p class="text-gray-500 text-sm mb-8">Jangan khawatir, kami akan kirimkan link reset password. Masukkan email akun e-Kost kamu.</p>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm text-left">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm text-left">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" class="space-y-6 text-left">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="name@example.com"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#400000] focus:border-transparent transition"
                    required autofocus>
            </div>

            <button type="submit"
                class="w-full bg-[#400000] text-white hover:bg-[#5c0000] rounded-xl px-4 py-3 font-bold transition duration-200 shadow-md flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Send Reset Link
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