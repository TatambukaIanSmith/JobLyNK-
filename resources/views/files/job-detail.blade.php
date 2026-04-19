<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $job->title }} - JOB-lyNK</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        /* Background */
        .glass-background {
            background: #dfe3ed;
            min-height: 100vh;
        }
    </style>
</head>
<body class="glass-background">
    <!-- Navigation -->
    <nav class="bg-blue-primary shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="{{ route('home') }}" class="text-white text-2xl font-bold">JOB-lyNK</a>
                    </div>
                    <div class="hidden md:block ml-10">
                        @auth
                            @if(Auth::user()->isWorker())
                                <!-- Worker Advertisement -->
                                <div class="flex items-center space-x-3 bg-white bg-opacity-10 px-6 py-2 rounded-lg backdrop-blur-sm">
                                    <i class="fas fa-briefcase text-yellow-300 text-lg"></i>
                                    <span class="text-white font-medium">Find more opportunities like this!</span>
                                    <a href="{{ route('jobs') }}" class="bg-yellow-400 hover:bg-yellow-500 text-blue-primary font-bold px-4 py-1.5 rounded-md transition-colors shadow-sm">
                                        Browse Jobs
                                    </a>
                                </div>
                            @elseif(Auth::user()->isEmployer())
                                <!-- Employer Advertisement -->
                                <div class="flex items-center space-x-3 bg-white bg-opacity-10 px-6 py-2 rounded-lg backdrop-blur-sm">
                                    <i class="fas fa-bullhorn text-yellow-300 text-lg"></i>
                                    <span class="text-white font-medium">Looking for talented workers?</span>
                                    <a href="{{ route('postjob') }}" class="bg-yellow-400 hover:bg-yellow-500 text-blue-primary font-bold px-4 py-1.5 rounded-md transition-colors shadow-sm">
                                        Post a Job
                                    </a>
                                </div>
                            @endif
                        @else
                            <!-- Guest Advertisement -->
                            <div class="flex items-center space-x-3 bg-white bg-opacity-10 px-6 py-2 rounded-lg backdrop-blur-sm">
                                <i class="fas fa-user-plus text-yellow-300 text-lg"></i>
                                <span class="text-white font-medium">Join thousands finding work!</span>
                                <a href="{{ route('register') }}" class="bg-yellow-400 hover:bg-yellow-500 text-blue-primary font-bold px-4 py-1.5 rounded-md transition-colors shadow-sm">
                                    Sign Up Free
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <button class="text-white hover:text-blue-light">
                            <i class="fas fa-bell text-xl"></i>
                        </button>
                        <div class="relative group">
                            <button id="profileBtn" class="flex items-center text-white hover:text-blue-light focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md"
                                    aria-haspopup="true" aria-expanded="false">
                                <img class="h-8 w-8 rounded-full" src="{{ Auth::user()->getProfilePictureUrl() }}" alt="Profile">
                                <span class="ml-2">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down ml-1"></i>
                            </button>
                            <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20">
                                @if(Auth::user()->isWorker())
                                    <a href="{{ route('worker') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                                @elseif(Auth::user()->isEmployer())
                                    <a href="{{ route('employerDashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                                @endif
                                <a href="{{ route('settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-white hover:text-blue-light px-3 py-2 rounded-md text-sm font-medium">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue-secondary text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-dark">Sign Up</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="{{ route('home') }}" class="hover:text-blue-primary">Home</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li><a href="{{ route('jobs') }}" class="hover:text-blue-primary">Jobs</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li class="text-gray-900">{{ $job->title }}</li>
            </ol>
        </nav>

        <!-- Back Button -->
        @auth
            @if(Auth::user()->isWorker())
                <div class="mb-4">
                    <a href="{{ route('worker') }}" class="inline-flex items-center px-4 py-2 bg-blue-primary text-white rounded-lg hover:bg-blue-dark transition-colors shadow-sm">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Dashboard
                    </a>
                </div>
            @elseif(Auth::user()->isEmployer())
                <div class="mb-4">
                    <a href="{{ route('employerDashboard') }}" class="inline-flex items-center px-4 py-2 bg-blue-primary text-white rounded-lg hover:bg-blue-dark transition-colors shadow-sm">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Dashboard
                    </a>
                </div>
            @endif
        @endauth

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Job Header -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="flex items-center mb-2">
                                <h1 class="text-3xl font-bold text-gray-900">{{ $job->title }}</h1>
                                @if($job->is_urgent)
                                    <span class="ml-3 bg-red-100 text-red-800 text-sm px-3 py-1 rounded-full">Urgent</span>
                                @endif
                                @if($job->is_featured)
                                    <span class="ml-2 bg-yellow-100 text-yellow-800 text-sm px-3 py-1 rounded-full">Featured</span>
                                @endif
                            </div>
                            <div class="flex items-center text-gray-600 mb-4">
                                <i class="fas fa-user mr-2"></i>
                                <span>Posted by {{ $job->employer->name }}</span>
                                <span class="mx-2">•</span>
                                <i class="fas fa-clock mr-2"></i>
                                <span>{{ $job->created_at->diffForHumans() }}</span>
                                <span class="mx-2">•</span>
                                <i class="fas fa-eye mr-2"></i>
                                <span>{{ $job->views }} views</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold text-green-600 mb-1">
                                UGX {{ number_format($job->budget) }}
                            </div>
                            <div class="text-sm text-gray-500">
                                @if($job->payment_type === 'hourly')
                                    per hour
                                @elseif($job->payment_type === 'fixed')
                                    fixed price
                                @else
                                    negotiable
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Job Details -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <i class="fas fa-map-marker-alt text-blue-primary mr-2"></i>
                            <div>
                                <div class="text-sm text-gray-500">Location</div>
                                <div class="font-medium">{{ $job->location }}</div>
                            </div>
                        </div>
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <i class="fas fa-clock text-blue-primary mr-2"></i>
                            <div>
                                <div class="text-sm text-gray-500">Duration</div>
                                <div class="font-medium">{{ $job->duration ?? 'Not specified' }}</div>
                            </div>
                        </div>
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <i class="fas fa-calendar text-blue-primary mr-2"></i>
                            <div>
                                <div class="text-sm text-gray-500">Start Date</div>
                                <div class="font-medium">{{ \Carbon\Carbon::parse($job->start_date)->format('M d, Y') }}</div>
                            </div>
                        </div>
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <i class="fas fa-briefcase text-blue-primary mr-2"></i>
                            <div>
                                <div class="text-sm text-gray-500">Job Type</div>
                                <div class="font-medium">{{ ucfirst($job->job_type) }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Tags -->
                    <div class="flex flex-wrap gap-2">
                        <span class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">{{ $job->category->name }}</span>
                        <span class="bg-gray-100 text-gray-700 text-sm px-3 py-1 rounded-full">{{ ucfirst($job->job_type) }}</span>
                        <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full">{{ ucfirst($job->payment_type) }}</span>
                        @if($job->urgency !== 'normal')
                            <span class="bg-orange-100 text-orange-800 text-sm px-3 py-1 rounded-full">{{ ucfirst($job->urgency) }}</span>
                        @endif
                        @if($job->requires_background_check)
                            <span class="bg-purple-100 text-purple-800 text-sm px-3 py-1 rounded-full">Background Check Required</span>
                        @endif
                    </div>
                </div>

                <!-- Job Description -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Job Description</h2>
                    <div class="prose max-w-none">
                        <p class="text-gray-700 leading-relaxed">{{ $job->description }}</p>
                    </div>
                </div>

                <!-- Required Skills -->
                @if($job->required_skills && trim($job->required_skills) !== '')
                    <div class="bg-white rounded-lg shadow p-6 mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Required Skills</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach(explode(',', $job->required_skills) as $skill)
                                @if(trim($skill))
                                    <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-sm">{{ trim($skill) }}</span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Application Form -->
                @auth
                    @if(Auth::user()->isWorker() && !$hasApplied && $job->isActive())
                        <div class="bg-white rounded-lg shadow-xl overflow-hidden border-2 border-blue-100">
                            <!-- Collapsed Preview Header -->
                            <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-6 text-white cursor-pointer" onclick="toggleApplicationForm()" id="applicationPreview">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-16 h-16 bg-white rounded-xl flex items-center justify-center p-3 shadow-lg">
                                            <img src="{{ asset('job-lynk-logo.png') }}" alt="JOB-lyNK Logo" class="w-full h-full object-contain">
                                        </div>
                                        <div>
                                            <h2 class="text-2xl font-bold mb-1">Apply for this Position</h2>
                                            <p class="text-blue-100 text-sm flex items-center">
                                                <i class="fas fa-magic mr-2"></i>
                                                Professional application template ready for you!
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-center">
                                        <button type="button" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-bold hover:bg-blue-50 transition-all shadow-lg transform hover:scale-105 flex items-center space-x-2">
                                            <i class="fas fa-chevron-down transition-transform duration-300" id="toggleIcon"></i>
                                            <span>View Application Form</span>
                                        </button>
                                        <p class="text-xs text-blue-100 mt-2">Click to expand</p>
                                    </div>
                                </div>
                                
                                <!-- Preview Features -->
                                <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-3">
                                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 text-center">
                                        <i class="fas fa-user-circle text-2xl mb-1"></i>
                                        <p class="text-xs">Personal Info</p>
                                    </div>
                                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 text-center">
                                        <i class="fas fa-graduation-cap text-2xl mb-1"></i>
                                        <p class="text-xs">Education</p>
                                    </div>
                                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 text-center">
                                        <i class="fas fa-tools text-2xl mb-1"></i>
                                        <p class="text-xs">Skills</p>
                                    </div>
                                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 text-center">
                                        <i class="fas fa-file-alt text-2xl mb-1"></i>
                                        <p class="text-xs">Cover Letter</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Full Application Form (Initially Hidden) -->
                            <div id="fullApplicationForm" class="hidden">
                                <!-- Application Header with Logo -->
                                <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-6 text-white border-t-4 border-yellow-400">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center p-2 animate-pulse">
                                                <img src="{{ asset('job-lynk-logo.png') }}" alt="JOB-lyNK Logo" class="w-full h-full object-contain">
                                            </div>
                                            <div>
                                                <h2 class="text-2xl font-bold">JOB-lyNK</h2>
                                                <p class="text-blue-100 text-sm">Official Application Form</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-xs text-blue-100">Application ID</div>
                                            <div class="font-mono text-sm bg-white/20 px-3 py-1 rounded">{{ strtoupper(substr(md5(Auth::id() . time()), 0, 8)) }}</div>
                                        </div>
                                    </div>
                                    <div class="border-t border-blue-400 pt-4">
                                        <h3 class="text-xl font-semibold mb-1">Application for: {{ $job->title }}</h3>
                                        <p class="text-blue-100 text-sm">{{ $job->employer->name }} • {{ $job->location }}</p>
                                    </div>
                                    
                                    <!-- Collapse Button -->
                                    <div class="mt-4 text-center">
                                        <button type="button" onclick="toggleApplicationForm()" class="text-white hover:text-blue-100 text-sm flex items-center space-x-2 mx-auto">
                                            <i class="fas fa-chevron-up"></i>
                                            <span>Collapse Form</span>
                                        </button>
                                    </div>
                                </div>

                                <!-- Application Form Body -->
                                <form method="POST" action="{{ route('jobs.apply', $job) }}" class="p-6 space-y-6">
                                @csrf
                                
                                <!-- Personal Information Section -->
                                <div class="border-l-4 border-blue-500 pl-4">
                                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                        <i class="fas fa-user-circle text-blue-600 mr-2"></i>
                                        Personal Information
                                    </h3>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Full Name <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" name="full_name" required
                                                value="{{ old('full_name', Auth::user()->name) }}"
                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                                placeholder="Enter your full name">
                                            @error('full_name')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Age <span class="text-red-500">*</span>
                                            </label>
                                            <input type="number" name="age" required min="16" max="100"
                                                value="{{ old('age') }}"
                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                                placeholder="Your age">
                                            @error('age')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Sex/Gender <span class="text-red-500">*</span>
                                            </label>
                                            <select name="sex" required
                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                                <option value="">Select gender</option>
                                                <option value="male" {{ old('sex') == 'male' ? 'selected' : '' }}>Male</option>
                                                <option value="female" {{ old('sex') == 'female' ? 'selected' : '' }}>Female</option>
                                                <option value="other" {{ old('sex') == 'other' ? 'selected' : '' }}>Other</option>
                                                <option value="prefer_not_to_say" {{ old('sex') == 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                                            </select>
                                            @error('sex')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Contact Number <span class="text-red-500">*</span>
                                            </label>
                                            <input type="tel" name="contact" required
                                                value="{{ old('contact', Auth::user()->phone) }}"
                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                                placeholder="+256 700 000 000">
                                            @error('contact')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Physical Address <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" name="address" required
                                                value="{{ old('address', Auth::user()->location) }}"
                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                                placeholder="Street, City, District">
                                            @error('address')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Education Background Section -->
                                <div class="border-l-4 border-green-500 pl-4">
                                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                        <i class="fas fa-graduation-cap text-green-600 mr-2"></i>
                                        Education Background
                                    </h3>
                                    
                                    <div class="mb-4">
                                        <label class="flex items-center space-x-3 cursor-pointer">
                                            <input type="checkbox" name="no_education" id="noEducationCheckbox" value="1"
                                                {{ old('no_education') ? 'checked' : '' }}
                                                onchange="toggleEducationFields()"
                                                class="w-5 h-5 text-blue-600 border-2 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                                            <span class="text-sm font-medium text-gray-700">I have no formal education background</span>
                                        </label>
                                    </div>

                                    <div id="educationFields" class="{{ old('no_education') ? 'hidden' : '' }} space-y-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Highest Level of Education
                                            </label>
                                            <select name="education_level"
                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                                <option value="">Select level</option>
                                                <option value="primary" {{ old('education_level') == 'primary' ? 'selected' : '' }}>Primary Education</option>
                                                <option value="secondary" {{ old('education_level') == 'secondary' ? 'selected' : '' }}>Secondary Education (O-Level)</option>
                                                <option value="advanced" {{ old('education_level') == 'advanced' ? 'selected' : '' }}>Advanced Level (A-Level)</option>
                                                <option value="certificate" {{ old('education_level') == 'certificate' ? 'selected' : '' }}>Certificate</option>
                                                <option value="diploma" {{ old('education_level') == 'diploma' ? 'selected' : '' }}>Diploma</option>
                                                <option value="bachelors" {{ old('education_level') == 'bachelors' ? 'selected' : '' }}>Bachelor's Degree</option>
                                                <option value="masters" {{ old('education_level') == 'masters' ? 'selected' : '' }}>Master's Degree</option>
                                                <option value="phd" {{ old('education_level') == 'phd' ? 'selected' : '' }}>PhD/Doctorate</option>
                                            </select>
                                            @error('education_level')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Institution/School Name
                                            </label>
                                            <input type="text" name="institution"
                                                value="{{ old('institution') }}"
                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                                placeholder="Name of school/university">
                                            @error('institution')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                    Year Completed
                                                </label>
                                                <input type="number" name="graduation_year" min="1950" max="{{ date('Y') + 5 }}"
                                                    value="{{ old('graduation_year') }}"
                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                                    placeholder="e.g., 2020">
                                                @error('graduation_year')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                    Field of Study
                                                </label>
                                                <input type="text" name="field_of_study"
                                                    value="{{ old('field_of_study') }}"
                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                                    placeholder="e.g., Computer Science">
                                                @error('field_of_study')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Skills Section -->
                                <div class="border-l-4 border-purple-500 pl-4">
                                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                        <i class="fas fa-tools text-purple-600 mr-2"></i>
                                        Skills & Competencies
                                    </h3>
                                    
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Relevant Skills <span class="text-red-500">*</span>
                                            <span class="text-xs text-gray-500 font-normal">(Separate with commas)</span>
                                        </label>
                                        <textarea name="skills" required rows="3"
                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            placeholder="e.g., Plumbing, Electrical work, Carpentry, Customer service">{{ old('skills') }}</textarea>
                                        <p class="mt-1 text-xs text-gray-500">List skills that are relevant to this job position</p>
                                        @error('skills')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Hobbies Section -->
                                <div class="border-l-4 border-yellow-500 pl-4">
                                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                        <i class="fas fa-heart text-yellow-600 mr-2"></i>
                                        Hobbies & Interests
                                    </h3>
                                    
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Your Hobbies <span class="text-red-500">*</span>
                                        </label>
                                        <textarea name="hobbies" required rows="2"
                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            placeholder="e.g., Reading, Sports, Music, Traveling">{{ old('hobbies') }}</textarea>
                                        @error('hobbies')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Cover Letter Section -->
                                <div class="border-l-4 border-red-500 pl-4">
                                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                        <i class="fas fa-file-alt text-red-600 mr-2"></i>
                                        Cover Letter
                                    </h3>
                                    
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Why are you the best fit for this position? <span class="text-red-500">*</span>
                                        </label>
                                        <textarea name="cover_letter" required rows="6"
                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            placeholder="Explain your experience, motivation, and why you're perfect for this job...">{{ old('cover_letter') }}</textarea>
                                        <p class="mt-1 text-xs text-gray-500">Minimum 50 characters required</p>
                                        @error('cover_letter')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                @if($job->payment_type === 'negotiable')
                                    <!-- Proposed Rate Section -->
                                    <div class="border-l-4 border-indigo-500 pl-4">
                                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                            <i class="fas fa-money-bill-wave text-indigo-600 mr-2"></i>
                                            Proposed Rate
                                        </h3>
                                        
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Your Proposed Rate (UGX)
                                            </label>
                                            <input type="number" name="proposed_rate" min="0" step="1000"
                                                value="{{ old('proposed_rate') }}"
                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                                placeholder="Enter your expected payment">
                                            @error('proposed_rate')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                @endif

                                <!-- Declaration Section -->
                                <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-4">
                                    <label class="flex items-start space-x-3 cursor-pointer">
                                        <input type="checkbox" name="declaration" required
                                            class="w-5 h-5 text-blue-600 border-2 border-gray-300 rounded focus:ring-2 focus:ring-blue-500 mt-1">
                                        <span class="text-sm text-gray-700">
                                            <strong>Declaration:</strong> I hereby declare that all the information provided in this application is true and accurate to the best of my knowledge. I understand that any false information may result in the rejection of my application or termination of employment.
                                        </span>
                                    </label>
                                    @error('declaration')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="flex items-center justify-between pt-4 border-t-2 border-gray-200">
                                    <div class="text-sm text-gray-600">
                                        <i class="fas fa-shield-alt text-green-600 mr-1"></i>
                                        Your application is secure and verified by JOB-lyNK
                                    </div>
                                    <button type="submit" 
                                        class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-4 px-8 rounded-lg transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center space-x-2">
                                        <i class="fas fa-paper-plane"></i>
                                        <span>Submit Application</span>
                                    </button>
                                </div>
                            </form>

                            <!-- Application Footer -->
                            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                                <div class="flex items-center justify-between text-xs text-gray-500">
                                    <div class="flex items-center space-x-4">
                                        <span><i class="fas fa-check-circle text-green-500 mr-1"></i> Verified Application</span>
                                        <span><i class="fas fa-lock text-blue-500 mr-1"></i> Secure & Encrypted</span>
                                    </div>
                                    <div>
                                        Powered by <strong class="text-blue-600">JOB-lyNK</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>

                        <style>
                            @keyframes fadeIn {
                                from {
                                    opacity: 0;
                                    transform: translateY(10px);
                                }
                                to {
                                    opacity: 1;
                                    transform: translateY(0);
                                }
                            }
                            
                            .animate-fadeIn {
                                animation: fadeIn 0.5s ease-out forwards;
                            }
                        </style>

                        <script>
                            function toggleApplicationForm() {
                                const fullForm = document.getElementById('fullApplicationForm');
                                const preview = document.getElementById('applicationPreview');
                                const annotation = document.getElementById('applicationAnnotation');
                                const icon = document.getElementById('toggleIcon');
                                
                                if (fullForm.classList.contains('hidden')) {
                                    // Show full form
                                    fullForm.classList.remove('hidden');
                                    preview.classList.add('hidden');
                                    if (annotation) annotation.classList.add('hidden');
                                    icon.classList.remove('fa-chevron-down');
                                    icon.classList.add('fa-chevron-up');
                                    
                                    // Smooth scroll to form
                                    setTimeout(() => {
                                        fullForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
                                    }, 100);
                                } else {
                                    // Hide full form
                                    fullForm.classList.add('hidden');
                                    preview.classList.remove('hidden');
                                    if (annotation) annotation.classList.remove('hidden');
                                    icon.classList.remove('fa-chevron-up');
                                    icon.classList.add('fa-chevron-down');
                                    
                                    // Scroll back to preview
                                    setTimeout(() => {
                                        preview.scrollIntoView({ behavior: 'smooth', block: 'start' });
                                    }, 100);
                                }
                            }
                            
                            function toggleEducationFields() {
                                const checkbox = document.getElementById('noEducationCheckbox');
                                const fields = document.getElementById('educationFields');
                                
                                if (checkbox.checked) {
                                    fields.classList.add('hidden');
                                    // Clear education field values when hidden
                                    fields.querySelectorAll('input, select, textarea').forEach(field => {
                                        field.removeAttribute('required');
                                    });
                                } else {
                                    fields.classList.remove('hidden');
                                }
                            }
                        </script>
                        
                        <!-- Artistic Annotation (Hidden when form is expanded) -->
                        <div id="applicationAnnotation" class="mt-6 relative">
                            <!-- Decorative Arrow pointing up -->
                            <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 text-blue-600 animate-bounce">
                                <i class="fas fa-arrow-up text-3xl"></i>
                            </div>
                            
                            <!-- Annotation Card -->
                            <div class="bg-gradient-to-r from-purple-50 via-blue-50 to-indigo-50 rounded-2xl p-6 shadow-lg border-2 border-dashed border-blue-300 relative overflow-hidden">
                                <!-- Decorative Background Elements -->
                                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-200 rounded-full opacity-20 -mr-16 -mt-16"></div>
                                <div class="absolute bottom-0 left-0 w-24 h-24 bg-purple-200 rounded-full opacity-20 -ml-12 -mb-12"></div>
                                
                                <!-- Content -->
                                <div class="relative z-10">
                                    <div class="flex items-start space-x-4">
                                        <!-- Icon -->
                                        <div class="flex-shrink-0">
                                            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg animate-pulse">
                                                <i class="fas fa-magic text-white text-2xl"></i>
                                            </div>
                                        </div>
                                        
                                        <!-- Text Content -->
                                        <div class="flex-1">
                                            <h3 class="text-xl font-bold text-gray-800 mb-2 flex items-center">
                                                <div class="w-6 h-6 bg-white rounded flex items-center justify-center mr-2 p-1 shadow-sm border border-blue-200">
                                                    <img src="{{ asset('job-lynk-logo.png') }}" alt="JOB-lyNK" class="w-full h-full object-contain">
                                                </div>
                                                <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                                    Your Application is Ready!
                                                </span>
                                            </h3>
                                            <p class="text-gray-700 text-sm leading-relaxed mb-3">
                                                We've prepared a <strong class="text-blue-600">professional application template</strong> just for you! 
                                                No need to write from scratch - simply fill in your details and submit.
                                            </p>
                                            
                                            <!-- Features List -->
                                            <div class="grid grid-cols-2 gap-2 mb-3">
                                                <div class="flex items-center text-xs text-gray-600">
                                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                                    <span>Pre-formatted</span>
                                                </div>
                                                <div class="flex items-center text-xs text-gray-600">
                                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                                    <span>Professional</span>
                                                </div>
                                                <div class="flex items-center text-xs text-gray-600">
                                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                                    <span>Easy to fill</span>
                                                </div>
                                                <div class="flex items-center text-xs text-gray-600">
                                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                                    <span>Verified by JOB-lyNK</span>
                                                </div>
                                            </div>
                                            
                                            <!-- Call to Action -->
                                            <div class="flex items-center space-x-2 text-sm">
                                                <i class="fas fa-hand-point-up text-blue-600 animate-bounce"></i>
                                                <span class="text-blue-600 font-semibold">Click above to view your application template</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Bottom Badge -->
                                    <div class="mt-4 pt-4 border-t border-blue-200">
                                        <div class="flex items-center justify-center space-x-2 text-xs text-gray-600">
                                            <i class="fas fa-shield-alt text-blue-500"></i>
                                            <span>Powered by <strong class="text-blue-600">JOB-lyNK</strong> Application System</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif(Auth::user()->isWorker() && $hasApplied)
                        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                                <div>
                                    <h3 class="text-lg font-medium text-green-800">Application Submitted</h3>
                                    <p class="text-green-700">You have already applied for this job. The employer will review your application and get back to you.</p>
                                </div>
                            </div>
                        </div>
                    @elseif(!$job->isActive())
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                            <div class="flex items-center">
                                <i class="fas fa-info-circle text-gray-500 text-xl mr-3"></i>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-800">Job No Longer Available</h3>
                                    <p class="text-gray-600">This job is no longer accepting applications.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <div class="flex items-center">
                            <i class="fas fa-info-circle text-blue-500 text-xl mr-3"></i>
                            <div>
                                <h3 class="text-lg font-medium text-blue-800">Login Required</h3>
                                <p class="text-blue-700 mb-3">You need to login as a worker to apply for this job.</p>
                                <a href="{{ route('login') }}" class="bg-blue-primary text-white px-4 py-2 rounded-lg hover:bg-blue-dark transition duration-300">
                                    Login to Apply
                                </a>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Action Buttons -->
                @auth
                    @if(Auth::user()->isWorker())
                        <div class="bg-white rounded-lg shadow p-6 mb-6">
                            <button onclick="toggleBookmark({{ $job->id }})" 
                                    class="bookmark-btn w-full border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition duration-300 mb-3"
                                    data-job-id="{{ $job->id }}"
                                    data-bookmarked="{{ Auth::user()->hasBookmarked($job->id) ? 'true' : 'false' }}">
                                <i class="fas fa-heart mr-2 {{ Auth::user()->hasBookmarked($job->id) ? 'text-red-500' : '' }}"></i>
                                <span>{{ Auth::user()->hasBookmarked($job->id) ? 'Saved' : 'Save Job' }}</span>
                            </button>
                            <button class="w-full border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition duration-300">
                                <i class="fas fa-share mr-2"></i>
                                Share Job
                            </button>
                        </div>
                    @endif
                @endauth

                <!-- Employer Info -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">About the Employer</h3>
                    <div class="flex items-center mb-3">
                        <img class="h-12 w-12 rounded-full" src="{{ $job->employer->getProfilePictureUrl() }}" alt="{{ $job->employer->name }}">
                        <div class="ml-3">
                            <div class="font-medium text-gray-900">{{ $job->employer->name }}</div>
                            <div class="text-sm text-gray-500">Employer</div>
                        </div>
                    </div>
                    @if($job->employer->bio)
                        <p class="text-gray-600 text-sm mb-3">{{ \Illuminate\Support\Str::limit($job->employer->bio, 100) }}</p>
                    @endif
                    @if($job->employer->location)
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <span>{{ $job->employer->location }}</span>
                        </div>
                    @endif
                </div>

                <!-- Job Stats -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Job Statistics</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Applications</span>
                            <span class="font-medium">{{ $job->applications_count }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Views</span>
                            <span class="font-medium">{{ $job->views }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Posted</span>
                            <span class="font-medium">{{ $job->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Related Jobs -->
                @if($relatedJobs->count() > 0)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Related Jobs</h3>
                        <div class="space-y-4">
                            @foreach($relatedJobs as $relatedJob)
                                <div class="border-b border-gray-200 pb-4 last:border-b-0 last:pb-0">
                                    <h4 class="font-medium text-gray-900 mb-1">
                                        <a href="{{ route('jobs.show', $relatedJob) }}" class="hover:text-blue-primary">
                                            {{ \Illuminate\Support\Str::limit($relatedJob->title, 50) }}
                                        </a>
                                    </h4>
                                    <div class="text-sm text-gray-500 mb-2">{{ $relatedJob->location }}</div>
                                    <div class="text-sm font-medium text-green-600">UGX {{ number_format($relatedJob->budget) }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function () {
        // Profile dropdown functionality
        $('#profileBtn').on('click', function (e) {
            e.stopPropagation();
            $('#dropdownMenu').toggle();
        });

        // Hide dropdown when clicking outside
        $(document).on('click', function () {
            $('#dropdownMenu').hide();
        });

        // Setup CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    // Bookmark functionality
    function toggleBookmark(jobId) {
        const button = $(`.bookmark-btn[data-job-id="${jobId}"]`);
        const isBookmarked = button.data('bookmarked') === 'true';
        
        // Disable button during request
        button.prop('disabled', true);
        
        $.ajax({
            url: `/jobs/${jobId}/bookmark`,
            method: 'POST',
            success: function(response) {
                if (response.success) {
                    // Update button state
                    const newBookmarked = !isBookmarked;
                    button.data('bookmarked', newBookmarked);
                    
                    // Update button appearance
                    const heartIcon = button.find('i');
                    const buttonText = button.find('span');
                    
                    if (newBookmarked) {
                        heartIcon.addClass('text-red-500');
                        buttonText.text('Saved');
                    } else {
                        heartIcon.removeClass('text-red-500');
                        buttonText.text('Save Job');
                    }
                    
                    // Show success message
                    showMessage(response.message, 'success');
                } else {
                    showMessage(response.message || 'An error occurred', 'error');
                }
            },
            error: function(xhr) {
                if (xhr.status === 401) {
                    showMessage('Please login to bookmark jobs', 'error');
                } else {
                    showMessage('An error occurred while bookmarking the job', 'error');
                }
            },
            complete: function() {
                // Re-enable button
                button.prop('disabled', false);
            }
        });
    }

    // Show message function
    function showMessage(message, type) {
        const alertClass = type === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700';
        const messageHtml = `
            <div class="fixed top-4 right-4 z-50 ${alertClass} border px-4 py-3 rounded shadow-lg" role="alert">
                <span class="block sm:inline">${message}</span>
                <button class="float-right ml-4 text-lg font-bold" onclick="this.parentElement.remove()">&times;</button>
            </div>
        `;
        
        $('body').append(messageHtml);
        
        // Auto-remove after 5 seconds
        setTimeout(function() {
            $('.fixed.top-4.right-4').fadeOut(function() {
                $(this).remove();
            });
        }, 5000);
    }
    </script>
</body>
</html>