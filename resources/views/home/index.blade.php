@extends('layouts.guest')
@use('Illuminate\Support\Facades\Storage')
@section('title', 'Home - e-Kost')

@section('content')
        <!-- Hero Section with Image Background -->
        <div class="relative bg-cover bg-center overflow-hidden" style="background-image: linear-gradient(rgba(64, 0, 0, 0.7), rgba(64, 0, 0, 0.7)), url('{{ asset('images/hero/kost-building.png') }}');">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32 flex flex-col lg:flex-row items-center relative z-10 gap-8">
                <!-- Left: Text Content -->
                <div class="lg:w-1/2 text-white">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight mb-6" data-aos="fade-up">
                        Kost Strategis, Hidup Lebih Praktis
                    </h1>
                    <p class="text-lg md:text-xl text-gray-200 mb-8 max-w-xl" data-aos="fade-up" data-aos-delay="100">
                        Kamar bersih, lingkungan aman, dan lokasi strategis yang dekat dengan pusat kota. Cocok untuk mahasiswa yang butuh tempat tinggal nyaman tanpa bikin kantong jebol. Book your space today.
                    </p>
                    <div class="flex space-x-4" data-aos="fade-up" data-aos-delay="200">
                        <a href="{{ route('rooms') }}" class="bg-[#F5E6E6] text-[#400000] hover:bg-white px-6 py-3 rounded-xl font-semibold transition duration-200 shadow-md">
                            Lihat Kamar
                        </a>
                        <a href="/contact" class="bg-transparent border-2 border-white hover:bg-white hover:text-[#400000] px-6 py-3 rounded-xl font-semibold transition duration-200">
                            Kontak Kami
                        </a>
                    </div>
                </div>

                <!-- Right: Map -->
                <div class="lg:w-1/2 mt-12 lg:mt-0" data-aos="fade-left" data-aos-delay="300">
                    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden p-2">
                        <a href="https://maps.google.com/?q=-7.438214,109.248791" target="_blank" rel="noopener noreferrer">
                            <img src="{{ asset('images/hero/map.png') }}" alt="Lokasi Kost"
                                class="w-full h-auto rounded-xl hover:opacity-90 transition duration-200 cursor-pointer">
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Featured Rooms Section -->
        <div class="py-20 bg-[#F5E6E6]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12" data-aos="fade-up">
                    <h2 class="text-3xl md:text-4xl font-bold text-[#400000]">Kamar Kosong, Gas Booking!</h2>
                    <p class="text-gray-600 mt-2 text-lg">Jangan sampai kehabisan! Temukan dan pesan kamar pilihan Anda sebelum disewa oleh penghuni lain.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @forelse($rooms as $index => $room)
                        <div class="bg-[#F5E6E6] rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300 group border-2 border-[#F5E6E6] hover:border-[#400000]" 
                             data-aos="fade-up" 
                             data-aos-delay="{{ $index * 100 }}">
                            <div class="relative overflow-hidden h-56">
                                @if($room->photo)
                                    <img src="{{ Storage::url($room->photo) }}"
                                         alt="Room {{ $room->room_number }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-[#F5E6E6] to-[#F5F5F5] flex items-center justify-center">
                                        <span class="text-6xl font-bold text-[#400000] opacity-20">{{ $room->room_number }}</span>
                                    </div>
                                @endif
                                <div class="absolute top-4 right-4 bg-white px-4 py-2 rounded-full text-xs font-bold text-[#400000] shadow-md border border-[#F5E6E6]">
                                    Tersedia
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-2xl font-bold text-[#400000] mb-2">Kamar {{ $room->room_number }}</h3>
                                <p class="text-[#400000] font-bold text-xl mb-4">
                                    Rp {{ number_format($room->price, 0, ',', '.') }} 
                                    <span class="text-sm font-normal text-gray-600">/ Bulan</span>
                                </p>

                                <div class="flex flex-wrap gap-2 mb-6 text-sm">
                                    @if($room->facilities)
                                        @foreach(array_slice($room->facilities, 0, 3) as $facility)
                                            <span class="bg-white text-[#400000] px-3 py-1 rounded-lg font-medium border border-[#F5E6E6]">
                                                {{ $facility }}
                                            </span>
                                        @endforeach
                                    @endif
                                </div>

                                <a href="{{ route('rooms.show', $room->id) }}"
                                   class="block w-full text-center bg-white border-2 border-[#400000] text-[#400000] hover:bg-[#400000] hover:text-white rounded-xl px-4 py-3 font-semibold transition duration-200 shadow-sm">
                                    View Detail
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-16">
                            <p class="text-gray-500 text-lg">Belum ada kamar tersedia saat ini.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-12 text-center" data-aos="fade-up">
                    <a href="{{ route('rooms') }}" 
                       class="inline-flex items-center text-[#400000] hover:text-[#600000] font-semibold text-lg transition group">
                        Lihat Semua Kamar 
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Facilities Section -->
        <div class="py-20 bg-[#F5F5F5] border-t border-[#F5E6E6]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-[#400000] mb-12" data-aos="fade-up">Fasilitas</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div class="flex flex-col items-center" data-aos="fade-up" data-aos-delay="0">
                        <div class="w-20 h-20 bg-[#F5E6E6] rounded-full flex items-center justify-center text-[#400000] mb-4 shadow-md">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />
                            </svg>
                        </div>
                        <h4 class="font-semibold text-[#400000]">Wifi Kencang</h4>
                    </div>
                    <div class="flex flex-col items-center" data-aos="fade-up" data-aos-delay="100">
                        <div class="w-20 h-20 bg-[#F5E6E6] rounded-full flex items-center justify-center text-[#400000] mb-4 shadow-md">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h4 class="font-semibold text-[#400000]">Keamanan CCTV</h4>
                    </div>
                    <div class="flex flex-col items-center" data-aos="fade-up" data-aos-delay="200">
                        <div class="w-20 h-20 bg-[#F5E6E6] rounded-full flex items-center justify-center text-[#400000] mb-4 shadow-md">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h4 class="font-semibold text-[#400000]">Parkir Luas</h4>
                    </div>
                    <div class="flex flex-col items-center" data-aos="fade-up" data-aos-delay="300">
                        <div class="w-20 h-20 bg-[#F5E6E6] rounded-full flex items-center justify-center text-[#400000] mb-4 shadow-md">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                        </div>
                        <h4 class="font-semibold text-[#400000]">Dapur Bersama</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Banner -->
    @guest
        <div class="bg-[#400000] py-16">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center">
                <h2 class="text-3xl font-extrabold text-white mb-4">
                    Siap Menemukan Hunian yang Tepat?
                </h2>

                <p class="text-white opacity-90 mb-8 text-lg">
                    Bergabunglah sekarang dan temukan kamar kos yang nyaman, aman, dan sesuai dengan kebutuhan Anda.
                </p>

                <a href="{{ route('register') }}"
                   class="bg-white text-[#012619] px-8 py-3 rounded-xl font-bold shadow-lg hover:bg-gray-100 transition duration-200 inline-block">
                    Daftar Sekarang
                </a>
            </div>
        </div>
    @endguest

    {{-- Floating Chatbot --}}
    <div x-data="chatbot()" class="fixed bottom-6 right-6 z-50 flex flex-col items-end">

        {{-- Chat Window --}}
        <div x-show="open" x-cloak x-transition
            class="mb-4 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-gray-100 flex flex-col overflow-hidden"
            style="height: 480px;">

            {{-- Header --}}
            <div class="bg-[#400000] px-4 py-3 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-3 3v-3z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-white font-semibold text-sm">e-Kost Assistant</p>
                        <p class="text-white/60 text-xs">Online</p>
                    </div>
                </div>
                <button @click="open = false" class="text-white/70 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Messages --}}
            <div class="flex-1 overflow-y-auto p-4 space-y-3 bg-gray-50" x-ref="chatBox">
                {{-- Welcome message --}}
                <div class="flex items-start gap-2">
                    <div class="w-7 h-7 bg-[#400000] rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-3 3v-3z" />
                        </svg>
                    </div>
                    <div
                        class="bg-white rounded-2xl rounded-tl-none px-4 py-2.5 shadow-sm text-sm text-gray-700 max-w-[80%]">
                        Halo! 👋 Saya asisten e-Kost. Ada yang bisa saya bantu? Tanyakan info kamar, harga, atau fasilitas
                        kami!
                    </div>
                </div>

                {{-- Dynamic messages --}}
                <template x-for="(msg, index) in messages" :key="index">
                    <div :class="msg.role === 'user' ? 'flex justify-end' : 'flex items-start gap-2'">
                        {{-- Bot avatar --}}
                        <div x-show="msg.role === 'assistant'"
                            class="w-7 h-7 bg-[#400000] rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-3 3v-3z" />
                            </svg>
                        </div>
                        <div :class="msg.role === 'user'
                                ? 'bg-[#400000] text-white rounded-2xl rounded-tr-none px-4 py-2.5 shadow-sm text-sm max-w-[80%]'
                                : 'bg-white rounded-2xl rounded-tl-none px-4 py-2.5 shadow-sm text-sm text-gray-700 max-w-[80%]'"
                            x-text="msg.content">
                        </div>
                    </div>
                </template>

                {{-- Typing indicator --}}
                <div x-show="loading" class="flex items-start gap-2">
                    <div class="w-7 h-7 bg-[#400000] rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-3 3v-3z" />
                        </svg>
                    </div>
                    <div class="bg-white rounded-2xl rounded-tl-none px-4 py-3 shadow-sm flex gap-1 items-center">
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0ms"></span>
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 150ms"></span>
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 300ms"></span>
                    </div>
                </div>
            </div>

            {{-- Quick Replies --}}
            <div x-show="messages.length === 0" class="px-4 py-2 flex gap-2 flex-wrap bg-gray-50 border-t border-gray-100">
                <button @click="sendQuick('Kamar apa saja yang tersedia?')"
                    class="text-xs bg-white border border-gray-200 text-gray-600 px-3 py-1.5 rounded-full hover:border-[#400000] hover:text-[#400000] transition">
                    Kamar tersedia?
                </button>
                <button @click="sendQuick('Berapa harga sewa per bulan?')"
                    class="text-xs bg-white border border-gray-200 text-gray-600 px-3 py-1.5 rounded-full hover:border-[#400000] hover:text-[#400000] transition">
                    Harga sewa?
                </button>
                <button @click="sendQuick('Apa saja fasilitas yang ada?')"
                    class="text-xs bg-white border border-gray-200 text-gray-600 px-3 py-1.5 rounded-full hover:border-[#400000] hover:text-[#400000] transition">
                    Fasilitas?
                </button>
            </div>

            {{-- Input --}}
            <div class="p-3 bg-white border-t border-gray-100 flex gap-2">
                <input x-model="input" @keydown.enter="send()" type="text" placeholder="Ketik pertanyaan..."
                    :disabled="loading"
                    class="flex-1 border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#400000] focus:border-transparent disabled:bg-gray-50">
                <button @click="send()" :disabled="loading || !input.trim()"
                    class="bg-[#400000] hover:bg-[#5c0000] disabled:opacity-50 text-white p-2 rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Bubble Button --}}
        <button @click="open = !open"
            class="w-14 h-14 bg-[#400000] hover:bg-[#5c0000] text-white rounded-full shadow-lg flex items-center justify-center transition duration-200 relative">
            <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-3 3v-3z" />
            </svg>
            <svg x-show="open" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <script>
        function chatbot() {
            return {
                open: false,
                input: '',
                loading: false,
                messages: [],

                async send() {
                    const text = this.input.trim();
                    if (!text || this.loading) return;

                    this.messages.push({ role: 'user', content: text });
                    this.input = '';
                    this.loading = true;
                    this.$nextTick(() => this.scrollToBottom());

                    try {
                        const res = await fetch('{{ route('chatbot.message') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                message: text,
                                history: this.messages.slice(0, -1),
                            }),
                        });

                        const data = await res.json();
                        this.messages.push({ role: 'assistant', content: data.reply });
                    } catch (e) {
                        this.messages.push({ role: 'assistant', content: 'Maaf, terjadi kesalahan. Silakan coba lagi.' });
                    } finally {
                        this.loading = false;
                        this.$nextTick(() => this.scrollToBottom());
                    }
                },

                sendQuick(text) {
                    this.input = text;
                    this.send();
                },

                scrollToBottom() {
                    const box = this.$refs.chatBox;
                    if (box) box.scrollTop = box.scrollHeight;
                }
            }
        }
    </script>
@endsection
