<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - JOB-lyNK</title>
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
                radial-gradient(circle at 80% 20%, rgba(241, 245, 249, 0.4) 0%, transparent 50%);
            pointer-events: none;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        .glass-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="glass-background">
    <!-- Navigation -->
    <nav class="bg-blue-primary shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <a href="/home" class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center p-1 shadow-sm">
                            <img src="{{ asset('job-lynk-logo.png') }}" alt="JOB-lyNK Logo" class="w-full h-full object-contain">
                        </div>
                        <h1 class="text-white text-2xl font-bold hover:text-blue-light">JOB-lyNk</h1>
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-4">
                    <a href="/home" class="text-white hover:text-blue-light px-3 py-2 rounded-md text-sm font-medium">Home</a>
                    <a href="/about" class="text-white hover:text-blue-light px-3 py-2 rounded-md text-sm font-medium">About</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="py-20 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-5xl font-bold text-gray-900 mb-4">JOB-lyNK Blog</h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Career tips, industry insights, and success stories from Uganda's leading job platform.</p>
            </div>

            <!-- Featured Post -->
            <div class="glass-card rounded-2xl overflow-hidden mb-16">
                <div class="md:flex">
                    <div class="md:w-1/2 bg-gradient-to-br from-blue-400 to-purple-600 p-12 flex items-center justify-center">
                        <i class="fas fa-newspaper text-white text-9xl opacity-50"></i>
                    </div>
                    <div class="md:w-1/2 p-8">
                        <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full">Featured</span>
                        <h2 class="text-3xl font-bold text-gray-900 mt-4 mb-4">How AI is Transforming Job Matching in Uganda</h2>
                        <p class="text-gray-600 mb-6">Discover how artificial intelligence is revolutionizing the way job seekers connect with employers, making the hiring process faster and more efficient.</p>
                        <div class="flex items-center text-sm text-gray-500 mb-6">
                            <i class="fas fa-calendar mr-2"></i>
                            <span>February 6, 2026</span>
                            <span class="mx-2">•</span>
                            <span>5 min read</span>
                        </div>
                        <a href="#" class="text-blue-primary font-semibold hover:text-blue-dark">Read More <i class="fas fa-arrow-right ml-2"></i></a>
                    </div>
                </div>
            </div>

            <!-- Blog Categories -->
            <div class="flex flex-wrap gap-3 mb-12 justify-center">
                <button class="bg-blue-primary text-white px-6 py-2 rounded-full text-sm font-medium">All Posts</button>
                <button class="bg-white text-gray-700 px-6 py-2 rounded-full text-sm font-medium hover:bg-gray-100">Career Tips</button>
                <button class="bg-white text-gray-700 px-6 py-2 rounded-full text-sm font-medium hover:bg-gray-100">Industry News</button>
                <button class="bg-white text-gray-700 px-6 py-2 rounded-full text-sm font-medium hover:bg-gray-100">Success Stories</button>
                <button class="bg-white text-gray-700 px-6 py-2 rounded-full text-sm font-medium hover:bg-gray-100">For Employers</button>
            </div>

            <!-- Blog Posts Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <!-- Post 1 -->
                <div class="glass-card rounded-xl overflow-hidden">
                    <div class="bg-gradient-to-br from-blue-400 to-blue-600 h-48 flex items-center justify-center">
                        <i class="fas fa-lightbulb text-white text-6xl opacity-50"></i>
                    </div>
                    <div class="p-6">
                        <span class="bg-purple-100 text-purple-800 text-xs px-3 py-1 rounded-full">Career Tips</span>
                        <h3 class="text-xl font-bold text-gray-900 mt-4 mb-3">10 Tips to Ace Your Next Job Interview</h3>
                        <p class="text-gray-600 text-sm mb-4">Master the art of interviewing with these proven strategies from hiring experts.</p>
                        <div class="flex items-center text-xs text-gray-500 mb-4">
                            <i class="fas fa-calendar mr-2"></i>
                            <span>Feb 5, 2026</span>
                            <span class="mx-2">•</span>
                            <span>4 min read</span>
                        </div>
                        <a href="#" class="text-blue-primary font-semibold text-sm hover:text-blue-dark">Read More →</a>
                    </div>
                </div>

                <!-- Post 2 -->
                <div class="glass-card rounded-xl overflow-hidden">
                    <div class="bg-gradient-to-br from-green-400 to-green-600 h-48 flex items-center justify-center">
                        <i class="fas fa-chart-line text-white text-6xl opacity-50"></i>
                    </div>
                    <div class="p-6">
                        <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full">Industry News</span>
                        <h3 class="text-xl font-bold text-gray-900 mt-4 mb-3">Uganda's Job Market Trends for 2026</h3>
                        <p class="text-gray-600 text-sm mb-4">Explore the fastest-growing sectors and in-demand skills for the year ahead.</p>
                        <div class="flex items-center text-xs text-gray-500 mb-4">
                            <i class="fas fa-calendar mr-2"></i>
                            <span>Feb 4, 2026</span>
                            <span class="mx-2">•</span>
                            <span>6 min read</span>
                        </div>
                        <a href="#" class="text-blue-primary font-semibold text-sm hover:text-blue-dark">Read More →</a>
                    </div>
                </div>

                <!-- Post 3 -->
                <div class="glass-card rounded-xl overflow-hidden">
                    <div class="bg-gradient-to-br from-yellow-400 to-orange-500 h-48 flex items-center justify-center">
                        <i class="fas fa-star text-white text-6xl opacity-50"></i>
                    </div>
                    <div class="p-6">
                        <span class="bg-yellow-100 text-yellow-800 text-xs px-3 py-1 rounded-full">Success Stories</span>
                        <h3 class="text-xl font-bold text-gray-900 mt-4 mb-3">From Unemployed to Dream Job in 30 Days</h3>
                        <p class="text-gray-600 text-sm mb-4">Read how Sarah landed her dream job using JOB-lyNK's AI matching feature.</p>
                        <div class="flex items-center text-xs text-gray-500 mb-4">
                            <i class="fas fa-calendar mr-2"></i>
                            <span>Feb 3, 2026</span>
                            <span class="mx-2">•</span>
                            <span>3 min read</span>
                        </div>
                        <a href="#" class="text-blue-primary font-semibold text-sm hover:text-blue-dark">Read More →</a>
                    </div>
                </div>

                <!-- Post 4 -->
                <div class="glass-card rounded-xl overflow-hidden">
                    <div class="bg-gradient-to-br from-purple-400 to-pink-500 h-48 flex items-center justify-center">
                        <i class="fas fa-building text-white text-6xl opacity-50"></i>
                    </div>
                    <div class="p-6">
                        <span class="bg-pink-100 text-pink-800 text-xs px-3 py-1 rounded-full">For Employers</span>
                        <h3 class="text-xl font-bold text-gray-900 mt-4 mb-3">How to Write Job Descriptions That Attract Top Talent</h3>
                        <p class="text-gray-600 text-sm mb-4">Learn the secrets to crafting compelling job posts that get results.</p>
                        <div class="flex items-center text-xs text-gray-500 mb-4">
                            <i class="fas fa-calendar mr-2"></i>
                            <span>Feb 2, 2026</span>
                            <span class="mx-2">•</span>
                            <span>5 min read</span>
                        </div>
                        <a href="#" class="text-blue-primary font-semibold text-sm hover:text-blue-dark">Read More →</a>
                    </div>
                </div>

                <!-- Post 5 -->
                <div class="glass-card rounded-xl overflow-hidden">
                    <div class="bg-gradient-to-br from-indigo-400 to-indigo-600 h-48 flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-white text-6xl opacity-50"></i>
                    </div>
                    <div class="p-6">
                        <span class="bg-indigo-100 text-indigo-800 text-xs px-3 py-1 rounded-full">Career Tips</span>
                        <h3 class="text-xl font-bold text-gray-900 mt-4 mb-3">Essential Skills Every Job Seeker Needs in 2026</h3>
                        <p class="text-gray-600 text-sm mb-4">Stay competitive with these must-have skills for today's job market.</p>
                        <div class="flex items-center text-xs text-gray-500 mb-4">
                            <i class="fas fa-calendar mr-2"></i>
                            <span>Feb 1, 2026</span>
                            <span class="mx-2">•</span>
                            <span>7 min read</span>
                        </div>
                        <a href="#" class="text-blue-primary font-semibold text-sm hover:text-blue-dark">Read More →</a>
                    </div>
                </div>

                <!-- Post 6 -->
                <div class="glass-card rounded-xl overflow-hidden">
                    <div class="bg-gradient-to-br from-red-400 to-red-600 h-48 flex items-center justify-center">
                        <i class="fas fa-handshake text-white text-6xl opacity-50"></i>
                    </div>
                    <div class="p-6">
                        <span class="bg-red-100 text-red-800 text-xs px-3 py-1 rounded-full">Success Stories</span>
                        <h3 class="text-xl font-bold text-gray-900 mt-4 mb-3">How One Company Filled 50 Positions in Record Time</h3>
                        <p class="text-gray-600 text-sm mb-4">Discover how TechCorp Uganda transformed their hiring with JOB-lyNK.</p>
                        <div class="flex items-center text-xs text-gray-500 mb-4">
                            <i class="fas fa-calendar mr-2"></i>
                            <span>Jan 31, 2026</span>
                            <span class="mx-2">•</span>
                            <span>4 min read</span>
                        </div>
                        <a href="#" class="text-blue-primary font-semibold text-sm hover:text-blue-dark">Read More →</a>
                    </div>
                </div>
            </div>

            <!-- Newsletter Signup -->
            <div class="glass-card rounded-2xl p-12 text-center">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Stay Updated</h2>
                <p class="text-gray-600 mb-8 max-w-2xl mx-auto">Subscribe to our newsletter for the latest career tips, industry insights, and job market trends.</p>
                <div class="max-w-md mx-auto flex gap-3">
                    <input type="email" placeholder="Enter your email" class="flex-1 px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-primary">
                    <button class="bg-blue-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-dark transition">Subscribe</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="text-gray-400">&copy; 2024 JOB-lyNK. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
