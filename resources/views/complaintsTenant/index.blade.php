@extends('layouts.tenant')

@section('title', 'Complaints')
@section('page-title', 'Complaints')

@section('content')

    <div class="space-y-6">

        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-[#400000]">
                    My Complaints
                </h1>

                <p class="text-gray-500 mt-1">
                    Kelola dan pantau complaint Anda.
                </p>
            </div>

            <a href="{{ route('complaints.create') }}"
                class="bg-[#400000] hover:bg-[#5c0000] text-white px-5 py-3 rounded-xl font-medium transition duration-200">
                + Create Complaint
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-4">

            @forelse($complaints as $complaint)

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

                    <div class="flex items-start justify-between">

                        <div>
                            <h2 class="text-xl font-bold text-[#400000]">
                                {{ $complaint->title }}
                            </h2>

                            <p class="text-sm text-gray-500 mt-1">
                                {{ $complaint->category }}
                            </p>
                        </div>

                        <span class="px-4 py-1 rounded-full text-sm font-semibold

                                @if($complaint->status == 'pending')
                                    bg-yellow-100 text-yellow-700
                                @elseif($complaint->status == 'process')
                                    bg-blue-100 text-blue-700
                                @else
                                    bg-green-100 text-green-700
                                @endif
                            ">
                            {{ ucfirst($complaint->status) }}
                        </span>

                    </div>

                    <p class="text-gray-600 mt-4 leading-relaxed">
                        {{ $complaint->description }}
                    </p>

                    @if($complaint->photo)
                        <img src="{{ Storage::url($complaint->photo) }}" class="w-40 rounded-xl mt-4 border border-gray-200">
                    @endif

                    @if($complaint->admin_response)

                        <div class="mt-5 bg-[#F5E6E6] border border-[#e8cfcf] rounded-xl p-4">

                            <h3 class="font-bold text-[#400000] mb-2">
                                Admin Response
                            </h3>

                            <p class="text-[#5c1a1a]">
                                {{ $complaint->admin_response }}
                            </p>

                        </div>

                    @endif

                </div>

            @empty

                <div class="bg-white rounded-2xl p-10 text-center border border-gray-100 text-gray-400">
                    Belum ada complaint.
                </div>

            @endforelse

        </div>

    </div>

@endsection