<div class="product-card bg-white rounded-lg overflow-hidden shadow-md">
    <a href="{{ route('public.products.show', $product->slug) }}" class="block">
        <div class="relative">
            <img src="{{ $product->images->where('is_primary', true)->first() ? Storage::url($product->images->where('is_primary', true)->first()->image_path) : 'https://via.placeholder.com/40' }}"
                alt="{{ $product->name }}" class="w-full h-56 object-cover">
            @if ($product->created_at->gt(now()->subDays(30)))
                <div
                    class="absolute top-0 right-0 bg-indigo-600 text-white text-xs font-bold px-2 py-1 m-2 rounded-full">
                    NEW
                </div>
            @endif
            @if ($product->discount > 0)
                <div class="absolute top-0 left-0 bg-red-600 text-white text-xs font-bold px-2 py-1 m-2 rounded-full">
                    {{ number_format(($product->discount / $product->price) * 100) }}% OFF
                </div>
            @endif
        </div>
    </a>
    <div class="p-4">
        <a href="{{ route('public.products.show', $product->slug) }}" class="block mb-2">
            <h3 class="font-semibold text-lg hover:text-indigo-600 transition-colors line-clamp-2"
                title="{{ $product->name }}">
                {{ $product->name }}
            </h3>
        </a>
        <div class="flex items-center mb-2">
            <div class="flex text-yellow-400">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= floor($product->average_rating))
                        <i class="fas fa-star"></i>
                    @elseif($i - 0.5 <= $product->average_rating)
                        <i class="fas fa-star-half-alt"></i>
                    @else
                        <i class="far fa-star"></i>
                    @endif
                @endfor
            </div>
            <span class="text-gray-600 text-sm ml-2">({{ number_format($product->average_rating, 1) }})</span>
        </div>

        <div class="mb-3">
            @if ($product->discount > 0)
                <div class="flex items-center space-x-2">
                    <span class="text-2xl font-bold text-gray-900">{{ number_format($product->final_price) }}
                        TK</span>
                    <span class="text-sm text-gray-500 line-through">{{ number_format($product->price) }}
                        TK</span>
                </div>
            @else
                <span class="text-2xl font-bold text-gray-900">{{ number_format($product->price) }}
                    TK</span>
            @endif
        </div>

        <!-- Buttons -->
        <div class="flex space-x-2">
            <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-1">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-2 rounded transition duration-300 text-xs flex items-center justify-center">
                    <i class="fas fa-shopping-cart mr-1"></i> Add to Cart
                </button>
            </form>
            <a href="{{ route('public.products.buy-now', $product) }}"
                class="bg-green-600 hover:bg-green-700 text-white py-2 px-3 rounded transition duration-300 text-xs flex items-center justify-center">
                Buy Now
            </a>
        </div>
    </div>
</div>
