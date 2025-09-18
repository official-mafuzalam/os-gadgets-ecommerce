<x-admin-layout>
    <x-slot name="main">
        <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Deal Details</h2>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.deals.edit', $deal) }}"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700">
                            <i class="fas fa-edit mr-1"></i> Edit Deal
                        </a>
                        <a href="{{ route('admin.deals.index') }}"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50">
                            <i class="fas fa-arrow-left mr-1"></i> Back to List
                        </a>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <!-- Banner Preview -->
                    <div class="relative">
                        <div class="bg-gradient-to-r bg-{{ $deal->background_color }} p-8">
                            <div class="flex flex-col md:flex-row items-center">
                                <div class="md:w-1/2 text-white">
                                    <h2 class="text-2xl md:text-3xl font-bold mb-4">{{ $deal->title }}</h2>
                                    <p class="text-white text-opacity-80 mb-6">{{ $deal->description }}</p>
                                    @if ($deal->discount_percentage)
                                        <div class="flex items-center mb-6">
                                            <div class="bg-white bg-opacity-20 rounded-lg px-4 py-2 mr-4">
                                                <span
                                                    class="block text-2xl font-bold">{{ $deal->discount_percentage }}%</span>
                                                <span class="text-xs uppercase">OFF</span>
                                            </div>
                                            <p class="text-sm">{{ $deal->discount_details }}</p>
                                        </div>
                                    @endif
                                    <a href="#"
                                        class="inline-flex items-center bg-white text-indigo-600 font-medium py-3 px-6 rounded-lg hover:bg-gray-100 transition-colors">
                                        {{ $deal->button_text }}
                                        <i class="fas fa-arrow-right ml-2"></i>
                                    </a>
                                </div>
                                <div class="md:w-1/2 mt-6 md:mt-0">
                                    <img src="{{ $deal->image_url }}" alt="{{ $deal->title }}"
                                        class="w-full h-64 md:h-80 object-cover rounded-lg shadow-lg">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-800 mb-4">Deal Information</h3>
                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Title</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $deal->title }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $deal->description ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Button Text</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $deal->button_text }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Button Link</dt>
                                    <dd class="mt-1 text-sm text-gray-900 break-all">{{ $deal->button_link }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-800 mb-4">Settings</h3>
                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1">
                                        <span
                                            class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-lg text-xs font-medium {{ $deal->is_active ? 'bg-teal-100 text-teal-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $deal->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Priority</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $deal->priority }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Discount</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        @if ($deal->discount_percentage)
                                            {{ $deal->discount_percentage }}% OFF - {{ $deal->discount_details }}
                                        @else
                                            No discount set
                                        @endif
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Schedule</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        @if ($deal->starts_at && $deal->ends_at)
                                            {{ $deal->starts_at->format('M d, Y H:i') }} to
                                            {{ $deal->ends_at->format('M d, Y H:i') }}
                                        @elseif($deal->starts_at)
                                            Starts: {{ $deal->starts_at->format('M d, Y H:i') }}
                                        @elseif($deal->ends_at)
                                            Ends: {{ $deal->ends_at->format('M d, Y H:i') }}
                                        @else
                                            No date restrictions
                                        @endif
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Colors</dt>
                                    <dd class="mt-1 flex items-center space-x-2">
                                        <span class="inline-block w-6 h-6 rounded-full"
                                            style="background-color: {{ $deal->background_from_color }}"></span>
                                        <span class="text-sm text-gray-900">{{ $deal->background_from_color }}</span>
                                        <span class="mx-1">→</span>
                                        <span class="inline-block w-6 h-6 rounded-full"
                                            style="background-color: {{ $deal->background_to_color }}"></span>
                                        <span class="text-sm text-gray-900">{{ $deal->background_to_color }}</span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Created</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $deal->created_at->format('M d, Y H:i') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $deal->updated_at->format('M d, Y H:i') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-admin-layout>
