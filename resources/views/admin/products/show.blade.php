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
                        <button type="button" onclick="openDealAssignmentModal()"
                            class="px-3 py-2 text-sm font-medium rounded-md bg-purple-600 text-white hover:bg-purple-700 transition-colors">
                            Assign to Deals
                        </button>
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
                            <!-- Main Image -->
                            <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md p-4 mb-4 relative">
                                <img id="mainProductImage"
                                    src="{{ $product->images->first() ? Storage::url($product->images->first()->image_path) : 'https://via.placeholder.com/300' }}"
                                    alt="{{ $product->name }}" class="w-full h-80 object-contain">

                                <!-- Set Primary Button -->
                                <button type="button" onclick="openSetPrimaryModal()"
                                    class="absolute top-4 right-4 bg-indigo-600 text-white p-2 rounded-full shadow-md hover:bg-indigo-700 transition-colors"
                                    title="Set as primary image">
                                    <i class="fas fa-star text-sm"></i>
                                </button>
                            </div>

                            <!-- Image Gallery -->
                            @if ($product->images->count() > 0)
                                <div class="mt-4">
                                    <div class="flex justify-between items-center mb-3">
                                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Gallery Images
                                        </h3>
                                        <button type="button" onclick="openSetPrimaryModal()"
                                            class="text-xs text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                                            Set Primary Image
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-4 gap-3">
                                        <!-- Gallery images -->
                                        @foreach ($product->images as $index => $image)
                                            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-1.5 cursor-pointer shadow-sm transition-all duration-200 hover:border-indigo-400 hover:shadow-md relative group"
                                                onclick="changeMainImage('{{ Storage::url($image->image_path) }}')">
                                                <img src="{{ Storage::url($image->image_path) }}"
                                                    alt="Gallery image {{ $index + 1 }}"
                                                    class="h-20 w-full object-cover rounded">

                                                <!-- Primary Badge -->
                                                @if ($image->is_primary)
                                                    <span
                                                        class="absolute top-0 right-0 bg-indigo-500 text-white text-xs px-1.5 py-0.5 rounded-bl-lg rounded-tr-lg">
                                                        Primary
                                                    </span>
                                                @endif

                                                <!-- Set Primary Button (shown on hover) -->
                                                <button type="button"
                                                    onclick="event.stopPropagation(); setAsPrimary({{ $image->id }})"
                                                    class="absolute bottom-1 left-1 bg-indigo-600 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition-opacity shadow-md"
                                                    title="Set as primary image">
                                                    <i class="fas fa-star text-xs"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Set Primary Image Modal -->
                        <div id="setPrimaryModal"
                            class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
                            <div
                                class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
                                <div class="p-6">
                                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Set Primary
                                        Image</h3>

                                    <div class="space-y-3 mb-6">
                                        @foreach ($product->images as $image)
                                            <div
                                                class="flex items-center justify-between p-3 border border-gray-200 dark:border-gray-700 rounded-lg">
                                                <div class="flex items-center space-x-3">
                                                    <img src="{{ Storage::url($image->image_path) }}" alt="Thumbnail"
                                                        class="w-12 h-12 object-cover rounded">
                                                    <span class="text-sm text-gray-700 dark:text-gray-300">
                                                        Image {{ $loop->iteration }}
                                                    </span>
                                                    @if ($image->is_primary)
                                                        <span
                                                            class="bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded-full">
                                                            Current Primary
                                                        </span>
                                                    @endif
                                                </div>
                                                <button type="button" onclick="setAsPrimary({{ $image->id }})"
                                                    class="px-3 py-1 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700 transition-colors {{ $image->is_primary ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                    {{ $image->is_primary ? 'disabled' : '' }}>
                                                    Set Primary
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="flex justify-end space-x-3">
                                        <button type="button" onclick="closeSetPrimaryModal()"
                                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
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
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Slug</dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-200">{{ $product->slug }}
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
                                        @if ($product->discount > 0)
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                                    Discount</dt>
                                                <dd class="text-sm text-gray-900 dark:text-gray-200">
                                                    ${{ number_format($product->discount, 2) }}</dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Final
                                                    Price</dt>
                                                <dd class="text-sm text-green-600 dark:text-green-400 font-semibold">
                                                    ${{ number_format($product->final_price, 2) }}</dd>
                                            </div>
                                        @endif
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Stock
                                                Quantity</dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-200">
                                                {{ $product->stock_quantity }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Stock
                                                Status</dt>
                                            <dd>
                                                <span @class([
                                                    'px-2 py-1 rounded-md text-xs font-medium',
                                                    'bg-green-500/10 text-green-600 dark:text-green-400' =>
                                                        $product->stock_quantity > 0,
                                                    'bg-red-500/10 text-red-600 dark:text-red-400' =>
                                                        $product->stock_quantity <= 0,
                                                ])>
                                                    {{ $product->stock_quantity > 0 ? 'In Stock' : 'Out of Stock' }}
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

                                <!-- Status Information -->
                                <div>
                                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Status</h3>
                                    <dl class="space-y-3">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Active
                                                Status</dt>
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
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Featured
                                                Status</dt>
                                            <dd>
                                                <span @class([
                                                    'px-2 py-1 rounded-md text-xs font-medium',
                                                    'bg-blue-500/10 text-blue-600 dark:text-blue-400' => $product->is_featured,
                                                    'bg-gray-500/10 text-gray-600 dark:text-gray-400' => !$product->is_featured,
                                                ])>
                                                    {{ $product->is_featured ? 'Featured' : 'Not Featured' }}
                                                </span>
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created At
                                            </dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-200">
                                                {{ $product->created_at->format('M d, Y h:i A') }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Updated At
                                            </dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-200">
                                                {{ $product->updated_at->format('M d, Y h:i A') }}</dd>
                                        </div>
                                    </dl>
                                </div>

                                <!-- Specifications -->
                                @if ($product->specifications && count($product->specifications) > 0)
                                    <div class="md:col-span-2">
                                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">
                                            Specifications</h3>
                                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            @foreach ($product->specifications as $key => $value)
                                                <div>
                                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                                        {{ ucfirst(str_replace('_', ' ', $key)) }}</dt>
                                                    <dd class="text-sm text-gray-900 dark:text-gray-200">
                                                        {{ $value }}</dd>
                                                </div>
                                            @endforeach
                                        </dl>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Deals Section -->
        <div class="w-full px-4 py-6 sm:px-6 lg:px-8">
            <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Assigned Deals</h3>

            @if ($product->deals->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($product->deals as $deal)
                        <div
                            class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-medium text-gray-900 dark:text-white">{{ $deal->title }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        Priority: {{ $deal->priority }}
                                    </p>
                                    <div class="mt-2 flex items-center">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $deal->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $deal->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                        @if ($deal->pivot->is_featured)
                                            <span
                                                class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                Featured
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <form action="{{ route('admin.products.deals.remove', [$product->id, $deal->id]) }}"
                                    method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Are you sure you want to remove this product from the deal?')"
                                        class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="mt-3 text-xs text-gray-500">
                                @if ($deal->starts_at && $deal->ends_at)
                                    {{ $deal->starts_at->format('M d, Y') }} - {{ $deal->ends_at->format('M d, Y') }}
                                @elseif($deal->starts_at)
                                    Starts: {{ $deal->starts_at->format('M d, Y') }}
                                @elseif($deal->ends_at)
                                    Ends: {{ $deal->ends_at->format('M d, Y') }}
                                @else
                                    No date restrictions
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div
                    class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-6 text-center">
                    <i class="fas fa-tag text-gray-400 text-3xl mb-2"></i>
                    <p class="text-gray-600 dark:text-gray-300">This product is not assigned to any deals yet.</p>
                    <button type="button" onclick="openDealAssignmentModal()"
                        class="mt-3 px-4 py-2 text-sm font-medium rounded-md bg-purple-600 text-white hover:bg-purple-700 transition-colors">
                        Assign to Deals
                    </button>
                </div>
            @endif
        </div>

        <!-- Deal Assignment Modal -->
        <div id="dealAssignmentModal"
            class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div
                class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white dark:bg-gray-800">
                <div class="mt-3">
                    <div class="flex justify-between items-center pb-3 border-b">
                        <h3 class="text-xl font-medium text-gray-900 dark:text-white">Assign Product to Deals</h3>
                        <button onclick="closeDealAssignmentModal()" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <form id="dealAssignmentForm" action="{{ route('admin.products.deals.assign', $product->id) }}"
                        method="POST" class="mt-4">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Select Deals to Assign This Product To:
                            </label>
                            <div class="max-h-60 overflow-y-auto border border-gray-300 rounded-md p-2">
                                @foreach ($allDeals as $deal)
                                    <div class="flex items-center p-2 hover:bg-gray-50 dark:hover:bg-gray-700 rounded">
                                        <input type="checkbox" name="deal_ids[]" value="{{ $deal->id }}"
                                            {{ $product->deals->contains($deal->id) ? 'checked' : '' }}
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                            {{ $deal->title }}
                                            <span class="text-xs text-gray-500">(Priority:
                                                {{ $deal->priority }})</span>
                                            @if ($deal->is_active)
                                                <span
                                                    class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Active
                                                </span>
                                            @endif
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('deal_ids')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                            <button type="button" onclick="closeDealAssignmentModal()"
                                class="px-4 py-2 text-sm font-medium rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600 transition-colors">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium rounded-md bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                                Save Assignments
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function changeMainImage(src) {
                const mainImage = document.getElementById('mainProductImage');

                // Add fade transition
                mainImage.style.opacity = '0';

                setTimeout(() => {
                    mainImage.src = src;
                    mainImage.style.opacity = '1';
                }, 200);

                // Update active thumbnail styling
                document.querySelectorAll('.border-2').forEach(el => {
                    el.classList.remove('border-2', 'border-indigo-500');
                    el.classList.add('border', 'border-gray-200', 'dark:border-gray-600');
                });

                // Find the clicked thumbnail and update its styling
                const clickedElement = event.currentTarget;
                clickedElement.classList.remove('border', 'border-gray-200', 'dark:border-gray-600');
                clickedElement.classList.add('border-2', 'border-indigo-500');
            }

            // Initialize with smooth transition
            document.addEventListener('DOMContentLoaded', function() {
                const mainImage = document.getElementById('mainProductImage');
                mainImage.style.transition = 'opacity 0.2s ease-in-out';
            });

            // Set Primary Image Functions
            function openSetPrimaryModal() {
                document.getElementById('setPrimaryModal').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function closeSetPrimaryModal() {
                document.getElementById('setPrimaryModal').classList.add('hidden');
                document.body.style.overflow = 'auto';
            }

            function setAsPrimary(imageId) {
                // Show loading state
                const buttons = document.querySelectorAll(`button[onclick="setAsPrimary(${imageId})"]`);
                buttons.forEach(button => {
                    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    button.disabled = true;
                });

                // Send AJAX request
                fetch('{{ route('admin.products.set-primary-image', $product->id) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            image_id: imageId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Reload the page to see changes
                            window.location.reload();
                        } else {
                            alert('Error: ' + (data.message || 'Failed to set primary image'));
                            // Reset buttons
                            buttons.forEach(button => {
                                button.innerHTML = 'Set Primary';
                                button.disabled = false;
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while setting the primary image');
                        // Reset buttons
                        buttons.forEach(button => {
                            button.innerHTML = 'Set Primary';
                            button.disabled = false;
                        });
                    });
            }

            // Close modal when clicking outside
            document.getElementById('setPrimaryModal').addEventListener('click', function(e) {
                if (e.target.id === 'setPrimaryModal') {
                    closeSetPrimaryModal();
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !document.getElementById('setPrimaryModal').classList.contains('hidden')) {
                    closeSetPrimaryModal();
                }
            });
        </script>

        <script>
            function openDealAssignmentModal() {
                document.getElementById('dealAssignmentModal').classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeDealAssignmentModal() {
                document.getElementById('dealAssignmentModal').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            // Close modal when clicking outside
            document.getElementById('dealAssignmentModal').addEventListener('click', function(e) {
                if (e.target.id === 'dealAssignmentModal') {
                    closeDealAssignmentModal();
                }
            });
        </script>
    </x-slot>
</x-admin-layout>
