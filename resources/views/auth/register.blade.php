@extends('layouts.guest')
@section('title', 'Register - e-Kost')

@section('content')
<div class="min-h-[calc(100vh-64px)] flex bg-[#f5e6e6] py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full mx-auto bg-white rounded-2xl shadow-md p-8 sm:p-10">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-[#012619]">Buat Akun</h1>
            <p class="text-gray-500 mt-2">Temukan kamar kos yang sesuai dengan kebutuhan Anda atau kelola properti dengan mudah, cepat, dan terpercaya bersama e-Kost.</p>
        </div>
        
        <form action="{{ route('register.post') }}" method="POST" class="space-y-6">
            @csrf
            
            @if ($errors->any())
                <div class="bg-red-50 text-red-500 p-4 rounded-xl text-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Depan</label>
                    <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="Awan" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-[#30BF62] focus:border-transparent transition" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Belakang</label>
                    <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Parker" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-[#30BF62] focus:border-transparent transition" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="awantukam@contoh.com" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-[#30BF62] focus:border-transparent transition" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="+62 812 3456 7890" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-[#30BF62] focus:border-transparent transition" required>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                    <input type="password" name="password" placeholder="••••••••" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-[#30BF62] focus:border-transparent transition" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" placeholder="••••••••" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-[#30BF62] focus:border-transparent transition" required>
                </div>
            </div>

            <div class="flex items-start">
                <input type="checkbox" id="terms" class="mt-1 w-4 h-4 text-[#30BF62] border-gray-300 rounded focus:ring-[#30BF62]" required>
                <label for="terms" class="ml-2 block text-sm text-gray-600">
                    I agree to the <a href="#" class="text-[#188C4A] hover:underline">Terms of Service</a> and <a href="#" class="text-[#188C4A] hover:underline">Privacy Policy</a>.
                </label>
            </div>

            <button type="submit" class="w-full bg-[#30BF62] text-white hover:bg-[#188C4A] rounded-xl px-4 py-3 font-semibold transition duration-200">
                Buat Akun
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-8">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-[#188C4A] hover:text-[#035949] font-medium transition">Masuk</a>
        </p>
    </div>
</div>
@endsection
