<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Center - JOB-lyNK</title>
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
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.1);
        }

        .category-card {
            cursor: pointer;
        }

        .faq-item {
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .faq-item:last-child {
            border-bottom: none;
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .faq-answer.active {
            max-height: 500px;
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
                    <a href="/jobs" class="text-white hover:text-blue-light px-3 py-2 rounded-md text-sm font-medium">Find Jobs</a>
                    <a href="/contact" class="text-white hover:text-blue-light px-3 py-2 rounded-md text-sm font-medium">Contact</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="py-16 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-5xl font-bold text-gray-900 mb-4">Help Center</h1>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">Your trust, support, and self-service hub. Find answers, get help, and learn how to make the most of JOB-lyNK.</p>
            </div>

            <!-- Search Bar -->
            <div class="max-w-3xl mx-auto mb-16">
                <div class="glass-card rounded-2xl p-2">
                    <div class="relative">
                        <input type="text" 
                               id="helpSearch" 
                               placeholder="Search for help articles, FAQs, guides..." 
                               class="w-full px-6 py-4 pr-12 rounded-xl border-0 focus:outline-none focus:ring-2 focus:ring-blue-primary text-gray-800">
                        <button class="absolute right-4 top-1/2 transform -translate-y-1/2 text-blue-primary hover:text-blue-secondary">
                            <i class="fas fa-search text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Top FAQs -->
            <div class="mb-16">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Top Questions</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 max-w-5xl mx-auto">
                    <button onclick="showQuickAnswer('create-account')" class="glass-card rounded-xl p-4 text-center hover:bg-blue-50 transition">
                        <i class="fas fa-rocket text-blue-primary text-2xl mb-2"></i>
                        <p class="text-gray-700 text-sm font-medium">How do I create an account?</p>
                    </button>
                    <button onclick="showQuickAnswer('apply-jobs')" class="glass-card rounded-xl p-4 text-center hover:bg-blue-50 transition">
                        <i class="fas fa-briefcase text-blue-primary text-2xl mb-2"></i>
                        <p class="text-gray-700 text-sm font-medium">How to apply for jobs?</p>
                    </button>
                    <button onclick="showQuickAnswer('post-job')" class="glass-card rounded-xl p-4 text-center hover:bg-blue-50 transition">
                        <i class="fas fa-building text-blue-primary text-2xl mb-2"></i>
                        <p class="text-gray-700 text-sm font-medium">How to post a job?</p>
                    </button>
                </div>
                
                <!-- Quick Answer Modal -->
                <div id="quickAnswerModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 overflow-y-auto">
                    <div class="glass-card rounded-2xl max-w-2xl w-full my-8 relative max-h-[90vh] overflow-y-auto">
                        <div class="sticky top-0 bg-white bg-opacity-95 backdrop-blur-sm p-4 rounded-t-2xl border-b border-gray-200 flex justify-between items-center z-10">
                            <h2 class="text-xl font-bold text-gray-900" id="modalTitle"></h2>
                            <button onclick="closeQuickAnswer()" class="text-gray-500 hover:text-gray-700 transition">
                                <i class="fas fa-times text-2xl"></i>
                            </button>
                        </div>
                        <div id="quickAnswerContent" class="p-6"></div>
                    </div>
                </div>
            </div>

            <!-- Help Categories -->
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Browse by Category</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    
                    <!-- Getting Started -->
                    <div class="glass-card rounded-2xl p-6 category-card" onclick="toggleCategory('getting-started')">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center mb-4">
                            <i class="fas fa-rocket text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Getting Started</h3>
                        <p class="text-gray-600 text-sm mb-4">Learn the basics of using JOB-lyNK</p>
                        <ul class="text-sm text-gray-700 space-y-2">
                            <li><i class="fas fa-check-circle text-blue-primary mr-2"></i>Creating an Account</li>
                            <li><i class="fas fa-check-circle text-blue-primary mr-2"></i>Logging In / Forgot Password</li>
                            <li><i class="fas fa-check-circle text-blue-primary mr-2"></i>Setting Up Your Profile</li>
                            <li><i class="fas fa-check-circle text-blue-primary mr-2"></i>Account Verification & Security</li>
                        </ul>
                    </div>

                    <!-- Job Seekers -->
                    <div class="glass-card rounded-2xl p-6 category-card" onclick="toggleCategory('job-seekers')">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center mb-4">
                            <i class="fas fa-user-tie text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Job Seekers</h3>
                        <p class="text-gray-600 text-sm mb-4">Everything you need to find your next job</p>
                        <ul class="text-sm text-gray-700 space-y-2">
                            <li><i class="fas fa-check-circle text-purple-500 mr-2"></i>Search & Apply for Jobs</li>
                            <li><i class="fas fa-check-circle text-purple-500 mr-2"></i>Track Applications</li>
                            <li><i class="fas fa-check-circle text-purple-500 mr-2"></i>Resume & Cover Letter Tips</li>
                            <li><i class="fas fa-check-circle text-purple-500 mr-2"></i>AI Job Match Feature</li>
                        </ul>
                    </div>

                    <!-- Employers -->
                    <div class="glass-card rounded-2xl p-6 category-card" onclick="toggleCategory('employers')">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-2xl flex items-center justify-center mb-4">
                            <i class="fas fa-building text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Employers</h3>
                        <p class="text-gray-600 text-sm mb-4">Tools to find the perfect candidates</p>
                        <ul class="text-sm text-gray-700 space-y-2">
                            <li><i class="fas fa-check-circle text-green-500 mr-2"></i>Posting a Job</li>
                            <li><i class="fas fa-check-circle text-green-500 mr-2"></i>Managing Applications</li>
                            <li><i class="fas fa-check-circle text-green-500 mr-2"></i>AI Candidate Match</li>
                            <li><i class="fas fa-check-circle text-green-500 mr-2"></i>Company Profile Setup</li>
                        </ul>
                    </div>

                    <!-- Payments -->
                    <div class="glass-card rounded-2xl p-6 category-card" onclick="toggleCategory('payments')">
                        <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl flex items-center justify-center mb-4">
                            <i class="fas fa-credit-card text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Payments & Transactions</h3>
                        <p class="text-gray-600 text-sm mb-4">Billing, subscriptions, and refunds</p>
                        <ul class="text-sm text-gray-700 space-y-2">
                            <li><i class="fas fa-check-circle text-orange-500 mr-2"></i>Subscription Plans</li>
                            <li><i class="fas fa-check-circle text-orange-500 mr-2"></i>Invoice & Receipts</li>
                            <li><i class="fas fa-check-circle text-orange-500 mr-2"></i>Refund Policy</li>
                            <li><i class="fas fa-check-circle text-orange-500 mr-2"></i>Payment Security</li>
                        </ul>
                    </div>

                    <!-- Technical Help -->
                    <div class="glass-card rounded-2xl p-6 category-card" onclick="toggleCategory('technical')">
                        <div class="w-16 h-16 bg-gradient-to-br from-red-400 to-pink-500 rounded-2xl flex items-center justify-center mb-4">
                            <i class="fas fa-tools text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Technical Help</h3>
                        <p class="text-gray-600 text-sm mb-4">Troubleshooting and technical support</p>
                        <ul class="text-sm text-gray-700 space-y-2">
                            <li><i class="fas fa-check-circle text-pink-500 mr-2"></i>Browser Compatibility</li>
                            <li><i class="fas fa-check-circle text-pink-500 mr-2"></i>Login Issues</li>
                            <li><i class="fas fa-check-circle text-pink-500 mr-2"></i>Notifications Not Working</li>
                            <li><i class="fas fa-check-circle text-pink-500 mr-2"></i>Data Management</li>
                        </ul>
                    </div>

                    <!-- Policies & Safety -->
                    <div class="glass-card rounded-2xl p-6 category-card" onclick="toggleCategory('policies')">
                        <div class="w-16 h-16 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-2xl flex items-center justify-center mb-4">
                            <i class="fas fa-shield-alt text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Policies & Safety</h3>
                        <p class="text-gray-600 text-sm mb-4">Your privacy and security matter</p>
                        <ul class="text-sm text-gray-700 space-y-2">
                            <li><i class="fas fa-check-circle text-indigo-500 mr-2"></i>Privacy Policy</li>
                            <li><i class="fas fa-check-circle text-indigo-500 mr-2"></i>Terms of Service</li>
                            <li><i class="fas fa-check-circle text-indigo-500 mr-2"></i>Data Security</li>
                            <li><i class="fas fa-check-circle text-indigo-500 mr-2"></i>Report Fraud</li>
                        </ul>
                    </div>

                </div>
            </div>

            <!-- FAQ Section -->
            <div class="mb-16 max-w-4xl mx-auto">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Frequently Asked Questions</h2>
                <div class="glass-card rounded-2xl p-8">
                    
                    <div class="faq-item py-4">
                        <button onclick="toggleFAQ(this)" class="w-full text-left flex justify-between items-center">
                            <span class="font-semibold text-gray-900">How do I create an account on JOB-lyNK?</span>
                            <i class="fas fa-chevron-down text-blue-primary transition-transform"></i>
                        </button>
                        <div class="faq-answer mt-3 text-gray-600">
                            <p>Click on "Register" in the top navigation, choose whether you're a job seeker or employer, fill in your details, and verify your email. It takes less than 2 minutes!</p>
                        </div>
                    </div>

                    <div class="faq-item py-4">
                        <button onclick="toggleFAQ(this)" class="w-full text-left flex justify-between items-center">
                            <span class="font-semibold text-gray-900">How does the AI Job Match feature work?</span>
                            <i class="fas fa-chevron-down text-blue-primary transition-transform"></i>
                        </button>
                        <div class="faq-answer mt-3 text-gray-600">
                            <p>Our AI analyzes your skills, experience, and preferences to match you with the most relevant job opportunities. The more complete your profile, the better the matches!</p>
                        </div>
                    </div>

                    <div class="faq-item py-4">
                        <button onclick="toggleFAQ(this)" class="w-full text-left flex justify-between items-center">
                            <span class="font-semibold text-gray-900">Is JOB-lyNK free to use?</span>
                            <i class="fas fa-chevron-down text-blue-primary transition-transform"></i>
                        </button>
                        <div class="faq-answer mt-3 text-gray-600">
                            <p>Job seekers can use JOB-lyNK completely free. Employers have access to basic features for free, with premium plans available for advanced features like AI candidate matching and priority listings.</p>
                        </div>
                    </div>

                    <div class="faq-item py-4">
                        <button onclick="toggleFAQ(this)" class="w-full text-left flex justify-between items-center">
                            <span class="font-semibold text-gray-900">How do I report a fake job posting?</span>
                            <i class="fas fa-chevron-down text-blue-primary transition-transform"></i>
                        </button>
                        <div class="faq-answer mt-3 text-gray-600">
                            <p>Click the "Report" button on any job listing, select the reason, and provide details. Our team reviews all reports within 24 hours and takes appropriate action.</p>
                        </div>
                    </div>

                    <div class="faq-item py-4">
                        <button onclick="toggleFAQ(this)" class="w-full text-left flex justify-between items-center">
                            <span class="font-semibold text-gray-900">Can I edit my application after submitting?</span>
                            <i class="fas fa-chevron-down text-blue-primary transition-transform"></i>
                        </button>
                        <div class="faq-answer mt-3 text-gray-600">
                            <p>Once submitted, applications cannot be edited. However, you can update your profile and resume at any time, which will be reflected in future applications.</p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Contact Support -->
            <div class="mb-16">
                <div class="glass-card rounded-2xl p-8 text-center max-w-3xl mx-auto">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-headset text-white text-3xl"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Still Need Help?</h2>
                    <p class="text-gray-600 mb-6">Our support team is here to help you 24/7</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="/contact" class="bg-blue-primary text-white px-8 py-3 rounded-xl font-semibold hover:bg-blue-dark transition duration-300">
                            <i class="fas fa-envelope mr-2"></i>Contact Support
                        </a>
                        <a href="#" class="bg-white text-blue-primary border-2 border-blue-primary px-8 py-3 rounded-xl font-semibold hover:bg-blue-50 transition duration-300">
                            <i class="fas fa-comments mr-2"></i>Live Chat
                        </a>
                    </div>
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

    <script>
        // Quick answer content
        const quickAnswers = {
            'create-account': {
                title: 'How do I create an account?',
                icon: 'fa-rocket',
                content: `
                    <div class="space-y-4 text-gray-700">
                        <p class="text-lg">Getting started with JOB-lyNK is quick and easy! Follow these simple steps:</p>
                        
                        <div class="bg-blue-50 rounded-lg p-4">
                            <h4 class="font-semibold text-blue-900 mb-2">Step 1: Choose Your Account Type</h4>
                            <p>Click on "Register" in the top navigation and select:</p>
                            <ul class="list-disc ml-6 mt-2">
                                <li><strong>Job Seeker</strong> - If you're looking for work</li>
                                <li><strong>Employer</strong> - If you're hiring</li>
                            </ul>
                        </div>
                        
                        <div class="bg-purple-50 rounded-lg p-4">
                            <h4 class="font-semibold text-purple-900 mb-2">Step 2: Fill in Your Details</h4>
                            <p>Provide your basic information:</p>
                            <ul class="list-disc ml-6 mt-2">
                                <li>Full name</li>
                                <li>Email address</li>
                                <li>Phone number</li>
                                <li>Create a secure password</li>
                            </ul>
                        </div>
                        
                        <div class="bg-green-50 rounded-lg p-4">
                            <h4 class="font-semibold text-green-900 mb-2">Step 3: Verify Your Email</h4>
                            <p>Check your inbox for a verification email and click the link to activate your account.</p>
                        </div>
                        
                        <div class="bg-yellow-50 rounded-lg p-4">
                            <h4 class="font-semibold text-yellow-900 mb-2">Step 4: Complete Your Profile</h4>
                            <p>Add more details to make your profile stand out:</p>
                            <ul class="list-disc ml-6 mt-2">
                                <li>Upload a profile picture</li>
                                <li>Add your skills and experience</li>
                                <li>Upload your resume (for job seekers)</li>
                                <li>Add company details (for employers)</li>
                            </ul>
                        </div>
                        
                        <div class="mt-6 p-4 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg text-white">
                            <p class="font-semibold"><i class="fas fa-lightbulb mr-2"></i>Pro Tip:</p>
                            <p>Complete profiles get 3x more engagement! Take a few extra minutes to fill out all sections.</p>
                        </div>
                        
                        <div class="mt-6 text-center">
                            <a href="/register" class="inline-block bg-blue-primary text-white px-8 py-3 rounded-xl font-semibold hover:bg-blue-dark transition">
                                Create Account Now <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                `
            },
            'apply-jobs': {
                title: 'How to apply for jobs?',
                icon: 'fa-briefcase',
                content: `
                    <div class="space-y-4 text-gray-700">
                        <p class="text-lg">Finding and applying for your dream job on JOB-lyNK is simple:</p>
                        
                        <div class="bg-blue-50 rounded-lg p-4">
                            <h4 class="font-semibold text-blue-900 mb-2">Step 1: Search for Jobs</h4>
                            <p>Use our powerful search features:</p>
                            <ul class="list-disc ml-6 mt-2">
                                <li>Browse by category (Home Services, Delivery, Digital, Events)</li>
                                <li>Use the search bar to find specific jobs</li>
                                <li>Filter by location, salary, job type</li>
                                <li>Let our AI match you with relevant opportunities</li>
                            </ul>
                        </div>
                        
                        <div class="bg-purple-50 rounded-lg p-4">
                            <h4 class="font-semibold text-purple-900 mb-2">Step 2: Review Job Details</h4>
                            <p>Click on any job to see:</p>
                            <ul class="list-disc ml-6 mt-2">
                                <li>Job description and requirements</li>
                                <li>Salary and payment terms</li>
                                <li>Company information</li>
                                <li>Application deadline</li>
                            </ul>
                        </div>
                        
                        <div class="bg-green-50 rounded-lg p-4">
                            <h4 class="font-semibold text-green-900 mb-2">Step 3: Submit Your Application</h4>
                            <p>Click "Apply Now" and:</p>
                            <ul class="list-disc ml-6 mt-2">
                                <li>Your profile information is automatically included</li>
                                <li>Add a personalized cover letter (optional but recommended)</li>
                                <li>Attach additional documents if needed</li>
                                <li>Review and submit</li>
                            </ul>
                        </div>
                        
                        <div class="bg-yellow-50 rounded-lg p-4">
                            <h4 class="font-semibold text-yellow-900 mb-2">Step 4: Track Your Applications</h4>
                            <p>Monitor your application status in your dashboard:</p>
                            <ul class="list-disc ml-6 mt-2">
                                <li>See which applications are pending, reviewed, or accepted</li>
                                <li>Get notifications when employers respond</li>
                                <li>Communicate directly with employers</li>
                            </ul>
                        </div>
                        
                        <div class="mt-6 p-4 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg text-white">
                            <p class="font-semibold"><i class="fas fa-star mr-2"></i>Success Tips:</p>
                            <ul class="list-disc ml-6 mt-2">
                                <li>Apply early - employers review applications as they come in</li>
                                <li>Customize your cover letter for each job</li>
                                <li>Keep your profile updated with latest skills</li>
                                <li>Respond quickly to employer messages</li>
                            </ul>
                        </div>
                        
                        <div class="mt-6 text-center">
                            <a href="/jobs" class="inline-block bg-blue-primary text-white px-8 py-3 rounded-xl font-semibold hover:bg-blue-dark transition">
                                Browse Jobs Now <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                `
            },
            'post-job': {
                title: 'How to post a job?',
                icon: 'fa-building',
                content: `
                    <div class="space-y-4 text-gray-700">
                        <p class="text-lg">Find the perfect candidate by posting your job on JOB-lyNK:</p>
                        
                        <div class="bg-blue-50 rounded-lg p-4">
                            <h4 class="font-semibold text-blue-900 mb-2">Step 1: Access Job Posting</h4>
                            <p>From your employer dashboard:</p>
                            <ul class="list-disc ml-6 mt-2">
                                <li>Click "Post a Job" button</li>
                                <li>Or navigate to the "Post Job" section</li>
                                <li>Make sure you're logged in as an employer</li>
                            </ul>
                        </div>
                        
                        <div class="bg-purple-50 rounded-lg p-4">
                            <h4 class="font-semibold text-purple-900 mb-2">Step 2: Fill in Job Details</h4>
                            <p>Provide comprehensive information:</p>
                            <ul class="list-disc ml-6 mt-2">
                                <li><strong>Job Title</strong> - Clear and descriptive</li>
                                <li><strong>Category</strong> - Select the most relevant category</li>
                                <li><strong>Description</strong> - Detailed job responsibilities</li>
                                <li><strong>Requirements</strong> - Skills and qualifications needed</li>
                                <li><strong>Location</strong> - Where the work will be performed</li>
                            </ul>
                        </div>
                        
                        <div class="bg-green-50 rounded-lg p-4">
                            <h4 class="font-semibold text-green-900 mb-2">Step 3: Set Compensation</h4>
                            <p>Define payment terms:</p>
                            <ul class="list-disc ml-6 mt-2">
                                <li>Salary or hourly rate</li>
                                <li>Payment frequency (daily, weekly, monthly)</li>
                                <li>Additional benefits or perks</li>
                                <li>Payment method preferences</li>
                            </ul>
                        </div>
                        
                        <div class="bg-yellow-50 rounded-lg p-4">
                            <h4 class="font-semibold text-yellow-900 mb-2">Step 4: Review and Publish</h4>
                            <p>Before publishing:</p>
                            <ul class="list-disc ml-6 mt-2">
                                <li>Preview your job posting</li>
                                <li>Check for typos and clarity</li>
                                <li>Set application deadline</li>
                                <li>Choose visibility options</li>
                                <li>Click "Publish" to go live</li>
                            </ul>
                        </div>
                        
                        <div class="bg-indigo-50 rounded-lg p-4">
                            <h4 class="font-semibold text-indigo-900 mb-2">Step 5: Manage Applications</h4>
                            <p>Once published:</p>
                            <ul class="list-disc ml-6 mt-2">
                                <li>Receive notifications for new applications</li>
                                <li>Review candidate profiles</li>
                                <li>Use AI matching to find best fits</li>
                                <li>Schedule interviews directly</li>
                                <li>Communicate with applicants</li>
                            </ul>
                        </div>
                        
                        <div class="mt-6 p-4 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg text-white">
                            <p class="font-semibold"><i class="fas fa-trophy mr-2"></i>Best Practices:</p>
                            <ul class="list-disc ml-6 mt-2">
                                <li>Be specific about requirements to attract qualified candidates</li>
                                <li>Offer competitive compensation</li>
                                <li>Respond to applications within 24-48 hours</li>
                                <li>Use clear, professional language</li>
                                <li>Include company culture information</li>
                            </ul>
                        </div>
                        
                        <div class="mt-6 text-center">
                            <a href="/postjob" class="inline-block bg-blue-primary text-white px-8 py-3 rounded-xl font-semibold hover:bg-blue-dark transition">
                                Post a Job Now <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                `
            }
        };

        function showQuickAnswer(answerId) {
            const modal = document.getElementById('quickAnswerModal');
            const content = document.getElementById('quickAnswerContent');
            const modalTitle = document.getElementById('modalTitle');
            const answer = quickAnswers[answerId];
            
            if (answer) {
                modalTitle.textContent = answer.title;
                content.innerHTML = answer.content;
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                
                // Scroll to top of modal content
                setTimeout(() => {
                    const modalContent = modal.querySelector('.glass-card');
                    if (modalContent) {
                        modalContent.scrollTop = 0;
                    }
                }, 100);
            }
        }

        function closeQuickAnswer() {
            const modal = document.getElementById('quickAnswerModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        document.getElementById('quickAnswerModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeQuickAnswer();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeQuickAnswer();
            }
        });

        function toggleFAQ(button) {
            const answer = button.nextElementSibling;
            const icon = button.querySelector('i');
            
            answer.classList.toggle('active');
            icon.classList.toggle('fa-chevron-down');
            icon.classList.toggle('fa-chevron-up');
        }

        function toggleCategory(categoryId) {
            // You can add navigation or expand functionality here
            console.log('Category clicked:', categoryId);
        }

        // Search functionality
        document.getElementById('helpSearch').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            // Add search logic here
            console.log('Searching for:', searchTerm);
        });
    </script>
</body>
</html>
