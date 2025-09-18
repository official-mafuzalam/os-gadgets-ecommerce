<x-app-layout>
    <x-slot name="main">
        <!-- Hero Section -->
        <div class="relative bg-gray-900 text-white overflow-hidden">
            <div class="max-w-7xl mx-auto">
                <div class="relative z-10 pb-8 bg-gray-900 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                    <div class="pt-10 px-4 sm:px-6 lg:px-8 lg:pt-16">
                        <div class="text-center lg:text-left">
                            <h1 class="text-4xl tracking-tight font-extrabold sm:text-5xl md:text-6xl">
                                <span class="block xl:inline">Get in Touch</span>
                            </h1>
                            <p class="mt-3 text-base text-gray-300 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto lg:mx-0">
                                We'd love to hear from you. Reach out to us through any of the following channels.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
                <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full"
                    src="https://images.unsplash.com/photo-1516387938699-a93567ec168e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1000&q=80"
                    alt="Customer support">
            </div>
        </div>

        <!-- Contact Content -->
        <div class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <!-- Contact Form -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Send us a Message</h2>
                        <form class="space-y-6">
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First
                                        Name</label>
                                    <input type="text" id="first_name"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                        placeholder="Your first name">
                                </div>
                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last
                                        Name</label>
                                    <input type="text" id="last_name"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                        placeholder="Your last name">
                                </div>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email
                                    Address</label>
                                <input type="email" id="email"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                    placeholder="your.email@example.com">
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number
                                    (Optional)</label>
                                <input type="tel" id="phone"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                    placeholder="+1 (555) 123-4567">
                            </div>
                            <div>
                                <label for="subject"
                                    class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                                <select id="subject"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                    <option value="">Select a subject</option>
                                    <option value="general">General Inquiry</option>
                                    <option value="product">Product Question</option>
                                    <option value="order">Order Issue</option>
                                    <option value="return">Return & Exchange</option>
                                    <option value="shipping">Shipping Question</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div>
                                <label for="message"
                                    class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                                <textarea id="message" rows="5"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                    placeholder="How can we help you?"></textarea>
                            </div>
                            <div>
                                <button type="submit"
                                    class="w-full bg-primary text-white py-3 px-4 rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 font-medium">
                                    Send Message
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Contact Information -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Contact Information</h2>

                        <div class="bg-gray-50 p-6 rounded-lg mb-6">
                            <div class="flex items-start mb-6">
                                <div
                                    class="w-10 h-10 bg-primary rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-map-marker-alt text-white"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Address</p>
                                    <p class="text-gray-600">
                                        {{ setting('site_address', 'Mirpur 2, Dhaka') }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-start mb-6">
                                <div
                                    class="w-10 h-10 bg-primary rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-phone text-white"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Phone</p>
                                    <p class="text-gray-600">{{ setting('site_phone', '+8801621833839') }}</p>
                                    <p class="text-sm text-gray-500">Sat-Thu from 9am to 6pm</p>
                                </div>
                            </div>
                            <div class="flex items-start mb-6">
                                <div
                                    class="w-10 h-10 bg-primary rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-envelope text-white"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Email</p>
                                    <p class="text-gray-600">{{ setting('site_email', 'support@octosyncsoftware.com') }}
                                    </p>
                                    <p class="text-sm text-gray-500">We'll respond within 24 hours</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div
                                    class="w-10 h-10 bg-primary rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-clock text-white"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Business Hours</p>
                                    <p class="text-gray-600">Saturday-Thursday: 9am-6pm<br>Friday: 10am-4pm<br>Friday:
                                        Closed</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Follow Us</h3>
                            <div class="flex space-x-4">
                                <a href="#"
                                    class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white hover:bg-blue-700 transition-colors">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#"
                                    class="w-10 h-10 bg-pink-600 rounded-full flex items-center justify-center text-white hover:bg-pink-700 transition-colors">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#"
                                    class="w-10 h-10 bg-blue-400 rounded-full flex items-center justify-center text-white hover:bg-blue-500 transition-colors">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#"
                                    class="w-10 h-10 bg-red-600 rounded-full flex items-center justify-center text-white hover:bg-red-700 transition-colors">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="py-12 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                        Frequently Asked Questions
                    </h2>
                    <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">
                        Find quick answers to common questions
                    </p>
                </div>

                <div class="mt-12 max-w-3xl mx-auto">
                    <div class="space-y-4">
                        <!-- FAQ Item 1 -->
                        <div class="bg-white shadow rounded-lg overflow-hidden">
                            <button class="w-full px-6 py-4 text-left focus:outline-none">
                                <div class="flex items-center justify-between">
                                    <span class="font-medium text-gray-900">How long does shipping take?</span>
                                    <i class="fas fa-chevron-down text-primary"></i>
                                </div>
                            </button>
                            <div class="px-6 pb-4">
                                <p class="text-gray-600">Standard shipping typically takes 3-5 business days within the
                                    continental US. Express shipping is available for an additional fee and delivers
                                    within 1-2 business days.</p>
                            </div>
                        </div>

                        <!-- FAQ Item 2 -->
                        <div class="bg-white shadow rounded-lg overflow-hidden">
                            <button class="w-full px-6 py-4 text-left focus:outline-none">
                                <div class="flex items-center justify-between">
                                    <span class="font-medium text-gray-900">What is your return policy?</span>
                                    <i class="fas fa-chevron-down text-primary"></i>
                                </div>
                            </button>
                            <div class="px-6 pb-4">
                                <p class="text-gray-600">We offer a 30-day return policy for all unused items in their
                                    original packaging. Returns are free for customers within the US. Please contact our
                                    support team to initiate a return.</p>
                            </div>
                        </div>

                        <!-- FAQ Item 3 -->
                        <div class="bg-white shadow rounded-lg overflow-hidden">
                            <button class="w-full px-6 py-4 text-left focus:outline-none">
                                <div class="flex items-center justify-between">
                                    <span class="font-medium text-gray-900">Do you ship internationally?</span>
                                    <i class="fas fa-chevron-down text-primary"></i>
                                </div>
                            </button>
                            <div class="px-6 pb-4">
                                <p class="text-gray-600">Yes, we ship to over 50 countries worldwide. International
                                    shipping rates and delivery times vary by destination. Additional customs fees may
                                    apply depending on your country's regulations.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map Section -->
        <div class="bg-white py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Visit Our Store</h2>
                <div class="rounded-lg overflow-hidden shadow-lg">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d100940.14245968236!2d-122.43759999999999!3d37.75769999999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80859a6d00690021%3A0x4a501367f076adff!2sSan%20Francisco%2C%20CA%2C%20USA!5e0!3m2!1sen!2s!4v1685061917892!5m2!1sen!2s"
                        width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
