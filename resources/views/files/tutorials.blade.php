<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutorials & Guides - JOB-lyNK</title>
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
            transform: translateY(-2px);
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
                    <a href="/help-center" class="text-white hover:text-blue-light px-3 py-2 rounded-md text-sm font-medium">Help Center</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="py-20 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-5xl font-bold text-gray-900 mb-4">Tutorials & Guides</h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Step-by-step guides to help you master JOB-lyNK and achieve your goals.</p>
            </div>

            <!-- Quick Start Guides -->
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Quick Start Guides</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="glass-card rounded-xl p-8">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center mb-6">
                            <i class="fas fa-user-plus text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Getting Started as a Job Seeker</h3>
                        <p class="text-gray-600 mb-6">Learn how to create your profile, search for jobs, and land your first opportunity.</p>
                        <ul class="space-y-2 text-gray-700 mb-6">
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Create and optimize your profile</li>
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Search and filter jobs effectively</li>
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Submit winning applications</li>
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Track your application status</li>
                        </ul>
                        <a href="#" class="text-blue-primary font-semibold hover:text-blue-dark">Start Tutorial →</a>
                    </div>

                    <div class="glass-card rounded-xl p-8">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center mb-6">
                            <i class="fas fa-briefcase text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Getting Started as an Employer</h3>
                        <p class="text-gray-600 mb-6">Discover how to post jobs, review applications, and hire the best candidates.</p>
                        <ul class="space-y-2 text-gray-700 mb-6">
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Set up your company profile</li>
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Create effective job postings</li>
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Review and manage applications</li>
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Use AI matching features</li>
                        </ul>
                        <a href="#" class="text-blue-primary font-semibold hover:text-blue-dark">Start Tutorial →</a>
                    </div>
                </div>
            </div>

            <!-- Video Tutorials -->
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Video Tutorials</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="glass-card rounded-xl overflow-hidden">
                        <div class="bg-gradient-to-br from-blue-400 to-blue-600 h-48 flex items-center justify-center">
                            <i class="fas fa-play-circle text-white text-6xl opacity-75"></i>
                        </div>
                        <div class="p-6">
                            <h3 class="font-bold text-gray-900 mb-2">How to Create Your Profile</h3>
                            <p class="text-gray-600 text-sm mb-4">A complete walkthrough of setting up your professional profile.</p>
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-clock mr-2"></i>
                                <span>5:30 minutes</span>
                            </div>
                        </div>
                    </div>

                    <div class="glass-card rounded-xl overflow-hidden">
                        <div class="bg-gradient-to-br from-green-400 to-green-600 h-48 flex items-center justify-center">
                            <i class="fas fa-play-circle text-white text-6xl opacity-75"></i>
                        </div>
                        <div class="p-6">
                            <h3 class="font-bold text-gray-900 mb-2">Using AI Job Matching</h3>
                            <p class="text-gray-600 text-sm mb-4">Learn how our AI finds the perfect jobs for you automatically.</p>
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-clock mr-2"></i>
                                <span>4:15 minutes</span>
                            </div>
                        </div>
                    </div>

                    <div class="glass-card rounded-xl overflow-hidden">
                        <div class="bg-gradient-to-br from-purple-400 to-purple-600 h-48 flex items-center justify-center">
                            <i class="fas fa-play-circle text-white text-6xl opacity-75"></i>
                        </div>
                        <div class="p-6">
                            <h3 class="font-bold text-gray-900 mb-2">Posting Your First Job</h3>
                            <p class="text-gray-600 text-sm mb-4">Step-by-step guide to creating an effective job posting.</p>
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-clock mr-2"></i>
                                <span>6:45 minutes</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feature Guides -->
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Feature Guides</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="glass-card rounded-xl p-6">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-search text-blue-primary text-xl"></i>
                            </div>
                            <h3 class="font-bold text-gray-900">Advanced Job Search</h3>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">Master filters, keywords, and search operators to find exactly what you need.</p>
                        <a href="#" class="text-blue-primary text-sm font-semibold hover:text-blue-dark">Read Guide →</a>
                    </div>

                    <div class="glass-card rounded-xl p-6">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-file-alt text-purple-600 text-xl"></i>
                            </div>
                            <h3 class="font-bold text-gray-900">Resume Optimization</h3>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">Tips and tricks to make your resume stand out to employers.</p>
                        <a href="#" class="text-blue-primary text-sm font-semibold hover:text-blue-dark">Read Guide →</a>
                    </div>

                    <div class="glass-card rounded-xl p-6">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-bell text-green-600 text-xl"></i>
                            </div>
                            <h3 class="font-bold text-gray-900">Notification Settings</h3>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">Configure alerts to never miss important job opportunities.</p>
                        <a href="#" class="text-blue-primary text-sm font-semibold hover:text-blue-dark">Read Guide →</a>
                    </div>

                    <div class="glass-card rounded-xl p-6">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-comments text-yellow-600 text-xl"></i>
                            </div>
                            <h3 class="font-bold text-gray-900">Messaging System</h3>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">Communicate effectively with employers and job seekers.</p>
                        <a href="#" class="text-blue-primary text-sm font-semibold hover:text-blue-dark">Read Guide →</a>
                    </div>

                    <div class="glass-card rounded-xl p-6">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-chart-bar text-red-600 text-xl"></i>
                            </div>
                            <h3 class="font-bold text-gray-900">Analytics Dashboard</h3>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">Track your job posting performance and application metrics.</p>
                        <a href="#" class="text-blue-primary text-sm font-semibold hover:text-blue-dark">Read Guide →</a>
                    </div>

                    <div class="glass-card rounded-xl p-6">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-shield-alt text-indigo-600 text-xl"></i>
                            </div>
                            <h3 class="font-bold text-gray-900">Account Security</h3>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">Keep your account safe with two-factor authentication and more.</p>
                        <a href="#" class="text-blue-primary text-sm font-semibold hover:text-blue-dark">Read Guide →</a>
                    </div>
                </div>
            </div>

            <!-- Best Practices -->
            <div class="glass-card rounded-2xl p-12 mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Best Practices</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">For Job Seekers</h3>
                        <ul class="space-y-3 text-gray-700">
                            <li class="flex items-start">
                                <i class="fas fa-star text-yellow-500 mr-3 mt-1"></i>
                                <span>Keep your profile updated with latest skills and experience</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-star text-yellow-500 mr-3 mt-1"></i>
                                <span>Apply early to jobs - employers review applications as they come in</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-star text-yellow-500 mr-3 mt-1"></i>
                                <span>Customize your cover letter for each application</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-star text-yellow-500 mr-3 mt-1"></i>
                                <span>Respond promptly to employer messages</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-star text-yellow-500 mr-3 mt-1"></i>
                                <span>Use professional photos and complete all profile sections</span>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">For Employers</h3>
                        <ul class="space-y-3 text-gray-700">
                            <li class="flex items-start">
                                <i class="fas fa-star text-yellow-500 mr-3 mt-1"></i>
                                <span>Write clear, detailed job descriptions with specific requirements</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-star text-yellow-500 mr-3 mt-1"></i>
                                <span>Offer competitive compensation to attract top talent</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-star text-yellow-500 mr-3 mt-1"></i>
                                <span>Review applications within 24-48 hours</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-star text-yellow-500 mr-3 mt-1"></i>
                                <span>Use AI matching to find the best candidates quickly</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-star text-yellow-500 mr-3 mt-1"></i>
                                <span>Provide feedback to candidates, even if not selected</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- CTA -->
            <div class="glass-card rounded-2xl p-12 text-center">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Need More Help?</h2>
                <p class="text-gray-600 mb-8 max-w-2xl mx-auto">Visit our Help Center for detailed FAQs and support articles, or contact our support team.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="/help-center" class="inline-block bg-blue-primary text-white px-8 py-4 rounded-xl font-semibold hover:bg-blue-dark transition">
                        Visit Help Center
                    </a>
                    <a href="/contact" class="inline-block bg-white text-blue-primary border-2 border-blue-primary px-8 py-4 rounded-xl font-semibold hover:bg-blue-50 transition">
                        Contact Support
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
