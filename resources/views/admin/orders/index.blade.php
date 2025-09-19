<x-admin-layout>
    @section('title', 'Orders Management')
    <x-slot name="main">
        {{-- <div class="bg-white shadow-sm rounded-lg mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900">Order Management</h1>
                <p class="mt-1 text-sm text-gray-600">Manage and track all customer orders</p>
            </div>
        </div> --}}

        <!-- Filters and Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-7 gap-3 mb-6">
            @php
                $stats = [
                    [
                        'label' => 'Total Orders',
                        'count' => $totalOrders,
                        'icon' => 'fas fa-shopping-bag',
                        'bg' => 'bg-blue-100',
                        'color' => 'text-blue-600',
                    ],
                    [
                        'label' => 'Pending',
                        'count' => $pendingOrders,
                        'icon' => 'fas fa-clock',
                        'bg' => 'bg-yellow-100',
                        'color' => 'text-yellow-600',
                    ],
                    [
                        'label' => 'Confirmed',
                        'count' => $confirmedOrders,
                        'icon' => 'fas fa-exclamation-circle',
                        'bg' => 'bg-gray-100',
                        'color' => 'text-gray-600',
                    ],
                    [
                        'label' => 'Processing',
                        'count' => $processingOrders,
                        'icon' => 'fas fa-sync-alt',
                        'bg' => 'bg-green-100',
                        'color' => 'text-green-600',
                    ],
                    [
                        'label' => 'Shipped',
                        'count' => $shippedOrders,
                        'icon' => 'fas fa-shipping-fast',
                        'bg' => 'bg-purple-100',
                        'color' => 'text-purple-600',
                    ],
                    [
                        'label' => 'Completed',
                        'count' => $completedOrders,
                        'icon' => 'fas fa-check-circle',
                        'bg' => 'bg-green-100',
                        'color' => 'text-green-600',
                    ],
                    [
                        'label' => 'Cancelled',
                        'count' => $cancelledOrders,
                        'icon' => 'fas fa-times-circle',
                        'bg' => 'bg-red-100',
                        'color' => 'text-red-600',
                    ],
                ];
            @endphp

            @foreach ($stats as $stat)
                <div class="bg-white p-3 rounded-lg shadow-sm border border-gray-200 flex items-center space-x-3">
                    <div class="rounded-full {{ $stat['bg'] }} p-2 flex items-center justify-center">
                        <i class="{{ $stat['icon'] }} {{ $stat['color'] }} text-lg"></i>
                    </div>
                    <div class="flex flex-col">
                        <p class="text-xs font-medium text-gray-600">{{ $stat['label'] }}</p>
                        <p class="text-lg font-bold text-gray-900">{{ $stat['count'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Filters Card -->
        <div class="bg-white shadow-sm rounded-lg mb-6 p-4">
            <form method="GET" action="{{ route('admin.orders.index') }}">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3">
                    <!-- Order Status -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Order Status</label>
                        <select name="status"
                            class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed
                            </option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>
                                Processing</option>
                            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped
                            </option>
                            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>
                                Delivered</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                                Cancelled</option>
                        </select>
                    </div>

                    <!-- Date From -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Date From</label>
                        <input type="date" name="start_date" value="{{ request('start_date', date('Y-m-d')) }}"
                            class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    </div>

                    <!-- Date To -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Date To</label>
                        <input type="date" name="end_date" value="{{ request('end_date', date('Y-m-d')) }}"
                            class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Category</label>
                        <select name="category_id"
                            class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Brand -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Brand</label>
                        <select name="brand_id"
                            class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            <option value="">All Brands</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}"
                                    {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Second Row -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 mt-3">
                    <!-- Product -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Product</label>
                        <select name="product_id"
                            class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            <option value="">All Products</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}"
                                    {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Search -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Order #, Customer, Phone, Email"
                            class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    </div>

                    <!-- Actions -->
                    <div class="md:col-span-2 flex space-x-2 items-end">
                        <a href="{{ route('admin.orders.index') }}"
                            class="flex-1 bg-gray-200 text-gray-800 px-3 py-1 rounded-md hover:bg-gray-300 transition-colors text-sm text-center">
                            <i class="fas fa-refresh mr-1"></i> Reset
                        </a>
                        <button type="submit"
                            class="flex-1 bg-blue-600 text-white px-3 py-1 rounded-md hover:bg-blue-700 transition-colors text-sm flex items-center justify-center">
                            <i class="fas fa-filter mr-1"></i> Apply Filters
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Orders Table -->
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-md font-semibold text-gray-900">All Orders</h2>
                <div class="flex items-center space-x-2 text-xs text-gray-600">
                    <span>{{ $orders->total() }} results found</span>
                    {{-- Optional Export Button --}}
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Order #
                            </th>
                            <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Customer
                            </th>
                            <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Status
                            </th>
                            <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Address
                            </th>
                            <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Total
                            </th>
                            <th class="px-3 py-2 text-right font-medium text-gray-500 uppercase tracking-wider">Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($orders as $order)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-3 py-2 whitespace-nowrap group relative">
                                    <div class="font-medium text-gray-900">{{ $order->order_number }}</div>
                                    <div class="text-xs text-gray-500">via {{ ucfirst($order->payment_method) }}</div>

                                    <div
                                        class="absolute top-1/2 left-full ml-3 -translate-y-1/2 hidden group-hover:flex flex-col items-start bg-gray-900 text-white text-xs rounded-lg px-3 py-2
                                        shadow-lg whitespace-normal w-56 z-20 transition-all duration-200 ease-out opacity-0 group-hover:opacity-100 group-hover:translate-x-0 -translate-x-2">
                                        <span class="font-semibold text-gray-200">Address:</span>
                                        <span class="text-gray-300">{{ $order->shippingAddress->full_address }}</span>
                                        <span class="mt-1 font-semibold text-gray-200">Delivery Area:</span>
                                        <span class="text-gray-300">
                                            @if ($order->shippingAddress->delivery_area === 'outside_dhaka')
                                                Outside Dhaka
                                            @elseif ($order->shippingAddress->delivery_area === 'inside_dhaka')
                                                Inside Dhaka
                                            @else
                                                {{ ucfirst(str_replace('_', ' ', $order->shippingAddress->delivery_area)) }}
                                            @endif
                                        </span>
                                        <div
                                            class="absolute top-1/2 -translate-y-1/2 right-full w-3 h-3 bg-gray-900 rotate-45">
                                        </div>
                                    </div>
                                </td>

                                <td class="px-3 py-2 whitespace-nowrap">
                                    <div class="font-medium text-gray-900">{{ $order->shippingAddress->full_name }}
                                    </div>
                                    <div class="text-xs text-gray-500">{{ $order->customer_phone }}</div>
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    <div class="text-gray-900">{{ $order->created_at->format('M j, Y') }}</div>
                                    <div class="text-xs text-gray-400">
                                        {{ $order->created_at->format('h:i A') }}
                                        @php
                                            $diff = now()->diff($order->created_at);
                                            if ($diff->d > 0) {
                                                $ago = $diff->d . ' day' . ($diff->d > 1 ? 's' : '') . ' ago';
                                            } elseif ($diff->h > 0) {
                                                $ago = $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' ago';
                                            } else {
                                                $ago = $diff->i . ' min ago';
                                            }
                                        @endphp
                                        <span class="text-xs text-gray-400">{{ $ago }}</span>
                                    </div>
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    <form action="{{ route('admin.orders.update-status', $order->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()"
                                            class="border rounded-md px-2 py-1 text-xs font-semibold
                                        @switch($order->status)
                                            @case('pending') bg-yellow-100 text-yellow-800 @break
                                            @case('confirmed') bg-blue-100 text-blue-800 @break
                                            @case('processing') bg-indigo-100 text-indigo-800 @break
                                            @case('shipped') bg-purple-100 text-purple-800 @break
                                            @case('delivered') bg-green-100 text-green-800 @break
                                            @case('cancelled') bg-red-100 text-red-800 @break
                                        @endswitch cursor-pointer hover:opacity-80 transition-colors">
                                            <option value="pending"
                                                {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="confirmed"
                                                {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed
                                            </option>
                                            <option value="processing"
                                                {{ $order->status == 'processing' ? 'selected' : '' }}>Processing
                                            </option>
                                            <option value="shipped"
                                                {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                            <option value="delivered"
                                                {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered
                                            </option>
                                            <option value="cancelled"
                                                {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled
                                            </option>
                                        </select>
                                    </form>
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    {{ \Illuminate\Support\Str::limit($order->shippingAddress->full_address, 40) }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap text-gray-900 text-sm">
                                    {{ number_format($order->total_amount) }} TK</td>
                                <td class="px-3 py-2 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.orders.show', $order->id) }}"
                                            class="text-blue-600 hover:text-blue-900" title="View Order"><i
                                                class="fas fa-eye"></i></a>
                                        <a href="{{ route('admin.orders.edit', $order->id) }}"
                                            class="text-indigo-600 hover:text-indigo-900" title="Edit Order"><i
                                                class="fas fa-edit"></i></a>
                                        @if ($order->canBeCancelled())
                                            <form action="{{ route('admin.orders.update-status', $order->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="submit" class="text-red-600 hover:text-red-900"
                                                    title="Cancel Order" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-3 py-6 text-center text-gray-500 text-sm">
                                    <div class="flex flex-col items-center justify-center py-6">
                                        <i class="fas fa-shopping-bag text-gray-300 text-3xl mb-2"></i>
                                        <p>No orders found matching your criteria.</p>
                                        <a href="{{ route('admin.orders.index') }}"
                                            class="text-blue-600 hover:text-blue-800 mt-1 text-sm">Clear filters</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="text-sm font-semibold text-gray-900">
                            <td colspan="1" class="px-3 py-2 text-right font-medium text-gray-600">Total Canceled
                                Amount:</td>
                            <td class="px-3 py-2 whitespace-nowrap">{{ number_format($totalCancelledAmount) }} TK</td>
                            <td colspan="1" class="px-3 py-2 text-right font-medium text-gray-600">Total Completed
                                Amount:</td>
                            <td class="px-3 py-2 whitespace-nowrap">{{ number_format($totalCompletedAmount) }} TK</td>
                            <td colspan="1" class="px-3 py-2 text-right font-medium text-gray-600">Total Ordered
                                Amount:</td>
                            <td class="px-3 py-2 whitespace-nowrap">{{ number_format($totalAmount) }} TK</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Pagination -->
            @if ($orders->hasPages())
                <div class="px-4 py-3 border-t border-gray-200">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>

    </x-slot>
</x-admin-layout>
