<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - JOB-lyNK</title>
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

        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .glass-card-dark {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 16px rgba(30, 64, 175, 0.2);
        }

        .stat-card {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }
    </style>
</head>
<body class="glass-background">   @include('includes.navbar')

    <!-- About Section -->
    <section class="py-20 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-5xl font-bold text-gray-900 mb-4">About JOB-lyNK</h1>
                <p class="text-gray-600 max-w-2xl mx-auto text-lg">Connecting talent with opportunity across Uganda</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center mb-16">
                <div class="glass-card-dark p-8 rounded-3xl">
                    <h2 class="text-3xl font-bold text-white mb-6">Our Story</h2>
                    <p class="text-white text-opacity-80 mb-4 text-lg leading-relaxed">
                        JOB-lyNK is Uganda's leading platform connecting skilled casual workers with employers who need flexible, reliable help. We're revolutionizing the way people find work and hire talent.
                    </p>
                    <p class="text-white text-opacity-80 mb-4 leading-relaxed">
                        Founded in 2024, our mission is to create economic opportunities for everyone by making it easy to find and offer casual work. Whether you're a student looking for part-time work, a professional seeking side gigs, or a business needing temporary help, JOB-lyNK is here for you.
                    </p>
                    <p class="text-white text-opacity-80 leading-relaxed">
                        We believe in fair pay, secure transactions, and building trust between workers and employers. Our platform ensures that every job is completed professionally and every worker is paid fairly.
                    </p>
                </div>
                <div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="stat-card rounded-2xl p-6 text-center">
                            <div class="text-5xl font-bold text-white mb-2">10K+</div>
                            <div class="text-sm text-white text-opacity-70">Active Workers</div>
                        </div>
                        <div class="stat-card rounded-2xl p-6 text-center">
                            <div class="text-5xl font-bold text-white mb-2">5K+</div>
                            <div class="text-sm text-white text-opacity-70">Employers</div>
                        </div>
                        <div class="stat-card rounded-2xl p-6 text-center">
                            <div class="text-5xl font-bold text-white mb-2">50K+</div>
                            <div class="text-sm text-white text-opacity-70">Jobs Completed</div>
                        </div>
                        <div class="stat-card rounded-2xl p-6 text-center">
                            <div class="text-5xl font-bold text-white mb-2">98%</div>
                            <div class="text-sm text-white text-opacity-70">Satisfaction</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Our Values -->
            <div class="mb-16">
                <h2 class="text-4xl font-bold text-gray-900 text-center mb-12">Our Values</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="glass-card rounded-2xl p-8 text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-purple-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                            <i class="fas fa-handshake text-white text-2xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2 text-lg">Trust & Safety</h3>
                        <p class="text-gray-700 text-sm">We verify all users and ensure secure transactions for peace of mind.</p>
                    </div>
                    <div class="glass-card rounded-2xl p-8 text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-pink-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                            <i class="fas fa-star text-white text-2xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2 text-lg">Quality Service</h3>
                        <p class="text-gray-700 text-sm">We maintain high standards to ensure excellent experiences for everyone.</p>
                    </div>
                    <div class="glass-card rounded-2xl p-8 text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-pink-400 to-red-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                            <i class="fas fa-users text-white text-2xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2 text-lg">Community First</h3>
                        <p class="text-gray-700 text-sm">We're building a supportive community where everyone can thrive.</p>
                    </div>
                    <div class="glass-card rounded-2xl p-8 text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                            <i class="fas fa-rocket text-white text-2xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2 text-lg">Innovation</h3>
                        <p class="text-gray-700 text-sm">We continuously improve our platform with the latest technology.</p>
                    </div>
                </div>
            </div>

            <!-- Mission & Vision -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
                <div class="glass-card-dark rounded-3xl p-8">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <i class="fas fa-bullseye text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Our Mission</h3>
                    <p class="text-white text-opacity-80 leading-relaxed">To empower individuals and businesses by providing a trusted platform that connects skilled workers with meaningful job opportunities, fostering economic growth and financial independence across Uganda.</p>
                </div>
                <div class="glass-card-dark rounded-3xl p-8">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-teal-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <i class="fas fa-eye text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Our Vision</h3>
                    <p class="text-white text-opacity-80 leading-relaxed">To become East Africa's most trusted and innovative platform for flexible work, where every person has access to fair employment opportunities and every business can find reliable talent.</p>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="text-center glass-card-dark rounded-3xl p-12">
                <h2 class="text-4xl font-bold text-white mb-4">Join Our Growing Community</h2>
                <p class="text-white text-opacity-80 mb-8 max-w-2xl mx-auto text-lg">Be part of the future of work in Uganda. Whether you're looking for opportunities or talent, we're here to help.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="/register?type=worker" class="bg-white text-blue-primary px-8 py-4 rounded-xl font-semibold hover:bg-opacity-90 transition duration-300 shadow-lg">
                        Join as Worker
                    </a>
                    <a href="/register?type=employer" class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-8 py-4 rounded-xl font-semibold hover:shadow-2xl transition duration-300 shadow-lg">
                        Join as Employer
                    </a>
                </div>
            </div>
        </div>
    </section>

   
    @include('includes.footer')
</body>
</html>
