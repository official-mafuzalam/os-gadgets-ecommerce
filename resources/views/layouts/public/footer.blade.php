 <!-- Newsletter -->
 <section class="py-16 bg-gray-100">
     <div class="container mx-auto px-4 text-center">
         <h2 class="text-3xl font-bold mb-4">Stay Updated</h2>
         <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">Subscribe to our newsletter for the latest product
             updates, exclusive deals, and tech news.</p>
         <form class="max-w-lg mx-auto flex flex-col md:flex-row gap-4">
             <input type="email" placeholder="Enter your email"
                 class="flex-grow px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
             <button type="submit"
                 class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-3 rounded-lg transition duration-300">Subscribe</button>
         </form>
     </div>
 </section>

 <!-- Footer -->
 <footer class="bg-gray-800 text-white pt-12 pb-8">
     <div class="container mx-auto px-4">
         <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
             <div>
                 <h3 class="text-xl font-bold mb-4">TechSphere</h3>
                 <p class="text-gray-400 mb-4">Your one-stop shop for the latest gadgets and electronics.</p>
                 <div class="flex space-x-4">
                     <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook-f"></i></a>
                     <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
                     <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                     <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-linkedin-in"></i></a>
                 </div>
             </div>

             <div>
                 <h3 class="text-lg font-semibold mb-4">Shop</h3>
                 <ul class="space-y-2">
                     <li><a href="#" class="text-gray-400 hover:text-white">Smartphones</a></li>
                     <li><a href="#" class="text-gray-400 hover:text-white">Laptops</a></li>
                     <li><a href="#" class="text-gray-400 hover:text-white">Tablets</a></li>
                     <li><a href="#" class="text-gray-400 hover:text-white">Wearables</a></li>
                     <li><a href="#" class="text-gray-400 hover:text-white">Accessories</a></li>
                 </ul>
             </div>

             <div>
                 <h3 class="text-lg font-semibold mb-4">Company</h3>
                 <ul class="space-y-2">
                     <li><a href="#" class="text-gray-400 hover:text-white">About Us</a></li>
                     <li><a href="#" class="text-gray-400 hover:text-white">Careers</a></li>
                     <li><a href="#" class="text-gray-400 hover:text-white">Contact Us</a></li>
                     <li><a href="#" class="text-gray-400 hover:text-white">Blog</a></li>
                     <li><a href="#" class="text-gray-400 hover:text-white">Press</a></li>
                 </ul>
             </div>

             <div>
                 <h3 class="text-lg font-semibold mb-4">Contact</h3>
                 <ul class="space-y-2">
                     <li class="text-gray-400"><i class="fas fa-map-marker-alt mr-2"></i> 123 Tech Street, San
                         Francisco, CA</li>
                     <li class="text-gray-400"><i class="fas fa-phone-alt mr-2"></i> +1 (555) 123-4567</li>
                     <li class="text-gray-400"><i class="fas fa-envelope mr-2"></i> support@techsphere.com</li>
                 </ul>
             </div>
         </div>

         <div class="border-t border-gray-700 pt-8 flex flex-col md:flex-row justify-between items-center">
             <a href="{{ route('admin.index',) }}" class="text-gray-400 text-sm mb-4 md:mb-0">© {{ date('Y') }} {{ config('app.name', 'OS Gadgets') }}.
                 All rights reserved.</a>
             <div class="flex space-x-6">
                 <a href="#" class="text-gray-400 hover:text-white text-sm">Privacy Policy</a>
                 <a href="#" class="text-gray-400 hover:text-white text-sm">Terms of Service</a>
                 <a href="#" class="text-gray-400 hover:text-white text-sm">Return Policy</a>
             </div>
         </div>
     </div>
 </footer>

 <!-- Shopping Cart Modal (Hidden by default) -->
 <div class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden" id="cartModal">
     <div class="absolute right-0 top-0 h-full w-full md:w-96 bg-white shadow-lg">
         <!-- Cart content would go here -->
     </div>
 </div>

 <script>
     // Simple JavaScript for interactive elements
     document.addEventListener('DOMContentLoaded', function() {
         // Product card hover effect
         const productCards = document.querySelectorAll('.product-card');
         productCards.forEach(card => {
             card.addEventListener('mouseenter', function() {
                 this.style.transform = 'translateY(-8px)';
                 this.style.boxShadow =
                     '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)';
             });

             card.addEventListener('mouseleave', function() {
                 this.style.transform = 'translateY(0)';
                 this.style.boxShadow = '';
             });
         });

         // Category card hover effect
         const categoryCards = document.querySelectorAll('.category-card');
         categoryCards.forEach(card => {
             card.addEventListener('mouseenter', function() {
                 this.style.transform = 'translateY(-5px)';
                 this.style.boxShadow = '0 10px 25px -5px rgba(0, 0, 0, 0.1)';
             });

             card.addEventListener('mouseleave', function() {
                 this.style.transform = 'translateY(0)';
                 this.style.boxShadow = '';
             });
         });
     });
 </script>
 </body>

 </html>
