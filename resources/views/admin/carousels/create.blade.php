<x-admin-layout>
    @section('title', 'Create Carousel Slide')
    <x-slot name="main">
        <div class="container mx-auto px-4 py-6">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Create New Carousel Slide</h1>
                <p class="text-gray-600">Add a new slide to your homepage carousel</p>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <form action="{{ route('admin.carousels.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="p-6">
                        @include('admin.carousels.form')
                    </div>
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
                        <a href="{{ route('admin.carousels.index') }}"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg">
                            Cancel
                        </a>
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">
                            Create Slide
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </x-slot>
</x-admin-layout>
