<x-app-layout>
    <x-slot name="main">
        <!-- Privacy Policy Page -->
        <div class="container mx-auto px-4 py-8 max-w-4xl">
            <div class="bg-white shadow-md rounded-lg p-6 md:p-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Privacy Policy</h1>
                <div class="prose max-w-none">
                    <p class="text-gray-600 mb-4">Last updated: {{ date('F j, Y') }}</p>

                    <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-3">1. Information We Collect</h2>
                    <p class="text-gray-600 mb-4">We collect information you provide directly to us, including when you
                        create an account, make a purchase, or contact us for support.</p>

                    <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-3">2. How We Use Your Information</h2>
                    <p class="text-gray-600 mb-4">We use the information we collect to provide, maintain, and improve our
                        services, to process transactions, and to communicate with you.</p>

                    <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-3">3. Information Sharing</h2>
                    <p class="text-gray-600 mb-4">We do not sell, trade, or otherwise transfer your personally
                        identifiable information to outside parties except trusted third parties who assist us in
                        operating our website.</p>

                    <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-3">4. Security</h2>
                    <p class="text-gray-600 mb-4">We implement a variety of security measures to maintain the safety of
                        your personal information when you place an order or enter, submit, or access your personal
                        information.</p>

                    <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-3">5. Cookies</h2>
                    <p class="text-gray-600 mb-4">We use cookies to help us remember and process the items in your
                        shopping cart and understand and save your preferences for future visits.</p>

                    <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-3">6. Changes to This Policy</h2>
                    <p class="text-gray-600 mb-4">We may update this privacy policy from time to time. We will notify
                        you of any changes by posting the new privacy policy on this page.</p>

                    <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-3">7. Contact Us</h2>
                    <p class="text-gray-600 mb-4">If you have any questions about this Privacy Policy, please contact us
                        at privacy@{{ request() - > getHost() }}.</p>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
