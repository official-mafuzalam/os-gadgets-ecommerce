<section class="py-10 bg-white">
    <div class="container mx-auto px-4">
        <div class="bg-gradient-to-r bg-{{ $deal->background_color }} rounded-2xl overflow-hidden shadow-xl">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 p-8 md:p-12 text-white">
                    <h2 class="text-2xl md:text-3xl font-bold mb-4">{{ $deal->title }}</h2>
                    <p class="text-indigo-100 mb-6">{{ $deal->description }}</p>
                    <div class="flex items-center mb-6">
                        @if ($deal->discount_percentage)
                            <div class="bg-white bg-opacity-20 rounded-lg px-4 py-2 mr-4">
                                <span class="block text-2xl font-bold">{{ $deal->discount_percentage }}%</span>
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
