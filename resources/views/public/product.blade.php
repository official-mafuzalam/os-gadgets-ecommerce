<x-app-layout>
    <x-slot name="main">
        <!-- Breadcrumb -->
        <div class="bg-gray-100 py-3">
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
                                <a href="{{ route('public.categories.show', $product->category) }}"
                                    class="ml-3 text-sm text-gray-700 hover:text-indigo-600">
                                    {{ $product->category->name }}
                                </a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                                <span class="ml-3 text-sm font-medium text-gray-500">{{ $product->name }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Product Section -->
        <div class="container mx-auto px-4 py-8">
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Product Images -->
                <div class="md:w-1/2">
                    <!-- Main Image -->
                    <div class="bg-white rounded-lg shadow-md p-4 mb-4">
                        <img id="mainProductImage" src="{{ asset('storage/' . $product->image) }}"
                            alt="{{ $product->name }}" class="w-full h-96 object-contain">
                    </div>

                    <!-- Image Gallery -->
                    @if ($product->image_gallery && count($product->image_gallery) > 0)
                        <div class="grid grid-cols-4 gap-2">
                            <div class="border-2 border-indigo-600 rounded-lg p-1">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="h-20 w-full object-cover cursor-pointer"
                                    onclick="changeMainImage('{{ asset('storage/' . $product->image) }}')">
                            </div>
                            @foreach ($product->image_gallery as $image)
                                <div class="border rounded-lg p-1 hover:border-indigo-600 transition-colors">
                                    <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}"
                                        class="h-20 w-full object-cover cursor-pointer"
                                        onclick="changeMainImage('{{ asset('storage/' . $image) }}')">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Product Details -->
                <div class="md:w-1/2">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>

                    <!-- Brand -->
                    <div class="mb-4">
                        <span class="text-gray-600">Brand: </span>
                        <a href="{{ route('public.brands.show', $product->brand) }}" class="text-indigo-600 hover:underline">
                            {{ $product->brand->name }}
                        </a>
                    </div>

                    <!-- Rating -->
                    <div class="flex items-center mb-4">
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
                        <span class="text-gray-600 text-sm ml-2">({{ $product->reviews->count() }} reviews)</span>
                    </div>

                    <!-- Price -->
                    <div class="mb-6">
                        <span class="text-3xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                        @if ($product->stock_quantity > 0)
                            <span class="ml-3 text-sm text-green-600 bg-green-100 px-2 py-1 rounded-full">
                                <i class="fas fa-check-circle mr-1"></i> In Stock
                            </span>
                        @else
                            <span class="ml-3 text-sm text-red-600 bg-red-100 px-2 py-1 rounded-full">
                                <i class="fas fa-times-circle mr-1"></i> Out of Stock
                            </span>
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Description</h3>
                        <p class="text-gray-700">{{ $product->description }}</p>
                    </div>

                    <!-- Add to Cart -->
                    <div class="mb-8">
                        <form action="#" method="POST">
                            @csrf
                            <div class="flex items-center mb-4">
                                <label for="quantity" class="text-gray-700 mr-4">Quantity:</label>
                                <div class="flex items-center border rounded-md">
                                    <button type="button" class="px-3 py-2 text-gray-600" onclick="decreaseQuantity()">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" id="quantity" name="quantity" value="1" min="1"
                                        max="{{ $product->stock_quantity }}"
                                        class="w-16 text-center border-0 focus:ring-0">
                                    <button type="button" class="px-3 py-2 text-gray-600" onclick="increaseQuantity()">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="flex space-x-4">
                                <button type="submit"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-8 rounded-lg transition duration-300 flex items-center"
                                    {{ $product->stock_quantity == 0 ? 'disabled' : '' }}>
                                    <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
                                </button>
                                <button type="button"
                                    class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-3 px-6 rounded-lg transition duration-300 flex items-center">
                                    <i class="fas fa-heart mr-2"></i> Wishlist
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Product Details -->
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-semibold mb-4">Product Details</h3>
                        <ul class="space-y-2">
                            <li class="flex">
                                <span class="text-gray-600 w-32">SKU:</span>
                                <span class="text-gray-900">{{ $product->sku }}</span>
                            </li>
                            <li class="flex">
                                <span class="text-gray-600 w-32">Category:</span>
                                <a href="{{ route('public.categories.show', $product->category) }}"
                                    class="text-indigo-600 hover:underline">
                                    {{ $product->category->name }}
                                </a>
                            </li>
                            <li class="flex">
                                <span class="text-gray-600 w-32">Availability:</span>
                                <span class="text-gray-900">{{ $product->stock_quantity }} in stock</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Specifications -->
            {{-- @if ($product->specifications && count($product->specifications) > 0)
                <div class="mt-12">
                    <h2 class="text-2xl font-bold mb-6">Specifications</h2>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($product->specifications as $key => $value)
                                    <tr class="hover:bg-gray-50">
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-1/3">
                                            {{ $key }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ $value }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif --}}

            <!-- Reviews -->
            <div class="mt-12">
                <h2 class="text-2xl font-bold mb-6">Customer Reviews</h2>

                <!-- Review Summary -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                    <div class="flex flex-col md:flex-row items-center">
                        <div class="md:w-1/3 text-center mb-6 md:mb-0">
                            <div class="text-5xl font-bold text-gray-900">
                                {{ number_format($product->average_rating, 1) }}/5</div>
                            <div class="flex justify-center text-yellow-400 my-2">
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
                            <div class="text-gray-600">Based on {{ $product->reviews->count() }} reviews</div>
                        </div>
                        <div class="md:w-2/3 md:pl-8">
                            @for ($i = 5; $i >= 1; $i--)
                                @php
                                    $count = $product->reviews->where('rating', $i)->count();
                                    $percentage =
                                        $product->reviews->count() > 0
                                            ? ($count / $product->reviews->count()) * 100
                                            : 0;
                                @endphp
                                <div class="flex items-center mb-2">
                                    <div class="text-gray-600 w-8">{{ $i }} <i
                                            class="fas fa-star text-yellow-400"></i></div>
                                    <div class="flex-1 h-2 bg-gray-200 rounded-full mx-2">
                                        <div class="h-2 bg-yellow-400 rounded-full"
                                            style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <div class="text-gray-600 w-12 text-right">{{ $count }}</div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

                <!-- Review List -->
                <div class="space-y-6">
                    @forelse($product->reviews as $review)
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h4 class="font-semibold">{{ $review->user->name }}</h4>
                                    <div class="flex text-yellow-400 mt-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $review->rating)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <span class="text-gray-500 text-sm">{{ $review->created_at->format('M d, Y') }}</span>
                            </div>
                            <p class="text-gray-700">{{ $review->comment }}</p>
                        </div>
                    @empty
                        <div class="bg-white rounded-lg shadow-md p-6 text-center">
                            <p class="text-gray-600">No reviews yet. Be the first to review this product!</p>
                        </div>
                    @endforelse
                </div>

                <!-- Write Review Button -->
                <div class="mt-8 text-center">
                    <button
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-8 rounded-lg transition duration-300">
                        Write a Review
                    </button>
                </div>
            </div>

            <!-- Related Products -->
            @if ($relatedProducts->count() > 0)
                <div class="mt-16">
                    <h2 class="text-2xl font-bold mb-6">You May Also Like</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($relatedProducts as $relatedProduct)
                            <div class="product-card bg-white rounded-lg overflow-hidden shadow-md">
                                <a href="{{ route('products.show', $relatedProduct) }}">
                                    <img src="{{ asset('storage/' . $relatedProduct->image) }}"
                                        alt="{{ $relatedProduct->name }}" class="w-full h-48 object-cover">
                                </a>
                                <div class="p-4">
                                    <a href="{{ route('products.show', $relatedProduct) }}"
                                        class="font-semibold text-lg mb-1 hover:text-indigo-600">
                                        {{ Str::limit($relatedProduct->name, 40) }}
                                    </a>
                                    <div class="flex items-center mb-2">
                                        <div class="flex text-yellow-400 text-sm">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= floor($relatedProduct->average_rating))
                                                    <i class="fas fa-star"></i>
                                                @elseif($i - 0.5 <= $relatedProduct->average_rating)
                                                    <i class="fas fa-star-half-alt"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <span
                                            class="text-gray-600 text-sm ml-2">({{ $relatedProduct->reviews->count() }})</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span
                                            class="text-xl font-bold text-gray-900">${{ number_format($relatedProduct->price, 2) }}</span>
                                        <button
                                            class="bg-indigo-600 hover:bg-indigo-700 text-white p-2 rounded-full transition duration-300">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <script>
            function changeMainImage(src) {
                document.getElementById('mainProductImage').src = src;
            }

            function increaseQuantity() {
                const quantityInput = document.getElementById('quantity');
                const max = parseInt(quantityInput.getAttribute('max'));
                let value = parseInt(quantityInput.value);

                if (value < max) {
                    quantityInput.value = value + 1;
                }
            }

            function decreaseQuantity() {
                const quantityInput = document.getElementById('quantity');
                let value = parseInt(quantityInput.value);

                if (value > 1) {
                    quantityInput.value = value - 1;
                }
            }
        </script>
    </x-slot>
</x-app-layout>
