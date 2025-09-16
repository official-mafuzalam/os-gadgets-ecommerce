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
        @if ($categories->isNotEmpty())
            <section class="py-16 bg-white">
                <div class="container mx-auto px-4">
                    <h2 class="text-3xl font-bold text-center mb-12">Shop By Category</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        @foreach ($categories as $item)
                            <a href="{{ route('public.categories.show', $item->slug) }}"
                                class="category-card bg-gray-100 rounded-lg p-6 text-center transition duration-300">
                                <div
                                    class="bg-indigo-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                                    @if ($item->image === null)
                                        <i class="fas fa-th-large text-indigo-600 text-2xl"></i>
                                    @else
                                        <img src="{{ $item->image }}" alt="{{ $item->name }}"
                                            class="w-10 h-10 object-contain">
                                    @endif
                                </div>
                                <h3 class="font-semibold text-lg mb-2">{{ $item->name }}</h3>
                                <p class="text-gray-600 text-sm">{{ $item->products_count }} Products</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Featured Products -->
        @if ($featuredProducts->isNotEmpty())
            <section class="py-16 bg-gray-50">
                <div class="container mx-auto px-4">
                    <div class="flex justify-between items-center mb-12">
                        <h2 class="text-3xl font-bold">Featured Products</h2>
                        <a href="{{ route('public.featured.products') }}"
                            class="text-indigo-600 font-medium hover:text-indigo-800">View All <i
                                class="fas fa-arrow-right ml-2"></i></a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        @forelse ($featuredProducts as $product)
                            @include('public.products.partial.product-card', ['product' => $product])
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
        @endif

        <!-- All Products -->
        @if ($allProducts->isNotEmpty())
            <section class="py-16 bg-gray-50">
                <div class="container mx-auto px-4">
                    <div class="flex justify-between items-center mb-12">
                        <h2 class="text-3xl font-bold">All Products</h2>
                        <a href="{{ route('public.products') }}"
                            class="text-indigo-600 font-medium hover:text-indigo-800">View All <i
                                class="fas fa-arrow-right ml-2"></i></a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        @forelse ($allProducts as $product)
                            @include('public.products.partial.product-card', ['product' => $product])
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
        @endif

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

    </x-slot>
</x-app-layout>
