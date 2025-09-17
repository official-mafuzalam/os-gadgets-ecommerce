<x-admin-layout>
    <x-slot name="main">
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <!-- Header Section -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">{{ $deal->title }}</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            Manage Products in This Deal
                        </p>
                    </div>
                    <div class="flex space-x-2">
                        <button type="button" onclick="openProductAssignmentModal()"
                            class="px-3 py-2 text-sm font-medium rounded-md bg-purple-600 text-white hover:bg-purple-700 transition-colors">
                            Add Products
                        </button>
                        <a href="{{ route('admin.deals.edit', $deal->id) }}"
                            class="px-3 py-2 text-sm font-medium rounded-md bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                            Edit Deal
                        </a>
                        <a href="{{ route('admin.deals.index') }}"
                            class="px-3 py-2 text-sm font-medium rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600 transition-colors">
                            Back to Deals
                        </a>
                    </div>
                </div>

                <!-- Products Table Section -->
                <div class="px-6 py-4">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Assigned Products
                        ({{ $deal->products->count() }})</h3>

                    @if ($deal->products->count() > 0)
                        <!-- Card -->
                        <div class="flex flex-col">
                            <div class="-m-1.5 overflow-x-auto">
                                <div class="p-1.5 min-w-full inline-block align-middle">
                                    <div
                                        class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-gray-800 dark:border-gray-700">
                                        <!-- Table -->
                                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                            <thead class="bg-gray-50 dark:bg-gray-700">
                                                <tr>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                                                        Product</th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                                                        Price</th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                                                        Stock</th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                                                        Status</th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                                                        Featured</th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                                                        Order</th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                                                        Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                                @foreach ($deal->products as $product)
                                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="flex items-center">
                                                                <img class="h-10 w-10 rounded object-cover mr-3"
                                                                    src="{{ $product->images->where('is_primary', true)->first() ? Storage::url($product->images->where('is_primary', true)->first()->image_path) : 'https://via.placeholder.com/40' }}"
                                                                    alt="{{ $product->name }}">
                                                                <div>
                                                                    <div
                                                                        class="text-sm font-medium text-gray-900 dark:text-white">
                                                                        {{ $product->name }}
                                                                    </div>
                                                                    <div
                                                                        class="text-sm text-gray-500 dark:text-gray-400">
                                                                        SKU: {{ $product->sku ?? 'N/A' }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                                            <div class="flex flex-col">
                                                                @if ($product->discount)
                                                                    <span class="font-semibold text-green-600">
                                                                        {{ number_format($product->price - $product->discount) }}
                                                                        TK |
                                                                        {{ number_format(($product->discount / $product->price) * 100) }}%
                                                                        OFF
                                                                    </span>
                                                                    <span
                                                                        class="text-xs text-gray-500 line-through">{{ number_format($product->price) }}
                                                                        TK
                                                                    </span>
                                                                @else
                                                                    <span
                                                                        class="font-semibold">{{ number_format($product->price) }}
                                                                        TK</span>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                                            {{ $product->stock_quantity }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <span
                                                                class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-lg text-xs font-medium
                                                                    {{ $product->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                                                            </span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <form
                                                                action="{{ route('admin.deals.products.toggle-featured', [$deal->id, $product->id]) }}"
                                                                method="POST" class="inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit"
                                                                    class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 
                                                                {{ $product->pivot->is_featured ? 'bg-purple-600' : 'bg-gray-200 dark:bg-gray-600' }}">
                                                                    <span class="sr-only">Toggle featured</span>
                                                                    <span aria-hidden="true"
                                                                        class="inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200 
                                                                  {{ $product->pivot->is_featured ? 'translate-x-5' : 'translate-x-0' }}"></span>
                                                                </button>
                                                            </form>
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                                            {{ $product->pivot->order }}
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                            <div class="flex justify-end items-center space-x-2">
                                                                <a href="{{ route('admin.products.show', $product->id) }}"
                                                                    class="py-1.5 px-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700">
                                                                    <i class="fas fa-eye mr-1"></i> View
                                                                </a>
                                                                <form
                                                                    action="{{ route('admin.deals.products.remove', [$deal->id, $product->id]) }}"
                                                                    method="POST" class="inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="py-1.5 px-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-100 text-red-800 hover:bg-red-200 dark:bg-red-900 dark:text-red-200 dark:hover:bg-red-800"
                                                                        onclick="return confirm('Are you sure you want to remove this product from the deal?')">
                                                                        <i class="fas fa-times mr-1"></i> Remove
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <!-- End Table -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Card -->
                    @else
                        <div
                            class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-6 text-center">
                            <i class="fas fa-box-open text-gray-400 text-3xl mb-2"></i>
                            <p class="text-gray-600 dark:text-gray-300">No products assigned to this deal yet.</p>
                            <button type="button" onclick="openProductAssignmentModal()"
                                class="mt-3 px-4 py-2 text-sm font-medium rounded-md bg-purple-600 text-white hover:bg-purple-700 transition-colors">
                                Add Products
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Assignment Modal -->
        <div id="productAssignmentModal"
            class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div
                class="relative top-20 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white dark:bg-gray-800">
                <div class="mt-3">
                    <div class="flex justify-between items-center pb-3 border-b">
                        <h3 class="text-xl font-medium text-gray-900 dark:text-white">Add Products to Deal</h3>
                        <button onclick="closeProductAssignmentModal()"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <form id="productAssignmentForm" action="{{ route('admin.deals.products.assign', $deal->id) }}"
                        method="POST" class="mt-4">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Select Products to Add to This Deal:
                            </label>
                            <div
                                class="max-h-96 overflow-y-auto border border-gray-300 rounded-md p-2 dark:border-gray-600">
                                @foreach ($allProducts as $product)
                                    <div class="flex items-center p-2 hover:bg-gray-50 dark:hover:bg-gray-700 rounded">
                                        <input type="checkbox" name="product_ids[]" value="{{ $product->id }}"
                                            {{ $deal->products->contains($product->id) ? 'checked disabled' : '' }}
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded dark:bg-gray-800 dark:border-gray-600">
                                        <label class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                            {{ $product->name }}
                                            <span class="text-xs text-gray-500">(SKU:
                                                {{ $product->sku ?? 'N/A' }})</span>
                                            @if ($product->is_active)
                                                <span
                                                    class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                    Active
                                                </span>
                                            @endif
                                            @if ($deal->products->contains($product->id))
                                                <span
                                                    class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                    Already Added
                                                </span>
                                            @endif
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('product_ids')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                            <button type="button" onclick="closeProductAssignmentModal()"
                                class="px-4 py-2 text-sm font-medium rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600 transition-colors">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium rounded-md bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                                Add Selected Products
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function openProductAssignmentModal() {
                document.getElementById('productAssignmentModal').classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeProductAssignmentModal() {
                document.getElementById('productAssignmentModal').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            // Close modal when clicking outside
            document.getElementById('productAssignmentModal').addEventListener('click', function(e) {
                if (e.target.id === 'productAssignmentModal') {
                    closeProductAssignmentModal();
                }
            });
        </script>
    </x-slot>
</x-admin-layout>
