<x-admin-layout>
    <x-slot name="main">
        @php
            $isEdit = isset($expense);
            $pageTitle = $isEdit ? 'Edit Expense' : 'Create New Expense';
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
                    {{ $isEdit ? 'Update the Expense details' : 'Add a new Expense' }}
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
            <form action="{{ $isEdit ? route('admin.expenses.update', $expense->id) : route('admin.expenses.store') }}"
                method="POST">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                <div class="p-6 space-y-6">

                    <div class="grid grid-cols-2 gap-6">
                        <!-- Date -->
                        <div>
                            <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="date" id="date" required onclick="this.showPicker()"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                value="{{ old('date', $expense->date ?? '') }}">
                            @error('date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Name -->
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <select name="category_id" id="category_id" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="" disabled>Select category</option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('category_id', $expense->category_id ?? '') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Amount -->
                        <div>
                            <label for="amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Amount <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="amount" id="amount" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                value="{{ old('amount', $expense->amount ?? '') }}">
                            @error('amount')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Description <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="description" id="description" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                value="{{ old('description', $expense->description ?? '') }}">
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
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
                            {{ $isEdit ? 'Update Expense' : 'Create Expense' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </x-slot>
</x-admin-layout>
