<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricing - JOB-lyNK</title>
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
<body class="glass-background">   @include('includes.navbar')

    <!-- Pricing Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Simple, Transparent Pricing</h1>
                <p class="text-gray-600 max-w-2xl mx-auto text-lg">Choose the plan that works best for you. No hidden fees.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Workers Plan -->
                <div class="bg-gray-50 rounded-2xl p-8 border-2 border-gray-200 hover:border-blue-primary transition duration-300 transform hover:scale-105">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-blue-light rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-user text-blue-primary text-2xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">For Workers</h2>
                        <div class="text-5xl font-bold text-blue-primary mb-2">Free</div>
                        <p class="text-gray-600">Always free to join and apply</p>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                            <span class="text-gray-700">Unlimited job applications</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                            <span class="text-gray-700">Profile with skills showcase</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                            <span class="text-gray-700">Direct messaging with employers</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                            <span class="text-gray-700">Secure payment processing</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                            <span class="text-gray-700">5% platform fee on earnings</span>
                        </li>
                    </ul>
                    <a href="/register?type=worker" class="block w-full bg-blue-primary text-white text-center py-3 rounded-lg font-semibold hover:bg-blue-dark transition duration-300">
                        Get Started
                    </a>
                </div>

                <!-- Employers Basic Plan -->
                <div class="bg-gray-50 rounded-2xl p-8 border-2 border-gray-200 hover:border-blue-primary transition duration-300 transform hover:scale-105">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-blue-light rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-briefcase text-blue-primary text-2xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Basic</h2>
                        <div class="text-5xl font-bold text-blue-primary mb-2">50K</div>
                        <p class="text-gray-600">UGX per job posting</p>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                            <span class="text-gray-700">Post up to 5 jobs/month</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                            <span class="text-gray-700">30-day job listing</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                            <span class="text-gray-700">Unlimited applications</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                            <span class="text-gray-700">Basic applicant filtering</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                            <span class="text-gray-700">Email support</span>
                        </li>
                    </ul>
                    <a href="/register?type=employer" class="block w-full bg-blue-primary text-white text-center py-3 rounded-lg font-semibold hover:bg-blue-dark transition duration-300">
                        Get Started
                    </a>
                </div>

                <!-- Employers Premium Plan -->
                <div class="bg-gradient-to-br from-blue-primary to-blue-secondary rounded-2xl p-8 border-2 border-blue-primary transform hover:scale-105 transition duration-300 relative">
                    <div class="absolute top-0 right-0 bg-yellow-400 text-gray-900 px-4 py-1 rounded-bl-lg rounded-tr-lg text-sm font-bold">
                        Popular
                    </div>
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-crown text-yellow-400 text-2xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-white mb-2">Premium</h2>
                        <div class="text-5xl font-bold text-white mb-2">150K</div>
                        <p class="text-blue-light">UGX per month</p>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start">
                            <i class="fas fa-check text-yellow-400 mt-1 mr-3"></i>
                            <span class="text-white">Unlimited job postings</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-yellow-400 mt-1 mr-3"></i>
                            <span class="text-white">Featured job listings</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-yellow-400 mt-1 mr-3"></i>
                            <span class="text-white">Advanced applicant filtering</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-yellow-400 mt-1 mr-3"></i>
                            <span class="text-white">Priority support</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-yellow-400 mt-1 mr-3"></i>
                            <span class="text-white">Analytics dashboard</span>
                        </li>
                    </ul>
                    <a href="/register?type=employer" class="block w-full bg-white text-blue-primary text-center py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                        Get Started
                    </a>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="mt-20 max-w-4xl mx-auto">
                <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Frequently Asked Questions</h2>
                <div class="space-y-6">
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Can I switch plans later?</h3>
                        <p class="text-gray-600">Yes, you can upgrade or downgrade your plan at any time. Changes take effect immediately.</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">What payment methods do you accept?</h3>
                        <p class="text-gray-600">We accept mobile money (MTN, Airtel), bank transfers, and credit/debit cards.</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Is there a refund policy?</h3>
                        <p class="text-gray-600">Yes, we offer a 7-day money-back guarantee if you're not satisfied with our service.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

   
    @include('includes.footer')
</body>
</html>
