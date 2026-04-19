<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - JOB-lyNK</title>
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
                <i class="fas fa-shield-alt text-2xl text-white"></i>
            </div>
            <h1 class="text-4xl font-bold text-white mb-4">Privacy Policy</h1>
            <p class="text-xl text-blue-light max-w-2xl mx-auto">
                Your privacy matters to us. Learn how we protect and handle your personal information.
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
                <a href="#collection" class="text-blue-primary hover:text-blue-dark text-sm font-medium">1. Data Collection</a>
                <a href="#usage" class="text-blue-primary hover:text-blue-dark text-sm font-medium">2. Data Usage</a>
                <a href="#sharing" class="text-blue-primary hover:text-blue-dark text-sm font-medium">3. Data Sharing</a>
                <a href="#security" class="text-blue-primary hover:text-blue-dark text-sm font-medium">4. Security</a>
                <a href="#cookies" class="text-blue-primary hover:text-blue-dark text-sm font-medium">5. Cookies</a>
                <a href="#rights" class="text-blue-primary hover:text-blue-dark text-sm font-medium">6. Your Rights</a>
                <a href="#retention" class="text-blue-primary hover:text-blue-dark text-sm font-medium">7. Data Retention</a>
                <a href="#contact" class="text-blue-primary hover:text-blue-dark text-sm font-medium">8. Contact Us</a>
            </div>
        </div>

        <!-- Privacy Content -->
        <div class="space-y-8">
            <!-- Section 1: Data Collection -->
            <section id="collection" class="bg-white rounded-xl shadow-lg p-8">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-blue-primary rounded-full flex items-center justify-center mr-4">
                        <span class="text-white font-bold">1</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Information We Collect</h2>
                </div>
                <div class="prose prose-blue max-w-none">
                    <p class="text-gray-700 leading-relaxed mb-6">
                        We collect information to provide better services to all our users. Here's what we collect and why:
                    </p>
                    
                    <div class="grid md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-blue-50 p-6 rounded-lg">
                            <h4 class="font-semibold text-blue-800 mb-3">
                                <i class="fas fa-user mr-2"></i>Personal Information
                            </h4>
                            <ul class="text-blue-700 text-sm space-y-2">
                                <li>• Name and contact details</li>
                                <li>• Email address and phone number</li>
                                <li>• Profile information and bio</li>
                                <li>• Location and work preferences</li>
                                <li>• Skills and experience data</li>
                            </ul>
                        </div>
                        <div class="bg-green-50 p-6 rounded-lg">
                            <h4 class="font-semibold text-green-800 mb-3">
                                <i class="fas fa-chart-line mr-2"></i>Usage Information
                            </h4>
                            <ul class="text-green-700 text-sm space-y-2">
                                <li>• Platform interaction data</li>
                                <li>• Job search and application history</li>
                                <li>• Communication records</li>
                                <li>• Device and browser information</li>
                                <li>• IP address and location data</li>
                            </ul>
                        </div>
                    </div>

                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg">
                        <p class="text-yellow-800">
                            <i class="fas fa-info-circle mr-2"></i>
                            <strong>Voluntary Information:</strong> Most information is provided voluntarily when you create an account or use our services. You can control what information you share.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Section 2: Data Usage -->
            <section id="usage" class="bg-white rounded-xl shadow-lg p-8">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-blue-primary rounded-full flex items-center justify-center mr-4">
                        <span class="text-white font-bold">2</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">How We Use Your Information</h2>
                </div>
                <div class="prose prose-blue max-w-none">
                    <div class="space-y-6">
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-3">Primary Uses</h4>
                            <div class="grid md:grid-cols-3 gap-4">
                                <div class="text-center p-4 bg-purple-50 rounded-lg">
                                    <i class="fas fa-handshake text-2xl text-purple-600 mb-2"></i>
                                    <h5 class="font-medium text-purple-800">Matching</h5>
                                    <p class="text-sm text-purple-700">Connect workers with relevant job opportunities</p>
                                </div>
                                <div class="text-center p-4 bg-indigo-50 rounded-lg">
                                    <i class="fas fa-comments text-2xl text-indigo-600 mb-2"></i>
                                    <h5 class="font-medium text-indigo-800">Communication</h5>
                                    <p class="text-sm text-indigo-700">Enable messaging between users</p>
                                </div>
                                <div class="text-center p-4 bg-pink-50 rounded-lg">
                                    <i class="fas fa-cog text-2xl text-pink-600 mb-2"></i>
                                    <h5 class="font-medium text-pink-800">Improvement</h5>
                                    <p class="text-sm text-pink-700">Enhance platform features and user experience</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 mb-3">Additional Uses</h4>
                            <ul class="text-gray-700 space-y-2">
                                <li>• Verify identity and prevent fraud</li>
                                <li>• Process payments and transactions</li>
                                <li>• Send important notifications and updates</li>
                                <li>• Provide customer support</li>
                                <li>• Comply with legal obligations</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 3: Data Sharing -->
            <section id="sharing" class="bg-white rounded-xl shadow-lg p-8">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-blue-primary rounded-full flex items-center justify-center mr-4">
                        <span class="text-white font-bold">3</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Information Sharing & Disclosure</h2>
                </div>
                <div class="prose prose-blue max-w-none">
                    <div class="bg-red-50 border border-red-200 p-6 rounded-lg mb-6">
                        <h4 class="font-bold text-red-800 mb-3">
                            <i class="fas fa-exclamation-triangle mr-2"></i>We Never Sell Your Data
                        </h4>
                        <p class="text-red-700">
                            JOB-lyNK does not sell, rent, or trade your personal information to third parties for marketing purposes.
                        </p>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">When We Share Information</h4>
                            <div class="space-y-3">
                                <div class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <div>
                                        <strong>With Your Consent:</strong> When you explicitly agree to share information
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <div>
                                        <strong>Service Providers:</strong> Trusted partners who help us operate the platform
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <div>
                                        <strong>Legal Requirements:</strong> When required by law or to protect rights and safety
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                    <div>
                                        <strong>Business Transfers:</strong> In case of merger, acquisition, or asset sale
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg mt-6">
                        <p class="text-blue-800">
                            <i class="fas fa-shield-alt mr-2"></i>
                            All third-party service providers are bound by strict confidentiality agreements and data protection standards.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Section 4: Security -->
            <section id="security" class="bg-white rounded-xl shadow-lg p-8">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-blue-primary rounded-full flex items-center justify-center mr-4">
                        <span class="text-white font-bold">4</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Data Security & Protection</h2>
                </div>
                <div class="prose prose-blue max-w-none">
                    <div class="grid md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-green-50 p-6 rounded-lg">
                            <h4 class="font-semibold text-green-800 mb-3">
                                <i class="fas fa-lock mr-2"></i>Technical Safeguards
                            </h4>
                            <ul class="text-green-700 text-sm space-y-2">
                                <li>• SSL/TLS encryption for data transmission</li>
                                <li>• Encrypted data storage</li>
                                <li>• Regular security audits and updates</li>
                                <li>• Multi-factor authentication options</li>
                                <li>• Secure payment processing</li>
                            </ul>
                        </div>
                        <div class="bg-blue-50 p-6 rounded-lg">
                            <h4 class="font-semibold text-blue-800 mb-3">
                                <i class="fas fa-users-cog mr-2"></i>Administrative Controls
                            </h4>
                            <ul class="text-blue-700 text-sm space-y-2">
                                <li>• Limited access to personal data</li>
                                <li>• Employee background checks</li>
                                <li>• Regular security training</li>
                                <li>• Incident response procedures</li>
                                <li>• Data breach notification protocols</li>
                            </ul>
                        </div>
                    </div>

                    <div class="bg-orange-50 border border-orange-200 p-6 rounded-lg">
                        <h4 class="font-bold text-orange-800 mb-3">
                            <i class="fas fa-exclamation-circle mr-2"></i>Security Breach Response & Liability
                        </h4>
                        <p class="text-orange-700 mb-3">
                            In the unlikely event of a data breach caused by our security failures, we will:
                        </p>
                        <ul class="text-orange-700 space-y-1">
                            <li>• Notify affected users within 72 hours</li>
                            <li>• Report to relevant authorities as required</li>
                            <li>• Take immediate steps to secure the breach</li>
                            <li>• Provide support and guidance to affected users</li>
                            <li>• <strong>Cover legal costs up to UGX 150,000 for users affected by our security failures</strong></li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Section 5: Cookies -->
            <section id="cookies" class="bg-white rounded-xl shadow-lg p-8">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-blue-primary rounded-full flex items-center justify-center mr-4">
                        <span class="text-white font-bold">5</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Cookies & Tracking Technologies</h2>
                </div>
                <div class="prose prose-blue max-w-none">
                    <div class="space-y-6">
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-3">Types of Cookies We Use</h4>
                            <div class="grid md:grid-cols-3 gap-4">
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <h5 class="font-medium text-gray-800 mb-2">Essential Cookies</h5>
                                    <p class="text-sm text-gray-600">Required for basic platform functionality and security</p>
                                </div>
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <h5 class="font-medium text-gray-800 mb-2">Performance Cookies</h5>
                                    <p class="text-sm text-gray-600">Help us understand how users interact with our platform</p>
                                </div>
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <h5 class="font-medium text-gray-800 mb-2">Preference Cookies</h5>
                                    <p class="text-sm text-gray-600">Remember your settings and personalize your experience</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 mb-3">Managing Cookies</h4>
                            <p class="text-gray-700 mb-3">
                                You can control cookies through your browser settings. However, disabling certain cookies may affect platform functionality.
                            </p>
                            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg">
                                <p class="text-blue-800">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    We respect "Do Not Track" signals and will not track users who have enabled this setting.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 6: Your Rights -->
            <section id="rights" class="bg-white rounded-xl shadow-lg p-8">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-blue-primary rounded-full flex items-center justify-center mr-4">
                        <span class="text-white font-bold">6</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Your Privacy Rights</h2>
                </div>
                <div class="prose prose-blue max-w-none">
                    <div class="grid md:grid-cols-2 gap-6 mb-6">
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <i class="fas fa-eye text-blue-primary mt-1 mr-3"></i>
                                <div>
                                    <strong>Access:</strong> Request a copy of your personal data
                                </div>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-edit text-blue-primary mt-1 mr-3"></i>
                                <div>
                                    <strong>Correction:</strong> Update or correct inaccurate information
                                </div>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-trash text-blue-primary mt-1 mr-3"></i>
                                <div>
                                    <strong>Deletion:</strong> Request removal of your personal data
                                </div>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-download text-blue-primary mt-1 mr-3"></i>
                                <div>
                                    <strong>Portability:</strong> Export your data in a readable format
                                </div>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <i class="fas fa-pause text-blue-primary mt-1 mr-3"></i>
                                <div>
                                    <strong>Restriction:</strong> Limit how we process your data
                                </div>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-ban text-blue-primary mt-1 mr-3"></i>
                                <div>
                                    <strong>Objection:</strong> Object to certain data processing
                                </div>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-undo text-blue-primary mt-1 mr-3"></i>
                                <div>
                                    <strong>Withdraw Consent:</strong> Revoke previously given consent
                                </div>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-gavel text-blue-primary mt-1 mr-3"></i>
                                <div>
                                    <strong>Complaint:</strong> File complaints with data protection authorities
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-green-50 border border-green-200 p-6 rounded-lg">
                        <h4 class="font-bold text-green-800 mb-3">
                            <i class="fas fa-clock mr-2"></i>Response Time
                        </h4>
                        <p class="text-green-700">
                            We will respond to your privacy requests within 30 days. For complex requests, we may extend this period by an additional 60 days with proper notification.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Section 7: Data Retention -->
            <section id="retention" class="bg-white rounded-xl shadow-lg p-8">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-blue-primary rounded-full flex items-center justify-center mr-4">
                        <span class="text-white font-bold">7</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Data Retention & Deletion</h2>
                </div>
                <div class="prose prose-blue max-w-none">
                    <div class="space-y-6">
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-3">Retention Periods</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                                    <span class="font-medium">Active Account Data</span>
                                    <span class="text-blue-primary">While account is active</span>
                                </div>
                                <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                                    <span class="font-medium">Inactive Account Data</span>
                                    <span class="text-blue-primary">3 years after last activity</span>
                                </div>
                                <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                                    <span class="font-medium">Transaction Records</span>
                                    <span class="text-blue-primary">7 years (legal requirement)</span>
                                </div>
                                <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                                    <span class="font-medium">Communication Logs</span>
                                    <span class="text-blue-primary">2 years</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-purple-50 border-l-4 border-purple-400 p-4 rounded-r-lg">
                            <p class="text-purple-800">
                                <i class="fas fa-info-circle mr-2"></i>
                                You can request immediate deletion of your account and data at any time, subject to legal retention requirements.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 8: Contact -->
            <section id="contact" class="bg-white rounded-xl shadow-lg p-8">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-blue-primary rounded-full flex items-center justify-center mr-4">
                        <span class="text-white font-bold">8</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Contact Us About Privacy</h2>
                </div>
                <div class="prose prose-blue max-w-none">
                    <p class="text-gray-700 mb-6">
                        If you have questions about this Privacy Policy or how we handle your personal information, please contact us:
                    </p>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="bg-blue-50 p-6 rounded-lg">
                            <h4 class="font-semibold text-blue-800 mb-4">
                                <i class="fas fa-envelope mr-2"></i>Email Us
                            </h4>
                            <p class="text-blue-700 mb-2">Privacy Officer</p>
                            <a href="mailto:leemeeya851@gmail.com" class="text-blue-600 hover:text-blue-800 font-medium">
                                leemeeya851@gmail.com
                            </a>
                            <p class="text-sm text-blue-600 mt-2">Response within 24-48 hours</p>
                        </div>
                        <div class="bg-green-50 p-6 rounded-lg">
                            <h4 class="font-semibold text-green-800 mb-4">
                                <i class="fas fa-phone mr-2"></i>Call Us
                            </h4>
                            <p class="text-green-700 mb-2">Privacy Hotline</p>
                            <a href="tel:+256748550372" class="text-green-600 hover:text-green-800 font-medium">
                                +256 748 550 372
                            </a>
                            <p class="text-sm text-green-600 mt-2">Monday - Friday, 9 AM - 6 PM EAT</p>
                        </div>
                    </div>

                    <div class="bg-gray-100 border border-gray-300 p-6 rounded-lg mt-6">
                        <h4 class="font-bold text-gray-800 mb-3">
                            <i class="fas fa-balance-scale mr-2"></i>Legal Liability for Privacy Violations
                        </h4>
                        <p class="text-gray-700">
                            In cases where JOB-lyNK fails to protect your personal information as outlined in this policy, and such failure results in damages to you, our liability for legal costs and damages is limited to a maximum of <strong>UGX 150,000</strong> per incident, subject to applicable law.
                        </p>
                    </div>
                </div>
            </section>
        </div>

        <!-- Contact Section -->
        <div class="bg-gradient-to-r from-blue-primary to-blue-secondary rounded-xl p-8 mt-12 text-white text-center">
            <h3 class="text-2xl font-bold mb-4">Questions About Your Privacy?</h3>
            <p class="mb-6 text-blue-light">We're here to help you understand and control your personal information.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="mailto:leemeeya851@gmail.com" class="bg-white text-blue-primary px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    <i class="fas fa-envelope mr-2"></i>Email Privacy Team
                </a>
                <a href="tel:+256748550372" class="border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-primary transition-colors">
                    <i class="fas fa-phone mr-2"></i>Call Privacy Hotline
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