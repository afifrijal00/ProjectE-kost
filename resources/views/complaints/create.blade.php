@extends('layouts.tenant')
@section('title', 'Submit Complaint - e-Kost')

@section('content')
    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-md p-6 sm:p-8">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-[#012619]">Submit a Complaint</h1>
            <p class="text-gray-500 mt-2 text-sm">Report any issues regarding your room or facilities to the admin.</p>
        </div>

        <form action="{{ route('tenant.complaints.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6"
            x-data="{ fileName: '' }">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select name="category"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-[#30BF62] focus:border-[#30BF62]">
                    <option value="Facilities (AC, Sink, Electricity)">Facilities (AC, Sink, Electricity)</option>
                    <option value="Cleanliness">Cleanliness</option>
                    <option value="Security / Noise">Security / Noise</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="Brief summary of the issue"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-[#30BF62] focus:border-[#30BF62]" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="4" placeholder="Detail the problem here..."
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-[#30BF62] focus:border-[#30BF62]"
                    required>{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Upload Photo Evidence (Optional)</label>
                <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-[#30BF62] transition bg-gray-50">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600 justify-center">
                            <label class="relative cursor-pointer bg-transparent rounded-md font-medium text-[#188C4A] hover:text-[#035949] focus-within:outline-none">
                                <span x-text="fileName === '' ? 'Upload a photo' : fileName"></span>
                                <input type="file" name="photo" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                    @change="fileName = $event.target.files[0].name">
                            </label>
                        </div>
                        <p class="text-xs text-gray-500" x-show="fileName === ''">JPG, PNG up to 2MB</p>
                    </div>
                </div>
            </div>

            <button type="submit"
                class="w-full bg-[#30BF62] text-white hover:bg-[#188C4A] rounded-xl px-4 py-3 font-bold transition duration-200 mt-4 shadow-md">
                Submit Complaint
            </button>

            <div class="text-center mt-4">
                <a href="{{ route('tenant.complaints.index') }}" class="text-sm text-gray-500 hover:text-[#012619]">Cancel</a>
            </div>
        </form>
    </div>
@endsection
