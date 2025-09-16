<x-admin-layout>
    <x-slot name="main">
        <!-- Header -->
        <div class="bg-white shadow-sm rounded-lg mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-900">Site Settings</h1>
                    <button type="submit" form="settings-form"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i> Save Settings
                    </button>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <form id="settings-form" action="#" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- General Settings -->
                    <div class="bg-white shadow-sm rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900 flex items-center">
                                <i class="fas fa-cog mr-2 text-blue-600"></i> General Settings
                            </h2>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Site Name</label>
                                    <input type="text" name="site_name"
                                        value="{{ old('site_name', $settings['site_name'] ?? '') }}"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                        placeholder="Your Site Name">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                    <input type="email" name="email"
                                        value="{{ old('email', $settings['email'] ?? '') }}"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                        placeholder="contact@example.com">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Mobile Number</label>
                                <input type="text" name="mobile"
                                    value="{{ old('mobile', $settings['mobile'] ?? '') }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                    placeholder="+880 XXXX XXXXXX">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                <textarea name="address" rows="3"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                    placeholder="Full business address">{{ old('address', $settings['address'] ?? '') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Site Logo</label>
                                <div class="flex items-center space-x-4">
                                    @if ($settings['logo'] ?? false)
                                        <div class="w-16 h-16 rounded-lg overflow-hidden border border-gray-300">
                                            <img src="{{ Storage::url($settings['logo']) }}" alt="Site Logo"
                                                class="w-full h-full object-contain">
                                        </div>
                                    @endif
                                    <input type="file" name="logo" accept="image/*"
                                        class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Recommended: 200x60px PNG or JPG</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Favicon</label>
                                <div class="flex items-center space-x-4">
                                    @if ($settings['favicon'] ?? false)
                                        <div class="w-8 h-8 rounded-lg overflow-hidden border border-gray-300">
                                            <img src="{{ Storage::url($settings['favicon']) }}" alt="Favicon"
                                                class="w-full h-full object-contain">
                                        </div>
                                    @endif
                                    <input type="file" name="favicon" accept="image/*"
                                        class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Recommended: 32x32px ICO or PNG</p>
                            </div>
                        </div>
                    </div>

                    <!-- Analytics Settings -->
                    <div class="bg-white shadow-sm rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900 flex items-center">
                                <i class="fas fa-chart-line mr-2 text-green-600"></i> Analytics & Tracking
                            </h2>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Google Analytics ID</label>
                                <input type="text" name="google_analytics"
                                    value="{{ old('google_analytics', $settings['google_analytics'] ?? '') }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                    placeholder="G-XXXXXXXXXX">
                                <p class="text-xs text-gray-500 mt-1">Your Google Analytics tracking ID</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Facebook Pixel ID</label>
                                <input type="text" name="facebook_pixel"
                                    value="{{ old('facebook_pixel', $settings['facebook_pixel'] ?? '') }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                    placeholder="XXXXXXXXXXXXXXX">
                                <p class="text-xs text-gray-500 mt-1">Your Facebook Pixel ID</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Additional Tracking
                                    Code</label>
                                <textarea name="additional_tracking" rows="4"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 font-mono text-sm"
                                    placeholder="Paste your tracking code here">{{ old('additional_tracking', $settings['additional_tracking'] ?? '') }}</textarea>
                                <p class="text-xs text-gray-500 mt-1">Any additional tracking or analytics code</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Shipping Settings -->
                    <div class="bg-white shadow-sm rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900 flex items-center">
                                <i class="fas fa-truck mr-2 text-purple-600"></i> Shipping Settings
                            </h2>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Inside Dhaka Charge
                                    (TK)</label>
                                <input type="number" step="0.01" name="shipping_inside_dhaka"
                                    value="{{ old('shipping_inside_dhaka', $settings['shipping_inside_dhaka'] ?? '') }}"
                                    min="0"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                    placeholder="0.00">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Outside Dhaka Charge
                                    (TK)</label>
                                <input type="number" step="0.01" name="shipping_outside_dhaka"
                                    value="{{ old('shipping_outside_dhaka', $settings['shipping_outside_dhaka'] ?? '') }}"
                                    min="0"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                    placeholder="0.00">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Free Shipping Minimum
                                    (TK)</label>
                                <input type="number" step="0.01" name="free_shipping_minimum"
                                    value="{{ old('free_shipping_minimum', $settings['free_shipping_minimum'] ?? '') }}"
                                    min="0"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                    placeholder="0.00">
                                <p class="text-xs text-gray-500 mt-1">Order amount for free shipping (0 to disable)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media Links -->
                    <div class="bg-white shadow-sm rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900 flex items-center">
                                <i class="fas fa-share-alt mr-2 text-red-600"></i> Social Media Links
                            </h2>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                    <i class="fab fa-facebook text-blue-600 mr-2"></i> Facebook
                                </label>
                                <input type="url" name="social_facebook"
                                    value="{{ old('social_facebook', $settings['social_facebook'] ?? '') }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                    placeholder="https://facebook.com/yourpage">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                    <i class="fab fa-twitter text-blue-400 mr-2"></i> Twitter
                                </label>
                                <input type="url" name="social_twitter"
                                    value="{{ old('social_twitter', $settings['social_twitter'] ?? '') }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                    placeholder="https://twitter.com/yourpage">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                    <i class="fab fa-instagram text-pink-600 mr-2"></i> Instagram
                                </label>
                                <input type="url" name="social_instagram"
                                    value="{{ old('social_instagram', $settings['social_instagram'] ?? '') }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                    placeholder="https://instagram.com/yourpage">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                    <i class="fab fa-linkedin text-blue-700 mr-2"></i> LinkedIn
                                </label>
                                <input type="url" name="social_linkedin"
                                    value="{{ old('social_linkedin', $settings['social_linkedin'] ?? '') }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                    placeholder="https://linkedin.com/company/yourpage">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                    <i class="fab fa-youtube text-red-600 mr-2"></i> YouTube
                                </label>
                                <input type="url" name="social_youtube"
                                    value="{{ old('social_youtube', $settings['social_youtube'] ?? '') }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                    placeholder="https://youtube.com/yourchannel">
                            </div>
                        </div>
                    </div>

                    <!-- Save Button for Mobile -->
                    <div class="lg:hidden bg-white shadow-sm rounded-lg p-6">
                        <button type="submit"
                            class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                            <i class="fas fa-save mr-2"></i> Save All Settings
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- JavaScript for handling form -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('settings-form');

                form.addEventListener('submit', function(e) {
                    // Add loading state
                    const submitButton = form.querySelector('button[type="submit"]');
                    const originalText = submitButton.innerHTML;
                    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Saving...';
                    submitButton.disabled = true;

                    // Form will submit normally
                });

                // Image preview for logo and favicon
                const logoInput = document.querySelector('input[name="logo"]');
                const faviconInput = document.querySelector('input[name="favicon"]');

                if (logoInput) {
                    logoInput.addEventListener('change', function(e) {
                        previewImage(this, this.previousElementSibling);
                    });
                }

                if (faviconInput) {
                    faviconInput.addEventListener('change', function(e) {
                        previewImage(this, this.previousElementSibling);
                    });
                }

                function previewImage(input, previewContainer) {
                    if (input.files && input.files[0]) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            if (!previewContainer.querySelector('img')) {
                                const img = document.createElement('img');
                                img.className = 'w-full h-full object-contain';
                                previewContainer.appendChild(img);
                            }
                            previewContainer.querySelector('img').src = e.target.result;
                        }

                        reader.readAsDataURL(input.files[0]);
                    }
                }
            });
        </script>
    </x-slot>
</x-admin-layout>