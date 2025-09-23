<x-admin-layout>
    <x-slot name="main">
        @section('page-title')
            <title>Expense | Admin Panel</title>
        @endsection

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                    Expense
                </h1>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Manage all Expense in the system
                </p>
            </div>
            <div class="mt-4 md:mt-0">
                {{-- <a class="inline-flex items-center px-4 py-2 bg-gray-400 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-150"
                    href="{{ route('admin.accounts.index') }}">
                    Account Overview
                </a> --}}
                <a class="inline-flex items-center px-4 py-2 bg-gray-400 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-150"
                    href="{{ route('admin.expense-categories.index') }}">
                    Expense Category
                </a>
                <a href="{{ route('admin.expenses.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-150">
                    Add New Expense
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6 p-4">
            <form method="GET" action="{{ route('admin.expenses.index') }}"
                class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- From Date -->
                <div>
                    <label for="from_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        From Date
                    </label>
                    <input type="date" name="from_date" id="from_date"
                        value="{{ old('from_date', request('from_date')) }}" onclick="this.showPicker()"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 
                       dark:bg-gray-700 dark:text-white">
                </div>

                <!-- To Date -->
                <div>
                    <label for="to_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        To Date
                    </label>
                    <input type="date" name="to_date" id="to_date" value="{{ old('to_date', request('to_date')) }}"
                        onclick="this.showPicker()"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 
                       dark:bg-gray-700 dark:text-white">
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Category
                    </label>
                    <select name="category_id" id="category_id"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 
                       dark:bg-gray-700 dark:text-white">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ (string) request('category_id') === (string) $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Buttons -->
                <div class="flex items-end gap-2">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none">
                        Filter
                    </button>
                    <a href="{{ route('admin.expenses.index') }}"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 focus:outline-none">
                        Reset
                    </a>
                </div>
            </form>
        </div>


        <!-- Expense Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden dark:bg-gray-800">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                Date</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                Category</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                Amount</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                Verified By</th>
                            <th
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @forelse ($expenses as $expense)
                            <tr class="bg-gray-100 dark:bg-gray-900">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $expense->date->format('d M, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $expense->category->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ number_format($expense->amount, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $expense->insertedBy->name }}</td>
                                <td class="px-6 py-4 text-right whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2 justify-end">
                                        <a href="{{ route('admin.expenses.show', $expense->id) }}"
                                            class="text-blue-600 hover:text-blue-900">View</a>
                                        <a href="{{ route('admin.expenses.edit', $expense->id) }}"
                                            class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        <form action="{{ route('admin.expenses.destroy', $expense->id) }}"
                                            method="POST" onsubmit="return confirm('Are you sure?')" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-right text-sm text-gray-500">No expenses found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4">
                {{ $expenses->withQueryString()->links() }}
            </div>
        </div>

        <!-- Total Expense -->
        <div class="mt-4 bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
            <p class="text-lg font-semibold text-gray-800 dark:text-white">
                Total Expense: <span class="text-red-600">{{ number_format($totalExpense, 2) }} ৳</span>
            </p>
        </div>
    </x-slot>
</x-admin-layout>
