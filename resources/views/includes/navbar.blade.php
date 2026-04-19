<!-- Navigation -->
<nav class="bg-gradient-to-r from-blue-primary via-blue-secondary to-blue-dark shadow-2xl sticky top-0 z-50 backdrop-blur-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo & Brand -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-all duration-300">
                        <img src="{{ asset('job-lynk-logo.png') }}" alt="Logo" class="w-10 h-10 object-contain">
                    </div>
                    <span class="text-white text-2xl font-bold group-hover:text-yellow-300 transition-colors">JOB-lyNK</span>
                </a>
            </div>
            
            <!-- Desktop Navigation Links -->
            <div class="hidden lg:flex items-center space-x-2">
                <a href="{{ route('home') }}" class="text-white hover:bg-white/10 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 {{ request()->routeIs('home') ? 'bg-white/20' : '' }}">
                    <i class="fas fa-home mr-2"></i>Home
                </a>
                <a href="{{ route('jobs') }}" class="text-white hover:bg-white/10 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 {{ request()->routeIs('jobs*') ? 'bg-white/20' : '' }}">
                    <i class="fas fa-briefcase mr-2"></i>Jobs
                </a>
                @auth
                @if(Auth::user()->role === 'worker')
                <a href="{{ route('nearby-jobs') }}" class="text-white hover:bg-white/10 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 {{ request()->routeIs('nearby-jobs') ? 'bg-white/20' : '' }}">
                    <i class="fas fa-map-marker-alt mr-2"></i>Nearby Jobs
                    <span class="ml-1 bg-green-500 text-white text-xs px-2 py-0.5 rounded-full">NEW</span>
                </a>
                @endif
                @endauth
                <a href="{{ route('how-it-works') }}" class="text-white hover:bg-white/10 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 {{ request()->routeIs('how-it-works') ? 'bg-white/20' : '' }}">
                    <i class="fas fa-info-circle mr-2"></i>How It Works
                </a>
                <a href="{{ route('pricing') }}" class="text-white hover:bg-white/10 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 {{ request()->routeIs('pricing') ? 'bg-white/20' : '' }}">
                    <i class="fas fa-tag mr-2"></i>Pricing
                </a>
                <a href="{{ route('about') }}" class="text-white hover:bg-white/10 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 {{ request()->routeIs('about') ? 'bg-white/20' : '' }}">
                    <i class="fas fa-users mr-2"></i>About
                </a>
            </div>
            
            <!-- Search Bar & Actions -->
            <div class="hidden lg:flex items-center space-x-4">
                <!-- Search Bar -->
                <div class="relative">
                    <form action="{{ route('jobs') }}" method="GET" id="navSearchForm" class="relative">
                        <input 
                            type="text" 
                            name="search" 
                            id="navSearchInput" 
                            placeholder="Search jobs..." 
                            class="bg-white/90 backdrop-blur-sm text-gray-800 placeholder-gray-500 border-2 border-white/30 rounded-xl px-4 py-2.5 pr-12 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:border-yellow-300 w-64 transition-all duration-300"
                            autocomplete="off">
                        <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-blue-primary hover:text-blue-secondary transition-colors">
                            <i class="fas fa-search text-lg"></i>
                        </button>
                    </form>
                    
                    <!-- Live Search Results -->
                    <div id="navSearchResults" class="hidden absolute z-50 w-96 mt-2 bg-white border border-gray-200 rounded-xl shadow-2xl max-h-[32rem] overflow-y-auto">
                        <div id="navSearchResultsContent" class="py-2">
                            <!-- Results populated by JavaScript -->
                        </div>
                    </div>
                </div>
                
                <!-- Auth Buttons -->
                <a href="{{ route('login') }}" class="text-white hover:text-yellow-300 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 whitespace-nowrap">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login
                </a>
                <a href="{{ route('register') }}" class="bg-yellow-400 hover:bg-yellow-300 text-blue-dark px-6 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 whitespace-nowrap">
                    <i class="fas fa-user-plus mr-2"></i>Get Started
                </a>
            </div>
            
            <!-- Mobile Menu Button -->
            <button id="mobileMenuBtn" class="lg:hidden text-white hover:text-yellow-300 transition-colors">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden lg:hidden bg-blue-dark/95 backdrop-blur-lg border-t border-white/10">
        <div class="px-4 pt-4 pb-6 space-y-2">
            <!-- Mobile Search -->
            <form action="{{ route('jobs') }}" method="GET" class="mb-4">
                <div class="relative">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Search jobs..." 
                        class="w-full bg-white/90 text-gray-800 placeholder-gray-500 border-2 border-white/30 rounded-xl px-4 py-3 pr-12 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-300">
                    <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-blue-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
            
            <a href="{{ route('home') }}" class="text-white hover:bg-white/10 block px-4 py-3 rounded-lg text-base font-medium transition-all">
                <i class="fas fa-home mr-3"></i>Home
            </a>
            <a href="{{ route('jobs') }}" class="text-white hover:bg-white/10 block px-4 py-3 rounded-lg text-base font-medium transition-all">
                <i class="fas fa-briefcase mr-3"></i>Find Jobs
            </a>
            @auth
            @if(Auth::user()->role === 'worker')
            <a href="{{ route('nearby-jobs') }}" class="text-white hover:bg-white/10 block px-4 py-3 rounded-lg text-base font-medium transition-all">
                <i class="fas fa-map-marker-alt mr-3"></i>Nearby Jobs
                <span class="ml-2 bg-green-500 text-white text-xs px-2 py-0.5 rounded-full">NEW</span>
            </a>
            @endif
            @endauth
            <a href="{{ route('how-it-works') }}" class="text-white hover:bg-white/10 block px-4 py-3 rounded-lg text-base font-medium transition-all">
                <i class="fas fa-info-circle mr-3"></i>How It Works
            </a>
            <a href="{{ route('pricing') }}" class="text-white hover:bg-white/10 block px-4 py-3 rounded-lg text-base font-medium transition-all">
                <i class="fas fa-tag mr-3"></i>Pricing
            </a>
            <a href="{{ route('about') }}" class="text-white hover:bg-white/10 block px-4 py-3 rounded-lg text-base font-medium transition-all">
                <i class="fas fa-users mr-3"></i>About
            </a>
            <div class="pt-4 border-t border-white/10 space-y-2">
                <a href="{{ route('login') }}" class="text-white hover:bg-white/10 block px-4 py-3 rounded-lg text-base font-medium transition-all">
                    <i class="fas fa-sign-in-alt mr-3"></i>Login
                </a>
                <a href="{{ route('register') }}" class="bg-yellow-400 text-blue-dark block px-4 py-3 rounded-lg text-base font-bold text-center transition-all">
                    <i class="fas fa-user-plus mr-3"></i>Get Started
                </a>
            </div>
        </div>
    </div>
</nav>

<script>
    // Mobile menu toggle
    document.getElementById('mobileMenuBtn')?.addEventListener('click', function() {
        const menu = document.getElementById('mobileMenu');
        menu.classList.toggle('hidden');
    });
    
    // Live search functionality
    let searchTimeout;
    const searchInput = document.getElementById('navSearchInput');
    const searchResults = document.getElementById('navSearchResults');
    const searchResultsContent = document.getElementById('navSearchResultsContent');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();
            
            if (query.length < 2) {
                searchResults.classList.add('hidden');
                return;
            }
            
            // Show loading state
            searchResultsContent.innerHTML = '<div class="px-4 py-3 text-gray-500 text-sm flex items-center"><i class="fas fa-spinner fa-spin mr-2"></i>Searching...</div>';
            searchResults.classList.remove('hidden');
            
            searchTimeout = setTimeout(() => {
                fetch(`/jobs/search?q=${encodeURIComponent(query)}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(jobs => {
                        if (jobs && jobs.length > 0) {
                            searchResultsContent.innerHTML = jobs.map(job => `
                                <a href="/jobs/${job.id}" class="block px-4 py-3 hover:bg-blue-50 transition-colors border-b border-gray-100 last:border-0">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="font-semibold text-gray-900 mb-1">${job.title}</div>
                                            <div class="text-sm text-gray-600">
                                                <i class="fas fa-building mr-1 text-blue-primary"></i>${job.company_name || 'Company'}
                                                <span class="mx-2">•</span>
                                                <i class="fas fa-map-marker-alt mr-1 text-blue-primary"></i>${job.location}
                                            </div>
                                            <div class="text-sm text-gray-500 mt-1">
                                                <i class="fas fa-clock mr-1"></i>${job.job_type}
                                                <span class="mx-2">•</span>
                                                <i class="fas fa-dollar-sign mr-1"></i>UGX ${Number(job.salary).toLocaleString()}
                                            </div>
                                        </div>
                                        ${job.is_urgent ? '<span class="ml-2 bg-red-100 text-red-600 text-xs px-2 py-1 rounded-full font-semibold">Urgent</span>' : ''}
                                    </div>
                                </a>
                            `).join('');
                            searchResults.classList.remove('hidden');
                        } else {
                            searchResultsContent.innerHTML = `
                                <div class="px-4 py-8 text-center">
                                    <i class="fas fa-search text-gray-300 text-3xl mb-2"></i>
                                    <div class="text-gray-500 text-sm">No jobs found for "${query}"</div>
                                    <a href="/jobs" class="text-blue-primary text-sm mt-2 inline-block hover:underline">Browse all jobs</a>
                                </div>
                            `;
                            searchResults.classList.remove('hidden');
                        }
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                        searchResultsContent.innerHTML = '<div class="px-4 py-3 text-red-500 text-sm"><i class="fas fa-exclamation-circle mr-2"></i>Error loading results. Please try again.</div>';
                    });
            }, 300);
        });
        
        // Close search results when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.classList.add('hidden');
            }
        });
        
        // Close search results when pressing Escape
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                searchResults.classList.add('hidden');
                searchInput.blur();
            }
        });
    }
</script>
