@php
    $carousel = $carousel ?? null;
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Title -->
    <div class="md:col-span-2">
        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
        <input type="text" name="title" id="title" value="{{ old('title', $carousel->title ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
            required>
        @error('title')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Description -->
    <div class="md:col-span-2">
        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
        <textarea name="description" id="description" rows="3"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description', $carousel->description ?? '') }}</textarea>
        @error('description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Image -->
    <div class="md:col-span-2">
        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">
            {{ $carousel ? 'Update Image' : 'Image *' }}
        </label>
        @if ($carousel && $carousel->image)
            <div class="mb-3">
                <img src="{{ $carousel->image_url }}" alt="Current image" class="w-32 h-20 object-cover rounded border">
            </div>
        @endif
        <input type="file" name="image" id="image" accept="image/*"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
            {{ $carousel ? '' : 'required' }}>
        @error('image')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
        <p class="mt-1 text-sm text-gray-500">Recommended size: 1200×600 pixels</p>
    </div>

    <!-- Primary Button -->
    <div>
        <label for="button_text" class="block text-sm font-medium text-gray-700 mb-1">Primary Button Text</label>
        <input type="text" name="button_text" id="button_text"
            value="{{ old('button_text', $carousel->button_text ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
        @error('button_text')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="button_url" class="block text-sm font-medium text-gray-700 mb-1">Primary Button URL</label>
        <input type="url" name="button_url" id="button_url"
            value="{{ old('button_url', $carousel->button_url ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
            placeholder="https://...">
        @error('button_url')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Secondary Button -->
    <div>
        <label for="secondary_button_text" class="block text-sm font-medium text-gray-700 mb-1">Secondary Button
            Text</label>
        <input type="text" name="secondary_button_text" id="secondary_button_text"
            value="{{ old('secondary_button_text', $carousel->secondary_button_text ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
        @error('secondary_button_text')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="secondary_button_url" class="block text-sm font-medium text-gray-700 mb-1">Secondary Button
            URL</label>
        <input type="url" name="secondary_button_url" id="secondary_button_url"
            value="{{ old('secondary_button_url', $carousel->secondary_button_url ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
            placeholder="https://...">
        @error('secondary_button_url')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Background Color -->
    <div>
        <label for="background_color" class="block text-sm font-medium text-gray-700 mb-1">Background Color</label>
        <select name="background_color" id="background_color"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="gradient-to-r from-indigo-900 to-purple-800"
                {{ old('background_color', $carousel->background_color ?? '') == 'gradient-to-r from-indigo-900 to-purple-800' ? 'selected' : '' }}>
                Indigo to Purple</option>
            <option value="gradient-to-r from-blue-900 to-indigo-800"
                {{ old('background_color', $carousel->background_color ?? '') == 'gradient-to-r from-blue-900 to-indigo-800' ? 'selected' : '' }}>
                Blue to Indigo</option>
            <option value="gradient-to-r from-purple-900 to-pink-800"
                {{ old('background_color', $carousel->background_color ?? '') == 'gradient-to-r from-purple-900 to-pink-800' ? 'selected' : '' }}>
                Purple to Pink</option>
            <option value="gradient-to-r from-green-900 to-teal-800"
                {{ old('background_color', $carousel->background_color ?? '') == 'gradient-to-r from-green-900 to-teal-800' ? 'selected' : '' }}>
                Green to Teal</option>
        </select>
        @error('background_color')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Order -->
    <div>
        <label for="order" class="block text-sm font-medium text-gray-700 mb-1">Order</label>
        <input type="number" name="order" id="order" value="{{ old('order', $carousel->order ?? 0) }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
            min="0">
        @error('order')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Status -->
    <div class="md:col-span-2">
        <div class="flex items-center">
            <input type="checkbox" name="is_active" id="is_active" value="1"
                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                {{ old('is_active', $carousel->is_active ?? true) ? 'checked' : '' }}>
            <label for="is_active" class="ml-2 block text-sm text-gray-900">Active (Visible on website)</label>
        </div>
        @error('is_active')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>
