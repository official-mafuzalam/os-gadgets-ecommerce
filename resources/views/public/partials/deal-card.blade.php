<a href="{{ $deal->button_link }}">
    <div class="relative bg-white rounded-xl shadow-md overflow-hidden">
        <!-- Deal Image -->
        <img src="{{ $deal->image_url }}" alt="{{ $deal->title }}" class="w-full h-48 md:h-64 object-cover">

        <!-- Overlay content -->
        <div
            class="absolute inset-0 flex flex-col justify-end p-3 md:p-4 bg-gradient-to-t from-black/60 to-transparent text-white">
            <h3 class="text-base md:text-lg font-semibold mb-1">{{ $deal->title }}</h3>
            <p class="text-xs md:text-sm mb-2 line-clamp-2">{{ $deal->description }}</p>

            @if ($deal->discount_percentage)
                <div class="bg-red-600 text-xs font-bold px-2 py-1 rounded inline-block mb-2">
                    {{ $deal->discount_percentage }}% OFF
                </div>
            @endif

            <!-- Overlay link -->
            <a href="{{ $deal->button_link }}"
                class="absolute top-2 right-2 md:top-4 md:right-4 bg-indigo-600 text-white text-xs md:text-sm font-medium py-1 px-2 md:py-2 md:px-4 rounded hover:bg-indigo-700 transition"
                aria-label="{{ $deal->button_text }}">
                {{ $deal->button_text }}
            </a>
        </div>
    </div>
</a>
