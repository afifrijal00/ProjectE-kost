@extends('layouts.app')
@section('title', 'Reminder Settings - e-Kost')
@section('header_title', 'Reminder Settings')

@section('content')
    <div class="mb-4">
        <a href="{{ route('reminders.index') }}" class="text-sm font-medium text-gray-500 hover:text-[#012619] inline-flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg> Back to Logs
        </a>
    </div>

    <div class="max-w-3xl bg-white rounded-2xl shadow-md p-6 sm:p-8" x-data="{ h3: true, h1: true, h0: false }">
        <div class="mb-8">
            <h2 class="text-xl font-bold text-[#012619]">Automated Billing Reminders</h2>
            <p class="text-gray-500 mt-1 text-sm">Configure when and how rent reminders are sent to tenants automatically.</p>
        </div>

        <form action="{{ route('reminders.send') }}" method="POST" class="space-y-8">
            @csrf

            <!-- H-3 -->
            <div class="border border-gray-200 rounded-xl p-5" :class="h3 ? 'bg-green-50/30' : 'bg-gray-50 opacity-60'">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="font-bold text-gray-900">H-3 Reminder (3 days before due)</h3>
                        <p class="text-sm text-gray-500">Gentle reminder about upcoming payment.</p>
                    </div>
                    <!-- Toggle Switch -->
                    <button type="button" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-[#30BF62] focus:ring-offset-2" :class="h3 ? 'bg-[#30BF62]' : 'bg-gray-200'" role="switch" @click="h3 = !h3">
                        <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out" :class="h3 ? 'translate-x-5' : 'translate-x-0'"></span>
                    </button>
                </div>

                <div x-show="h3" class="mt-4 border-t border-gray-200 pt-4" x-transition>
                    <input type="hidden" name="type" value="H-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Channels</label>
                    <div class="flex space-x-6">
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" class="text-[#30BF62] focus:ring-[#30BF62] rounded" disabled>
                            <span class="text-sm text-gray-400">WhatsApp (not available)</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" class="text-[#30BF62] focus:ring-[#30BF62] rounded" checked disabled>
                            <span class="text-sm text-gray-600">Email ✅</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- H-1 -->
            <div class="border border-gray-200 rounded-xl p-5" :class="h1 ? 'bg-green-50/30' : 'bg-gray-50 opacity-60'">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="font-bold text-gray-900">H-1 Reminder (1 day before due)</h3>
                        <p class="text-sm text-gray-500">Secondary reminder for unpaid invoices.</p>
                    </div>
                    <button type="button" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none" :class="h1 ? 'bg-[#30BF62]' : 'bg-gray-200'" @click="h1 = !h1">
                        <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out" :class="h1 ? 'translate-x-5' : 'translate-x-0'"></span>
                    </button>
                </div>

                <div x-show="h1" class="mt-4 border-t border-gray-200 pt-4" x-transition>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Channels</label>
                    <div class="flex space-x-6">
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" class="text-[#30BF62] focus:ring-[#30BF62] rounded" disabled>
                            <span class="text-sm text-gray-400">WhatsApp (not available)</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" class="text-[#30BF62] focus:ring-[#30BF62] rounded" checked disabled>
                            <span class="text-sm text-gray-600">Email ✅</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Notification Message Template -->
            <div class="border border-gray-200 rounded-xl p-5 bg-white">
                <label class="block text-sm font-bold text-gray-900 mb-2">Message Template Format</label>
                <p class="text-xs text-gray-500 mb-3">Available variables: <code>{tenant_name}</code>, <code>{room}</code>, <code>{amount}</code>, <code>{due_date}</code></p>
                <textarea name="template" rows="4"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-[#30BF62] focus:border-[#30BF62] text-sm font-mono text-gray-700"
                    required>Hi {tenant_name}, this is a gentle reminder that your rent for {room} amounting to Rp {amount} is due on {due_date}. Please complete the payment soon. Thank you! - e-Kost Management</textarea>
            </div>

            <div class="flex justify-end pt-4">
                <div class="flex gap-3">
                    <button type="submit" name="type" value="H-3"
                        class="bg-[#30BF62] text-white hover:bg-[#188C4A] rounded-xl px-6 py-2.5 font-bold transition duration-200 shadow-md">
                        Send H-3 Reminder
                    </button>
                    <button type="submit" name="type" value="H-1"
                        class="bg-[#035949] text-white hover:bg-[#012619] rounded-xl px-6 py-2.5 font-bold transition duration-200 shadow-md">
                        Send H-1 Reminder
                    </button>
                    <button type="submit" name="type" value="overdue"
                        class="bg-red-600 text-white hover:bg-red-700 rounded-xl px-6 py-2.5 font-bold transition duration-200 shadow-md">
                        Send Overdue Reminder
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
