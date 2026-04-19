<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>My Job Posts - JOB-lyNK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .job-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .job-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        .status-badge {
            position: relative;
            overflow: hidden;
        }
        
        .status-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }
        
        .status-badge:hover::before {
            left: 100%;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-6">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('employerDashboard') }}" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-arrow-left text-xl"></i>
                        </a>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">My Job Posts</h1>
                            <p class="text-gray-600">Manage and track all your job postings</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('postjob') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition inline-flex items-center">
                            <i class="fas fa-plus mr-2"></i>
                            Post New Job
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 rounded-lg shadow-md text-white transform hover:scale-105 transition-transform duration-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-briefcase text-3xl opacity-80"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-blue-100 text-sm">Total Jobs</p>
                            <p class="text-3xl font-bold" id="total-jobs">0</p>
                            <p class="text-blue-100 text-xs" id="jobs-this-month">0 this month</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 rounded-lg shadow-md text-white transform hover:scale-105 transition-transform duration-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-3xl opacity-80"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-green-100 text-sm">Active Jobs</p>
                            <p class="text-3xl font-bold" id="active-jobs">0</p>
                            <p class="text-green-100 text-xs" id="draft-jobs">0 drafts</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 p-6 rounded-lg shadow-md text-white transform hover:scale-105 transition-transform duration-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-eye text-3xl opacity-80"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-yellow-100 text-sm">Total Views</p>
                            <p class="text-3xl font-bold" id="total-views">0</p>
                            <p class="text-yellow-100 text-xs" id="avg-views">Avg 0 per job</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-6 rounded-lg shadow-md text-white transform hover:scale-105 transition-transform duration-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-users text-3xl opacity-80"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-purple-100 text-sm">Applications</p>
                            <p class="text-3xl font-bold" id="total-applications">0</p>
                            <p class="text-purple-100 text-xs" id="application-rate">0% rate</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-pink-500 to-pink-600 p-6 rounded-lg shadow-md text-white transform hover:scale-105 transition-transform duration-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-heart text-3xl opacity-80"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-pink-100 text-sm">Engagement</p>
                            <p class="text-3xl font-bold" id="total-engagement">0</p>
                            <p class="text-pink-100 text-xs" id="engagement-breakdown">0 saves, 0 likes</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters and Search -->
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                    <div class="flex space-x-3">
                        <button id="refresh-btn" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                            <i class="fas fa-sync-alt mr-2"></i>
                            Refresh
                        </button>
                    </div>
                    <div class="flex space-x-2">
                        <input type="text" id="job-search" placeholder="Search jobs..." 
                               class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <select id="status-filter" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="draft">Draft</option>
                            <option value="paused">Paused</option>
                            <option value="expired">Expired</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Jobs List -->
            <div id="jobs-container">
                <div id="loading" class="text-center py-12">
                    <i class="fas fa-spinner fa-spin text-3xl text-gray-400 mb-4"></i>
                    <p class="text-gray-600">Loading your job posts...</p>
                </div>
                
                <div id="jobs-list" class="space-y-4 hidden"></div>
                
                <div id="empty-state" class="bg-white p-12 rounded-lg shadow-md text-center hidden">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-briefcase text-2xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">No Job Posts Yet</h3>
                    <p class="text-gray-600 mb-6">Start by creating your first job posting to attract talented workers.</p>
                    <a href="{{ route('postjob') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition inline-flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        Create Your First Job
                    </a>
                </div>
            </div>

            <!-- Pagination -->
            <div id="pagination" class="mt-8 flex justify-center hidden"></div>
        </div>
    </div>

    <script>
        let currentPage = 1;
        let currentSearch = '';
        let currentStatus = '';

        // Load jobs on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadJobs();
            
            // Set up event listeners
            document.getElementById('refresh-btn').addEventListener('click', loadJobs);
            document.getElementById('job-search').addEventListener('input', debounce(handleSearch, 300));
            document.getElementById('status-filter').addEventListener('change', handleFilter);
        });

        function loadJobs(page = 1) {
            showLoading();
            
            const params = new URLSearchParams({
                page: page,
                search: currentSearch,
                status: currentStatus
            });

            fetch(`/employer/jobs?${params}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayJobs(data.jobs);
                    updateStatistics(data.jobs);
                } else {
                    showError('Failed to load jobs');
                }
            })
            .catch(error => {
                console.error('Error loading jobs:', error);
                showError('Failed to load jobs');
            });
        }

        function displayJobs(jobsData) {
            const jobsList = document.getElementById('jobs-list');
            const emptyState = document.getElementById('empty-state');
            const loading = document.getElementById('loading');
            
            loading.classList.add('hidden');
            
            if (jobsData.data.length === 0) {
                jobsList.classList.add('hidden');
                emptyState.classList.remove('hidden');
                return;
            }
            
            emptyState.classList.add('hidden');
            jobsList.classList.remove('hidden');
            
            jobsList.innerHTML = jobsData.data.map(job => createJobCard(job)).join('');
            
            // Update pagination
            updatePagination(jobsData);
        }

        function createJobCard(job) {
            const statusColors = {
                'active': 'bg-green-100 text-green-800',
                'draft': 'bg-gray-100 text-gray-800',
                'paused': 'bg-yellow-100 text-yellow-800',
                'expired': 'bg-red-100 text-red-800'
            };
            
            const statusColor = statusColors[job.status] || 'bg-gray-100 text-gray-800';
            
            return `
                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200 job-card">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between space-y-4 lg:space-y-0">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-2">
                                <h3 class="text-xl font-semibold text-gray-800">${job.title}</h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium status-badge ${statusColor}">
                                    ${job.status.charAt(0).toUpperCase() + job.status.slice(1)}
                                </span>
                            </div>
                            <p class="text-gray-600 mb-3">${job.description.substring(0, 120)}${job.description.length > 120 ? '...' : ''}</p>
                            <div class="flex flex-wrap items-center space-x-4 text-sm text-gray-500">
                                <span><i class="fas fa-map-marker-alt mr-1"></i>${job.location}</span>
                                <span><i class="fas fa-dollar-sign mr-1"></i>UGX ${Number(job.budget).toLocaleString()}</span>
                                <span><i class="fas fa-calendar mr-1"></i>${new Date(job.created_at).toLocaleDateString()}</span>
                                <span><i class="fas fa-eye mr-1"></i>${job.views || 0} views</span>
                                <span><i class="fas fa-users mr-1"></i>${job.applications_count || 0} applications</span>
                                <span><i class="fas fa-tag mr-1"></i>${job.category ? job.category.name : 'No Category'}</span>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button class="bg-indigo-500 text-white p-2 rounded-lg hover:bg-indigo-600 transition" 
                                    onclick="showJobDetails(${job.id})" title="View Details & Analytics">
                                <i class="fas fa-chart-bar"></i>
                            </button>
                            <button class="bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 transition" 
                                    onclick="viewJobLive(${job.id})" title="View Live">
                                <i class="fas fa-external-link-alt"></i>
                            </button>
                            <button class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition" 
                                    onclick="editJob(${job.id})" title="Edit Job">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="bg-purple-500 text-white p-2 rounded-lg hover:bg-purple-600 transition" 
                                    onclick="duplicateJob(${job.id})" title="Duplicate Job">
                                <i class="fas fa-copy"></i>
                            </button>
                            ${job.status === 'active' ? 
                                `<button class="bg-yellow-500 text-white p-2 rounded-lg hover:bg-yellow-600 transition" 
                                        onclick="pauseJob(${job.id})" title="Pause Job">
                                    <i class="fas fa-pause"></i>
                                </button>` : 
                                job.status === 'draft' ?
                                `<button class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 transition" 
                                        onclick="publishJob(${job.id})" title="Publish Job">
                                    <i class="fas fa-play"></i>
                                </button>` : ''
                            }
                            <button class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition" 
                                    onclick="deleteJob(${job.id})" title="Delete Job">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }

        function updateStatistics(jobsData) {
            const jobs = jobsData.data;
            const totalJobs = jobs.length;
            const activeJobs = jobs.filter(job => job.status === 'active').length;
            const draftJobs = jobs.filter(job => job.status === 'draft').length;
            const totalViews = jobs.reduce((sum, job) => sum + (job.views || 0), 0);
            const totalApplications = jobs.reduce((sum, job) => sum + (job.applications_count || 0), 0);
            
            document.getElementById('total-jobs').textContent = totalJobs;
            document.getElementById('active-jobs').textContent = activeJobs;
            document.getElementById('draft-jobs').textContent = draftJobs + ' drafts';
            document.getElementById('total-views').textContent = totalViews;
            document.getElementById('avg-views').textContent = `Avg ${totalJobs > 0 ? Math.round(totalViews / totalJobs) : 0} per job`;
            document.getElementById('total-applications').textContent = totalApplications;
            document.getElementById('application-rate').textContent = `${totalViews > 0 ? Math.round((totalApplications / totalViews) * 100) : 0}% rate`;
            document.getElementById('total-engagement').textContent = totalApplications;
            document.getElementById('engagement-breakdown').textContent = `${totalApplications} applications`;
        }

        function updatePagination(jobsData) {
            const pagination = document.getElementById('pagination');
            
            if (jobsData.last_page <= 1) {
                pagination.classList.add('hidden');
                return;
            }
            
            pagination.classList.remove('hidden');
            
            let paginationHTML = '';
            
            // Previous button
            if (jobsData.current_page > 1) {
                paginationHTML += `<button onclick="loadJobs(${jobsData.current_page - 1})" class="px-3 py-2 mx-1 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Previous</button>`;
            }
            
            // Page numbers
            for (let i = 1; i <= jobsData.last_page; i++) {
                const isActive = i === jobsData.current_page;
                paginationHTML += `<button onclick="loadJobs(${i})" class="px-3 py-2 mx-1 ${isActive ? 'bg-blue-600 text-white' : 'bg-white border border-gray-300 hover:bg-gray-50'} rounded-lg">${i}</button>`;
            }
            
            // Next button
            if (jobsData.current_page < jobsData.last_page) {
                paginationHTML += `<button onclick="loadJobs(${jobsData.current_page + 1})" class="px-3 py-2 mx-1 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Next</button>`;
            }
            
            pagination.innerHTML = paginationHTML;
        }

        function handleSearch(event) {
            currentSearch = event.target.value;
            currentPage = 1;
            loadJobs();
        }

        function handleFilter(event) {
            currentStatus = event.target.value;
            currentPage = 1;
            loadJobs();
        }

        function showLoading() {
            document.getElementById('loading').classList.remove('hidden');
            document.getElementById('jobs-list').classList.add('hidden');
            document.getElementById('empty-state').classList.add('hidden');
        }

        function showError(message) {
            document.getElementById('loading').classList.add('hidden');
            alert(message);
        }

        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Job management functions
        window.viewJobLive = function(jobId) {
            window.open(`/jobs/${jobId}`, '_blank');
        };

        window.editJob = function(jobId) {
            // Redirect to edit page or show modal
            alert('Edit functionality - redirect to edit page for job ' + jobId);
        };

        window.duplicateJob = function(jobId) {
            if (confirm('Are you sure you want to duplicate this job?')) {
                fetch(`/employer/jobs/${jobId}/duplicate`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Job duplicated successfully!');
                        loadJobs();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error duplicating job');
                });
            }
        };

        window.publishJob = function(jobId) {
            if (confirm('Are you sure you want to publish this job?')) {
                fetch(`/employer/jobs/${jobId}/publish`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Job published successfully!');
                        loadJobs();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error publishing job');
                });
            }
        };

        window.pauseJob = function(jobId) {
            if (confirm('Are you sure you want to pause this job?')) {
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
                        loadJobs();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error pausing job');
                });
            }
        };

        window.deleteJob = function(jobId) {
            if (confirm('Are you sure you want to delete this job? This action cannot be undone.')) {
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
                        loadJobs();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting job');
                });
            }
        };

        window.showJobDetails = function(jobId) {
            alert('Job details functionality - show detailed analytics for job ' + jobId);
        };
    </script>
</body>
</html>