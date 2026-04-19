<!-- Applications Management Interface -->
<div class="bg-white rounded-lg shadow-md p-6">
    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-6 space-y-4 lg:space-y-0">
        <div>
            <h3 class="text-xl font-semibold text-gray-800">Job Applications</h3>
            <p class="text-gray-600 mt-1">Review and manage applications for your job postings</p>
        </div>
        <div class="flex items-center space-x-4">
            <div class="text-sm text-gray-500">
                Total Applications: <span class="font-semibold text-gray-800">{{ $stats['total_applications'] ?? 0 }}</span>
            </div>
            <!-- View Toggle -->
            <div class="flex bg-gray-100 rounded-lg p-1">
                <button id="listViewBtn" class="px-3 py-1 text-sm font-medium rounded-md bg-white text-gray-900 shadow-sm" onclick="switchToListView()">
                    <i class="fas fa-list mr-1"></i>List View
                </button>
                <button id="pipelineViewBtn" class="px-3 py-1 text-sm font-medium rounded-md text-gray-500 hover:text-gray-900" onclick="switchToPipelineView()">
                    <i class="fas fa-columns mr-1"></i>Pipeline View
                </button>
            </div>
        </div>
    </div>

    <!-- Application Statistics -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 p-4 rounded-xl hover:shadow-md transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-600 text-xs font-medium uppercase tracking-wide">Total Applications</p>
                    <p class="text-2xl font-bold text-blue-900 mt-1">{{ $stats['total_applications'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-inbox text-white text-sm"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-amber-50 to-amber-100 border border-amber-200 p-4 rounded-xl hover:shadow-md transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-amber-600 text-xs font-medium uppercase tracking-wide">Pending Review</p>
                    <p class="text-2xl font-bold text-amber-900 mt-1">{{ $recentApplications->where('status', 'pending')->count() ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-clock text-white text-sm"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 p-4 rounded-xl hover:shadow-md transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-600 text-xs font-medium uppercase tracking-wide">Approved</p>
                    <p class="text-2xl font-bold text-green-900 mt-1">{{ $recentApplications->where('status', 'approved')->count() ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-check-circle text-white text-sm"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-red-50 to-red-100 border border-red-200 p-4 rounded-xl hover:shadow-md transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-600 text-xs font-medium uppercase tracking-wide">Rejected</p>
                    <p class="text-2xl font-bold text-red-900 mt-1">{{ $recentApplications->where('status', 'rejected')->count() ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-times-circle text-white text-sm"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter and Search -->
    <div class="bg-white p-4 rounded-lg shadow-md mb-6" id="filtersSection">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
            <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                <div class="relative">
                    <input type="text" id="applicationSearch" placeholder="Search applications..." 
                           class="pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </div>
                <select id="applicationStatusFilter" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
                <select id="applicationJobFilter" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">All Jobs</option>
                    @if(isset($jobs) && $jobs->count() > 0)
                        @foreach($jobs as $job)
                            <option value="{{ $job->id }}">{{ $job->title }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition" onclick="refreshApplications()">
                <i class="fas fa-sync-alt mr-2"></i>
                Refresh
            </button>
        </div>
    </div>

    <!-- List View (Default) -->
    <div id="listView" class="space-y-4">
        @if(isset($recentApplications) && $recentApplications->count() > 0)
            @foreach($recentApplications as $application)
                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200 hover:shadow-lg transition-shadow duration-200 candidate-card" 
                     data-candidate-id="{{ $application->user->id }}" 
                     data-application-id="{{ $application->id }}"
                     data-stage="{{ $application->stage ?? 'applied' }}">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between space-y-4 lg:space-y-0">
                        <div class="flex items-start space-x-4 flex-1">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold text-lg">{{ substr($application->user->name, 0, 1) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center space-x-3 mb-2">
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $application->user->name }}</h3>
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'approved' => 'bg-green-100 text-green-800',
                                            'rejected' => 'bg-red-100 text-red-800'
                                        ];
                                        $status = $application->status ?? 'pending';
                                        $statusColor = $statusColors[$status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </div>
                                <p class="text-gray-600 mb-2">{{ $application->user->email }}</p>
                                <div class="flex flex-wrap items-center space-x-4 text-sm text-gray-500 mb-3">
                                    <span><i class="fas fa-briefcase mr-1"></i>{{ $application->job->title }}</span>
                                    <span><i class="fas fa-calendar mr-1"></i>Applied {{ $application->created_at->format('M d, Y') }}</span>
                                    @if($application->user->phone)
                                        <span><i class="fas fa-phone mr-1"></i>{{ $application->user->phone }}</span>
                                    @endif
                                </div>
                                @if($application->cover_letter)
                                    <div class="bg-gray-50 p-3 rounded-lg">
                                        <h4 class="text-sm font-medium text-gray-700 mb-1">Cover Letter:</h4>
                                        <p class="text-gray-600 text-sm">{{ Str::limit($application->cover_letter, 150) }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button class="bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 transition" 
                                    onclick="viewApplicationDetails({{ $application->id }})" title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>
                            @if($status === 'pending')
                                <button class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition" 
                                        onclick="approveApplication({{ $application->id }})" title="Approve">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition" 
                                        onclick="rejectApplication({{ $application->id }})" title="Reject">
                                    <i class="fas fa-times"></i>
                                </button>
                            @endif
                            <button class="bg-purple-500 text-white p-2 rounded-lg hover:bg-purple-600 transition" 
                                    onclick="contactApplicant({{ $application->user->id }})" title="Contact">
                                <i class="fas fa-envelope"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="bg-white p-12 rounded-lg shadow-md text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-inbox text-2xl text-gray-400"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">No Applications Yet</h3>
                <p class="text-gray-600 mb-6">You haven't received any job applications yet. Once workers start applying to your jobs, they'll appear here.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#job-posts" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition inline-flex items-center">
                        <i class="fas fa-briefcase mr-2"></i>
                        View My Jobs
                    </a>
                    <a href="{{ route('postjob') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition inline-flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        Post New Job
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Pipeline View (Kanban Board) -->
    <div id="pipelineView" class="hidden">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Applications Column -->
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-semibold text-gray-800 flex items-center">
                        <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                        Applications
                    </h4>
                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full" id="appliedCount">0</span>
                </div>
                <div class="space-y-3 min-h-96" id="appliedColumn" data-stage="applied">
                    <!-- Candidate cards will be populated here -->
                </div>
            </div>

            <!-- Screening Column -->
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-semibold text-gray-800 flex items-center">
                        <div class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></div>
                        Screening
                    </h4>
                    <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full" id="screeningCount">0</span>
                </div>
                <div class="space-y-3 min-h-96" id="screeningColumn" data-stage="screening">
                    <!-- Candidate cards will be populated here -->
                </div>
            </div>

            <!-- Interview Column -->
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-semibold text-gray-800 flex items-center">
                        <div class="w-3 h-3 bg-purple-500 rounded-full mr-2"></div>
                        Interview
                    </h4>
                    <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full" id="interviewCount">0</span>
                </div>
                <div class="space-y-3 min-h-96" id="interviewColumn" data-stage="interview">
                    <!-- Candidate cards will be populated here -->
                </div>
            </div>

            <!-- Hired Column -->
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-semibold text-gray-800 flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                        Hired
                    </h4>
                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full" id="hiredCount">0</span>
                </div>
                <div class="space-y-3 min-h-96" id="hiredColumn" data-stage="hired">
                    <!-- Candidate cards will be populated here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Application Management Functions
function refreshApplications() {
    console.log('🔄 Refreshing applications list');
    location.reload();
}

function viewApplicationDetails(applicationId) {
    console.log('👁️ Viewing application details:', applicationId);
    // You can implement a modal or redirect to detailed view
    alert('Viewing application details #' + applicationId + '\n\nThis will show detailed application information.');
}

function approveApplication(applicationId) {
    if (confirm('Are you sure you want to approve this application?')) {
        console.log('✅ Approving application:', applicationId);
        // Make AJAX request to approve application
        fetch(`/employer/applications/${applicationId}/approve`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Application approved successfully!');
                location.reload();
            } else {
                alert('Error approving application: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error approving application. Please try again.');
        });
    }
}

function rejectApplication(applicationId) {
    if (confirm('Are you sure you want to reject this application?')) {
        console.log('❌ Rejecting application:', applicationId);
        // Make AJAX request to reject application
        fetch(`/employer/applications/${applicationId}/reject`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Application rejected successfully!');
                location.reload();
            } else {
                alert('Error rejecting application: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error rejecting application. Please try again.');
        });
    }
}

function contactApplicant(userId) {
    console.log('📧 Contacting applicant:', userId);
    // Redirect to messages with this user
    window.location.href = `/messages?user=${userId}`;
}

// Search and Filter Functionality
const applicationSearch = document.getElementById('applicationSearch');
const applicationStatusFilter = document.getElementById('applicationStatusFilter');
const applicationJobFilter = document.getElementById('applicationJobFilter');

if (applicationSearch) {
    applicationSearch.addEventListener('input', function() {
        filterApplications();
    });
}

if (applicationStatusFilter) {
    applicationStatusFilter.addEventListener('change', function() {
        filterApplications();
    });
}

if (applicationJobFilter) {
    applicationJobFilter.addEventListener('change', function() {
        filterApplications();
    });
}

function filterApplications() {
    const searchTerm = applicationSearch ? applicationSearch.value.toLowerCase() : '';
    const statusValue = applicationStatusFilter ? applicationStatusFilter.value.toLowerCase() : '';
    const jobValue = applicationJobFilter ? applicationJobFilter.value : '';
    
    const applicationCards = document.querySelectorAll('#applicationsList > div');
    
    applicationCards.forEach(card => {
        const applicantName = card.querySelector('h3')?.textContent.toLowerCase() || '';
        const applicantEmail = card.querySelector('.text-gray-600')?.textContent.toLowerCase() || '';
        const jobTitle = card.querySelector('.fa-briefcase')?.parentElement?.textContent.toLowerCase() || '';
        const statusBadge = card.querySelector('.inline-flex')?.textContent.toLowerCase() || '';
        
        const matchesSearch = applicantName.includes(searchTerm) || 
                             applicantEmail.includes(searchTerm) || 
                             jobTitle.includes(searchTerm);
        const matchesStatus = !statusValue || statusBadge.includes(statusValue);
        const matchesJob = !jobValue || jobTitle.includes(jobValue.toLowerCase());
        
        if (matchesSearch && matchesStatus && matchesJob) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>