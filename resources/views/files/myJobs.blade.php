<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>My Jobs - JOB-lyNK</title>
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
        body {
            background: #dfe3ed;
            min-height: 100vh;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="bg-blue-primary shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="{{ route('home') }}" class="text-white text-2xl font-bold">JOB-lyNK</a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('employerDashboard') }}" class="text-white hover:text-blue-light">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                        </a>
                        <div class="relative group">
                            <button class="flex items-center text-white hover:text-blue-light">
                                <img class="h-8 w-8 rounded-full" src="{{ Auth::user()->getProfilePictureUrl() }}" alt="Profile">
                                <span class="ml-2">{{ Auth::user()->name }}</span>
                            </button>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">My Job Posts</h1>
            <p class="text-gray-600">Manage and view all your job postings</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Total Jobs</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $jobs->count() }}</p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <i class="fas fa-briefcase text-blue-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Active Jobs</p>
                        <p class="text-3xl font-bold text-green-600">{{ $jobs->where('status', 'active')->count() }}</p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Draft Jobs</p>
                        <p class="text-3xl font-bold text-yellow-600">{{ $jobs->where('status', 'draft')->count() }}</p>
                    </div>
                    <div class="bg-yellow-100 rounded-full p-3">
                        <i class="fas fa-edit text-yellow-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Total Views</p>
                        <p class="text-3xl font-bold text-purple-600">{{ $jobs->sum('views') }}</p>
                    </div>
                    <div class="bg-purple-100 rounded-full p-3">
                        <i class="fas fa-eye text-purple-600 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mb-6 flex justify-between items-center">
            <div class="flex space-x-3">
                <button onclick="filterJobs('all')" class="filter-btn bg-blue-primary text-white px-4 py-2 rounded-lg hover:bg-blue-dark transition">
                    All Jobs
                </button>
                <button onclick="filterJobs('active')" class="filter-btn bg-white text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                    Active
                </button>
                <button onclick="filterJobs('draft')" class="filter-btn bg-white text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                    Draft
                </button>
                <button onclick="filterJobs('filled')" class="filter-btn bg-white text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                    Filled
                </button>
            </div>
            <a href="{{ route('postjob') }}" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg transition shadow-sm">
                <i class="fas fa-plus mr-2"></i>Post New Job
            </a>
        </div>

        <!-- Jobs List -->
        <div class="space-y-4" id="jobs-container">
            @forelse($jobs as $job)
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-6 job-card" data-status="{{ $job->status }}">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            <h3 class="text-xl font-bold text-gray-900">{{ $job->title }}</h3>
                            @if($job->status === 'active')
                                <span class="ml-3 bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full">Active</span>
                            @elseif($job->status === 'draft')
                                <span class="ml-3 bg-yellow-100 text-yellow-800 text-xs px-3 py-1 rounded-full">Draft</span>
                            @elseif($job->status === 'paused')
                                <span class="ml-3 bg-orange-100 text-orange-800 text-xs px-3 py-1 rounded-full">Paused</span>
                            @elseif($job->status === 'filled')
                                <span class="ml-3 bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full">Filled</span>
                            @endif
                            @if($job->is_urgent)
                                <span class="ml-2 bg-red-100 text-red-800 text-xs px-3 py-1 rounded-full">Urgent</span>
                            @endif
                        </div>
                        
                        <div class="flex items-center text-gray-600 text-sm mb-3 space-x-4">
                            <span><i class="fas fa-map-marker-alt mr-1"></i>{{ $job->location }}</span>
                            <span><i class="fas fa-briefcase mr-1"></i>{{ ucfirst($job->job_type) }}</span>
                            <span><i class="fas fa-clock mr-1"></i>Posted {{ $job->created_at->diffForHumans() }}</span>
                        </div>

                        <p class="text-gray-700 mb-4">{{ Str::limit($job->description, 150) }}</p>

                        <div class="flex items-center space-x-6 text-sm">
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-eye mr-2"></i>
                                <span>{{ $job->views }} views</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-file-alt mr-2"></i>
                                <span>{{ $job->applications_count }} applications</span>
                            </div>
                            <div class="flex items-center text-green-600 font-semibold">
                                <i class="fas fa-money-bill-wave mr-2"></i>
                                <span>UGX {{ number_format($job->budget) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="ml-6 flex flex-col space-y-2">
                        <a href="{{ route('jobs.show', $job->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm transition text-center">
                            <i class="fas fa-eye mr-1"></i>View
                        </a>
                        <button onclick="editJob({{ $job->id }})" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm transition">
                            <i class="fas fa-edit mr-1"></i>Edit
                        </button>
                        @if($job->status === 'active')
                        <button onclick="pauseJob({{ $job->id }})" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm transition">
                            <i class="fas fa-pause mr-1"></i>Pause
                        </button>
                        @elseif($job->status === 'paused')
                        <button onclick="activateJob({{ $job->id }})" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm transition">
                            <i class="fas fa-play mr-1"></i>Resume
                        </button>
                        @elseif($job->status === 'draft')
                        <button onclick="publishJob({{ $job->id }})" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm transition">
                            <i class="fas fa-check mr-1"></i>Publish
                        </button>
                        @endif
                        <button onclick="deleteJob({{ $job->id }})" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm transition">
                            <i class="fas fa-trash mr-1"></i>Delete
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <i class="fas fa-briefcase text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No Jobs Posted Yet</h3>
                <p class="text-gray-600 mb-6">Start by posting your first job to find talented workers</p>
                <a href="{{ route('postjob') }}" class="inline-block bg-blue-primary hover:bg-blue-dark text-white px-6 py-3 rounded-lg transition">
                    <i class="fas fa-plus mr-2"></i>Post Your First Job
                </a>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" style="display: none;">
        <div class="bg-white rounded-lg shadow-2xl max-w-md w-full mx-4 transform transition-all">
            <div class="p-6">
                <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full" id="modalIconContainer">
                    <i id="modalIcon" class="text-3xl"></i>
                </div>
                <h3 id="modalTitle" class="text-xl font-bold text-gray-900 text-center mb-2"></h3>
                <p id="modalMessage" class="text-gray-600 text-center mb-6"></p>
                <div class="flex space-x-3">
                    <button onclick="closeConfirmModal()" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition font-medium">
                        Cancel
                    </button>
                    <button id="modalConfirmBtn" class="flex-1 px-4 py-2 rounded-lg text-white transition font-medium">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Job Modal -->
    <div id="editJobModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4" style="display: none;">
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Edit Job</h2>
                    <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>

                <form id="editJobForm" class="space-y-6">
                    <input type="hidden" id="edit_job_id">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Job Title *</label>
                            <input type="text" id="edit_title" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Location *</label>
                            <input type="text" id="edit_location" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Job Type *</label>
                            <select id="edit_job_type" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="one-time">One-time</option>
                                <option value="recurring">Recurring</option>
                                <option value="project">Project</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Payment Type *</label>
                            <select id="edit_payment_type" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="hourly">Hourly</option>
                                <option value="fixed">Fixed</option>
                                <option value="negotiable">Negotiable</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Budget (UGX) *</label>
                            <input type="number" id="edit_budget" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Duration</label>
                            <input type="text" id="edit_duration" placeholder="e.g., 3-5 hours" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Start Date *</label>
                            <input type="date" id="edit_start_date" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Urgency</label>
                            <select id="edit_urgency" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="normal">Normal</option>
                                <option value="urgent">Urgent</option>
                                <option value="asap">ASAP</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Job Description *</label>
                        <textarea id="edit_description" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                    </div>

                    <div class="flex items-center space-x-4">
                        <label class="flex items-center">
                            <input type="checkbox" id="edit_is_urgent" class="mr-2">
                            <span class="text-sm text-gray-700">Mark as Urgent</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" id="edit_is_featured" class="mr-2">
                            <span class="text-sm text-gray-700">Feature this job</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" id="edit_requires_background_check" class="mr-2">
                            <span class="text-sm text-gray-700">Requires background check</span>
                        </label>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4 border-t">
                        <button type="button" onclick="closeEditModal()" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-2 bg-blue-primary text-white rounded-lg hover:bg-blue-dark transition">
                            <i class="fas fa-save mr-2"></i>Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let confirmCallback = null;

        function showConfirmModal(title, message, icon, iconBg, btnColor, btnText, callback) {
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalMessage').textContent = message;
            document.getElementById('modalIcon').className = icon;
            document.getElementById('modalIconContainer').className = `flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full ${iconBg}`;
            
            const confirmBtn = document.getElementById('modalConfirmBtn');
            confirmBtn.className = `flex-1 px-4 py-2 rounded-lg text-white transition font-medium ${btnColor}`;
            confirmBtn.textContent = btnText;
            
            confirmCallback = callback;
            document.getElementById('confirmModal').style.display = 'flex';
        }

        function closeConfirmModal() {
            document.getElementById('confirmModal').style.display = 'none';
            confirmCallback = null;
        }

        document.getElementById('modalConfirmBtn').addEventListener('click', function() {
            if (confirmCallback) {
                confirmCallback();
            }
            closeConfirmModal();
        });

        function filterJobs(status) {
            const cards = document.querySelectorAll('.job-card');
            const buttons = document.querySelectorAll('.filter-btn');
            
            // Update button styles
            buttons.forEach(btn => {
                btn.classList.remove('bg-blue-primary', 'text-white');
                btn.classList.add('bg-white', 'text-gray-700');
            });
            event.target.classList.remove('bg-white', 'text-gray-700');
            event.target.classList.add('bg-blue-primary', 'text-white');
            
            // Filter cards
            cards.forEach(card => {
                if (status === 'all' || card.dataset.status === status) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function editJob(jobId) {
            // Fetch job details
            fetch(`/employer/jobs/${jobId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const job = data.job;
                        
                        // Populate form fields
                        document.getElementById('edit_job_id').value = job.id;
                        document.getElementById('edit_title').value = job.title;
                        document.getElementById('edit_location').value = job.location;
                        document.getElementById('edit_job_type').value = job.job_type;
                        document.getElementById('edit_payment_type').value = job.payment_type;
                        document.getElementById('edit_budget').value = job.budget;
                        document.getElementById('edit_duration').value = job.duration || '';
                        document.getElementById('edit_start_date').value = job.start_date.split('T')[0];
                        document.getElementById('edit_urgency').value = job.urgency;
                        document.getElementById('edit_description').value = job.description;
                        document.getElementById('edit_is_urgent').checked = job.is_urgent;
                        document.getElementById('edit_is_featured').checked = job.is_featured;
                        document.getElementById('edit_requires_background_check').checked = job.requires_background_check;
                        
                        // Show modal
                        document.getElementById('editJobModal').style.display = 'flex';
                    }
                })
                .catch(error => {
                    console.error('Error fetching job:', error);
                    alert('Failed to load job details');
                });
        }

        function closeEditModal() {
            document.getElementById('editJobModal').style.display = 'none';
        }

        // Handle edit form submission
        document.getElementById('editJobForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const jobId = document.getElementById('edit_job_id').value;
            const formData = {
                title: document.getElementById('edit_title').value,
                location: document.getElementById('edit_location').value,
                job_type: document.getElementById('edit_job_type').value,
                payment_type: document.getElementById('edit_payment_type').value,
                budget: document.getElementById('edit_budget').value,
                duration: document.getElementById('edit_duration').value,
                start_date: document.getElementById('edit_start_date').value,
                urgency: document.getElementById('edit_urgency').value,
                description: document.getElementById('edit_description').value,
                is_urgent: document.getElementById('edit_is_urgent').checked,
                is_featured: document.getElementById('edit_is_featured').checked,
                requires_background_check: document.getElementById('edit_requires_background_check').checked
            };

            fetch(`/employer/jobs/${jobId}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeEditModal();
                    location.reload();
                } else {
                    alert('Failed to update job: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error updating job:', error);
                alert('Failed to update job');
            });
        });

        function deleteJob(jobId) {
            showConfirmModal(
                'Delete Job?',
                'This action cannot be undone. All applications for this job will also be deleted.',
                'fas fa-trash text-3xl text-red-500',
                'bg-red-100',
                'bg-red-500 hover:bg-red-600',
                'Delete Job',
                function() {
                    fetch(`/employer/jobs/${jobId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Failed to delete job');
                        }
                    });
                }
            );
        }
        function pauseJob(jobId) {
            showConfirmModal(
                'Pause Job?',
                'This job will be hidden from workers until you resume it. You can resume it anytime.',
                'fas fa-pause text-3xl text-orange-500',
                'bg-orange-100',
                'bg-orange-500 hover:bg-orange-600',
                'Pause Job',
                function() {
                    fetch(`/employer/jobs/${jobId}/pause`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Failed to pause job');
                        }
                    });
                }
            );
        }

        function activateJob(jobId) {
            fetch(`/employer/jobs/${jobId}/activate`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Failed to resume job');
                }
            });
        }

        function publishJob(jobId) {
            fetch(`/employer/jobs/${jobId}/publish`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Failed to publish job');
                }
            });
        }
    </script>
</body>
</html>
