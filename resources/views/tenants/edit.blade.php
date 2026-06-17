@extends('layouts.app')
@section('title', 'Manage Tenant - e-Kost')
@section('header_title', 'Create / Edit Tenant')
@use('Illuminate\Support\Facades\Storage')

@section('content')
    <div class="max-w-4xl bg-white rounded-2xl shadow-md p-6 sm:p-8">
        <div class="mb-6 flex items-center justify-between border-b border-gray-100 pb-4">
            <h2 class="text-xl font-bold text-[#012619]">Tenant Form</h2>
            <a href="{{ route('tenants.index') }}" class="text-gray-400 hover:text-gray-600 transition"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></a>
        </div>

        <form action="{{ route('tenants.update', $tenant->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Section: Personal Info -->
            <div>
                <h3 class="text-lg font-semibold text-[#035949] mb-4">Personal Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $tenant->name) }}" placeholder="John Doe"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-[#30BF62] focus:border-[#30BF62]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $tenant->email) }}" placeholder="email@ext.com"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-[#30BF62] focus:border-[#30BF62]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="tel" name="phone" value="{{ old('phone', $tenant->phone) }}" placeholder="+62..."
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-[#30BF62] focus:border-[#30BF62]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Identity Card (NIK)</label>
                        <input type="text" name="nik" value="{{ old('nik', $tenant->nik) }}" placeholder="16 digit NIK" maxlength="16"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-[#30BF62] focus:border-[#30BF62]">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Upload KTP</label>
                        {{-- Tampilkan foto KTP lama jika ada --}}
                        @if($tenant->ktp_photo)
                            <div class="mb-2">
                                <img src="{{ Storage::url($tenant->ktp_photo) }}" alt="KTP"
                                    class="h-24 rounded-xl border border-gray-200 object-cover">
                                <p class="text-xs text-gray-400 mt-1">Foto KTP saat ini. Upload baru untuk mengganti.</p>
                            </div>
                        @endif
                        <input type="file" name="ktp_photo" accept="image/*"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-[#188C4A] hover:file:bg-green-100 transition">
                    </div>
                </div>
            </div>

            <hr class="border-gray-100">

            <!-- Section: Room Assignment -->
            <div>
                <h3 class="text-lg font-semibold text-[#035949] mb-4">Room Assignment & Contract</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Assign Room</label>
                        <select name="room_id"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-[#30BF62] focus:border-[#30BF62]">
                            <option value="">Select available room</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" {{ old('room_id', $tenant->room_id) == $room->id ? 'selected' : '' }}>
                                    Room {{ $room->room_number }} ({{ $room->type }}) - Rp {{ number_format($room->price, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stay Durationn</label>
                        <select name="duration"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-[#30BF62] focus:border-[#30BF62]">
                            <option value="1" {{ old('duration', $tenant->duration) == 1 ? 'selected' : '' }}>1 Month</option>
                            <option value="3" {{ old('duration', $tenant->duration) == 3 ? 'selected' : '' }}>3 Months</option>
                            <option value="6" {{ old('duration', $tenant->duration) == 6 ? 'selected' : '' }}>6 Months</option>
                            <option value="12" {{ old('duration', $tenant->duration) == 12 ? 'selected' : '' }}>12 Months</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                        <input type="date" name="start_date" value="{{ old('start_date', $tenant->start_date->format('Y-m-d')) }}"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-[#30BF62] focus:border-[#30BF62]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-[#30BF62] focus:border-[#30BF62]">
                        <option value="active" {{ old('status', $tenant->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="pending" {{ old('status', $tenant->status) == 'pending' ? 'selected' : '' }}>Pending Payment</option>
                        <option value="past" {{ old('status', $tenant->status) == 'past' ? 'selected' : '' }}>Past</option>
                    </select>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="window.history.back()" class="border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 rounded-xl px-5 py-2 font-medium transition duration-200">Cancel</button>
                <button type="submit"
                    class="bg-[#30BF62] text-white hover:bg-[#188C4A] rounded-xl px-5 py-2 font-medium transition duration-200 shadow-sm">Update
                    Tenant</button>
            </div>
        </form>
    </div>
@endsection
