@extends('layouts.tenant')

@section('title', 'Create Complaint')
@section('page-title', 'Create Complaint')

@section('content')

    <div class="max-w-3xl mx-auto">

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">

            <h1 class="text-3xl font-bold text-[#400000] mb-8">
                Create Complaint
            </h1>

            <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">

                @csrf

                <div>
                    <label class="block text-sm font-semibold text-[#400000] mb-2">
                        Title
                    </label>

                    <input type="text" name="title"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#400000]">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-[#400000] mb-2">
                        Category
                    </label>

                    <select name="category"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#400000]">

                        <option value="Electricity">Electricity</option>
                        <option value="Water">Water</option>
                        <option value="WiFi">WiFi</option>
                        <option value="Facility">Facility</option>
                        <option value="Other">Other</option>

                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-[#400000] mb-2">
                        Description
                    </label>

                    <textarea name="description" rows="5"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#400000]"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-[#400000] mb-2">
                        Photo (Optional)
                    </label>

                    <input type="file" name="photo" class="w-full border border-gray-200 rounded-xl px-4 py-3">
                </div>

                <button type="submit"
                    class="bg-[#400000] hover:bg-[#5c0000] text-white px-6 py-3 rounded-xl font-semibold transition duration-200">
                    Submit Complaint
                </button>

            </form>

        </div>

    </div>

@endsection