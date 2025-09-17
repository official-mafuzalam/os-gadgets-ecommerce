<x-app-layout>
    <x-slot name="main">
        <!-- Hero Section with Dynamic Carousel -->
        @if ($carousels->isNotEmpty())
            <section class="relative overflow-hidden">
                <div class="hero-carousel" style="height: 600px;">
                    @foreach ($carousels as $index => $carousel)
                        <div
                            class="hero-slide {{ $index === 0 ? 'active' : '' }} bg-{{ $carousel->background_color }} text-white py-20">
                            <div class="container mx-auto px-4 flex flex-col md:flex-row items-center h-full">
                                <div class="md:w-1/2 flex flex-col justify-center">
                                    <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-4">{{ $carousel->title }}
                                    </h1>
                                    @if ($carousel->description)
                                        <p class="text-xl mb-8">{{ $carousel->description }}</p>
                                    @endif
                                    <div class="flex flex-wrap gap-4">
                                        @if ($carousel->button_text && $carousel->button_url)
                                            <a href="{{ $carousel->button_url }}"
                                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-6 rounded-lg transition duration-300 transform hover:-translate-y-1">
                                                {{ $carousel->button_text }}
                                            </a>
                                        @endif
                                        @if ($carousel->secondary_button_text && $carousel->secondary_button_url)
                                            <a href="{{ $carousel->secondary_button_url }}"
                                                class="bg-transparent hover:bg-white hover:text-indigo-600 text-white font-medium py-3 px-6 rounded-lg border-2 border-white transition duration-300 transform hover:-translate-y-1">
                                                {{ $carousel->secondary_button_text }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="md:w-1/2 mt-10 md:mt-0">
                                    <img src="{{ $carousel->image_url }}" alt="{{ $carousel->title }}"
                                        class="rounded-xl shadow-2xl transform hover:scale-105 transition duration-700 max-h-96 object-cover">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Carousel Indicators -->
                @if ($carousels->count() > 1)
                    <div class="absolute bottom-6 left-0 right-0 flex justify-center space-x-2">
                        @foreach ($carousels as $index => $carousel)
                            <button
                                class="carousel-dot w-3 h-3 rounded-full bg-white bg-opacity-40 {{ $index === 0 ? 'active' : '' }}"
                                data-slide="{{ $index }}"></button>
                        @endforeach
                    </div>

                    <!-- Navigation Arrows -->
                    <button
                        class="carousel-prev absolute left-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-20 hover:bg-opacity-30 text-white p-3 rounded-full">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button
                        class="carousel-next absolute right-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-20 hover:bg-opacity-30 text-white p-3 rounded-full">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                @endif
            </section>
        @endif

        <!-- Featured Categories -->
        @if ($categories->isNotEmpty())
            <section class="py-16 bg-white">
                <div class="container mx-auto px-4">
                    <div class="text-center max-w-2xl mx-auto mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Shop By Category</h2>
                        <p class="text-gray-600">Explore our wide range of tech categories to find exactly what you're
                            looking for</p>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                        @foreach ($categories as $item)
                            <a href="{{ route('public.categories.show', $item->slug) }}" class="group">
                                <div
                                    class="category-card bg-gray-50 rounded-xl p-6 text-center transition-all duration-300 hover:shadow-lg hover:border-indigo-500 border-2 border-transparent">
                                    <div
                                        class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-indigo-200 transition-colors">
                                        @if ($item->image === null)
                                            <i class="fas fa-th-large text-indigo-600 text-xl"></i>
                                        @else
                                            <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}"
                                                class="w-8 h-8 object-contain">
                                        @endif
                                    </div>
                                    <h3
                                        class="font-semibold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors">
                                        {{ $item->name }}</h3>
                                    <p class="text-gray-500 text-sm">{{ $item->products_count }} Products</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="text-center mt-10">
                        <a href="{{ route('public.categories') }}"
                            class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium">
                            Browse All Categories
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </section>
        @endif

        <!-- Featured Products -->
        @if ($featuredProducts->isNotEmpty())
            <section class="py-16 bg-gray-50">
                <div class="container mx-auto px-4">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-12">
                        <div class="mb-4 md:mb-0">
                            <h2 class="text-3xl font-bold text-gray-900">Featured Products</h2>
                            <p class="text-gray-600 mt-2">Handpicked selection of our best products</p>
                        </div>
                        <a href="{{ route('public.featured.products') }}"
                            class="flex items-center text-indigo-600 font-medium hover:text-indigo-800">
                            View All
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($featuredProducts as $product)
                            @include('public.products.partial.product-card', ['product' => $product])
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        @if ($deal)
            <section class="py-10 bg-white">
                <div class="container mx-auto px-4">
                    <div
                        class="bg-gradient-to-r from-[{{ $deal->background_from_color }}] to-[{{ $deal->background_to_color }}] rounded-2xl overflow-hidden shadow-xl">
                        <div class="flex flex-col md:flex-row items-center">
                            <div class="md:w-1/2 p-8 md:p-12 text-white">
                                <h2 class="text-2xl md:text-3xl font-bold mb-4">{{ $deal->title }}</h2>
                                <p class="text-indigo-100 mb-6">{{ $deal->description }}</p>
                                <div class="flex items-center mb-6">
                                    @if ($deal->discount_percentage)
                                        <div class="bg-white bg-opacity-20 rounded-lg px-4 py-2 mr-4">
                                            <span
                                                class="block text-2xl font-bold">{{ $deal->discount_percentage }}%</span>
                                            <span class="text-xs uppercase">OFF</span>
                                        </div>
                                    @endif
                                    <p class="text-sm">{{ $deal->discount_details }}</p>
                                </div>
                                <a href="{{ $deal->button_link }}"
                                    class="inline-flex items-center bg-white text-indigo-600 font-medium py-3 px-6 rounded-lg hover:bg-gray-100 transition-colors">
                                    {{ $deal->button_text }}
                                    <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                            <div class="md:w-1/2">
                                <img src="{{ $deal->image_url }}" alt="{{ $deal->title }}"
                                    class="w-full h-64 md:h-96 object-cover">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- All Products -->
        @if ($allProducts->isNotEmpty())
            <section class="py-16 bg-white">
                <div class="container mx-auto px-4">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-12">
                        <div class="mb-4 md:mb-0">
                            <h2 class="text-3xl font-bold text-gray-900">New Arrivals</h2>
                            <p class="text-gray-600 mt-2">Discover our latest products</p>
                        </div>
                        <a href="{{ route('public.products') }}"
                            class="flex items-center text-indigo-600 font-medium hover:text-indigo-800">
                            View All Products
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($allProducts as $product)
                            @include('public.products.partial.product-card', ['product' => $product])
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Features Section -->
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
                        <h3 class="font-semibold text-lg mb-2">Free Shipping</h3>
                        <p class="text-gray-600">On all orders over $50</p>
                    </div>
                    <div class="text-center p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                        <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-undo-alt text-indigo-600 text-2xl"></i>
                        </div>
                        <h3 class="font-semibold text-lg mb-2">Easy Returns</h3>
                        <p class="text-gray-600">30-day money back guarantee</p>
                    </div>
                    <div class="text-center p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                        <div
                            class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-headset text-indigo-600 text-2xl"></i>
                        </div>
                        <h3 class="font-semibold text-lg mb-2">24/7 Support</h3>
                        <p class="text-gray-600">Dedicated customer support</p>
                    </div>
                </div>
            </div>
        </section>

        <style>
            .hero-carousel {
                position: relative;
                overflow: hidden;
                height: 600px;
            }

            .hero-slide {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                opacity: 0;
                transition: opacity 1s ease-in-out;
                display: flex;
                align-items: center;
            }

            .hero-slide.active {
                opacity: 1;
                z-index: 1;
            }

            .carousel-dot.active {
                background-color: white !important;
            }

            .category-card:hover {
                transform: translateY(-5px);
            }

            @media (max-width: 768px) {
                .hero-carousel {
                    height: 500px;
                }
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const slides = document.querySelectorAll('.hero-slide');
                const dots = document.querySelectorAll('.carousel-dot');
                const prevButton = document.querySelector('.carousel-prev');
                const nextButton = document.querySelector('.carousel-next');

                let currentSlide = 0;
                let slideInterval;

                // Function to show a specific slide
                function showSlide(n) {
                    // Remove active class from all slides and dots
                    slides.forEach(slide => slide.classList.remove('active'));
                    dots.forEach(dot => dot.classList.remove('active'));

                    // Update current slide index
                    currentSlide = (n + slides.length) % slides.length;

                    // Add active class to current slide and dot
                    slides[currentSlide].classList.add('active');
                    dots[currentSlide].classList.add('active');
                }

                // Function to go to next slide
                function nextSlide() {
                    showSlide(currentSlide + 1);
                }

                // Function to go to previous slide
                function prevSlide() {
                    showSlide(currentSlide - 1);
                }

                // Start auto sliding
                function startSlideShow() {
                    slideInterval = setInterval(nextSlide, 5000);
                }

                // Stop auto sliding
                function stopSlideShow() {
                    clearInterval(slideInterval);
                }

                // Add event listeners to navigation buttons
                if (nextButton) {
                    nextButton.addEventListener('click', () => {
                        stopSlideShow();
                        nextSlide();
                        startSlideShow();
                    });
                }

                if (prevButton) {
                    prevButton.addEventListener('click', () => {
                        stopSlideShow();
                        prevSlide();
                        startSlideShow();
                    });
                }

                // Add event listeners to dots
                dots.forEach((dot, index) => {
                    dot.addEventListener('click', () => {
                        stopSlideShow();
                        showSlide(index);
                        startSlideShow();
                    });
                });

                // Pause slideshow when user hovers over carousel
                const carousel = document.querySelector('.hero-carousel');
                if (carousel) {
                    carousel.addEventListener('mouseenter', stopSlideShow);
                    carousel.addEventListener('mouseleave', startSlideShow);
                }

                // Initialize the carousel
                showSlide(0);
                startSlideShow();
            });
        </script>
    </x-slot>
</x-app-layout>
