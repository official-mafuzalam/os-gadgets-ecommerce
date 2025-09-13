<x-admin-layout>
    @section('title', $product->name)
    <x-slot name="main">
        <div class="w-full px-4 py-6 sm:px-6 lg:px-8">
            <!-- Main Card -->
            <div class="bg-white rounded-xl shadow-lg dark:bg-gray-800 overflow-hidden">
                <!-- Card Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">{{ $product->name }}</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            Product Details
                        </p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.products.edit', $product->id) }}"
                            class="px-3 py-2 text-sm font-medium rounded-md bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                            Edit Product
                        </a>
                        <a href="{{ route('admin.products.index') }}"
                            class="px-3 py-2 text-sm font-medium rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600 transition-colors">
                            Back to Products
                        </a>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="px-6 py-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Left Column - Image -->
                        <div class="md:col-span-1">
                            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden">
                                <img src="{{ $product->image ? Storage::url($product->image) : 'https://via.placeholder.com/300' }}"
                                    alt="{{ $product->name }}" class="w-full h-64 object-cover">
                            </div>

                            @if ($product->image_gallery && count($product->image_gallery) > 0)
                                <div class="mt-4">
                                    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Gallery Images
                                    </h3>
                                    <div class="grid grid-cols-3 gap-2">
                                        @foreach ($product->image_gallery as $image)
                                            <img src="{{ Storage::url($image) }}" alt="Gallery image"
                                                class="w-full h-20 object-cover rounded-md">
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Right Column - Details -->
                        <div class="md:col-span-2">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Basic Information -->
                                <div>
                                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Basic
                                        Information</h3>
                                    <dl class="space-y-3">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-200">{{ $product->name }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">SKU</dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-200">{{ $product->sku }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Description
                                            </dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-200">
                                                {{ $product->description }}</dd>
                                        </div>
                                    </dl>
                                </div>

                                <!-- Pricing & Stock -->
                                <div>
                                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Pricing &
                                        Stock</h3>
                                    <dl class="space-y-3">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Price</dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-200">
                                                ${{ number_format($product->price, 2) }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Stock
                                                Quantity</dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-200">
                                                {{ $product->stock_quantity }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                                            <dd>
                                                <span @class([
                                                    'px-2 py-1 rounded-md text-xs font-medium',
                                                    'bg-green-500/10 text-green-600 dark:text-green-400' => $product->is_active,
                                                    'bg-red-500/10 text-red-600 dark:text-red-400' => !$product->is_active,
                                                ])>
                                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </dd>
                                        </div>
                                    </dl>
                                </div>

                                <!-- Category & Brand -->
                                <div>
                                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Category &
                                        Brand</h3>
                                    <dl class="space-y-3">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Category
                                            </dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-200">
                                                {{ $product->category->name }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Brand</dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-200">
                                                {{ $product->brand->name }}</dd>
                                        </div>
                                    </dl>
                                </div>

                                <!-- Specifications -->
                                {{-- @if ($product->specifications && count($product->specifications) > 0)
                                    <div class="md:col-span-2">
                                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">
                                            Specifications</h3>
                                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            @foreach ($product->specifications as $key => $value)
                                                <div>
                                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                                        {{ $key }}</dt>
                                                    <dd class="text-sm text-gray-900 dark:text-gray-200">
                                                        {{ $value }}</dd>
                                                </div>
                                            @endforeach
                                        </dl>
                                    </div>
                                @endif --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-admin-layout>