<x-admin-layout>
    <x-slot name="main">
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Manage Deals</h2>
                    <a href="{{ route('admin.deals.create') }}"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700">
                        <i class="fas fa-plus mr-1"></i> Create New Deal
                    </a>
                </div>

                <!-- Card -->
                <div class="flex flex-col">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                                <!-- Table -->
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                Title</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                Discount</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                Dates</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                Priority</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                Products</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                Status</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">
                                                Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @forelse($deals as $deal)
                                            <tr class="hover:bg-gray-50">
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                    <div class="flex items-center">
                                                        <img class="h-10 w-10 rounded object-cover mr-3"
                                                            src="{{ $deal->image_url }}" alt="{{ $deal->title }}">
                                                        {{ $deal->title }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                    @if ($deal->discount_percentage)
                                                        <span
                                                            class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-lg text-xs font-medium bg-blue-100 text-blue-800">
                                                            {{ $deal->discount_percentage }}% OFF
                                                        </span>
                                                    @else
                                                        <span class="text-gray-500">No discount</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                    @if ($deal->starts_at && $deal->ends_at)
                                                        {{ $deal->starts_at->format('M d, Y') }} -
                                                        {{ $deal->ends_at->format('M d, Y') }}
                                                    @elseif($deal->starts_at)
                                                        Starts: {{ $deal->starts_at->format('M d, Y') }}
                                                    @elseif($deal->ends_at)
                                                        Ends: {{ $deal->ends_at->format('M d, Y') }}
                                                    @else
                                                        No date restrictions
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                    {{ $deal->priority }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                    <a href="{{ route('admin.deals.products.show', $deal) }}"
                                                        class="text-blue-500 hover:underline">
                                                        {{ $deal->products->count() }} Products
                                                    </a>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                    <form action="{{ route('admin.deals.toggle-status', $deal) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="focus:outline-none">
                                                            <span @class([
                                                                'inline-flex px-2 py-1 rounded-md text-xs font-medium cursor-pointer transition-colors',
                                                                'bg-green-500/20 text-green-700 dark:text-green-300 hover:bg-green-500/30' =>
                                                                    $deal->is_active,
                                                                'bg-red-500/20 text-red-700 dark:text-red-300 hover:bg-red-500/30' => !$deal->is_active,
                                                            ])>
                                                                {{ $deal->is_active ? 'Active' : 'Inactive' }}
                                                                <svg class="w-3 h-3 ml-1 inline" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4">
                                                                    </path>
                                                                </svg>
                                                            </span>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.deals.toggle-featured', $deal) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="focus:outline-none">
                                                            <span @class([
                                                                'inline-flex px-2 py-1 rounded-md text-xs font-medium cursor-pointer transition-colors',
                                                                'bg-green-500/20 text-green-700 dark:text-green-300 hover:bg-green-500/30' =>
                                                                    $deal->is_featured,
                                                                'bg-red-500/20 text-red-700 dark:text-red-300 hover:bg-red-500/30' => !$deal->is_featured,
                                                            ])>
                                                                {{ $deal->is_featured ? 'Featured' : 'Not Featured' }}
                                                                <svg class="w-3 h-3 ml-1 inline" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4">
                                                                    </path>
                                                                </svg>
                                                            </span>
                                                        </button>
                                                    </form>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <div class="flex justify-end items-center space-x-2">
                                                        <a href="{{ route('admin.deals.show', $deal) }}"
                                                            class="py-1.5 px-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50">
                                                            <i class="fas fa-eye mr-1"></i>
                                                        </a>
                                                        <a href="{{ route('admin.deals.edit', $deal) }}"
                                                            class="py-1.5 px-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50">
                                                            <i class="fas fa-edit mr-1"></i>
                                                        </a>
                                                        <form action="{{ route('admin.deals.destroy', $deal) }}"
                                                            method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="py-1.5 px-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-100 text-red-800 hover:bg-red-200"
                                                                onclick="return confirm('Are you sure you want to delete this deal?')">
                                                                <i class="fas fa-trash mr-1"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                                    No deals found. <a href="{{ route('admin.deals.create') }}"
                                                        class="text-blue-600 hover:text-blue-800">Create your first
                                                        deal</a>.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <!-- End Table -->

                                <!-- Footer -->
                                <div class="px-6 py-4 border-t border-gray-200">
                                    {{ $deals->links() }}
                                </div>
                                <!-- End Footer -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Card -->
            </div>
        </div>
    </x-slot>
</x-admin-layout>
