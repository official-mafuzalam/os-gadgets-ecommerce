<x-app-layout>
    @section('title', 'Checkout')
    <x-slot name="main">
        {{-- <div class="bg-gray-50 py-6">
            <div class="container mx-auto px-4">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('public.welcome') }}" class="text-sm text-gray-700 hover:text-blue-600">
                                <i class="fas fa-home mr-1"></i> Home
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                                <a href="{{ route('public.cart') }}"
                                    class="text-sm text-gray-700 hover:text-blue-600">Shopping Cart</a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                                <span class="text-sm font-medium text-gray-500">Checkout</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div> --}}

        <div class="container mx-auto px-4 py-6">
            <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                {{-- Billing Form --}}
                <div class="lg:col-span-7">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                        <div class="flex items-center mb-6">
                            <div class="bg-blue-100 w-10 h-10 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-user text-blue-600"></i>
                            </div>
                            <h2 class="text-xl font-semibold text-gray-900">Billing Details</h2>
                        </div>

                        <form action="{{ route('public.checkout.process') }}" method="POST" id="checkout-form">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                                    <input type="text" name="full_name" required
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-colors"
                                        placeholder="Enter your full name">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number *</label>
                                    <input type="text" name="phone" required
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-colors"
                                        placeholder="Your phone number">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" name="email"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-colors"
                                    placeholder="your.email@example.com">
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Delivery Full Address
                                    *</label>
                                <textarea name="full_address" required rows="3"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-colors"
                                    placeholder="Enter your complete delivery address"></textarea>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Notes (Optional)</label>
                                <textarea name="notes" rows="3"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-colors"
                                    placeholder="Enter any additional notes or instructions"></textarea>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Delivery Option *</label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div class="relative">
                                        <input class="sr-only peer" type="radio" name="delivery_area"
                                            id="inside_dhaka" value="inside_dhaka" checked>
                                        <label
                                            class="flex p-4 bg-white border border-gray-300 rounded-lg cursor-pointer focus:outline-none hover:bg-gray-50 peer-checked:border-blue-600 peer-checked:ring-1 peer-checked:ring-blue-600 transition-colors"
                                            for="inside_dhaka">
                                            <div class="ml-3">
                                                <span class="mt-1 font-semibold text-gray-900">Inside Dhaka</span>
                                                <p class="mt-1 text-sm text-gray-500">
                                                    <span
                                                        id="inside_dhaka_price">{{ setting('inside_dhaka_shipping_cost') }}</span>
                                                    TK - 1-2 business days
                                                </p>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="relative">
                                        <input class="sr-only peer" type="radio" name="delivery_area"
                                            id="outside_dhaka" value="outside_dhaka">
                                        <label
                                            class="flex p-4 bg-white border border-gray-300 rounded-lg cursor-pointer focus:outline-none hover:bg-gray-50 peer-checked:border-blue-600 peer-checked:ring-1 peer-checked:ring-blue-600 transition-colors"
                                            for="outside_dhaka">
                                            <div class="ml-3">
                                                <span class="mt-1 font-semibold text-gray-900">Outside Dhaka</span>
                                                <p class="mt-1 text-sm text-gray-500">
                                                    <span
                                                        id="outside_dhaka_price">{{ setting('outside_dhaka_shipping_cost') }}</span>
                                                    TK - 3-5 business days
                                                </p>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" id="place-order-btn"
                                class="w-full bg-blue-600 text-white py-3.5 px-6 rounded-lg font-medium hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center justify-center">
                                <i class="fas fa-lock mr-2"></i> Place Order Securely
                            </button>
                        </form>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center mb-4">
                            <div class="bg-blue-100 w-8 h-8 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-shield-alt text-blue-600 text-sm"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Secure Checkout</h3>
                        </div>
                        <p class="text-sm text-gray-600">Your information is protected by 256-bit SSL encryption</p>
                    </div>
                </div>

                {{-- Order Summary --}}
                <div class="lg:col-span-5 mt-6 lg:mt-0">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-6">
                        <div class="flex items-center mb-6">
                            <div class="bg-blue-100 w-10 h-10 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-receipt text-blue-600"></i>
                            </div>
                            <h2 class="text-xl font-semibold text-gray-900">Order Summary</h2>
                        </div>

                        <div class="divide-y divide-gray-200 mb-4">
                            @foreach ($cartItems as $item)
                                <div class="flex justify-between items-start py-4">
                                    <div class="flex items-start">
                                        <div
                                            class="flex-shrink-0 w-16 h-16 rounded-md overflow-hidden border border-gray-200">
                                            <img src="{{ $item->product->images->where('is_primary', true)->first() ? Storage::url($item->product->images->where('is_primary', true)->first()->image_path) : 'https://via.placeholder.com/80' }}"
                                                alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-sm font-medium text-gray-900">{{ $item->product->name }}
                                            </h3>
                                            <p class="text-xs text-gray-500 mt-1">Qty: {{ $item->quantity }}</p>
                                        </div>
                                    </div>
                                    <span
                                        class="text-sm font-medium text-gray-900">{{ number_format($item->total_price, 2) }}
                                        TK</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="space-y-3 border-t border-gray-200 pt-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="text-gray-900">{{ number_format($subtotal, 2) }} TK</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Delivery charge</span>
                                <span id="delivery_charge" class="text-gray-900">
                                    {{ number_format(setting('inside_dhaka_shipping_cost'), 2) }} TK
                                </span>
                            </div>
                            <div class="flex justify-between text-lg font-semibold pt-3 border-t border-gray-200">
                                <span class="text-gray-900">Total</span>
                                <span id="total_amount" class="text-gray-900">
                                    {{ number_format($subtotal + setting('inside_dhaka_shipping_cost'), 2) }} TK
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function updateDelivery() {
                const selectedOption = document.querySelector('input[name="delivery_area"]:checked');

                // Get the actual prices from the spans
                const insideDhakaPrice = parseFloat(document.getElementById('inside_dhaka_price').textContent);
                const outsideDhakaPrice = parseFloat(document.getElementById('outside_dhaka_price').textContent);

                // Determine the delivery charge based on selection
                const deliveryCharge = selectedOption.value === 'inside_dhaka' ? insideDhakaPrice : outsideDhakaPrice;

                // Update the delivery charge display
                document.getElementById('delivery_charge').innerText = deliveryCharge.toFixed(2) + ' TK';

                // Calculate and update total
                const subtotal = parseFloat("{{ $subtotal }}");
                const total = subtotal + deliveryCharge;
                document.getElementById('total_amount').innerText = total.toFixed(2) + ' TK';
            }

            // Initialize on page load
            document.addEventListener('DOMContentLoaded', function() {
                // Set up delivery option change listeners
                document.querySelectorAll('input[name="delivery_area"]').forEach(option => {
                    option.addEventListener('change', updateDelivery);
                });

                // Run once on load to ensure correct value
                updateDelivery();

                // Form submission handler (if checkout form exists)
                const checkoutForm = document.getElementById('checkout-form');
                if (checkoutForm) {
                    checkoutForm.addEventListener('submit', function(e) {
                        const btn = document.getElementById('place-order-btn');
                        btn.disabled = true;
                        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
                    });
                }
            });
        </script>
    </x-slot>
</x-app-layout>
