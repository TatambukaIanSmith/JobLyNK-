<!-- Job Posts Management Interface -->
<div class="bg-white rounded-lg shadow-md p-6">
    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-6 space-y-4 lg:space-y-0">
        <div>
            <h3 class="text-xl font-semibold text-gray-800">My Job Posts</h3>
            <p class="text-gray-600 mt-1">Manage and track all your job postings</p>
        </div>
        <div class="flex items-center space-x-4">
            <div class="text-sm text-gray-500">
                Total Jobs: <span class="font-semibold text-gray-800">{{ $totalJobPosts ?? 0 }}</span>
            </div>
            <a href="{{ route('postjob') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-2"></i>Post New Job
            </a>
        </div>
    </div>

    <!-- Filter and Search -->
    <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 mb-6">
        <div class="relative flex-1">
            <input type="text" id="jobSearch" placeholder="Search job posts..." 
                   class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
        </div>
        <select id="jobStatusFilter" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <option value="">All Status</option>
            <option value="active">Active</option>
            <option value="draft">Draft</option>
            <option value="paused">Paused</option>
            <option value="completed">Completed</option>
            <option value="expired">Expired</option>
        </select>
        <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition" onclick="refreshJobPosts()">
            <i class="fas fa-sync-alt mr-2"></i>Refresh
        </button>
    </div>

    <!-- Job Posts List -->
    <div class="space-y-4">
        @if(isset($jobPosts) && $jobPosts->count() > 0)
            @foreach($jobPosts as $job)
                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow job-post-card">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between space-y-4 lg:space-y-0">
                        <!-- Job Info -->
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-2">
                                <h4 class="text-lg font-semibold text-gray-900">{{ $job->title }}</h4>
                                <span class="px-3 py-1 text-xs font-medium rounded-full
                                    @if($job->status === 'active') bg-green-100 text-green-800
                                    @elseif($job->status === 'draft') bg-gray-100 text-gray-800
                                    @elseif($job->status === 'paused') bg-yellow-100 text-yellow-800
                                    @elseif($job->status === 'completed') bg-blue-100 text-blue-800
                                    @elseif($job->status === 'expired') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($job->status ?? 'draft') }}
                                </span>
                                @if($job->is_featured)
                                    <span class="px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded-full">
                                        <i class="fas fa-star mr-1"></i>Featured
                                    </span>
                                @endif
                                @if($job->is_urgent)
                                    <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">
                                        <i class="fas fa-exclamation mr-1"></i>Urgent
                                    </span>
                                @endif
                            </div>
                            
                            <div class="text-sm text-gray-600 space-y-1 mb-3">
                                <p><i class="fas fa-map-marker-alt w-4"></i> {{ $job->location ?? 'Location not specified' }}</p>
                                <p><i class="fas fa-briefcase w-4"></i> {{ ucfirst($job->job_type ?? 'Not specified') }}</p>
                                <p><i class="fas fa-money-bill-wave w-4"></i> UGX {{ number_format($job->budget ?? 0) }} ({{ ucfirst($job->payment_type ?? 'negotiable') }})</p>
                                <p><i class="fas fa-calendar w-4"></i> Posted: {{ $job->created_at->format('M d, Y \a\t g:i A') }}</p>
                                @if($job->category)
                                    <p><i class="fas fa-tag w-4"></i> {{ $job->category->name }}</p>
                                @endif
                            </div>

                            <!-- Job Description Preview -->
                            <p class="text-gray-700 text-sm line-clamp-2 mb-3">
                                {{ Str::limit($job->description ?? 'No description provided', 150) }}
                            </p>

                            <!-- Job Stats -->
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                <span><i class="fas fa-eye mr-1"></i>{{ $job->views ?? 0 }} views</span>
                                <span><i class="fas fa-users mr-1"></i>{{ $job->applications_count ?? 0 }} applications</span>
                                @if($job->start_date)
                                    <span><i class="fas fa-play mr-1"></i>Starts: {{ \Carbon\Carbon::parse($job->start_date)->format('M d, Y') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col space-y-2 lg:ml-6">
                            <div class="flex space-x-2">
                                <button onclick="viewJobDetails({{ $job->id }})" class="bg-blue-600 text-white px-3 py-2 rounded text-sm hover:bg-blue-700 transition">
                                    <i class="fas fa-eye mr-1"></i>View
                                </button>
                                <button onclick="editJob({{ $job->id }})" class="bg-green-600 text-white px-3 py-2 rounded text-sm hover:bg-green-700 transition">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </button>
                                @if($job->status === 'active')
                                    <button onclick="pauseJob({{ $job->id }})" class="bg-yellow-600 text-white px-3 py-2 rounded text-sm hover:bg-yellow-700 transition">
                                        <i class="fas fa-pause mr-1"></i>Pause
                                    </button>
                                @elseif($job->status === 'paused')
                                    <button onclick="activateJob({{ $job->id }})" class="bg-green-600 text-white px-3 py-2 rounded text-sm hover:bg-green-700 transition">
                                        <i class="fas fa-play mr-1"></i>Activate
                                    </button>
                                @endif
                            </div>
                            <div class="flex space-x-2">
                                @if($job->applications_count > 0)
                                    <button onclick="viewApplications({{ $job->id }})" class="bg-purple-600 text-white px-3 py-2 rounded text-sm hover:bg-purple-700 transition">
                                        <i class="fas fa-users mr-1"></i>Applications ({{ $job->applications_count }})
                                    </button>
                                @endif
                                <button onclick="deleteJob({{ $job->id }})" class="bg-red-600 text-white px-3 py-2 rounded text-sm hover:bg-red-700 transition">
                                    <i class="fas fa-trash mr-1"></i>Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-briefcase text-3xl text-gray-400"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">No Job Posts Yet</h3>
                <p class="text-gray-600 mb-6">You haven't posted any jobs yet. Create your first job posting to start finding great workers.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('postjob') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition inline-flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        <span>Post Your First Job</span>
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
// Job Posts Management Functions
function refreshJobPosts() {
    console.log('🔄 Refreshing job posts list');
    location.reload();
}

function viewJobDetails(jobId) {
    console.log('👁️ Viewing job details:', jobId);
    // You can implement a modal or redirect to detailed view
    alert('Viewing job details #' + jobId + '\n\nThis will open the detailed job view.');
}

function editJob(jobId) {
    console.log('✏️ Editing job:', jobId);
    // Redirect to edit job page or open edit modal
    window.location.href = `/employer/jobs/${jobId}/edit`;
}

function pauseJob(jobId) {
    if (confirm('Are you sure you want to pause this job posting?')) {
        console.log('⏸️ Pausing job:', jobId);
        // Make AJAX request to pause job
        fetch(`/employer/jobs/${jobId}/pause`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Job paused successfully!');
                location.reload();
            } else {
                alert('Error pausing job: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error pausing job. Please try again.');
        });
    }
}

function activateJob(jobId) {
    if (confirm('Are you sure you want to activate this job posting?')) {
        console.log('▶️ Activating job:', jobId);
        // Make AJAX request to activate job
        fetch(`/employer/jobs/${jobId}/activate`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Job activated successfully!');
                location.reload();
            } else {
                alert('Error activating job: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error activating job. Please try again.');
        });
    }
}

function viewApplications(jobId) {
    console.log('👥 Viewing applications for job:', jobId);
    // Switch to applications view with filter for this job
    showContent('applications');
    updateSidebar('applications');
    // You could add filtering logic here
}

function deleteJob(jobId) {
    if (confirm('Are you sure you want to delete this job posting? This action cannot be undone.')) {
        console.log('🗑️ Deleting job:', jobId);
        // Make AJAX request to delete job
        fetch(`/employer/jobs/${jobId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Job deleted successfully!');
                location.reload();
            } else {
                alert('Error deleting job: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting job. Please try again.');
        });
    }
}

// Search and Filter Functionality
const jobSearch = document.getElementById('jobSearch');
const jobStatusFilter = document.getElementById('jobStatusFilter');

if (jobSearch) {
    jobSearch.addEventListener('input', function() {
        filterJobPosts();
    });
}

if (jobStatusFilter) {
    jobStatusFilter.addEventListener('change', function() {
        filterJobPosts();
    });
}

function filterJobPosts() {
    const searchTerm = jobSearch ? jobSearch.value.toLowerCase() : '';
    const statusValue = jobStatusFilter ? jobStatusFilter.value.toLowerCase() : '';
    
    const jobCards = document.querySelectorAll('.job-post-card');
    
    jobCards.forEach(card => {
        const jobTitle = card.querySelector('h4')?.textContent.toLowerCase() || '';
        const jobLocation = card.querySelector('.fa-map-marker-alt')?.parentElement?.textContent.toLowerCase() || '';
        const statusBadge = card.querySelector('.inline-flex')?.textContent.toLowerCase() || '';
        
        const matchesSearch = jobTitle.includes(searchTerm) || jobLocation.includes(searchTerm);
        const matchesStatus = !statusValue || statusBadge.includes(statusValue);
        
        if (matchesSearch && matchesStatus) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>