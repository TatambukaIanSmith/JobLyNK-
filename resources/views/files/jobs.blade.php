<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Jobs - JOB-lyNK</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'blue-primary': '#1e40af',
                        'blue-secondary': '#3b82f6',
                        'blue-light': '#dbeafe',
                        'blue-dark': '#1e3a8a'
                    }
                }
            }
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Enhanced search bar styles */
        .search-input:focus {
            background-color: rgba(255, 255, 255, 0.95);
            color: #1e40af;
        }
        
        .search-input:focus::placeholder {
            color: #9ca3af;
        }
        
        .search-input:focus + .search-icon {
            color: #1e40af;
        }
        
        /* Search suggestions dropdown */
        .search-suggestions {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            max-height: 300px;
            overflow-y: auto;
        }
        
        .search-suggestion-item {
            padding: 0.75rem 1rem;
            cursor: pointer;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .search-suggestion-item:hover {
            background-color: #f9fafb;
        }
        
        .search-suggestion-item:last-child {
            border-bottom: none;
        }

        /* Glass Morphism Background */
        .glass-background {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            position: relative;
        }

        .glass-background::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(248, 250, 252, 0.4) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(241, 245, 249, 0.4) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(226, 232, 240, 0.4) 0%, transparent 50%);
            pointer-events: none;
        }

        /* Glass Morphism Cards */
        .glass-card {
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 16px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2);
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            background: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
            box-shadow: 0 12px 40px 0 rgba(31, 38, 135, 0.25);
        }

        /* Glass Morphism Filter Sidebar */
        .glass-filter {
            background: rgba(255, 255, 255, 0.35);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        }

        /* Glass Morphism Header */
        .glass-header {
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        }

        /* Enhanced text readability */
        .glass-text {
            color: #1a202c;
            text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);
        }

        .glass-text-light {
            color: #4a5568;
            text-shadow: 0 1px 2px rgba(255, 255, 255, 0.6);
        }

        /* Glass form inputs */
        .glass-input {
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 12px;
            color: #1a202c;
        }

        .glass-input:focus {
            background: rgba(255, 255, 255, 0.7);
            border-color: rgba(30, 64, 175, 0.5);
            outline: none;
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        .glass-input::placeholder {
            color: #4a5568;
        }

        /* Glass buttons */
        .glass-button {
            background: rgba(30, 64, 175, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(30, 64, 175, 0.4);
            border-radius: 12px;
            color: white;
            transition: all 0.3s ease;
        }

        .glass-button:hover {
            background: rgba(30, 64, 175, 1);
            transform: translateY(-1px);
            box-shadow: 0 4px 20px rgba(30, 64, 175, 0.4);
        }

        /* Glass stats cards */
        .glass-stat {
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 16px;
            box-shadow: 0 4px 24px 0 rgba(31, 38, 135, 0.1);
            transition: all 0.3s ease;
        }

        .glass-stat:hover {
            background: rgba(255, 255, 255, 0.6);
            transform: translateY(-1px);
        }

        /* Floating animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .floating {
            animation: float 6s ease-in-out infinite;
        }

        /* iOS-style bottom-to-top animation for job cards */
        @keyframes slideUpFade {
            0% {
                opacity: 0;
                transform: translateY(60px) scale(0.95);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .job-card {
            opacity: 0;
            transform: translateY(60px) scale(0.95);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }

        .job-card.animate-in {
            animation: slideUpFade 0.6s ease-out forwards;
        }

        /* Smooth transition for cards */
        .glass-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .glass-card, .glass-filter, .glass-header {
                backdrop-filter: blur(8px);
                -webkit-backdrop-filter: blur(8px);
            }
        }
    </style>
</head>
<body class="glass-background">
    <!-- Navigation -->
    <nav class="bg-blue-primary shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center p-1 shadow-sm">
                            <img src="{{ asset('job-lynk-logo.png') }}" alt="JOB-lyNK Logo" class="w-full h-full object-contain">
                        </div>
                        <span class="text-white text-2xl font-bold hover:text-blue-light">JOB-lyNK</span>
                    </a>
                    <div class="hidden md:block ml-10">
                        <div class="flex items-center">
                            <!-- Enhanced Search Bar -->
                            <div class="relative">
                                <form method="GET" action="{{ route('jobs') }}" class="flex items-center">
                                    <div class="relative">
                                        <input type="text" 
                                               name="search" 
                                               id="navSearchInput"
                                               value="{{ request('search') }}" 
                                               placeholder="Search jobs, keywords, companies..." 
                                               class="search-input w-96 pl-10 pr-4 py-2.5 bg-white bg-opacity-20 border border-white border-opacity-30 rounded-lg text-white placeholder-blue-100 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-50 focus:bg-opacity-95 transition-all duration-200"
                                               autocomplete="off">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-search text-blue-100 search-icon transition-colors duration-200"></i>
                                        </div>
                                        <!-- Search suggestions dropdown -->
                                        <div id="searchSuggestions" class="search-suggestions absolute top-full left-0 right-0 mt-1 hidden z-50">
                                            <!-- Suggestions will be populated by JavaScript -->
                                        </div>
                                    </div>
                                    <button type="submit" 
                                            class="ml-3 bg-blue-secondary hover:bg-blue-dark text-white px-5 py-2.5 rounded-lg transition-colors duration-200 flex items-center font-medium">
                                        <i class="fas fa-search mr-2"></i>
                                        Search
                                    </button>
                                    @if(request('search'))
                                        <a href="{{ route('jobs') }}" 
                                           class="ml-2 bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-3 py-2.5 rounded-lg transition-colors duration-200 flex items-center"
                                           title="Clear search">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <button class="text-white hover:text-blue-light">
                            <i class="fas fa-bell text-xl"></i>
                        </button>
                        <div class="relative group">
                            <button id="profileBtn" class="flex items-center text-white hover:text-blue-light focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md"
                                    aria-haspopup="true" aria-expanded="false">
                                <img class="h-8 w-8 rounded-full" src="{{ Auth::user()->getProfilePictureUrl() }}" alt="Profile">
                                <span class="ml-2">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down ml-1"></i>
                            </button>
                            <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20">
                                @if(Auth::user()->isWorker())
                                    <a href="{{ route('worker') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                                @elseif(Auth::user()->isEmployer())
                                    <a href="{{ route('employerDashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                                @endif
                                <a href="{{ route('settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-white hover:text-blue-light px-3 py-2 rounded-md text-sm font-medium">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue-secondary text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-dark">Sign Up</a>
                    @endauth
                </div>
            </div>
        </div>
        
        <!-- Mobile Search Bar -->
        <div class="md:hidden px-4 pb-4">
            <form method="GET" action="{{ route('jobs') }}" class="flex items-center space-x-2">
                <div class="relative flex-1">
                    <input type="text" 
                           name="search" 
                           id="mobileSearchInput"
                           value="{{ request('search') }}" 
                           placeholder="Search jobs..." 
                           class="search-input w-full pl-10 pr-4 py-2.5 bg-white bg-opacity-20 border border-white border-opacity-30 rounded-lg text-white placeholder-blue-100 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-50 focus:bg-opacity-95 transition-all duration-200"
                           autocomplete="off">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-blue-100 search-icon transition-colors duration-200"></i>
                    </div>
                </div>
                <button type="submit" 
                        class="bg-blue-secondary hover:bg-blue-dark text-white px-4 py-2.5 rounded-lg transition-colors duration-200 font-medium">
                    <i class="fas fa-search"></i>
                </button>
                @if(request('search'))
                    <a href="{{ route('jobs') }}" 
                       class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-3 py-2.5 rounded-lg transition-colors duration-200"
                       title="Clear search">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </form>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="glass-header p-6 mb-6">
            <h1 class="text-3xl font-bold glass-text">Find Jobs</h1>
            <p class="glass-text-light mt-1">Discover opportunities that match your skills</p>
            
            <!-- Job Statistics -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="glass-stat p-4 floating">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <i class="fas fa-briefcase text-blue-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium glass-text-light">Total Jobs</p>
                            <p class="text-2xl font-semibold glass-text">{{ $stats['total_jobs'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="glass-stat p-4 floating" style="animation-delay: 2s;">
                    <div class="flex items-center">
                        <div class="p-2 bg-red-100 rounded-lg">
                            <i class="fas fa-clock text-red-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium glass-text-light">Urgent Jobs</p>
                            <p class="text-2xl font-semibold glass-text">{{ $stats['urgent_jobs'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="glass-stat p-4 floating" style="animation-delay: 4s;">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <i class="fas fa-tags text-green-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium glass-text-light">Categories</p>
                            <p class="text-2xl font-semibold glass-text">{{ $stats['categories_count'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Filters Sidebar -->
            <div class="lg:col-span-1">
                <div class="glass-filter p-6 sticky top-6">
                    <h3 class="text-lg font-semibold glass-text mb-4">Filters</h3>
                    
                    <form method="GET" action="{{ route('jobs') }}" id="filterForm">
                        <!-- Search -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium glass-text mb-2">Search</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Job title, keywords..."
                                class="glass-input w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent">
                        </div>

                        <!-- Category -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium glass-text mb-2">Category</label>
                            <select name="category" class="glass-input w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Location -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium glass-text mb-2">Location</label>
                            <input type="text" name="location" value="{{ request('location') }}" placeholder="City, area..."
                                class="glass-input w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent">
                        </div>

                        <!-- Pay Range -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium glass-text mb-2">Pay Range (UGX)</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="number" name="min_budget" value="{{ request('min_budget') }}" placeholder="Min"
                                    class="glass-input px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent">
                                <input type="number" name="max_budget" value="{{ request('max_budget') }}" placeholder="Max"
                                    class="glass-input px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent">
                            </div>
                        </div>

                        <!-- Job Type -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium glass-text mb-2">Job Type</label>
                            <select name="job_type" class="glass-input w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent">
                                <option value="">All Types</option>
                                <option value="one-time" {{ request('job_type') == 'one-time' ? 'selected' : '' }}>One-time</option>
                                <option value="recurring" {{ request('job_type') == 'recurring' ? 'selected' : '' }}>Recurring</option>
                                <option value="project" {{ request('job_type') == 'project' ? 'selected' : '' }}>Project</option>
                            </select>
                        </div>

                        <!-- Urgent Only -->
                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="urgent_only" value="1" {{ request('urgent_only') ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-blue-primary focus:ring-blue-primary">
                                <span class="ml-2 text-sm glass-text-light">Urgent jobs only</span>
                            </label>
                        </div>

                        <button type="submit" class="glass-button w-full py-2 px-4 font-medium">
                            Apply Filters
                        </button>
                        
                        @if(request()->hasAny(['search', 'category', 'location', 'job_type', 'min_budget', 'max_budget', 'urgent_only']))
                            <a href="{{ route('jobs') }}" class="w-full mt-2 block text-center glass-input py-2 px-4 glass-text hover:bg-opacity-40 transition duration-300">
                                Clear Filters
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Jobs List -->
            <div class="lg:col-span-3">
                <!-- Sort and View Options -->
                <div class="flex items-center justify-between mb-6 glass-card p-4">
                    <div class="flex items-center space-x-4">
                        <span class="text-sm glass-text-light">{{ $jobs->total() }} jobs found</span>
                        <form method="GET" action="{{ route('jobs') }}" class="inline">
                            @foreach(request()->except(['sort', 'order']) as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            <select name="sort" onchange="this.form.submit()" class="glass-input border-0 px-3 py-1 text-sm">
                                <option value="created_at" {{ request('sort', 'created_at') == 'created_at' ? 'selected' : '' }}>Sort by: Newest</option>
                                <option value="budget" {{ request('sort') == 'budget' ? 'selected' : '' }}>Sort by: Budget</option>
                                <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Sort by: Title</option>
                                <option value="location" {{ request('sort') == 'location' ? 'selected' : '' }}>Sort by: Location</option>
                            </select>
                            <input type="hidden" name="order" value="{{ request('order', 'desc') }}">
                        </form>
                    </div>
                </div>

                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Job Cards -->
                <div class="space-y-4">
                    @forelse($jobs as $job)
                        <div class="glass-card job-card p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center mb-2">
                                        <h3 class="text-xl font-semibold glass-text">
                                            <a href="{{ route('jobs.show', $job) }}" class="hover:text-blue-primary">
                                                {{ $job->title }}
                                            </a>
                                        </h3>
                                        @if($job->is_urgent)
                                            <span class="ml-2 bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">Urgent</span>
                                        @endif
                                        @if($job->is_featured)
                                            <span class="ml-2 bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">Featured</span>
                                        @endif
                                    </div>
                                    <p class="glass-text-light mb-3">{{ \Illuminate\Support\Str::limit($job->description, 150) }}</p>
                                    <div class="flex flex-wrap items-center gap-4 text-sm glass-text-light mb-4">
                                        <div class="flex items-center">
                                            <i class="fas fa-map-marker-alt mr-1 text-blue-primary"></i>
                                            <span>{{ $job->location }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-clock mr-1 text-blue-primary"></i>
                                            <span>{{ $job->duration }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar mr-1 text-blue-primary"></i>
                                            <span>{{ $job->start_date->format('M d, Y') }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-user mr-1 text-blue-primary"></i>
                                            <span>{{ $job->employer->name }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-eye mr-1 text-blue-primary"></i>
                                            <span>{{ $job->views }} views</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">{{ $job->category->name }}</span>
                                        <span class="bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded">{{ ucfirst($job->job_type) }}</span>
                                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">{{ ucfirst($job->payment_type) }}</span>
                                        @if($job->urgency !== 'normal')
                                            <span class="bg-orange-100 text-orange-800 text-xs px-2 py-1 rounded">{{ ucfirst($job->urgency) }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-right ml-6">
                                    <div class="text-2xl font-bold text-green-600 mb-2">
                                        UGX {{ number_format($job->budget) }}
                                    </div>
                                    <div class="text-sm glass-text-light mb-4">
                                        @if($job->payment_type === 'hourly')
                                            per hour
                                        @elseif($job->payment_type === 'fixed')
                                            fixed price
                                        @else
                                            negotiable
                                        @endif
                                    </div>
                                    
                                    @auth
                                        @if(Auth::user()->isWorker())
                                            <a href="{{ route('jobs.show', $job) }}" class="glass-button px-4 py-2 mb-2 w-full block text-center text-white font-medium">
                                                View Details
                                            </a>
                                            <button onclick="toggleBookmark({{ $job->id }})" 
                                                    class="bookmark-btn glass-input px-4 py-2 w-full glass-text hover:bg-opacity-40 transition duration-300"
                                                    data-job-id="{{ $job->id }}"
                                                    data-bookmarked="{{ Auth::user()->hasBookmarked($job->id) ? 'true' : 'false' }}">
                                                <i class="fas fa-heart mr-1 {{ Auth::user()->hasBookmarked($job->id) ? 'text-red-500' : '' }}"></i> 
                                                <span>{{ Auth::user()->hasBookmarked($job->id) ? 'Saved' : 'Save' }}</span>
                                            </button>
                                        @else
                                            <a href="{{ route('jobs.show', $job) }}" class="glass-button px-4 py-2 mb-2 w-full block text-center text-white font-medium">
                                                View Details
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="glass-button px-4 py-2 mb-2 w-full block text-center text-white font-medium">
                                            Login to Apply
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="glass-card p-8 text-center">
                            <i class="fas fa-search text-gray-400 text-4xl mb-4"></i>
                            <h3 class="text-lg font-semibold glass-text mb-2">No jobs found</h3>
                            <p class="glass-text-light mb-4">Try adjusting your search criteria or browse all available jobs.</p>
                            <a href="{{ route('jobs') }}" class="glass-button px-4 py-2 text-white font-medium">
                                View All Jobs
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($jobs->hasPages())
                    <div class="mt-8">
                        {{ $jobs->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    // Profile dropdown functionality
    $('#profileBtn').on('click', function (e) {
        e.stopPropagation();
        $('#dropdownMenu').toggle();
    });

    // Hide dropdown when clicking outside
    $(document).on('click', function () {
        $('#dropdownMenu').hide();
    });

    // Setup CSRF token for AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Enhanced search functionality
    let searchTimeout;
    const searchSuggestions = $('#searchSuggestions');
    
    // Search input handlers for both desktop and mobile
    $('#navSearchInput, #mobileSearchInput').on('input', function() {
        const query = $(this).val().trim();
        
        if (query.length >= 2) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                fetchSearchSuggestions(query);
            }, 300);
        } else {
            hideSearchSuggestions();
        }
    });

    // Hide suggestions when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.relative').length) {
            hideSearchSuggestions();
        }
    });

    // Handle keyboard navigation in search
    $('#navSearchInput, #mobileSearchInput').on('keydown', function(e) {
        const suggestions = $('.search-suggestion-item');
        const current = $('.search-suggestion-item.active');
        
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            if (current.length === 0) {
                suggestions.first().addClass('active bg-blue-50');
            } else {
                current.removeClass('active bg-blue-50');
                const next = current.next('.search-suggestion-item');
                if (next.length) {
                    next.addClass('active bg-blue-50');
                } else {
                    suggestions.first().addClass('active bg-blue-50');
                }
            }
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            if (current.length === 0) {
                suggestions.last().addClass('active bg-blue-50');
            } else {
                current.removeClass('active bg-blue-50');
                const prev = current.prev('.search-suggestion-item');
                if (prev.length) {
                    prev.addClass('active bg-blue-50');
                } else {
                    suggestions.last().addClass('active bg-blue-50');
                }
            }
        } else if (e.key === 'Enter' && current.length) {
            e.preventDefault();
            current.click();
        } else if (e.key === 'Escape') {
            hideSearchSuggestions();
        }
    });

    function fetchSearchSuggestions(query) {
        // Show loading state
        searchSuggestions.html(`
            <div class="search-suggestion-item text-center text-gray-500">
                <i class="fas fa-spinner fa-spin mr-2"></i>
                Searching...
            </div>
        `).removeClass('hidden');

        // Simulate API call for suggestions (you can replace this with actual API call)
        setTimeout(() => {
            const suggestions = generateSearchSuggestions(query);
            displaySearchSuggestions(suggestions);
        }, 200);
    }

    function generateSearchSuggestions(query) {
        // This is a mock function. In a real application, you'd make an API call
        const commonSearches = [
            'Web Developer', 'Graphic Designer', 'Data Entry', 'Content Writer',
            'Marketing Assistant', 'Virtual Assistant', 'Software Engineer',
            'Project Manager', 'Customer Service', 'Sales Representative'
        ];
        
        const categories = [
            'Technology', 'Design', 'Marketing', 'Finance', 'Healthcare',
            'Education', 'Construction', 'Hospitality', 'Retail'
        ];

        const suggestions = [];
        
        // Add matching job titles
        commonSearches.forEach(search => {
            if (search.toLowerCase().includes(query.toLowerCase())) {
                suggestions.push({
                    type: 'job',
                    text: search,
                    icon: 'fas fa-briefcase'
                });
            }
        });

        // Add matching categories
        categories.forEach(category => {
            if (category.toLowerCase().includes(query.toLowerCase())) {
                suggestions.push({
                    type: 'category',
                    text: category,
                    icon: 'fas fa-tags'
                });
            }
        });

        // Add the current query as a search option
        suggestions.unshift({
            type: 'search',
            text: `Search for "${query}"`,
            icon: 'fas fa-search'
        });

        return suggestions.slice(0, 6); // Limit to 6 suggestions
    }

    function displaySearchSuggestions(suggestions) {
        if (suggestions.length === 0) {
            hideSearchSuggestions();
            return;
        }

        const suggestionsHtml = suggestions.map(suggestion => `
            <div class="search-suggestion-item flex items-center" data-value="${suggestion.text}">
                <i class="${suggestion.icon} text-gray-400 mr-3"></i>
                <span class="flex-1">${suggestion.text}</span>
                <i class="fas fa-arrow-up-right-from-square text-gray-300 text-xs"></i>
            </div>
        `).join('');

        searchSuggestions.html(suggestionsHtml).removeClass('hidden');

        // Handle suggestion clicks
        $('.search-suggestion-item').on('click', function() {
            const value = $(this).data('value');
            const cleanValue = value.replace('Search for "', '').replace('"', '');
            $('#navSearchInput, #mobileSearchInput').val(cleanValue);
            hideSearchSuggestions();
            
            // Submit the form
            $(this).closest('form').find('form').submit();
        });
    }

    function hideSearchSuggestions() {
        searchSuggestions.addClass('hidden').empty();
        $('.search-suggestion-item').removeClass('active bg-blue-50');
    }
});

// Bookmark functionality
function toggleBookmark(jobId) {
    const button = $(`.bookmark-btn[data-job-id="${jobId}"]`);
    const isBookmarked = button.data('bookmarked') === 'true';
    
    // Disable button during request
    button.prop('disabled', true);
    
    $.ajax({
        url: `/jobs/${jobId}/bookmark`,
        method: 'POST',
        success: function(response) {
            if (response.success) {
                // Update button state
                const newBookmarked = !isBookmarked;
                button.data('bookmarked', newBookmarked);
                
                // Update button appearance
                const heartIcon = button.find('i');
                const buttonText = button.find('span');
                
                if (newBookmarked) {
                    heartIcon.addClass('text-red-500');
                    buttonText.text('Saved');
                } else {
                    heartIcon.removeClass('text-red-500');
                    buttonText.text('Save');
                }
                
                // Show success message (optional)
                showMessage(response.message, 'success');
            } else {
                showMessage(response.message || 'An error occurred', 'error');
            }
        },
        error: function(xhr) {
            if (xhr.status === 401) {
                showMessage('Please login to bookmark jobs', 'error');
                // Optionally redirect to login
                // window.location.href = '/login';
            } else {
                showMessage('An error occurred while bookmarking the job', 'error');
            }
        },
        complete: function() {
            // Re-enable button
            button.prop('disabled', false);
        }
    });
}

// Show message function
function showMessage(message, type) {
    const alertClass = type === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700';
    const messageHtml = `
        <div class="fixed top-4 right-4 z-50 ${alertClass} border px-4 py-3 rounded shadow-lg" role="alert">
            <span class="block sm:inline">${message}</span>
            <button class="float-right ml-4 text-lg font-bold" onclick="this.parentElement.remove()">&times;</button>
        </div>
    `;
    
    $('body').append(messageHtml);
    
    // Auto-remove after 5 seconds
    setTimeout(function() {
        $('.fixed.top-4.right-4').fadeOut(function() {
            $(this).remove();
        });
    }, 5000);
}

// iOS-style scroll animation for job cards
document.addEventListener('DOMContentLoaded', function() {
    const jobCards = document.querySelectorAll('.job-card');
    
    // Intersection Observer options
    const observerOptions = {
        root: null, // viewport
        rootMargin: '0px 0px -100px 0px', // trigger slightly before card enters viewport
        threshold: 0.1 // trigger when 10% of card is visible
    };
    
    // Create observer
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                // Add staggered delay based on order
                setTimeout(() => {
                    entry.target.classList.add('animate-in');
                }, index * 100); // 100ms delay between each card
                
                // Stop observing once animated
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Observe all job cards
    jobCards.forEach(card => {
        observer.observe(card);
    });
});
</script>

<!-- Include Footer -->
@include('includes.footer')

</body>
</html>
