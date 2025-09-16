@include('layouts.public.header')

<!-- Alert Messages -->
<!-- Success Notification -->
@if (session('success'))
    <div id="notification-success"
        class="fixed bottom-4 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center transition-all duration-300">
        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="ml-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                </path>
            </svg>
        </button>
    </div>
@endif

<!-- Error Notification -->
@if ($errors->any())
    <div id="notification-error"
        class="fixed bottom-4 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg flex flex-col transition-all duration-300">
        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        @foreach ($errors->all() as $error)
            <div class="text-sm font-medium">{{ $error }}</div>
        @endforeach
        <button onclick="this.parentElement.remove()" class="ml-4 mt-2 self-end">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                </path>
            </svg>
        </button>
    </div>
@endif

<!-- Page Heading -->
@if (isset($header))
    <header class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {{ $header }}
        </div>
    </header>
@endif
<!-- Page Content -->
@if (isset($main))
    <main>
        {{ $main }}
    </main>
@endif

@include('layouts.public.footer')
