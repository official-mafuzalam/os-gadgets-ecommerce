<x-app-layout>
    <x-slot name="main">

        <section class="container mx-auto px-3 md:px-4 mt-4 md:mt-6">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 md:gap-6">

                <div class="hidden lg:flex flex-col space-y-4 md:space-y-6 col-span-1">
                    @foreach ($leftDeals as $deal)
                        @include('public.partials.deal-card', ['deal' => $deal])
                    @endforeach
                </div>

                <div class="col-span-1 lg:col-span-2">
                    @include('public.partials.carousel', ['carousels' => $carousels])

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6 mt-4 md:mt-6 justify-items-center">
                        @foreach ($bottomDeals as $deal)
                            <div class="w-full max-w-sm">
                                @include('public.partials.deal-card', ['deal' => $deal])
                            </div>
                        @endforeach
                    </div>

                </div>

                <div class="hidden lg:flex flex-col space-y-4 md:space-y-6 col-span-1">
                    @foreach ($rightDeals as $deal)
                        @include('public.partials.deal-card', ['deal' => $deal])
                    @endforeach
                </div>

            </div>
        </section>


        @if ($categories->isNotEmpty())
            <section class="py-10 bg-white">
                <div class="container mx-auto px-4">
                    <div class="text-center max-w-2xl mx-auto mb-6">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Shop By Category</h2>
                        <p class="text-gray-600">Explore our wide range of tech categories to find exactly what you're
                            looking for</p>
                    </div>
                    <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-9 gap-2">
                        @foreach ($categories as $item)
                            <a href="{{ route('public.categories.show', $item->slug) }}" class="group block">
                                <div
                                    class="category-card bg-white rounded-2xl p-2 text-center transition-all duration-300 hover:shadow-xl hover:border-indigo-500 border border-gray-200">

                                    {{-- Category Image --}}
                                    <div
                                        class="w-20 h-20 mx-auto mb-3 rounded-full overflow-hidden border-2 border-indigo-100 group-hover:border-indigo-300 transition-all duration-300">
                                        @if ($item->image === null)
                                            <div class="w-full h-full flex items-center justify-center bg-indigo-50">
                                                <i class="fas fa-th-large text-indigo-600 text-2xl"></i>
                                            </div>
                                        @else
                                            <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}"
                                                class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300">
                                        @endif
                                    </div>

                                    {{-- Category Name --}}
                                    <h3
                                        class="font-medium text-gray-900 text-sm group-hover:text-indigo-600 transition-colors">
                                        {{ $item->name }}
                                    </h3>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="text-center mt-6">
                        <a href="{{ route('public.categories') }}"
                            class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium">
                            Browse All Categories
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </section>
        @endif

        @if ($featuredProducts->isNotEmpty())
            <section class="py-16 bg-gray-50">
                <div class="container mx-auto px-4">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-12">
                        <div class="mb-4 md:mb-0 text-center md:text-left">
                            <h2 class="text-3xl font-bold text-gray-900">Featured Products</h2>
                            <p class="text-gray-600 mt-2">Handpicked selection of our best products</p>
                        </div>
                        <a href="{{ route('public.featured.products') }}"
                            class="flex items-center text-indigo-600 font-semibold hover:text-indigo-800 transition-colors">
                            View All
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-2">
                        @foreach ($featuredProducts as $product)
                            @include('public.products.partial.product-card', ['product' => $product])
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        @if ($deal)
            @include('public.partials.deal-banner', ['deal' => $deal])
        @endif

        @if ($allProducts->isNotEmpty())
            <section class="py-16 bg-gray-50">
                <div class="container mx-auto px-4">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-12">
                        <div class="mb-4 md:mb-0 text-center md:text-left">
                            <h2 class="text-3xl font-bold text-gray-900">New Arrivals</h2>
                            <p class="text-gray-600 mt-2">Discover our latest products</p>
                        </div>
                        <a href="{{ route('public.featured.products') }}"
                            class="flex items-center text-indigo-600 font-semibold hover:text-indigo-800 transition-colors">
                            View All
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-2">
                        @foreach ($featuredProducts as $product)
                            @include('public.products.partial.product-card', ['product' => $product])
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="text-center max-w-2xl mx-auto mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Why Shop With Us</h2>
                    <p class="text-gray-600">We provide the best shopping experience for tech enthusiasts</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                        <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-shipping-fast text-indigo-600 text-2xl"></i>
                        </div>
                        <h3 class="font-semibold text-lg mb-2">Fast Shipping</h3>
                        <p class="text-gray-600">Delivery within 3-5 business days</p>
                    </div>
                    <div class="text-center p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                        <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-undo-alt text-indigo-600 text-2xl"></i>
                        </div>
                        <h3 class="font-semibold text-lg mb-2">Easy Returns</h3>
                        <p class="text-gray-600">30-day money back guarantee</p>
                    </div>
                    <div class="text-center p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                        <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-headset text-indigo-600 text-2xl"></i>
                        </div>
                        <h3 class="font-semibold text-lg mb-2">24/7 Support</h3>
                        <p class="text-gray-600">Dedicated customer support</p>
                    </div>
                </div>
            </div>
        </section>

    </x-slot>
</x-app-layout>
