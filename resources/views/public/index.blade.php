<x-app-layout>
    <x-slot name="main">
        <!-- Hero Section -->
        <section class="hero-bg text-white py-20">
            <div class="container mx-auto px-4 flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 flex flex-col justify-center">
                    <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-4">Cutting-Edge Tech Gadgets for Modern
                        Life
                    </h1>
                    <p class="text-xl mb-8">Discover the latest electronics and tech accessories with exclusive deals.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-6 rounded-lg transition duration-300">Shop
                            Now</a>
                        <a href="#"
                            class="bg-transparent hover:bg-white hover:text-indigo-600 text-white font-medium py-3 px-6 rounded-lg border-2 border-white transition duration-300">View
                            Deals</a>
                    </div>
                </div>
                <div class="md:w-1/2 mt-10 md:mt-0">
                    <img src="https://images.unsplash.com/photo-1550009158-9ebf69173e03?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1201&q=80"
                        alt="Latest Gadgets" class="rounded-lg shadow-xl">
                </div>
            </div>
        </section>

        <!-- Featured Categories -->
        <section class="py-16 bg-white">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center mb-12">Shop By Category</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="category-card bg-gray-100 rounded-lg p-6 text-center transition duration-300">
                        <div class="bg-indigo-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-mobile-alt text-indigo-600 text-3xl"></i>
                        </div>
                        <h3 class="font-semibold text-lg mb-2">Smartphones</h3>
                        <p class="text-gray-600 text-sm">Latest models & accessories</p>
                    </div>

                    <div class="category-card bg-gray-100 rounded-lg p-6 text-center transition duration-300">
                        <div class="bg-indigo-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-laptop text-indigo-600 text-3xl"></i>
                        </div>
                        <h3 class="font-semibold text-lg mb-2">Laptops</h3>
                        <p class="text-gray-600 text-sm">Powerful computing devices</p>
                    </div>

                    <div class="category-card bg-gray-100 rounded-lg p-6 text-center transition duration-300">
                        <div class="bg-indigo-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-headphones text-indigo-600 text-3xl"></i>
                        </div>
                        <h3 class="font-semibold text-lg mb-2">Audio</h3>
                        <p class="text-gray-600 text-sm">Headphones & speakers</p>
                    </div>

                    <div class="category-card bg-gray-100 rounded-lg p-6 text-center transition duration-300">
                        <div class="bg-indigo-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-clock text-indigo-600 text-3xl"></i>
                        </div>
                        <h3 class="font-semibold text-lg mb-2">Wearables</h3>
                        <p class="text-gray-600 text-sm">Smartwatches & trackers</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Products -->
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center mb-12">
                    <h2 class="text-3xl font-bold">Featured Products</h2>
                    <a href="#" class="text-indigo-600 font-medium hover:text-indigo-800">View All <i
                            class="fas fa-arrow-right ml-2"></i></a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @forelse ($featuredProducts as $item)
                        <div class="product-card bg-white rounded-lg overflow-hidden shadow-md">
                            <a href="{{ route('public.products.show', $item->slug) }}" class="block">
                                <div class="relative">
                                    <img src="{{ $item->images->where('is_primary', true)->first() ? Storage::url($item->images->where('is_primary', true)->first()->image_path) : 'https://via.placeholder.com/40' }}"
                                        alt="{{ $item->name }}" class="w-full h-56 object-cover">
                                    @if ($item->created_at->gt(now()->subDays(30)))
                                        <div
                                            class="absolute top-0 right-0 bg-indigo-600 text-white text-xs font-bold px-2 py-1 m-2 rounded-full">
                                            NEW
                                        </div>
                                    @endif
                                    @if ($item->discount > 0)
                                        <div
                                            class="absolute top-0 left-0 bg-red-600 text-white text-xs font-bold px-2 py-1 m-2 rounded-full">
                                            {{ number_format(($item->discount / $item->price) * 100) }}% OFF
                                        </div>
                                    @endif
                                </div>
                            </a>
                            <div class="p-4">
                                <a href="{{ route('public.products.show', $item->slug) }}" class="block mb-2">
                                    <h3 class="font-semibold text-lg hover:text-indigo-600 transition-colors line-clamp-2"
                                        title="{{ $item->name }}">
                                        {{ $item->name }}
                                    </h3>
                                </a>
                                <div class="flex items-center mb-2">
                                    <div class="flex text-yellow-400">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= floor($item->average_rating))
                                                <i class="fas fa-star"></i>
                                            @elseif($i - 0.5 <= $item->average_rating)
                                                <i class="fas fa-star-half-alt"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span
                                        class="text-gray-600 text-sm ml-2">({{ number_format($item->average_rating, 1) }})</span>
                                </div>

                                <div class="mb-3">
                                    @if ($item->discount > 0)
                                        <div class="flex items-center space-x-2">
                                            <span
                                                class="text-2xl font-bold text-gray-900">{{ number_format($item->final_price) }}
                                                TK</span>
                                            <span
                                                class="text-sm text-gray-500 line-through">{{ number_format($item->price) }}
                                                TK</span>
                                        </div>
                                    @else
                                        <span
                                            class="text-2xl font-bold text-gray-900">{{ number_format($item->price) }}
                                            TK</span>
                                    @endif
                                </div>

                                <!-- Buttons -->
                                <div class="flex space-x-2">
                                    <form action="{{ route('cart.add', $item) }}" method="POST" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit"
                                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-2 rounded transition duration-300 text-xs flex items-center justify-center">
                                            <i class="fas fa-shopping-cart mr-1"></i> Add to Cart
                                        </button>
                                    </form>
                                    <a href="{{ route('public.products.buy-now', $item) }}"
                                        class="bg-green-600 hover:bg-green-700 text-white py-2 px-3 rounded transition duration-300 text-xs flex items-center justify-center">
                                        Buy Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-4 text-center py-8">
                            <i class="fas fa-box-open text-4xl text-gray-300 mb-4"></i>
                            <p class="text-gray-600 text-lg">No featured products available at the moment.</p>
                            <p class="text-gray-500">Please check back later for new arrivals.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Special Offer -->
        <section class="py-16 bg-indigo-600 text-white">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-3xl font-bold mb-4">Summer Sale - Up to 30% Off</h2>
                <p class="text-xl mb-8 max-w-2xl mx-auto">Don't miss our exclusive summer promotion on selected gadgets
                    and
                    electronics. Limited time offer!</p>
                <div class="flex justify-center space-x-4">
                    <a href="#"
                        class="bg-white text-indigo-600 hover:bg-gray-100 font-medium py-3 px-8 rounded-lg transition duration-300">Shop
                        Now</a>
                    <a href="#"
                        class="bg-transparent hover:bg-indigo-700 text-white font-medium py-3 px-8 rounded-lg border-2 border-white transition duration-300">Learn
                        More</a>
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section class="py-16 bg-white">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center mb-12">What Our Customers Say</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                        <div class="flex text-yellow-400 mb-4">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="text-gray-600 mb-4">"TechSphere has the best prices and fastest shipping. My new
                            laptop
                            arrived sooner than expected and was perfectly packaged."</p>
                        <div class="flex items-center">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800&q=80"
                                alt="Customer" class="w-12 h-12 rounded-full object-cover">
                            <div class="ml-4">
                                <h4 class="font-semibold">Michael Chen</h4>
                                <p class="text-gray-500 text-sm">Verified Customer</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                        <div class="flex text-yellow-400 mb-4">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="text-gray-600 mb-4">"I've been shopping with TechSphere for over a year now and they
                            never disappoint. Great products and excellent customer service."</p>
                        <div class="flex items-center">
                            <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800&q=80"
                                alt="Customer" class="w-12 h-12 rounded-full object-cover">
                            <div class="ml-4">
                                <h4 class="font-semibold">Sarah Johnson</h4>
                                <p class="text-gray-500 text-sm">Verified Customer</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                        <div class="flex text-yellow-400 mb-4">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <p class="text-gray-600 mb-4">"The product descriptions are accurate and the website is easy to
                            navigate. Found exactly what I was looking for in minutes."</p>
                        <div class="flex items-center">
                            <img src="https://images.unsplash.com/photo-1552058544-f2b08422138a?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800&q=80"
                                alt="Customer" class="w-12 h-12 rounded-full object-cover">
                            <div class="ml-4">
                                <h4 class="font-semibold">James Wilson</h4>
                                <p class="text-gray-500 text-sm">Verified Customer</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </x-slot>
</x-app-layout>
