<x-app-layout>
    @section('title', 'All Brands')
    <x-slot name="main">
        <!-- Breadcrumb -->
        {{-- <div class="bg-gray-100 py-4">
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
                                <span class="ml-3 text-sm font-medium text-gray-500">Brands</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div> --}}

        <!-- Page Header -->
        <div class="container mx-auto px-4 py-8">
            <div class="text-center mb-12">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Shop by Brand</h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Discover products from your favorite brands and explore new ones
                </p>
            </div>

            <!-- Brands Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6">
                @forelse($brands as $brand)
                    <div
                        class="group bg-white rounded-lg shadow-md p-6 text-center hover:shadow-xl transition-all duration-300">
                        <a href="{{ route('public.products', ['brand' => $brand->slug]) }}" class="block">
                            @if ($brand->logo)
                                <div class="mb-4 h-20 flex items-center justify-center">
                                    <img src="{{ Storage::url($brand->logo) }}" alt="{{ $brand->name }}"
                                        class="max-h-16 max-w-full object-contain">
                                </div>
                            @else
                                <div class="mb-4 h-20 flex items-center justify-center">
                                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center">
                                        <span
                                            class="text-2xl font-bold text-indigo-600">{{ substr($brand->name, 0, 1) }}</span>
                                    </div>
                                </div>
                            @endif

                            <h3 class="font-semibold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors">
                                {{ $brand->name }}
                            </h3>

                            <p class="text-sm text-gray-500 mb-3">
                                {{ $brand->products_count }} products
                            </p>

                            <a href="{{ route('public.products', ['brand' => $brand->slug]) }}"
                                class="inline-block text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                                View Products
                            </a>
                        </a>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="bg-white rounded-lg shadow-md p-8">
                            <i class="fas fa-tag text-4xl text-gray-300 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No brands found</h3>
                            <p class="text-gray-600">Check back later for new brands</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($brands->hasPages())
                <div class="mt-12">
                    {{ $brands->links() }}
                </div>
            @endif
        </div>

        <!-- Alphabetical Filter -->
        @if ($brands->count() > 20)
            <div class="bg-white border-t border-b border-gray-200 py-4">
                <div class="container mx-auto px-4">
                    <div class="flex flex-wrap justify-center gap-2">
                        @foreach (range('A', 'Z') as $letter)
                            <a href="#{{ $letter }}"
                                class="w-8 h-8 flex items-center justify-center text-sm font-medium text-gray-700 hover:bg-indigo-100 hover:text-indigo-600 rounded">
                                {{ $letter }}
                            </a>
                        @endforeach
                        <a href="#0-9"
                            class="w-8 h-8 flex items-center justify-center text-sm font-medium text-gray-700 hover:bg-indigo-100 hover:text-indigo-600 rounded">
                            0-9
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Featured Brands Section -->
        @if ($featuredBrands->count() > 0)
            <section class="bg-gray-50 py-16">
                <div class="container mx-auto px-4">
                    <div class="text-center mb-12">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Featured Brands</h2>
                        <p class="text-gray-600 mt-2">Discover our most trusted brands</p>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                        @foreach ($featuredBrands as $brand)
                            <div class="text-center group">
                                <a href="{{ route('public.products', ['brand' => $brand->slug]) }}" class="block">
                                    @if ($brand->logo)
                                        <div class="mb-4 h-24 flex items-center justify-center">
                                            <img src="{{ Storage::url($brand->logo) }}" alt="{{ $brand->name }}"
                                                class="max-h-20 max-w-full object-contain group-hover:scale-105 transition-transform duration-300">
                                        </div>
                                    @else
                                        <div class="mb-4 h-24 flex items-center justify-center">
                                            <div
                                                class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center group-hover:bg-indigo-200 transition-colors">
                                                <span
                                                    class="text-3xl font-bold text-indigo-600">{{ substr($brand->name, 0, 1) }}</span>
                                            </div>
                                        </div>
                                    @endif
                                    <h3
                                        class="font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">
                                        {{ $brand->name }}
                                    </h3>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    </x-slot>
</x-app-layout>