<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Talent Network - JOB-lyNK</title>
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
                    <a href="{{ route('talent-network.join') }}" class="bg-blue-secondary hover:bg-blue-dark text-white px-4 py-2 rounded-md text-sm font-medium">Join Network</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="py-20 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-5xl font-bold text-gray-900 mb-4">Join Our Talent Network</h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Connect with top employers, get matched to opportunities, and grow your career with Uganda's premier talent community.</p>
            </div>

            <!-- Benefits -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <div class="glass-card rounded-2xl p-8">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-bell text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Priority Job Alerts</h3>
                    <p class="text-gray-600">Get notified first when jobs matching your skills are posted. Never miss an opportunity.</p>
                </div>

                <div class="glass-card rounded-2xl p-8">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-robot text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">AI-Powered Matching</h3>
                    <p class="text-gray-600">Our AI analyzes your profile and matches you with the most relevant opportunities.</p>
                </div>

                <div class="glass-card rounded-2xl p-8">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-graduation-cap text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Skill Development</h3>
                    <p class="text-gray-600">Access free training resources, webinars, and career development tools.</p>
                </div>
            </div>

            <!-- How It Works -->
            <div class="glass-card rounded-2xl p-12 mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-12 text-center">How It Works</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-primary text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">1</div>
                        <h4 class="font-semibold text-gray-900 mb-2">Create Profile</h4>
                        <p class="text-gray-600 text-sm">Sign up and complete your professional profile with skills and experience.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-primary text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">2</div>
                        <h4 class="font-semibold text-gray-900 mb-2">Get Verified</h4>
                        <p class="text-gray-600 text-sm">Complete verification to unlock premium network benefits.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-primary text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">3</div>
                        <h4 class="font-semibold text-gray-900 mb-2">Get Matched</h4>
                        <p class="text-gray-600 text-sm">Receive personalized job recommendations based on your profile.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-primary text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">4</div>
                        <h4 class="font-semibold text-gray-900 mb-2">Land Jobs</h4>
                        <p class="text-gray-600 text-sm">Apply with one click and connect directly with employers.</p>
                    </div>
                </div>
            </div>

            <!-- Network Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-16">
                <div class="glass-card rounded-xl p-6 text-center">
                    <div class="text-4xl font-bold text-blue-primary mb-2">10K+</div>
                    <div class="text-gray-600">Active Members</div>
                </div>
                <div class="glass-card rounded-xl p-6 text-center">
                    <div class="text-4xl font-bold text-blue-primary mb-2">500+</div>
                    <div class="text-gray-600">Partner Companies</div>
                </div>
                <div class="glass-card rounded-xl p-6 text-center">
                    <div class="text-4xl font-bold text-blue-primary mb-2">2K+</div>
                    <div class="text-gray-600">Jobs Monthly</div>
                </div>
                <div class="glass-card rounded-xl p-6 text-center">
                    <div class="text-4xl font-bold text-blue-primary mb-2">95%</div>
                    <div class="text-gray-600">Success Rate</div>
                </div>
            </div>

            <!-- CTA -->
            <div class="glass-card rounded-2xl p-12 text-center">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Ready to Join?</h2>
                <p class="text-gray-600 mb-8 max-w-2xl mx-auto">Become part of Uganda's fastest-growing professional talent network. It's free to join!</p>
                <a href="{{ route('talent-network.join') }}" class="inline-block bg-blue-primary text-white px-8 py-4 rounded-xl font-semibold hover:bg-blue-dark transition">
                    Join Talent Network <i class="fas fa-arrow-right ml-2"></i>
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
