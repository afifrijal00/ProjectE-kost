@extends('layouts.app')
@section('title', 'Manage Tenant - e-Kost')
@section('header_title', 'Create / Edit Tenant')

@section('content')
    <div class="max-w-4xl bg-white rounded-2xl shadow-md p-6 sm:p-8">
        <div class="mb-6 flex items-center justify-between border-b border-gray-100 pb-4">
            <h2 class="text-xl font-bold text-[#012619]">Tenant Form</h2>
            <a href="{{ route('tenants.index') }}" class="text-gray-400 hover:text-gray-600 transition"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></a>
        </div>

        <form action="{{ route('tenants.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- Section: Personal Info -->
            <div>
                <h3 class="text-lg font-semibold text-[#035949] mb-4">Personal Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="John Doe"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-[#30BF62] focus:border-[#30BF62]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="email@ext.com"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-[#30BF62] focus:border-[#30BF62]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="+62..."
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-[#30BF62] focus:border-[#30BF62]">
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
                                <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                    Room {{ $room->room_number }} ({{ $room->type }}) - Rp {{ number_format($room->price, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stay Duration</label>
                        <select name="duration"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-[#30BF62] focus:border-[#30BF62]">
                            <option value="1" {{ old('duration') == 1 ? 'selected' : '' }}>1 Month</option>
                            <option value="3" {{ old('duration') == 3 ? 'selected' : '' }}>3 Months</option>
                            <option value="6" {{ old('duration') == 6 ? 'selected' : '' }}>6 Months</option>
                            <option value="12" {{ old('duration') == 12 ? 'selected' : '' }}>12 Months</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                        <input type="date" name="start_date" value="{{ old('start_date') }}"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-[#30BF62] focus:border-[#30BF62]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-[#30BF62] focus:border-[#30BF62]">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending Payment</option>
                            <option value="past" {{ old('status') == 'past' ? 'selected' : '' }}>Past</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="window.history.back()" class="border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 rounded-xl px-5 py-2 font-medium transition duration-200">Cancel</button>
                <button type="submit"
                    class="bg-[#30BF62] text-white hover:bg-[#188C4A] rounded-xl px-5 py-2 font-medium transition duration-200 shadow-sm">Save
                    Tenant</button>
            </div>
        </form>
    </div>
@endsection
