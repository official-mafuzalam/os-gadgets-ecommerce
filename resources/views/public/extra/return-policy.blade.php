<x-app-layout>
    <x-slot name="main">
        <!-- Return Policy Page -->
        <div class="container mx-auto px-4 py-8 max-w-4xl">
            <div class="bg-white shadow-md rounded-lg p-6 md:p-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Return Policy</h1>
                <div class="prose max-w-none">
                    <p class="text-gray-600 mb-4">Last updated: {{ date('F j, Y') }}</p>

                    <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-3">1. Return Eligibility</h2>
                    <p class="text-gray-600 mb-4">We accept returns within 30 days of purchase. Items must be unused, in
                        their original packaging, and with all tags attached.</p>

                    <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-3">2. Non-Returnable Items</h2>
                    <p class="text-gray-600 mb-4">The following items cannot be returned: digital products, personalized
                        items, perishable goods, and items marked as final sale.</p>

                    <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-3">3. Return Process</h2>
                    <p class="text-gray-600 mb-4">To initiate a return, please contact our customer service team with
                        your order number. We will provide you with return instructions.</p>

                    <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-3">4. Refunds</h2>
                    <p class="text-gray-600 mb-4">Once we receive your returned item, we will inspect it and process
                        your refund within 5-7 business days. The refund will be issued to your original payment method.
                    </p>

                    <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-3">5. Exchanges</h2>
                    <p class="text-gray-600 mb-4">We are happy to exchange items for a different size or color, subject
                        to availability. Please contact us for exchange instructions.</p>

                    <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-3">6. Shipping Costs</h2>
                    <p class="text-gray-600 mb-4">Original shipping costs are non-refundable. Customers are responsible
                        for return shipping costs unless the return is due to our error.</p>

                    <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-3">7. Damaged or Defective Items</h2>
                    <p class="text-gray-600 mb-4">If you receive a damaged or defective item, please contact us within 7
                        days of receipt. We will arrange for a replacement or refund at no additional cost to you.</p>

                    <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-3">8. Contact Us</h2>
                    <p class="text-gray-600 mb-4">If you have any questions about our return policy, please contact us
                        at returns@{{ request() - > getHost() }}.</p>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>