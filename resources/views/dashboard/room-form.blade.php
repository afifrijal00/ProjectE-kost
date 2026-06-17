@extends('layouts.app')
@use('Illuminate\Support\Facades\Storage')
@section('title', 'Room Form - e-Kost')
@section('header_title', 'Create / Edit Room')

@section('content')
            <div class="max-w-4xl bg-white rounded-2xl shadow-md p-6 sm:p-8">
                <div class="mb-6 pb-4 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-xl font-bold text-[#012619]">Detail Kamar</h2>
                    <a href="{{ route('dashboard.rooms') }}" class="text-gray-400 hover:text-[#012619] transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </a>
                </div>

                <form action="{{ isset($room) ? route('dashboard.rooms.update', $room->id) : route('dashboard.rooms.store') }}"
                    method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @if(isset($room))
                        @method('PUT')
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama/ Nomor Kamar</label>
                            <input type="text" name="room_number" value="{{ old('room_number', $room->room_number ?? '') }}"
                                placeholder="Kamar 1 / Regular A"
                                class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-[#30BF62] focus:border-transparent transition"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Kamar</label>
                            <select name="type"
                                class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-[#30BF62] focus:border-transparent transition">
                                <option value="Regular" {{ old('type', $room->type ?? '') == 'Regular' ? 'selected' : '' }}>Regular</option>
                                <option value="VIP" {{ old('type', $room->type ?? '') == 'VIP' ? 'selected' : '' }}>VIP</option>
                                <option value="Suite" {{ old('type', $room->type ?? '') == 'Suite' ? 'selected' : '' }}>Suite</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Biaya Sewa Bulanan (Rp)</label>
                            <input type="number" name="price" value="{{ old('price', $room->price ?? '') }}" placeholder="1500000"
                                class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-[#30BF62] focus:border-transparent transition"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status"
                                class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-[#30BF62] focus:border-transparent transition">
                                <option value="available" {{ old('status', $room->status ?? '') == 'available' ? 'selected' : '' }}>Tersedia</option>
                                <option value="occupied" {{ old('status', $room->status ?? '') == 'occupied' ? 'selected' : '' }}>Ditempati</option>
                                <option value="maintenance" {{ old('status', $room->status ?? '') == 'maintenance' ? 'selected' : '' }}>Perbaikan</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kamar</label>
                        <textarea name="description" rows="3" placeholder="Deskripsikan kamar ini...."
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-[#30BF62] focus:border-transparent transition">{{ old('description', $room->description ?? '') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Fasilitas Kamar</label>
                        @php
$availableFacilities = ['AC', 'Kasur', 'Kamar mandi luar', 'Lemari', 'Kamar mandi dalam', 'Meja laptop', 'Wifi', 'Kipas angin'];
$selectedFacilities = old('facilities', $room->facilities ?? []);
                        @endphp
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            @foreach($availableFacilities as $facility)
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="facilities[]" value="{{ $facility }}"
                                        class="w-4 h-4 text-[#30BF62] border-gray-300 rounded focus:ring-[#30BF62]" {{ in_array($facility, $selectedFacilities) ? 'checked' : '' }}>
                                    <span class="text-sm text-gray-700">{{ $facility }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Display Kamar</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-[#400000] transition bg-gray-50">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label
                                        class="relative cursor-pointer bg-white rounded-md font-medium text-[#400000] hover:text-[#035949] focus-within:outline-none focus-within:ring-2 focus-within:ring-[#30BF62]">
                                        <span>Upload a photo</span>
                                        <input type="file" name="photo" accept="image/*" class="sr-only">
                                    </label>
                                    @if(isset($room) && $room->photo)
                                        <div class="mt-3">
                                            <img src="{{ Storage::url($room->photo) }}" alt="Room Photo"
                                                class="h-24 rounded-xl border border-gray-200 object-cover">
                                            <p class="text-xs text-gray-400 mt-1">Foto saat ini. Upload baru untuk mengganti.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <button type="button" onclick="window.history.back()" class="border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 rounded-xl px-5 py-2 font-medium transition duration-200">Batalkan</button>
                        <button type="submit"
                            class="bg-[#ad3333] text-white hover:bg-[#400000] rounded-xl px-5 py-2 font-medium transition duration-200 shadow-sm">
                            {{ isset($room) ? 'Simpan Perubahan' : 'Simpan Kamar' }}
                        </button>
                    </div>
                </form>
            </div>
@endsection
