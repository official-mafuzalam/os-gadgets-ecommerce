<x-admin-layout>
    <x-slot name="main">
        @php
            $isEdit = isset($category);
            $pageTitle = $isEdit ? 'Edit Category' : 'Create New Category';
        @endphp

        @section('page-title')
            <title>{{ $pageTitle }} | Admin Panel</title>
        @endsection

        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                    {{ $pageTitle }}
                </h1>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    {{ $isEdit ? 'Update the category details' : 'Add a new category for blog posts' }}
                </p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('admin.expense-categories.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-400 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-150">
                    Back to Categories
                </a>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow overflow-hidden dark:bg-gray-800">
            <form
                action="{{ $isEdit ? route('admin.expense-categories.update', $category->id) : route('admin.expense-categories.store') }}"
                method="POST">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                value="{{ old('name', $category->name ?? '') }}">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="status" id="status" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="" disabled>Select status</option>
                                <option value="1"
                                    {{ old('status', $category->status ?? '') == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0"
                                    {{ old('status', $category->status ?? '') == 0 ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Footer -->
                <div class="flex items-center justify-end p-6 bg-gray-50 dark:bg-gray-700 space-x-3">
                    <button type="reset"
                        class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-700 dark:focus:ring-gray-800">
                        Reset
                    </button>
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        {{ $isEdit ? 'Update Category' : 'Create Category' }}
                    </button>
                </div>
            </form>
        </div>
    </x-slot>
</x-admin-layout>
