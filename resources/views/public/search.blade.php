<x-app-layout>
    <x-slot name="main">
        <!-- Breadcrumb -->
        <div class="bg-gray-100 py-4">
            <div class="container mx-auto px-4">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('public.welcome') }}" class="text-sm text-gray-700 hover:text-indigo-600">
                                <i class="fas fa-home mr-1"></i>
                                Home
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                                <span class="ml-3 text-sm font-medium text-gray-500">Search Results</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Search Results -->
        <div class="container mx-auto px-4 py-8">
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">
                    Search Results for "{{ $query }}"
                </h1>

                @if ($products->count() > 0)
                    <p class="text-gray-600">{{ $products->total() }} results found</p>
                @else
                    <p class="text-gray-600">No results found for "{{ $query }}"</p>
                @endif
            </div>

            @if ($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($products as $product)
                        <div
                            class="product-card bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                            <a href="{{ route('public.products.show', $product) }}">
                                <div class="relative">
                                    <img src="{{ $product->image ? Storage::url($product->image) : 'https://via.placeholder.com/300' }}"
                                        alt="{{ $product->name }}" class="w-full h-48 object-cover">
                                    @if ($product->discount > 0)
                                        <div
                                            class="absolute top-2 left-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                                            {{ number_format(($product->discount / $product->price) * 100) }}% OFF
                                        </div>
                                    @endif
                                </div>
                            </a>
                            <div class="p-4">
                                <a href="{{ route('public.products.show', $product) }}">
                                    <h3 class="font-semibold text-lg mb-1 hover:text-indigo-600">{{ $product->name }}
                                    </h3>
                                </a>

                                <div class="flex items-center mb-2">
                                    <div class="flex text-yellow-400 text-sm">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= floor($product->reviews_avg_rating))
                                                <i class="fas fa-star"></i>
                                            @elseif($i - 0.5 <= $product->reviews_avg_rating)
                                                <i class="fas fa-star-half-alt"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-gray-600 text-xs ml-2">({{ $product->reviews_count }})</span>
                                </div>

                                <div class="mb-3">
                                    @if ($product->discount > 0)
                                        <div class="flex items-center space-x-2">
                                            <span
                                                class="text-xl font-bold text-gray-900">{{ number_format($product->final_price) }}
                                                TK</span>
                                            <span
                                                class="text-sm text-gray-500 line-through">{{ number_format($product->price) }}
                                                TK</span>
                                        </div>
                                    @else
                                        <span
                                            class="text-xl font-bold text-gray-900">{{ number_format($product->price) }}
                                            TK</span>
                                    @endif
                                </div>

                                <div class="flex space-x-2">
                                    <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit"
                                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-3 rounded text-sm">
                                            Add to Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <i class="fas fa-search text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
                    <p class="text-gray-600 mb-4">Try different keywords or browse our categories</p>
                    <div class="space-x-4">
                        <a href="{{ route('public.products') }}"
                            class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">
                            Browse All Products
                        </a>
                        <a href="{{ route('public.categories') }}"
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-300">
                            View Categories
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </x-slot>
</x-app-layout>
