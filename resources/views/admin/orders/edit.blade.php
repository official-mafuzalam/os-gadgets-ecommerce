<x-admin-layout>
    @section('title', 'Order Edit')
    <x-slot name="main">
        <!-- Header with Breadcrumb -->
        <div class="bg-white shadow-sm rounded-lg mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-900">Edit Order #{{ $order->order_number }}</h1>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('admin.orders.show', $order->id) }}"
                            class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Order
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Order Status Card -->
                    <div class="bg-white shadow-sm rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Order Status & Details</h2>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Order Status</label>
                                    <select name="status"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>
                                            Confirmed</option>
                                        <option value="processing"
                                            {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>
                                            Shipped</option>
                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>
                                            Delivered</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                            Cancelled</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Status</label>
                                    <select name="payment_status"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                        <option value="pending"
                                            {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending
                                        </option>
                                        <option value="paid"
                                            {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="failed"
                                            {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                                        <option value="refunded"
                                            {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Refunded
                                        </option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                    <input type="text" name="full_name"
                                        value="{{ old('full_name', $order->shippingAddress->full_name) }}"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                    <input type="text" name="customer_phone"
                                        value="{{ old('customer_phone', $order->customer_phone) }}"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                                @if ($order->customer_email)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Registered
                                            Email</label>
                                        <input type="email" value="{{ $order->customer_email }}" disabled
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100 cursor-not-allowed">
                                    </div>
                                @endif
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Full Address</label>
                                <textarea name="full_address" rows="2"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                    placeholder="Add any notes about this order">{{ old('full_address', $order->shippingAddress->full_address) }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Order Notes</label>
                                <textarea name="notes" rows="1"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                    placeholder="Add any notes about this order">{{ old('notes', $order->notes) }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tracking Number</label>
                                <input type="text" name="tracking_number"
                                    value="{{ old('tracking_number', $order->tracking_number) }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                    placeholder="Enter tracking number">
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="bg-white shadow-sm rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                            <h2 class="text-lg font-medium text-gray-900">Order Items</h2>
                            <span class="text-sm text-gray-600">{{ $order->items->count() }} items</span>
                        </div>
                        <div class="divide-y divide-gray-200">
                            @foreach ($order->items as $item)
                                <div class="p-6 flex items-start">
                                    <div
                                        class="flex-shrink-0 w-16 h-16 rounded-md overflow-hidden border border-gray-200">
                                        <img src="{{ $item->product->images->where('is_primary', true)->first() ? Storage::url($item->product->images->where('is_primary', true)->first()->image_path) : 'https://via.placeholder.com/64' }}"
                                            alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <h3 class="text-md font-medium text-gray-900">{{ $item->product->name }}</h3>
                                        <p class="text-sm text-gray-500">SKU: {{ $item->product->sku }}</p>
                                        <div class="mt-2 grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div>
                                                <label
                                                    class="block text-xs font-medium text-gray-600 mb-1">Quantity</label>
                                                <input type="number" name="items[{{ $item->id }}][quantity]"
                                                    value="{{ old('items.' . $item->id . '.quantity', $item->quantity) }}"
                                                    min="1"
                                                    class="w-full border border-gray-300 rounded-lg px-3 py-1 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600 mb-1">Unit Price
                                                    (TK)
                                                </label>
                                                <input type="number" step="0.01"
                                                    name="items[{{ $item->id }}][unit_price]"
                                                    value="{{ old('items.' . $item->id . '.unit_price', $item->unit_price) }}"
                                                    min="0"
                                                    class="w-full border border-gray-300 rounded-lg px-3 py-1 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600 mb-1">Total
                                                    (TK)</label>
                                                <p class="text-sm font-semibold text-gray-900">
                                                    {{ number_format($item->unit_price * $item->quantity, 2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Order Summary -->
                    <div class="bg-white shadow-sm rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Order Summary</h2>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Subtotal (TK)</label>
                                    <input type="number" step="0.01" name="subtotal"
                                        value="{{ old('subtotal', $order->subtotal) }}" min="0"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Shipping Cost
                                        (TK)</label>
                                    <input type="number" step="0.01" name="shipping_cost"
                                        value="{{ old('shipping_cost', $order->shipping_cost) }}" min="0"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Discount Amount
                                        (TK)</label>
                                    <input type="number" step="0.01" name="discount_amount"
                                        value="{{ old('discount_amount', $order->discount_amount) }}" min="0"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Total Amount
                                        (TK)</label>
                                    <input type="number" step="0.01" name="total_amount"
                                        value="{{ old('total_amount', $order->total_amount) }}" min="0"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 bg-gray-50"
                                        readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="bg-white shadow-sm rounded-lg">
                        <div class="p-6 space-y-3">
                            <button type="submit"
                                class="w-full bg-blue-600 text-white py-2.5 px-4 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                <i class="fas fa-save mr-2"></i> Update Order
                            </button>

                            <a href="{{ route('admin.orders.show', $order->id) }}"
                                class="w-full bg-gray-200 text-gray-800 py-2.5 px-4 rounded-lg hover:bg-gray-300 transition-colors font-medium text-center block">
                                <i class="fas fa-times mr-2"></i> Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- JavaScript for auto-calculating total -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Calculate total when any amount field changes
                const amountFields = ['subtotal', 'shipping_cost', 'discount_amount'];

                amountFields.forEach(field => {
                    const input = document.querySelector(`input[name="${field}"]`);
                    if (input) {
                        input.addEventListener('input', calculateTotal);
                    }
                });

                // Also calculate on page load
                calculateTotal();

                function calculateTotal() {
                    const subtotal = parseFloat(document.querySelector('input[name="subtotal"]').value) || 0;
                    const shipping = parseFloat(document.querySelector('input[name="shipping_cost"]').value) || 0;
                    const discount = parseFloat(document.querySelector('input[name="discount_amount"]').value) || 0;

                    const total = subtotal + shipping - discount;
                    document.querySelector('input[name="total_amount"]').value = total.toFixed(2);
                }

                // Auto-calculate item totals
                document.querySelectorAll('input[name^="items"]').forEach(input => {
                    input.addEventListener('input', function() {
                        const name = this.name;
                        if (name.includes('quantity') || name.includes('unit_price')) {
                            const matches = name.match(/items\[(\d+)\]\[(quantity|unit_price)\]/);
                            if (matches) {
                                const itemId = matches[1];
                                const fieldType = matches[2];

                                const quantity = parseFloat(document.querySelector(
                                    `input[name="items[${itemId}][quantity]"]`).value) || 0;
                                const unitPrice = parseFloat(document.querySelector(
                                    `input[name="items[${itemId}][unit_price]"]`).value) || 0;

                                // Update the displayed total (this is just visual, not part of form submission)
                                const totalDisplay = document.querySelector(
                                        `input[name="items[${itemId}][quantity]"]`)
                                    .closest('.grid').querySelector('p');
                                if (totalDisplay) {
                                    totalDisplay.textContent = (quantity * unitPrice).toFixed(2);
                                }

                                // Recalculate order subtotal
                                calculateOrderSubtotal();
                            }
                        }
                    });
                });

                function calculateOrderSubtotal() {
                    let subtotal = 0;
                    document.querySelectorAll('input[name^="items"]').forEach(input => {
                        const name = input.name;
                        if (name.includes('quantity') && name.includes('unit_price')) {
                            const matches = name.match(/items\[(\d+)\]\[(quantity|unit_price)\]/);
                            if (matches) {
                                const itemId = matches[1];
                                const quantity = parseFloat(document.querySelector(
                                    `input[name="items[${itemId}][quantity]"]`).value) || 0;
                                const unitPrice = parseFloat(document.querySelector(
                                    `input[name="items[${itemId}][unit_price]"]`).value) || 0;
                                subtotal += quantity * unitPrice;
                            }
                        }
                    });

                    document.querySelector('input[name="subtotal"]').value = subtotal.toFixed(2);
                    calculateTotal();
                }
            });
        </script>
    </x-slot>
</x-admin-layout>
