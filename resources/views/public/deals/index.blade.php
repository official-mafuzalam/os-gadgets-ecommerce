<x-app-layout>
    <x-slot name="main">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Active Deals Banner -->
                @if ($activeDeals->count() > 0)
                    <div class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Current Offers</h2>
                        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                            @foreach ($activeDeals as $deal)
                                <div
                                    class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transition-transform duration-300 hover:scale-105">
                                    <div
                                        class="bg-gradient-to-r bg-{{ $deal->background_color }} p-6">
                                        <div class="text-center text-white">
                                            <h3 class="text-xl font-bold mb-2">{{ $deal->title }}</h3>
                                            <p class="text-white text-opacity-90 mb-4">{{ $deal->description }}</p>

                                            @if ($deal->discount_percentage)
                                                <div
                                                    class="bg-white bg-opacity-20 rounded-lg px-4 py-2 inline-block mb-4">
                                                    <span
                                                        class="block text-2xl font-bold">{{ $deal->discount_percentage }}%</span>
                                                    <span class="text-xs uppercase">OFF</span>
                                                </div>
                                            @endif

                                            <p class="text-sm mb-4">{{ $deal->discount_details }}</p>

                                            <a href="{{ $deal->button_link }}"
                                                class="inline-flex items-center bg-white text-gray-900 font-medium py-2 px-6 rounded-lg hover:bg-gray-100 transition-colors">
                                                {{ $deal->button_text }}
                                                <i class="fas fa-arrow-right ml-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <img src="{{ $deal->image_url }}" alt="{{ $deal->title }}"
                                            class="w-full h-48 object-cover rounded-lg">
                                    </div>
                                    @if ($deal->ends_at)
                                        <div class="px-4 pb-4">
                                            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-3 text-center">
                                                <p class="text-sm text-gray-600 dark:text-gray-300">Offer ends in</p>

                                                <div id="countdown-{{ $deal->id }}"
                                                    class="flex justify-center space-x-2 text-lg font-bold text-gray-900 dark:text-white">
                                                    <span class="days">00</span>d
                                                    <span class="hours">00</span>h
                                                    <span class="minutes">00</span>m
                                                    <span class="seconds">00</span>s
                                                </div>

                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                    ({{ $deal->ends_at->diffForHumans() }})
                                                </p>
                                            </div>
                                        </div>

                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                function startCountdown(id, endTime) {
                                                    const countdownEl = document.getElementById("countdown-" + id);
                                                    const daysEl = countdownEl.querySelector(".days");
                                                    const hoursEl = countdownEl.querySelector(".hours");
                                                    const minutesEl = countdownEl.querySelector(".minutes");
                                                    const secondsEl = countdownEl.querySelector(".seconds");

                                                    function updateCountdown() {
                                                        const now = new Date().getTime();
                                                        const distance = new Date(endTime).getTime() - now;

                                                        if (distance <= 0) {
                                                            countdownEl.innerHTML = "Expired";
                                                            clearInterval(interval);
                                                            return;
                                                        }

                                                        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                                        daysEl.textContent = String(days).padStart(2, "0");
                                                        hoursEl.textContent = String(hours).padStart(2, "0");
                                                        minutesEl.textContent = String(minutes).padStart(2, "0");
                                                        secondsEl.textContent = String(seconds).padStart(2, "0");
                                                    }

                                                    updateCountdown();
                                                    const interval = setInterval(updateCountdown, 1000);
                                                }

                                                // Init countdown for this deal
                                                startCountdown("{{ $deal->id }}", "{{ $deal->ends_at }}");
                                            });
                                        </script>
                                    @endif

                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Featured Products Section -->
                @if ($featuredProducts->count() > 0)
                    <div class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Featured Products</h2>
                        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                            @foreach ($featuredProducts as $product)
                                @include('public.products.partial.product-card', ['product' => $product])
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- All Products in Deals Section -->
                @if ($allDealProducts->count() > 0)
                    <div class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">All Products on Sale</h2>
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Product</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Price</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Discount</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Stock</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach ($allDealProducts as $product)
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            <img class="h-10 w-10 rounded object-cover"
                                                                src="{{ $product->images->where('is_primary', true)->first() ? Storage::url($product->images->where('is_primary', true)->first()->image_path) : 'https://via.placeholder.com/40' }}"
                                                                alt="{{ $product->name }}">
                                                        </div>

                                                        <div class="ml-4">
                                                            <div
                                                                class="text-sm font-medium text-gray-900 dark:text-white">
                                                                {{ $product->name }}
                                                            </div>
                                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                                SKU: {{ $product->sku ?? 'N/A' }}
                                                            </div>
                                                        </div>

                                                        @if ($product->discount > 0 && $product->price > 0)
                                                            <span
                                                                class="ml-4 inline-block bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded-full dark:bg-red-800 dark:text-red-100">
                                                                {{ number_format(($product->discount / $product->price) * 100) }}%
                                                                OFF
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex flex-col">
                                                        @if ($product->discount)
                                                            <span class="font-semibold text-green-600">
                                                                {{ number_format($product->price - $product->discount) }}
                                                                TK
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
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if ($product->discount)
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                            {{ number_format($product->discount) }}TK OFF
                                                        </span>
                                                    @else
                                                        <span class="text-sm text-gray-500">No discount</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span @class([
                                                        'inline-flex px-2 py-1 rounded-md text-xs font-medium',
                                                        'bg-green-500/10 text-green-600 dark:text-green-400' =>
                                                            $product->stock_quantity > 10,
                                                        'bg-yellow-500/10 text-yellow-600 dark:text-yellow-400' =>
                                                            $product->stock_quantity > 0 && $product->stock_quantity <= 10,
                                                        'bg-red-500/10 text-red-600 dark:text-red-400' =>
                                                            $product->stock_quantity == 0,
                                                    ])>
                                                        {{ $product->stock_quantity }} in stock
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <div class="flex items-center space-x-2">
                                                        <a href="{{ route('public.products.show', $product->slug) }}"
                                                            class="bg-green-600 hover:bg-green-700 text-white p-2 rounded text-sm flex items-center justify-center transition-colors">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <form action="{{ route('cart.add', $product) }}" method="POST"
                                                            class="flex-1">
                                                            @csrf
                                                            <input type="hidden" name="quantity" value="1">
                                                            <button type="submit"
                                                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-2 rounded transition duration-300 text-xs flex items-center justify-center">
                                                                <i class="fas fa-shopping-cart mr-1"></i> Add to Cart
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if ($allDealProducts->hasPages())
                                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700">
                                    {{ $allDealProducts->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- No Deals Message -->
                @if ($activeDeals->count() == 0 && $featuredProducts->count() == 0 && $allDealProducts->count() == 0)
                    <div class="text-center py-12">
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
                            <i class="fas fa-tag text-4xl text-gray-400 mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No Current Deals</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">Check back later for amazing offers and
                                discounts!</p>
                            <a href="{{ route('public.products') }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 transition-colors">
                                Browse All Products
                                <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </x-slot>
</x-app-layout>
