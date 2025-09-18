<x-app-layout>
    <x-slot name="main">
        <div class="container mx-auto px-4 py-8 max-w-4xl">
            <div class="bg-white shadow-md rounded-lg p-6 md:p-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Track Your Order</h1>

                <form action="{{ route('public.parcel.tracking.submit') }}" method="POST" class="mb-8">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="tracking_number" class="block text-sm font-medium text-gray-700 mb-2">Tracking
                                Number</label>
                            <input type="text" id="tracking_number" name="tracking_number"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Enter your tracking number" value="{{ old('tracking_number') }}" required>
                            @error('tracking_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email
                                Address</label>
                            <input type="email" id="email" name="email"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Enter your email" value="{{ old('email') }}" required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div> --}}
                    </div>

                    <button type="submit"
                        class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition-colors">
                        Track Order
                    </button>
                </form>

                @if (isset($order))
                    <div class="border-t border-gray-200 pt-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Order Tracking Information</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-700 mb-2">Order Details</h3>
                                <div class="space-y-2">
                                    <p><span class="font-medium">Order Number:</span> {{ $order->order_number }}</p>
                                    <p><span class="font-medium">Tracking Number:</span> {{ $order->tracking_number }}
                                    </p>
                                    <p><span class="font-medium">Order Date:</span>
                                        {{ $order->created_at->format('M d, Y') }}</p>
                                    <p><span class="font-medium">Status:</span>
                                        <span
                                            class="px-2 py-1 text-xs rounded-full 
                                        @if ($order->status == 'delivered') bg-green-100 text-green-800
                                        @elseif($order->status == 'shipped') bg-blue-100 text-blue-800
                                        @elseif($order->status == 'processing') bg-yellow-100 text-yellow-800
                                        @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </p>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium text-gray-700 mb-2">Shipping Information</h3>
                                <div class="space-y-2">
                                    <p><span class="font-medium">Carrier:</span>
                                        {{ $order->carrier ?? 'Standard Shipping' }}</p>
                                    <p><span class="font-medium">Estimated Delivery:</span>
                                        @if ($order->estimated_delivery)
                                            {{ $order->estimated_delivery->format('M d, Y') }}
                                        @else
                                            Not available
                                        @endif
                                    </p>
                                    <p><span class="font-medium">Shipping Address:</span>
                                        {{ $order->shipping_address }}</p>
                                </div>
                            </div>
                        </div>

                        <h3 class="text-lg font-medium text-gray-700 mb-4">Tracking History</h3>
                        <div class="relative">
                            <!-- Tracking timeline -->
                            <div class="absolute left-4 top-0 h-full w-0.5 bg-gray-200"></div>

                            <div class="space-y-6 pl-12 relative">
                                @php
                                    $trackingEvents = [
                                        [
                                            'status' => 'ordered',
                                            'label' => 'Order Placed',
                                            'date' => $order->created_at,
                                        ],
                                        [
                                            'status' => 'confirmed',
                                            'label' => 'Order Confirmed',
                                            'date' => $order->created_at->addHours(2),
                                        ],
                                        [
                                            'status' => 'processing',
                                            'label' => 'Processing',
                                            'date' => $order->created_at->addDay(),
                                        ],
                                    ];

                                    if ($order->status == 'shipped' || $order->status == 'delivered') {
                                        $trackingEvents[] = [
                                            'status' => 'shipped',
                                            'label' => 'Shipped',
                                            'date' => $order->created_at->addDays(2),
                                        ];
                                    }

                                    if ($order->status == 'delivered') {
                                        $trackingEvents[] = [
                                            'status' => 'delivered',
                                            'label' => 'Delivered',
                                            'date' => $order->created_at->addDays(4),
                                        ];
                                    }
                                @endphp

                                @foreach ($trackingEvents as $event)
                                    <div class="relative">
                                        <div
                                            class="absolute -left-8 top-1.5 w-4 h-4 rounded-full 
                                    @if (array_search($event['status'], array_column($trackingEvents, 'status')) <=
                                            array_search($order->status, array_column($trackingEvents, 'status'))) bg-indigo-600
                                    @else
                                        bg-gray-300 @endif">
                                        </div>
                                        <div class="flex flex-col">
                                            <span
                                                class="text-sm font-medium text-gray-900">{{ $event['label'] }}</span>
                                            <span
                                                class="text-sm text-gray-500">{{ $event['date']->format('M d, Y h:i A') }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @elseif(session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="mt-8 border-t border-gray-200 pt-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Need Help?</h2>
                    <p class="text-gray-600 mb-4">If you're having trouble tracking your order or have any questions,
                        our customer service team is here to help.</p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('public.contact') }}"
                            class="text-indigo-600 hover:text-indigo-800 font-medium">Contact Us</a>
                        {{-- <a href="{{ route('public.faq') }}"
                            class="text-indigo-600 hover:text-indigo-800 font-medium">FAQs</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
