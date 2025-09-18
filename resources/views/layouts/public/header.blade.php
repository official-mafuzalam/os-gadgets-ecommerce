<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', setting('meta_description', 'Best E-commerce website'))">
    <meta name="keywords" content="@yield('meta_keywords', setting('meta_keywords', 'software, solutions, it'))">
    <meta name="author" content="{{ setting('site_name', 'Octosync Software Ltd') }}">


    <title>@yield('title', setting('site_name', 'Octosync Software Ltd'))</title>
    @if (setting('site_favicon'))
        <link rel="icon" href="{{ Storage::url(setting('site_favicon')) }}" type="image/x-icon">
    @else
        <link rel="icon" href="{{ asset('assets/logo/icon.png') }}" type="image/x-icon">
    @endif

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- <link rel="preload" as="style" href="{{ asset('build/assets/app-7c5c9473.css') }}" />
    <link rel="stylesheet" href="{{ asset('build/assets/app-7c5c9473.css') }}" />
    <link rel="modulepreload" href="{{ asset('build/assets/app-37a11075.js') }}" />
    <script type="module" src="{{ asset('build/assets/app-37a11075.js') }}"></script> --}}

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .product-card {
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
    @stack('styles')

    @if (setting('google_tag_manager_id'))
        <script>
            (function(w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start': new Date().getTime(),
                    event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s),
                    dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', '{{ setting('google_tag_manager_id') }}');
        </script>
    @endif

    @if (setting('facebook_pixel_id'))
        <script>
            ! function(f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function() {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ setting('facebook_pixel_id') }}');
            fbq('track', 'PageView');
        </script>
        <noscript>
            <img height="1" width="1" style="display:none"
                src="https://www.facebook.com/tr?id={{ setting('facebook_pixel_id') }}&ev=PageView&noscript=1" />
        </noscript>
    @endif

</head>

<body class="bg-gray-50">
    @if (setting('google_tag_manager_id'))
        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id={{ setting('google_tag_manager_id') }}"
                height="0" width="0" style="display:none;visibility:hidden"></iframe>
        </noscript>
    @endif

    <!-- Navigation -->
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <a href="{{ route('public.welcome') }}"
                        class="text-2xl font-bold text-indigo-600">{{ setting('site_name', 'Octosync Software Ltd') }}</a>
                </div>

                <div class="hidden md:flex space-x-8">
                    <a href="{{ route('public.welcome') }}"
                        class="text-gray-800 hover:text-indigo-600 font-medium">Home</a>
                    <a href="{{ route('public.products') }}"
                        class="text-gray-800 hover:text-indigo-600 font-medium">Products</a>

                    <div
                        class="hs-dropdown [--strategy:static] sm:[--strategy:absolute] [--adaptive:none] sm:[--trigger:hover] [--is-collapse:true] sm:[--is-collapse:false] relative">
                        <button id="hs-mega-menu-categories" type="button"
                            class="flex items-center w-full text-gray-800 font-medium hover:text-indigo-600 focus:outline-hidden focus:text-indigo-600 dark:text-neutral-400 dark:hover:text-neutral-500 dark:focus:text-neutral-500"
                            aria-haspopup="menu" aria-expanded="false" aria-label="Categories">
                            Categories
                            <svg class="hs-dropdown-open:-rotate-180 sm:hs-dropdown-open:rotate-0 duration-300 ms-auto sm:ms-1 shrink-0 size-4"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="m6 9 6 6 6-6" />
                            </svg>
                        </button>

                        <div class="hs-dropdown-menu sm:transition-[opacity,margin] sm:ease-in-out sm:duration-[350ms] hs-dropdown-open:opacity-100 opacity-0 hidden z-50 top-full left-1/2 transform -translate-x-1/2 sm:w-[800px] bg-gray-100 sm:shadow-lg rounded-lg py-4 sm:px-4 dark:bg-neutral-800 dark:border dark:border-neutral-700"
                            role="menu" aria-orientation="vertical" aria-labelledby="hs-mega-menu-categories">
                            <div class="sm:grid sm:grid-cols-4 gap-4">
                                <!-- Category Columns -->
                                @php
                                    $categories = App\Models\Category::where('is_active', true)->get();
                                    $chunkSize = ceil($categories->count() / 4);
                                    $categoryChunks = $categories->chunk($chunkSize);
                                @endphp

                                @foreach ($categoryChunks as $chunk)
                                    <div class="flex flex-col">
                                        @foreach ($chunk as $category)
                                            <a href="{{ route('public.categories.show', $category->slug) }}"
                                                class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-50 hover:text-indigo-600 focus:outline-hidden focus:bg-gray-50 dark:text-neutral-300 dark:hover:bg-neutral-700 dark:hover:text-white dark:focus:bg-neutral-700 transition-colors">
                                                @if ($category->image)
                                                    <img src="{{ Storage::url($category->image) }}"
                                                        alt="{{ $category->name }}" class="w-4 h-4 text-indigo-600">
                                                @else
                                                    <i class="fas fa-folder w-4 h-4 text-indigo-600"></i>
                                                @endif
                                                {{ $category->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>

                            <!-- View All Button -->
                            <div class="border-t border-gray-200 dark:border-neutral-700 mt-4 pt-4 px-4">
                                <a href="{{ route('public.categories') }}"
                                    class="w-full flex items-center justify-center gap-x-2 py-2 px-3 text-sm font-medium text-indigo-600 hover:text-indigo-700 hover:bg-indigo-50 rounded-lg transition-colors dark:text-indigo-400 dark:hover:text-indigo-300 dark:hover:bg-neutral-700">
                                    <span>View All Categories</span>
                                    <i class="fas fa-arrow-right text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('public.brands') }}"
                        class="text-gray-800 hover:text-indigo-600 font-medium">Brands</a>
                    <a href="{{ route('public.deals') }}"
                        class="text-gray-800 hover:text-indigo-600 font-medium">Deals</a>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- Search Button (Mobile) -->
                    <button class="md:hidden text-gray-800 hover:text-indigo-600" onclick="toggleMobileSearch()">
                        <i class="fas fa-search text-lg"></i>
                    </button>

                    <!-- Search Button (Desktop) -->
                    <button class="hidden md:block text-gray-800 hover:text-indigo-600" onclick="toggleSearch()">
                        <i class="fas fa-search text-lg"></i>
                    </button>

                    <!-- Cart Icon -->
                    @php
                        $sessionCart = App\Models\ShoppingCart::where('session_id', session()->getId())->first();
                        $cartCount = $sessionCart ? $sessionCart->items()->sum('quantity') : 0;
                    @endphp

                    <a href="{{ route('public.cart') }}" class="text-gray-800 hover:text-indigo-600 relative">
                        <i class="fas fa-shopping-cart text-lg"></i>
                        @if ($cartCount > 0)
                            <span
                                class="absolute -top-2 -right-2 bg-indigo-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <!-- Mobile Menu Button -->
                    <button class="md:hidden text-gray-800 hover:text-indigo-600" onclick="toggleMobileMenu()">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>

                <!-- Desktop Search Modal -->
                <div id="searchModal"
                    class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
                    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl">
                        <div class="p-4">
                            <div class="flex items-center">
                                <input type="text" id="searchInput" placeholder="Search products..."
                                    class="flex-1 px-4 py-3 border-0 focus:ring-0 focus:outline-none text-lg"
                                    onkeyup="performSearch(event)">
                                <button onclick="closeSearch()" class="ml-2 text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-times text-xl"></i>
                                </button>
                            </div>
                            <div id="searchResults" class="mt-4 max-h-60 overflow-y-auto hidden">
                                <!-- Search results will be populated here -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Search Bar -->
                <div id="mobileSearch"
                    class="md:hidden fixed top-0 left-0 right-0 bg-white p-4 shadow-md z-50 hidden">
                    <div class="flex items-center">
                        <input type="text" id="mobileSearchInput" placeholder="Search products..."
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-l-md focus:ring-indigo-500 focus:border-indigo-500"
                            onkeyup="performMobileSearch(event)">
                        <button onclick="closeMobileSearch()"
                            class="bg-gray-100 px-4 py-2 rounded-r-md text-gray-600 hover:text-gray-800">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div id="mobileSearchResults" class="mt-2 max-h-48 overflow-y-auto hidden">
                        <!-- Mobile search results will be populated here -->
                    </div>
                </div>

                <script>
                    // Search functionality
                    function toggleSearch() {
                        document.getElementById('searchModal').classList.toggle('hidden');
                        document.getElementById('searchInput').focus();
                    }

                    function closeSearch() {
                        document.getElementById('searchModal').classList.add('hidden');
                    }

                    function toggleMobileSearch() {
                        document.getElementById('mobileSearch').classList.toggle('hidden');
                        document.getElementById('mobileSearchInput').focus();
                    }

                    function closeMobileSearch() {
                        document.getElementById('mobileSearch').classList.add('hidden');
                    }

                    function performSearch(event) {
                        if (event.key === 'Enter') {
                            const query = document.getElementById('searchInput').value.trim();
                            if (query) {
                                window.location.href = `{{ route('public.search') }}?q=${encodeURIComponent(query)}`;
                            }
                        } else {
                            liveSearch('searchInput', 'searchResults');
                        }
                    }

                    function performMobileSearch(event) {
                        if (event.key === 'Enter') {
                            const query = document.getElementById('mobileSearchInput').value.trim();
                            if (query) {
                                window.location.href = `{{ route('public.search') }}?q=${encodeURIComponent(query)}`;
                            }
                        } else {
                            liveSearch('mobileSearchInput', 'mobileSearchResults');
                        }
                    }

                    function liveSearch(inputId, resultsId) {
                        const query = document.getElementById(inputId).value.trim();
                        const resultsContainer = document.getElementById(resultsId);

                        if (query.length < 2) {
                            resultsContainer.classList.add('hidden');
                            return;
                        }

                        fetch(`{{ route('public.search.live') }}?q=${encodeURIComponent(query)}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.length > 0) {
                                    let html = '<div class="space-y-2">';
                                    data.forEach(product => {
                                        // Get primary image or use placeholder
                                        const primaryImage = product.images && product.images.length > 0 ?
                                            product.images.find(img => img.is_primary) : null;

                                        const imageUrl = primaryImage ? primaryImage.image_url :
                                            'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0yMCAxM00yNi4wMjUxIDE2Ljk3NDlDMjcuMjU4MSAxOC4yMDc4IDI3LjI1ODEgMjAuMTkyMiAyNi4wMjUxIDIxLjQyNTFDMjQuNzkyMiAyMi42NTgxIDIyLjgwNzggMjIuNjU4MSAyMS41NzQ5IDIxLjQyNTFDMjAuMzQxOSAyMC4xOTIyIDIwLjM0MTkgMTguMjA3OCAyMS41NzQ5IDE2Ljk3NDlDMjIuODA3OCAxNS43NDE5IDI0Ljc5MjIgMTUuNzQxOSAyNi4wMjUxIDE2Ljk3NDkiIHN0cm9rZT0iIzlDQTBBQyIgc3Ryb2tlLXdpZHRoPSIxLjUiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8cGF0aCBkPSJNMTMuNSA2LjVDMTMuNSA1LjM5NTQzIDE0LjM5NTQgNC41IDE1LjUgNC41SDI0LjVDMjUuNjA0NiA0LjUgMjYuNSA1LjM5NTQzIDI2LjUgNi41VjEzLjUiIHN0cm9rZT0iIzlDQTBBQyIgc3Ryb2tlLXdpZHRoPSIxLjUiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8cGF0aCBkPSJNMTMuNSA0LjVWMTMuNUgyNC41VjQuNSIgc3Ryb2tlPSIjOUNBMEFDIiBzdHJva2Utd2lkdGg9IjEuNSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+Cjwvc3ZnPgo=';

                                        html += `
                                            <a href="{{ route('public.products.show', '') }}/${product.slug}" class="flex items-center p-2 hover:bg-gray-100 rounded-lg">
                                                <img src="${imageUrl}" 
                                                    alt="${product.name}" 
                                                    class="w-10 h-10 object-cover rounded"
                                                    onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0yMCAxM00yNi4wMjUxIDE2Ljk3NDlDMjcuMjU4MSAxOC4yMDc4IDI3LjI1ODEgMjAuMTkyMiAyNi4wMjUxIDIxLjQyNTFDMjQuNzkyMiAyMi42NTgxIDIyLjgwNzggMjIuNjU4MSAyMS41NzQ5IDIxLjQyNTFDMjAuMzQxOSAyMC4xOTIyIDIwLjM0MTkgMTguMjA3OCAyMS41NzQ5IDE2Ljk3NDlDMjIuODA3OCAxNS43NDE5IDI0Ljc5MjIgMTUuNzQxOSAyNi4wMjUxIDE2Ljk3NDkiIHN0cm9rZT0iIzlDQTBBQyIgc3Ryb2tlLXdpZHRoPSIxLjUiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8cGF0aCBkPSJNMTMuNSA2LjVDMTMuNSA1LjM5NTQzIDE0LjM5NTQgNC41IDE1LjUgNC41SDI0LjVDMjUuNjA0NiA0LjUgMjYuNSA1LjM5NTQzIDI2LjUgNi41VjEzLjUiIHN0cm9rZT0iIzlDQTBBQyIgc3Ryb2tlLXdpZHRoPSIxLjUiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8cGF0aCBkPSJNMTMuNSA0LjVWMTMuNUgyNC41VjQuNSIgc3Ryb2tlPSIjOUNBMEFDIiBzdHJva2Utd2lkdGg9IjEuNSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+Cjwvc3ZnPgo=';">
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-900">${product.name}</div>
                                                    <div class="text-sm text-gray-600">${product.price_formatted}</div>
                                                </div>
                                            </a>
                                        `;
                                    });
                                    html += '</div>';
                                    resultsContainer.innerHTML = html;
                                    resultsContainer.classList.remove('hidden');
                                } else {
                                    resultsContainer.innerHTML =
                                        '<div class="p-4 text-center text-gray-500">No products found</div>';
                                    resultsContainer.classList.remove('hidden');
                                }
                            })
                            .catch(error => {
                                console.error('Search error:', error);
                                resultsContainer.innerHTML =
                                    '<div class="p-4 text-center text-gray-500">Search failed. Please try again.</div>';
                                resultsContainer.classList.remove('hidden');
                            });
                    }

                    // Close search when clicking outside
                    document.getElementById('searchModal').addEventListener('click', function(e) {
                        if (e.target.id === 'searchModal') {
                            closeSearch();
                        }
                    });

                    // Close search with Escape key
                    document.addEventListener('keydown', function(e) {
                        if (e.key === 'Escape') {
                            closeSearch();
                            closeMobileSearch();
                        }
                    });
                </script>
            </div>
        </div>
    </nav>
