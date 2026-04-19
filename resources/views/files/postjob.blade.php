<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post a Job - JOB-lyNK</title>
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
    <nav class="bg-blue-primary shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="index.html" class="text-white text-2xl font-bold">JOB-lyNK</a>
                    </div>
                    <div class="hidden md:block ml-10">
                        <div class="flex items-baseline space-x-4">
                            <a href="{{route('home')}}" class="text-white px-3 py-2 rounded-md text-sm font-medium">Home</a>
                            <a href="{{route('employerDashboard')}}" class="text-blue-light hover:text-white px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                            <a href="#" class="text-white px-3 py-2 rounded-md text-sm font-medium">Post a Job</a>
                            {{-- <a href="'jobs.html'" class="text-blue-light hover:text-white px-3 py-2 rounded-md text-sm font-medium">My Jobs</a> --}}
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{route('login')}}" class="text-blue-light hover:text-white px-3 py-2 rounded-md text-sm font-medium">Sign In</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Post a Job</h1>
            <p class="text-gray-600">Find the perfect worker for your task</p>
        </div>

        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex items-center justify-center">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-8 h-8 bg-blue-primary text-white rounded-full text-sm font-semibold">1</div>
                    <span class="ml-2 text-sm font-medium text-blue-primary">Job Details</span>
                </div>
                <div class="mx-4 h-px bg-gray-300 w-16"></div>
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-8 h-8 bg-gray-300 text-gray-600 rounded-full text-sm font-semibold">2</div>
                    <span class="ml-2 text-sm font-medium text-gray-600">Budget & Timeline</span>
                </div>
                <div class="mx-4 h-px bg-gray-300 w-16"></div>
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-8 h-8 bg-gray-300 text-gray-600 rounded-full text-sm font-semibold">3</div>
                    <span class="ml-2 text-sm font-medium text-gray-600">Review & Post</span>
                </div>
            </div>
        </div>

        <form class="bg-white rounded-lg shadow-lg p-8" id="jobPostForm" method="POST" action="{{ route('postjob.store') }}">
            @csrf
            
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    <strong class="font-bold">Please fix the following errors:</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            
            <!-- Step 1: Job Details -->
            <div id="step1" class="step">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Tell us about your job</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="jobTitle" class="block text-sm font-medium text-gray-700 mb-2">Job Title *</label>
                        <input type="text" id="jobTitle" name="jobTitle" required
                            placeholder="e.g., House Cleaning, Delivery Service"
                            value="{{ old('jobTitle') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent">
                        @error('jobTitle')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                        <select id="category" name="category" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent">
                            <option value="">Select a category</option>
                            @foreach($categories ?? [] as $category)
                                <option value="{{ $category->slug }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Job Description *</label>
                    <textarea id="description" name="description" rows="5" required
                        placeholder="Describe what you need done, any specific requirements, and what's included..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Location *</label>
                        <input type="text" id="location" name="location" required
                            placeholder="Address or general area"
                            value="{{ old('location') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent">
                        @error('location')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="jobType" class="block text-sm font-medium text-gray-700 mb-2">Job Type *</label>
                        <select id="jobType" name="jobType" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent">
                            <option value="">Select job type</option>
                            <option value="one-time" {{ old('jobType') == 'one-time' ? 'selected' : '' }}>One-time task</option>
                            <option value="recurring" {{ old('jobType') == 'recurring' ? 'selected' : '' }}>Recurring job</option>
                            <option value="project" {{ old('jobType') == 'project' ? 'selected' : '' }}>Short-term project</option>
                        </select>
                        @error('jobType')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Skills Required</label>
                    <div class="space-y-4">
                        <!-- Skills Selection Interface -->
                        <div class="border border-gray-300 rounded-lg p-4">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-sm text-gray-600">Select skills needed for this job</span>
                                <button type="button" onclick="openJobSkillsModal()" class="text-blue-primary hover:text-blue-dark text-sm font-medium">
                                    <i class="fas fa-plus mr-1"></i>Add Skills
                                </button>
                            </div>
                            
                            <!-- Selected Skills Display -->
                            <div id="selectedJobSkills" class="space-y-2">
                                <!-- Selected skills will appear here -->
                            </div>
                            
                            <!-- Empty State -->
                            <div id="noSkillsSelected" class="text-center py-4 text-gray-500">
                                <i class="fas fa-tools text-2xl mb-2"></i>
                                <p class="text-sm">No skills selected yet</p>
                                <p class="text-xs">Click "Add Skills" to specify what skills workers need</p>
                            </div>
                        </div>
                        
                        <!-- Hidden input to store selected skills -->
                        <input type="hidden" name="job_skills" id="jobSkillsInput" value="">
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="button" onclick="nextStep()" class="bg-blue-primary text-white px-6 py-2 rounded-lg hover:bg-blue-dark transition duration-300">
                        Next: Budget & Timeline
                    </button>
                </div>
            </div>

            <!-- Step 2: Budget & Timeline -->
            <div id="step2" class="step hidden">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Budget and Timeline</h2>
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">How would you like to pay?</label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <label class="relative">
                            <input type="radio" name="paymentType" value="hourly" class="sr-only peer" {{ old('paymentType', 'hourly') == 'hourly' ? 'checked' : '' }}>
                            <div class="border-2 border-gray-300 rounded-lg p-4 cursor-pointer peer-checked:border-blue-primary peer-checked:bg-blue-light transition-all">
                                <div class="text-center">
                                    <i class="fas fa-clock text-2xl text-blue-primary mb-2"></i>
                                    <div class="font-semibold">Hourly Rate</div>
                                    <div class="text-sm text-gray-600">Pay per hour worked</div>
                                </div>
                            </div>
                        </label>
                        <label class="relative">
                            <input type="radio" name="paymentType" value="fixed" class="sr-only peer" {{ old('paymentType') == 'fixed' ? 'checked' : '' }}>
                            <div class="border-2 border-gray-300 rounded-lg p-4 cursor-pointer peer-checked:border-blue-primary peer-checked:bg-blue-light transition-all">
                                <div class="text-center">
                                    <i class="fas fa-dollar-sign text-2xl text-blue-primary mb-2"></i>
                                    <div class="font-semibold">Fixed Price</div>
                                    <div class="text-sm text-gray-600">One-time payment</div>
                                </div>
                            </div>
                        </label>
                        <label class="relative">
                            <input type="radio" name="paymentType" value="negotiable" class="sr-only peer" {{ old('paymentType') == 'negotiable' ? 'checked' : '' }}>
                            <div class="border-2 border-gray-300 rounded-lg p-4 cursor-pointer peer-checked:border-blue-primary peer-checked:bg-blue-light transition-all">
                                <div class="text-center">
                                    <i class="fas fa-handshake text-2xl text-blue-primary mb-2"></i>
                                    <div class="font-semibold">Negotiable</div>
                                    <div class="text-sm text-gray-600">Discuss with worker</div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div id="budgetField">
                        <label for="budget" class="block text-sm font-medium text-gray-700 mb-2">Budget *</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-500">$</span>
                            <input type="number" id="budget" name="budget" required step="0.01"
                                placeholder="25"
                                value="{{ old('budget') }}"
                                class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent">
                            <span id="budgetSuffix" class="absolute right-3 top-2 text-gray-500">/hour</span>
                        </div>
                    </div>
                    <div>
                        <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">Estimated Duration</label>
                        <select id="duration" name="duration"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent">
                            <option value="">Select duration</option>
                            <option value="1-2">1-2 hours</option>
                            <option value="3-5">3-5 hours</option>
                            <option value="6-8">6-8 hours</option>
                            <option value="full-day">Full day (8+ hours)</option>
                            <option value="multiple-days">Multiple days</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="startDate" class="block text-sm font-medium text-gray-700 mb-2">Start Date *</label>
                        <input type="date" id="startDate" name="startDate" required
                            value="{{ old('startDate') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent">
                        @error('startDate')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="urgency" class="block text-sm font-medium text-gray-700 mb-2">Urgency</label>
                        <select id="urgency" name="urgency"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent">
                            <option value="normal" {{ old('urgency', 'normal') == 'normal' ? 'selected' : '' }}>Normal</option>
                            <option value="urgent" {{ old('urgency') == 'urgent' ? 'selected' : '' }}>Urgent (within 24 hours)</option>
                            <option value="asap" {{ old('urgency') == 'asap' ? 'selected' : '' }}>ASAP (within 6 hours)</option>
                        </select>
                        @error('urgency')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-between">
                    <button type="button" onclick="prevStep()" class="border border-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-50 transition duration-300">
                        Previous
                    </button>
                    <button type="button" onclick="nextStep()" class="bg-blue-primary text-white px-6 py-2 rounded-lg hover:bg-blue-dark transition duration-300">
                        Next: Review
                    </button>
                </div>
            </div>

            <!-- Step 3: Review & Post -->
            <div id="step3" class="step hidden">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Review Your Job Post</h2>
                
                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-2">Job Details</h3>
                            <div class="space-y-2 text-sm">
                                <div><span class="text-gray-600">Title:</span> <span id="reviewTitle"></span></div>
                                <div><span class="text-gray-600">Category:</span> <span id="reviewCategory"></span></div>
                                <div><span class="text-gray-600">Type:</span> <span id="reviewType"></span></div>
                                <div><span class="text-gray-600">Location:</span> <span id="reviewLocation"></span></div>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-2">Budget & Timeline</h3>
                            <div class="space-y-2 text-sm">
                                <div><span class="text-gray-600">Payment:</span> <span id="reviewPayment"></span></div>
                                <div><span class="text-gray-600">Duration:</span> <span id="reviewDuration"></span></div>
                                <div><span class="text-gray-600">Start Date:</span> <span id="reviewStartDate"></span></div>
                                <div><span class="text-gray-600">Urgency:</span> <span id="reviewUrgency"></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h3 class="font-semibold text-gray-900 mb-2">Description</h3>
                        <p class="text-sm text-gray-600" id="reviewDescription"></p>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 mb-3">Additional Options</h3>
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="checkbox" name="featured" value="1" {{ old('featured') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-primary focus:ring-blue-primary">
                            <span class="ml-2 text-sm">Make this job featured (+$5) - Get more applications</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="urgent" value="1" {{ old('urgent') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-primary focus:ring-blue-primary">
                            <span class="ml-2 text-sm">Mark as urgent (+$3) - Highlight to workers</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="background" value="1" {{ old('background') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-primary focus:ring-blue-primary">
                            <span class="ml-2 text-sm">Require background check - Filter for verified workers only</span>
                        </label>
                    </div>
                </div>

                <div class="bg-blue-light rounded-lg p-4 mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-semibold text-blue-dark">Posting Fee</h4>
                            <p class="text-sm text-blue-dark">Basic job posting</p>
                        </div>
                        <div class="text-2xl font-bold text-blue-dark">$2.99</div>
                    </div>
                </div>

                <div class="flex justify-between">
                    <button type="button" onclick="prevStep()" class="border border-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-50 transition duration-300">
                        Previous
                    </button>
                    <button type="submit" class="bg-blue-primary text-white px-8 py-2 rounded-lg hover:bg-blue-dark transition duration-300">
                        Post Job Now
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        let currentStep = 1;
        const totalSteps = 3;

        function updateStepUI() {
            // Update progress indicators
            for (let i = 1; i <= totalSteps; i++) {
                const stepElement = document.querySelector(`.flex:nth-child(${i * 2 - 1}) .w-8`);
                const stepLabel = document.querySelector(`.flex:nth-child(${i * 2 - 1}) span`);
                
                if (i <= currentStep) {
                    stepElement.className = 'flex items-center justify-center w-8 h-8 bg-blue-primary text-white rounded-full text-sm font-semibold';
                    stepLabel.className = 'ml-2 text-sm font-medium text-blue-primary';
                } else {
                    stepElement.className = 'flex items-center justify-center w-8 h-8 bg-gray-300 text-gray-600 rounded-full text-sm font-semibold';
                    stepLabel.className = 'ml-2 text-sm font-medium text-gray-600';
                }
            }

            // Show/hide steps
            document.querySelectorAll('.step').forEach(step => step.classList.add('hidden'));
            document.getElementById(`step${currentStep}`).classList.remove('hidden');
        }

        function nextStep() {
            if (currentStep < totalSteps) {
                if (validateCurrentStep()) {
                    currentStep++;
                    updateStepUI();
                    if (currentStep === 3) {
                        updateReview();
                    }
                }
            }
        }

        function prevStep() {
            if (currentStep > 1) {
                currentStep--;
                updateStepUI();
            }
        }

        function validateCurrentStep() {
            const step = document.getElementById(`step${currentStep}`);
            const requiredFields = step.querySelectorAll('[required]');
            
            for (let field of requiredFields) {
                if (!field.value.trim()) {
                    field.focus();
                    alert('Please fill in all required fields.');
                    return false;
                }
            }
            return true;
        }

        function updateReview() {
            document.getElementById('reviewTitle').textContent = document.getElementById('jobTitle').value;
            document.getElementById('reviewCategory').textContent = document.getElementById('category').options[document.getElementById('category').selectedIndex].text;
            document.getElementById('reviewType').textContent = document.getElementById('jobType').options[document.getElementById('jobType').selectedIndex].text;
            document.getElementById('reviewLocation').textContent = document.getElementById('location').value;
            document.getElementById('reviewDescription').textContent = document.getElementById('description').value;
            
            const paymentType = document.querySelector('input[name="paymentType"]:checked').value;
            const budget = document.getElementById('budget').value;
            let paymentText = '';
            
            if (paymentType === 'hourly') {
                paymentText = `$${budget}/hour`;
            } else if (paymentType === 'fixed') {
                paymentText = `$${budget} (fixed)`;
            } else {
                paymentText = 'Negotiable';
            }
            
            document.getElementById('reviewPayment').textContent = paymentText;
            document.getElementById('reviewDuration').textContent = document.getElementById('duration').options[document.getElementById('duration').selectedIndex].text || 'Not specified';
            document.getElementById('reviewStartDate').textContent = document.getElementById('startDate').value;
            document.getElementById('reviewUrgency').textContent = document.getElementById('urgency').options[document.getElementById('urgency').selectedIndex].text;
        }

        // Payment type change handler
        document.querySelectorAll('input[name="paymentType"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const suffix = document.getElementById('budgetSuffix');
                if (this.value === 'hourly') {
                    suffix.textContent = '/hour';
                } else if (this.value === 'fixed') {
                    suffix.textContent = 'total';
                } else {
                    suffix.textContent = '';
                }
            });
        });

        // Form submission - Let Laravel handle it, just validate on client side
        document.getElementById('jobPostForm').addEventListener('submit', function(e) {
            // Client-side validation is already handled by HTML5 required attributes
            // Laravel will handle server-side validation
        });

        // Set minimum date to today
        document.getElementById('startDate').min = new Date().toISOString().split('T')[0];
    </script>

    <!-- Job Skills Selection Modal -->
    <div id="jobSkillsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white p-8 rounded-xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-semibold text-gray-900">Select Required Skills</h3>
                <button onclick="closeJobSkillsModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Available Skills -->
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-lg font-semibold text-gray-800">Available Skills</h4>
                        <button onclick="openCreateJobSkillModal()" class="text-green-600 hover:text-green-700 text-sm font-medium">
                            <i class="fas fa-plus mr-1"></i>Create New Skill
                        </button>
                    </div>
                    <div class="mb-4">
                        <input type="text" id="jobSkillSearchInput" placeholder="Search skills..." 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-primary focus:border-blue-primary"
                               onkeyup="filterJobSkills()">
                    </div>
                    <div class="space-y-3 max-h-96 overflow-y-auto" id="availableJobSkillsList">
                        <!-- Skills will be loaded here -->
                    </div>
                </div>
                
                <!-- Selected Skills -->
                <div>
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Required Skills</h4>
                    <div class="space-y-3 max-h-96 overflow-y-auto" id="selectedJobSkillsList">
                        <!-- Selected skills will be shown here -->
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end space-x-4 mt-8">
                <button onclick="closeJobSkillsModal()" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                    Cancel
                </button>
                <button onclick="saveJobSkills()" class="px-6 py-2 bg-blue-primary text-white rounded-lg hover:bg-blue-dark transition">
                    Save Skills
                </button>
            </div>
        </div>
    </div>

    <!-- Create New Skill Modal for Job Posting -->
    <div id="createJobSkillModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white p-8 rounded-xl max-w-md w-full mx-4">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-900">Create New Skill</h3>
                <button onclick="closeCreateJobSkillModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <form id="createJobSkillForm" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Skill Name *</label>
                    <input type="text" id="newJobSkillName" placeholder="e.g., Welding, Social Media Management" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-primary focus:border-blue-primary"
                           required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                    <select id="newJobSkillCategory" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-primary focus:border-blue-primary" required>
                        <option value="">Select a category</option>
                        <option value="Programming">Programming</option>
                        <option value="Design">Design</option>
                        <option value="Marketing">Marketing</option>
                        <option value="Writing">Writing</option>
                        <option value="Administrative">Administrative</option>
                        <option value="Mobile">Mobile Development</option>
                        <option value="Creative">Creative</option>
                        <option value="Education">Education</option>
                        <option value="Research">Research</option>
                        <option value="Construction">Construction</option>
                        <option value="Healthcare">Healthcare</option>
                        <option value="Transportation">Transportation</option>
                        <option value="Hospitality">Hospitality</option>
                        <option value="Agriculture">Agriculture</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description (Optional)</label>
                    <textarea id="newJobSkillDescription" rows="3" placeholder="Brief description of this skill..." 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-primary focus:border-blue-primary"></textarea>
                </div>
            </form>
            
            <div class="flex justify-end space-x-4 mt-6">
                <button onclick="closeCreateJobSkillModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                    Cancel
                </button>
                <button onclick="createNewJobSkill()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    <i class="fas fa-plus mr-2"></i>Create Skill
                </button>
            </div>
        </div>
    </div>

    <script>
        // Job Skills Management
        let availableJobSkills = [];
        let selectedJobSkills = [];

        // Load available skills when page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadAvailableJobSkills();
        });

        function loadAvailableJobSkills() {
            fetch('/api/skills')
                .then(response => response.json())
                .then(data => {
                    availableJobSkills = data;
                })
                .catch(error => console.error('Error loading skills:', error));
        }

        function openJobSkillsModal() {
            renderAvailableJobSkills();
            renderSelectedJobSkills();
            document.getElementById('jobSkillsModal').classList.remove('hidden');
            document.getElementById('jobSkillsModal').classList.add('flex');
        }

        function closeJobSkillsModal() {
            document.getElementById('jobSkillsModal').classList.add('hidden');
            document.getElementById('jobSkillsModal').classList.remove('flex');
        }

        function renderAvailableJobSkills() {
            const container = document.getElementById('availableJobSkillsList');
            const searchTerm = document.getElementById('jobSkillSearchInput')?.value.toLowerCase() || '';
            
            const filteredSkills = availableJobSkills.filter(skill => 
                skill.name.toLowerCase().includes(searchTerm) ||
                skill.category.toLowerCase().includes(searchTerm)
            );

            const skillsHtml = filteredSkills.map(skill => {
                const isSelected = selectedJobSkills.some(js => js.skill_id === skill.id);
                return `
                    <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg ${isSelected ? 'bg-gray-100 opacity-50' : 'hover:bg-gray-50'}">
                        <div>
                            <h5 class="font-medium text-gray-900">${skill.name}</h5>
                            <p class="text-sm text-gray-500">${skill.category}</p>
                        </div>
                        <button onclick="addJobSkill(${skill.id})" 
                                class="px-3 py-1 text-sm bg-blue-primary text-white rounded hover:bg-blue-dark transition ${isSelected ? 'hidden' : ''}">
                            Add
                        </button>
                    </div>
                `;
            }).join('');

            container.innerHTML = skillsHtml;
        }

        function addJobSkill(skillId) {
            const skill = availableJobSkills.find(s => s.id === skillId);
            if (skill && !selectedJobSkills.some(js => js.skill_id === skillId)) {
                selectedJobSkills.push({
                    skill_id: skillId,
                    skill: skill,
                    required_level: 'Beginner',
                    is_required: true
                });
                renderAvailableJobSkills();
                renderSelectedJobSkills();
            }
        }

        function renderSelectedJobSkills() {
            const container = document.getElementById('selectedJobSkillsList');
            
            if (selectedJobSkills.length === 0) {
                container.innerHTML = '<p class="text-gray-500 text-center py-4">No skills selected</p>';
                return;
            }

            const skillsHtml = selectedJobSkills.map((jobSkill, index) => `
                <div class="p-3 border border-gray-200 rounded-lg bg-blue-50">
                    <div class="flex items-center justify-between mb-2">
                        <h5 class="font-medium text-gray-900">${jobSkill.skill.name}</h5>
                        <button onclick="removeJobSkill(${index})" class="text-red-500 hover:text-red-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="space-y-2">
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Required Level</label>
                            <select onchange="updateJobSkillLevel(${index}, this.value)" 
                                    class="w-full px-2 py-1 text-sm border border-gray-300 rounded">
                                <option value="Beginner" ${jobSkill.required_level === 'Beginner' ? 'selected' : ''}>Beginner</option>
                                <option value="Intermediate" ${jobSkill.required_level === 'Intermediate' ? 'selected' : ''}>Intermediate</option>
                                <option value="Advanced" ${jobSkill.required_level === 'Advanced' ? 'selected' : ''}>Advanced</option>
                                <option value="Expert" ${jobSkill.required_level === 'Expert' ? 'selected' : ''}>Expert</option>
                            </select>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" ${jobSkill.is_required ? 'checked' : ''} 
                                   onchange="updateJobSkillRequired(${index}, this.checked)"
                                   class="h-4 w-4 text-blue-primary border-gray-300 rounded focus:ring-blue-primary">
                            <label class="ml-2 text-xs text-gray-600">Required (not just preferred)</label>
                        </div>
                    </div>
                </div>
            `).join('');

            container.innerHTML = skillsHtml;
        }

        function removeJobSkill(index) {
            selectedJobSkills.splice(index, 1);
            renderAvailableJobSkills();
            renderSelectedJobSkills();
        }

        function updateJobSkillLevel(index, level) {
            selectedJobSkills[index].required_level = level;
        }

        function updateJobSkillRequired(index, isRequired) {
            selectedJobSkills[index].is_required = isRequired;
        }

        function filterJobSkills() {
            renderAvailableJobSkills();
        }

        function saveJobSkills() {
            // Update the display in the main form
            updateJobSkillsDisplay();
            
            // Update hidden input
            document.getElementById('jobSkillsInput').value = JSON.stringify(selectedJobSkills);
            
            closeJobSkillsModal();
        }

        function updateJobSkillsDisplay() {
            const container = document.getElementById('selectedJobSkills');
            const noSkillsDiv = document.getElementById('noSkillsSelected');
            
            if (selectedJobSkills.length === 0) {
                container.innerHTML = '';
                noSkillsDiv.style.display = 'block';
                return;
            }
            
            noSkillsDiv.style.display = 'none';
            
            const skillsHtml = selectedJobSkills.map(jobSkill => `
                <div class="flex items-center justify-between p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <div>
                        <span class="font-medium text-gray-900">${jobSkill.skill.name}</span>
                        <span class="ml-2 px-2 py-1 text-xs rounded-full ${jobSkill.is_required ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800'}">
                            ${jobSkill.is_required ? 'Required' : 'Preferred'}
                        </span>
                        <span class="ml-2 px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded-full">
                            ${jobSkill.required_level}
                        </span>
                    </div>
                    <button type="button" onclick="removeSkillFromDisplay(${jobSkill.skill_id})" class="text-red-500 hover:text-red-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `).join('');
            
            container.innerHTML = skillsHtml;
        }

        function removeSkillFromDisplay(skillId) {
            selectedJobSkills = selectedJobSkills.filter(js => js.skill_id !== skillId);
            updateJobSkillsDisplay();
            document.getElementById('jobSkillsInput').value = JSON.stringify(selectedJobSkills);
        }

        // Create New Skill Functions for Job Posting
        function openCreateJobSkillModal() {
            document.getElementById('createJobSkillModal').classList.remove('hidden');
            document.getElementById('createJobSkillModal').classList.add('flex');
        }

        function closeCreateJobSkillModal() {
            document.getElementById('createJobSkillModal').classList.add('hidden');
            document.getElementById('createJobSkillModal').classList.remove('flex');
            // Clear form
            document.getElementById('newJobSkillName').value = '';
            document.getElementById('newJobSkillCategory').value = '';
            document.getElementById('newJobSkillDescription').value = '';
        }

        function createNewJobSkill() {
            const name = document.getElementById('newJobSkillName').value.trim();
            const category = document.getElementById('newJobSkillCategory').value;
            const description = document.getElementById('newJobSkillDescription').value.trim();

            if (!name || !category) {
                alert('Please fill in skill name and category');
                return;
            }

            fetch('/api/skills', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    name: name,
                    category: category,
                    description: description
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Skill "' + data.skill.name + '" created successfully!');
                    
                    // Add the new skill to available skills
                    availableJobSkills.push(data.skill);
                    
                    // Refresh the skills list
                    renderAvailableJobSkills();
                    
                    // Close modal
                    closeCreateJobSkillModal();
                } else {
                    alert('Error creating skill: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error creating skill:', error);
                alert('Error creating skill');
            });
        }
    </script>

</body>
</html>

