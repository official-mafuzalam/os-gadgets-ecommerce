<x-app-layout>
    <x-slot name="main">
        <!-- Hero Section -->
        <div class="relative bg-gray-900 text-white overflow-hidden">
            <div class="max-w-7xl mx-auto">
                <div class="relative z-10 pb-8 bg-gray-900 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                    <div class="pt-10 px-4 sm:px-6 lg:px-8 lg:pt-16">
                        <div class="text-center lg:text-left">
                            <h1 class="text-4xl tracking-tight font-extrabold sm:text-5xl md:text-6xl">
                                <span class="block xl:inline">Our Story</span>
                            </h1>
                            <p class="mt-3 text-base text-gray-300 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto lg:mx-0">
                                Learn about our journey, values, and commitment to excellence.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
                <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full"
                    src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1000&q=80"
                    alt="Our team">
            </div>
        </div>

        <!-- About Content -->
        <div class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-base text-primary font-semibold tracking-wide uppercase">About Us</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        A better way to shop
                    </p>
                    <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                        Founded in 2010, our mission has always been to provide high-quality products with exceptional
                        customer service.
                    </p>
                </div>

                <div class="mt-16">
                    <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                        <div>
                            <img class="w-full h-96 object-cover rounded-lg"
                                src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1000&q=80"
                                alt="Our store">
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Our Journey</h3>
                            <p class="text-gray-600 mb-4">
                                What started as a small family business has grown into a trusted e-commerce platform
                                serving customers nationwide.
                                Our commitment to quality, customer satisfaction, and innovation has been the driving
                                force behind our success.
                            </p>
                            <p class="text-gray-600">
                                We carefully curate our product selection to ensure we offer only the best items to our
                                customers.
                                Every product in our inventory goes through a rigorous quality check process to meet our
                                high standards.
                            </p>
                            <div class="mt-6 grid grid-cols-2 gap-4">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="text-primary text-3xl font-bold">500K+</div>
                                    <div class="text-gray-600">Happy Customers</div>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="text-primary text-3xl font-bold">10K+</div>
                                    <div class="text-gray-600">Products</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Values Section -->
        <div class="py-12 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                        Our Values
                    </h2>
                    <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">
                        These principles guide everything we do
                    </p>
                </div>

                <div class="mt-10">
                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        <!-- Quality -->
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <div
                                    class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-medal text-white text-2xl"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 text-center">Quality</h3>
                                <p class="mt-2 text-sm text-gray-500 text-center">
                                    We are committed to offering only the highest quality products from trusted
                                    suppliers.
                                </p>
                            </div>
                        </div>

                        <!-- Customer Service -->
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <div
                                    class="w-16 h-16 bg-secondary rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-hands-helping text-white text-2xl"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 text-center">Customer Service</h3>
                                <p class="mt-2 text-sm text-gray-500 text-center">
                                    Our dedicated support team is always ready to assist you with any questions or
                                    concerns.
                                </p>
                            </div>
                        </div>

                        <!-- Fast Delivery -->
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <div
                                    class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-truck text-white text-2xl"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 text-center">Fast Delivery</h3>
                                <p class="mt-2 text-sm text-gray-500 text-center">
                                    We pride ourselves on quick order processing and reliable shipping methods.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Team Section -->
        <div class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                        Our Leadership
                    </h2>
                    <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">
                        The passionate people behind our success
                    </p>
                </div>

                <div class="mt-10 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Team Member 1 -->
                    <div class="bg-gray-50 overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="w-32 h-32 rounded-full mx-auto mb-4 overflow-hidden">
                                <img class="w-full h-full object-cover"
                                    src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=400&q=80"
                                    alt="Team member">
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 text-center">Sarah Johnson</h3>
                            <p class="text-sm text-primary text-center">CEO & Founder</p>
                            <p class="mt-2 text-sm text-gray-500 text-center">
                                Sarah founded the company with a vision to revolutionize online shopping.
                            </p>
                        </div>
                    </div>

                    <!-- Team Member 2 -->
                    <div class="bg-gray-50 overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="w-32 h-32 rounded-full mx-auto mb-4 overflow-hidden">
                                <img class="w-full h-full object-cover"
                                    src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=400&q=80"
                                    alt="Team member">
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 text-center">Michael Chen</h3>
                            <p class="text-sm text-primary text-center">Chief Operations Officer</p>
                            <p class="mt-2 text-sm text-gray-500 text-center">
                                Michael ensures our operations run smoothly and efficiently.
                            </p>
                        </div>
                    </div>

                    <!-- Team Member 3 -->
                    <div class="bg-gray-50 overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="w-32 h-32 rounded-full mx-auto mb-4 overflow-hidden">
                                <img class="w-full h-full object-cover"
                                    src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=400&q=80"
                                    alt="Team member">
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 text-center">Emily Rodriguez</h3>
                            <p class="text-sm text-primary text-center">Head of Customer Experience</p>
                            <p class="mt-2 text-sm text-gray-500 text-center">
                                Emily leads our customer service team to deliver exceptional support.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-primary">
            <div
                class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
                <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                    <span class="block">Ready to explore?</span>
                    <span class="block text-primary-200">Start shopping with us today.</span>
                </h2>
                <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                    <div class="inline-flex rounded-md shadow">
                        <a href="#"
                            class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-primary bg-white hover:bg-gray-50">
                            Shop Now
                        </a>
                    </div>
                    <div class="ml-3 inline-flex rounded-md shadow">
                        <a href="#"
                            class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700">
                            Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
