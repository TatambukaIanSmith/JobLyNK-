<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Careers - JOB-lyNK</title>
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
                <h1 class="text-5xl font-bold text-gray-900 mb-4">Join Our Team</h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Help us revolutionize the way people find work in Uganda. Build your career with a mission-driven team.</p>
            </div>

            <!-- Why Join Us -->
            <div class="glass-card rounded-2xl p-12 mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Why Work at JOB-lyNK?</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-rocket text-white text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-2">Innovation First</h3>
                        <p class="text-gray-600">Work with cutting-edge technology and shape the future of work.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-heart text-white text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-2">Impact Lives</h3>
                        <p class="text-gray-600">Make a real difference by connecting people with opportunities.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-users text-white text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-2">Great Culture</h3>
                        <p class="text-gray-600">Collaborative environment with talented, passionate people.</p>
                    </div>
                </div>
            </div>

            <!-- Open Positions -->
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Open Positions</h2>
                <div class="space-y-4">
                    <div class="glass-card rounded-xl p-6 hover:shadow-lg transition">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Senior Full Stack Developer</h3>
                                <p class="text-gray-600 mb-4">Build and scale our platform using Laravel, Vue.js, and modern technologies.</p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full">Full-time</span>
                                    <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full">Remote</span>
                                    <span class="bg-purple-100 text-purple-800 text-xs px-3 py-1 rounded-full">Engineering</span>
                                </div>
                            </div>
                            <a href="/contact" class="bg-blue-primary text-white px-6 py-2 rounded-lg hover:bg-blue-dark transition">Apply</a>
                        </div>
                    </div>

                    <div class="glass-card rounded-xl p-6 hover:shadow-lg transition">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Product Manager</h3>
                                <p class="text-gray-600 mb-4">Lead product strategy and work with cross-functional teams to deliver value.</p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full">Full-time</span>
                                    <span class="bg-yellow-100 text-yellow-800 text-xs px-3 py-1 rounded-full">Kampala</span>
                                    <span class="bg-purple-100 text-purple-800 text-xs px-3 py-1 rounded-full">Product</span>
                                </div>
                            </div>
                            <a href="/contact" class="bg-blue-primary text-white px-6 py-2 rounded-lg hover:bg-blue-dark transition">Apply</a>
                        </div>
                    </div>

                    <div class="glass-card rounded-xl p-6 hover:shadow-lg transition">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Customer Success Manager</h3>
                                <p class="text-gray-600 mb-4">Help our users succeed and build lasting relationships with employers.</p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full">Full-time</span>
                                    <span class="bg-yellow-100 text-yellow-800 text-xs px-3 py-1 rounded-full">Kampala</span>
                                    <span class="bg-purple-100 text-purple-800 text-xs px-3 py-1 rounded-full">Customer Success</span>
                                </div>
                            </div>
                            <a href="/contact" class="bg-blue-primary text-white px-6 py-2 rounded-lg hover:bg-blue-dark transition">Apply</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Benefits -->
            <div class="glass-card rounded-2xl p-12 mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Benefits & Perks</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-start space-x-4">
                        <i class="fas fa-check-circle text-green-500 text-2xl mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">Competitive Salary</h4>
                            <p class="text-gray-600">Market-leading compensation packages</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <i class="fas fa-check-circle text-green-500 text-2xl mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">Health Insurance</h4>
                            <p class="text-gray-600">Comprehensive medical coverage for you and family</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <i class="fas fa-check-circle text-green-500 text-2xl mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">Flexible Work</h4>
                            <p class="text-gray-600">Remote work options and flexible hours</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <i class="fas fa-check-circle text-green-500 text-2xl mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">Learning Budget</h4>
                            <p class="text-gray-600">Annual budget for courses and conferences</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA -->
            <div class="text-center glass-card rounded-2xl p-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Don't See Your Role?</h2>
                <p class="text-gray-600 mb-8">We're always looking for talented people. Send us your resume!</p>
                <a href="/contact" class="inline-block bg-blue-primary text-white px-8 py-4 rounded-xl font-semibold hover:bg-blue-dark transition">
                    Get in Touch <i class="fas fa-arrow-right ml-2"></i>
                </a>
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
