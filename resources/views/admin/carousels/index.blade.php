<x-admin-layout>
    @section('title', 'Carousel Management')
    <x-slot name="main">
        <div class="container mx-auto px-4 py-6">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Carousel Management</h1>
                    <p class="text-gray-600">Manage your homepage carousel slides</p>
                </div>
                <a href="{{ route('admin.carousels.create') }}"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg mt-4 md:mt-0 inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i> Add New Slide
                </a>
            </div>

            <!-- Carousel Items -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                @if ($carousels->isEmpty())
                    <div class="p-8 text-center">
                        <i class="fas fa-images text-4xl text-gray-300 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No carousel slides yet</h3>
                        <p class="text-gray-600 mb-4">Get started by creating your first carousel slide.</p>
                        <a href="{{ route('admin.carousels.create') }}"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                            <i class="fas fa-plus mr-2"></i> Create First Slide
                        </a>
                    </div>
                @else
                    <div id="sortable-carousels">
                        @foreach ($carousels as $carousel)
                            <div class="border-b border-gray-200 last:border-b-0" data-id="{{ $carousel->id }}">
                                <div class="p-4 flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <span class="drag-handle cursor-move text-gray-400 hover:text-gray-600">
                                            <i class="fas fa-bars"></i>
                                        </span>
                                        <div class="w-16 h-12 bg-gray-200 rounded overflow-hidden">
                                            <img src="{{ $carousel->image_url }}" alt="{{ $carousel->title }}"
                                                class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-900">{{ $carousel->title }}</h4>
                                            <p class="text-sm text-gray-600">
                                                {{ Str::limit($carousel->description, 50) }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full {{ $carousel->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $carousel->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                        <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">
                                            Order: {{ $carousel->order }}
                                        </span>
                                        <a href="{{ route('admin.carousels.edit', $carousel) }}"
                                            class="text-indigo-600 hover:text-indigo-800">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.carousels.destroy', $carousel) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800"
                                                onclick="return confirm('Are you sure you want to delete this carousel slide?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Instructions -->
            @if ($carousels->isNotEmpty())
                <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Drag & Drop Reordering</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p>Drag the handle (<i class="fas fa-bars text-blue-600"></i>) to reorder carousel
                                    slides. Changes are saved automatically.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const sortable = new Sortable(document.getElementById('sortable-carousels'), {
                        handle: '.drag-handle',
                        animation: 150,
                        onEnd: function(evt) {
                            const order = Array.from(evt.from.children).map((child, index) => {
                                return child.dataset.id;
                            });

                            fetch('{{ route('admin.carousels.reorder') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        order: order
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        // Update order numbers in UI
                                        document.querySelectorAll('[data-id]').forEach((item, index) => {
                                            const orderBadge = item.querySelector('.bg-blue-100');
                                            if (orderBadge) {
                                                orderBadge.textContent = `Order: ${index}`;
                                            }
                                        });
                                    }
                                });
                        }
                    });
                });
            </script>
        @endpush
    </x-slot>
</x-admin-layout>