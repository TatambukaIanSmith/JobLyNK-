<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>We'll Be Back Shortly - JOB-lyNK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .maintenance-animation {
            animation: pulse 2s infinite;
        }
        
        .gear-animation {
            animation: rotate 3s linear infinite;
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="min-h-screen gradient-bg flex items-center justify-center p-4">
    
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.1"><circle cx="30" cy="30" r="2"/></g></svg>'); background-size: 60px 60px;"></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 max-w-2xl w-full">
        
        <!-- Logo Section -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-full shadow-2xl mb-6">
                <i class="fas fa-briefcase text-3xl text-indigo-600"></i>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-2">JOB-lyNK</h1>
            <p class="text-indigo-200 text-lg">Your Career Connection Platform</p>
        </div>

        <!-- Main Maintenance Card -->
        <div class="glass-effect rounded-3xl p-8 md:p-12 shadow-2xl text-center">
            
            <!-- Animated Icon -->
            <div class="mb-8">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-orange-400 to-red-500 rounded-full shadow-lg mb-4">
                    <i class="fas fa-cog text-3xl text-white gear-animation"></i>
                </div>
                <div class="maintenance-animation">
                    <span class="inline-block w-3 h-3 bg-orange-400 rounded-full mx-1"></span>
                    <span class="inline-block w-3 h-3 bg-yellow-400 rounded-full mx-1"></span>
                    <span class="inline-block w-3 h-3 bg-green-400 rounded-full mx-1"></span>
                </div>
            </div>

            <!-- Main Heading -->
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                We'll Be Back Shortly
            </h2>

            <!-- Main Message -->
            <div class="text-lg text-indigo-100 mb-8 leading-relaxed">
                <p class="mb-4">
                    Our system is currently undergoing <strong class="text-white">scheduled maintenance</strong> to improve performance, security, and reliability. During this time, access to the platform is temporarily unavailable.
                </p>
                
                <!-- Reassurance -->
                <div class="bg-white bg-opacity-10 rounded-2xl p-6 mb-6">
                    <div class="flex items-center justify-center mb-3">
                        <i class="fas fa-shield-alt text-green-400 text-2xl mr-3"></i>
                        <span class="text-white font-semibold">Your Data is Safe</span>
                    </div>
                    <p class="text-indigo-100">
                        We're working behind the scenes to make things better and will be back online as soon as possible. No action is required from you.
                    </p>
                </div>
            </div>

            <!-- Features Being Improved -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-white bg-opacity-10 rounded-xl p-4">
                    <i class="fas fa-rocket text-yellow-400 text-xl mb-2"></i>
                    <p class="text-white font-medium text-sm">Performance</p>
                </div>
                <div class="bg-white bg-opacity-10 rounded-xl p-4">
                    <i class="fas fa-lock text-green-400 text-xl mb-2"></i>
                    <p class="text-white font-medium text-sm">Security</p>
                </div>
                <div class="bg-white bg-opacity-10 rounded-xl p-4">
                    <i class="fas fa-star text-blue-400 text-xl mb-2"></i>
                    <p class="text-white font-medium text-sm">New Features</p>
                </div>
            </div>

            <!-- Refresh Tip -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl p-6 mb-6">
                <div class="flex items-center justify-center mb-3">
                    <i class="fas fa-sync-alt text-white text-xl mr-3"></i>
                    <span class="text-white font-semibold">Quick Tip</span>
                </div>
                <p class="text-blue-100">
                    You may refresh this page after a few minutes to check if we're back online.
                </p>
                <button onclick="location.reload()" class="mt-4 bg-white text-blue-600 px-6 py-2 rounded-full font-medium hover:bg-blue-50 transition-colors duration-200">
                    <i class="fas fa-redo mr-2"></i>Refresh Page
                </button>
            </div>

            <!-- Support Contact -->
            <div class="border-t border-white border-opacity-20 pt-6">
                <p class="text-indigo-200 text-sm mb-4">
                    Need urgent assistance? Our support team is here to help.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="mailto:support@job-lynk.com" class="inline-flex items-center justify-center bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-6 py-3 rounded-full transition-all duration-200">
                        <i class="fas fa-envelope mr-2"></i>
                        Email Support
                    </a>
                    <a href="tel:+256-XXX-XXXX" class="inline-flex items-center justify-center bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-6 py-3 rounded-full transition-all duration-200">
                        <i class="fas fa-phone mr-2"></i>
                        Call Support
                    </a>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-indigo-200 text-sm">
                Thank you for your patience while we make JOB-lyNK even better!
            </p>
            <div class="flex items-center justify-center mt-4 space-x-6">
                <a href="#" class="text-indigo-300 hover:text-white transition-colors">
                    <i class="fab fa-twitter text-xl"></i>
                </a>
                <a href="#" class="text-indigo-300 hover:text-white transition-colors">
                    <i class="fab fa-facebook text-xl"></i>
                </a>
                <a href="#" class="text-indigo-300 hover:text-white transition-colors">
                    <i class="fab fa-linkedin text-xl"></i>
                </a>
            </div>
        </div>

    </div>

    <!-- Auto-refresh script -->
    <script>
        // Auto-refresh every 2 minutes to check if maintenance is over
        setTimeout(function() {
            location.reload();
        }, 120000); // 2 minutes

        // Add some interactive elements
        document.addEventListener('DOMContentLoaded', function() {
            // Add hover effects to cards
            const cards = document.querySelectorAll('.bg-white.bg-opacity-10');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                    this.style.transition = 'transform 0.2s ease';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>

</body>
</html>