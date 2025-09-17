<x-app-layout>
    <x-slot name="main">
        <!-- Order Confirmation Section -->
        <div class="container mx-auto px-4 py-12">
            <div class="max-w-3xl mx-auto">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-green-500 to-green-600 py-8 px-6 text-center">
                        <div
                            class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h1 class="text-3xl font-bold text-white mb-2">Order Confirmed!</h1>
                        <p class="text-green-100">Thank you for your purchase</p>
                    </div>

                    <!-- Order Details -->
                    <div class="px-6 py-8">
                        <div class="text-center mb-8">
                            <p class="text-gray-600 mb-1">Your order has been placed successfully</p>
                            <p class="text-sm text-gray-500">Order ID: #{{ $order->order_number ?? '' }}</p>
                            <p class="text-sm text-gray-500">Date: {{ now()->format('F j, Y') }}</p>
                            <p class="text-sm text-gray-500">Time: {{ now()->format('g:i A') }}</p>
                        </div>

                        <div class="border border-gray-200 rounded-lg divide-y divide-gray-200 mb-8">
                            <!-- Order Summary -->
                            <div class="p-6">
                                <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h2>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Subtotal</span>
                                        <span class="font-medium">{{ number_format($order->subtotal) }} TK</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Shipping</span>
                                        <span class="font-medium">{{ number_format($order->shipping_cos) }} TK</span>
                                    </div>
                                    <div class="flex justify-between pt-3 border-t border-gray-200">
                                        <span class="text-lg font-semibold">Total</span>
                                        <span
                                            class="text-lg font-bold text-green-600">{{ number_format($order->total_amount) }}
                                            TK</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Shipping Information -->
                            <div class="p-6">
                                <h2 class="text-lg font-semibold text-gray-900 mb-4">Shipping Information</h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-500 mb-1">Shipping Address</h3>
                                        <p class="text-gray-900">{{ $order->shippingAddress->full_name ?? '---' }}
                                        </p>
                                        <p class="text-gray-900">
                                            {{ $order->shippingAddress->full_address ?? '' }}</p>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-500 mb-1">Contact Information</h3>
                                        <p class="text-gray-900">{{ $order->customer_email ?? '---' }}
                                        </p>
                                        <p class="text-gray-900">{{ $order->customer_phone ?? '---' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Method -->
                            {{-- <div class="p-6">
                                <h2 class="text-lg font-semibold text-gray-900 mb-4">Payment Method</h2>
                                <div class="flex items-center">
                                    <div class="bg-gray-100 p-2 rounded-md mr-3">
                                        <svg class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium">Credit Card ending in
                                            {{ $order->payment_last_four ?? '4242' }}</p>
                                        <p class="text-sm text-gray-500">Expires
                                            {{ $order->payment_expiry ?? '12/2025' }}</p>
                                    </div>
                                </div>
                            </div> --}}
                        </div>

                        <!-- Estimated Delivery -->
                        <div class="bg-blue-50 rounded-lg p-6 mb-8">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">Estimated Delivery</h3>
                                    <p class="mt-1 text-sm text-blue-700">Your order should arrive by <span
                                            class="font-semibold">{{ now()->addDays(2)->format('l, F j, Y') }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('public.products') }}"
                                class="flex-1 inline-flex justify-center items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Continue Shopping
                            </a>
                            {{-- <a href="{{ route('order.tracking', ['order_id' => $order->id ?? '123456']) }}"
                                class="flex-1 inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                                Track Your Order
                            </a> --}}
                        </div>
                    </div>
                </div>

                <!-- Order Support -->
                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-500">
                        Need help with your order? <a href="{{ route('public.contact') }}"
                            class="font-medium text-indigo-600 hover:text-indigo-500">Contact us</a>
                    </p>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
