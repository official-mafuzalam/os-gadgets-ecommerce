<div class="col-span-2">
    <section class="relative overflow-hidden rounded-xl">
        <div class="hero-carousel h-64 md:h-80 lg:h-96">
            @foreach ($carousels as $index => $carousel)
                <div
                    class="hero-slide {{ $index === 0 ? 'active' : '' }} bg-{{ $carousel->background_color }} text-white">
                    <div class="container mx-auto px-4 flex flex-col md:flex-row items-center h-full py-6 md:py-0">
                        <div
                            class="md:w-1/2 flex flex-col justify-center order-2 md:order-1 text-center md:text-left mt-4 md:mt-0">
                            <h3 class="text-xl md:text-2xl lg:text-3xl font-bold leading-tight mb-2 md:mb-4">
                                {{ $carousel->title }}</h3>
                            @if ($carousel->description)
                                <p class="text-sm md:text-base mb-4 md:mb-6 line-clamp-2">{{ $carousel->description }}
                                </p>
                            @endif

                            <div class="flex flex-wrap gap-2 md:gap-4 justify-center md:justify-start">
                                @if ($carousel->button_text && $carousel->button_url)
                                    <a href="{{ $carousel->button_url }}"
                                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 md:py-3 md:px-6 rounded-lg transition duration-300 text-sm md:text-base">
                                        {{ $carousel->button_text }}
                                    </a>
                                @endif

                                @if ($carousel->secondary_button_text && $carousel->secondary_button_url)
                                    <a href="{{ $carousel->secondary_button_url }}"
                                        class="bg-transparent hover:bg-white hover:text-indigo-600 text-white font-medium py-2 px-4 md:py-3 md:px-6 rounded-lg border border-white md:border-2 transition duration-300 text-sm md:text-base">
                                        {{ $carousel->secondary_button_text }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="md:w-1/2 order-1 md:order-2">
                            <img src="{{ $carousel->image_url }}" alt="{{ $carousel->title }}"
                                class="rounded-xl shadow-lg md:shadow-2xl max-h-40 md:max-h-64 lg:max-h-80 object-contain mx-auto">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Indicators --}}
        @if ($carousels->count() > 1)
            <div class="absolute bottom-2 md:bottom-4 left-0 right-0 flex justify-center space-x-2">
                @foreach ($carousels as $index => $carousel)
                    <button
                        class="carousel-dot w-2 h-2 md:w-3 md:h-3 rounded-full bg-white bg-opacity-40 {{ $index === 0 ? 'active' : '' }}"
                        data-slide="{{ $index }}"></button>
                @endforeach
            </div>

            {{-- Navigation Arrows --}}
            <button
                class="carousel-prev absolute left-1 md:left-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-60 hover:bg-opacity-80 text-gray-800 p-2 md:p-3 rounded-full shadow-lg">
                <i class="fas fa-chevron-left text-xs md:text-base"></i>
            </button>
            <button
                class="carousel-next absolute right-1 md:right-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-60 hover:bg-opacity-80 text-gray-800 p-2 md:p-3 rounded-full shadow-lg">
                <i class="fas fa-chevron-right text-xs md:text-base"></i>
            </button>
        @endif
    </section>
</div>

@push('styles')
    <style>
        /* ===== Hero Carousel Base ===== */
        .hero-carousel {
            position: relative;
            overflow: hidden;
            height: 320px;
            /* Reduced for mobile */
        }

        .hero-slide {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 0.8s ease-in-out;
            /* Slightly faster transition */
            display: flex;
            align-items: center;
        }

        .hero-slide.active {
            opacity: 1;
            z-index: 1;
        }

        .hero-slide img {
            height: 100%;
            max-height: 280px;
            /* Reduced for mobile */
            object-fit: contain;
        }

        /* ===== Indicators ===== */
        .carousel-dot.active {
            background-color: white !important;
        }

        /* ===== Responsive ===== */
        @media (min-width: 768px) {
            .hero-carousel {
                height: 380px;
                /* Medium screens */
            }

            .hero-slide img {
                max-height: 340px;
                /* Medium screens */
            }
        }

        @media (min-width: 1024px) {
            .hero-carousel {
                height: 420px;
                /* Large screens */
            }

            .hero-slide img {
                max-height: 400px;
                /* Large screens */
            }
        }

        /* Mobile-specific adjustments */
        @media (max-width: 640px) {
            .hero-carousel {
                height: 280px;
                /* Even smaller for very small screens */
            }

            .hero-slide img {
                max-height: 180px;
                /* Even smaller for very small screens */
            }

            .carousel-prev,
            .carousel-next {
                display: none;
                /* Hide arrows on very small screens */
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('.hero-slide');
            if (slides.length <= 0) return;

            const dots = document.querySelectorAll('.carousel-dot');
            const prevButton = document.querySelector('.carousel-prev');
            const nextButton = document.querySelector('.carousel-next');

            let currentSlide = 0;
            let slideInterval;

            function showSlide(n) {
                slides.forEach(slide => slide.classList.remove('active'));
                dots.forEach(dot => dot.classList.remove('active'));
                currentSlide = (n + slides.length) % slides.length;
                slides[currentSlide].classList.add('active');
                if (dots[currentSlide]) {
                    dots[currentSlide].classList.add('active');
                }
            }

            function nextSlide() {
                showSlide(currentSlide + 1);
            }

            function prevSlide() {
                showSlide(currentSlide - 1);
            }

            function startSlideShow() {
                // Only start if more than one slide
                if (slides.length > 1) {
                    slideInterval = setInterval(nextSlide, 5000);
                }
            }

            function stopSlideShow() {
                clearInterval(slideInterval);
            }

            // Only add event listeners if elements exist
            if (nextButton && slides.length > 1) {
                nextButton.addEventListener('click', () => {
                    stopSlideShow();
                    nextSlide();
                    startSlideShow();
                });
            }

            if (prevButton && slides.length > 1) {
                prevButton.addEventListener('click', () => {
                    stopSlideShow();
                    prevSlide();
                    startSlideShow();
                });
            }

            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    stopSlideShow();
                    showSlide(index);
                    startSlideShow();
                });
            });

            const carousel = document.querySelector('.hero-carousel');
            if (carousel && slides.length > 1) {
                carousel.addEventListener('mouseenter', stopSlideShow);
                carousel.addEventListener('mouseleave', startSlideShow);

                // Touch events for mobile
                let touchStartX = 0;
                let touchEndX = 0;

                carousel.addEventListener('touchstart', e => {
                    touchStartX = e.changedTouches[0].screenX;
                }, false);

                carousel.addEventListener('touchend', e => {
                    touchEndX = e.changedTouches[0].screenX;
                    handleSwipe();
                }, false);

                function handleSwipe() {
                    if (touchEndX < touchStartX - 50) {
                        // Swipe left - next slide
                        stopSlideShow();
                        nextSlide();
                        startSlideShow();
                    }

                    if (touchEndX > touchStartX + 50) {
                        // Swipe right - previous slide
                        stopSlideShow();
                        prevSlide();
                        startSlideShow();
                    }
                }
            }

            showSlide(0);
            startSlideShow();
        });
    </script>
@endpush
