<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>How It Works - JOB-lyNK</title>
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
    </style>
</head>
<body class="glass-background">
       @include('includes.navbar')

    <!-- How It Works Section -->
    <section class="py-20 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">How It Works</h1>
                <p class="text-gray-600 max-w-2xl mx-auto text-lg">Getting started is simple. Follow these easy steps to find work or hire talent.</p>
            </div>
            
            <!-- Workers and Employers Side by Side -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
                <!-- For Workers -->
                <div>
                    <h2 class="text-3xl font-bold text-blue-primary text-center mb-8">For Workers</h2>
                    
                    <!-- Workers Carousel -->
                    <div class="relative">
                        <div class="overflow-hidden rounded-2xl">
                            <div id="workersCarousel" class="flex transition-transform duration-500 ease-in-out">
                                <!-- Step 1 -->
                                <div class="w-full flex-shrink-0 px-4">
                                    <div class="text-center bg-white p-8 rounded-xl shadow-lg">
                                        <div class="w-20 h-20 bg-blue-primary text-white rounded-full flex items-center justify-center mx-auto mb-4 text-3xl font-bold shadow-lg">1</div>
                                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Create Profile</h3>
                                        <p class="text-gray-600">Sign up and complete your profile with skills and experience</p>
                                    </div>
                                </div>
                                <!-- Step 2 -->
                                <div class="w-full flex-shrink-0 px-4">
                                    <div class="text-center bg-white p-8 rounded-xl shadow-lg">
                                        <div class="w-20 h-20 bg-blue-primary text-white rounded-full flex items-center justify-center mx-auto mb-4 text-3xl font-bold shadow-lg">2</div>
                                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Browse Jobs</h3>
                                        <p class="text-gray-600">Search and filter jobs that match your skills and availability</p>
                                    </div>
                                </div>
                                <!-- Step 3 -->
                                <div class="w-full flex-shrink-0 px-4">
                                    <div class="text-center bg-white p-8 rounded-xl shadow-lg">
                                        <div class="w-20 h-20 bg-blue-primary text-white rounded-full flex items-center justify-center mx-auto mb-4 text-3xl font-bold shadow-lg">3</div>
                                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Apply & Connect</h3>
                                        <p class="text-gray-600">Submit applications and communicate with employers</p>
                                    </div>
                                </div>
                                <!-- Step 4 -->
                                <div class="w-full flex-shrink-0 px-4">
                                    <div class="text-center bg-white p-8 rounded-xl shadow-lg">
                                        <div class="w-20 h-20 bg-blue-primary text-white rounded-full flex items-center justify-center mx-auto mb-4 text-3xl font-bold shadow-lg">4</div>
                                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Get Paid</h3>
                                        <p class="text-gray-600">Complete work and receive secure payment through the platform</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Navigation Arrows -->
                        <button onclick="previousWorkerStep()" class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 bg-white rounded-full p-3 shadow-lg hover:bg-gray-100 transition-all hover:scale-110">
                            <i class="fas fa-chevron-left text-blue-primary text-lg"></i>
                        </button>
                        <button onclick="nextWorkerStep()" class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 bg-white rounded-full p-3 shadow-lg hover:bg-gray-100 transition-all hover:scale-110">
                            <i class="fas fa-chevron-right text-blue-primary text-lg"></i>
                        </button>
                        
                        <!-- Indicator Dots -->
                        <div class="flex justify-center space-x-3 mt-6">
                            <button onclick="goToWorkerStep(0)" class="worker-dot w-3 h-3 rounded-full bg-blue-primary transition-all duration-300"></button>
                            <button onclick="goToWorkerStep(1)" class="worker-dot w-3 h-3 rounded-full bg-gray-300 transition-all duration-300"></button>
                            <button onclick="goToWorkerStep(2)" class="worker-dot w-3 h-3 rounded-full bg-gray-300 transition-all duration-300"></button>
                            <button onclick="goToWorkerStep(3)" class="worker-dot w-3 h-3 rounded-full bg-gray-300 transition-all duration-300"></button>
                        </div>
                    </div>
                </div>

                <!-- For Employers -->
                <div>
                    <h2 class="text-3xl font-bold text-blue-primary text-center mb-8">For Employers</h2>
                    
                    <!-- Employers Carousel -->
                    <div class="relative">
                        <div class="overflow-hidden rounded-2xl">
                            <div id="employersCarousel" class="flex transition-transform duration-500 ease-in-out">
                                <!-- Step 1 -->
                                <div class="w-full flex-shrink-0 px-4">
                                    <div class="text-center bg-white p-8 rounded-xl shadow-lg">
                                        <div class="w-20 h-20 bg-blue-secondary text-white rounded-full flex items-center justify-center mx-auto mb-4 text-3xl font-bold shadow-lg">1</div>
                                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Post a Job</h3>
                                        <p class="text-gray-600">Create a detailed job listing with requirements and budget</p>
                                    </div>
                                </div>
                                <!-- Step 2 -->
                                <div class="w-full flex-shrink-0 px-4">
                                    <div class="text-center bg-white p-8 rounded-xl shadow-lg">
                                        <div class="w-20 h-20 bg-blue-secondary text-white rounded-full flex items-center justify-center mx-auto mb-4 text-3xl font-bold shadow-lg">2</div>
                                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Review Applications</h3>
                                        <p class="text-gray-600">Browse qualified candidates and their profiles</p>
                                    </div>
                                </div>
                                <!-- Step 3 -->
                                <div class="w-full flex-shrink-0 px-4">
                                    <div class="text-center bg-white p-8 rounded-xl shadow-lg">
                                        <div class="w-20 h-20 bg-blue-secondary text-white rounded-full flex items-center justify-center mx-auto mb-4 text-3xl font-bold shadow-lg">3</div>
                                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Hire & Manage</h3>
                                        <p class="text-gray-600">Select the best candidate and coordinate work details</p>
                                    </div>
                                </div>
                                <!-- Step 4 -->
                                <div class="w-full flex-shrink-0 px-4">
                                    <div class="text-center bg-white p-8 rounded-xl shadow-lg">
                                        <div class="w-20 h-20 bg-blue-secondary text-white rounded-full flex items-center justify-center mx-auto mb-4 text-3xl font-bold shadow-lg">4</div>
                                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Pay Securely</h3>
                                        <p class="text-gray-600">Release payment once work is completed to your satisfaction</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Navigation Arrows -->
                        <button onclick="previousEmployerStep()" class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 bg-white rounded-full p-3 shadow-lg hover:bg-gray-100 transition-all hover:scale-110">
                            <i class="fas fa-chevron-left text-blue-secondary text-lg"></i>
                        </button>
                        <button onclick="nextEmployerStep()" class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 bg-white rounded-full p-3 shadow-lg hover:bg-gray-100 transition-all hover:scale-110">
                            <i class="fas fa-chevron-right text-blue-secondary text-lg"></i>
                        </button>
                        
                        <!-- Indicator Dots -->
                        <div class="flex justify-center space-x-3 mt-6">
                            <button onclick="goToEmployerStep(0)" class="employer-dot w-3 h-3 rounded-full bg-blue-secondary transition-all duration-300"></button>
                            <button onclick="goToEmployerStep(1)" class="employer-dot w-3 h-3 rounded-full bg-gray-300 transition-all duration-300"></button>
                            <button onclick="goToEmployerStep(2)" class="employer-dot w-3 h-3 rounded-full bg-gray-300 transition-all duration-300"></button>
                            <button onclick="goToEmployerStep(3)" class="employer-dot w-3 h-3 rounded-full bg-gray-300 transition-all duration-300"></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Video Tutorials Section -->
            <div class="mt-20">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">
                        <i class="fas fa-play-circle text-blue-primary mr-3"></i>
                        Video Tutorials
                    </h2>
                    <p class="text-gray-600 max-w-2xl mx-auto text-lg">
                        Watch these quick tutorials to learn how to make the most of JOB-lyNK
                    </p>
                </div>

                <!-- Video Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Tutorial 1: Getting Started for Workers -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="relative aspect-video bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center group cursor-pointer">
                            <!-- Replace with actual video embed -->
                            <div class="absolute inset-0 bg-black bg-opacity-30 group-hover:bg-opacity-20 transition-all"></div>
                            <button onclick="openVideoModal('worker-getting-started')" class="relative z-10 w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                <i class="fas fa-play text-blue-primary text-2xl ml-1"></i>
                            </button>
                            <div class="absolute bottom-4 right-4 bg-black bg-opacity-70 text-white px-3 py-1 rounded-full text-sm">
                                <i class="fas fa-clock mr-1"></i>3:45
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Getting Started as a Worker</h3>
                            <p class="text-gray-600 text-sm mb-4">Learn how to create your profile, browse jobs, and submit your first application</p>
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-user text-blue-primary mr-2"></i>
                                <span>For Workers</span>
                            </div>
                        </div>
                    </div>

                    <!-- Tutorial 2: Posting Your First Job -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="relative aspect-video bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center group cursor-pointer">
                            <div class="absolute inset-0 bg-black bg-opacity-30 group-hover:bg-opacity-20 transition-all"></div>
                            <button onclick="openVideoModal('employer-post-job')" class="relative z-10 w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                <i class="fas fa-play text-green-600 text-2xl ml-1"></i>
                            </button>
                            <div class="absolute bottom-4 right-4 bg-black bg-opacity-70 text-white px-3 py-1 rounded-full text-sm">
                                <i class="fas fa-clock mr-1"></i>4:20
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Posting Your First Job</h3>
                            <p class="text-gray-600 text-sm mb-4">Step-by-step guide to creating an effective job listing and attracting top talent</p>
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-briefcase text-green-600 mr-2"></i>
                                <span>For Employers</span>
                            </div>
                        </div>
                    </div>

                    <!-- Tutorial 3: Managing Applications -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="relative aspect-video bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center group cursor-pointer">
                            <div class="absolute inset-0 bg-black bg-opacity-30 group-hover:bg-opacity-20 transition-all"></div>
                            <button onclick="openVideoModal('manage-applications')" class="relative z-10 w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                <i class="fas fa-play text-purple-600 text-2xl ml-1"></i>
                            </button>
                            <div class="absolute bottom-4 right-4 bg-black bg-opacity-70 text-white px-3 py-1 rounded-full text-sm">
                                <i class="fas fa-clock mr-1"></i>5:10
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Managing Applications</h3>
                            <p class="text-gray-600 text-sm mb-4">How to review, shortlist, and communicate with applicants effectively</p>
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-briefcase text-purple-600 mr-2"></i>
                                <span>For Employers</span>
                            </div>
                        </div>
                    </div>

                    <!-- Tutorial 4: Using the Messaging System -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="relative aspect-video bg-gradient-to-br from-yellow-500 to-orange-500 flex items-center justify-center group cursor-pointer">
                            <div class="absolute inset-0 bg-black bg-opacity-30 group-hover:bg-opacity-20 transition-all"></div>
                            <button onclick="openVideoModal('messaging-system')" class="relative z-10 w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                <i class="fas fa-play text-orange-600 text-2xl ml-1"></i>
                            </button>
                            <div class="absolute bottom-4 right-4 bg-black bg-opacity-70 text-white px-3 py-1 rounded-full text-sm">
                                <i class="fas fa-clock mr-1"></i>3:30
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Using the Messaging System</h3>
                            <p class="text-gray-600 text-sm mb-4">Learn how to communicate professionally with employers or workers</p>
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-users text-orange-600 mr-2"></i>
                                <span>For Everyone</span>
                            </div>
                        </div>
                    </div>

                    <!-- Tutorial 5: Payment & Security -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="relative aspect-video bg-gradient-to-br from-red-500 to-pink-500 flex items-center justify-center group cursor-pointer">
                            <div class="absolute inset-0 bg-black bg-opacity-30 group-hover:bg-opacity-20 transition-all"></div>
                            <button onclick="openVideoModal('payment-security')" class="relative z-10 w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                <i class="fas fa-play text-pink-600 text-2xl ml-1"></i>
                            </button>
                            <div class="absolute bottom-4 right-4 bg-black bg-opacity-70 text-white px-3 py-1 rounded-full text-sm">
                                <i class="fas fa-clock mr-1"></i>4:50
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Payment & Security</h3>
                            <p class="text-gray-600 text-sm mb-4">Understanding secure payments, escrow, and protecting your account</p>
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-shield-alt text-pink-600 mr-2"></i>
                                <span>For Everyone</span>
                            </div>
                        </div>
                    </div>

                    <!-- Tutorial 6: Profile Optimization -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="relative aspect-video bg-gradient-to-br from-indigo-500 to-blue-500 flex items-center justify-center group cursor-pointer">
                            <div class="absolute inset-0 bg-black bg-opacity-30 group-hover:bg-opacity-20 transition-all"></div>
                            <button onclick="openVideoModal('profile-optimization')" class="relative z-10 w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                <i class="fas fa-play text-indigo-600 text-2xl ml-1"></i>
                            </button>
                            <div class="absolute bottom-4 right-4 bg-black bg-opacity-70 text-white px-3 py-1 rounded-full text-sm">
                                <i class="fas fa-clock mr-1"></i>6:15
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Profile Optimization Tips</h3>
                            <p class="text-gray-600 text-sm mb-4">Make your profile stand out and increase your chances of getting hired</p>
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-user text-indigo-600 mr-2"></i>
                                <span>For Workers</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="mt-16 text-center bg-blue-primary rounded-2xl p-12">
                <h2 class="text-3xl font-bold text-white mb-4">Ready to Get Started?</h2>
                <p class="text-blue-light mb-8 max-w-2xl mx-auto">Join thousands of workers and employers who trust JOB-lyNK for their flexible work needs.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="/register?type=worker" class="bg-white text-blue-primary px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                        Join as Worker
                    </a>
                    <a href="/register?type=employer" class="bg-blue-dark text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-900 transition duration-300">
                        Join as Employer
                    </a>
                </div>
            </div>
        </div>
    </section>

    
    
    <script>
        // Workers Carousel
        let currentWorkerSlide = 0;
        const totalWorkerSlides = 4;
        let workerAutoplayInterval;
        
        function updateWorkersCarousel() {
            const carousel = document.getElementById('workersCarousel');
            const dots = document.querySelectorAll('.worker-dot');
            
            carousel.style.transform = `translateX(-${currentWorkerSlide * 100}%)`;
            
            dots.forEach((dot, index) => {
                if (index === currentWorkerSlide) {
                    dot.classList.remove('bg-gray-300');
                    dot.classList.add('bg-blue-primary');
                } else {
                    dot.classList.remove('bg-blue-primary');
                    dot.classList.add('bg-gray-300');
                }
            });
        }
        
        function nextWorkerStep() {
            currentWorkerSlide = (currentWorkerSlide + 1) % totalWorkerSlides;
            updateWorkersCarousel();
            resetWorkerAutoplay();
        }
        
        function previousWorkerStep() {
            currentWorkerSlide = (currentWorkerSlide - 1 + totalWorkerSlides) % totalWorkerSlides;
            updateWorkersCarousel();
            resetWorkerAutoplay();
        }
        
        function goToWorkerStep(index) {
            currentWorkerSlide = index;
            updateWorkersCarousel();
            resetWorkerAutoplay();
        }
        
        function startWorkerAutoplay() {
            workerAutoplayInterval = setInterval(() => {
                nextWorkerStep();
            }, 5000);
        }
        
        function resetWorkerAutoplay() {
            clearInterval(workerAutoplayInterval);
            startWorkerAutoplay();
        }
        
        // Employers Carousel
        let currentEmployerSlide = 0;
        const totalEmployerSlides = 4;
        let employerAutoplayInterval;
        
        function updateEmployersCarousel() {
            const carousel = document.getElementById('employersCarousel');
            const dots = document.querySelectorAll('.employer-dot');
            
            carousel.style.transform = `translateX(-${currentEmployerSlide * 100}%)`;
            
            dots.forEach((dot, index) => {
                if (index === currentEmployerSlide) {
                    dot.classList.remove('bg-gray-300');
                    dot.classList.add('bg-blue-secondary');
                } else {
                    dot.classList.remove('bg-blue-secondary');
                    dot.classList.add('bg-gray-300');
                }
            });
        }
        
        function nextEmployerStep() {
            currentEmployerSlide = (currentEmployerSlide + 1) % totalEmployerSlides;
            updateEmployersCarousel();
            resetEmployerAutoplay();
        }
        
        function previousEmployerStep() {
            currentEmployerSlide = (currentEmployerSlide - 1 + totalEmployerSlides) % totalEmployerSlides;
            updateEmployersCarousel();
            resetEmployerAutoplay();
        }
        
        function goToEmployerStep(index) {
            currentEmployerSlide = index;
            updateEmployersCarousel();
            resetEmployerAutoplay();
        }
        
        function startEmployerAutoplay() {
            employerAutoplayInterval = setInterval(() => {
                nextEmployerStep();
            }, 5000);
        }
        
        function resetEmployerAutoplay() {
            clearInterval(employerAutoplayInterval);
            startEmployerAutoplay();
        }
        
        // Start both carousels on page load
        document.addEventListener('DOMContentLoaded', function() {
            startWorkerAutoplay();
            startEmployerAutoplay();
            
            // Pause on hover
            const workersContainer = document.getElementById('workersCarousel').parentElement.parentElement;
            workersContainer.addEventListener('mouseenter', () => clearInterval(workerAutoplayInterval));
            workersContainer.addEventListener('mouseleave', () => startWorkerAutoplay());
            
            const employersContainer = document.getElementById('employersCarousel').parentElement.parentElement;
            employersContainer.addEventListener('mouseenter', () => clearInterval(employerAutoplayInterval));
            employersContainer.addEventListener('mouseleave', () => startEmployerAutoplay());
        });
    </script>

    <!-- Video Modal -->
    <div id="videoModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
        <div class="relative w-full max-w-5xl bg-white rounded-2xl overflow-hidden shadow-2xl">
            <!-- Close Button -->
            <button onclick="closeTutorialModal()" class="absolute top-4 right-4 z-10 w-10 h-10 bg-white rounded-full flex items-center justify-center hover:bg-gray-100 transition-all shadow-lg">
                <i class="fas fa-times text-gray-700 text-xl"></i>
            </button>
            
            <!-- Tutorial Container -->
            <div class="bg-gradient-to-br from-gray-50 to-gray-100" id="tutorialContainer">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-8 text-white">
                    <h2 id="tutorialTitle" class="text-3xl font-bold mb-2"></h2>
                    <p id="tutorialDescription" class="text-blue-100"></p>
                </div>
                
                <!-- Steps Container -->
                <div class="p-8">
                    <!-- Progress Bar -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-600">Progress</span>
                            <span class="text-sm font-medium text-blue-600"><span id="currentStep">1</span> of <span id="totalSteps">4</span></span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div id="progressBar" class="bg-gradient-to-r from-blue-600 to-indigo-600 h-2 rounded-full transition-all duration-500" style="width: 25%"></div>
                        </div>
                    </div>
                    
                    <!-- Step Content -->
                    <div id="stepContent" class="bg-white rounded-xl shadow-lg p-8 min-h-[400px]">
                        <!-- Dynamic content will be loaded here -->
                    </div>
                    
                    <!-- Navigation -->
                    <div class="flex justify-between items-center mt-8">
                        <button id="prevBtn" onclick="previousStep()" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-semibold transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-arrow-left mr-2"></i>Previous
                        </button>
                        <div id="stepDots" class="flex space-x-2">
                            <!-- Dots will be generated dynamically -->
                        </div>
                        <button id="nextBtn" onclick="nextStep()" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl font-semibold transition-all shadow-lg">
                            Next<i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Audio Context for sound effects
        const AudioContext = window.AudioContext || window.webkitAudioContext;
        const audioCtx = new AudioContext();

        // Sound effect functions
        function playSound(frequency, duration, type = 'sine') {
            const oscillator = audioCtx.createOscillator();
            const gainNode = audioCtx.createGain();
            
            oscillator.connect(gainNode);
            gainNode.connect(audioCtx.destination);
            
            oscillator.frequency.value = frequency;
            oscillator.type = type;
            
            gainNode.gain.setValueAtTime(0.3, audioCtx.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + duration);
            
            oscillator.start(audioCtx.currentTime);
            oscillator.stop(audioCtx.currentTime + duration);
        }

        function playClickSound() {
            playSound(800, 0.1, 'sine');
        }

        function playNextSound() {
            playSound(600, 0.15, 'sine');
            setTimeout(() => playSound(800, 0.15, 'sine'), 50);
        }

        function playPrevSound() {
            playSound(800, 0.15, 'sine');
            setTimeout(() => playSound(600, 0.15, 'sine'), 50);
        }

        function playCompleteSound() {
            playSound(523, 0.2, 'sine'); // C
            setTimeout(() => playSound(659, 0.2, 'sine'), 100); // E
            setTimeout(() => playSound(784, 0.3, 'sine'), 200); // G
        }

        function playOpenSound() {
            playSound(400, 0.1, 'sine');
            setTimeout(() => playSound(600, 0.1, 'sine'), 80);
            setTimeout(() => playSound(800, 0.15, 'sine'), 160);
        }

        function playCloseSound() {
            playSound(800, 0.1, 'sine');
            setTimeout(() => playSound(600, 0.1, 'sine'), 80);
            setTimeout(() => playSound(400, 0.15, 'sine'), 160);
        }

        // Tutorial data with step-by-step guides
        const tutorialData = {
            'worker-getting-started': {
                title: 'Getting Started as a Worker',
                description: 'Learn how to create your profile, browse jobs, and submit your first application',
                steps: [
                    {
                        title: 'Create Your Account',
                        content: 'Start by clicking the "Register" button in the top right corner. Choose "Join as Worker" and fill in your details including name, email, phone number, and location.',
                        icon: 'fa-user-plus',
                        color: 'blue',
                        tips: ['Use a professional email address', 'Add a clear profile picture', 'Complete all required fields']
                    },
                    {
                        title: 'Complete Your Profile',
                        content: 'Navigate to your dashboard and click on "Profile Settings". Add your skills, experience, bio, and upload any relevant certificates or documents.',
                        icon: 'fa-id-card',
                        color: 'green',
                        tips: ['List all relevant skills', 'Write a compelling bio', 'Upload certificates to stand out']
                    },
                    {
                        title: 'Browse Available Jobs',
                        content: 'Go to the "Jobs" section to see all available opportunities. Use filters to find jobs that match your skills, location, and availability.',
                        icon: 'fa-search',
                        color: 'purple',
                        tips: ['Use search filters effectively', 'Save jobs you\'re interested in', 'Check job requirements carefully']
                    },
                    {
                        title: 'Submit Your Application',
                        content: 'Click on a job to view details. Write a personalized cover letter explaining why you\'re the best fit, then click "Apply Now" to submit your application.',
                        icon: 'fa-paper-plane',
                        color: 'indigo',
                        tips: ['Customize each application', 'Highlight relevant experience', 'Be professional and concise']
                    }
                ]
            },
            'employer-post-job': {
                title: 'Posting Your First Job',
                description: 'Step-by-step guide to creating an effective job listing',
                steps: [
                    {
                        title: 'Access Post Job Page',
                        content: 'From your employer dashboard, click the "Post a Job" button. This will take you to the job creation form where you can enter all job details.',
                        icon: 'fa-plus-circle',
                        color: 'green',
                        tips: ['Have job details ready beforehand', 'Know your budget range', 'Understand the skills you need']
                    },
                    {
                        title: 'Enter Job Details',
                        content: 'Fill in the job title, detailed description, required skills, location, job type (full-time, part-time, contract), and your budget. Be as specific as possible.',
                        icon: 'fa-edit',
                        color: 'blue',
                        tips: ['Write clear job titles', 'Provide detailed descriptions', 'List specific skill requirements']
                    },
                    {
                        title: 'Set Requirements & Budget',
                        content: 'Specify experience level needed, education requirements, and set a competitive budget. You can also mark the job as urgent if you need quick hires.',
                        icon: 'fa-dollar-sign',
                        color: 'yellow',
                        tips: ['Research market rates', 'Be realistic with requirements', 'Offer competitive compensation']
                    },
                    {
                        title: 'Review & Publish',
                        content: 'Review all details carefully, preview how your job will appear to workers, then click "Publish Job". Your listing will go live immediately and workers can start applying.',
                        icon: 'fa-check-circle',
                        color: 'green',
                        tips: ['Double-check all information', 'Preview before publishing', 'Monitor applications regularly']
                    }
                ]
            },
            'manage-applications': {
                title: 'Managing Applications',
                description: 'How to review, shortlist, and communicate with applicants',
                steps: [
                    {
                        title: 'View Applications',
                        content: 'Go to "My Jobs" and click on a job listing to see all applications. You\'ll see applicant profiles, cover letters, and their qualifications.',
                        icon: 'fa-inbox',
                        color: 'blue',
                        tips: ['Check applications daily', 'Read cover letters carefully', 'Review applicant profiles']
                    },
                    {
                        title: 'Review Candidates',
                        content: 'Click on each application to view the worker\'s full profile, skills, experience, and previous work history. Compare candidates based on your requirements.',
                        icon: 'fa-user-check',
                        color: 'purple',
                        tips: ['Compare multiple candidates', 'Check skill matches', 'Look for relevant experience']
                    },
                    {
                        title: 'Shortlist & Contact',
                        content: 'Shortlist promising candidates by clicking "Shortlist". Use the messaging system to ask questions, schedule interviews, or request additional information.',
                        icon: 'fa-comments',
                        color: 'green',
                        tips: ['Shortlist 3-5 candidates', 'Ask relevant questions', 'Respond promptly to messages']
                    },
                    {
                        title: 'Make Your Decision',
                        content: 'After reviewing all candidates, select the best fit and click "Hire". The worker will be notified and you can begin coordinating work details.',
                        icon: 'fa-handshake',
                        color: 'indigo',
                        tips: ['Trust your evaluation', 'Communicate clearly', 'Set clear expectations']
                    }
                ]
            },
            'messaging-system': {
                title: 'Using the Messaging System',
                description: 'Learn how to communicate professionally with employers or workers',
                steps: [
                    {
                        title: 'Access Messages',
                        content: 'Click the "Messages" icon in your dashboard navigation. You\'ll see all your conversations with employers or workers in one place.',
                        icon: 'fa-envelope',
                        color: 'blue',
                        tips: ['Check messages regularly', 'Enable notifications', 'Keep conversations organized']
                    },
                    {
                        title: 'Start a Conversation',
                        content: 'To message someone, go to their profile or job listing and click "Send Message". Write a professional introduction and your question or proposal.',
                        icon: 'fa-comment-dots',
                        color: 'green',
                        tips: ['Be professional and polite', 'Introduce yourself clearly', 'State your purpose upfront']
                    },
                    {
                        title: 'Professional Communication',
                        content: 'Keep messages clear, concise, and professional. Respond promptly to inquiries. Use proper grammar and avoid slang or abbreviations.',
                        icon: 'fa-user-tie',
                        color: 'purple',
                        tips: ['Respond within 24 hours', 'Use proper grammar', 'Be respectful and courteous']
                    },
                    {
                        title: 'Manage Conversations',
                        content: 'Mark important messages, archive old conversations, and use the search function to find specific discussions. Keep your inbox organized.',
                        icon: 'fa-tasks',
                        color: 'indigo',
                        tips: ['Archive completed conversations', 'Use search for old messages', 'Keep inbox organized']
                    }
                ]
            },
            'payment-security': {
                title: 'Payment & Security',
                description: 'Understanding secure payments and protecting your account',
                steps: [
                    {
                        title: 'Secure Payment System',
                        content: 'JOB-lyNK uses secure escrow payments. Employers deposit funds before work begins, and workers receive payment after completion. All transactions are encrypted.',
                        icon: 'fa-shield-alt',
                        color: 'green',
                        tips: ['Never pay outside the platform', 'Verify payment before starting', 'Report suspicious activity']
                    },
                    {
                        title: 'Account Security',
                        content: 'Enable two-factor authentication (2FA) in your settings. Use a strong, unique password. Never share your login credentials with anyone.',
                        icon: 'fa-lock',
                        color: 'red',
                        tips: ['Enable 2FA immediately', 'Use strong passwords', 'Never share credentials']
                    },
                    {
                        title: 'Payment Methods',
                        content: 'Add your preferred payment method in settings. Workers can receive payments via bank transfer or mobile money. Employers can pay using cards or bank transfers.',
                        icon: 'fa-credit-card',
                        color: 'blue',
                        tips: ['Verify payment details', 'Keep information updated', 'Check transaction history']
                    },
                    {
                        title: 'Dispute Resolution',
                        content: 'If issues arise, use our dispute resolution system. Contact support with evidence. Funds are held securely until disputes are resolved fairly.',
                        icon: 'fa-gavel',
                        color: 'orange',
                        tips: ['Document all work', 'Communicate clearly', 'Contact support if needed']
                    }
                ]
            },
            'profile-optimization': {
                title: 'Profile Optimization Tips',
                description: 'Make your profile stand out and increase your chances of getting hired',
                steps: [
                    {
                        title: 'Professional Profile Picture',
                        content: 'Upload a clear, professional headshot. Smile, dress appropriately, and use good lighting. Your photo is the first thing employers see.',
                        icon: 'fa-camera',
                        color: 'blue',
                        tips: ['Use a recent photo', 'Dress professionally', 'Smile and look approachable']
                    },
                    {
                        title: 'Compelling Bio',
                        content: 'Write a 3-4 sentence bio highlighting your expertise, experience, and what makes you unique. Focus on value you bring to employers.',
                        icon: 'fa-file-alt',
                        color: 'green',
                        tips: ['Highlight key strengths', 'Mention years of experience', 'Show your personality']
                    },
                    {
                        title: 'Skills & Certifications',
                        content: 'List all relevant skills with proficiency levels. Upload certificates, diplomas, or training completion documents to verify your expertise.',
                        icon: 'fa-certificate',
                        color: 'purple',
                        tips: ['List 10-15 relevant skills', 'Upload all certificates', 'Keep skills updated']
                    },
                    {
                        title: 'Portfolio & Reviews',
                        content: 'Add examples of your work if applicable. Encourage satisfied employers to leave reviews. Positive reviews significantly increase your hire rate.',
                        icon: 'fa-star',
                        color: 'yellow',
                        tips: ['Showcase best work', 'Request reviews after jobs', 'Maintain 5-star rating']
                    }
                ]
            }
        };

        let currentTutorial = null;
        let currentStepIndex = 0;

        function openVideoModal(tutorialId) {
            currentTutorial = tutorialData[tutorialId];
            currentStepIndex = 0;
            
            if (!currentTutorial) return;
            
            // Play opening sound
            playOpenSound();
            
            document.getElementById('tutorialTitle').textContent = currentTutorial.title;
            document.getElementById('tutorialDescription').textContent = currentTutorial.description;
            document.getElementById('totalSteps').textContent = currentTutorial.steps.length;
            
            generateStepDots();
            renderStep();
            
            document.getElementById('videoModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function generateStepDots() {
            const dotsContainer = document.getElementById('stepDots');
            dotsContainer.innerHTML = '';
            
            currentTutorial.steps.forEach((_, index) => {
                const dot = document.createElement('div');
                dot.className = `w-3 h-3 rounded-full transition-all cursor-pointer ${index === 0 ? 'bg-blue-600 w-8' : 'bg-gray-300'}`;
                dot.onclick = () => goToStep(index);
                dotsContainer.appendChild(dot);
            });
        }

        function renderStep() {
            const step = currentTutorial.steps[currentStepIndex];
            const stepContent = document.getElementById('stepContent');
            
            const colorClasses = {
                blue: 'from-blue-500 to-blue-600',
                green: 'from-green-500 to-green-600',
                purple: 'from-purple-500 to-purple-600',
                indigo: 'from-indigo-500 to-indigo-600',
                yellow: 'from-yellow-500 to-orange-500',
                red: 'from-red-500 to-pink-500',
                orange: 'from-orange-500 to-red-500'
            };
            
            stepContent.innerHTML = `
                <div class="flex items-start space-x-6 animate-fade-in">
                    <div class="flex-shrink-0">
                        <div class="w-20 h-20 bg-gradient-to-br ${colorClasses[step.color]} rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="fas ${step.icon} text-white text-3xl"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">${step.title}</h3>
                        <p class="text-gray-600 text-lg leading-relaxed mb-6">${step.content}</p>
                        
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200">
                            <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                                <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                                Pro Tips
                            </h4>
                            <ul class="space-y-2">
                                ${step.tips.map(tip => `
                                    <li class="flex items-start text-gray-700">
                                        <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                                        <span>${tip}</span>
                                    </li>
                                `).join('')}
                            </ul>
                        </div>
                    </div>
                </div>
            `;
            
            // Update progress
            document.getElementById('currentStep').textContent = currentStepIndex + 1;
            const progress = ((currentStepIndex + 1) / currentTutorial.steps.length) * 100;
            document.getElementById('progressBar').style.width = progress + '%';
            
            // Update buttons
            document.getElementById('prevBtn').disabled = currentStepIndex === 0;
            const nextBtn = document.getElementById('nextBtn');
            if (currentStepIndex === currentTutorial.steps.length - 1) {
                nextBtn.innerHTML = '<i class="fas fa-check mr-2"></i>Finish';
            } else {
                nextBtn.innerHTML = 'Next<i class="fas fa-arrow-right ml-2"></i>';
            }
            
            // Update dots
            updateStepDots();
        }

        function updateStepDots() {
            const dots = document.getElementById('stepDots').children;
            Array.from(dots).forEach((dot, index) => {
                if (index === currentStepIndex) {
                    dot.className = 'w-8 h-3 rounded-full bg-blue-600 transition-all cursor-pointer';
                } else if (index < currentStepIndex) {
                    dot.className = 'w-3 h-3 rounded-full bg-green-500 transition-all cursor-pointer';
                } else {
                    dot.className = 'w-3 h-3 rounded-full bg-gray-300 transition-all cursor-pointer';
                }
            });
        }

        function nextStep() {
            if (currentStepIndex < currentTutorial.steps.length - 1) {
                playNextSound();
                currentStepIndex++;
                renderStep();
            } else {
                playCompleteSound();
                setTimeout(() => closeTutorialModal(), 500);
            }
        }

        function previousStep() {
            if (currentStepIndex > 0) {
                playPrevSound();
                currentStepIndex--;
                renderStep();
            }
        }

        function goToStep(index) {
            playClickSound();
            currentStepIndex = index;
            renderStep();
        }

        function closeTutorialModal() {
            playCloseSound();
            document.getElementById('videoModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            currentTutorial = null;
            currentStepIndex = 0;
        }

        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeTutorialModal();
            }
            if (e.key === 'ArrowRight' && currentTutorial) {
                nextStep();
            }
            if (e.key === 'ArrowLeft' && currentTutorial) {
                previousStep();
            }
        });

        // Close modal on backdrop click
        document.getElementById('videoModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeTutorialModal();
            }
        });
    </script>
    
    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }
    </style>
    @include('includes.footer')
</body>
</html>
