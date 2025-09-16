<x-app-layout>
    @section('title', 'All Categories')
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
                                <span class="ml-3 text-sm font-medium text-gray-500">Categories</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Page Header -->
        <div class="container mx-auto px-4 py-8">
            <div class="text-center mb-12">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Product Categories</h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Browse our wide range of product categories to find exactly what you're looking for
                </p>
            </div>

            <!-- Categories Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($categories as $category)
                    <div
                        class="group bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300">
                        <a href="{{ route('public.products', ['category' => $category->slug]) }}">
                            <div class="relative overflow-hidden">
                                @if ($category->image)
                                    <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}"
                                        class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <div
                                        class="w-full h-48 bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center">
                                        <i class="fas fa-folder text-4xl text-indigo-400"></i>
                                    </div>
                                @endif
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300">
                                </div>
                            </div>
                        </a>

                        <div class="p-6">
                            <a href="{{ route('public.products', ['category' => $category->slug]) }}">
                                <h3
                                    class="text-xl font-semibold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors">
                                    {{ $category->name }}
                                </h3>
                            </a>

                            @if ($category->description)
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                    {{ $category->description }}
                                </p>
                            @endif

                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">
                                    {{ $category->products_count }} products
                                </span>
                                <a href="{{ route('public.products', ['category' => $category->slug]) }}"
                                    class="text-indigo-600 hover:text-indigo-700 text-sm font-medium flex items-center">
                                    View Products
                                    <i class="fas fa-arrow-right ml-1 text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="bg-white rounded-lg shadow-md p-8">
                            <i class="fas fa-folder-open text-4xl text-gray-300 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No categories found</h3>
                            <p class="text-gray-600">Check back later for new categories</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($categories->hasPages())
                <div class="mt-12">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>

        <!-- Featured Categories Section -->
        @if ($featuredCategories->count() > 0)
            <section class="bg-gray-50 py-12 mt-12">
                <div class="container mx-auto px-4">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Featured Categories</h2>
                        <p class="text-gray-600 mt-2">Discover our most popular product categories</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($featuredCategories as $category)
                            <div
                                class="bg-white rounded-xl shadow-md p-6 flex items-center space-x-4 hover:shadow-lg transition-shadow">
                                @if ($category->icon)
                                    <div
                                        class="flex-shrink-0 w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                                        <i class="{{ $category->icon }} text-indigo-600 text-xl"></i>
                                    </div>
                                @else
                                    <div
                                        class="flex-shrink-0 w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-box text-indigo-600 text-xl"></i>
                                    </div>
                                @endif
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        <a href="{{ route('public.products', ['category' => $category->slug]) }}"
                                            class="hover:text-indigo-600">
                                            {{ $category->name }}
                                        </a>
                                    </h3>
                                    <p class="text-sm text-gray-500">{{ $category->products_count }} products</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <style>
            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
        </style>
    </x-slot>
</x-app-layout>
