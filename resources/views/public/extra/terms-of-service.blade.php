<x-app-layout>
    <x-slot name="main">
        <!-- Terms of Service Page -->
        <div class="container mx-auto px-4 py-8 max-w-4xl">
            <div class="bg-white shadow-md rounded-lg p-6 md:p-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Terms of Service</h1>
                <div class="prose max-w-none">
                    <p class="text-gray-600 mb-4">Last updated: {{ date('F j, Y') }}</p>

                    <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-3">1. Agreement to Terms</h2>
                    <p class="text-gray-600 mb-4">By accessing or using our website, you agree to be bound by these Terms
                        of Service and all applicable laws and regulations.</p>

                    <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-3">2. Use License</h2>
                    <p class="text-gray-600 mb-4">Permission is granted to temporarily use the materials on our website
                        for personal, non-commercial transitory viewing only.</p>

                    <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-3">3. Account Creation</h2>
                    <p class="text-gray-600 mb-4">When you create an account with us, you must provide accurate and
                        complete information. You are responsible for safeguarding your password.</p>

                    <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-3">4. Product Information</h2>
                    <p class="text-gray-600 mb-4">We strive to display accurate product information, but we do not
                        warrant that product descriptions or other content is accurate, complete, or error-free.</p>

                    <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-3">5. Pricing and Payment</h2>
                    <p class="text-gray-600 mb-4">Prices for products are subject to change without notice. We reserve
                        the right to modify or discontinue services without notice.</p>

                    <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-3">6. Limitation of Liability</h2>
                    <p class="text-gray-600 mb-4">In no event shall {{ setting('site_name', 'Octosync Software Ltd') }}
                        be liable for any damages arising out of the use or inability to use the materials on our
                        website.</p>

                    <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-3">7. Governing Law</h2>
                    <p class="text-gray-600 mb-4">These terms and conditions are governed by and construed in accordance
                        with the laws of your country.</p>

                    <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-3">8. Changes to Terms</h2>
                    <p class="text-gray-600 mb-4">We may revise these Terms of Service at any time without notice. By
                        using this website, you are agreeing to be bound by the current version of these Terms.</p>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
