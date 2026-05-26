@extends('layouts.guest')
@section('title', 'Verify Email - e-Kost')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-[#F2F2F2] py-12 px-4">
        <div class="max-w-md w-full bg-white rounded-2xl shadow-md p-8 text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-8 h-8 text-[#30BF62]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-[#012619] mb-2">Verify Your Email</h2>
            <p class="text-gray-500 mb-6">Kami telah mengirimkan link verifikasi ke email Anda. Silakan cek inbox atau
                folder spam.</p>

            @if(session('status') == 'verification-link-sent')
                <div class="bg-green-50 text-green-700 p-3 rounded-xl mb-4 text-sm">
                    Link verifikasi baru telah dikirim ke email Anda!
                </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit"
                    class="w-full bg-[#30BF62] text-white hover:bg-[#188C4A] rounded-xl px-4 py-3 font-bold transition duration-200 mb-3">
                    Kirim Ulang Email Verifikasi
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full border border-gray-300 text-gray-600 hover:bg-gray-50 rounded-xl px-4 py-3 font-medium transition duration-200">
                    Logout
                </button>
            </form>
        </div>
    </div>
@endsection