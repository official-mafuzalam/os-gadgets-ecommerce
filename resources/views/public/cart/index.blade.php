<x-app-layout>
    <x-slot name="main">
        <!-- Breadcrumb -->
        <div class="bg-gray-100 py-4">
            <div class="container mx-auto px-4">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('public.welcome') }}" class="text-sm text-gray-700 hover:text-indigo-600">
                                <i class="fas fa-home mr-1"></i>
                                Home
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                                <span class="ml-3 text-sm font-medium text-gray-500">Shopping Cart</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Cart Section -->
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-8">Shopping Cart</h1>

            @if (\Cart::count() > 0)
                <div class="lg:grid lg:grid-cols-12 lg:gap-x-12">
                    <!-- Cart Items -->
                    <div class="lg:col-span-8">
                        <div class="bg-white rounded-lg shadow-md">
                            <div class="p-6 border-b border-gray-200">
                                <h2 class="text-lg font-semibold text-gray-900">{{ \Cart::count() }} items in cart</h2>
                            </div>

                            <div class="divide-y divide-gray-200">
                                @foreach ($cartItems as $item)
                                    <div class="p-6 flex items-center" id="cart-item-{{ $item->rowId }}">
                                        <div class="flex-shrink-0 w-20 h-20">
                                            <img src="{{ $item->options->image ? Storage::url($item->options->image) : 'https://via.placeholder.com/80' }}"
                                                alt="{{ $item->name }}" class="w-full h-full object-cover rounded">
                                        </div>

                                        <div class="ml-6 flex-1">
                                            <div class="flex items-start justify-between">
                                                <div>
                                                    <h3 class="text-lg font-medium text-gray-900">
                                                        <a
                                                            href="{{ route('public.products.show', $item->options->slug) }}">{{ $item->name }}</a>
                                                    </h3>
                                                    <p class="text-sm text-gray-500">SKU: {{ $item->options->sku }}</p>
                                                    <p class="text-sm text-gray-500">Stock: {{ $item->options->stock }}
                                                    </p>
                                                </div>
                                                <p class="text-lg font-semibold text-gray-900">
                                                    {{ number_format($item->price) }} TK</p>
                                            </div>

                                            <div class="mt-4 flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <label class="sr-only">Quantity</label>
                                                    <div class="flex items-center border border-gray-300 rounded">
                                                        <button type="button"
                                                            onclick="updateQuantity('{{ $item->rowId }}', {{ $item->qty - 1 }})"
                                                            class="px-3 py-1 text-gray-600 hover:text-gray-800 {{ $item->qty <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}">
                                                            -
                                                        </button>
                                                        <input type="number" id="quantity-{{ $item->rowId }}"
                                                            value="{{ $item->qty }}" min="1"
                                                            max="{{ $item->options->stock }}"
                                                            class="w-12 text-center border-0 focus:ring-0"
                                                            onchange="updateQuantity('{{ $item->rowId }}', this.value)">
                                                        <button type="button"
                                                            onclick="updateQuantity('{{ $item->rowId }}', {{ $item->qty + 1 }})"
                                                            class="px-3 py-1 text-gray-600 hover:text-gray-800 {{ $item->qty >= $item->options->stock ? 'opacity-50 cursor-not-allowed' : '' }}">
                                                            +
                                                        </button>
                                                    </div>
                                                </div>

                                                <button onclick="removeItem('{{ $item->rowId }}')"
                                                    class="text-red-600 hover:text-red-800 text-sm font-medium">
                                                    <i class="fas fa-trash mr-1"></i> Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-6">
                            <button onclick="clearCart()" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                <i class="fas fa-trash mr-1"></i> Clear Cart
                            </button>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-4 mt-8 lg:mt-0">
                        <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h2>

                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="text-gray-900">{{ $subtotal }} TK</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Shipping</span>
                                    <span class="text-gray-900">Calculated at checkout</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tax</span>
                                    <span class="text-gray-900">{{ $tax }} TK</span>
                                </div>
                                <div class="border-t border-gray-200 pt-2 mt-2">
                                    <div class="flex justify-between text-lg font-semibold">
                                        <span class="text-gray-900">Total</span>
                                        <span class="text-gray-900">{{ $total }} TK</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6">
                                <a href="{{ route('public.checkout') }}"
                                    class="w-full bg-indigo-600 text-white py-3 px-4 rounded-md text-center font-medium hover:bg-indigo-700 transition-colors">
                                    Proceed to Checkout
                                </a>
                            </div>

                            <div class="mt-4 text-center">
                                <a href="{{ route('public.products') }}"
                                    class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                                    Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <i class="fas fa-shopping-cart text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Your cart is empty</h3>
                    <p class="text-gray-600 mb-6">Start shopping to add items to your cart</p>
                    <a href="{{ route('public.products') }}"
                        class="bg-indigo-600 text-white px-6 py-3 rounded-md font-medium hover:bg-indigo-700">
                        Browse Products
                    </a>
                </div>
            @endif
        </div>

        <script>
            function updateQuantity(rowId, quantity) {
                if (quantity < 1) quantity = 1;

                fetch(`/cart/update/${rowId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            quantity: parseInt(quantity)
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update cart count in navigation
                            document.querySelectorAll('.cart-count').forEach(el => {
                                el.textContent = data.cart_count;
                                el.style.display = data.cart_count > 0 ? 'flex' : 'none';
                            });

                            // Reload the page to reflect changes
                            window.location.reload();
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error updating quantity');
                    });
            }

            function removeItem(rowId) {
                if (!confirm('Are you sure you want to remove this item?')) return;

                fetch(`/cart/remove/${rowId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Remove item from DOM
                            document.getElementById(`cart-item-${rowId}`).remove();

                            // Update cart count
                            document.querySelectorAll('.cart-count').forEach(el => {
                                el.textContent = data.cart_count;
                                el.style.display = data.cart_count > 0 ? 'flex' : 'none';
                            });

                            // Update totals
                            if (data.cart_count === 0) {
                                window.location.reload();
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error removing item');
                    });
            }

            function clearCart() {
                if (!confirm('Are you sure you want to clear your cart?')) return;

                fetch('/cart/clear', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error clearing cart');
                    });
            }
        </script>
    </x-slot>
</x-app-layout>
