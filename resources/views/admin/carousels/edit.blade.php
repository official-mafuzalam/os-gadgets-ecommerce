<x-admin-layout>
    @section('title', 'Edit Carousel Slide')
    <x-slot name="main">
        <div class="container mx-auto px-4 py-6">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Edit Carousel Slide</h1>
                <p class="text-gray-600">Update your carousel slide details</p>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <form action="{{ route('admin.carousels.update', $carousel) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="p-6">
                        @include('admin.carousels.form', ['carousel' => $carousel])
                    </div>
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
                        <a href="{{ route('admin.carousels.index') }}"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg">
                            Cancel
                        </a>
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">
                            Update Slide
                        </button>
                    </div>
                </form>
            </div>

            <!-- Preview -->
            <div class="mt-8 bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Slide Preview</h2>
                    <p class="text-sm text-gray-600">How this slide will appear on the homepage</p>
                </div>
                <div class="p-6">
                    <div class="bg-gradient-to-r from-indigo-900 to-purple-800 text-white p-8 rounded-lg">
                        <div class="flex flex-col md:flex-row items-center">
                            <div class="md:w-1/2 mb-6 md:mb-0">
                                <h3 class="text-2xl font-bold mb-4" id="preview-title">{{ $carousel->title }}</h3>
                                <p class="text-lg mb-6" id="preview-description">{{ $carousel->description }}</p>
                                <div class="flex space-x-4">
                                    @if ($carousel->button_text)
                                        <span class="bg-indigo-600 text-white px-4 py-2 rounded"
                                            id="preview-primary-btn">{{ $carousel->button_text }}</span>
                                    @endif
                                    @if ($carousel->secondary_button_text)
                                        <span class="border-2 border-white text-white px-4 py-2 rounded"
                                            id="preview-secondary-btn">{{ $carousel->secondary_button_text }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="md:w-1/2">
                                <img src="{{ $carousel->image_url }}" alt="Preview"
                                    class="rounded-lg shadow-lg w-full max-w-md mx-auto" id="preview-image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Update preview in real-time
                    const titleInput = document.querySelector('input[name="title"]');
                    const descriptionInput = document.querySelector('textarea[name="description"]');
                    const primaryBtnInput = document.querySelector('input[name="button_text"]');
                    const secondaryBtnInput = document.querySelector('input[name="secondary_button_text"]');
                    const imageInput = document.querySelector('input[name="image"]');

                    if (titleInput) {
                        titleInput.addEventListener('input', function() {
                            document.getElementById('preview-title').textContent = this.value;
                        });
                    }

                    if (descriptionInput) {
                        descriptionInput.addEventListener('input', function() {
                            document.getElementById('preview-description').textContent = this.value;
                        });
                    }

                    if (primaryBtnInput) {
                        primaryBtnInput.addEventListener('input', function() {
                            const previewBtn = document.getElementById('preview-primary-btn');
                            if (this.value) {
                                previewBtn.textContent = this.value;
                                previewBtn.style.display = 'inline-block';
                            } else {
                                previewBtn.style.display = 'none';
                            }
                        });
                    }

                    if (secondaryBtnInput) {
                        secondaryBtnInput.addEventListener('input', function() {
                            const previewBtn = document.getElementById('preview-secondary-btn');
                            if (this.value) {
                                previewBtn.textContent = this.value;
                                previewBtn.style.display = 'inline-block';
                            } else {
                                previewBtn.style.display = 'none';
                            }
                        });
                    }

                    if (imageInput) {
                        imageInput.addEventListener('change', function() {
                            if (this.files && this.files[0]) {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    document.getElementById('preview-image').src = e.target.result;
                                }
                                reader.readAsDataURL(this.files[0]);
                            }
                        });
                    }
                });
            </script>
        @endpush
    </x-slot>
</x-admin-layout>