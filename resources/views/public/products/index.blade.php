<x-app-layout>
    @section('title', 'Products')
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
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                                <a href="{{ route('public.products') }}"
                                    class="ml-3 text-sm text-gray-700 hover:text-indigo-600">
                                    Products
                                </a>
                            </div>
                        </li>
                        @if (isset($category))
                            <li>
                                <div class="flex items-center">
                                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                                    <span class="ml-3 text-sm font-medium text-gray-500">{{ $category->name }}</span>
                                </div>
                            </li>
                        @endif
                        @if (isset($brand))
                            <li>
                                <div class="flex items-center">
                                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                                    <span class="ml-3 text-sm font-medium text-gray-500">{{ $brand->name }}</span>
                                </div>
                            </li>
                        @endif
                        @if (isset($is_featured) && $is_featured)
                            <li>
                                <div class="flex items-center">
                                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                                    <span class="ml-3 text-sm font-medium text-gray-500">Featured</span>
                                </div>
                            </li>
                        @endif
                        @if (isset($deal))
                            <li>
                                <div class="flex items-center">
                                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                                    <span class="ml-3 text-sm font-medium text-gray-500">{{ $deal->title }}</span>
                                </div>
                            </li>
                        @endif
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Page Header -->
        <div class="container mx-auto px-4 py-8">
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">
                            @if (isset($category))
                                {{ $category->name }} Products
                            @elseif(isset($brand))
                                {{ $brand->name }} Products
                            @elseif(isset($is_featured) && $is_featured)
                                Featured Products
                            @elseif(isset($deal))
                                {{ $deal->title }} Products
                            @else
                                All Products
                            @endif
                        </h1>
                        <p class="text-gray-600">
                            @if (isset($category))
                                {{ $category->description ?? 'Browse our collection of ' . $category->name . ' products' }}
                            @elseif(isset($brand))
                                Discover premium products from {{ $brand->name }}
                            @elseif(isset($is_featured) && $is_featured)
                                Discover our handpicked collection of featured products
                            @elseif(isset($deal))
                                {{ $deal->description ?? 'Explore products under the ' . $deal->title . ' deal' }}
                            @else
                                Discover our complete collection of premium products
                            @endif
                        </p>
                    </div>

                    <div class="mt-4 md:mt-0">
                        <p class="text-sm text-gray-600">
                            Showing {{ $products->total() }} results
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar Filters -->
                <div class="lg:w-1/4">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                        <!-- Categories -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Categories</h3>
                            <div class="space-y-2">
                                <a href="{{ route('public.products') }}"
                                    class="block py-2 px-3 rounded-lg text-sm font-medium {{ !request('category') && !request('brand') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                    All Categories
                                </a>
                                @foreach ($categories as $cat)
                                    <a href="{{ route('public.products', ['category' => $cat->slug]) }}"
                                        class="block py-2 px-3 rounded-lg text-sm font-medium {{ request('category') == $cat->slug ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                        {{ $cat->name }}
                                        <span class="text-gray-400 float-right">({{ $cat->products_count }})</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Brands -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Brands</h3>
                            <div class="space-y-2">
                                <a href="{{ route('public.products') }}"
                                    class="block py-2 px-3 rounded-lg text-sm font-medium {{ !request('brand') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                    All Brands
                                </a>
                                @foreach ($brands as $br)
                                    <a href="{{ route('public.products', ['brand' => $br->slug]) }}"
                                        class="block py-2 px-3 rounded-lg text-sm font-medium {{ request('brand') == $br->slug ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                        {{ $br->name }}
                                        <span class="text-gray-400 float-right">({{ $br->products_count }})</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Price Filter -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Price Range</h3>
                            <form method="GET" action="{{ route('public.products') }}">
                                @if (request('category'))
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                @endif
                                @if (request('brand'))
                                    <input type="hidden" name="brand" value="{{ request('brand') }}">
                                @endif
                                <div class="space-y-3">
                                    <div class="flex space-x-2">
                                        <input type="number" name="min_price" placeholder="Min"
                                            value="{{ request('min_price') }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                                        <input type="number" name="max_price" placeholder="Max"
                                            value="{{ request('max_price') }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                                    </div>
                                    <button type="submit"
                                        class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md text-sm font-medium hover:bg-indigo-700">
                                        Apply Filter
                                    </button>
                                    @if (request('min_price') || request('max_price'))
                                        <a href="{{ route('public.products', array_filter(['category' => request('category'), 'brand' => request('brand')])) }}"
                                            class="block text-center text-sm text-indigo-600 hover:text-indigo-700">
                                            Clear Filter
                                        </a>
                                    @endif
                                </div>
                            </form>
                        </div>

                        <!-- Sort -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Sort By</h3>
                            <form method="GET" action="{{ route('public.products') }}">
                                @if (request('category'))
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                @endif
                                @if (request('brand'))
                                    <input type="hidden" name="brand" value="{{ request('brand') }}">
                                @endif
                                @if (request('min_price'))
                                    <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                                @endif
                                @if (request('max_price'))
                                    <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                                @endif
                                <select name="sort" onchange="this.form.submit()"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest
                                        First</option>
                                    <option value="price_low_high"
                                        {{ request('sort') == 'price_low_high' ? 'selected' : '' }}>Price: Low to High
                                    </option>
                                    <option value="price_high_low"
                                        {{ request('sort') == 'price_high_low' ? 'selected' : '' }}>Price: High to Low
                                    </option>
                                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>
                                        Name: A to Z</option>
                                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>
                                        Name: Z to A</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="lg:w-3/4">
                    <!-- Mobile Filter Toggle -->
                    <div class="lg:hidden mb-4">
                        <button onclick="toggleMobileFilters()"
                            class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 flex items-center justify-between">
                            <span>Filters</span>
                            <i class="fas fa-filter"></i>
                        </button>
                    </div>

                    <!-- Products Grid -->
                    @if ($products->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($products as $product)
                                <div
                                    class="product-card bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                                    <a href="{{ route('public.products.show', $product->slug) }}">
                                        <div class="relative">
                                            <img src="{{ $product->images->where('is_primary', true)->first() ? Storage::url($product->images->where('is_primary', true)->first()->image_path) : 'https://via.placeholder.com/300' }}"
                                                alt="{{ $product->name }}" class="w-full h-48 object-cover">
                                            @if ($product->discount > 0)
                                                <div
                                                    class="absolute top-2 left-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                                                    {{ number_format(($product->discount / $product->price) * 100) }}%
                                                    OFF
                                                </div>
                                            @endif
                                            @if ($product->created_at->gt(now()->subDays(30)))
                                                <div
                                                    class="absolute top-2 right-2 bg-indigo-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                                                    NEW
                                                </div>
                                            @endif
                                        </div>
                                    </a>
                                    <div class="p-4">
                                        <a href="{{ route('public.products.show', $product->slug) }}">
                                            <h3 class="font-semibold text-lg mb-1 hover:text-indigo-600 line-clamp-2"
                                                title="{{ $product->name }}">
                                                {{ $product->name }}
                                            </h3>
                                        </a>

                                        <div class="flex items-center mb-2">
                                            <div class="flex text-yellow-400 text-sm">
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
                                            <span
                                                class="text-gray-600 text-xs ml-2">({{ $product->reviews_count }})</span>
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
                                            <form action="{{ route('cart.add', $product) }}" method="POST"
                                                class="flex-1">
                                                @csrf
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit"
                                                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-3 rounded text-sm flex items-center justify-center transition-colors">
                                                    <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
                                                </button>
                                            </form>
                                            <a href="{{ route('public.products.show', $product->slug) }}"
                                                class="bg-green-600 hover:bg-green-700 text-white p-2 rounded text-sm flex items-center justify-center transition-colors">
                                                <i class="fas fa-eye"></i>
                                            </a>
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
                            <p class="text-gray-600 mb-4">Try adjusting your search or filter criteria</p>
                            <a href="{{ route('public.products') }}"
                                class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">
                                Clear Filters
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Mobile Filters Modal -->
        <div id="mobileFilters" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden lg:hidden">
            <div class="absolute right-0 top-0 h-full w-80 bg-white overflow-y-auto">
                <div class="p-4">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold">Filters</h2>
                        <button onclick="toggleMobileFilters()" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    <!-- Mobile filter content (same as sidebar filters) -->
                    <div class="space-y-6">
                        <!-- Categories -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Categories</h3>
                            <div class="space-y-2">
                                <!-- Same category links as sidebar -->
                            </div>
                        </div>

                        <!-- Brands -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Brands</h3>
                            <div class="space-y-2">
                                <!-- Same brand links as sidebar -->
                            </div>
                        </div>

                        <!-- Price Filter -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Price Range</h3>
                            <!-- Same price filter as sidebar -->
                        </div>

                        <!-- Sort -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Sort By</h3>
                            <!-- Same sort options as sidebar -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
        </style>

        <script>
            function toggleMobileFilters() {
                document.getElementById('mobileFilters').classList.toggle('hidden');
            }

            // Close mobile filters when clicking outside
            document.getElementById('mobileFilters').addEventListener('click', function(e) {
                if (e.target.id === 'mobileFilters') {
                    toggleMobileFilters();
                }
            });
        </script>
    </x-slot>
</x-app-layout>
