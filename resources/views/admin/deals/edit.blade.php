<x-admin-layout>
    <x-slot name="main">
        <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Edit Deal</h2>
                    <p class="text-sm text-gray-600 mt-1">Update the deal information below.</p>
                </div>

                <form action="{{ route('admin.deals.update', $deal) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="bg-white shadow rounded-lg divide-y divide-gray-200">
                        <!-- Basic Information -->
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-800 mb-4">Basic Information</h3>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <label for="title" class="block text-sm font-medium mb-2">Title *</label>
                                    <input type="text" id="title" name="title"
                                        value="{{ old('title', $deal->title) }}"
                                        class="py-2 px-3 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"
                                        required>
                                    @error('title')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="description" class="block text-sm font-medium mb-2">Description</label>
                                    <textarea id="description" name="description" rows="3"
                                        class="py-2 px-3 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $deal->description) }}</textarea>
                                    @error('description')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="button_text" class="block text-sm font-medium mb-2">Button Text
                                        *</label>
                                    <input type="text" id="button_text" name="button_text"
                                        value="{{ old('button_text', $deal->button_text) }}"
                                        class="py-2 px-3 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"
                                        required>
                                    @error('button_text')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="button_link" class="block text-sm font-medium mb-2">Button Link
                                        *</label>
                                    <input type="url" id="button_link" name="button_link"
                                        value="{{ old('button_link', $deal->button_link) }}"
                                        class="py-2 px-3 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="https://example.com/shop" required>
                                    @error('button_link')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Discount Information -->
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-800 mb-4">Discount Information</h3>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                <div>
                                    <label for="discount_percentage" class="block text-sm font-medium mb-2">Discount
                                        Percentage</label>
                                    <div class="relative">
                                        <input type="number" id="discount_percentage" name="discount_percentage"
                                            value="{{ old('discount_percentage', $deal->discount_percentage) }}"
                                            min="0" max="100"
                                            class="py-2 px-3 pr-8 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
                                        <div
                                            class="absolute inset-y-0 right-0 flex items-center pointer-events-none z-20 pr-3">
                                            <span class="text-gray-500">%</span>
                                        </div>
                                    </div>
                                    @error('discount_percentage')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="discount_text" class="block text-sm font-medium mb-2">Discount
                                        Text</label>
                                    <input type="text" id="discount_text" name="discount_text"
                                        value="{{ old('discount_text', $deal->discount_text) }}"
                                        class="py-2 px-3 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="e.g. Massive discounts on premium gadgets">
                                    @error('discount_text')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="discount_details" class="block text-sm font-medium mb-2">Discount
                                        Details</label>
                                    <input type="text" id="discount_details" name="discount_details"
                                        value="{{ old('discount_details', $deal->discount_details) }}"
                                        class="py-2 px-3 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="e.g. On selected electronics and accessories">
                                    @error('discount_details')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Design Settings -->
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-800 mb-4">Design Settings</h3>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                <div>
                                    <label for="background_from_color" class="block text-sm font-medium mb-2">Gradient
                                        Start Color *</label>
                                    <div class="relative">
                                        <input type="color" id="background_from_color" name="background_from_color"
                                            value="{{ old('background_from_color', $deal->background_from_color) }}"
                                            class="py-1 px-1 block w-full h-10 border border-gray-200 rounded-lg text-sm">
                                    </div>
                                    @error('background_from_color')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="background_to_color" class="block text-sm font-medium mb-2">Gradient End
                                        Color *</label>
                                    <div class="relative">
                                        <input type="color" id="background_to_color" name="background_to_color"
                                            value="{{ old('background_to_color', $deal->background_to_color) }}"
                                            class="py-1 px-1 block w-full h-10 border border-gray-200 rounded-lg text-sm">
                                    </div>
                                    @error('background_to_color')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="priority" class="block text-sm font-medium mb-2">Priority *</label>
                                    <input type="number" id="priority" name="priority"
                                        value="{{ old('priority', $deal->priority) }}" min="0"
                                        class="py-2 px-3 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"
                                        required>
                                    <p class="text-xs text-gray-500 mt-1">Higher numbers appear first</p>
                                    @error('priority')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="image" class="block text-sm font-medium mb-2">Banner Image</label>
                                    <input type="file" id="image" name="image"
                                        class="py-2 px-3 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"
                                        accept="image/*">
                                    @if ($deal->image_url)
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500 mb-1">Current image:</p>
                                            <img src="{{ $deal->image_url }}" alt="Current banner image"
                                                class="h-20 rounded-lg object-cover">
                                        </div>
                                    @endif
                                    @error('image')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Schedule Settings -->
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-800 mb-4">Schedule Settings</h3>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label for="starts_at" class="block text-sm font-medium mb-2">Start Date</label>
                                    <input type="datetime-local" id="starts_at" name="starts_at"
                                        value="{{ old('starts_at', $deal->starts_at ? $deal->starts_at->format('Y-m-d\TH:i') : '') }}"
                                        class="py-2 px-3 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('starts_at')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="ends_at" class="block text-sm font-medium mb-2">End Date</label>
                                    <input type="datetime-local" id="ends_at" name="ends_at"
                                        value="{{ old('ends_at', $deal->ends_at ? $deal->ends_at->format('Y-m-d\TH:i') : '') }}"
                                        class="py-2 px-3 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('ends_at')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="sm:col-span-2">
                                    <div class="flex items-center">
                                        <input type="checkbox" id="is_active" name="is_active" value="1"
                                            {{ old('is_active', $deal->is_active) ? 'checked' : '' }}
                                            class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500">
                                        <label for="is_active" class="text-sm text-gray-500 ml-3">Active (visible on
                                            site)</label>
                                    </div>
                                    @error('is_active')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="px-6 py-4 bg-gray-50 flex justify-end">
                            <a href="{{ route('admin.deals.index') }}"
                                class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-lg border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm">
                                Cancel
                            </a>
                            <button type="submit"
                                class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-lg border border-transparent font-semibold bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm">
                                Update Deal
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </x-slot>
</x-admin-layout>