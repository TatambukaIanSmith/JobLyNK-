<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Worker Dashboard - JOB-lyNK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .sidebar-active {
            background-color: #374151;
            color: #3b82f6;
            font-weight: 600;
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-100">
    
    <!-- Mobile Menu Button -->
    <button id="mobileMenuBtn" class="lg:hidden fixed top-4 left-4 z-50 bg-gray-800 text-white p-3 rounded-lg shadow-lg">
        <i class="fas fa-bars text-xl"></i>
    </button>

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <div id="sidebar" class="fixed lg:static inset-y-0 left-0 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-40 w-64 bg-gray-800 shadow-xl p-6 flex flex-col justify-between overflow-y-auto">
            <div>
                <!-- Logo -->
                <div class="mb-8">
                    <div class="flex items-center space-x-3 mb-2">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center p-1 shadow-sm">
                            <img src="{{ asset('job-lynk-logo.png') }}" alt="JOB-lyNK Logo" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <a href="{{ route('worker') }}" class="text-xl font-bold text-blue-500 hover:text-blue-400 transition-colors">Worker Hub</a>
                            <p class="text-xs text-gray-400">Your Dashboard</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="space-y-2">
                    <a href="#" class="sidebar-link flex items-center space-x-3 p-3 rounded-xl text-gray-300 hover:bg-gray-700 transition duration-200 sidebar-active" data-content="profile">
                        <i class="fas fa-user h-6 w-6"></i>
                        <span>My Profile</span>
                    </a>
                    <a href="{{ route('jobs') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-300 hover:bg-gray-700 transition duration-200 bg-gradient-to-r from-green-600/20 to-blue-600/20 border border-green-500/30">
                        <i class="fas fa-map-marker-alt h-6 w-6 text-green-400"></i>
                        <span class="font-semibold">Browse Jobs</span>
                        <span class="ml-auto bg-green-500 text-white text-xs px-2 py-0.5 rounded-full">NEW</span>
                    </a>
                    <a href="#" class="sidebar-link flex items-center space-x-3 p-3 rounded-xl text-gray-300 hover:bg-gray-700 transition duration-200" data-content="skills">
                        <i class="fas fa-certificate h-6 w-6"></i>
                        <span>Skills & Certs</span>
                    </a>
                    <a href="#" class="sidebar-link flex items-center space-x-3 p-3 rounded-xl text-gray-300 hover:bg-gray-700 transition duration-200" data-content="applications">
                        <i class="fas fa-clipboard-list h-6 w-6"></i>
                        <span>My Applications</span>
                    </a>
                    <a href="#" class="sidebar-link flex items-center space-x-3 p-3 rounded-xl text-gray-300 hover:bg-gray-700 transition duration-200 relative" data-content="notifications">
                        <i class="fas fa-bell h-6 w-6"></i>
                        <span>Job Matches</span>
                        @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                        <span class="absolute top-2 right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $unreadNotificationsCount }}</span>
                        @endif
                    </a>
                    <a href="#" class="sidebar-link flex items-center space-x-3 p-3 rounded-xl text-gray-300 hover:bg-gray-700 transition duration-200" data-content="messages">
                        <i class="fas fa-envelope h-6 w-6"></i>
                        <span>Messages</span>
                        <span id="messagesBadge" class="hidden absolute top-1 right-1 bg-red-500 text-white text-xs font-bold rounded-full min-w-[20px] h-5 px-1.5 flex items-center justify-center shadow-lg animate-pulse"></span>
                    </a>
                    <a href="#" class="sidebar-link flex items-center space-x-3 p-3 rounded-xl text-gray-300 hover:bg-gray-700 transition duration-200" data-content="saved">
                        <i class="fas fa-bookmark h-6 w-6"></i>
                        <span>Saved Jobs</span>
                    </a>
                </nav>
            </div>
            
            <!-- Bottom Section - Profile & Logout -->
            <div class="space-y-3 mt-auto pt-4 border-t border-gray-700">
                <div class="p-3 bg-gray-750 rounded-xl">
                    <div class="flex items-center">
                        <div class="relative">
                            <div class="h-10 w-10 rounded-full ring-2 ring-blue-400 ring-offset-2 ring-offset-gray-800 overflow-hidden">
                                <img class="h-full w-full object-cover" 
                                     src="{{ Auth::user()->getProfilePictureUrl() }}" 
                                     alt="{{ Auth::user()->name }}">
                            </div>
                            <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-gray-800"></div>
                        </div>
                        <div class="flex-1 text-left ml-3">
                            <div class="text-sm text-gray-300 font-medium truncate">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-500">Worker Profile</div>
                        </div>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('logout') }}" id="logoutForm" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center space-x-3 p-3 rounded-xl text-red-500 bg-gray-700 hover:bg-gray-600 transition duration-200">
                        <i class="fas fa-sign-out-alt h-6 w-6"></i>
                        <span>Log Out</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto w-full lg:w-auto">
            <!-- Top Bar -->
            <div class="sticky top-0 z-40 bg-gray-800/95 backdrop-blur-lg border-b border-gray-700 shadow-lg">
                <div class="px-4 lg:px-8 py-4">
                    <div class="flex items-center justify-between gap-4">
                        <!-- Search Bar -->
                        <div class="flex-1 max-w-xl">
                            <div class="relative">
                                <input 
                                    type="text" 
                                    id="globalSearch"
                                    placeholder="Search jobs, applications, or messages..." 
                                    class="w-full pl-10 pr-4 py-2.5 bg-gray-900 border border-gray-700 text-gray-200 placeholder-gray-500 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                >
                                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                            </div>
                        </div>

                        <!-- Quick Stats -->
                        <div class="hidden lg:flex items-center gap-4 px-4 py-2 bg-gradient-to-r from-blue-900/50 to-purple-900/50 rounded-xl border border-blue-800">
                            <div class="text-center">
                                <div class="text-xs text-gray-400">Applications</div>
                                <div class="text-sm font-bold text-blue-400">{{ $applicationsCount ?? 0 }}</div>
                            </div>
                            <div class="w-px h-8 bg-gray-700"></div>
                            <div class="text-center">
                                <div class="text-xs text-gray-400">Job Matches</div>
                                <div class="text-sm font-bold text-green-400">{{ $jobMatchesCount ?? 0 }}</div>
                            </div>
                        </div>

                        <!-- Profile -->
                        <div class="flex items-center gap-3">
                            <img class="h-10 w-10 rounded-full object-cover ring-2 ring-blue-500" 
                                 src="{{ Auth::user()->getProfilePictureUrl() }}" 
                                 alt="{{ Auth::user()->name }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Container -->
            <div class="p-4 lg:p-8">
                
                <!-- Profile Section -->
                <div id="profile-content" class="content-section">
                    <h2 class="text-2xl font-semibold text-gray-300 mb-6">My Profile</h2>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Profile Card -->
                        <div class="lg:col-span-1 bg-gray-800 rounded-xl p-6 border border-gray-700">
                            <div class="text-center">
                                <img class="h-24 w-24 rounded-full mx-auto object-cover ring-4 ring-blue-500" 
                                     src="{{ Auth::user()->getProfilePictureUrl() }}" 
                                     alt="{{ Auth::user()->name }}">
                                <h3 class="mt-4 text-xl font-semibold text-white">{{ Auth::user()->name }}</h3>
                                <p class="text-gray-400 text-sm">{{ Auth::user()->email }}</p>
                                <p class="text-gray-500 text-xs mt-1">Member since {{ Auth::user()->created_at->format('M Y') }}</p>
                            </div>
                            
                            <div class="mt-6 space-y-3">
                                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition">
                                    <i class="fas fa-edit mr-2"></i>Edit Profile
                                </button>
                                <button class="w-full bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded-lg transition">
                                    <i class="fas fa-key mr-2"></i>Change Password
                                </button>
                            </div>
                        </div>

                        <!-- Stats Cards -->
                        <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-xl p-6 text-white">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm opacity-90">Total Applications</p>
                                        <p class="text-3xl font-bold mt-2">{{ $applicationsCount ?? 0 }}</p>
                                    </div>
                                    <i class="fas fa-clipboard-list text-4xl opacity-50"></i>
                                </div>
                            </div>

                            <div class="bg-gradient-to-br from-green-600 to-green-800 rounded-xl p-6 text-white">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm opacity-90">Job Matches</p>
                                        <p class="text-3xl font-bold mt-2">{{ $jobMatchesCount ?? 0 }}</p>
                                    </div>
                                    <i class="fas fa-bell text-4xl opacity-50"></i>
                                </div>
                            </div>

                            <div class="bg-gradient-to-br from-purple-600 to-purple-800 rounded-xl p-6 text-white">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm opacity-90">Profile Completion</p>
                                        <p class="text-3xl font-bold mt-2">75%</p>
                                    </div>
                                    <i class="fas fa-user-check text-4xl opacity-50"></i>
                                </div>
                            </div>

                            <div class="bg-gradient-to-br from-yellow-600 to-yellow-800 rounded-xl p-6 text-white">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm opacity-90">Saved Jobs</p>
                                        <p class="text-3xl font-bold mt-2">0</p>
                                    </div>
                                    <i class="fas fa-bookmark text-4xl opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="mt-6 bg-gray-800 rounded-xl p-6 border border-gray-700">
                        <h3 class="text-lg font-semibold text-white mb-4">Quick Actions</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <button onclick="showContent('skills')" class="bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg transition">
                                <i class="fas fa-plus-circle mb-2 text-2xl"></i>
                                <p class="text-sm">Add Skills</p>
                            </button>
                            <button onclick="showContent('applications')" class="bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg transition">
                                <i class="fas fa-clipboard-list mb-2 text-2xl"></i>
                                <p class="text-sm">View Applications</p>
                            </button>
                            <button onclick="showContent('notifications')" class="bg-purple-600 hover:bg-purple-700 text-white py-3 px-4 rounded-lg transition">
                                <i class="fas fa-bell mb-2 text-2xl"></i>
                                <p class="text-sm">Job Matches</p>
                            </button>
                            <button onclick="showContent('messages')" class="bg-yellow-600 hover:bg-yellow-700 text-white py-3 px-4 rounded-lg transition">
                                <i class="fas fa-envelope mb-2 text-2xl"></i>
                                <p class="text-sm">Messages</p>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Skills Section -->
                <div id="skills-content" class="content-section hidden">
                    <h2 class="text-2xl font-semibold text-gray-300 mb-6">Skills & Certifications</h2>
                    
                    <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                        <p class="text-gray-400 text-center py-8">
                            <i class="fas fa-tools text-4xl mb-4 text-gray-600"></i>
                            <br>
                            Skills management coming soon...
                        </p>
                    </div>
                </div>

                <!-- Applications Section -->
                <div id="applications-content" class="content-section hidden">
                    <h2 class="text-2xl font-semibold text-gray-300 mb-6">My Applications</h2>
                    
                    <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                        <p class="text-gray-400 text-center py-8">
                            <i class="fas fa-clipboard-list text-4xl mb-4 text-gray-600"></i>
                            <br>
                            No applications yet. Start applying to jobs!
                        </p>
                    </div>
                </div>

                <!-- Notifications Section -->
                <div id="notifications-content" class="content-section hidden">
                    <h2 class="text-2xl font-semibold text-gray-300 mb-6">Job Matches</h2>
                    
                    <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                        <p class="text-gray-400 text-center py-8">
                            <i class="fas fa-bell text-4xl mb-4 text-gray-600"></i>
                            <br>
                            No job matches yet. Add your skills to get matched!
                        </p>
                    </div>
                </div>

                <!-- Messages Section -->
                <div id="messages-content" class="content-section hidden">
                    <h2 class="text-2xl font-semibold text-gray-300 mb-6">Messages</h2>
                    
                    <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                        <p class="text-gray-400 text-center py-8">
                            <i class="fas fa-envelope text-4xl mb-4 text-gray-600"></i>
                            <br>
                            No messages yet.
                        </p>
                    </div>
                </div>

                <!-- Saved Jobs Section -->
                <div id="saved-content" class="content-section hidden">
                    <h2 class="text-2xl font-semibold text-gray-300 mb-6">Saved Jobs</h2>
                    
                    <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                        <p class="text-gray-400 text-center py-8">
                            <i class="fas fa-bookmark text-4xl mb-4 text-gray-600"></i>
                            <br>
                            No saved jobs yet. Browse jobs and save your favorites!
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        // CSRF Token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const sidebar = document.getElementById('sidebar');

        mobileMenuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });

        // Content Switching
        const sidebarLinks = document.querySelectorAll('.sidebar-link');
        const contentSections = document.querySelectorAll('.content-section');

        function showContent(contentId) {
            // Hide all sections
            contentSections.forEach(section => {
                section.classList.add('hidden');
            });
            
            // Show selected section
            const targetContent = document.getElementById(contentId + '-content');
            if (targetContent) {
                targetContent.classList.remove('hidden');
            }
        }

        function updateSidebar(activeLink) {
            sidebarLinks.forEach(link => {
                link.classList.remove('sidebar-active');
            });
            activeLink.classList.add('sidebar-active');
        }

        // Add click handlers to sidebar links
        sidebarLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const contentId = link.getAttribute('data-content');
                if (contentId) {
                    showContent(contentId);
                    updateSidebar(link);
                    
                    // Close mobile menu
                    if (window.innerWidth < 1024) {
                        sidebar.classList.add('-translate-x-full');
                    }
                }
            });
        });

        // Initialize - show profile by default
        showContent('profile');
    </script>

</body>
</html>
