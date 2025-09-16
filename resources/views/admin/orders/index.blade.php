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
        <div class="grid grid-cols-1 md:grid-cols-7 gap-4 mb-6">
            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="rounded-full bg-blue-100 p-3 mr-4">
                        <i class="fas fa-shopping-bag text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Orders</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalOrders }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="rounded-full bg-yellow-100 p-3 mr-4">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Pending</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $pendingOrders }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="rounded-full bg-gray-100 p-3 mr-4">
                        <i class="fas fa-exclamation-circle text-gray-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Confirmed</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $confirmedOrders }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="rounded-full bg-green-100 p-3 mr-4">
                        <i class="fas fa-truck text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Processing</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $processingOrders }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="rounded-full bg-purple-100 p-3 mr-4">
                        <i class="fas fa-shipping-fast text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Shipped</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $shippedOrders }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="rounded-full bg-purple-100 p-3 mr-4">
                        <i class="fas fa-check-circle text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Completed</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $completedOrders }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="rounded-full bg-red-100 p-3 mr-4">
                        <i class="fas fa-times-circle text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Cancelled</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $cancelledOrders }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Card -->
        <div class="bg-white shadow-sm rounded-lg mb-6">
            {{-- <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Filters</h2>
            </div> --}}
            <div class="p-6">
                <form method="GET" action="{{ route('admin.orders.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Order Status</label>
                            <select name="status"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>
                                    Confirmed</option>
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

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                            <input type="date" name="start_date" value="{{ request('start_date', date('Y-m-d')) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                            <input type="date" name="end_date" value="{{ request('end_date', date('Y-m-d')) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select name="category_id"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                <option value="">All Categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
                            <select name="brand_id"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
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

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Product</label>
                            <select name="product_id"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                <option value="">All Products</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}"
                                        {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Order #, Customer, Phone, Email"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Actions</label>
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.orders.index') }}"
                                    class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors flex items-center justify-center w-1/2">
                                    <i class="fas fa-refresh mr-2"></i> Reset
                                </a>
                                <button type="submit"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center w-1/2">
                                    <i class="fas fa-filter mr-2"></i> Apply Filters
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-medium text-gray-900">All Orders</h2>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600">{{ $orders->total() }} results found</span>
                    {{-- <a href="{{ route('admin.orders.export') }}?{{ http_build_query(request()->all()) }}"
                        class="bg-green-600 text-white px-3 py-1.5 rounded text-sm hover:bg-green-700 transition-colors">
                        <i class="fas fa-download mr-1"></i> Export
                    </a> --}}
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Order #
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Payment
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($orders as $order)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $order->order_number }}</div>
                                    <div class="text-xs text-gray-500">via {{ ucfirst($order->payment_method) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $order->shippingAddress->full_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $order->customer_phone }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $order->created_at->format('M j, Y') }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $order->created_at->format('h:i A') }} |
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
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span @class([
                                        'px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full',
                                        'bg-yellow-100 text-yellow-800' => $order->status == 'pending',
                                        'bg-blue-100 text-blue-800' => $order->status == 'confirmed',
                                        'bg-indigo-100 text-indigo-800' => $order->status == 'processing',
                                        'bg-purple-100 text-purple-800' => $order->status == 'shipped',
                                        'bg-green-100 text-green-800' => $order->status == 'delivered',
                                        'bg-red-100 text-red-800' => $order->status == 'cancelled',
                                    ])>
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span @class([
                                        'px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full',
                                        'bg-green-100 text-green-800' => $order->payment_status == 'paid',
                                        'bg-yellow-100 text-yellow-800' => $order->payment_status == 'pending',
                                        'bg-red-100 text-red-800' => !in_array($order->payment_status, [
                                            'paid',
                                            'pending',
                                        ]),
                                    ])>
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ number_format($order->total_amount) }} TK
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.orders.show', $order->id) }}"
                                            class="text-blue-600 hover:text-blue-900" title="View Order">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.orders.edit', $order->id) }}"
                                            class="text-indigo-600 hover:text-indigo-900" title="Edit Order">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if ($order->canBeCancelled())
                                            <form action="{{ route('admin.orders.update-status', $order->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="submit" class="text-red-600 hover:text-red-900"
                                                    title="Cancel Order"
                                                    onclick="return confirm('Are you sure you want to cancel this order?')">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                    <div class="flex flex-col items-center justify-center py-8">
                                        <i class="fas fa-shopping-bag text-gray-300 text-4xl mb-3"></i>
                                        <p class="text-gray-600">No orders found matching your criteria.</p>
                                        <a href="{{ route('admin.orders.index') }}"
                                            class="text-blue-600 hover:text-blue-800 mt-2">
                                            Clear filters and try again
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="1" class="px-6 py-4 font-bold text-right text-sm text-gray-600">
                                Total Canceled Amount:
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-bold text-sm text-gray-900">
                                {{ number_format($totalCancelledAmount) }} TK
                            </td>
                            <td colspan="1" class="px-6 py-4 font-bold text-right text-sm text-gray-600">
                                Total Completed Amount:
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-bold text-sm text-gray-900">
                                {{ number_format($totalCompletedAmount) }} TK
                            </td>
                            <td colspan="1" class="px-6 py-4 font-bold text-right text-sm text-gray-600">
                                Total Ordered Amount:
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-bold text-sm text-gray-900">
                                {{ number_format($totalAmount) }} TK
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Pagination -->
            @if ($orders->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </x-slot>
</x-admin-layout>
