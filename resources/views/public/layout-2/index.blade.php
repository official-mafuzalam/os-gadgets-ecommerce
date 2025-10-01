<x-app-layout>
    <x-slot name="main">
        @php
            $layoutSetting = setting('default_layout_type', 'layout2'); // default to layout2
        @endphp

        {{-- @if ($layoutSetting === 'layout2') --}}
            <!-- Hero Section with Carousel and Side Deals -->
            <section class="container mx-auto px-4 md:px-6 mt-6">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

                    <!-- Left Side Deals -->
                    <div class="hidden lg:flex flex-col space-y-4">
                        @foreach ($leftDeals as $deal)
                            @include('public.partials.deal-card', ['deal' => $deal])
                        @endforeach
                    </div>

                    <!-- Center Carousel -->
                    <div class="col-span-1 lg:col-span-2">
                        @include('public.partials.carousel', ['carousels' => $carousels])
                    </div>

                    <!-- Right Side Deals -->
                    <div class="hidden lg:flex flex-col space-y-4">
                        @foreach ($rightDeals as $deal)
                            @include('public.partials.deal-card', ['deal' => $deal])
                        @endforeach
                    </div>
                </div>
            </section>

            <!-- Highlighted Deals Banner -->
            @if ($bottomDeals)
                <section class="container mx-auto px-4 md:px-6 mt-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach ($bottomDeals as $item)
                            @include('public.partials.deal-banner', ['deal' => $item])
                        @endforeach
                    </div>
                </section>
            @endif

            <!-- Shop By Category Section -->
            @if ($categories->isNotEmpty())
                <section class="py-12 bg-gray-50">
                    <div class="container mx-auto px-4">
                        <div class="text-center mb-10">
                            <h2 class="text-3xl font-bold text-gray-900">Browse Categories</h2>
                            <p class="text-gray-600 mt-2">Find products by category</p>
                        </div>
                        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-4">
                            @foreach ($categories as $item)
                                <a href="{{ route('public.categories.show', $item->slug) }}"
                                    class="group block bg-white rounded-xl p-4 text-center border hover:shadow-lg transition">
                                    <div
                                        class="w-16 h-16 mx-auto mb-3 rounded-full overflow-hidden border-2 border-indigo-100 group-hover:border-indigo-300">
                                        @if ($item->image === null)
                                            <div class="w-full h-full flex items-center justify-center bg-indigo-50">
                                                <i class="fas fa-th-large text-indigo-600 text-lg"></i>
                                            </div>
                                        @else
                                            <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}"
                                                class="w-full h-full object-cover group-hover:scale-110 transition">
                                        @endif
                                    </div>
                                    <h3 class="text-sm font-medium text-gray-900 group-hover:text-indigo-600">
                                        {{ $item->name }}
                                    </h3>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif

            <!-- Featured Products Slider -->
            @if ($featuredProducts->isNotEmpty())
                <section class="py-16 bg-white">
                    <div class="container mx-auto px-4">
                        <div class="flex justify-between items-center mb-8">
                            <h2 class="text-2xl font-bold text-gray-900">Featured Products</h2>
                            <a href="{{ route('public.featured.products') }}"
                                class="text-indigo-600 hover:text-indigo-800 font-medium">
                                View All <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                            @foreach ($featuredProducts as $product)
                                @include('public.products.partial.product-card', ['product' => $product])
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif

            <!-- Promotional Deal Banner -->
            @if ($deal)
                <section class="py-10 bg-gray-50">
                    <div class="container mx-auto px-4">
                        @include('public.partials.deal-banner', ['deal' => $deal])
                    </div>
                </section>
            @endif

            <!-- New Arrivals -->
            @if ($allProducts->isNotEmpty())
                <section class="py-16 bg-white">
                    <div class="container mx-auto px-4">
                        <div class="flex justify-between items-center mb-8">
                            <h2 class="text-2xl font-bold text-gray-900">New Arrivals</h2>
                            <a href="{{ route('public.featured.products') }}"
                                class="text-indigo-600 hover:text-indigo-800 font-medium">
                                View All <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                            @foreach ($allProducts as $product)
                                @include('public.products.partial.product-card', ['product' => $product])
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif

            <!-- Why Choose Us -->
            <section class="py-16 bg-gray-50">
                <div class="container mx-auto px-4">
                    <div class="text-center max-w-2xl mx-auto mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Why Choose Us</h2>
                        <p class="text-gray-600">Your trusted online shopping destination</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="text-center p-6 bg-white rounded-xl shadow hover:shadow-md transition">
                            <div
                                class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-truck text-indigo-600 text-2xl"></i>
                            </div>
                            <h3 class="font-semibold text-lg mb-2">Fast Delivery</h3>
                            <p class="text-gray-600">Get your products quickly</p>
                        </div>
                        <div class="text-center p-6 bg-white rounded-xl shadow hover:shadow-md transition">
                            <div
                                class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-sync text-indigo-600 text-2xl"></i>
                            </div>
                            <h3 class="font-semibold text-lg mb-2">Easy Returns</h3>
                            <p class="text-gray-600">Hassle-free returns within 30 days</p>
                        </div>
                        <div class="text-center p-6 bg-white rounded-xl shadow hover:shadow-md transition">
                            <div
                                class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-headset text-indigo-600 text-2xl"></i>
                            </div>
                            <h3 class="font-semibold text-lg mb-2">24/7 Support</h3>
                            <p class="text-gray-600">We’re here to help anytime</p>
                        </div>
                    </div>
                </div>
            </section>
        {{-- @endif --}}
    </x-slot>
</x-app-layout>
