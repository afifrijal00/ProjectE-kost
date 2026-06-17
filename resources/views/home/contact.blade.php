@extends('layouts.guest')

@section('title', 'Contact - eKost')

@section('content')

    <div class="bg-[#400000] py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-6">
                Hubungi Kami
            </h1>

            <p class="text-lg text-gray-300 max-w-2xl mx-auto">
                Punya pertanyaan tentang kamar, fasilitas, atau proses booking?
                Tim eKost siap membantu Anda.
            </p>
        </div>
    </div>

    <div class="bg-[#F2F2F2] py-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

                <!-- Contact Info -->
                <div class="bg-white rounded-2xl shadow-md p-8">
                    <h2 class="text-2xl font-bold text-[#012619] mb-6">
                        Informasi Kontak
                    </h2>

                    <div class="space-y-6">

                        <div class="flex items-start gap-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-[#30BF62]/10 flex items-center justify-center text-[#30BF62]">
                                📍
                            </div>

                            <div>
                                <h4 class="font-semibold text-[#012619]">Alamat</h4>
                                <p class="text-gray-600">
                                    Red Dragon Kost - Jl. DI Panjaitan, Purwokerto.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-[#30BF62]/10 flex items-center justify-center text-[#30BF62]">
                                📞
                            </div>

                            <div>
                                <h4 class="font-semibold text-[#012619]">Telepon</h4>
                                <p class="text-gray-600">
                                    +62 812-3456-7890
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-[#30BF62]/10 flex items-center justify-center text-[#30BF62]">
                                ✉️
                            </div>

                            <div>
                                <h4 class="font-semibold text-[#012619]">Email</h4>
                                <p class="text-gray-600">
                                    admin@ekost.com
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Contact Form -->
                <div class="bg-white rounded-2xl shadow-md p-8">

                    <h2 class="text-2xl font-bold text-[#012619] mb-6">
                        Kirim Pesan
                    </h2>

                    <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama
                            </label>

                            <input type="text" name="name" value="{{ old('name') }}"
                                class="w-full border-2 border-gray-400 rounded-xl px-4 py-3 focus:border-[#400000] focus:ring-2 focus:ring-[#400000] focus:outline-none"
                                required>

                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Email
                            </label>

                            <input type="email" name="email" value="{{ old('email') }}"
                                class="w-full border-2 border-gray-400 rounded-xl px-4 py-3 focus:border-[#400000] focus:ring-2 focus:ring-[#400000] focus:outline-none"
                                required>

                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Pesan
                            </label>

                            <textarea name="message" rows="5"
                                class="w-full border-2 border-gray-400 rounded-xl px-4 py-3 focus:border-[#400000] focus:ring-2 focus:ring-[#400000] focus:outline-none"
                                required>{{ old('message') }}</textarea>

                            @error('message')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="w-full bg-[#ad3333] hover:bg-[#400000] text-white font-semibold py-3 rounded-xl transition duration-200">
                            Kirim Pesan
                        </button>
                    </form>

                </div>

            </div>
        </div>
    </div>

@endsection