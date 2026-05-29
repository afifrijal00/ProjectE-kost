<!-- Reusable Modal Layout -->
<!-- To clear confusion, an outer wrapper dispatches events or listens to 'x-on:open-modal' -->
<div x-data="{ open: false }" @open-modal.window="if ($event.detail === '{{ $id ?? 'default-modal' }}') open = true"
    @close-modal.window="if ($event.detail === '{{ $id ?? 'default-modal' }}') open = false"
    @keydown.escape.window="open = false" x-show="open" class="relative z-50" aria-labelledby="modal-title"
    role="dialog" aria-modal="true" x-cloak>

    <!-- Background backdrop -->
    <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm transition-opacity">
    </div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <!-- Modal Panel -->
            <div x-show="open" @click.outside="open = false" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">

                <!-- Header -->
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4 border-b border-gray-100">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                            <!-- Default icon, can be overridden -->
                            <svg class="h-6 w-6 text-[#188C4A]" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg font-semibold leading-6 text-gray-900" id="modal-title">
                                {{ $title ?? 'Modal Title' }}
                            </h3>
                            <button @click="open = false"
                                class="absolute top-4 right-4 text-gray-400 hover:text-gray-500 focus:outline-none transition">
                                <span class="sr-only">Close</span>
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Body -->
                <div class="bg-white px-4 py-5 sm:p-6 text-sm text-gray-600">
                    {{ $slot ?? 'Are you sure you want to proceed with this action? This cannot be undone.' }}
                </div>

                <!-- Footer -->
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-gray-100 gap-3">
                    @if(isset($footer))
                        {{ $footer }}
                    @else
                        <button type="button"
                            class="inline-flex w-full justify-center rounded-xl bg-[#30BF62] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#188C4A] sm:ml-3 sm:w-auto transition duration-200"
                            @click="open = false">
                            Confirm Action
                        </button>
                        <button type="button"
                            class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition duration-200"
                            @click="open = false">
                            Cancel
                        </button>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>