<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Press & Media Kit - JOB-lyNK</title>
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
                    <a href="/contact" class="text-white hover:text-blue-light px-3 py-2 rounded-md text-sm font-medium">Contact</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="py-20 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-5xl font-bold text-gray-900 mb-4">Press & Media Kit</h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Everything you need to know about JOB-lyNK. Download our media assets and learn about our story.</p>
            </div>

            <!-- Company Overview -->
            <div class="glass-card rounded-2xl p-12 mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">About JOB-lyNK</h2>
                <p class="text-gray-700 text-lg mb-4">
                    JOB-lyNK is Uganda's leading platform connecting skilled casual workers with employers who need flexible, reliable help. Founded in 2024, we're revolutionizing the way people find work and hire talent across Uganda.
                </p>
                <p class="text-gray-700 text-lg mb-4">
                    Our mission is to create economic opportunities for everyone by making it easy to find and offer casual work. Whether you're a student looking for part-time work, a professional seeking side gigs, or a business needing temporary help, JOB-lyNK is here for you.
                </p>
                <p class="text-gray-700 text-lg">
                    With over 10,000 active workers, 5,000 employers, and 50,000+ jobs completed, we're building the future of flexible work in East Africa.
                </p>
            </div>

            <!-- Key Facts -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-16">
                <div class="glass-card rounded-xl p-6 text-center">
                    <div class="text-4xl font-bold text-blue-primary mb-2">2024</div>
                    <div class="text-gray-600">Founded</div>
                </div>
                <div class="glass-card rounded-xl p-6 text-center">
                    <div class="text-4xl font-bold text-blue-primary mb-2">10K+</div>
                    <div class="text-gray-600">Active Workers</div>
                </div>
                <div class="glass-card rounded-xl p-6 text-center">
                    <div class="text-4xl font-bold text-blue-primary mb-2">5K+</div>
                    <div class="text-gray-600">Employers</div>
                </div>
                <div class="glass-card rounded-xl p-6 text-center">
                    <div class="text-4xl font-bold text-blue-primary mb-2">50K+</div>
                    <div class="text-gray-600">Jobs Completed</div>
                </div>
            </div>

            <!-- Brand Assets -->
            <div class="glass-card rounded-2xl p-12 mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Brand Assets</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="border-2 border-gray-200 rounded-xl p-8 text-center">
                        <div class="bg-white rounded-lg p-8 mb-4">
                            <img src="{{ asset('job-lynk-logo.png') }}" alt="JOB-lyNK Logo" class="w-32 h-32 mx-auto object-contain">
                        </div>
                        <h3 class="font-bold text-gray-900 mb-2">Primary Logo</h3>
                        <p class="text-gray-600 text-sm mb-4">PNG, SVG formats</p>
                        <button class="bg-blue-primary text-white px-6 py-2 rounded-lg hover:bg-blue-dark transition">
                            <i class="fas fa-download mr-2"></i>Download
                        </button>
                    </div>
                    <div class="border-2 border-gray-200 rounded-xl p-8 text-center">
                        <div class="bg-gray-900 rounded-lg p-8 mb-4">
                            <img src="{{ asset('job-lynk-logo.png') }}" alt="JOB-lyNK Logo White" class="w-32 h-32 mx-auto object-contain">
                        </div>
                        <h3 class="font-bold text-gray-900 mb-2">Logo (White)</h3>
                        <p class="text-gray-600 text-sm mb-4">PNG, SVG formats</p>
                        <button class="bg-blue-primary text-white px-6 py-2 rounded-lg hover:bg-blue-dark transition">
                            <i class="fas fa-download mr-2"></i>Download
                        </button>
                    </div>
                </div>
            </div>

            <!-- Brand Colors -->
            <div class="glass-card rounded-2xl p-12 mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Brand Colors</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div>
                        <div class="bg-blue-primary h-24 rounded-lg mb-3"></div>
                        <p class="font-semibold text-gray-900">Blue Primary</p>
                        <p class="text-gray-600 text-sm">#1e40af</p>
                    </div>
                    <div>
                        <div class="bg-blue-secondary h-24 rounded-lg mb-3"></div>
                        <p class="font-semibold text-gray-900">Blue Secondary</p>
                        <p class="text-gray-600 text-sm">#3b82f6</p>
                    </div>
                    <div>
                        <div class="bg-blue-light h-24 rounded-lg mb-3"></div>
                        <p class="font-semibold text-gray-900">Blue Light</p>
                        <p class="text-gray-600 text-sm">#dbeafe</p>
                    </div>
                    <div>
                        <div class="bg-blue-dark h-24 rounded-lg mb-3"></div>
                        <p class="font-semibold text-gray-900">Blue Dark</p>
                        <p class="text-gray-600 text-sm">#1e3a8a</p>
                    </div>
                </div>
            </div>

            <!-- Press Releases -->
            <div class="glass-card rounded-2xl p-12 mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Recent Press Releases</h2>
                <div class="space-y-6">
                    <div class="border-b border-gray-200 pb-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">JOB-lyNK Launches AI-Powered Job Matching</h3>
                                <p class="text-gray-600 mb-2">Revolutionary technology connects job seekers with perfect opportunities in seconds.</p>
                                <p class="text-sm text-gray-500">February 1, 2026</p>
                            </div>
                            <button class="text-blue-primary hover:text-blue-dark font-semibold">Read More →</button>
                        </div>
                    </div>
                    <div class="border-b border-gray-200 pb-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">JOB-lyNK Reaches 10,000 Active Users Milestone</h3>
                                <p class="text-gray-600 mb-2">Platform celebrates rapid growth and impact on Uganda's job market.</p>
                                <p class="text-sm text-gray-500">January 15, 2026</p>
                            </div>
                            <button class="text-blue-primary hover:text-blue-dark font-semibold">Read More →</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact -->
            <div class="glass-card rounded-2xl p-12 text-center">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Media Inquiries</h2>
                <p class="text-gray-600 mb-8 max-w-2xl mx-auto">For press inquiries, interviews, or additional information, please contact our media team.</p>
                <div class="space-y-3">
                    <p class="text-gray-700"><i class="fas fa-envelope text-blue-primary mr-2"></i> press@joblynk.com</p>
                    <p class="text-gray-700"><i class="fas fa-phone text-blue-primary mr-2"></i> +256 XXX XXX XXX</p>
                </div>
                <div class="mt-8">
                    <a href="/contact" class="inline-block bg-blue-primary text-white px-8 py-4 rounded-xl font-semibold hover:bg-blue-dark transition">
                        Contact Media Team <i class="fas fa-arrow-right ml-2"></i>
                    </a>
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
