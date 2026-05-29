@extends('layouts.tenant')
@section('title', 'My Complaints - e-Kost')

@section('content')
    <div class="max-w-4xl mx-auto">

        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 border-b border-gray-100 pb-4 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-[#012619]">My Complaints</h1>
                <p class="text-gray-500 text-sm mt-1">Track the status of your reported issues here.</p>
            </div>
            <a href="{{ route('admin.complaints.index') }}"
                class="text-sm font-medium text-gray-500 hover:text-[#012619] inline-flex items-center">
                + New Complaint
            </a>
        </div>

        <!-- Complaint Cards -->
        <div class="space-y-4">

            <!-- Open Complaint -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 hover:shadow-md transition flex flex-col sm:flex-row gap-4">
                <div class="sm:w-1/6 flex-shrink-0">
                    <!-- Status Badge -->
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                        <svg class="w-1.5 h-1.5 mr-1.5 rounded-full bg-red-500" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3" /></svg> Wait Admin
                    </span>
                </div>
                <div class="sm:w-5/6">
                    <div class="flex justify-between items-start mb-1">
                        <h3 class="font-bold text-[#012619] text-lg">AC Not Cold & Leaking</h3>
                        <span class="text-xs text-gray-500">Today, 08:30</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">The AC has been running for 3 hours but the room is still very hot. Also, there is water dripping from the indoor unit near the bed...</p>
                    <button class="text-[#188C4A] hover:text-[#035949] text-sm font-medium transition">View Details</button>
                </div>
            </div>

            <!-- In Progress Complaint -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 hover:shadow-md transition flex flex-col sm:flex-row gap-4">
                <div class="sm:w-1/6 flex-shrink-0">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                        <svg class="animate-pulse w-1.5 h-1.5 mr-1.5 rounded-full bg-blue-500" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3" /></svg> In Progress
                    </span>
                </div>
                <div class="sm:w-5/6">
                    <div class="flex justify-between items-start mb-1">
                        <h3 class="font-bold text-[#012619] text-lg">Leaking Sink</h3>
                        <span class="text-xs text-gray-500">2 Days ago</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-2">Bathroom sink is leaking, water spreads to the living area.</p>

                    <div class="bg-blue-50 border border-blue-100 p-3 rounded-xl mt-3 inline-block">
                        <p class="text-xs text-blue-800"><span class="font-bold">Admin response:</span> "We have notified the technician, they will come at 1 PM today."</p>
                    </div>
                </div>
            </div>

            <!-- Resolved Complaint -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 opacity-70 hover:opacity-100 transition flex flex-col sm:flex-row gap-4">
                <div class="sm:w-1/6 flex-shrink-0">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-[#188C4A]">
                        <svg class="w-1.5 h-1.5 mr-1.5 rounded-full bg-[#188C4A]" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3" /></svg> Resolved
                    </span>
                </div>
                <div class="sm:w-5/6">
                    <div class="flex justify-between items-start mb-1">
                        <h3 class="font-bold text-gray-700 text-lg line-through">Internet Down</h3>
                        <span class="text-xs text-gray-500">10 Jan 2026</span>
                    </div>
                    <p class="text-sm text-gray-500 mb-0">WiFi in the lobby is not connecting.</p>
                </div>
            </div>

        </div>
    </div>
@endsection
