<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JOB-lyNK - Find Your Perfect Casual Job</title>
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
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(20px, -50px) scale(1.1); }
            50% { transform: translate(-20px, 20px) scale(0.9); }
            75% { transform: translate(50px, 50px) scale(1.05); }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.5); }
            50% { box-shadow: 0 0 40px rgba(59, 130, 246, 0.8); }
        }
        
        .animate-fadeInUp { animation: fadeInUp 0.6s ease-out forwards; }
        .animate-slideInRight { animation: slideInRight 0.6s ease-out forwards; }
        .animate-blob { animation: blob 20s infinite; }
        .animate-float { animation: float 3s ease-in-out infinite; }
        .animate-pulse-glow { animation: pulse-glow 2s ease-in-out infinite; }
        
        .animation-delay-200 { animation-delay: 0.2s; }
        .animation-delay-400 { animation-delay: 0.4s; }
        .animation-delay-600 { animation-delay: 0.6s; }
        .animation-delay-800 { animation-delay: 0.8s; }
        .animation-delay-1000 { animation-delay: 1s; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
        
        .job-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        }
        
        .job-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            background: linear-gradient(135deg, #ffffff 0%, #eff6ff 100%);
        }
        
        .category-card {
            transition: all 0.3s ease;
        }
        
        .category-card:hover {
            transform: translateY(-5px);
        }
        
        .carousel-item {
            display: none;
        }
        
        .carousel-item.active {
            display: block;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Include Navbar -->
    @include('includes.navbar')

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-blue-primary via-blue-secondary to-blue-dark overflow-hidden">
        <!-- Animated Background Blobs -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden">
            <div class="absolute top-0 -left-4 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
            <div class="absolute top-0 -right-4 w-72 h-72 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-32">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="text-white space-y-6 opacity-0 animate-fadeInUp">
                    <div class="inline-block bg-yellow-400/20 backdrop-blur-sm px-4 py-2 rounded-full text-yellow-300 text-sm font-semibold mb-4">
                        <i class="fas fa-star mr-2"></i>Uganda's #1 Job Platform
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                        Find Your Perfect <span class="text-yellow-300">Casual Job</span> Today
                    </h1>
                    <p class="text-lg md:text-xl text-blue-light leading-relaxed">
                        Connect with top employers and discover flexible job opportunities that match your skills and schedule. Start your journey to success now!
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        <a href="{{ route('jobs') }}" class="bg-yellow-400 hover:bg-yellow-300 text-blue-dark px-8 py-4 rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-2xl text-center transform hover:scale-105">
                            <i class="fas fa-search mr-2"></i>Browse Jobs
                        </a>
                        <a href="{{ route('register') }}" class="bg-white/10 backdrop-blur-sm border-2 border-white text-white px-8 py-4 rounded-xl font-bold hover:bg-white hover:text-blue-primary transition-all duration-300 text-center">
                            <i class="fas fa-user-plus mr-2"></i>Sign Up Free
                        </a>
                    </div>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-6 pt-8">
                        <div class="text-center">
                            <div class="text-4xl font-bold text-yellow-300 mb-1">{{ $stats['total_jobs'] }}+</div>
                            <div class="text-sm text-blue-light">Active Jobs</div>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-bold text-yellow-300 mb-1">{{ $stats['total_employers'] }}+</div>
                            <div class="text-sm text-blue-light">Employers</div>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-bold text-yellow-300 mb-1">{{ $stats['total_workers'] }}+</div>
                            <div class="text-sm text-blue-light">Job Seekers</div>
                        </div>
                    </div>
                </div>
                
                <!-- Hero Image -->
                <div class="opacity-0 animate-slideInRight animation-delay-400">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=600&h=600&fit=crop" alt="Team" class="rounded-2xl shadow-2xl animate-float">
                        <div class="absolute -bottom-6 -left-6 bg-white p-6 rounded-xl shadow-2xl animate-pulse-glow">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-white text-xl"></i>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-gray-800">98%</div>
                                    <div class="text-sm text-gray-600">Success Rate</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Image Carousel Section -->
    <section class="py-16 bg-gradient-to-br from-white to-blue-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Success Stories</h2>
                <p class="text-lg text-gray-600">See how JOB-lyNK is transforming careers across Uganda</p>
            </div>
            
            <div class="relative overflow-hidden rounded-2xl shadow-2xl">
                <!-- Carousel Container -->
                <div id="carousel" class="relative h-96">
                    <!-- Slide 1 -->
                    <div class="carousel-item active absolute inset-0">
                        <img src="https://images.unsplash.com/photo-1556761175-b413da4baf72?w=1200&h=400&fit=crop" alt="Office Team" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/80 to-transparent flex items-center">
                            <div class="max-w-2xl px-12 text-white">
                                <h3 class="text-4xl font-bold mb-4">Join Top Companies</h3>
                                <p class="text-xl">Work with leading employers across Uganda and build your career</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Slide 2 -->
                    <div class="carousel-item absolute inset-0">
                        <img src="https://images.unsplash.com/photo-1521737711867-e3b97375f902?w=1200&h=400&fit=crop" alt="Success" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-r from-green-900/80 to-transparent flex items-center">
                            <div class="max-w-2xl px-12 text-white">
                                <h3 class="text-4xl font-bold mb-4">Flexible Opportunities</h3>
                                <p class="text-xl">Find part-time, full-time, and freelance jobs that fit your schedule</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Slide 3 -->
                    <div class="carousel-item absolute inset-0">
                        <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=1200&h=400&fit=crop" alt="Growth" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-r from-purple-900/80 to-transparent flex items-center">
                            <div class="max-w-2xl px-12 text-white">
                                <h3 class="text-4xl font-bold mb-4">Grow Your Skills</h3>
                                <p class="text-xl">Access training resources and advance your career with every opportunity</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Slide 4 -->
                    <div class="carousel-item absolute inset-0">
                        <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=1200&h=400&fit=crop" alt="Team Success" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-r from-orange-900/80 to-transparent flex items-center">
                            <div class="max-w-2xl px-12 text-white">
                                <h3 class="text-4xl font-bold mb-4">Earn More</h3>
                                <p class="text-xl">Competitive salaries and benefits from verified employers</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Carousel Controls -->
                <button onclick="prevSlide()" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 w-12 h-12 rounded-full flex items-center justify-center transition-all shadow-lg hover:scale-110">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button onclick="nextSlide()" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 w-12 h-12 rounded-full flex items-center justify-center transition-all shadow-lg hover:scale-110">
                    <i class="fas fa-chevron-right"></i>
                </button>
                
                <!-- Carousel Indicators -->
                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                    <button onclick="goToSlide(0)" class="carousel-indicator w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-all"></button>
                    <button onclick="goToSlide(1)" class="carousel-indicator w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-all"></button>
                    <button onclick="goToSlide(2)" class="carousel-indicator w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-all"></button>
                    <button onclick="goToSlide(3)" class="carousel-indicator w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-all"></button>
                </div>
            </div>
        </div>
    </section>

    <!-- Job Categories Section -->
    <section class="py-16 bg-gradient-to-br from-gray-50 to-blue-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Popular Job Categories</h2>
                <p class="text-lg text-gray-600">Explore opportunities across various industries</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <a href="{{ route('jobs') }}?category=hospitality" class="category-card group bg-white hover:bg-blue-primary p-6 rounded-xl shadow-md hover:shadow-xl text-center cursor-pointer">
                    <div class="w-16 h-16 mx-auto mb-4 bg-blue-100 group-hover:bg-white rounded-xl flex items-center justify-center transition-all">
                        <i class="fas fa-utensils text-blue-primary text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 group-hover:text-white transition-colors">Hospitality</h3>
                </a>
                
                <a href="{{ route('jobs') }}?category=retail" class="category-card group bg-white hover:bg-green-500 p-6 rounded-xl shadow-md hover:shadow-xl text-center cursor-pointer">
                    <div class="w-16 h-16 mx-auto mb-4 bg-green-100 group-hover:bg-white rounded-xl flex items-center justify-center transition-all">
                        <i class="fas fa-shopping-cart text-green-500 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 group-hover:text-white transition-colors">Retail</h3>
                </a>
                
                <a href="{{ route('jobs') }}?category=delivery" class="category-card group bg-white hover:bg-orange-500 p-6 rounded-xl shadow-md hover:shadow-xl text-center cursor-pointer">
                    <div class="w-16 h-16 mx-auto mb-4 bg-orange-100 group-hover:bg-white rounded-xl flex items-center justify-center transition-all">
                        <i class="fas fa-truck text-orange-500 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 group-hover:text-white transition-colors">Delivery</h3>
                </a>
                
                <a href="{{ route('jobs') }}?category=customer-service" class="category-card group bg-white hover:bg-purple-500 p-6 rounded-xl shadow-md hover:shadow-xl text-center cursor-pointer">
                    <div class="w-16 h-16 mx-auto mb-4 bg-purple-100 group-hover:bg-white rounded-xl flex items-center justify-center transition-all">
                        <i class="fas fa-headset text-purple-500 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 group-hover:text-white transition-colors">Customer Service</h3>
                </a>
                
                <a href="{{ route('jobs') }}?category=warehouse" class="category-card group bg-white hover:bg-red-500 p-6 rounded-xl shadow-md hover:shadow-xl text-center cursor-pointer">
                    <div class="w-16 h-16 mx-auto mb-4 bg-red-100 group-hover:bg-white rounded-xl flex items-center justify-center transition-all">
                        <i class="fas fa-warehouse text-red-500 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 group-hover:text-white transition-colors">Warehouse</h3>
                </a>
                
                <a href="{{ route('jobs') }}?category=events" class="category-card group bg-white hover:bg-pink-500 p-6 rounded-xl shadow-md hover:shadow-xl text-center cursor-pointer">
                    <div class="w-16 h-16 mx-auto mb-4 bg-pink-100 group-hover:bg-white rounded-xl flex items-center justify-center transition-all">
                        <i class="fas fa-calendar text-pink-500 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 group-hover:text-white transition-colors">Events</h3>
                </a>
            </div>
        </div>
    </section>

    <!-- Featured Jobs Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Featured Jobs</h2>
                <p class="text-lg text-gray-600">Discover the latest job opportunities from top employers</p>
            </div>
            
            <div id="jobsContainer" class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($featuredJobs as $index => $job)
                <div class="job-card border-2 border-gray-100 rounded-2xl p-6 hover:border-blue-primary cursor-pointer opacity-0 animate-fadeInUp" style="animation-delay: {{ $index * 0.1 }}s">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900 mb-2 hover:text-blue-primary transition-colors">{{ $job->title }}</h3>
                            <p class="text-gray-600 flex items-center">
                                <i class="fas fa-building mr-2 text-blue-primary"></i>
                                {{ $job->employer->name ?? 'Company' }}
                            </p>
                        </div>
                        <button onclick="bookmarkJob({{ $job->id }})" class="text-gray-400 hover:text-yellow-500 transition-all transform hover:scale-110">
                            <i class="far fa-bookmark text-2xl"></i>
                        </button>
                    </div>
                    
                    <div class="space-y-2 mb-4">
                        <p class="text-gray-600 flex items-center">
                            <i class="fas fa-map-marker-alt mr-2 text-blue-primary w-5"></i>
                            {{ $job->location }}
                        </p>
                        <p class="text-gray-600 flex items-center">
                            <i class="fas fa-clock mr-2 text-blue-primary w-5"></i>
                            {{ $job->job_type }}
                        </p>
                        <p class="text-gray-600 flex items-center">
                            <i class="fas fa-dollar-sign mr-2 text-blue-primary w-5"></i>
                            UGX {{ number_format($job->budget) }}
                        </p>
                    </div>
                    
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ Str::limit($job->description, 100) }}</p>
                    
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <span class="text-xs text-gray-500 flex items-center">
                            <i class="far fa-clock mr-1"></i>
                            {{ $job->created_at->diffForHumans() }}
                        </span>
                        <a href="{{ route('jobs.show', $job->id) }}" class="bg-blue-primary text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-blue-dark transition-all transform hover:scale-105 shadow-md">
                            View Details
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-16">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-briefcase text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No Jobs Available</h3>
                    <p class="text-gray-600">Check back soon for new opportunities!</p>
                </div>
                @endforelse
            </div>
            
            @if($featuredJobs->count() > 0)
            <div class="text-center mt-12">
                <a href="{{ route('jobs') }}" class="inline-block bg-blue-primary text-white px-10 py-4 rounded-xl font-bold hover:bg-blue-dark transition-all duration-300 shadow-lg hover:shadow-2xl transform hover:scale-105">
                    View All Jobs <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            @endif
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-16 bg-gradient-to-br from-blue-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">How It Works</h2>
                <p class="text-lg text-gray-600">Get started in three simple steps</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center opacity-0 animate-fadeInUp relative">
                    <div class="w-24 h-24 bg-gradient-to-br from-blue-primary to-blue-secondary rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl transform hover:scale-110 transition-all duration-300">
                        <i class="fas fa-user-plus text-white text-4xl"></i>
                    </div>
                    <div class="absolute top-12 left-1/2 transform translate-x-12 hidden md:block">
                        <i class="fas fa-arrow-right text-blue-200 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">1. Create Account</h3>
                    <p class="text-gray-600 leading-relaxed">Sign up for free and create your professional profile in minutes. Add your skills and experience.</p>
                </div>
                
                <div class="text-center opacity-0 animate-fadeInUp animation-delay-200 relative">
                    <div class="w-24 h-24 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl transform hover:scale-110 transition-all duration-300">
                        <i class="fas fa-search text-white text-4xl"></i>
                    </div>
                    <div class="absolute top-12 left-1/2 transform translate-x-12 hidden md:block">
                        <i class="fas fa-arrow-right text-blue-200 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">2. Browse Jobs</h3>
                    <p class="text-gray-600 leading-relaxed">Search and filter through hundreds of job opportunities that match your skills and preferences.</p>
                </div>
                
                <div class="text-center opacity-0 animate-fadeInUp animation-delay-400">
                    <div class="w-24 h-24 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl transform hover:scale-110 transition-all duration-300">
                        <i class="fas fa-paper-plane text-white text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">3. Apply & Get Hired</h3>
                    <p class="text-gray-600 leading-relaxed">Submit your application with one click and connect with employers directly to land your dream job.</p>
                </div>
            </div>
        </div>
    </section>


    <!-- Testimonials Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">What Our Users Say</h2>
                <p class="text-lg text-gray-600">Join thousands of satisfied job seekers and employers</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-gradient-to-br from-blue-50 to-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all">
                    <div class="flex items-center mb-4">
                        <img src="https://ui-avatars.com/api/?name=Sarah+M&background=3b82f6&color=fff" alt="User" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="font-bold text-gray-900">Sarah M.</h4>
                            <div class="text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"Found my perfect part-time job within a week! The platform is so easy to use and the employers are very responsive."</p>
                </div>
                
                <div class="bg-gradient-to-br from-green-50 to-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all">
                    <div class="flex items-center mb-4">
                        <img src="https://ui-avatars.com/api/?name=John+D&background=10b981&color=fff" alt="User" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="font-bold text-gray-900">John D.</h4>
                            <div class="text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"As an employer, JOB-lyNK has been a game-changer. I found qualified candidates quickly and the hiring process was seamless."</p>
                </div>
                
                <div class="bg-gradient-to-br from-purple-50 to-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all">
                    <div class="flex items-center mb-4">
                        <img src="https://ui-avatars.com/api/?name=Mary+K&background=8b5cf6&color=fff" alt="User" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="font-bold text-gray-900">Mary K.</h4>
                            <div class="text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"The best job platform in Uganda! Professional, reliable, and they truly care about connecting the right people with the right opportunities."</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Include Footer -->
    @include('includes.footer')


    <script>
        // Carousel functionality
        let currentSlide = 0;
        const slides = document.querySelectorAll('.carousel-item');
        const indicators = document.querySelectorAll('.carousel-indicator');
        const totalSlides = slides.length;
        
        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.remove('active');
                indicators[i].classList.remove('bg-white');
                indicators[i].classList.add('bg-white/50');
            });
            
            currentSlide = (index + totalSlides) % totalSlides;
            slides[currentSlide].classList.add('active');
            indicators[currentSlide].classList.remove('bg-white/50');
            indicators[currentSlide].classList.add('bg-white');
        }
        
        function nextSlide() {
            showSlide(currentSlide + 1);
        }
        
        function prevSlide() {
            showSlide(currentSlide - 1);
        }
        
        function goToSlide(index) {
            showSlide(index);
        }
        
        // Auto-advance carousel every 5 seconds
        setInterval(nextSlide, 5000);
        
        // Initialize first indicator
        indicators[0].classList.add('bg-white');
        
        // Bookmark job function
        function bookmarkJob(jobId) {
            @auth
                fetch(`/jobs/${jobId}/bookmark`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Job bookmarked successfully!');
                    }
                });
            @else
                window.location.href = '{{ route("login") }}';
            @endauth
        }
        
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
        
        // Scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                }
            });
        }, observerOptions);
        
        document.querySelectorAll('.animate-fadeInUp, .animate-slideInRight').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>
</html>
