<x-app-layout>
    <x-slot name="main">
        <!-- Breadcrumb Navigation -->
        <div class="bg-gray-100 py-4">
            <div class="container mx-auto px-4">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('public.welcome') }}"
                                class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-indigo-600">
                                <i class="fas fa-home mr-2"></i>
                                Home
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                                <a href="{{ route('public.categories.show', $product->category->slug) }}"
                                    class="ml-1 text-sm font-medium text-gray-500 hover:text-indigo-600 md:ml-2">
                                    {{ $product->category->name }}
                                </a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                                <span class="ml-1 text-sm font-medium text-gray-400 md:ml-2">
                                    {{ Str::limit($product->name, 80) }}
                                </span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Product Section -->
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Product Images -->
                <div>
                    <!-- Main Image -->
                    <div class="mb-4 bg-white rounded-lg shadow-md p-4">
                        <div class="relative overflow-hidden rounded-lg">
                            @if ($product->images->count() > 0)
                                <img id="main-product-image"
                                    src="{{ Storage::url($product->images->first()->image_path) }}"
                                    alt="{{ $product->name }}" class="w-full h-96 object-contain">
                            @else
                                <div class="w-full h-96 bg-gray-200 flex items-center justify-center rounded-lg">
                                    <i class="fas fa-image text-4xl text-gray-400"></i>
                                </div>
                            @endif
                            @if ($product->discount > 0)
                                <div
                                    class="absolute top-4 left-4 bg-red-600 text-white text-sm font-bold px-3 py-1 rounded-full">
                                    {{ number_format($product->discount) }} TK OFF
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Thumbnail Images -->
                    @if ($product->images->count() > 1)
                        <div class="grid grid-cols-4 gap-2">
                            @foreach ($product->images as $image)
                                <div class="border-2 border-transparent hover:border-indigo-500 rounded-lg p-1 cursor-pointer transition-all"
                                    onclick="changeImage('{{ Storage::url($image->image_path) }}')">
                                    <img src="{{ Storage::url($image->image_path) }}" alt="{{ $product->name }}"
                                        class="w-full h-20 object-cover rounded-md">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Product Details -->
                <div>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <!-- Brand & Status -->
                        <div class="flex justify-between items-start mb-4">
                            @if ($product->brand)
                                <span class="text-sm text-gray-500">By <a
                                        href="{{ route('public.brands.show', $product->brand->slug) }}"
                                        class="text-indigo-600 hover:underline">{{ $product->brand->name }}</a></span>
                            @endif
                            @if ($product->stock_quantity > 0)
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">In
                                    Stock</span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">Out of
                                    Stock</span>
                            @endif
                        </div>

                        <!-- Product Title -->
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>

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
                            <span class="ml-2 text-sm text-gray-600">({{ $product->reviews_count }} reviews)</span>
                        </div>

                        <!-- Price -->
                        <div class="mb-6">
                            @if ($product->discount > 0)
                                <div class="flex items-center">
                                    <span
                                        class="text-3xl font-bold text-gray-900">{{ number_format($product->final_price) }}
                                        TK</span>
                                    <span
                                        class="ml-3 text-xl text-gray-500 line-through">{{ number_format($product->price) }}
                                        TK</span>
                                    <span class="ml-3 bg-red-100 text-red-800 text-sm font-medium px-2 py-1 rounded">
                                        Save {{ number_format($product->discount) }} TK
                                    </span>
                                </div>
                            @else
                                <span class="text-3xl font-bold text-gray-900">{{ number_format($product->price) }}
                                    TK</span>
                            @endif
                        </div>

                        <!-- Description -->
                        {{-- <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Description</h3>
                            <p class="text-gray-700">{{ $product->description }}</p>
                        </div> --}}

                        <!-- Add to Cart -->
                        <div class="mb-6">
                            <div class="flex items-center space-x-4 mb-4">
                                <div class="flex items-center border border-gray-300 rounded-md">
                                    <button class="px-3 py-2 text-gray-600 hover:text-gray-800"
                                        onclick="decreaseQuantity()">-</button>
                                    <input type="number" id="quantity" value="1" min="1"
                                        max="{{ $product->stock_quantity }}"
                                        class="w-12 text-center border-0 focus:ring-0">
                                    <button class="px-3 py-2 text-gray-600 hover:text-gray-800"
                                        onclick="increaseQuantity()">+</button>
                                </div>
                                <span class="text-sm text-gray-500">{{ $product->stock_quantity }} available</span>
                            </div>

                            <!-- Categories -->
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Category</h3>
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('public.categories.show', $product->category->slug) }}"
                                        class="bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm px-3 py-1 rounded-full transition-colors">
                                        {{ $product->category->name }}
                                    </a>
                                </div>
                            </div>

                            <div class="flex space-x-4">
                                <form action="#" method="POST" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit"
                                        class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-md transition-colors flex items-center justify-center">
                                        <i class="fas fa-shopping-bag mr-2"></i>
                                        Buy Now
                                    </button>
                                </form>
                                <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1" id="form-quantity">
                                    <button type="submit"
                                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-md transition-colors flex items-center justify-center"
                                        {{ $product->stock_quantity == 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-shopping-cart mr-2"></i>
                                        Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Product Details -->
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex items-center text-sm text-gray-600 mb-2">
                                <i class="fas fa-truck mr-2"></i>
                                Delivery within 2-5 business days
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-undo mr-2"></i>
                                30-day money-back guarantee
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Tabs -->
            <div class="mt-12 bg-white rounded-lg shadow-md">
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px">
                        <button id="tab-description"
                            class="py-4 px-6 text-sm font-medium border-b-2 border-indigo-500 text-indigo-600">Description</button>
                        <button id="tab-specifications"
                            class="py-4 px-6 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700">Specifications</button>
                        <button id="tab-reviews"
                            class="py-4 px-6 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700">Reviews
                            ({{ $product->reviews_count }})</button>
                        <button id="tab-shipping"
                            class="py-4 px-6 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700">Shipping
                            & Returns</button>
                    </nav>
                </div>
                <div class="p-6">
                    <!-- Description Tab -->
                    <div id="content-description" class="prose max-w-none">
                        <p>{{ $product->description }}</p>
                    </div>

                    <!-- Specifications Tab -->
                    <div id="content-specifications" class="prose max-w-none hidden">
                        @if ($product->specifications && count($product->specifications) > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach ($product->specifications as $key => $value)
                                    <div class="border-b border-gray-100 pb-2">
                                        <dt class="font-medium text-gray-900">{{ $key }}</dt>
                                        <dd class="text-gray-700">{{ $value }}</dd>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-600">No specifications available.</p>
                        @endif
                    </div>

                    <!-- Reviews Tab -->
                    <div id="content-reviews" class="hidden">
                        <div class="flex items-center mb-6">
                            <div class="mr-4">
                                <span
                                    class="text-5xl font-bold text-gray-900">{{ number_format($product->average_rating, 1) }}</span>
                                <span class="text-gray-500">/5</span>
                            </div>
                            <div>
                                <div class="flex items-center mb-1">
                                    <div class="flex text-yellow-400 mr-2">
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
                                </div>
                                <p class="text-sm text-gray-600">Based on {{ $product->reviews_count }} reviews</p>
                            </div>
                        </div>

                        <!-- Review List -->
                        <div class="space-y-6">
                            @forelse($product->reviews as $review)
                                <div class="border-b border-gray-200 pb-6">
                                    <div class="flex items-center mb-2">
                                        <div class="flex text-yellow-400 mr-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $review->rating)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <h4 class="font-medium text-gray-900">{{ $review->user->name }}</h4>
                                    </div>
                                    <p class="text-gray-600 text-sm mb-2">{{ $review->created_at->format('M d, Y') }}
                                    </p>
                                    <p class="text-gray-700">{{ $review->comment }}</p>
                                </div>
                            @empty
                                <p class="text-gray-600">No reviews yet. Be the first to review this product!</p>
                            @endforelse
                        </div>

                        <!-- Review Form -->
                        <div class="mt-8">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Write a Review</h4>
                            <form>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                                    <div class="flex items-center">
                                        <div class="flex text-gray-300" id="rating-stars">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star cursor-pointer hover:text-yellow-400 text-lg"
                                                    onmouseover="highlightStars({{ $i }})"
                                                    onclick="setRating({{ $i }})"></i>
                                            @endfor
                                        </div>
                                        <input type="hidden" name="rating" id="rating-value" value="0">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="review-body"
                                        class="block text-sm font-medium text-gray-700 mb-2">Review</label>
                                    <textarea id="review-body" name="body" rows="4"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                                </div>
                                <button type="submit"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-md transition-colors">Submit
                                    Review</button>
                            </form>
                        </div>
                    </div>

                    <!-- Shipping Tab -->
                    <div id="content-shipping" class="prose max-w-none hidden">
                        <h3>Shipping Information</h3>
                        <p>We offer standard shipping within 2-5 business days. Express shipping options are available
                            at checkout for an additional fee.</p>
                        <p>Free shipping on orders over ৳1000. All orders are processed within 24 hours of placement.
                        </p>

                        <h3>Returns Policy</h3>
                        <p>We offer a 30-day money-back guarantee on all products. If you're not completely satisfied
                            with your purchase, you can return it for a full refund.</p>
                        <p>To initiate a return, please contact our customer service team with your order number and
                            reason for return.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if ($relatedProducts->count() > 0)
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">You May Also Like</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    @foreach ($relatedProducts as $relatedProduct)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden group">
                            <a href="{{ route('public.products.show', $relatedProduct) }}">
                                <div class="relative overflow-hidden">
                                    <img src="{{ $relatedProduct->image ? Storage::url($relatedProduct->image) : 'https://via.placeholder.com/300' }}"
                                        alt="{{ $relatedProduct->name }}"
                                        class="w-full h-48 object-cover group-hover:scale-105 transition duration-300">
                                </div>
                            </a>
                            <div class="p-4">
                                <a href="{{ route('public.products.show', $relatedProduct) }}">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-1 hover:text-indigo-600">
                                        {{ Str::limit($relatedProduct->name, 40) }}
                                    </h3>
                                </a>
                                <div class="flex items-center justify-between mt-2">
                                    <span
                                        class="text-lg font-bold text-gray-900">{{ number_format($relatedProduct->price) }}
                                        TK</span>
                                    <form action="{{ route('cart.add', $relatedProduct) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit"
                                            class="bg-indigo-600 hover:bg-indigo-700 text-white p-2 rounded-full transition duration-300">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <script>
            // Function to change the main product image
            function changeImage(src) {
                document.getElementById('main-product-image').src = src;
            }

            // Function to increase quantity
            function increaseQuantity() {
                const quantityInput = document.getElementById('quantity');
                const formQuantityInput = document.getElementById('form-quantity');
                const max = parseInt(quantityInput.max);
                let value = parseInt(quantityInput.value);
                if (value < max) {
                    quantityInput.value = value + 1;
                    formQuantityInput.value = value + 1;
                }
            }

            // Function to decrease quantity
            function decreaseQuantity() {
                const quantityInput = document.getElementById('quantity');
                const formQuantityInput = document.getElementById('form-quantity');
                let value = parseInt(quantityInput.value);
                if (value > 1) {
                    quantityInput.value = value - 1;
                    formQuantityInput.value = value - 1;
                }
            }

            // Tab functionality
            document.addEventListener('DOMContentLoaded', function() {
                const tabs = document.querySelectorAll('[id^="tab-"]');
                const contents = document.querySelectorAll('[id^="content-"]');

                tabs.forEach(tab => {
                    tab.addEventListener('click', function() {
                        const target = this.id.replace('tab-', 'content-');

                        // Update active tab
                        tabs.forEach(t => {
                            t.classList.remove('border-indigo-500', 'text-indigo-600');
                            t.classList.add('border-transparent', 'text-gray-500');
                        });
                        this.classList.add('border-indigo-500', 'text-indigo-600');
                        this.classList.remove('border-transparent', 'text-gray-500');

                        // Show target content
                        contents.forEach(content => {
                            content.classList.add('hidden');
                        });
                        document.getElementById(target).classList.remove('hidden');
                    });
                });

                // Rating stars functionality
                window.highlightStars = function(count) {
                    const stars = document.querySelectorAll('#rating-stars i');
                    stars.forEach((star, index) => {
                        if (index < count) {
                            star.classList.add('text-yellow-400');
                            star.classList.remove('text-gray-300');
                        } else {
                            star.classList.remove('text-yellow-400');
                            star.classList.add('text-gray-300');
                        }
                    });
                };

                window.setRating = function(count) {
                    document.getElementById('rating-value').value = count;
                    const stars = document.querySelectorAll('#rating-stars i');
                    stars.forEach((star, index) => {
                        if (index < count) {
                            star.classList.add('text-yellow-400');
                            star.classList.remove('text-gray-300');
                        } else {
                            star.classList.remove('text-yellow-400');
                            star.classList.add('text-gray-300');
                        }
                    });
                };
            });
        </script>
    </x-slot>
</x-app-layout>
