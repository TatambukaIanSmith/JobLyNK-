<!-- Footer -->
<footer class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white relative overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-primary via-yellow-400 to-blue-secondary"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid md:grid-cols-2 lg:grid-cols-5 gap-12 mb-12">
            <!-- Brand Section -->
            <div class="lg:col-span-2">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-primary to-blue-secondary rounded-xl flex items-center justify-center shadow-lg">
                        <img src="{{ asset('job-lynk-logo.png') }}" alt="Logo" class="w-10 h-10 object-contain">
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-blue-400 to-yellow-300 bg-clip-text text-transparent">JOB-lyNK</span>
                </div>
                <p class="text-gray-400 mb-6 leading-relaxed">
                    Connecting talented individuals with amazing opportunities. Your dream job is just a click away.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="w-10 h-10 bg-white/10 hover:bg-blue-primary rounded-lg flex items-center justify-center transition-all duration-300 hover:scale-110">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-white/10 hover:bg-blue-400 rounded-lg flex items-center justify-center transition-all duration-300 hover:scale-110">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-white/10 hover:bg-pink-600 rounded-lg flex items-center justify-center transition-all duration-300 hover:scale-110">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-white/10 hover:bg-blue-700 rounded-lg flex items-center justify-center transition-all duration-300 hover:scale-110">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
            
            <!-- For Job Seekers -->
            <div>
                <h4 class="text-lg font-bold mb-6 text-white">For Job Seekers</h4>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('jobs') }}" class="text-gray-400 hover:text-yellow-300 transition-colors flex items-center group">
                            <i class="fas fa-chevron-right mr-2 text-xs group-hover:translate-x-1 transition-transform"></i>
                            Browse Jobs
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}" class="text-gray-400 hover:text-yellow-300 transition-colors flex items-center group">
                            <i class="fas fa-chevron-right mr-2 text-xs group-hover:translate-x-1 transition-transform"></i>
                            Create Profile
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('how-it-works') }}" class="text-gray-400 hover:text-yellow-300 transition-colors flex items-center group">
                            <i class="fas fa-chevron-right mr-2 text-xs group-hover:translate-x-1 transition-transform"></i>
                            How It Works
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-yellow-300 transition-colors flex items-center group">
                            <i class="fas fa-chevron-right mr-2 text-xs group-hover:translate-x-1 transition-transform"></i>
                            Career Resources
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- For Employers -->
            <div>
                <h4 class="text-lg font-bold mb-6 text-white">For Employers</h4>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('postjob') }}" class="text-gray-400 hover:text-yellow-300 transition-colors flex items-center group">
                            <i class="fas fa-chevron-right mr-2 text-xs group-hover:translate-x-1 transition-transform"></i>
                            Post a Job
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pricing') }}" class="text-gray-400 hover:text-yellow-300 transition-colors flex items-center group">
                            <i class="fas fa-chevron-right mr-2 text-xs group-hover:translate-x-1 transition-transform"></i>
                            Pricing Plans
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-yellow-300 transition-colors flex items-center group">
                            <i class="fas fa-chevron-right mr-2 text-xs group-hover:translate-x-1 transition-transform"></i>
                            Find Talent
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-yellow-300 transition-colors flex items-center group">
                            <i class="fas fa-chevron-right mr-2 text-xs group-hover:translate-x-1 transition-transform"></i>
                            Employer Resources
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Company -->
            <div>
                <h4 class="text-lg font-bold mb-6 text-white">Company</h4>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('about') }}" class="text-gray-400 hover:text-yellow-300 transition-colors flex items-center group">
                            <i class="fas fa-chevron-right mr-2 text-xs group-hover:translate-x-1 transition-transform"></i>
                            About Us
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="text-gray-400 hover:text-yellow-300 transition-colors flex items-center group">
                            <i class="fas fa-chevron-right mr-2 text-xs group-hover:translate-x-1 transition-transform"></i>
                            Contact Us
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('terms-of-service') }}" class="text-gray-400 hover:text-yellow-300 transition-colors flex items-center group">
                            <i class="fas fa-chevron-right mr-2 text-xs group-hover:translate-x-1 transition-transform"></i>
                            Terms of Service
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('privacy-policy') }}" class="text-gray-400 hover:text-yellow-300 transition-colors flex items-center group">
                            <i class="fas fa-chevron-right mr-2 text-xs group-hover:translate-x-1 transition-transform"></i>
                            Privacy Policy
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Newsletter Section -->
        <div class="bg-gradient-to-r from-blue-primary/20 to-blue-secondary/20 backdrop-blur-sm rounded-2xl p-8 mb-12 border border-white/10">
            <div class="grid md:grid-cols-2 gap-6 items-center">
                <div>
                    <h3 class="text-2xl font-bold mb-2">Stay Updated</h3>
                    <p class="text-gray-400">Subscribe to get the latest job alerts and career tips</p>
                </div>
                <form class="flex gap-2">
                    <input 
                        type="email" 
                        placeholder="Enter your email" 
                        class="flex-1 px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-300 backdrop-blur-sm">
                    <button type="submit" class="bg-yellow-400 hover:bg-yellow-300 text-blue-dark px-6 py-3 rounded-xl font-bold transition-all duration-300 hover:scale-105 shadow-lg">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Bottom Bar -->
        <div class="border-t border-white/10 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <p class="text-gray-400 text-sm">
                    &copy; 2026 JOB-lyNK. All rights reserved. Made with <i class="fas fa-heart text-red-500 mx-1"></i> in Uganda
                </p>
                <div class="flex items-center space-x-6 text-sm">
                    <a href="{{ route('terms-of-service') }}" class="text-gray-400 hover:text-yellow-300 transition-colors">Terms</a>
                    <a href="{{ route('privacy-policy') }}" class="text-gray-400 hover:text-yellow-300 transition-colors">Privacy</a>
                    <a href="{{ route('contact') }}" class="text-gray-400 hover:text-yellow-300 transition-colors">Support</a>
                </div>
            </div>
        </div>
    </div>
</footer>
