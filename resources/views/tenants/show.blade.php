@extends('layouts.app')
@section('title', 'Tenant Details - e-Kost')
@section('header_title', 'Tenant Details')
@use('Illuminate\Support\Facades\Storage')

@section('content')
    <div class="mb-4">
        <a href="{{ route('tenants.index') }}" class="text-sm font-medium text-gray-500 hover:text-[#012619] inline-flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg> Back to Tenants
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Profile Card -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-2xl shadow-md p-6 text-center text-[#012619]">
                <div
                    class="mx-auto w-24 h-24 rounded-full bg-green-100 text-[#188C4A] text-2xl font-bold flex items-center justify-center mb-4 border-4 border-white shadow-sm ring-2 ring-gray-100">
                    {{ strtoupper(substr($tenant->name, 0, 2)) }}
                </div>
                <h2 class="text-xl font-bold">{{ $tenant->name }}</h2>
                <p class="text-gray-500 text-sm mb-4">{{ $tenant->email }}</p>
                @if($tenant->status == 'active')
                    <span class="bg-green-100 text-[#188C4A] px-3 py-1 rounded-full text-xs font-semibold">Active Tenant</span>
                @elseif($tenant->status == 'pending')
                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Pending Payment</span>
                @elseif($tenant->status == 'checkout_requested')
                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs font-semibold">Checkout Requested</span>
                @elseif($tenant->status == 'inactive')
                    <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-semibold">Inactive</span>
                @else
                    <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-semibold">Past Tenant</span>
                @endif

                <div class="flex border-t border-gray-100 pt-4 mt-6">
                    <div class="w-1/2 p-2 border-r border-gray-100">
                        <p class="text-xs text-gray-500">Room</p>
                        <p class="font-bold text-lg text-[#30BF62]">{{ $tenant->room->room_number ?? '-' }}</p>
                    </div>
                    <div class="w-1/2 p-2 relative">
                        <p class="text-xs text-gray-500">Since</p>
                        <p class="font-bold text-sm text-[#012619]">{{ $tenant->start_date->format('M Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6">
                <h3 class="font-bold text-[#012619] mb-4 border-b border-gray-100 pb-2">Document Proof</h3>
                @if($tenant->ktp_photo)
                    <img src="{{ Storage::url($tenant->ktp_photo) }}" alt="KTP"
                        class="w-full rounded-xl cursor-pointer hover:opacity-80 transition object-cover border border-gray-200">
                @else
                    <img src="https://placehold.co/300x180/e2e8f0/475569?text=KTP+Photo" alt="KTP"
                        class="w-full rounded-xl cursor-pointer hover:opacity-80 transition object-cover border border-gray-200">
                @endif
                <a href="{{ route('tenants.contract', $tenant->id) }}" target="_blank"
                    class="block text-center mt-4 border border-[#035949] text-[#035949] hover:bg-[#035949] hover:text-white rounded-xl px-4 py-2 text-sm font-medium transition duration-200 w-full">View
                    Contract PDF</a>

                    @if($tenant->status == 'checkout_requested')
                        <div class="bg-orange-50 border border-orange-200 rounded-2xl p-6">
                            <h3 class="font-bold text-orange-700 mb-2">Permintaan Akhiri Sewa</h3>
                            <p class="text-sm text-orange-600 mb-4">Tenant ini telah mengajukan permintaan untuk mengakhiri sewa kamar.</p>
                            <form action="{{ route('tenants.approve-checkout', $tenant->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    onclick="return confirm('Konfirmasi checkout tenant ini? Kamar akan menjadi available kembali.')"
                                    class="w-full bg-orange-500 text-white hover:bg-orange-600 rounded-xl px-4 py-2.5 font-bold transition">
                                    Approve Checkout
                                </button>
                            </form>
                        </div>
                    @endif
            </div>
        </div>

        <!-- Right Column: Info & History -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-md p-6">
                <div class="flex justify-between items-center mb-6 pb-2 border-b border-gray-100">
                    <h3 class="font-bold text-[#012619] text-lg">Personal Information</h3>
                    <a href="{{ route('tenants.edit', $tenant->id) }}"
                        class="text-sm font-medium text-[#188C4A] hover:text-[#035949] transition">Edit</a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-12">
                    <div>
                        <span class="text-sm text-gray-500 block mb-1">Full Name</span>
                        <span class="font-medium text-gray-900">{{ $tenant->name }}</span>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500 block mb-1">Phone Number</span>
                        <span class="font-medium text-gray-900">{{ $tenant->phone }}</span>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500 block mb-1">ID (NIK) / Passport</span>
                        <span class="font-medium text-gray-900">{{ $tenant->nik }}</span>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500 block mb-1">Emergency Contact</span>
                        <span class="font-medium text-gray-900">{{ $tenant->emergency_contact ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500 block mb-1">Contract Start Date</span>
                        <span class="font-medium text-gray-900">{{ $tenant->start_date->format('d M Y') }}</span>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500 block mb-1">Contract End Date</span>
                        <span class="font-medium text-gray-900">{{ $tenant->end_date->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6">
                <h3 class="font-bold text-[#012619] text-lg mb-6 pb-2 border-b border-gray-100">Payment History Timeline</h3>

                @php
                    $paymentHistory = $tenant->payments->whereIn('status', ['paid', 'verify'])->sortByDesc('created_at');
                @endphp

                @if($paymentHistory->isEmpty())
                    <p class="text-center text-gray-400 text-sm py-6">Belum ada riwayat pembayaran.</p>
                @else
                    <div class="relative relative-step pl-4 border-l-2 border-gray-200 space-y-6 ml-2">
                        @foreach($paymentHistory as $payment)
                            <div class="relative">
                                <span
                                    class="absolute -left-[25px] {{ $payment->status == 'paid' ? 'bg-[#30BF62] ring-green-100' : 'bg-yellow-400 ring-yellow-100' }} w-3 h-3 rounded-full ring-4"></span>
                                <h4 class="font-bold text-[#012619] text-sm">
                                    Invoice #{{ $payment->invoice_number }}
                                    {{ $payment->notes ? '— ' . $payment->notes : '' }}
                                </h4>
                                <p
                                    class="text-xs {{ $payment->status == 'paid' ? 'text-green-600' : 'text-yellow-600' }} font-medium my-0.5">
                                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                </p>
                                <span class="text-xs text-gray-400">
                                    {{ ($payment->verified_at ?? $payment->created_at)->format('d M Y') }}
                                    &middot; {{ $payment->status == 'paid' ? 'Verified' : 'Menunggu Verifikasi' }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
