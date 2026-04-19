<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms of Service - JOB-lyNK</title>
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
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-blue-primary shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="{{ route('home') }}" class="text-white text-2xl font-bold">JOB-lyNK</a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('register') }}" class="text-blue-light hover:text-white px-3 py-2 rounded-md text-sm font-medium">Back to Registration</a>
                    <a href="{{ route('home') }}" class="bg-white text-blue-primary px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-100 transition-colors">Home</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-blue-primary to-blue-secondary py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white bg-opacity-20 rounded-full mb-6">
                <i class="fas fa-file-contract text-2xl text-white"></i>
            </div>
            <h1 class="text-4xl font-bold text-white mb-4">Terms of Service</h1>
            <p class="text-xl text-blue-light max-w-2xl mx-auto">
                Understanding your rights and responsibilities on the JOB-lyNK platform
            </p>
            <div class="mt-6 text-sm text-blue-light">
                <i class="fas fa-calendar-alt mr-2"></i>
                Last Updated: January 26, 2026
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Quick Navigation -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">
                <i class="fas fa-compass mr-2 text-blue-primary"></i>
                Quick Navigation
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <a href="#acceptance" class="text-blue-primary hover:text-blue-dark text-sm font-medium">1. Acceptance</a>
                <a href="#services" class="text-blue-primary hover:text-blue-dark text-sm font-medium">2. Services</a>
                <a href="#accounts" class="text-blue-primary hover:text-blue-dark text-sm font-medium">3. User Accounts</a>
                <a href="#conduct" class="text-blue-primary hover:text-blue-dark text-sm font-medium">4. User Conduct</a>
                <a href="#payments" class="text-blue-primary hover:text-blue-dark text-sm font-medium">5. Payments</a>
                <a href="#liability" class="text-blue-primary hover:text-blue-dark text-sm font-medium">6. Liability</a>
                <a href="#disputes" class="text-blue-primary hover:text-blue-dark text-sm font-medium">7. Disputes</a>
                <a href="#termination" class="text-blue-primary hover:text-blue-dark text-sm font-medium">8. Termination</a>
            </div>
        </div>

        <!-- Terms Content -->
        <div class="space-y-8">
            <!-- Section 1: Acceptance -->
            <section id="acceptance" class="bg-white rounded-xl shadow-lg p-8">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-blue-primary rounded-full flex items-center justify-center mr-4">
                        <span class="text-white font-bold">1</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Acceptance of Terms</h2>
                </div>
                <div class="prose prose-blue max-w-none">
                    <p class="text-gray-700 leading-relaxed mb-4">
                        By accessing and using JOB-lyNK ("the Platform"), you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to abide by the above, please do not use this service.
                    </p>
                    <div class="bg-blue-50 border-l-4 border-blue-primary p-4 rounded-r-lg">
                        <p class="text-blue-800 font-medium">
                            <i class="fas fa-info-circle mr-2"></i>
                            By creating an account, you confirm that you are at least 18 years old and have the legal capacity to enter into this agreement.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Section 2: Services -->
            <section id="services" class="bg-white rounded-xl shadow-lg p-8">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-blue-primary rounded-full flex items-center justify-center mr-4">
                        <span class="text-white font-bold">2</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Platform Services</h2>
                </div>
                <div class="prose prose-blue max-w-none">
                    <p class="text-gray-700 leading-relaxed mb-4">
                        JOB-lyNK provides a digital marketplace connecting job seekers (Workers) with employers. Our services include:
                    </p>
                    <div class="grid md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-green-800 mb-2">
                                <i class="fas fa-user-tie mr-2"></i>For Workers
                            </h4>
                            <ul class="text-green-700 text-sm space-y-1">
                                <li>• Job search and application tools</li>
                                <li>• Profile creation and management</li>
                                <li>• Direct messaging with employers</li>
                                <li>• Application tracking</li>
                            </ul>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-purple-800 mb-2">
                                <i class="fas fa-briefcase mr-2"></i>For Employers
                            </h4>
                            <ul class="text-purple-700 text-sm space-y-1">
                                <li>• Job posting and management</li>
                                <li>• Candidate screening tools</li>
                                <li>• AI-powered recommendations</li>
                                <li>• Interview scheduling</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 3: User Accounts -->
            <section id="accounts" class="bg-white rounded-xl shadow-lg p-8">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-blue-primary rounded-full flex items-center justify-center mr-4">
                        <span class="text-white font-bold">3</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">User Accounts & Responsibilities</h2>
                </div>
                <div class="prose prose-blue max-w-none">
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Account Security</h4>
                            <p class="text-gray-700">You are responsible for maintaining the confidentiality of your account credentials and for all activities that occur under your account.</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Accurate Information</h4>
                            <p class="text-gray-700">You agree to provide accurate, current, and complete information during registration and to update such information to keep it accurate, current, and complete.</p>
                        </div>
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg">
                            <p class="text-yellow-800">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                <strong>Important:</strong> Providing false information may result in immediate account suspension and potential legal action.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 4: User Conduct -->
            <section id="conduct" class="bg-white rounded-xl shadow-lg p-8">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-blue-primary rounded-full flex items-center justify-center mr-4">
                        <span class="text-white font-bold">4</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Acceptable Use & Ethical Behavior</h2>
                </div>
                <div class="prose prose-blue max-w-none">
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-900 mb-3">Prohibited Activities</h4>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="bg-red-50 p-4 rounded-lg">
                                <h5 class="font-medium text-red-800 mb-2">Strictly Forbidden</h5>
                                <ul class="text-red-700 text-sm space-y-1">
                                    <li>• Harassment or discrimination</li>
                                    <li>• Fraudulent job postings</li>
                                    <li>• Identity theft or impersonation</li>
                                    <li>• Spam or unsolicited messages</li>
                                    <li>• Sharing inappropriate content</li>
                                </ul>
                            </div>
                            <div class="bg-orange-50 p-4 rounded-lg">
                                <h5 class="font-medium text-orange-800 mb-2">Platform Misuse</h5>
                                <ul class="text-orange-700 text-sm space-y-1">
                                    <li>• Circumventing platform fees</li>
                                    <li>• Creating multiple accounts</li>
                                    <li>• Automated data scraping</li>
                                    <li>• Reverse engineering</li>
                                    <li>• Violating intellectual property</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="bg-red-100 border border-red-300 p-6 rounded-lg">
                        <h4 class="font-bold text-red-800 mb-3">
                            <i class="fas fa-gavel mr-2"></i>Consequences of Unethical Behavior
                        </h4>
                        <p class="text-red-700 mb-3">
                            Users engaging in unethical behavior, fraud, or violations of these terms may face:
                        </p>
                        <ul class="text-red-700 space-y-2">
                            <li>• Immediate account suspension or termination</li>
                            <li>• Forfeiture of any pending payments or deposits</li>
                            <li>• Legal action and prosecution under Ugandan law</li>
                            <li>• <strong>Liability for legal fees up to UGX 150,000</strong></li>
                            <li>• Permanent ban from the platform</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Section 5: Payments -->
            <section id="payments" class="bg-white rounded-xl shadow-lg p-8">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-blue-primary rounded-full flex items-center justify-center mr-4">
                        <span class="text-white font-bold">5</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Payment Terms</h2>
                </div>
                <div class="prose prose-blue max-w-none">
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Platform Fees</h4>
                            <p class="text-gray-700">JOB-lyNK charges service fees for successful job placements and premium features. All fees are clearly disclosed before any transaction.</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Payment Processing</h4>
                            <p class="text-gray-700">Payments are processed securely through our verified payment partners. We do not store sensitive payment information on our servers.</p>
                        </div>
                        <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg">
                            <p class="text-green-800">
                                <i class="fas fa-shield-alt mr-2"></i>
                                All transactions are protected by industry-standard encryption and fraud detection systems.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 6: Liability -->
            <section id="liability" class="bg-white rounded-xl shadow-lg p-8">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-blue-primary rounded-full flex items-center justify-center mr-4">
                        <span class="text-white font-bold">6</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Limited Liability & Disclaimers</h2>
                </div>
                <div class="prose prose-blue max-w-none">
                    <div class="bg-gray-100 border border-gray-300 p-6 rounded-lg mb-6">
                        <h4 class="font-bold text-gray-800 mb-3">
                            <i class="fas fa-exclamation-circle mr-2"></i>Platform Limitations
                        </h4>
                        <p class="text-gray-700 mb-3">
                            JOB-lyNK serves as a marketplace platform connecting users. We are not responsible for:
                        </p>
                        <ul class="text-gray-700 space-y-1">
                            <li>• The quality, safety, or legality of jobs posted</li>
                            <li>• The truth or accuracy of user profiles</li>
                            <li>• The performance of work or payment disputes between users</li>
                            <li>• Any damages arising from user interactions</li>
                        </ul>
                    </div>
                    <div class="bg-blue-50 border border-blue-300 p-6 rounded-lg">
                        <h4 class="font-bold text-blue-800 mb-3">Maximum Liability</h4>
                        <p class="text-blue-700">
                            Our total liability to any user for all claims arising from the use of JOB-lyNK shall not exceed the amount of fees paid by that user to the platform in the 12 months preceding the claim, up to a maximum of <strong>UGX 150,000</strong>.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Section 7: Disputes -->
            <section id="disputes" class="bg-white rounded-xl shadow-lg p-8">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-blue-primary rounded-full flex items-center justify-center mr-4">
                        <span class="text-white font-bold">7</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Dispute Resolution</h2>
                </div>
                <div class="prose prose-blue max-w-none">
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Resolution Process</h4>
                            <ol class="text-gray-700 space-y-2">
                                <li>1. <strong>Direct Communication:</strong> Users should first attempt to resolve disputes directly</li>
                                <li>2. <strong>Platform Mediation:</strong> Contact our support team for assistance</li>
                                <li>3. <strong>Formal Arbitration:</strong> Binding arbitration under Ugandan law if needed</li>
                            </ol>
                        </div>
                        <div class="bg-purple-50 border-l-4 border-purple-400 p-4 rounded-r-lg">
                            <p class="text-purple-800">
                                <i class="fas fa-balance-scale mr-2"></i>
                                Legal disputes will be governed by the laws of Uganda. Users agree to jurisdiction in Ugandan courts.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 8: Termination -->
            <section id="termination" class="bg-white rounded-xl shadow-lg p-8">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-blue-primary rounded-full flex items-center justify-center mr-4">
                        <span class="text-white font-bold">8</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Account Termination</h2>
                </div>
                <div class="prose prose-blue max-w-none">
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Voluntary Termination</h4>
                            <p class="text-gray-700">You may terminate your account at any time through your account settings. Data deletion follows our Privacy Policy guidelines.</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Platform Termination</h4>
                            <p class="text-gray-700">We reserve the right to suspend or terminate accounts that violate these terms, with or without notice, depending on the severity of the violation.</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Contact Section -->
        <div class="bg-gradient-to-r from-blue-primary to-blue-secondary rounded-xl p-8 mt-12 text-white text-center">
            <h3 class="text-2xl font-bold mb-4">Questions About These Terms?</h3>
            <p class="mb-6 text-blue-light">Our legal team is here to help clarify any concerns you may have.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="mailto:leemeeya851@gmail.com" class="bg-white text-blue-primary px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    <i class="fas fa-envelope mr-2"></i>Contact Legal Team
                </a>
                <a href="tel:+256748550372" class="border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-primary transition-colors">
                    <i class="fas fa-phone mr-2"></i>General Support
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8 mt-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-gray-400">
                © 2026 JOB-lyNK. All rights reserved. | 
                <a href="{{ route('privacy-policy') }}" class="text-blue-400 hover:text-blue-300">Privacy Policy</a> | 
                <a href="{{ route('terms-of-service') }}" class="text-blue-400 hover:text-blue-300">Terms of Service</a>
            </p>
        </div>
    </footer>

    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Highlight current section in navigation
        window.addEventListener('scroll', function() {
            const sections = document.querySelectorAll('section[id]');
            const navLinks = document.querySelectorAll('a[href^="#"]');
            
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop - 100;
                if (window.pageYOffset >= sectionTop) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('font-bold');
                if (link.getAttribute('href') === '#' + current) {
                    link.classList.add('font-bold');
                }
            });
        });
    </script>
</body>
</html>