<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - JOB-lyNK</title>
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
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2);
        }
    </style>
</head>
<body class="glass-background">`n    @include('includes.navbar')

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-12 relative z-10">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Get In Touch</h1>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    Have questions or feedback? We'd love to hear from you! Fill out the form below or reach out directly.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Contact Form -->
                <div class="glass-card p-8 rounded-2xl">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Send Us a Message</h2>
                    
                    @if(session('success'))
                        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent transition duration-200">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent transition duration-200">
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                            <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent transition duration-200">
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                            <textarea id="message" name="message" rows="5" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent transition duration-200">{{ old('message') }}</textarea>
                        </div>
                        <button type="submit"
                            class="w-full bg-blue-primary text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-dark transition duration-300 flex items-center justify-center">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Send Message
                        </button>
                    </form>
                </div>

                <!-- Contact Information -->
                <div class="space-y-6">
                    <!-- Contact Details -->
                    <div class="glass-card p-8 rounded-2xl">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Contact Information</h2>
                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-blue-primary rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-envelope text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-1">Email</h3>
                                    <a href="mailto:support@job-lynk.com" class="text-blue-primary hover:text-blue-dark">support@job-lynk.com</a>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-blue-primary rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-phone text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-1">Phone</h3>
                                    <a href="tel:+256750820785" class="text-blue-primary hover:text-blue-dark">+256 750 820 785</a>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-blue-primary rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-map-marker-alt text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-1">Address</h3>
                                    <p class="text-gray-600">Abayita Ababiri, Entebbe Road<br>Kampala, Uganda</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Map -->
                    <div class="glass-card p-8 rounded-2xl">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Find Us</h2>
                        <div class="rounded-lg overflow-hidden h-64">
                            <iframe src="https://maps.app.goo.gl/v2ALGq7sm9H5uh469" 
                                    frameborder="0" 
                                    allowfullscreen 
                                    class="w-full h-full"
                                    loading="lazy"></iframe>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="glass-card p-8 rounded-2xl">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Follow Us</h2>
                        <div class="flex space-x-4">
                            <a href="#" class="w-12 h-12 bg-blue-primary rounded-lg flex items-center justify-center hover:bg-blue-dark transition duration-300">
                                <i class="fab fa-facebook-f text-white text-xl"></i>
                            </a>
                            <a href="#" class="w-12 h-12 bg-blue-primary rounded-lg flex items-center justify-center hover:bg-blue-dark transition duration-300">
                                <i class="fab fa-twitter text-white text-xl"></i>
                            </a>
                            <a href="#" class="w-12 h-12 bg-blue-primary rounded-lg flex items-center justify-center hover:bg-blue-dark transition duration-300">
                                <i class="fab fa-linkedin-in text-white text-xl"></i>
                            </a>
                            <a href="#" class="w-12 h-12 bg-blue-primary rounded-lg flex items-center justify-center hover:bg-blue-dark transition duration-300">
                                <i class="fab fa-instagram text-white text-xl"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 relative z-10 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="text-gray-400">&copy; 2024 JOB-lyNK. All rights reserved.</p>
            </div>
        </div>
    </footer>
    @include('includes.footer')
</body>
</html>