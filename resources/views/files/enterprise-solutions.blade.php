<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enterprise Solutions - JOB-lyNK</title>
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
                <h1 class="text-5xl font-bold text-gray-900 mb-4">Enterprise Solutions</h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Scalable hiring solutions for large organizations. Streamline your recruitment process with our enterprise-grade platform.</p>
            </div>

            <!-- Key Features -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <div class="glass-card rounded-2xl p-8 text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-users-cog text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Dedicated Account Manager</h3>
                    <p class="text-gray-600">Get personalized support from a dedicated account manager who understands your business needs.</p>
                </div>

                <div class="glass-card rounded-2xl p-8 text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-chart-line text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Advanced Analytics</h3>
                    <p class="text-gray-600">Track hiring metrics, time-to-fill, candidate quality, and ROI with comprehensive dashboards.</p>
                </div>

                <div class="glass-card rounded-2xl p-8 text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-shield-alt text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Enterprise Security</h3>
                    <p class="text-gray-600">Bank-level security, SSO integration, and compliance with international data protection standards.</p>
                </div>
            </div>

            <!-- Enterprise Features -->
            <div class="glass-card rounded-2xl p-12 mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">What's Included</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-start space-x-4">
                        <i class="fas fa-check-circle text-green-500 text-2xl mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Unlimited Job Postings</h4>
                            <p class="text-gray-600">Post as many jobs as you need without worrying about limits or extra fees.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <i class="fas fa-check-circle text-green-500 text-2xl mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Multi-User Access</h4>
                            <p class="text-gray-600">Add unlimited team members with customizable roles and permissions.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <i class="fas fa-check-circle text-green-500 text-2xl mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">API Integration</h4>
                            <p class="text-gray-600">Integrate with your existing HR systems and ATS platforms.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <i class="fas fa-check-circle text-green-500 text-2xl mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Priority Support</h4>
                            <p class="text-gray-600">24/7 priority support via phone, email, and dedicated Slack channel.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <i class="fas fa-check-circle text-green-500 text-2xl mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Custom Branding</h4>
                            <p class="text-gray-600">White-label career pages with your company branding and domain.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <i class="fas fa-check-circle text-green-500 text-2xl mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Bulk Operations</h4>
                            <p class="text-gray-600">Manage multiple job postings and applications efficiently with bulk actions.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pricing -->
            <div class="glass-card rounded-2xl p-12 mb-16 text-center">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Custom Pricing for Your Needs</h2>
                <p class="text-gray-600 mb-8 max-w-2xl mx-auto">Our enterprise solutions are tailored to your organization's size and requirements. Contact us for a personalized quote.</p>
                <a href="/contact" class="inline-block bg-blue-primary text-white px-8 py-4 rounded-xl font-semibold hover:bg-blue-dark transition">
                    Request a Demo <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            <!-- Trusted By -->
            <div class="text-center">
                <h3 class="text-2xl font-bold text-gray-900 mb-8">Trusted by Leading Organizations</h3>
                <p class="text-gray-600">Join hundreds of enterprises that trust JOB-lyNK for their hiring needs.</p>
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
