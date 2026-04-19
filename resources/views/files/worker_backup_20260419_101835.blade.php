<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Worker Dashboard - JOB-lyNK</title>
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
        .soft-shadow {
            box-shadow: inset 2px 2px 5px rgba(0, 0, 0, 0.4),
                        inset -2px -2px 5px rgba(60, 60, 60, 0.1); 
        }
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.75);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 50;
            overflow-y: auto;
            padding: 1rem;
        }
        
        /* Ensure content doesn't overflow */
        * {
            box-sizing: border-box;
        }
        
        /* Responsive images */
        img {
            max-width: 100%;
            height: auto;
        }
        
        /* Mobile sidebar overlay */
        @media (max-width: 1023px) {
            #sidebar {
                box-shadow: 2px 0 10px rgba(0, 0, 0, 0.5);
            }
        }
        
        /* Top Bar Dropdown Animations */
        #workerNotificationsDropdown,
        #workerQuickActionsDropdown,
        #workerTopBarProfileDropdown,
        #themeMenuDropdown {
            animation: slideDown 0.2s ease-out;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Dark Mode Styles */
        .dark {
            color-scheme: dark;
        }
        
        .dark body {
            background: linear-gradient(135deg, #0f172a 0%, #020617 100%);
            color: #e5e7eb;
        }
        
        .dark .bg-gray-900 {
            background-color: #020617 !important;
        }
        
        .dark .bg-gray-800 {
            background-color: #0f172a !important;
        }
        
        .dark .bg-gray-700 {
            background-color: #1e293b !important;
        }
        
        .dark .text-white {
            color: #f9fafb !important;
        }
        
        .dark .text-gray-100 {
            color: #f3f4f6 !important;
        }
        
        .dark .text-gray-300 {
            color: #d1d5db !important;
        }
        
        .dark .text-gray-400 {
            color: #9ca3af !important;
        }
        
        .dark .border-gray-700 {
            border-color: #374151 !important;
        }
        
        .dark .border-gray-600 {
            border-color: #4b5563 !important;
        }
        
        /* Theme dropdown */
        .dark #themeMenuDropdown {
            background-color: #1f2937 !important;
            border-color: #374151 !important;
        }
        
        .dark .theme-option:hover {
            background-color: #374151 !important;
        }
        
        /* Top Bar Dark Mode */
        .dark .sticky.top-0 {
            background-color: rgba(17, 24, 39, 0.95) !important;
            backdrop-filter: blur(12px);
            border-bottom-color: #374151 !important;
        }
        
        .dark #workerNotificationsDropdown,
        .dark #workerQuickActionsDropdown,
        .dark #workerTopBarProfileDropdown {
            background-color: #1f2937 !important;
            border-color: #374151 !important;
        }
        
        .dark #workerGlobalSearch {
            background-color: #020617 !important;
            border-color: #374151 !important;
            color: #e5e7eb !important;
        }
        
        .dark #workerGlobalSearch::placeholder {
            color: #6b7280 !important;
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
                <nav class="space-y-2">
                    <a href="#" class="sidebar-link flex items-center space-x-3 p-3 rounded-xl text-gray-300 hover:bg-gray-700 transition duration-200 sidebar-active" data-content="profile" onclick="return false;">
                        <i class="fas fa-user h-6 w-6"></i>
                        <span>My Profile</span>
                    </a>
                    <a href="{{ route('jobs') }}" class="flex items-center space-x-3 p-3 rounded-xl text-gray-300 hover:bg-gray-700 transition duration-200 bg-gradient-to-r from-green-600/20 to-blue-600/20 border border-green-500/30">
                        <i class="fas fa-map-marker-alt h-6 w-6 text-green-400"></i>
                        <span class="font-semibold">Nearby Jobs</span>
                        <span class="ml-auto bg-green-500 text-white text-xs px-2 py-0.5 rounded-full">NEW</span>
                    </a>
                    <a href="#" class="sidebar-link flex items-center space-x-3 p-3 rounded-xl text-gray-300 hover:bg-gray-700 transition duration-200" data-content="skills" onclick="return false;">
                        <i class="fas fa-certificate h-6 w-6"></i>
                        <span>Skills & Certs</span>
                    </a>
                    <a href="#" class="sidebar-link flex items-center space-x-3 p-3 rounded-xl text-gray-300 hover:bg-gray-700 transition duration-200" data-content="applications" onclick="return false;">
                        <i class="fas fa-clipboard-list h-6 w-6"></i>
                        <span>My Applications</span>
                    </a>
                    <a href="#" class="sidebar-link flex items-center space-x-3 p-3 rounded-xl text-gray-300 hover:bg-gray-700 transition duration-200 relative" data-content="notifications" onclick="return false;">
                        <i class="fas fa-bell h-6 w-6"></i>
                        <span>Job Matches</span>
                        @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                        <span class="absolute top-2 right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $unreadNotificationsCount }}</span>
                        @endif
                    </a>
                    <a href="#" class="sidebar-link flex items-center space-x-3 p-3 rounded-xl text-gray-300 hover:bg-gray-700 transition duration-200" data-content="workplace" onclick="return false;">
                        <i class="fas fa-briefcase h-6 w-6"></i>
                        <span>Workplace</span>
                    </a>
                    <a href="#" class="sidebar-link flex items-center space-x-3 p-3 rounded-xl text-gray-300 hover:bg-gray-700 transition duration-200 relative" data-content="messages" onclick="return false;">
                        <i class="fas fa-envelope h-6 w-6"></i>
                        <span>Messages</span>
                        <span id="messagesBadge" class="hidden absolute top-1 right-1 bg-red-500 text-white text-xs font-bold rounded-full min-w-[20px] h-5 px-1.5 flex items-center justify-center shadow-lg animate-pulse"></span>
                    </a>
                    <a href="#" class="sidebar-link flex items-center space-x-3 p-3 rounded-xl text-gray-300 hover:bg-gray-700 transition duration-200" data-content="saved" onclick="return false;">
                        <i class="fas fa-bookmark h-6 w-6"></i>
                        <span>Saved Jobs</span>
                    </a>
                </nav>
            </div>
            
            <!-- Bottom Section - Worker Profile Dropdown -->
            <div class="space-y-3 mt-auto pt-4 border-t border-gray-700 relative">
                <button onclick="toggleWorkerProfileDropdown()" class="w-full p-3 bg-gray-750 rounded-xl hover:bg-gray-700 transition-all duration-200 group">
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
                        <i class="fas fa-chevron-up text-gray-400 text-xs group-hover:text-white transition"></i>
                    </div>
                </button>
                
                <!-- Worker Profile Dropdown Menu -->
                <div id="workerProfileDropdown" class="hidden absolute bottom-full left-0 right-0 mb-2 bg-gray-800 rounded-lg shadow-2xl border border-gray-700 overflow-hidden z-50 max-h-[80vh] overflow-y-auto">
                    <!-- Profile Header -->
                    <div class="p-4 bg-gradient-to-br from-blue-600 to-indigo-600 text-white">
                        <div class="flex items-center mb-3">
                            <img class="h-12 w-12 rounded-full object-cover ring-2 ring-white/30" 
                                 src="{{ Auth::user()->getProfilePictureUrl() }}" 
                                 alt="{{ Auth::user()->name }}">
                            <div class="flex-1 ml-3">
                                <div class="font-semibold">{{ Auth::user()->name }}</div>
                                <div class="text-xs opacity-90">{{ Auth::user()->email }}</div>
                            </div>
                        </div>
                        <div class="flex items-center text-xs">
                            <i class="fas fa-briefcase mr-2"></i>
                            Member since {{ Auth::user()->created_at->format('M Y') }}
                        </div>
                    </div>
                    
                    <!-- Menu Items -->
                    <div class="p-2">
                        <div class="px-3 py-2 text-xs text-gray-500 uppercase tracking-wider">Personal Info</div>
                        
                        <a href="#" onclick="openWorkerProfileEdit(); return false;" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition">
                            <i class="fas fa-user-edit w-5 text-blue-400"></i>
                            <span class="text-sm">Edit Profile</span>
                        </a>
                        
                        <a href="#" onclick="openWorkerPasswordChange(); return false;" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition">
                            <i class="fas fa-key w-5 text-green-400"></i>
                            <span class="text-sm">Change Password</span>
                        </a>
                        
                        <div class="border-t border-gray-700 my-2"></div>
                        
                        <div class="px-3 py-2 text-xs text-gray-500 uppercase tracking-wider">Professional Info</div>
                        
                        <a href="#" onclick="openSkillsManager(); return false;" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition">
                            <i class="fas fa-tools w-5 text-purple-400"></i>
                            <span class="text-sm">Manage Skills</span>
                        </a>
                        
                        <a href="#" onclick="openAvailabilitySettings(); return false;" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition">
                            <i class="fas fa-calendar-check w-5 text-yellow-400"></i>
                            <span class="text-sm">Availability Status</span>
                        </a>
                        
                        <a href="#" onclick="openWorkHistory(); return false;" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition">
                            <i class="fas fa-history w-5 text-indigo-400"></i>
                            <span class="text-sm">Work History</span>
                        </a>
                        
                        <a href="#" onclick="openRatingsReviews(); return false;" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition">
                            <i class="fas fa-star w-5 text-yellow-500"></i>
                            <span class="text-sm">Ratings & Reviews</span>
                        </a>
                        
                        <div class="border-t border-gray-700 my-2"></div>
                        
                        <div class="px-3 py-2 text-xs text-gray-500 uppercase tracking-wider">Account</div>
                        
                        <a href="#" onclick="openAccountSettings(); return false;" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition">
                            <i class="fas fa-cog w-5 text-gray-400"></i>
                            <span class="text-sm">Account Settings</span>
                        </a>
                        
                        <a href="#" onclick="openDeleteAccount(); return false;" class="flex items-center space-x-3 p-3 rounded-lg text-red-400 hover:bg-red-900/20 transition">
                            <i class="fas fa-trash-alt w-5"></i>
                            <span class="text-sm">Delete Account</span>
                        </a>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('logout') }}" id="logoutForm" class="w-full">
                    @csrf
                    <button type="submit" onclick="return showLogoutModal(event)" class="w-full flex items-center space-x-3 p-3 rounded-xl text-red-500 bg-gray-700 hover:bg-gray-600 transition duration-200">
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
                        <!-- Left Section: Search Bar -->
                        <div class="flex-1 max-w-xl">
                            <div class="relative">
                                <input 
                                    type="text" 
                                    id="workerGlobalSearch"
                                    placeholder="Search jobs, applications, or messages..." 
                                    class="w-full pl-10 pr-4 py-2.5 bg-gray-900 border border-gray-700 text-gray-200 placeholder-gray-500 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                >
                                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                            </div>
                        </div>

                        <!-- Right Section: Actions & Profile -->
                        <div class="flex items-center gap-3">
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

                            <!-- Notifications -->
                            <div class="relative">
                                <button 
                                    onclick="toggleWorkerNotifications()"
                                    class="relative p-2.5 bg-gray-900 hover:bg-gray-700 rounded-xl transition-all group"
                                >
                                    <i class="fas fa-bell text-gray-400 group-hover:text-blue-400 transition-colors"></i>
                                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold animate-pulse">
                                        {{ $unreadNotificationsCount ?? 0 }}
                                    </span>
                                </button>
                                
                                <!-- Notifications Dropdown -->
                                <div id="workerNotificationsDropdown" class="hidden absolute top-full right-0 mt-2 w-80 bg-gray-800 rounded-xl shadow-2xl border border-gray-700 overflow-hidden z-50">
                                    <div class="p-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white">
                                        <div class="flex items-center justify-between">
                                            <h3 class="font-semibold">Notifications</h3>
                                            <span class="text-xs bg-white/20 px-2 py-1 rounded-full">{{ $unreadNotificationsCount ?? 0 }} new</span>
                                        </div>
                                    </div>
                                    <div class="max-h-96 overflow-y-auto">
                                        <div class="p-3 hover:bg-gray-700 border-b border-gray-700 cursor-pointer transition">
                                            <div class="flex items-start gap-3">
                                                <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                                                <div class="flex-1">
                                                    <p class="text-sm font-medium text-gray-200">New job match found</p>
                                                    <p class="text-xs text-gray-400 mt-1">Senior Developer position matches your skills</p>
                                                    <p class="text-xs text-gray-500 mt-1">10 minutes ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-3 bg-gray-900 text-center">
                                        <a href="#" class="text-sm text-blue-400 hover:text-blue-300 font-medium">View all notifications</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="relative">
                                <button 
                                    onclick="toggleWorkerQuickActions()"
                                    class="p-2.5 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 rounded-xl transition-all group shadow-lg"
                                >
                                    <i class="fas fa-bolt text-white"></i>
                                </button>
                                
                                <!-- Quick Actions Dropdown -->
                                <div id="workerQuickActionsDropdown" class="hidden absolute top-full right-0 mt-2 w-64 bg-gray-800 rounded-xl shadow-2xl border border-gray-700 overflow-hidden z-50">
                                    <div class="p-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white">
                                        <h3 class="font-semibold text-sm">Quick Actions</h3>
                                    </div>
                                    <div class="p-2">
                                        <button onclick="showContent('notifications'); toggleWorkerQuickActions();" class="w-full text-left px-3 py-2 hover:bg-gray-700 rounded-lg transition flex items-center gap-3">
                                            <i class="fas fa-briefcase text-blue-400 w-5"></i>
                                            <span class="text-sm text-gray-200">Browse Jobs</span>
                                        </button>
                                        <button onclick="showContent('applications'); toggleWorkerQuickActions();" class="w-full text-left px-3 py-2 hover:bg-gray-700 rounded-lg transition flex items-center gap-3">
                                            <i class="fas fa-file-alt text-green-400 w-5"></i>
                                            <span class="text-sm text-gray-200">My Applications</span>
                                        </button>
                                        <button onclick="showContent('skills'); toggleWorkerQuickActions();" class="w-full text-left px-3 py-2 hover:bg-gray-700 rounded-lg transition flex items-center gap-3">
                                            <i class="fas fa-certificate text-purple-400 w-5"></i>
                                            <span class="text-sm text-gray-200">Update Skills</span>
                                        </button>
                                        <button onclick="showContent('messages'); toggleWorkerQuickActions();" class="w-full text-left px-3 py-2 hover:bg-gray-700 rounded-lg transition flex items-center gap-3">
                                            <i class="fas fa-comments text-yellow-400 w-5"></i>
                                            <span class="text-sm text-gray-200">Messages</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Theme Switcher (moved from header) -->
                            <div class="relative">
                                <button 
                                    onclick="toggleThemeMenu()"
                                    class="p-2.5 bg-gray-900 hover:bg-gray-700 rounded-xl transition-all group"
                                    title="Change Theme"
                                >
                                    <i id="theme-icon" class="fas fa-sun text-gray-400 group-hover:text-yellow-500 transition-colors"></i>
                                </button>
                                
                                <!-- Theme Menu Dropdown -->
                                <div id="themeMenuDropdown" class="hidden absolute top-full right-0 mt-2 w-56 bg-gray-800 rounded-xl shadow-2xl border border-gray-700 overflow-hidden z-50">
                                    <div class="p-3 bg-gradient-to-r from-gray-700 to-gray-900 text-white">
                                        <h3 class="font-semibold text-sm flex items-center">
                                            <i class="fas fa-palette mr-2"></i>
                                            Theme Settings
                                        </h3>
                                    </div>
                                    <div class="p-2">
                                        <button onclick="setTheme('light')" class="theme-option w-full text-left px-3 py-3 hover:bg-gray-700 rounded-lg transition flex items-center gap-3 group">
                                            <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-orange-400 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                                <i class="fas fa-sun text-white"></i>
                                            </div>
                                            <div class="flex-1">
                                                <div class="text-sm font-medium text-gray-200">Light Mode</div>
                                                <div class="text-xs text-gray-400">Bright and clear</div>
                                            </div>
                                            <i class="fas fa-check text-blue-400 hidden light-check"></i>
                                        </button>
                                        <button onclick="setTheme('dark')" class="theme-option w-full text-left px-3 py-3 hover:bg-gray-700 rounded-lg transition flex items-center gap-3 group">
                                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-700 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                                <i class="fas fa-moon text-white"></i>
                                            </div>
                                            <div class="flex-1">
                                                <div class="text-sm font-medium text-gray-200">Dark Mode</div>
                                                <div class="text-xs text-gray-400">Easy on the eyes</div>
                                            </div>
                                            <i class="fas fa-check text-blue-400 hidden dark-check"></i>
                                        </button>
                                        <button onclick="setTheme('system')" class="theme-option w-full text-left px-3 py-3 hover:bg-gray-700 rounded-lg transition flex items-center gap-3 group">
                                            <div class="w-10 h-10 bg-gradient-to-br from-gray-500 to-gray-700 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                                <i class="fas fa-desktop text-white"></i>
                                            </div>
                                            <div class="flex-1">
                                                <div class="text-sm font-medium text-gray-200">System Default</div>
                                                <div class="text-xs text-gray-400">Match your OS</div>
                                            </div>
                                            <i class="fas fa-check text-blue-400 hidden system-check"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Worker Profile -->
                            <div class="relative">
                                <button 
                                    onclick="toggleWorkerTopBarProfile()"
                                    class="flex items-center gap-3 pl-3 pr-4 py-2 bg-gradient-to-r from-gray-900 to-gray-800 hover:from-gray-800 hover:to-gray-700 rounded-xl transition-all border border-gray-700 group"
                                >
                                    <div class="relative">
                                        <img class="w-9 h-9 rounded-lg object-cover ring-2 ring-blue-400" 
                                             src="{{ Auth::user()->getProfilePictureUrl() }}" 
                                             alt="{{ Auth::user()->name }}">
                                        <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 rounded-full border-2 border-gray-800"></div>
                                    </div>
                                    <div class="hidden lg:block text-left">
                                        <div class="text-sm font-semibold text-gray-200">{{ Auth::user()->name }}</div>
                                        <div class="text-xs text-gray-500">Worker</div>
                                    </div>
                                    <i class="fas fa-chevron-down text-gray-500 text-xs group-hover:text-gray-400 transition"></i>
                                </button>
                                
                                <!-- Profile Dropdown -->
                                <div id="workerTopBarProfileDropdown" class="hidden absolute top-full right-0 mt-2 w-64 bg-gray-800 rounded-xl shadow-2xl border border-gray-700 overflow-hidden z-50">
                                    <div class="p-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white">
                                        <div class="flex items-center gap-3">
                                            <img class="w-12 h-12 rounded-lg object-cover ring-2 ring-white/30" 
                                                 src="{{ Auth::user()->getProfilePictureUrl() }}" 
                                                 alt="{{ Auth::user()->name }}">
                                            <div>
                                                <div class="font-semibold">{{ Auth::user()->name }}</div>
                                                <div class="text-xs text-blue-100">{{ Auth::user()->email }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-2">
                                        <a href="#" onclick="showContent('profile'); toggleWorkerTopBarProfile(); return false;" class="flex items-center gap-3 px-3 py-2 hover:bg-gray-700 rounded-lg transition">
                                            <i class="fas fa-user text-gray-400 w-5"></i>
                                            <span class="text-sm text-gray-200">My Profile</span>
                                        </a>
                                        <a href="#" onclick="showContent('skills'); toggleWorkerTopBarProfile(); return false;" class="flex items-center gap-3 px-3 py-2 hover:bg-gray-700 rounded-lg transition">
                                            <i class="fas fa-certificate text-gray-400 w-5"></i>
                                            <span class="text-sm text-gray-200">Skills & Certs</span>
                                        </a>
                                        <div class="border-t border-gray-700 my-2"></div>
                                        <form method="POST" action="{{ route('logout') }}" id="logoutForm" class="m-0">
                                            @csrf
                                            <button type="submit" onclick="return showLogoutModal(event)" class="w-full flex items-center gap-3 px-3 py-2 hover:bg-red-900/50 rounded-lg transition text-left">
                                                <i class="fas fa-sign-out-alt text-red-400 w-5"></i>
                                                <span class="text-sm text-red-400 font-medium">Logout</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="p-4 lg:p-10 max-w-7xl mx-auto">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between mb-8 gap-4 pt-4">
                    <div>
                        <h1 class="text-2xl lg:text-4xl font-extrabold text-white mb-2">Hello, {{ Auth::user()->name }}!</h1>
                        <p class="text-base lg:text-lg text-gray-400">Manage your career and track your progress.</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-left lg:text-right">
                            <div class="text-sm text-gray-400">Member since</div>
                            <div class="text-lg font-semibold text-white">{{ Auth::user()->created_at->format('M Y') }}</div>
                        </div>
                    </div>
                </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-900 border border-green-700 text-green-100 rounded-lg">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 bg-red-900 border border-red-700 text-red-100 rounded-lg">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            <div id="jobseeker-content-container">

                <div id="profile-content" class="content-section">
                    <h2 class="text-2xl font-semibold text-gray-300 mb-6">Profile Summary & Recommended Jobs</h2>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        
                        <div class="lg:col-span-1 space-y-8">
                            <div class="bg-gray-800 p-8 rounded-xl soft-shadow">
                                <div class="flex flex-col items-center">
                                    <div class="relative">
                                        <img class="h-28 w-28 rounded-full mb-4 object-cover border-4 border-blue-500" 
                                             src="{{ Auth::user()->getProfilePictureUrl() }}" 
                                             alt="Profile Picture"
                                             id="profileImage">
                                        <button onclick="document.getElementById('profilePictureInput').click()" 
                                                class="absolute bottom-2 right-2 bg-blue-600 text-white px-3 py-2 rounded-lg hover:bg-blue-700 transition shadow-lg">
                                            <i class="fas fa-camera text-sm"></i>
                                        </button>
                                        <input type="file" id="profilePictureInput" accept="image/*" class="hidden" onchange="uploadProfilePicture(this)">
                                    </div>
                                    <h3 class="text-2xl font-bold text-white">{{ Auth::user()->name }}</h3>
                                    <p class="text-md text-gray-400">{{ Auth::user()->bio ?? 'Professional Worker' }}</p>
                                    <span class="mt-2 px-4 py-1 text-sm font-semibold rounded-full bg-green-900 text-green-400 border border-green-700">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Verified Worker
                                    </span>
                                </div>
                                <div class="mt-6 border-t border-gray-700 pt-4">
                                    <p class="text-sm text-gray-400 mb-1">
                                        <strong class="text-gray-200">Email:</strong> {{ Auth::user()->email }}
                                    </p>
                                    @if(Auth::user()->phone)
                                        <p class="text-sm text-gray-400 mb-1">
                                            <strong class="text-gray-200">Phone:</strong> {{ Auth::user()->phone }}
                                        </p>
                                    @endif
                                    @if(Auth::user()->location)
                                        <p class="text-sm text-gray-400 mb-1">
                                            <strong class="text-gray-200">Location:</strong> {{ Auth::user()->location }}
                                        </p>
                                    @endif
                                    <button onclick="openModal('edit-details-modal')" class="w-full mt-4 bg-blue-600 text-white py-3 rounded-xl hover:bg-blue-700 transition font-semibold shadow-md">
                                        <i class="fas fa-edit mr-2"></i>
                                        Edit Personal Details
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="lg:col-span-2 space-y-8">
                            <div class="bg-gray-800 p-6 rounded-xl soft-shadow">
                                <h3 class="text-xl font-semibold text-gray-200 mb-4">
                                    <i class="fas fa-star text-yellow-500 mr-2"></i>
                                    Top Recommended Jobs
                                </h3>
                                <div class="space-y-4">
                                    <div class="border-b border-gray-700 pb-4">
                                        <p class="font-medium text-white">Construction Helper - Kampala</p>
                                        <p class="text-sm text-gray-400">ABC Construction Ltd - Industrial Area</p>
                                        <p class="text-md text-green-500 font-bold">UGX 50,000 / day</p>
                                        <a href="{{ route('jobs') }}" class="text-blue-500 text-sm hover:text-blue-400 font-medium">
                                            View & Apply <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                    <div class="border-b border-gray-700 pb-4">
                                        <p class="font-medium text-white">Security Guard - Night Shift</p>
                                        <p class="text-sm text-gray-400">SecureUg Ltd - Ntinda</p>
                                        <p class="text-md text-green-500 font-bold">UGX 45,000 / night</p>
                                        <a href="{{ route('jobs') }}" class="text-blue-500 text-sm hover:text-blue-400 font-medium">
                                            View & Apply <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="mt-4 text-center">
                                    <a href="{{ route('jobs') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                                        <i class="fas fa-search mr-2"></i>
                                        Browse All Jobs
                                    </a>
                                </div>
                            </div>

                            <div class="bg-gray-800 p-6 rounded-xl soft-shadow">
                                <h3 class="text-xl font-semibold text-gray-200 mb-4">
                                    <i class="fas fa-clock text-blue-500 mr-2"></i>
                                    Recent Activity
                                </h3>
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between p-3 bg-blue-900 rounded-lg border border-blue-700">
                                        <div>
                                            <p class="font-medium text-gray-200">Welcome to JOB-lyNK!</p>
                                            <p class="text-sm text-gray-400">Account created: {{ Auth::user()->created_at->format('M d, Y') }}</p>
                                        </div>
                                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-700 text-green-100">
                                            <i class="fas fa-check mr-1"></i>
                                            Complete
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="skills-content" class="content-section hidden">
                    <h2 class="text-2xl font-semibold text-gray-300 mb-6">Manage Skills and Professional Documents</h2>
                    
                    <div class="bg-gray-800 p-8 rounded-xl soft-shadow mb-8">
                        <h3 class="text-xl font-semibold text-gray-200 mb-4">Your Key Skills</h3>
                        <div class="flex flex-wrap gap-3 mb-4" id="skillsContainer">
                            @foreach(Auth::user()->getSkillsArray() as $skill)
                                <span class="px-3 py-1 text-sm bg-blue-900 text-blue-300 rounded-full flex items-center border border-blue-700 shadow-sm skill-tag">
                                    {{ $skill }}
                                    <button onclick="removeSkill('{{ $skill }}')" class="ml-2 text-red-400 hover:text-red-300 font-bold text-xs">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </span>
                            @endforeach
                        </div>
                        
                        <!-- Skill Selection Dropdown -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-300 mb-2">Select Skills from List</label>
                            <select id="skillSelect" class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                                <option value="">-- Choose a skill --</option>
                            </select>
                            <button onclick="addSelectedSkill()" class="mt-2 bg-green-600 text-white py-2 px-5 rounded-xl hover:bg-green-700 transition shadow-md font-medium">
                                <i class="fas fa-plus mr-2"></i>Add Selected Skill
                            </button>
                        </div>
                        
                        <!-- Or type custom skill -->
                        <div class="border-t border-gray-700 pt-4 mt-4">
                            <label class="block text-sm font-medium text-gray-300 mb-2">Or Add Custom Skill</label>
                            <div class="flex gap-2">
                                <input type="text" id="newSkillInput" placeholder="Type custom skill (e.g., Mason, Driver, Plumber)" 
                                       class="flex-1 px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-xl focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400"
                                       onkeypress="handleSkillKeyPress(event)">
                                <button onclick="addSkill()" class="bg-blue-600 text-white py-2 px-5 rounded-xl hover:bg-blue-700 transition shadow-md font-medium">
                                    <i class="fas fa-plus mr-2"></i>Add Custom
                                </button>
                            </div>
                        </div>
                        <div id="skillMessage" class="mt-3 text-sm hidden"></div>
                    </div>

                    <div class="bg-gray-800 p-8 rounded-xl soft-shadow">
                        <h3 class="text-xl font-semibold text-gray-200 mb-4">Certifications & Documents</h3>
                        <div class="space-y-3">
                            <div class="p-4 border border-gray-700 rounded-xl flex justify-between items-center bg-green-900">
                                <div>
                                    <p class="font-medium text-gray-200">
                                        <i class="fas fa-id-card mr-2"></i>
                                        National ID Verification
                                    </p>
                                    <p class="text-sm text-gray-400">Identity verified through registration</p>
                                </div>
                                <span class="text-sm text-green-400 font-semibold">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Verified
                                </span>
                            </div>
                            
                            <!-- Professional Certificates Section -->
                            <div class="p-4 border border-gray-700 rounded-xl bg-gray-900">
                                <div class="flex justify-between items-center mb-4">
                                    <div>
                                        <p class="font-medium text-gray-200">
                                            <i class="fas fa-certificate mr-2"></i>
                                            Professional Certificates
                                        </p>
                                        <p class="text-sm text-gray-400">Upload your professional certificates</p>
                                    </div>
                                    <button onclick="openCertificateUploadModal()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm">
                                        <i class="fas fa-upload mr-2"></i>
                                        Upload
                                    </button>
                                </div>
                                
                                <!-- Certificates List -->
                                <div id="certificatesList" class="space-y-2">
                                    @php
                                        $userCertificates = Auth::user()->certificates;
                                        if (is_string($userCertificates)) {
                                            $userCertificates = json_decode($userCertificates, true) ?? [];
                                        } elseif (!is_array($userCertificates)) {
                                            $userCertificates = [];
                                        }
                                    @endphp
                                    @if(!empty($userCertificates) && is_array($userCertificates))
                                        @foreach($userCertificates as $index => $certificate)
                                            <div class="flex items-center justify-between p-3 bg-gray-800 rounded-lg border border-gray-600 certificate-item" data-index="{{ $index }}">
                                                <div class="flex items-center space-x-3">
                                                    <i class="fas fa-file-{{ str_contains($certificate['mime_type'] ?? '', 'pdf') ? 'pdf' : 'image' }} text-blue-400"></i>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-200">{{ $certificate['name'] ?? 'Unknown Certificate' }}</p>
                                                        <p class="text-xs text-gray-400">{{ $certificate['original_name'] ?? 'Unknown' }} • {{ number_format(($certificate['file_size'] ?? 0) / 1024, 1) }} KB</p>
                                                        <p class="text-xs text-gray-500">Uploaded {{ isset($certificate['uploaded_at']) ? \Carbon\Carbon::parse($certificate['uploaded_at'])->format('M d, Y') : 'Unknown date' }}</p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <button onclick="viewCertificate('{{ $certificate['path'] ?? '' }}', '{{ $certificate['name'] ?? 'Certificate' }}', '{{ $certificate['mime_type'] ?? 'application/octet-stream' }}')" class="text-blue-400 hover:text-blue-300 text-sm">
                                                        <i class="fas fa-eye mr-1"></i>
                                                        View
                                                    </button>
                                                    <button onclick="deleteCertificate({{ $index }})" class="text-red-400 hover:text-red-300 text-sm">
                                                        <i class="fas fa-trash mr-1"></i>
                                                        Delete
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-center py-6 text-gray-500">
                                            <i class="fas fa-certificate text-3xl mb-2"></i>
                                            <p class="text-sm">No certificates uploaded yet</p>
                                            <p class="text-xs">Upload your professional certificates to showcase your qualifications</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="applications-content" class="content-section hidden">
                    <h2 class="text-2xl font-semibold text-gray-300 mb-6">My Job Application History</h2>
                    
                    <!-- Floating Profile Icon -->
                    <div id="floatingProfileIcon" class="fixed bottom-6 right-6 z-50 transition-all duration-300">
                        <div class="relative">
                            <img class="h-16 w-16 rounded-full border-4 border-blue-500 shadow-lg cursor-pointer hover:scale-110 transition-transform" 
                                 src="{{ Auth::user()->getProfilePictureUrl() }}" 
                                 alt="Your Profile"
                                 onclick="toggleFloatingIcon()">
                            <div class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold">
                                <span id="applicationCount">0</span>
                            </div>
                            <button onclick="hideFloatingIcon()" class="absolute -top-1 -left-1 bg-gray-600 hover:bg-gray-700 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs transition">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="bg-gray-800 p-8 rounded-xl soft-shadow">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-200">Application Tracking</h3>
                                <p class="text-sm text-gray-400 mt-1">Track all your job applications and their status</p>
                            </div>
                            <div class="flex items-center space-x-4">
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-blue-400" id="totalApplicationsCount">0</div>
                                    <div class="text-sm text-gray-400">Total Applications</div>
                                </div>
                                <button onclick="refreshApplications()" class="text-blue-400 hover:text-blue-300 text-sm">
                                    <i class="fas fa-sync-alt mr-1"></i>
                                    Refresh
                                </button>
                            </div>
                        </div>
                        
                        <div id="applicationsContainer">
                            <div class="flex justify-center items-center py-8">
                                <i class="fas fa-spinner fa-spin text-2xl text-blue-400"></i>
                                <span class="ml-2 text-gray-300">Loading applications...</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="notifications-content" class="content-section hidden">
                    <h2 class="text-2xl font-semibold text-gray-300 mb-6">Job Matches - Jobs That Match Your Skills</h2>
                    
                    <div class="bg-gray-800 p-6 rounded-xl soft-shadow mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-white">Your Job Matches</h3>
                                <p class="text-sm text-gray-400">Jobs that match your skills and preferences</p>
                            </div>
                            <button onclick="markAllAsRead()" class="text-sm text-blue-400 hover:text-blue-300 transition">
                                <i class="fas fa-check-double mr-1"></i> Mark all as read
                            </button>
                        </div>

                        @if(isset($recentNotifications) && $recentNotifications->count() > 0)
                        <div class="space-y-4" id="notifications-list">
                            @foreach($recentNotifications as $notification)
                            <div class="bg-gray-700 rounded-lg p-4 {{ !$notification->is_read ? 'border-l-4 border-blue-500' : '' }} notification-item" data-notification-id="{{ $notification->id }}">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-2">
                                            <i class="fas fa-briefcase text-blue-400"></i>
                                            <h4 class="font-semibold text-white">{{ $notification->job->title }}</h4>
                                            @if(!$notification->is_read)
                                            <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded-full">New</span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-300 mb-2">
                                            <i class="fas fa-building text-gray-400 mr-1"></i>
                                            {{ $notification->job->employer->name ?? 'Employer' }}
                                        </p>
                                        <p class="text-sm text-gray-300 mb-2">
                                            <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>
                                            {{ $notification->job->location }}
                                        </p>
                                        <div class="flex items-center space-x-4 text-sm text-gray-400 mb-3">
                                            <span>
                                                <i class="fas fa-chart-line text-green-400 mr-1"></i>
                                                {{ $notification->getMatchPercentage() }} Match
                                            </span>
                                            <span>
                                                <i class="fas fa-clock mr-1"></i>
                                                {{ $notification->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-400 mb-3">
                                            {{ Str::limit(strip_tags($notification->job->description), 150) }}
                                        </p>
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('jobs.show', $notification->job->id) }}" class="text-sm bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition">
                                                <i class="fas fa-eye mr-1"></i> View Job
                                            </a>
                                            @if(!$notification->is_read)
                                            <button onclick="markAsRead({{ $notification->id }})" class="text-sm text-gray-400 hover:text-white transition">
                                                <i class="fas fa-check mr-1"></i> Mark as read
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-12">
                            <i class="fas fa-bell-slash text-6xl text-gray-600 mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-400 mb-2">No Job Matches Yet</h3>
                            <p class="text-gray-500 mb-4">We'll notify you when jobs matching your skills are posted</p>
                            <a href="#" class="sidebar-link text-blue-400 hover:text-blue-300 transition" data-content="skills">
                                <i class="fas fa-plus-circle mr-1"></i> Add More Skills
                            </a>
                        </div>
                        @endif
                    </div>

                    <!-- Statistics Card -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-gray-800 p-4 rounded-lg soft-shadow">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-400">Total Matches</p>
                                    <p class="text-2xl font-bold text-white">{{ $totalNotifications ?? 0 }}</p>
                                </div>
                                <i class="fas fa-briefcase text-3xl text-blue-400"></i>
                            </div>
                        </div>
                        <div class="bg-gray-800 p-4 rounded-lg soft-shadow">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-400">Unread</p>
                                    <p class="text-2xl font-bold text-white">{{ $unreadNotificationsCount ?? 0 }}</p>
                                </div>
                                <i class="fas fa-bell text-3xl text-yellow-400"></i>
                            </div>
                        </div>
                        <div class="bg-gray-800 p-4 rounded-lg soft-shadow">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-400">This Week</p>
                                    <p class="text-2xl font-bold text-white">{{ isset($recentNotifications) ? $recentNotifications->where('created_at', '>=', now()->subWeek())->count() : 0 }}</p>
                                </div>
                                <i class="fas fa-calendar-week text-3xl text-green-400"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="alerts-content" class="content-section hidden">
                    <h2 class="text-2xl font-semibold text-gray-300 mb-6">Manage Job Alerts</h2>
                    
                    <div class="bg-gray-800 p-8 rounded-xl soft-shadow mb-8">
                        <h3 class="text-xl font-semibold text-gray-200 mb-4">Your Active Alerts</h3>
                        <ul class="space-y-4">
                            <li class="p-4 border border-gray-700 rounded-lg flex justify-between items-center bg-gray-900">
                                <div>
                                    <p class="font-bold text-white">Job Type: Plumber (Daily/Short Term)</p>
                                    <p class="text-sm text-gray-400">Location: Within 10km of Kawempe</p>
                                </div>
                                <button class="text-red-500 hover:text-red-400 text-sm">Delete</button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div id="saved-content" class="content-section hidden">
                    <h2 class="text-2xl font-semibold text-gray-300 mb-6">Saved Jobs & Bookmarks</h2>
                    
                    <div class="bg-gray-800 p-8 rounded-xl soft-shadow">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-semibold text-gray-200">Your Saved Jobs</h3>
                            <button onclick="refreshSavedJobs()" class="text-blue-400 hover:text-blue-300 text-sm">
                                <i class="fas fa-sync-alt mr-1"></i>
                                Refresh
                            </button>
                        </div>
                        
                        <div id="savedJobsContainer">
                            <div class="flex justify-center items-center py-8">
                                <i class="fas fa-spinner fa-spin text-2xl text-blue-400"></i>
                                <span class="ml-2 text-gray-300">Loading saved jobs...</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="workplace-content" class="content-section hidden">
                    <h2 class="text-2xl font-semibold text-gray-300 mb-6">Workplace - Smart Job Discovery</h2>
                    
                    <!-- Gamified Profile System -->
                    <div class="bg-gradient-to-r from-blue-900 to-purple-900 p-6 rounded-xl soft-shadow mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-white">Your Profile Score</h3>
                                <p class="text-blue-200">Complete your profile to unlock better job matches</p>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold text-yellow-400" id="profileScore">75%</div>
                                <div class="text-sm text-blue-200">Profile Strength</div>
                            </div>
                        </div>
                        
                        <!-- Progress Bar -->
                        <div class="w-full bg-gray-700 rounded-full h-3 mb-4">
                            <div id="profileProgressBar" class="bg-gradient-to-r from-yellow-400 to-green-400 h-3 rounded-full transition-all duration-500" style="width: 75%"></div>
                        </div>
                        
                        <!-- Achievement Badges -->
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-3 py-1 bg-yellow-600 text-yellow-100 rounded-full text-xs font-semibold">
                                <i class="fas fa-star mr-1"></i>Profile Complete
                            </span>
                            <span class="px-3 py-1 bg-green-600 text-green-100 rounded-full text-xs font-semibold">
                                <i class="fas fa-certificate mr-1"></i>Skills Added
                            </span>
                            <span class="px-3 py-1 bg-blue-600 text-blue-100 rounded-full text-xs font-semibold">
                                <i class="fas fa-camera mr-1"></i>Photo Uploaded
                            </span>
                            <span class="px-3 py-1 bg-gray-600 text-gray-300 rounded-full text-xs opacity-50">
                                <i class="fas fa-file-alt mr-1"></i>Resume Uploaded
                            </span>
                        </div>
                        
                        <!-- Quick Actions -->
                        <div class="flex space-x-3">
                            <button onclick="showContent('profile')" class="group bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 text-sm">
                                <i class="fas fa-user-edit mr-2 group-hover:animate-pulse"></i>Complete Profile
                            </button>
                            <button onclick="showContent('skills')" class="group bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 text-sm">
                                <i class="fas fa-plus mr-2 group-hover:rotate-90 transition-transform duration-300"></i>Add Skills
                            </button>
                        </div>
                    </div>
                    
                    <!-- Real-time Job Alerts -->
                    <div class="bg-gray-800 p-6 rounded-xl soft-shadow mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-200">
                                    <i class="fas fa-bell text-yellow-500 mr-2"></i>
                                    Smart Job Alerts
                                </h3>
                                <p class="text-gray-400 text-sm">Get instant notifications for jobs that match your profile</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-400">Alerts</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="alertsToggle" class="sr-only peer" checked>
                                    <div class="w-11 h-6 bg-gray-600 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Alert Settings -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div class="bg-gray-900 p-4 rounded-lg">
                                <h4 class="font-semibold text-white mb-2">Location Alerts</h4>
                                <div class="flex items-center space-x-2">
                                    <input type="text" id="alertLocation" placeholder="e.g., Kampala, Entebbe" 
                                           class="flex-1 px-3 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg text-sm">
                                    <button onclick="findJobMatches()" class="group bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white px-4 py-2 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 text-sm">
                                        <i class="fas fa-search group-hover:animate-bounce"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="bg-gray-900 p-4 rounded-lg">
                                <h4 class="font-semibold text-white mb-2">Salary Range</h4>
                                <div class="flex items-center space-x-2">
                                    <input type="number" id="minSalary" placeholder="Min" 
                                           class="w-20 px-2 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg text-sm">
                                    <span class="text-gray-400">-</span>
                                    <input type="number" id="maxSalary" placeholder="Max" 
                                           class="w-20 px-2 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg text-sm">
                                    <span class="text-gray-400 text-sm">UGX</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Recent Alerts -->
                        <div id="recentAlerts" class="space-y-2">
                            <div class="flex items-center justify-between p-3 bg-blue-900 bg-opacity-50 rounded-lg border-l-4 border-blue-500">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-bell text-blue-400"></i>
                                    <div>
                                        <p class="text-sm font-medium text-white">New Construction Job in Kampala</p>
                                        <p class="text-xs text-gray-400">2 minutes ago • UGX 45,000/day</p>
                                    </div>
                                </div>
                                <button onclick="viewAreaJobs(this)" class="group bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 text-white px-4 py-2 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 text-sm">
                                    <i class="fas fa-eye mr-1 group-hover:animate-pulse"></i>View
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- View Toggle -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-4">
                            <h3 class="text-lg font-semibold text-gray-200">Job Discovery</h3>
                            <div class="flex bg-gray-800 rounded-xl p-1 shadow-inner">
                                <button id="cardViewBtn" onclick="switchView('cards')" class="group px-6 py-3 rounded-xl bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold shadow-lg transform transition-all duration-300 text-sm">
                                    <i class="fas fa-th-large mr-2 group-hover:animate-pulse"></i>Cards
                                </button>
                                <button id="mapViewBtn" onclick="switchView('map')" class="group px-6 py-3 rounded-xl text-gray-400 hover:text-white hover:bg-gradient-to-r hover:from-emerald-500 hover:to-teal-600 font-semibold transform hover:scale-105 transition-all duration-300 text-sm">
                                    <i class="fas fa-map mr-2 group-hover:animate-bounce"></i>Map
                                </button>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-400">Found:</span>
                            <span id="jobCount" class="text-lg font-semibold text-blue-400">0</span>
                            <span class="text-sm text-gray-400">jobs</span>
                        </div>
                    </div>
                    
                    <!-- Smart Job Cards View -->
                    <div id="cardsView" class="block">
                        <div class="bg-gray-800 p-6 rounded-xl soft-shadow">
                            <!-- Swipe Interface -->
                            <div class="relative h-[500px] mb-6 overflow-hidden">
                                <div id="jobCardsStack" class="relative w-full h-full">
                                    <!-- Job cards will be dynamically loaded here -->
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="text-center">
                                            <i class="fas fa-spinner fa-spin text-3xl text-blue-400 mb-4"></i>
                                            <p class="text-gray-300">Loading smart job recommendations...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Interactive Map View -->
                    <div id="mapView" class="hidden">
                        <div class="bg-gray-800 p-6 rounded-xl soft-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-200">Jobs Near You</h3>
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm text-gray-400">Radius:</span>
                                    <select id="radiusSelect" class="bg-gray-700 text-white border border-gray-600 rounded px-2 py-1 text-sm">
                                        <option value="5">5 km</option>
                                        <option value="10" selected>10 km</option>
                                        <option value="25">25 km</option>
                                        <option value="50">50 km</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Map Container -->
                            <div id="jobMap" class="w-full h-96 bg-gray-700 rounded-lg relative overflow-hidden">
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="text-center">
                                        <i class="fas fa-map-marked-alt text-4xl text-blue-400 mb-4"></i>
                                        <p class="text-gray-300 mb-2">Interactive Job Map</p>
                                        <p class="text-sm text-gray-400">Click on markers to view job details</p>
                                    </div>
                                </div>
                                
                                <!-- Simulated Map Markers -->
                                <div class="absolute top-20 left-32 w-5 h-5 bg-gradient-to-r from-red-500 to-pink-600 rounded-full border-3 border-white shadow-lg cursor-pointer hover:scale-150 hover:shadow-red-500/50 transition-all duration-300" onclick="showJobPopup(1)"></div>
                                <div class="absolute top-40 left-48 w-5 h-5 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full border-3 border-white shadow-lg cursor-pointer hover:scale-150 hover:shadow-blue-500/50 transition-all duration-300" onclick="showJobPopup(2)"></div>
                                <div class="absolute top-32 right-40 w-5 h-5 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full border-3 border-white shadow-lg cursor-pointer hover:scale-150 hover:shadow-green-500/50 transition-all duration-300" onclick="showJobPopup(3)"></div>
                                <div class="absolute bottom-32 left-40 w-5 h-5 bg-gradient-to-r from-yellow-500 to-orange-600 rounded-full border-3 border-white shadow-lg cursor-pointer hover:scale-150 hover:shadow-yellow-500/50 transition-all duration-300" onclick="showJobPopup(4)"></div>
                                
                                <!-- Map Legend -->
                                <div class="absolute bottom-4 left-4 bg-black bg-opacity-75 text-white p-3 rounded-lg text-xs">
                                    <div class="flex items-center space-x-2 mb-1">
                                        <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                        <span>Urgent Jobs</span>
                                    </div>
                                    <div class="flex items-center space-x-2 mb-1">
                                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                        <span>Regular Jobs</span>
                                    </div>
                                    <div class="flex items-center space-x-2 mb-1">
                                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                        <span>High Pay</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                                        <span>New Jobs</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Job List for Map -->
                            <div id="mapJobsList" class="mt-4 space-y-2 max-h-48 overflow-y-auto">
                                <!-- Jobs will be listed here when map markers are clicked -->
                            </div>
                        </div>
                    </div>
                </div>

                <div id="messages-content" class="content-section hidden">
                    <h2 class="text-2xl font-semibold text-gray-300 mb-6">Messages</h2>
                    
                    <!-- WhatsApp-Style Chat Interface -->
                    <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden" style="height: calc(100vh - 250px); min-height: 500px;">
                        <div class="flex h-full">
                            <!-- Conversations List (Left Side) -->
                            <div class="w-1/3 bg-gray-900 border-r border-gray-700 flex flex-col">
                                <!-- Search Header -->
                                <div class="p-4 bg-gray-800 border-b border-gray-700">
                                    <div class="flex items-center justify-between mb-3">
                                        <h3 class="text-lg font-semibold text-white">Chats</h3>
                                        <button onclick="openNewChatModal()" class="group relative bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white px-4 py-2 rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-blue-500/50 flex items-center space-x-2">
                                            <i class="fas fa-comment-medical text-sm"></i>
                                            <span class="text-sm font-semibold">New Chat</span>
                                            <div class="absolute inset-0 rounded-xl bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                                        </button>
                                    </div>
                                    <input type="text" placeholder="Search conversations..." 
                                           class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400">
                                </div>
                                
                                <!-- Conversations -->
                                <div class="flex-1 overflow-y-auto" id="conversationsList">
                                    <div class="p-8 text-center text-gray-500">
                                        <i class="fas fa-comments text-4xl mb-3 text-gray-600"></i>
                                        <p class="text-sm">No conversations yet</p>
                                        <p class="text-xs mt-1">Click + to start chatting</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Chat Area (Right Side) -->
                            <div class="flex-1 flex flex-col bg-gray-800">
                                <!-- Chat Header -->
                                <div id="chatHeader" class="hidden p-4 bg-gray-900 border-b border-gray-700">
                                    <div class="flex items-center space-x-3">
                                        <div id="chatAvatar"></div>
                                        <div class="flex-1">
                                            <h3 id="chatName" class="font-semibold text-white"></h3>
                                            <p id="chatRole" class="text-xs text-gray-400"></p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Messages Area -->
                                <div class="flex-1 overflow-y-auto p-4 bg-gray-900" id="messagesArea" style="background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZGVmcz48cGF0dGVybiBpZD0iYSIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiBwYXR0ZXJuVHJhbnNmb3JtPSJyb3RhdGUoNDUpIj48cGF0aCBkPSJNLTEwIDMwaDYwdjJoLTYweiIgZmlsbD0iIzFhMjAyYyIgZmlsbC1vcGFjaXR5PSIuMSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNhKSIvPjwvc3ZnPg==');">
                                    <!-- No Chat Selected -->
                                    <div id="noChatSelected" class="flex items-center justify-center h-full">
                                        <div class="text-center text-gray-500">
                                            <i class="fas fa-comment-dots text-6xl mb-4 text-gray-600"></i>
                                            <h3 class="text-xl font-semibold mb-2 text-gray-400">Select a chat</h3>
                                            <p class="text-sm">Choose a conversation to start messaging</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Messages Container -->
                                    <div id="messagesContainer" class="hidden space-y-3"></div>
                                </div>
                                
                                <!-- Message Input -->
                                <div id="messageInput" class="hidden p-4 bg-gray-900 border-t border-gray-700">
                                    <form id="sendMessageForm" class="flex items-center space-x-3">
                                        <input type="hidden" id="currentReceiverId">
                                        <input type="text" id="messageText" placeholder="Type a message..." 
                                               class="flex-1 px-4 py-3 bg-gray-700 text-white rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400"
                                               maxlength="1000" required>
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-full transition">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
    <!-- New Chat Modal -->
    <div id="new-chat-modal" class="modal-overlay">
        <div class="bg-gray-800 rounded-xl shadow-2xl w-full max-w-md mx-4 soft-shadow">
            <div class="p-6 border-b border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-white">New Chat</h3>
                    <button onclick="closeModal('new-chat-modal')" class="text-gray-400 hover:text-white">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            <div class="p-6">
                <p class="text-sm text-gray-400 mb-4">Select an employer to start chatting</p>
                <div id="employersList" class="space-y-2 max-h-96 overflow-y-auto">
                    <div class="flex justify-center py-8">
                        <i class="fas fa-spinner fa-spin text-2xl text-blue-400"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Congratulations Modal for Approved Application -->
    <div id="congratulations-modal" class="modal-overlay">
        <div class="bg-gradient-to-br from-green-600 to-green-700 rounded-2xl shadow-2xl w-full max-w-lg mx-4 soft-shadow relative overflow-hidden">
            <!-- Confetti Animation Background -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-0 left-1/4 w-2 h-2 bg-yellow-300 rounded-full animate-ping"></div>
                <div class="absolute top-10 right-1/4 w-2 h-2 bg-blue-300 rounded-full animate-ping" style="animation-delay: 0.2s;"></div>
                <div class="absolute top-5 left-1/3 w-2 h-2 bg-pink-300 rounded-full animate-ping" style="animation-delay: 0.4s;"></div>
                <div class="absolute top-20 right-1/3 w-2 h-2 bg-purple-300 rounded-full animate-ping" style="animation-delay: 0.6s;"></div>
            </div>
            
            <div class="p-8 text-center relative z-10">
                <!-- Success Icon -->
                <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg animate-bounce">
                    <i class="fas fa-check text-green-600 text-5xl"></i>
                </div>
                
                <h2 class="text-3xl font-bold text-white mb-4">🎉 Congratulations!</h2>
                <p class="text-xl text-green-50 mb-2">You've Been Hired!</p>
                <p class="text-green-100 mb-6" id="congratsMessage">
                    Your application has been approved by the employer.
                </p>
                
                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 mb-6">
                    <p class="text-sm text-green-50 mb-1">Job Position:</p>
                    <p class="text-lg font-semibold text-white" id="congratsJobTitle">-</p>
                    <p class="text-sm text-green-50 mt-2 mb-1">Employer:</p>
                    <p class="text-lg font-semibold text-white" id="congratsEmployerName">-</p>
                </div>
                
                <p class="text-sm text-green-100 mb-6">
                    <i class="fas fa-info-circle mr-1"></i>
                    The employer will contact you soon with next steps. Check your messages!
                </p>
                
                <button onclick="closeCongratsModal()" class="bg-white text-green-600 px-8 py-3 rounded-xl font-semibold hover:bg-green-50 transition duration-300 shadow-lg">
                    <i class="fas fa-thumbs-up mr-2"></i>
                    Awesome!
                </button>
            </div>
        </div>
    </div>
    
    <div id="edit-details-modal" class="modal-overlay">
        <div class="bg-gray-800 rounded-xl shadow-2xl w-full max-w-lg mx-4 my-4 soft-shadow relative max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-gray-800 p-6 pb-4 border-b border-gray-700 rounded-t-xl">
                <h2 class="text-2xl font-bold text-blue-400">
                    <i class="fas fa-user-edit mr-2"></i>
                    Edit Your Details
                </h2>
                <button onclick="closeModal('edit-details-modal')" 
                        class="absolute top-4 right-4 text-gray-400 hover:text-white transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div class="p-6 pt-4">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileUpdateForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-6 border-b border-gray-700 pb-6">
                        <label for="profile_picture" class="block text-sm font-medium text-gray-300 mb-2">Profile Picture</label>
                        <div class="flex items-center space-x-4">
                            <img class="h-16 w-16 rounded-full object-cover border-2 border-gray-600" 
                                 src="{{ Auth::user()->getProfilePictureUrl() }}" 
                                 alt="Current Profile Picture"
                                 id="modalProfilePreview">
                            <label class="cursor-pointer bg-gray-700 text-white py-2 px-4 rounded-xl hover:bg-gray-600 transition duration-200 text-sm font-medium">
                                <i class="fas fa-upload mr-2"></i>
                                Upload New Photo
                                <input id="profile_picture" name="profile_picture" type="file" accept="image/*" class="sr-only" onchange="previewModalImage(this)">
                            </label>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">JPG, PNG, GIF up to 2MB</p>
                    </div>

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-300">Full Name</label>
                        <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" required 
                               class="mt-1 block w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-xl focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400">
                    </div>

                    <div class="mb-4">
                        <label for="bio" class="block text-sm font-medium text-gray-300">Professional Title/Bio</label>
                        <input type="text" id="bio" name="bio" value="{{ Auth::user()->bio }}" 
                               placeholder="e.g., Professional Plumber, Construction Worker"
                               class="mt-1 block w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-xl focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400">
                    </div>
                    
                    <div class="mb-4">
                        <label for="phone" class="block text-sm font-medium text-gray-300">Phone Number</label>
                        <input type="tel" id="phone" name="phone" value="{{ Auth::user()->phone }}" 
                               placeholder="+256 XXX XXX XXX"
                               class="mt-1 block w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-xl focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400">
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-300">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" readonly 
                               class="mt-1 block w-full px-4 py-2 bg-gray-600 text-gray-400 border border-gray-600 rounded-xl cursor-not-allowed">
                        <p class="mt-1 text-xs text-gray-500">Contact support to change your email.</p>
                    </div>

                    <div class="mb-6">
                        <label for="location" class="block text-sm font-medium text-gray-300">Location / Current Address</label>
                        <textarea id="location" name="location" rows="3" 
                                  placeholder="e.g., Kampala, Kawempe"
                                  class="mt-1 block w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-xl focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400">{{ Auth::user()->location }}</textarea>
                    </div>
                </form>
            </div>
            
            <div class="sticky bottom-0 bg-gray-800 p-6 pt-4 border-t border-gray-700 rounded-b-xl">
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeModal('edit-details-modal')" 
                            class="px-6 py-2 border border-gray-600 text-gray-300 rounded-xl hover:bg-gray-700 transition font-medium">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </button>
                    <button type="submit" form="profileUpdateForm"
                            class="px-6 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-semibold shadow-md">
                        <i class="fas fa-save mr-2"></i>
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Certificate Upload Modal -->
    <div id="certificate-upload-modal" class="modal-overlay">
        <div class="bg-gray-800 rounded-xl shadow-2xl w-full max-w-md mx-4 my-4 soft-shadow relative">
            <div class="p-6 border-b border-gray-700">
                <h2 class="text-xl font-bold text-blue-400">
                    <i class="fas fa-certificate mr-2"></i>
                    Upload Certificate
                </h2>
                <button onclick="closeModal('certificate-upload-modal')" 
                        class="absolute top-4 right-4 text-gray-400 hover:text-white transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div class="p-6">
                <form id="certificateUploadForm" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="certificate_name" class="block text-sm font-medium text-gray-300 mb-2">Certificate Name</label>
                        <input type="text" id="certificate_name" name="certificate_name" required 
                               placeholder="e.g., Plumbing Certification, Electrical License"
                               class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-xl focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400">
                    </div>

                    <div class="mb-4">
                        <label for="certificate_file" class="block text-sm font-medium text-gray-300 mb-2">Certificate File</label>
                        <div class="border-2 border-dashed border-gray-600 rounded-xl p-4 text-center hover:border-blue-500 transition">
                            <input type="file" id="certificate_file" name="certificate" accept=".pdf,.jpg,.jpeg,.png" required class="hidden" onchange="updateFileDisplay(this)">
                            <label for="certificate_file" class="cursor-pointer">
                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                <p class="text-gray-300 font-medium">Click to select file</p>
                                <p class="text-sm text-gray-500">PDF, JPG, PNG (max 5MB)</p>
                            </label>
                            <div id="selectedFileName" class="mt-2 text-sm text-blue-400 hidden"></div>
                        </div>
                    </div>

                    <div id="certificateUploadMessage" class="mb-4 text-sm hidden"></div>
                </form>
            </div>
            
            <div class="p-6 pt-0 border-t border-gray-700">
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeModal('certificate-upload-modal')" 
                            class="px-6 py-2 border border-gray-600 text-gray-300 rounded-xl hover:bg-gray-700 transition">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </button>
                    <button type="button" onclick="uploadCertificate()"
                            class="px-6 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-semibold shadow-md">
                        <i class="fas fa-upload mr-2"></i>
                        Upload Certificate
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Certificate Viewer Modal -->
    <div id="certificate-viewer-modal" class="modal-overlay">
        <div class="bg-gray-800 rounded-xl shadow-2xl w-full max-w-4xl mx-4 my-4 soft-shadow relative max-h-[90vh] overflow-hidden">
            <div class="sticky top-0 bg-gray-800 p-4 border-b border-gray-700 rounded-t-xl flex justify-between items-center">
                <h2 class="text-xl font-bold text-blue-400">
                    <i class="fas fa-eye mr-2"></i>
                    <span id="certificateViewerTitle">Certificate Viewer</span>
                </h2>
                <button onclick="closeModal('certificate-viewer-modal')" 
                        class="text-gray-400 hover:text-white transition bg-gray-700 hover:bg-gray-600 rounded-lg p-2">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            
            <div class="p-4 overflow-y-auto" style="max-height: calc(90vh - 80px);">
                <div id="certificateViewerContent" class="text-center">
                    <!-- Certificate content will be loaded here -->
                </div>
            </div>
            
            <div class="sticky bottom-0 bg-gray-800 p-4 border-t border-gray-700 rounded-b-xl">
                <div class="flex justify-between items-center">
                    <button onclick="closeModal('certificate-viewer-modal')" 
                            class="px-6 py-2 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition font-semibold">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Certificates
                    </button>
                    <div class="flex items-center space-x-4">
                        <!-- Download Progress Bar (hidden by default) -->
                        <div id="downloadProgress" class="hidden flex items-center space-x-2">
                            <div class="w-32 bg-gray-700 rounded-full h-2">
                                <div id="downloadProgressBar" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                            </div>
                            <span id="downloadProgressText" class="text-sm text-gray-300">0%</span>
                        </div>
                        <button id="certificateDownloadBtn" onclick="downloadCertificate()" 
                               class="px-6 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-semibold">
                            <i class="fas fa-download mr-2"></i>
                            Download
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Unsave Job Confirmation Modal -->
    <div id="unsave-job-modal" class="modal-overlay">
        <div class="bg-gray-800 rounded-xl shadow-2xl w-full max-w-md mx-4 my-4 soft-shadow relative">
            <div class="p-6 border-b border-gray-700">
                <h2 class="text-xl font-bold text-red-400">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Remove Saved Job
                </h2>
            </div>
            
            <div class="p-6">
                <p class="text-gray-300 mb-4">Are you sure you want to remove this job from your saved jobs?</p>
                <p class="text-sm text-gray-400">This action cannot be undone. You can always save the job again later.</p>
            </div>
            
            <div class="p-6 pt-0 border-t border-gray-700">
                <div class="flex justify-end space-x-4">
                    <button onclick="closeUnsaveModal()" 
                            class="px-6 py-2 border border-gray-600 text-gray-300 rounded-xl hover:bg-gray-700 transition">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </button>
                    <button id="confirmUnsaveBtn" onclick="confirmUnsaveJob()"
                            class="px-6 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700 transition font-semibold shadow-md">
                        <i class="fas fa-bookmark-slash mr-2"></i>
                        Remove Job
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Job Application Modal -->
    <div id="job-application-modal" class="modal-overlay">
        <div class="bg-gray-800 rounded-xl shadow-2xl w-full max-w-2xl mx-4 my-4 soft-shadow relative max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-gray-800 p-6 pb-4 border-b border-gray-700 rounded-t-xl">
                <h2 class="text-2xl font-bold text-blue-400">
                    <i class="fas fa-briefcase mr-2"></i>
                    Apply for Job
                </h2>
                <p class="text-gray-400 text-sm mt-1" id="applicationJobTitle">Loading job details...</p>
                <button onclick="closeModal('job-application-modal')" 
                        class="absolute top-4 right-4 text-gray-400 hover:text-white transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div class="p-6 pt-4">
                <form id="jobApplicationForm">
                    <!-- Job Information Display -->
                    <div class="bg-gray-900 p-4 rounded-lg mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-400">Company:</span>
                                <span class="text-white font-medium ml-2" id="applicationCompany">-</span>
                            </div>
                            <div>
                                <span class="text-gray-400">Location:</span>
                                <span class="text-white font-medium ml-2" id="applicationLocation">-</span>
                            </div>
                            <div>
                                <span class="text-gray-400">Salary:</span>
                                <span class="text-green-400 font-medium ml-2" id="applicationSalary">-</span>
                            </div>
                            <div>
                                <span class="text-gray-400">Job Type:</span>
                                <span class="text-blue-400 font-medium ml-2" id="applicationType">-</span>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-200 mb-4">Personal Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="applicantName" class="block text-sm font-medium text-gray-300 mb-2">Full Name *</label>
                                <input type="text" id="applicantName" name="applicantName" required 
                                       value="{{ Auth::user()->name }}"
                                       class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="applicantPhone" class="block text-sm font-medium text-gray-300 mb-2">Phone Number *</label>
                                <input type="tel" id="applicantPhone" name="applicantPhone" required 
                                       value="{{ Auth::user()->phone ?? '' }}"
                                       placeholder="+256 XXX XXX XXX"
                                       class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        <div class="mt-4">
                            <label for="applicantEmail" class="block text-sm font-medium text-gray-300 mb-2">Email Address *</label>
                            <input type="email" id="applicantEmail" name="applicantEmail" required 
                                   value="{{ Auth::user()->email }}" readonly
                                   class="w-full px-4 py-2 bg-gray-600 text-gray-400 border border-gray-600 rounded-xl cursor-not-allowed">
                        </div>
                    </div>

                    <!-- Experience & Skills -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-200 mb-4">Experience & Skills</h3>
                        <div class="mb-4">
                            <label for="experience" class="block text-sm font-medium text-gray-300 mb-2">Relevant Experience</label>
                            <textarea id="experience" name="experience" rows="3" 
                                      placeholder="Describe your relevant work experience for this position..."
                                      class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-xl focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                        <div>
                            <label for="skills" class="block text-sm font-medium text-gray-300 mb-2">Key Skills</label>
                            <input type="text" id="skills" name="skills" 
                                   value="{{ implode(', ', Auth::user()->getSkillsArray()) }}"
                                   placeholder="e.g., Construction, Plumbing, Electrical work"
                                   class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Cover Letter -->
                    <div class="mb-6">
                        <label for="coverLetter" class="block text-sm font-medium text-gray-300 mb-2">Cover Letter *</label>
                        <textarea id="coverLetter" name="coverLetter" rows="5" required
                                  placeholder="Write a brief cover letter explaining why you're interested in this position and why you'd be a good fit..."
                                  class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-xl focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>

                    <!-- Availability -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-200 mb-4">Availability</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="startDate" class="block text-sm font-medium text-gray-300 mb-2">Available Start Date *</label>
                                <input type="date" id="startDate" name="startDate" required 
                                       class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="expectedSalary" class="block text-sm font-medium text-gray-300 mb-2">Expected Salary (UGX)</label>
                                <input type="number" id="expectedSalary" name="expectedSalary" 
                                       placeholder="e.g., 45000"
                                       class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="mb-6">
                        <label for="additionalInfo" class="block text-sm font-medium text-gray-300 mb-2">Additional Information</label>
                        <textarea id="additionalInfo" name="additionalInfo" rows="3" 
                                  placeholder="Any additional information you'd like to share (references, certifications, etc.)"
                                  class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-xl focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>

                    <div id="applicationMessage" class="mb-4 text-sm hidden"></div>
                </form>
            </div>
            
            <div class="sticky bottom-0 bg-gray-800 p-6 pt-4 border-t border-gray-700 rounded-b-xl">
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeModal('job-application-modal')" 
                            class="px-6 py-2 border border-gray-600 text-gray-300 rounded-xl hover:bg-gray-700 transition">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </button>
                    <button type="button" onclick="submitJobApplication()"
                            class="px-6 py-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Submit Application
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // CSRF token for AJAX requests  
        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

        // --- Profile Picture Upload Functions ---
        function uploadProfilePicture(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                
                // Validate file type
                if (!file.type.startsWith('image/')) {
                    showModernNotification('Please select a valid image file.', 'warning');
                    return;
                }
                
                // Validate file size (2MB max)
                if (file.size > 2 * 1024 * 1024) {
                    showModernNotification('File size must be less than 2MB.', 'warning');
                    return;
                }
                
                const formData = new FormData();
                formData.append('profile_picture', file);
                formData.append('_token', csrfToken);

                // Show loading state
                const profileImage = document.getElementById('profileImage');
                const originalSrc = profileImage.src;
                profileImage.style.opacity = '0.5';
                
                // Show loading message
                console.log('🔄 Uploading profile picture...');

                fetch('{{ route("profile.picture.update") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    console.log('📡 Response status:', response.status);
                    console.log('📡 Response headers:', response.headers);
                    
                    if (response.ok) {
                        return response.json();
                    } else {
                        // Handle validation errors (422)
                        return response.json().then(errorData => {
                            console.log('❌ Validation errors:', errorData);
                            let errorMessage = 'Upload failed';
                            if (errorData.errors) {
                                errorMessage = Object.values(errorData.errors).flat().join(', ');
                            } else if (errorData.message) {
                                errorMessage = errorData.message;
                            }
                            throw new Error(errorMessage);
                        }).catch(jsonError => {
                            console.log('❌ JSON parse error:', jsonError);
                            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                        });
                    }
                })
                .then(data => {
                    console.log('📡 Response data:', data);
                    console.log('🔍 Debug info:', data.debug_info);
                    
                    // Log all debug details
                    if (data.debug_info) {
                        console.log('📁 Stored path:', data.debug_info.stored_path);
                        console.log('🌐 Expected URL:', data.debug_info.expected_url);
                        console.log('🔗 Actual URL from method:', data.debug_info.actual_url_from_method);
                        console.log('📄 File exists:', data.debug_info.file_exists);
                        console.log('📂 Public storage path:', data.debug_info.public_storage_path);
                        console.log('💾 User profile picture field:', data.debug_info.user_profile_picture_field);
                    }
                    
                    if (data.success) {
                        console.log('✅ Profile picture uploaded successfully');
                        console.log('🔗 New profile picture URL:', data.profile_picture_url);
                        
                        // Check if we got the default avatar (means file wasn't found)
                        if (data.profile_picture_url.includes('ui-avatars.com')) {
                            console.warn('⚠️ Still getting default avatar - file may not be accessible');
                            
                            // Show detailed debug info to user
                            let debugMessage = 'Profile picture uploaded but not visible.\n\nDebug Info:\n';
                            if (data.debug_info) {
                                debugMessage += `Stored at: ${data.debug_info.stored_path}\n`;
                                debugMessage += `File exists: ${data.debug_info.file_exists}\n`;
                                debugMessage += `Expected URL: ${data.debug_info.full_url}`;
                            }
                            
                            showModernNotification(debugMessage, 'info', true);
                        } else {
                            // Update the profile image immediately without page reload
                            const newImageUrl = data.profile_picture_url + '?t=' + new Date().getTime();
                            profileImage.src = newImageUrl;
                            profileImage.style.opacity = '1';
                            
                            // Also update any other profile images on the page
                            const allProfileImages = document.querySelectorAll('img[src*="profile"]');
                            allProfileImages.forEach(img => {
                                if (img.src.includes('profile') || img.alt.includes('Profile')) {
                                    img.src = newImageUrl;
                                }
                            });
                            
                            showModernNotification('Profile picture updated successfully!', 'success');
                        }
                        
                        // Clear the file input
                        input.value = '';
                    } else {
                        throw new Error(data.message || 'Upload failed');
                    }
                })
                .catch(error => {
                    console.error('❌ Upload error:', error);
                    profileImage.style.opacity = '1';
                    showModernNotification('Failed to upload profile picture: ' + error.message, 'error');
                    
                    // Clear the file input
                    input.value = '';
                });
            }
        }

        function previewModalImage(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                
                // Validate file type
                if (!file.type.startsWith('image/')) {
                    showModernNotification('Please select a valid image file.', 'warning');
                    input.value = ''; // Clear the input
                    return;
                }
                
                // Validate file size (2MB max)
                if (file.size > 2 * 1024 * 1024) {
                    showModernNotification('File size must be less than 2MB.', 'warning');
                    input.value = ''; // Clear the input
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('modalProfilePreview');
                    if (preview) {
                        preview.src = e.target.result;
                        console.log('✅ Image preview updated');
                    }
                };
                reader.onerror = function() {
                    showModernNotification('Error reading the selected file.', 'error');
                    input.value = ''; // Clear the input
                };
                reader.readAsDataURL(file);
            }
        }

        // --- Skills Management Functions ---
        
        // Load available skills on page load
        function loadAvailableSkills() {
            fetch('/api/skills')
                .then(response => response.json())
                .then(data => {
                    const skillSelect = document.getElementById('skillSelect');
                    if (skillSelect && data.length > 0) {
                        data.forEach(skill => {
                            const option = document.createElement('option');
                            option.value = skill.name;
                            option.textContent = skill.name;
                            skillSelect.appendChild(option);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error loading skills:', error);
                });
        }
        
        // Add selected skill from dropdown
        function addSelectedSkill() {
            const skillSelect = document.getElementById('skillSelect');
            const skill = skillSelect.value.trim();
            
            if (!skill) {
                showSkillMessage('Please select a skill from the list.', 'error');
                return;
            }
            
            fetch('{{ route("profile.skills.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ skill: skill })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    skillSelect.value = '';
                    updateSkillsDisplay(data.skills);
                    showSkillMessage(data.message + ' Checking for matching jobs...', 'success');
                    
                    // Refresh the page after a short delay to show new notifications
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showSkillMessage(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showSkillMessage('Failed to add skill. Please try again.', 'error');
            });
        }
        
        function addSkill() {
            const skillInput = document.getElementById('newSkillInput');
            const skill = skillInput.value.trim();
            
            if (!skill) {
                showSkillMessage('Please enter a skill name.', 'error');
                return;
            }

            fetch('{{ route("profile.skills.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ skill: skill })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    skillInput.value = '';
                    updateSkillsDisplay(data.skills);
                    showSkillMessage(data.message + ' Checking for matching jobs...', 'success');
                    
                    // Refresh the page after a short delay to show new notifications
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showSkillMessage(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showSkillMessage('Failed to add skill. Please try again.', 'error');
            });
        }

        function removeSkill(skill) {
            fetch('{{ route("profile.skills.remove") }}', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ skill: skill })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateSkillsDisplay(data.skills);
                    showSkillMessage(data.message, 'success');
                } else {
                    showSkillMessage(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showSkillMessage('Failed to remove skill. Please try again.', 'error');
            });
        }

        function updateSkillsDisplay(skills) {
            const container = document.getElementById('skillsContainer');
            container.innerHTML = '';
            
            skills.forEach(skill => {
                const skillTag = document.createElement('span');
                skillTag.className = 'px-3 py-1 text-sm bg-blue-900 text-blue-300 rounded-full flex items-center border border-blue-700 shadow-sm skill-tag';
                skillTag.innerHTML = `
                    ${skill}
                    <button onclick="removeSkill('${skill}')" class="ml-2 text-red-400 hover:text-red-300 font-bold text-xs">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                container.appendChild(skillTag);
            });
        }

        function showSkillMessage(message, type) {
            const messageDiv = document.getElementById('skillMessage');
            messageDiv.className = `mt-3 text-sm ${type === 'success' ? 'text-green-400' : 'text-red-400'}`;
            messageDiv.innerHTML = `<i class="fas fa-${type === 'success' ? 'check' : 'exclamation-triangle'} mr-1"></i>${message}`;
            messageDiv.classList.remove('hidden');
            
            setTimeout(() => {
                messageDiv.classList.add('hidden');
            }, 3000);
        }

        function handleSkillKeyPress(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                addSkill();
            }
        }

        // --- General Message Function ---
        function showMessage(message, type) {
            // Create a temporary message element
            const messageDiv = document.createElement('div');
            messageDiv.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
                type === 'success' ? 'bg-green-600 text-white' : 'bg-red-600 text-white'
            }`;
            messageDiv.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check' : 'exclamation-triangle'} mr-2"></i>
                ${message}
            `;
            
            document.body.appendChild(messageDiv);
            
            setTimeout(() => {
                messageDiv.remove();
            }, 3000);
        }

        // --- Certificate Management Functions ---
        function openCertificateUploadModal() {
            openModal('certificate-upload-modal');
            // Reset form
            document.getElementById('certificateUploadForm').reset();
            document.getElementById('selectedFileName').classList.add('hidden');
            document.getElementById('certificateUploadMessage').classList.add('hidden');
        }

        function updateFileDisplay(input) {
            const fileNameDiv = document.getElementById('selectedFileName');
            if (input.files && input.files[0]) {
                const file = input.files[0];
                
                // Validate file type
                const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
                if (!allowedTypes.includes(file.type)) {
                    showCertificateMessage('Please select a PDF or image file (JPG, PNG).', 'error');
                    input.value = '';
                    fileNameDiv.classList.add('hidden');
                    return;
                }
                
                // Validate file size (5MB max)
                if (file.size > 5 * 1024 * 1024) {
                    showCertificateMessage('File size must be less than 5MB.', 'error');
                    input.value = '';
                    fileNameDiv.classList.add('hidden');
                    return;
                }
                
                fileNameDiv.textContent = `Selected: ${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;
                fileNameDiv.classList.remove('hidden');
                document.getElementById('certificateUploadMessage').classList.add('hidden');
            } else {
                fileNameDiv.classList.add('hidden');
            }
        }

        function uploadCertificate() {
            const form = document.getElementById('certificateUploadForm');
            const formData = new FormData();
            
            const certificateName = document.getElementById('certificate_name').value.trim();
            const certificateFile = document.getElementById('certificate_file').files[0];
            
            if (!certificateName) {
                showCertificateMessage('Please enter a certificate name.', 'error');
                return;
            }
            
            if (!certificateFile) {
                showCertificateMessage('Please select a certificate file.', 'error');
                return;
            }
            
            formData.append('certificate', certificateFile);
            formData.append('certificate_name', certificateName);
            formData.append('_token', csrfToken);
            
            // Show loading state
            const uploadButton = document.querySelector('button[onclick="uploadCertificate()"]');
            const originalText = uploadButton.innerHTML;
            uploadButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Uploading...';
            uploadButton.disabled = true;
            
            showCertificateMessage('Uploading certificate...', 'info');
            
            fetch('{{ route("profile.certificate.upload") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    return response.json().then(errorData => {
                        let errorMessage = 'Upload failed';
                        if (errorData.errors) {
                            errorMessage = Object.values(errorData.errors).flat().join(', ');
                        } else if (errorData.message) {
                            errorMessage = errorData.message;
                        }
                        throw new Error(errorMessage);
                    });
                }
            })
            .then(data => {
                if (data.success) {
                    showMessage('Certificate uploaded successfully!', 'success');
                    closeModal('certificate-upload-modal');
                    updateCertificatesDisplay(data.certificates);
                } else {
                    throw new Error(data.message || 'Upload failed');
                }
            })
            .catch(error => {
                console.error('Certificate upload error:', error);
                showCertificateMessage('Failed to upload certificate: ' + error.message, 'error');
            })
            .finally(() => {
                // Restore button state
                uploadButton.innerHTML = originalText;
                uploadButton.disabled = false;
            });
        }

        function deleteCertificate(index) {
            if (!confirm('Are you sure you want to delete this certificate?')) {
                return;
            }
            
            fetch('{{ route("profile.certificate.delete") }}', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ certificate_index: index })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('Certificate deleted successfully!', 'success');
                    updateCertificatesDisplay(data.certificates);
                } else {
                    showMessage(data.message || 'Failed to delete certificate', 'error');
                }
            })
            .catch(error => {
                console.error('Certificate deletion error:', error);
                showMessage('Failed to delete certificate. Please try again.', 'error');
            });
        }

        function updateCertificatesDisplay(certificates) {
            const certificatesList = document.getElementById('certificatesList');
            
            if (!certificates || certificates.length === 0) {
                certificatesList.innerHTML = `
                    <div class="text-center py-6 text-gray-500">
                        <i class="fas fa-certificate text-3xl mb-2"></i>
                        <p class="text-sm">No certificates uploaded yet</p>
                        <p class="text-xs">Upload your professional certificates to showcase your qualifications</p>
                    </div>
                `;
                return;
            }
            
            certificatesList.innerHTML = certificates.map((certificate, index) => {
                const fileIcon = certificate.mime_type.includes('pdf') ? 'file-pdf' : 'file-image';
                const uploadDate = new Date(certificate.uploaded_at).toLocaleDateString('en-US', { 
                    year: 'numeric', 
                    month: 'short', 
                    day: 'numeric' 
                });
                const fileSize = (certificate.file_size / 1024).toFixed(1);
                
                return `
                    <div class="flex items-center justify-between p-3 bg-gray-800 rounded-lg border border-gray-600 certificate-item" data-index="${index}">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-${fileIcon} text-blue-400"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-200">${certificate.name}</p>
                                <p class="text-xs text-gray-400">${certificate.original_name} • ${fileSize} KB</p>
                                <p class="text-xs text-gray-500">Uploaded ${uploadDate}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button onclick="viewCertificate('${certificate.path}', '${certificate.name}', '${certificate.mime_type}')" class="text-blue-400 hover:text-blue-300 text-sm">
                                <i class="fas fa-eye mr-1"></i>
                                View
                            </button>
                            <button onclick="deleteCertificate(${index})" class="text-red-400 hover:text-red-300 text-sm">
                                <i class="fas fa-trash mr-1"></i>
                                Delete
                            </button>
                        </div>
                    </div>
                `;
            }).join('');
        }

        function showCertificateMessage(message, type) {
            const messageDiv = document.getElementById('certificateUploadMessage');
            messageDiv.className = `mb-4 text-sm ${type === 'success' ? 'text-green-400' : type === 'error' ? 'text-red-400' : 'text-blue-400'}`;
            messageDiv.innerHTML = `<i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'exclamation-triangle' : 'info-circle'} mr-1"></i>${message}`;
            messageDiv.classList.remove('hidden');
        }

        // --- Certificate Viewer Functions ---
        let currentCertificate = null;

        function viewCertificate(certificatePath, certificateName, mimeType) {
            const modal = document.getElementById('certificate-viewer-modal');
            const title = document.getElementById('certificateViewerTitle');
            const content = document.getElementById('certificateViewerContent');
            
            // Store current certificate info for download
            currentCertificate = {
                path: certificatePath,
                name: certificateName,
                mimeType: mimeType
            };
            
            // Set title
            title.textContent = certificateName;
            
            // Reset download progress
            resetDownloadProgress();
            
            // Clear previous content
            content.innerHTML = '<div class="flex justify-center items-center py-8"><i class="fas fa-spinner fa-spin text-2xl text-blue-400"></i><span class="ml-2 text-gray-300">Loading certificate...</span></div>';
            
            // Show modal
            modal.style.display = 'flex';
            
            // Load certificate content based on type
            if (mimeType.includes('pdf')) {
                // For PDF files, use an iframe
                content.innerHTML = `
                    <iframe src="/storage/${certificatePath}" 
                            class="w-full border border-gray-600 rounded-lg" 
                            style="height: 600px;"
                            onload="this.style.display='block'"
                            onerror="this.style.display='none'; document.getElementById('certificateViewerContent').innerHTML='<div class=\\'text-center py-8 text-red-400\\'><i class=\\'fas fa-exclamation-triangle text-2xl mb-2\\'></i><p>Unable to display PDF. Please use the download button.</p></div>'">
                    </iframe>
                `;
            } else {
                // For image files, use an img tag
                content.innerHTML = `
                    <img src="/storage/${certificatePath}" 
                         alt="${certificateName}"
                         class="max-w-full max-h-full object-contain rounded-lg border border-gray-600"
                         onload="this.style.display='block'"
                         onerror="this.style.display='none'; document.getElementById('certificateViewerContent').innerHTML='<div class=\\'text-center py-8 text-red-400\\'><i class=\\'fas fa-exclamation-triangle text-2xl mb-2\\'></i><p>Unable to display image. Please use the download button.</p></div>'">
                `;
            }
        }

        function downloadCertificate() {
            if (!currentCertificate) {
                showMessage('No certificate selected for download', 'error');
                return;
            }

            const downloadBtn = document.getElementById('certificateDownloadBtn');
            const progressContainer = document.getElementById('downloadProgress');
            const progressBar = document.getElementById('downloadProgressBar');
            const progressText = document.getElementById('downloadProgressText');
            
            // Show progress bar and update button
            progressContainer.classList.remove('hidden');
            downloadBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Downloading...';
            downloadBtn.disabled = true;
            
            // Create XMLHttpRequest for progress tracking
            const xhr = new XMLHttpRequest();
            const url = `/storage/${currentCertificate.path}`;
            
            xhr.open('GET', url, true);
            xhr.responseType = 'blob';
            
            // Track download progress
            xhr.onprogress = function(event) {
                if (event.lengthComputable) {
                    const percentComplete = Math.round((event.loaded / event.total) * 100);
                    progressBar.style.width = percentComplete + '%';
                    progressText.textContent = percentComplete + '%';
                }
            };
            
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Create download link
                    const blob = xhr.response;
                    const downloadUrl = window.URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.href = downloadUrl;
                    
                    // Get file extension from mime type or original name
                    let extension = '';
                    if (currentCertificate.mimeType.includes('pdf')) {
                        extension = '.pdf';
                    } else if (currentCertificate.mimeType.includes('jpeg') || currentCertificate.mimeType.includes('jpg')) {
                        extension = '.jpg';
                    } else if (currentCertificate.mimeType.includes('png')) {
                        extension = '.png';
                    }
                    
                    // Set download filename
                    const filename = currentCertificate.name + extension;
                    link.download = filename;
                    
                    // Trigger download
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    
                    // Clean up
                    window.URL.revokeObjectURL(downloadUrl);
                    
                    // Show success message
                    showMessage(`Certificate "${currentCertificate.name}" downloaded successfully!`, 'success');
                    
                    // Reset UI after short delay
                    setTimeout(() => {
                        resetDownloadProgress();
                    }, 1000);
                } else {
                    showMessage('Failed to download certificate. Please try again.', 'error');
                    resetDownloadProgress();
                }
            };
            
            xhr.onerror = function() {
                showMessage('Download failed. Please check your connection and try again.', 'error');
                resetDownloadProgress();
            };
            
            xhr.ontimeout = function() {
                showMessage('Download timed out. Please try again.', 'error');
                resetDownloadProgress();
            };
            
            // Set timeout (30 seconds)
            xhr.timeout = 30000;
            
            // Start download
            xhr.send();
        }

        function resetDownloadProgress() {
            const downloadBtn = document.getElementById('certificateDownloadBtn');
            const progressContainer = document.getElementById('downloadProgress');
            const progressBar = document.getElementById('downloadProgressBar');
            const progressText = document.getElementById('downloadProgressText');
            
            // Hide progress bar
            progressContainer.classList.add('hidden');
            
            // Reset progress
            progressBar.style.width = '0%';
            progressText.textContent = '0%';
            
            // Reset button
            downloadBtn.innerHTML = '<i class="fas fa-download mr-2"></i>Download';
            downloadBtn.disabled = false;
        }

        // --- Saved Jobs Management Functions ---
        function loadSavedJobs() {
            const container = document.getElementById('savedJobsContainer');
            
            // Show loading state
            container.innerHTML = `
                <div class="flex justify-center items-center py-8">
                    <i class="fas fa-spinner fa-spin text-2xl text-blue-400"></i>
                    <span class="ml-2 text-gray-300">Loading saved jobs...</span>
                </div>
            `;
            
            fetch('{{ route("profile.saved-jobs") }}', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displaySavedJobs(data.jobs);
                } else {
                    container.innerHTML = `
                        <div class="text-center py-8 text-red-400">
                            <i class="fas fa-exclamation-triangle text-2xl mb-2"></i>
                            <p>Failed to load saved jobs. Please try again.</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error loading saved jobs:', error);
                container.innerHTML = `
                    <div class="text-center py-8 text-red-400">
                        <i class="fas fa-exclamation-triangle text-2xl mb-2"></i>
                        <p>Failed to load saved jobs. Please check your connection.</p>
                    </div>
                `;
            });
        }

        function displaySavedJobs(jobs) {
            const container = document.getElementById('savedJobsContainer');
            
            if (!jobs || jobs.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-12">
                        <i class="fas fa-bookmark text-6xl text-gray-600 mb-4"></i>
                        <h4 class="text-xl font-semibold text-gray-300 mb-2">No Saved Jobs Yet</h4>
                        <p class="text-gray-500 mb-6">Start browsing jobs and save the ones you're interested in for later.</p>
                        <div class="space-y-3">
                            <a href="{{ route('jobs') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                                <i class="fas fa-search mr-2"></i>
                                Browse Available Jobs
                            </a>
                            <div class="text-sm text-gray-400">
                                <i class="fas fa-lightbulb mr-1"></i>
                                Tip: Click the bookmark icon on any job listing to save it here
                            </div>
                        </div>
                    </div>
                `;
                return;
            }
            
            const jobsHtml = jobs.map(job => `
                <div class="bg-gray-900 p-6 rounded-xl border border-gray-700 hover:border-gray-600 transition saved-job-item" data-job-id="${job.id}">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            <h4 class="text-lg font-semibold text-white mb-2">${job.title}</h4>
                            <div class="flex items-center space-x-4 text-sm text-gray-400 mb-2">
                                <span><i class="fas fa-building mr-1"></i>${job.company}</span>
                                <span><i class="fas fa-map-marker-alt mr-1"></i>${job.location}</span>
                                <span><i class="fas fa-tag mr-1"></i>${job.category}</span>
                            </div>
                            <div class="flex items-center space-x-4 text-sm text-gray-400 mb-3">
                                <span class="px-2 py-1 bg-blue-900 text-blue-300 rounded-full text-xs">${job.job_type}</span>
                                <span class="text-green-400 font-semibold">UGX ${job.salary} / ${job.salary_type}</span>
                                <span><i class="fas fa-calendar mr-1"></i>Posted ${job.created_at}</span>
                            </div>
                            <p class="text-gray-300 text-sm leading-relaxed">${job.description}</p>
                        </div>
                        <div class="ml-4 flex flex-col space-y-2">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full ${job.status === 'active' ? 'bg-green-900 text-green-400' : 'bg-red-900 text-red-400'}">
                                ${job.status === 'active' ? 'Active' : 'Closed'}
                            </span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center pt-4 border-t border-gray-700">
                        <div class="flex space-x-3">
                            <a href="/jobs/${job.id}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm">
                                <i class="fas fa-eye mr-2"></i>
                                View Details
                            </a>
                            ${job.status === 'active' ? `
                                <a href="/jobs/${job.id}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm">
                                    <i class="fas fa-paper-plane mr-2"></i>
                                    Apply Now
                                </a>
                            ` : ''}
                        </div>
                        <button onclick="unsaveJob(${job.id})" class="text-red-400 hover:text-red-300 text-sm px-3 py-2 border border-red-400 rounded-lg hover:bg-red-900 transition">
                            <i class="fas fa-bookmark-slash mr-1"></i>
                            Unsave
                        </button>
                    </div>
                </div>
            `).join('');
            
            container.innerHTML = `
                <div class="space-y-4">
                    ${jobsHtml}
                </div>
            `;
        }

        function refreshSavedJobs() {
            loadSavedJobs();
        }

        function unsaveJob(jobId) {
            // Store the job ID for confirmation
            window.pendingUnsaveJobId = jobId;
            
            // Show modern confirmation modal
            openModal('unsave-job-modal');
        }

        function closeUnsaveModal() {
            closeModal('unsave-job-modal');
            window.pendingUnsaveJobId = null;
        }

        function confirmUnsaveJob() {
            const jobId = window.pendingUnsaveJobId;
            if (!jobId) return;
            
            const confirmBtn = document.getElementById('confirmUnsaveBtn');
            const originalText = confirmBtn.innerHTML;
            
            // Show loading state
            confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Removing...';
            confirmBtn.disabled = true;
            
            fetch('{{ route("profile.unsave-job") }}', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ job_id: jobId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('Job removed from saved jobs successfully!', 'success');
                    // Remove the job item from the display
                    const jobItem = document.querySelector(`[data-job-id="${jobId}"]`);
                    if (jobItem) {
                        jobItem.style.opacity = '0.5';
                        jobItem.style.transform = 'scale(0.95)';
                        setTimeout(() => {
                            loadSavedJobs(); // Reload the saved jobs list
                        }, 300);
                    }
                    closeUnsaveModal();
                } else {
                    showMessage(data.message || 'Failed to remove job from saved jobs', 'error');
                }
            })
            .catch(error => {
                console.error('Error unsaving job:', error);
                showMessage('Failed to remove job from saved jobs. Please try again.', 'error');
            })
            .finally(() => {
                // Restore button state
                confirmBtn.innerHTML = originalText;
                confirmBtn.disabled = false;
            });
        }

        // --- My Applications Management Functions ---
        function loadMyApplications() {
            const container = document.getElementById('applicationsContainer');
            
            // Show loading state
            container.innerHTML = `
                <div class="flex justify-center items-center py-8">
                    <i class="fas fa-spinner fa-spin text-2xl text-blue-400"></i>
                    <span class="ml-2 text-gray-300">Loading applications...</span>
                </div>
            `;
            
            fetch('{{ route("profile.my-applications") }}', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayMyApplications(data.applications, data.total_applications);
                    updateApplicationCounts(data.total_applications);
                } else {
                    container.innerHTML = `
                        <div class="text-center py-8 text-red-400">
                            <i class="fas fa-exclamation-triangle text-2xl mb-2"></i>
                            <p>Failed to load applications. Please try again.</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error loading applications:', error);
                container.innerHTML = `
                    <div class="text-center py-8 text-red-400">
                        <i class="fas fa-exclamation-triangle text-2xl mb-2"></i>
                        <p>Failed to load applications. Please check your connection.</p>
                    </div>
                `;
            });
        }

        function displayMyApplications(applications, totalCount) {
            const container = document.getElementById('applicationsContainer');
            
            if (!applications || applications.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-12">
                        <i class="fas fa-clipboard-list text-6xl text-gray-600 mb-4"></i>
                        <h4 class="text-xl font-semibold text-gray-300 mb-2">No Applications Yet</h4>
                        <p class="text-gray-500 mb-6">Start applying for jobs to see your application history here.</p>
                        <div class="space-y-3">
                            <a href="{{ route('jobs') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                                <i class="fas fa-search mr-2"></i>
                                Browse Available Jobs
                            </a>
                            <div class="text-sm text-gray-400">
                                <i class="fas fa-lightbulb mr-1"></i>
                                Tip: Apply for jobs to track your application status here
                            </div>
                        </div>
                    </div>
                `;
                return;
            }
            
            const applicationsHtml = applications.map(application => {
                const statusColors = {
                    'pending': 'bg-yellow-900 text-yellow-400',
                    'approved': 'bg-green-900 text-green-400',
                    'rejected': 'bg-red-900 text-red-400',
                    'withdrawn': 'bg-gray-900 text-gray-400'
                };
                
                const statusColor = statusColors[application.status] || 'bg-blue-900 text-blue-400';
                
                return `
                    <div class="bg-gray-900 p-6 rounded-xl border border-gray-700 hover:border-gray-600 transition application-item" data-application-id="${application.id}">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex-1">
                                <h4 class="text-lg font-semibold text-white mb-2">${application.job_title}</h4>
                                <div class="flex items-center space-x-4 text-sm text-gray-400 mb-2">
                                    <span><i class="fas fa-building mr-1"></i>${application.company}</span>
                                    <span><i class="fas fa-map-marker-alt mr-1"></i>${application.location}</span>
                                    <span><i class="fas fa-tag mr-1"></i>${application.category}</span>
                                </div>
                                <div class="flex items-center space-x-4 text-sm text-gray-400 mb-3">
                                    <span class="px-2 py-1 bg-blue-900 text-blue-300 rounded-full text-xs">${application.job_type}</span>
                                    <span class="text-green-400 font-semibold">UGX ${application.salary.toLocaleString()}</span>
                                </div>
                                <div class="flex items-center space-x-4 text-sm text-gray-500">
                                    <span><i class="fas fa-calendar mr-1"></i>Applied: ${application.applied_datetime}</span>
                                    <span><i class="fas fa-clock mr-1"></i>${application.days_ago}</span>
                                </div>
                            </div>
                            <div class="ml-4 flex flex-col items-end space-y-2">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full ${statusColor}">
                                    ${application.status.charAt(0).toUpperCase() + application.status.slice(1)}
                                </span>
                                <div class="text-xs text-gray-500">
                                    ID: #${application.id}
                                </div>
                            </div>
                        </div>
                        ${application.cover_letter ? `
                            <div class="pt-4 border-t border-gray-700">
                                <p class="text-sm text-gray-400 mb-2"><i class="fas fa-envelope mr-1"></i>Cover Letter:</p>
                                <p class="text-sm text-gray-300 bg-gray-800 p-3 rounded-lg">${application.cover_letter}</p>
                            </div>
                        ` : ''}
                        <div class="flex justify-between items-center pt-4 border-t border-gray-700 mt-4">
                            <div class="flex space-x-3">
                                <a href="/jobs/${application.job_id}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm">
                                    <i class="fas fa-eye mr-2"></i>
                                    View Job
                                </a>
                            </div>
                            <div class="text-xs text-gray-500">
                                Applied ${application.applied_time}
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
            
            container.innerHTML = `
                <div class="space-y-4">
                    ${applicationsHtml}
                </div>
            `;
        }

        function updateApplicationCounts(totalCount) {
            document.getElementById('totalApplicationsCount').textContent = totalCount;
            document.getElementById('applicationCount').textContent = totalCount;
        }

        function refreshApplications() {
            loadMyApplications();
        }

        // --- Floating Profile Icon Functions ---
        function toggleFloatingIcon() {
            const icon = document.getElementById('floatingProfileIcon');
            if (icon.style.transform === 'scale(1.2)') {
                icon.style.transform = 'scale(1)';
            } else {
                icon.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    icon.style.transform = 'scale(1)';
                }, 200);
            }
        }

        function hideFloatingIcon() {
            const icon = document.getElementById('floatingProfileIcon');
            icon.style.opacity = '0';
            icon.style.transform = 'scale(0)';
            setTimeout(() => {
                icon.style.display = 'none';
            }, 300);
        }

        function showFloatingIcon() {
            const icon = document.getElementById('floatingProfileIcon');
            icon.style.display = 'block';
            setTimeout(() => {
                icon.style.opacity = '1';
                icon.style.transform = 'scale(1)';
            }, 10);
        }

        // --- Workplace Features ---
        let currentJobCards = [];
        let currentCardIndex = 0;
        let swipeInProgress = false;

        // Gamified Profile System
        function calculateProfileScore() {
            const user = @json(Auth::user());
            let score = 0;
            let maxScore = 100;
            
            // Basic profile completion
            if (user.name) score += 15;
            if (user.email) score += 10;
            if (user.phone) score += 15;
            if (user.location) score += 15;
            if (user.bio) score += 15;
            if (user.profile_picture && !user.profile_picture.includes('ui-avatars.com')) score += 15;
            if (user.skills && user.skills.length > 0) score += 15;
            
            return Math.round((score / maxScore) * 100);
        }

        function updateProfileScore() {
            const score = calculateProfileScore();
            document.getElementById('profileScore').textContent = score + '%';
            document.getElementById('profileProgressBar').style.width = score + '%';
            
            // Update progress bar color based on score
            const progressBar = document.getElementById('profileProgressBar');
            if (score < 50) {
                progressBar.className = 'bg-gradient-to-r from-red-400 to-orange-400 h-3 rounded-full transition-all duration-500';
            } else if (score < 80) {
                progressBar.className = 'bg-gradient-to-r from-yellow-400 to-orange-400 h-3 rounded-full transition-all duration-500';
            } else {
                progressBar.className = 'bg-gradient-to-r from-yellow-400 to-green-400 h-3 rounded-full transition-all duration-500';
            }
        }

        // Real-time Job Alerts
        function saveAlertSettings() {
            const location = document.getElementById('alertLocation').value;
            const minSalary = document.getElementById('minSalary').value;
            const maxSalary = document.getElementById('maxSalary').value;
            
            // Save to localStorage for demo
            localStorage.setItem('jobAlerts', JSON.stringify({
                location: location,
                minSalary: minSalary,
                maxSalary: maxSalary,
                enabled: document.getElementById('alertsToggle').checked
            }));
            
            showMessage('Alert settings saved successfully!', 'success');
            
            // Simulate new alert
            setTimeout(() => {
                addNewAlert('New job matching your criteria found!', 'Just now');
            }, 2000);
        }

        function findJobMatches() {
            const location = document.getElementById('alertLocation').value;
            const minSalary = document.getElementById('minSalary').value;
            const maxSalary = document.getElementById('maxSalary').value;
            
            // Save settings first
            localStorage.setItem('jobAlerts', JSON.stringify({
                location: location,
                minSalary: minSalary,
                maxSalary: maxSalary,
                enabled: document.getElementById('alertsToggle').checked
            }));
            
            // Show loading state
            const button = event.target.closest('button');
            const originalContent = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            button.disabled = true;
            
            // Simulate instant job matching
            setTimeout(() => {
                // Generate matching jobs based on criteria
                const matchingJobs = generateMatchingJobs(location, minSalary, maxSalary);
                
                // Update job cards with new matches
                currentJobCards = matchingJobs;
                currentCardIndex = 0;
                displayCurrentCard();
                document.getElementById('jobCount').textContent = matchingJobs.length;
                
                // Show success message
                showMessage(`Found ${matchingJobs.length} job matches for your criteria!`, 'success');
                
                // Add instant alert
                addNewAlert(`${matchingJobs.length} jobs found matching "${location}" location`, 'Just now');
                
                // Restore button
                button.innerHTML = originalContent;
                button.disabled = false;
                
                // Auto-switch to cards view to show results
                switchView('cards');
                
            }, 1500);
        }

        function generateMatchingJobs(location, minSalary, maxSalary) {
            const jobTemplates = [
                {
                    title: 'Construction Worker',
                    company: 'BuildTech Uganda',
                    type: 'Daily',
                    description: 'Experienced construction worker needed for residential project.',
                    urgent: true
                },
                {
                    title: 'Plumber',
                    company: 'WaterFix Solutions',
                    type: 'Contract',
                    description: 'Professional plumber for commercial building maintenance.',
                    urgent: false
                },
                {
                    title: 'Electrician',
                    company: 'PowerGrid Ltd',
                    type: 'Project',
                    description: 'Licensed electrician for industrial electrical installation.',
                    urgent: false
                },
                {
                    title: 'Security Guard',
                    company: 'SecureUg Services',
                    type: 'Monthly',
                    description: 'Night shift security guard for office complex.',
                    urgent: true
                },
                {
                    title: 'Cleaner',
                    company: 'CleanPro Uganda',
                    type: 'Weekly',
                    description: 'Professional cleaner for residential and office cleaning.',
                    urgent: false
                },
                {
                    title: 'Driver',
                    company: 'TransportCo',
                    type: 'Daily',
                    description: 'Experienced driver with clean driving record needed.',
                    urgent: true
                }
            ];
            
            // Filter and generate jobs based on criteria
            const matchingJobs = [];
            const locationFilter = location.toLowerCase();
            const minSal = parseInt(minSalary) || 30000;
            const maxSal = parseInt(maxSalary) || 100000;
            
            jobTemplates.forEach((template, index) => {
                // Generate salary within range
                const salary = Math.floor(Math.random() * (maxSal - minSal + 1)) + minSal;
                
                // Generate match percentage based on criteria match
                let match = Math.floor(Math.random() * 20) + 75; // Base 75-95%
                if (locationFilter && template.title.toLowerCase().includes(locationFilter.split(' ')[0])) {
                    match = Math.min(match + 10, 98);
                }
                
                matchingJobs.push({
                    id: Date.now() + index,
                    title: template.title,
                    company: template.company,
                    location: location || 'Kampala, Uganda',
                    salary: salary,
                    type: template.type,
                    match: match,
                    description: template.description,
                    urgent: template.urgent
                });
            });
            
            // Sort by match percentage (highest first)
            return matchingJobs.sort((a, b) => b.match - a.match).slice(0, 4);
        }

        function addNewAlert(message, time) {
            const alertsContainer = document.getElementById('recentAlerts');
            const alertHtml = `
                <div class="flex items-center justify-between p-3 bg-green-900 bg-opacity-50 rounded-lg border-l-4 border-green-500">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-bell text-green-400"></i>
                        <div>
                            <p class="text-sm font-medium text-white">${message}</p>
                            <p class="text-xs text-gray-400">${time}</p>
                        </div>
                    </div>
                    <button onclick="viewAreaJobs(this)" class="group bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 text-white px-4 py-2 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 text-sm">
                        <i class="fas fa-eye mr-1 group-hover:animate-pulse"></i>View
                    </button>
                </div>
            `;
            alertsContainer.insertAdjacentHTML('afterbegin', alertHtml);
        }

        function viewAreaJobs(button) {
            // Get the alert message to extract location info
            const alertElement = button.closest('.flex');
            const alertMessage = alertElement.querySelector('.text-white').textContent;
            
            // Extract location from alert message or use saved location
            const savedAlerts = localStorage.getItem('jobAlerts');
            let location = 'Kampala'; // default
            
            if (savedAlerts) {
                const alerts = JSON.parse(savedAlerts);
                location = alerts.location || 'Kampala';
            }
            
            // Also try to extract location from the alert message
            if (alertMessage.includes('in ')) {
                const locationMatch = alertMessage.match(/in ([^"]+)/);
                if (locationMatch) {
                    location = locationMatch[1].trim();
                }
            }
            
            // Show loading state
            const originalContent = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Loading';
            button.disabled = true;
            
            console.log('Loading jobs for location:', location); // Debug log
            
            // Validate location and check for employers
            setTimeout(() => {
                const locationValidation = validateUgandanLocation(location);
                
                if (!locationValidation.isValid) {
                    // Location not available
                    showMessage('Place is not available yet', 'error');
                    button.innerHTML = originalContent;
                    button.disabled = false;
                    return;
                }
                
                if (!locationValidation.hasEmployers) {
                    // No registered employers in this area
                    showMessage(`No registered employers found in ${location} area`, 'error');
                    button.innerHTML = originalContent;
                    button.disabled = false;
                    return;
                }
                
                // Generate area-specific jobs with real employers
                const areaJobs = generateRealAreaJobs(locationValidation.normalizedName);
                
                console.log('Generated area jobs:', areaJobs); // Debug log
                
                // Update job cards with area jobs
                currentJobCards = areaJobs;
                currentCardIndex = 0;
                
                // Force display the current card
                displayCurrentCard();
                document.getElementById('jobCount').textContent = areaJobs.length;
                
                // Show success message
                showMessage(`Found ${areaJobs.length} jobs from registered employers in ${locationValidation.normalizedName}`, 'success');
                
                // Auto-switch to cards view to show results
                switchView('cards');
                
                // Restore button
                button.innerHTML = originalContent;
                button.disabled = false;
                
                // Scroll to job cards section (commented out due to syntax error)
                // document.getElementById('cardsView').scrollIntoView({ behavior: 'smooth' });
                
            }, 1200);
        }

        function validateUgandanLocation(location) {
            // Real Ugandan locations with registered employers
            const ugandanLocationsWithEmployers = {
                // Major cities
                'kampala': { name: 'Kampala', hasEmployers: true },
                'entebbe': { name: 'Entebbe', hasEmployers: true },
                'jinja': { name: 'Jinja', hasEmployers: true },
                'mbarara': { name: 'Mbarara', hasEmployers: true },
                'gulu': { name: 'Gulu', hasEmployers: true },
                'lira': { name: 'Lira', hasEmployers: true },
                'mbale': { name: 'Mbale', hasEmployers: true },
                'kasese': { name: 'Kasese', hasEmployers: true },
                'masaka': { name: 'Masaka', hasEmployers: true },
                'soroti': { name: 'Soroti', hasEmployers: true },
                
                // Kampala areas/suburbs
                'ntinda': { name: 'Ntinda, Kampala', hasEmployers: true },
                'kololo': { name: 'Kololo, Kampala', hasEmployers: true },
                'nakawa': { name: 'Nakawa, Kampala', hasEmployers: true },
                'kawempe': { name: 'Kawempe, Kampala', hasEmployers: true },
                'rubaga': { name: 'Rubaga, Kampala', hasEmployers: true },
                'makindye': { name: 'Makindye, Kampala', hasEmployers: true },
                'bugolobi': { name: 'Bugolobi, Kampala', hasEmployers: true },
                'bukoto': { name: 'Bukoto, Kampala', hasEmployers: true },
                'kansanga': { name: 'Kansanga, Kampala', hasEmployers: true },
                'najera': { name: 'Najera, Kampala', hasEmployers: true },
                
                // Other towns with some employers
                'mukono': { name: 'Mukono', hasEmployers: true },
                'wakiso': { name: 'Wakiso', hasEmployers: true },
                'mityana': { name: 'Mityana', hasEmployers: false },
                'lugazi': { name: 'Lugazi', hasEmployers: true },
                'iganga': { name: 'Iganga', hasEmployers: false },
                'tororo': { name: 'Tororo', hasEmployers: false },
                'kabale': { name: 'Kabale', hasEmployers: false },
                'fort portal': { name: 'Fort Portal', hasEmployers: false },
                'hoima': { name: 'Hoima', hasEmployers: false },
                'arua': { name: 'Arua', hasEmployers: false }
            };
            
            const searchLocation = location.toLowerCase().trim();
            
            // Check if location exists in Uganda
            if (ugandanLocationsWithEmployers[searchLocation]) {
                const locationData = ugandanLocationsWithEmployers[searchLocation];
                return {
                    isValid: true,
                    hasEmployers: locationData.hasEmployers,
                    normalizedName: locationData.name
                };
            }
            
            // Check partial matches for areas within cities
            for (const [key, value] of Object.entries(ugandanLocationsWithEmployers)) {
                if (searchLocation.includes(key) || key.includes(searchLocation)) {
                    return {
                        isValid: true,
                        hasEmployers: value.hasEmployers,
                        normalizedName: value.name
                    };
                }
            }
            
            // Location not found in Uganda
            return {
                isValid: false,
                hasEmployers: false,
                normalizedName: location
            };
        }

        function generateRealAreaJobs(location) {
            // Real employer data for different locations
            const realEmployersByLocation = {
                'Kampala': [
                    { name: 'Roofings Group', sector: 'Construction', established: true },
                    { name: 'Simba Telecom', sector: 'Telecommunications', established: true },
                    { name: 'Centenary Bank', sector: 'Banking', established: true },
                    { name: 'New Vision Printing', sector: 'Media', established: true },
                    { name: 'Uganda Breweries', sector: 'Manufacturing', established: true }
                ],
                'Entebbe': [
                    { name: 'Entebbe Airport Services', sector: 'Aviation', established: true },
                    { name: 'Lake Victoria Hotels', sector: 'Hospitality', established: true },
                    { name: 'Entebbe Municipality', sector: 'Government', established: true }
                ],
                'Jinja': [
                    { name: 'Jinja Industrial Park', sector: 'Manufacturing', established: true },
                    { name: 'Source of Nile Hotel', sector: 'Hospitality', established: true },
                    { name: 'Nile Breweries', sector: 'Manufacturing', established: true }
                ],
                'Mbarara': [
                    { name: 'Mbarara Regional Hospital', sector: 'Healthcare', established: true },
                    { name: 'Ankole Coffee Processors', sector: 'Agriculture', established: true }
                ],
                'Ntinda, Kampala': [
                    { name: 'Ntinda Shopping Complex', sector: 'Retail', established: true },
                    { name: 'Ntinda Technical Services', sector: 'Engineering', established: true }
                ],
                'Kololo, Kampala': [
                    { name: 'Kololo Hospital', sector: 'Healthcare', established: true },
                    { name: 'Diplomatic Security Services', sector: 'Security', established: true }
                ]
            };
            
            // Get employers for the location
            const employers = realEmployersByLocation[location] || realEmployersByLocation['Kampala'];
            
            // Job templates based on real employer sectors
            const jobTemplates = [
                {
                    title: 'Construction Worker',
                    type: 'Daily',
                    description: 'Experienced construction worker needed for ongoing building projects.',
                    salary: 45000,
                    urgent: true,
                    sector: 'Construction'
                },
                {
                    title: 'Security Guard',
                    type: 'Monthly',
                    description: 'Professional security guard for commercial premises.',
                    salary: 400000,
                    urgent: false,
                    sector: 'Security'
                },
                {
                    title: 'Cleaner',
                    type: 'Weekly',
                    description: 'Office and facility cleaning services required.',
                    salary: 150000,
                    urgent: false,
                    sector: 'General'
                },
                {
                    title: 'Driver',
                    type: 'Monthly',
                    description: 'Experienced driver with clean driving record.',
                    salary: 500000,
                    urgent: true,
                    sector: 'Transport'
                },
                {
                    title: 'Maintenance Technician',
                    type: 'Contract',
                    description: 'Building and equipment maintenance specialist.',
                    salary: 600000,
                    urgent: false,
                    sector: 'Engineering'
                }
            ];
            
            // Generate jobs with real employers
            const areaJobs = [];
            
            jobTemplates.forEach((template, index) => {
                if (index < employers.length) {
                    const employer = employers[index];
                    
                    // Match job to employer sector when possible
                    let jobTitle = template.title;
                    let jobDescription = template.description;
                    
                    if (employer.sector === 'Healthcare' && template.title === 'Cleaner') {
                        jobTitle = 'Hospital Cleaner';
                        jobDescription = 'Professional cleaning services for medical facility.';
                    } else if (employer.sector === 'Aviation' && template.title === 'Security Guard') {
                        jobTitle = 'Airport Security Officer';
                        jobDescription = 'Security services for airport facilities and operations.';
                    } else if (employer.sector === 'Manufacturing' && template.title === 'Maintenance Technician') {
                        jobTitle = 'Factory Maintenance Worker';
                        jobDescription = 'Equipment maintenance and repair for manufacturing facility.';
                    }
                    
                    const match = Math.floor(Math.random() * 15) + 82; // 82-97% for real employers
                    
                    areaJobs.push({
                        id: Date.now() + index + 2000,
                        title: jobTitle,
                        company: employer.name,
                        location: location + ', Uganda',
                        salary: template.salary,
                        type: template.type,
                        match: match,
                        description: jobDescription,
                        urgent: template.urgent
                    });
                }
            });
            
            // Sort by match percentage and urgency
            return areaJobs.sort((a, b) => {
                if (a.urgent && !b.urgent) return -1;
                if (!a.urgent && b.urgent) return 1;
                return b.match - a.match;
            });
        }

        function generateAreaJobs(location) {
            const areaJobTemplates = [
                {
                    title: 'Construction Supervisor',
                    company: `${location} BuildCorp`,
                    type: 'Monthly',
                    description: `Construction supervisor needed for ongoing projects in ${location} area.`,
                    urgent: true,
                    salary: 85000
                },
                {
                    title: 'Maintenance Technician',
                    company: `${location} Properties Ltd`,
                    type: 'Contract',
                    description: `Building maintenance technician for residential complexes in ${location}.`,
                    urgent: false,
                    salary: 65000
                },
                {
                    title: 'Delivery Driver',
                    company: `${location} Logistics`,
                    type: 'Daily',
                    description: `Reliable delivery driver for local routes within ${location} area.`,
                    urgent: true,
                    salary: 40000
                },
                {
                    title: 'Shop Assistant',
                    company: `${location} Retail Store`,
                    type: 'Weekly',
                    description: `Customer service assistant for busy retail store in ${location}.`,
                    urgent: false,
                    salary: 35000
                },
                {
                    title: 'Garden Caretaker',
                    company: `${location} Gardens`,
                    type: 'Project',
                    description: `Professional gardener for landscaping projects in ${location} area.`,
                    urgent: false,
                    salary: 50000
                },
                {
                    title: 'Security Officer',
                    company: `${location} Security Services`,
                    type: 'Monthly',
                    description: `Experienced security officer for commercial buildings in ${location}.`,
                    urgent: true,
                    salary: 55000
                }
            ];
            
            // Generate jobs specific to the area
            const areaJobs = areaJobTemplates.map((template, index) => {
                // Generate match percentage (area-specific jobs have higher matches)
                const match = Math.floor(Math.random() * 15) + 80; // 80-95% for area jobs
                
                return {
                    id: Date.now() + index + 1000,
                    title: template.title,
                    company: template.company,
                    location: `${location}, Uganda`,
                    salary: template.salary,
                    type: template.type,
                    match: match,
                    description: template.description,
                    urgent: template.urgent
                };
            });
            
            // Sort by urgency first, then by match percentage
            return areaJobs.sort((a, b) => {
                if (a.urgent && !b.urgent) return -1;
                if (!a.urgent && b.urgent) return 1;
                return b.match - a.match;
            });
        }

        // Smart Job Cards with Swipe Interface
        function loadJobCards() {
            // Simulate job data
            currentJobCards = [
                {
                    id: 1,
                    title: 'Construction Helper',
                    company: 'BuildCorp Ltd',
                    location: 'Kampala, Industrial Area',
                    salary: 45000,
                    type: 'Daily',
                    match: 92,
                    description: 'Looking for experienced construction helper for ongoing project.',
                    urgent: true
                },
                {
                    id: 2,
                    title: 'Plumber',
                    company: 'WaterWorks Uganda',
                    location: 'Entebbe',
                    salary: 60000,
                    type: 'Project',
                    match: 88,
                    description: 'Residential plumbing installation and repair work.',
                    urgent: false
                },
                {
                    id: 3,
                    title: 'Electrician',
                    company: 'PowerTech Solutions',
                    location: 'Kampala, Ntinda',
                    salary: 55000,
                    type: 'Contract',
                    match: 85,
                    description: 'Commercial electrical installation and maintenance.',
                    urgent: false
                }
            ];
            
            currentCardIndex = 0;
            displayCurrentCard();
            document.getElementById('jobCount').textContent = currentJobCards.length;
        }

        function displayCurrentCard() {
            const container = document.getElementById('jobCardsStack');
            
            console.log('Displaying card:', currentCardIndex, 'of', currentJobCards.length); // Debug log
            
            if (currentCardIndex >= currentJobCards.length) {
                container.innerHTML = `
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <i class="fas fa-check-circle text-4xl text-green-400 mb-4"></i>
                            <p class="text-gray-300 mb-2">All caught up!</p>
                            <p class="text-sm text-gray-400">Check back later for new job recommendations</p>
                            <button onclick="loadJobCards()" class="group mt-6 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                                <i class="fas fa-refresh mr-2 group-hover:animate-spin"></i>Reload Jobs
                            </button>
                        </div>
                    </div>
                `;
                return;
            }
            
            const job = currentJobCards[currentCardIndex];
            console.log('Current job:', job); // Debug log
            
            const cardHtml = `
                <div class="job-card absolute inset-0 bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl p-6 border border-gray-700 shadow-2xl transform transition-all duration-300" 
                     style="z-index: ${currentJobCards.length - currentCardIndex}">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 rounded-full ${job.match >= 90 ? 'bg-green-400' : job.match >= 80 ? 'bg-yellow-400' : 'bg-blue-400'}"></div>
                            <span class="text-sm font-semibold ${job.match >= 90 ? 'text-green-400' : job.match >= 80 ? 'text-yellow-400' : 'text-blue-400'}">${job.match}% Match</span>
                        </div>
                        ${job.urgent ? '<span class="bg-red-600 text-white px-2 py-1 rounded-full text-xs font-semibold">URGENT</span>' : ''}
                    </div>
                    
                    <h3 class="text-2xl font-bold text-white mb-2">${job.title}</h3>
                    <p class="text-blue-400 font-semibold mb-1">${job.company}</p>
                    <p class="text-gray-400 text-sm mb-4"><i class="fas fa-map-marker-alt mr-1"></i>${job.location}</p>
                    
                    <div class="bg-gray-700 bg-opacity-50 rounded-lg p-4 mb-4">
                        <p class="text-gray-300 text-sm leading-relaxed">${job.description}</p>
                    </div>
                    
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <p class="text-2xl font-bold text-green-400">UGX ${job.salary.toLocaleString()}</p>
                            <p class="text-sm text-gray-400">${job.type} basis</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-400">Job ID</p>
                            <p class="text-lg font-semibold text-gray-300">#${job.id}</p>
                        </div>
                    </div>
                    
                    <div class="flex space-x-2">
                        <span class="px-3 py-1 bg-blue-900 text-blue-300 rounded-full text-xs">Construction</span>
                        <span class="px-3 py-1 bg-purple-900 text-purple-300 rounded-full text-xs">${job.type}</span>
                        <span class="px-3 py-1 bg-green-900 text-green-300 rounded-full text-xs">Immediate Start</span>
                    </div>
                    
                    <div class="mt-6 pt-4 border-t border-gray-600">
                        <button onclick="openJobApplicationModal(${job.id})" class="w-full bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white py-3 px-6 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                            <i class="fas fa-paper-plane mr-2"></i>Apply for This Job
                        </button>
                    </div>
                </div>
            `;
            
            container.innerHTML = cardHtml;
        }

        function swipeLeft() {
            if (swipeInProgress) return;
            swipeInProgress = true;
            
            const card = document.querySelector('.job-card');
            if (card) {
                card.style.transform = 'translateX(-100%) rotate(-30deg)';
                card.style.opacity = '0';
                
                setTimeout(() => {
                    currentCardIndex++;
                    displayCurrentCard();
                    swipeInProgress = false;
                }, 300);
            }
        }

        function swipeRight() {
            if (swipeInProgress) return;
            swipeInProgress = true;
            
            const card = document.querySelector('.job-card');
            if (card) {
                card.style.transform = 'translateX(100%) rotate(30deg)';
                card.style.opacity = '0';
                
                // Save job
                const job = currentJobCards[currentCardIndex];
                showMessage(`Saved "${job.title}" to your bookmarks!`, 'success');
                
                setTimeout(() => {
                    currentCardIndex++;
                    displayCurrentCard();
                    swipeInProgress = false;
                }, 300);
            }
        }

        function swipeUp() {
            if (swipeInProgress) return;
            swipeInProgress = true;
            
            const card = document.querySelector('.job-card');
            if (card) {
                card.style.transform = 'translateY(-100%) scale(0.8)';
                card.style.opacity = '0';
                
                // Apply to job
                const job = currentJobCards[currentCardIndex];
                showMessage(`Applied to "${job.title}"! Good luck!`, 'success');
                
                setTimeout(() => {
                    currentCardIndex++;
                    displayCurrentCard();
                    swipeInProgress = false;
                }, 300);
            }
        }

        // View Switching
        function switchView(view) {
            const cardsView = document.getElementById('cardsView');
            const mapView = document.getElementById('mapView');
            const cardBtn = document.getElementById('cardViewBtn');
            const mapBtn = document.getElementById('mapViewBtn');
            
            if (view === 'cards') {
                cardsView.classList.remove('hidden');
                mapView.classList.add('hidden');
                cardBtn.className = 'group px-6 py-3 rounded-xl bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold shadow-lg transform transition-all duration-300 text-sm';
                mapBtn.className = 'group px-6 py-3 rounded-xl text-gray-400 hover:text-white hover:bg-gradient-to-r hover:from-emerald-500 hover:to-teal-600 font-semibold transform hover:scale-105 transition-all duration-300 text-sm';
            } else {
                cardsView.classList.add('hidden');
                mapView.classList.remove('hidden');
                cardBtn.className = 'group px-6 py-3 rounded-xl text-gray-400 hover:text-white hover:bg-gradient-to-r hover:from-blue-500 hover:to-purple-600 font-semibold transform hover:scale-105 transition-all duration-300 text-sm';
                mapBtn.className = 'group px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold shadow-lg transform transition-all duration-300 text-sm';
            }
        }

        // Interactive Map
        function showJobPopup(jobId) {
            const jobsData = {
                1: { title: 'Construction Helper', company: 'BuildCorp Ltd', salary: 45000, urgent: true },
                2: { title: 'Security Guard', company: 'SecureUg Ltd', salary: 40000, urgent: false },
                3: { title: 'Plumber', company: 'WaterWorks', salary: 60000, urgent: false },
                4: { title: 'Electrician', company: 'PowerTech', salary: 55000, urgent: false }
            };
            
            const job = jobsData[jobId];
            const mapJobsList = document.getElementById('mapJobsList');
            
            mapJobsList.innerHTML = `
                <div class="bg-gray-900 p-4 rounded-lg border border-gray-600">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-semibold text-white">${job.title}</h4>
                        ${job.urgent ? '<span class="bg-red-600 text-white px-2 py-1 rounded-full text-xs">URGENT</span>' : ''}
                    </div>
                    <p class="text-blue-400 text-sm mb-1">${job.company}</p>
                    <p class="text-green-400 font-semibold mb-3">UGX ${job.salary.toLocaleString()}</p>
                    <div class="flex space-x-2">
                        <button class="group bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white px-4 py-2 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 text-sm">
                            <i class="fas fa-eye mr-1 group-hover:animate-pulse"></i>View
                        </button>
                        <button class="group bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-4 py-2 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 text-sm">
                            <i class="fas fa-heart mr-1 group-hover:animate-bounce"></i>Save
                        </button>
                    </div>
                </div>
            `;
        }

        // Initialize Workplace when section is opened
        function initializeWorkplace() {
            updateProfileScore();
            loadJobCards();
            
            // Load saved alert settings
            const savedAlerts = localStorage.getItem('jobAlerts');
            if (savedAlerts) {
                const alerts = JSON.parse(savedAlerts);
                document.getElementById('alertLocation').value = alerts.location || '';
                document.getElementById('minSalary').value = alerts.minSalary || '';
                document.getElementById('maxSalary').value = alerts.maxSalary || '';
                document.getElementById('alertsToggle').checked = alerts.enabled !== false;
            }
        }

        // --- Job Application Functions ---
        let currentApplicationJob = null;

        function openJobApplicationModal(jobId) {
            // Find the job by ID
            const job = currentJobCards.find(j => j.id == jobId);
            if (!job) {
                showMessage('Job not found', 'error');
                return;
            }

            currentApplicationJob = job;

            // Populate job information in modal
            document.getElementById('applicationJobTitle').textContent = job.title;
            document.getElementById('applicationCompany').textContent = job.company;
            document.getElementById('applicationLocation').textContent = job.location;
            document.getElementById('applicationSalary').textContent = `UGX ${job.salary.toLocaleString()}`;
            document.getElementById('applicationType').textContent = job.type;

            // Set default start date to tomorrow
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            document.getElementById('startDate').value = tomorrow.toISOString().split('T')[0];

            // Clear previous messages
            document.getElementById('applicationMessage').classList.add('hidden');

            // Open modal
            openModal('job-application-modal');
        }

        function submitJobApplication() {
            if (!currentApplicationJob) {
                showApplicationMessage('No job selected for application', 'error');
                return;
            }

            // Get form data
            const formData = {
                jobId: currentApplicationJob.id,
                jobTitle: currentApplicationJob.title,
                company: currentApplicationJob.company,
                applicantName: document.getElementById('applicantName').value.trim(),
                applicantPhone: document.getElementById('applicantPhone').value.trim(),
                applicantEmail: document.getElementById('applicantEmail').value.trim(),
                experience: document.getElementById('experience').value.trim(),
                skills: document.getElementById('skills').value.trim(),
                coverLetter: document.getElementById('coverLetter').value.trim(),
                startDate: document.getElementById('startDate').value,
                expectedSalary: document.getElementById('expectedSalary').value,
                additionalInfo: document.getElementById('additionalInfo').value.trim()
            };

            // Validate required fields
            if (!formData.applicantName || !formData.applicantPhone || !formData.coverLetter || !formData.startDate) {
                showApplicationMessage('Please fill in all required fields', 'error');
                return;
            }

            // Validate phone number format
            const phoneRegex = /^(\+256|0)[0-9]{9}$/;
            if (!phoneRegex.test(formData.applicantPhone.replace(/\s/g, ''))) {
                showApplicationMessage('Please enter a valid Ugandan phone number', 'error');
                return;
            }

            // Show loading state
            const submitBtn = document.querySelector('button[onclick="submitJobApplication()"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Submitting Application...';
            submitBtn.disabled = true;

            // Simulate application submission
            setTimeout(() => {
                // Save application to localStorage (simulate sending to company)
                saveJobApplication(formData);

                // Show success message
                showMessage(`Application submitted successfully to ${currentApplicationJob.company}!`, 'success');
                
                // Close modal
                closeModal('job-application-modal');

                // Reset form
                document.getElementById('jobApplicationForm').reset();

                // Restore button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;

                // Add to user's applications list
                addToMyApplications(formData);

            }, 2000);
        }

        function saveJobApplication(applicationData) {
            // Get existing applications
            const existingApplications = JSON.parse(localStorage.getItem('userApplications') || '[]');
            
            // Add new application with timestamp
            const newApplication = {
                ...applicationData,
                applicationId: Date.now(),
                submittedAt: new Date().toISOString(),
                status: 'pending'
            };
            
            existingApplications.push(newApplication);
            
            // Save back to localStorage
            localStorage.setItem('userApplications', JSON.stringify(existingApplications));
            
            console.log('Application saved:', newApplication);
        }

        function addToMyApplications(applicationData) {
            // This would typically update the My Applications section
            // For now, we'll just log it
            console.log('Added to My Applications:', applicationData);
            
            // If the applications section is currently loaded, refresh it
            const applicationsContent = document.getElementById('applications-content');
            if (applicationsContent && !applicationsContent.classList.contains('hidden')) {
                loadMyApplications();
            }
        }

        function showApplicationMessage(message, type) {
            const messageDiv = document.getElementById('applicationMessage');
            messageDiv.className = `mb-4 text-sm ${type === 'success' ? 'text-green-400' : 'text-red-400'}`;
            messageDiv.innerHTML = `<i class="fas fa-${type === 'success' ? 'check' : 'exclamation-triangle'} mr-1"></i>${message}`;
            messageDiv.classList.remove('hidden');
            
            // Auto-hide after 5 seconds
            setTimeout(() => {
                messageDiv.classList.add('hidden');
            }, 5000);
        }

        // --- Modal Control Functions ---
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.style.display = 'flex';
            }
        }
        
        // Worker Profile Dropdown Functions
        function toggleWorkerProfileDropdown() {
            const dropdown = document.getElementById('workerProfileDropdown');
            dropdown.classList.toggle('hidden');
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('workerProfileDropdown');
            const button = event.target.closest('button[onclick="toggleWorkerProfileDropdown()"]');
            
            if (!button && dropdown && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
        
        // Edit Worker Profile
        function openWorkerProfileEdit() {
            document.getElementById('workerProfileDropdown').classList.add('hidden');
            alert('Edit Profile feature - Coming soon!');
            // Will open comprehensive profile edit modal
        }
        
        // Change Worker Password
        function openWorkerPasswordChange() {
            document.getElementById('workerProfileDropdown').classList.add('hidden');
            alert('Change Password feature - Coming soon!');
            // Will open password change modal
        }
        
        // Manage Skills
        function openSkillsManager() {
            document.getElementById('workerProfileDropdown').classList.add('hidden');
            // Navigate to skills section
            const skillsLink = document.querySelector('[data-content="skills"]');
            if (skillsLink) skillsLink.click();
        }
        
        // Availability Settings
        function openAvailabilitySettings() {
            document.getElementById('workerProfileDropdown').classList.add('hidden');
            alert('Availability Settings - Coming soon!');
            // Will open availability status modal
        }
        
        // Work History
        function openWorkHistory() {
            document.getElementById('workerProfileDropdown').classList.add('hidden');
            alert('Work History - Coming soon!');
            // Will open work history modal
        }
        
        // Ratings & Reviews
        function openRatingsReviews() {
            document.getElementById('workerProfileDropdown').classList.add('hidden');
            alert('Ratings & Reviews - Coming soon!');
            // Will open ratings and reviews modal
        }
        
        // Account Settings
        function openAccountSettings() {
            document.getElementById('workerProfileDropdown').classList.add('hidden');
            // Navigate to settings section
            const settingsLink = document.querySelector('a[href="{{ route('settings') }}"]');
            if (settingsLink) settingsLink.click();
        }
        
        // Delete Account
        function openDeleteAccount() {
            document.getElementById('workerProfileDropdown').classList.add('hidden');
            if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
                alert('Delete Account feature - Coming soon!');
                // Will handle account deletion
            }
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.style.display = 'none';
            }
        }

        // --- Sidebar and Content Switching ---
        document.addEventListener('DOMContentLoaded', () => {
            // Load available skills for dropdown
            loadAvailableSkills();
            
            // Mobile menu toggle
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const sidebar = document.getElementById('sidebar');
            
            if (mobileMenuBtn && sidebar) {
                mobileMenuBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    sidebar.classList.toggle('-translate-x-full');
                });
            } else {
                console.error('Mobile menu elements not found:', { mobileMenuBtn, sidebar });
            }
            
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', (e) => {
                if (window.innerWidth < 1024) {
                    if (!sidebar.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                        sidebar.classList.add('-translate-x-full');
                    }
                }
            });
            
            const sidebarLinks = document.querySelectorAll('.sidebar-link');
            const contentSections = document.querySelectorAll('.content-section');

            function showContent(contentId) {
                contentSections.forEach(section => {
                    section.classList.add('hidden');
                });
                const targetContent = document.getElementById(contentId + '-content');
                if (targetContent) {
                    targetContent.classList.remove('hidden');
                }
            }

            function updateSidebar(activeLink) {
                sidebarLinks.forEach(link => {
                    link.classList.remove('sidebar-active');
                    link.classList.add('text-gray-300', 'hover:bg-gray-700');
                });
                activeLink.classList.add('sidebar-active');
            }

            sidebarLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const contentId = link.getAttribute('data-content');
                    if (contentId) {
                        showContent(contentId);
                        updateSidebar(link);
                        
                        // Close mobile menu when link is clicked
                        if (window.innerWidth < 1024) {
                            sidebar.classList.add('-translate-x-full');
                        }
                        
                        // Load saved jobs when saved jobs section is opened
                        if (contentId === 'saved') {
                            loadSavedJobs();
                            hideFloatingIcon();
                        }
                        // Load applications when applications section is opened
                        else if (contentId === 'applications') {
                            loadMyApplications();
                            showFloatingIcon();
                        }
                        // Initialize workplace when workplace section is opened
                        else if (contentId === 'workplace') {
                            initializeWorkplace();
                            hideFloatingIcon();
                        }
                        // Hide floating icon for other sections
                        else {
                            hideFloatingIcon();
                        }
                    }
                });
            });

            const defaultLink = document.querySelector('[data-content="profile"]');
            if (defaultLink) {
                updateSidebar(defaultLink);
                showContent('profile');
            }

            // --- WhatsApp-Style Chat Functionality ---
            let currentChatUserId = null;
            let messageRefreshInterval = null;
            
            // Load conversations when messages section is opened
            const messagesLink = document.querySelector('[data-content="messages"]');
            if (messagesLink) {
                messagesLink.addEventListener('click', function(e) {
                    console.log('Messages link clicked');
                    // Load conversations every time messages is clicked
                    setTimeout(() => {
                        loadExistingConversations();
                        updateUnreadMessageCount();
                    }, 200);
                });
            }
            
            // Load unread count on page load and refresh every 10 seconds
            updateUnreadMessageCount();
            setInterval(updateUnreadMessageCount, 10000);
            
            function updateUnreadMessageCount() {
                fetch('/api/messages/unread-count', {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Unread message count:', data.count);
                    const badge = document.getElementById('messagesBadge');
                    if (badge) {
                        if (data.count > 0) {
                            badge.textContent = data.count > 99 ? '99+' : data.count;
                            badge.classList.remove('hidden');
                        } else {
                            badge.classList.add('hidden');
                        }
                    }
                })
                .catch(error => console.error('Error loading unread count:', error));
            }
            
            function loadExistingConversations() {
                console.log('Loading existing conversations...');
                const conversationsList = document.getElementById('conversationsList');
                
                // Show loading
                conversationsList.innerHTML = `
                    <div class="flex justify-center items-center py-8">
                        <i class="fas fa-spinner fa-spin text-2xl text-blue-400"></i>
                        <span class="ml-2 text-gray-300">Loading chats...</span>
                    </div>
                `;
                
                fetch('/api/messages/users', {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(users => {
                    console.log('Users loaded:', users);
                    const employers = users.filter(u => u.role === 'employer' || u.role === 'admin');
                    
                    if (employers.length === 0) {
                        conversationsList.innerHTML = `
                            <div class="p-8 text-center text-gray-500">
                                <i class="fas fa-comments text-4xl mb-3 text-gray-600"></i>
                                <p class="text-sm">No employers available</p>
                            </div>
                        `;
                        return;
                    }
                    
                    // Load conversations for each employer
                    let hasConversations = false;
                    conversationsList.innerHTML = '';
                    
                    employers.forEach(employer => {
                        fetch(`/api/messages/conversations/${employer.id}`, {
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.messages && data.messages.length > 0) {
                                hasConversations = true;
                                const lastMsg = data.messages[data.messages.length - 1];
                                addConversationToList(employer, lastMsg);
                            }
                        })
                        .catch(err => console.error('Error loading conversation:', err));
                    });
                    
                    // After a short delay, check if we have conversations
                    setTimeout(() => {
                        if (!hasConversations && conversationsList.children.length === 0) {
                            conversationsList.innerHTML = `
                                <div class="p-8 text-center text-gray-500">
                                    <i class="fas fa-comments text-4xl mb-3 text-gray-600"></i>
                                    <p class="text-sm">No conversations yet</p>
                                    <p class="text-xs mt-1">Click + to start chatting</p>
                                </div>
                            `;
                        }
                    }, 1000);
                })
                .catch(error => {
                    console.error('Error loading conversations:', error);
                    conversationsList.innerHTML = `
                        <div class="p-8 text-center text-gray-500">
                            <i class="fas fa-exclamation-triangle text-4xl mb-3 text-red-600"></i>
                            <p class="text-sm">Error loading conversations</p>
                        </div>
                    `;
                });
            }
            
            function addConversationToList(employer, lastMessage) {
                const conversationsList = document.getElementById('conversationsList');
                
                // Remove "no conversations" message if it exists
                const noConvMsg = conversationsList.querySelector('.text-center');
                if (noConvMsg) {
                    conversationsList.innerHTML = '';
                }
                
                // Check if already exists
                if (document.querySelector(`[data-user-id="${employer.id}"]`)) {
                    return;
                }
                
                const avatarHtml = employer.profile_picture 
                    ? `<img src="/storage/${employer.profile_picture}" class="w-10 h-10 rounded-full object-cover">`
                    : `<div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">${employer.name.charAt(0)}</div>`;
                
                const convItem = document.createElement('div');
                convItem.setAttribute('data-user-id', employer.id);
                convItem.className = 'p-3 hover:bg-gray-800 cursor-pointer border-b border-gray-800 transition';
                convItem.innerHTML = `
                    <div class="flex items-center space-x-3">
                        ${avatarHtml}
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-white truncate">${employer.name}</p>
                            <p class="text-xs text-gray-400 truncate">${lastMessage ? lastMessage.message.substring(0, 30) + (lastMessage.message.length > 30 ? '...' : '') : 'Start chatting'}</p>
                        </div>
                        ${lastMessage ? `<div class="text-xs text-gray-500">${new Date(lastMessage.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</div>` : ''}
                    </div>
                `;
                convItem.onclick = () => startChat(employer.id, employer.name, employer.role, employer.profile_picture);
                conversationsList.appendChild(convItem);
            }
            
            window.openNewChatModal = function() {
                openModal('new-chat-modal');
                loadEmployersForChat();
            }
            
            function loadEmployersForChat() {
                fetch('/api/messages/users', {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(users => {
                    const employersList = document.getElementById('employersList');
                    const employers = users.filter(u => u.role === 'employer' || u.role === 'admin');
                    
                    if (employers.length === 0) {
                        employersList.innerHTML = '<p class="text-center text-gray-400 py-4">No employers available</p>';
                        return;
                    }
                    
                    employersList.innerHTML = employers.map(employer => `
                        <div onclick="startChat(${employer.id}, '${employer.name.replace(/'/g, "\\'")}', '${employer.role}', '${employer.profile_picture || ''}')" 
                             class="flex items-center space-x-3 p-3 hover:bg-gray-700 rounded-lg cursor-pointer transition">
                            ${employer.profile_picture 
                                ? `<img src="/storage/${employer.profile_picture}" class="w-10 h-10 rounded-full object-cover">`
                                : `<div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">${employer.name.charAt(0)}</div>`
                            }
                            <div class="flex-1">
                                <p class="font-medium text-white">${employer.name}</p>
                                <p class="text-xs text-gray-400 capitalize">${employer.role}</p>
                            </div>
                        </div>
                    `).join('');
                })
                .catch(error => {
                    console.error('Error loading employers:', error);
                    document.getElementById('employersList').innerHTML = '<p class="text-center text-red-400 py-4">Error loading employers</p>';
                });
            }
            
            window.startChat = function(userId, userName, userRole, profilePicture) {
                closeModal('new-chat-modal');
                currentChatUserId = userId;
                
                // Clear any existing refresh interval
                if (messageRefreshInterval) {
                    clearInterval(messageRefreshInterval);
                }
                
                // Update chat header
                document.getElementById('chatHeader').classList.remove('hidden');
                document.getElementById('chatName').textContent = userName;
                document.getElementById('chatRole').textContent = userRole.charAt(0).toUpperCase() + userRole.slice(1);
                
                const avatarHtml = profilePicture 
                    ? `<img src="/storage/${profilePicture}" class="w-10 h-10 rounded-full object-cover">`
                    : `<div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">${userName.charAt(0)}</div>`;
                document.getElementById('chatAvatar').innerHTML = avatarHtml;
                
                // Show chat area
                document.getElementById('noChatSelected').classList.add('hidden');
                document.getElementById('messagesContainer').classList.remove('hidden');
                document.getElementById('messageInput').classList.remove('hidden');
                document.getElementById('currentReceiverId').value = userId;
                
                // Add to conversations list if not exists
                addToConversationsList(userId, userName, userRole, profilePicture);
                
                // Load messages
                loadChatMessages(userId);
                
                // Start auto-refresh for new messages (every 3 seconds)
                messageRefreshInterval = setInterval(() => {
                    loadChatMessages(userId, true);
                }, 3000);
            }
            
            function addToConversationsList(userId, userName, userRole, profilePicture) {
                const conversationsList = document.getElementById('conversationsList');
                
                // Check if already exists
                if (document.querySelector(`[data-user-id="${userId}"]`)) {
                    return;
                }
                
                // Remove "no conversations" message
                const noConvMsg = conversationsList.querySelector('.text-center');
                if (noConvMsg) {
                    conversationsList.innerHTML = '';
                }
                
                const avatarHtml = profilePicture 
                    ? `<img src="/storage/${profilePicture}" class="w-10 h-10 rounded-full object-cover">`
                    : `<div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">${userName.charAt(0)}</div>`;
                
                const convItem = document.createElement('div');
                convItem.setAttribute('data-user-id', userId);
                convItem.className = 'p-3 hover:bg-gray-800 cursor-pointer border-b border-gray-800 transition';
                convItem.innerHTML = `
                    <div class="flex items-center space-x-3">
                        ${avatarHtml}
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-white truncate">${userName}</p>
                            <p class="text-xs text-gray-400 truncate capitalize">${userRole}</p>
                        </div>
                    </div>
                `;
                convItem.onclick = () => startChat(userId, userName, userRole, profilePicture);
                conversationsList.appendChild(convItem);
            }
            
            function loadChatMessages(userId, isRefresh = false) {
                fetch(`/api/messages/conversations/${userId}`, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    displayMessages(data.messages || [], isRefresh);
                    // Update badge count after loading messages (they get marked as read)
                    if (!isRefresh) {
                        setTimeout(updateUnreadMessageCount, 500);
                    }
                })
                .catch(error => {
                    console.error('Error loading messages:', error);
                    if (!isRefresh) {
                        document.getElementById('messagesContainer').innerHTML = '<p class="text-center text-gray-400">Error loading messages</p>';
                    }
                });
            }
            
            function displayMessages(messages, isRefresh = false) {
                const container = document.getElementById('messagesContainer');
                const currentUserId = {{ Auth::id() ?? 'null' }};
                
                // Store current scroll position
                const wasAtBottom = container.scrollHeight - container.scrollTop <= container.clientHeight + 100;
                
                if (messages.length === 0) {
                    container.innerHTML = '<p class="text-center text-gray-400 py-4">No messages yet. Start the conversation!</p>';
                    return;
                }
                
                container.innerHTML = messages.map(msg => {
                    const isOwn = msg.sender_id === currentUserId;
                    const time = new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                    
                    return `
                        <div class="flex ${isOwn ? 'justify-end' : 'justify-start'}">
                            <div class="max-w-[70%] ${isOwn ? 'bg-blue-600' : 'bg-gray-700'} rounded-lg px-4 py-2 shadow">
                                <p class="text-white text-sm break-words">${escapeHtml(msg.message)}</p>
                                <p class="text-xs ${isOwn ? 'text-blue-100' : 'text-gray-400'} mt-1 text-right">${time}</p>
                            </div>
                        </div>
                    `;
                }).join('');
                
                // Scroll to bottom if was at bottom or if it's a new message
                if (wasAtBottom || !isRefresh) {
                    container.scrollTop = container.scrollHeight;
                }
            }
            
            // Send message
            document.getElementById('sendMessageForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const messageText = document.getElementById('messageText').value.trim();
                const receiverId = document.getElementById('currentReceiverId').value;
                
                if (!messageText || !receiverId) return;
                
                fetch('/api/messages/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        receiver_id: receiverId,
                        message: messageText
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('messageText').value = '';
                        
                        // Reload messages to show the sent message
                        loadChatMessages(receiverId);
                    }
                })
                .catch(error => {
                    console.error('Error sending message:', error);
                    alert('Failed to send message');
                });
            });
            
            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }
            
            // Stop refresh when switching away from messages
            document.querySelector('[data-content="messages"]').addEventListener('click', function() {
                // Messages section is being opened
            });
            
            // Stop refresh when leaving messages section
            document.querySelectorAll('.sidebar-link:not([data-content="messages"])').forEach(link => {
                link.addEventListener('click', function() {
                    if (messageRefreshInterval) {
                        clearInterval(messageRefreshInterval);
                        messageRefreshInterval = null;
                    }
                });
            });

            // --- Old Messages Functionality ---
            window.openNewMessageModal = function() {
                openModal('new-message-modal');
                loadEmployers();
            }

            window.loadEmployers = function() {
                fetch('/api/messages/users', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(users => {
                    const employerSelect = document.getElementById('employerSelect');
                    employerSelect.innerHTML = '<option value="">Select an employer...</option>';
                    
                    const employers = users.filter(user => user.role === 'employer');
                    employers.forEach(employer => {
                        const option = document.createElement('option');
                        option.value = employer.id;
                        option.textContent = `${employer.name} (${employer.email})`;
                        employerSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error loading employers:', error);
                    document.getElementById('employerSelect').innerHTML = '<option value="">Error loading employers</option>';
                });
            }

            window.handleRecipientChange = function() {
                const recipientSelect = document.getElementById('recipientSelect');
                const employerSelection = document.getElementById('employerSelection');
                
                if (recipientSelect.value === 'employer') {
                    employerSelection.classList.remove('hidden');
                } else {
                    employerSelection.classList.add('hidden');
                }
            }

            window.updateCharCount = function() {
                const messageContent = document.getElementById('messageContent');
                const charCount = document.getElementById('messageCharCount');
                charCount.textContent = messageContent.value.length;
            }

            window.sendNewMessage = function() {
                const recipientType = document.getElementById('recipientSelect').value;
                const employerId = document.getElementById('employerSelect').value;
                const subject = document.getElementById('messageSubject').value.trim();
                const message = document.getElementById('messageContent').value.trim();
                
                if (!recipientType || !subject || !message) {
                    showNewMessageStatus('Please fill in all required fields.', 'error');
                    return;
                }
                
                if (recipientType === 'employer' && !employerId) {
                    showNewMessageStatus('Please select an employer.', 'error');
                    return;
                }
                
                let receiverId;
                if (recipientType === 'admin') {
                    receiverId = 1; // Assuming admin has ID 1
                } else {
                    receiverId = employerId;
                }
                
                const sendButton = event.target;
                const originalText = sendButton.innerHTML;
                sendButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Sending...';
                sendButton.disabled = true;
                
                fetch('/api/messages/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        receiver_id: receiverId,
                        message: `Subject: ${subject}\n\n${message}`
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNewMessageStatus('Message sent successfully!', 'success');
                        document.getElementById('newMessageForm').reset();
                        document.getElementById('employerSelection').classList.add('hidden');
                        document.getElementById('messageCharCount').textContent = '0';
                        
                        setTimeout(() => {
                            closeModal('new-message-modal');
                        }, 1500);
                    } else {
                        showNewMessageStatus(data.error || 'Failed to send message', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error sending message:', error);
                    showNewMessageStatus('Failed to send message. Please try again.', 'error');
                })
                .finally(() => {
                    sendButton.innerHTML = originalText;
                    sendButton.disabled = false;
                });
            }

            window.showNewMessageStatus = function(message, type) {
                const statusDiv = document.getElementById('newMessageStatus');
                statusDiv.className = `mb-4 text-sm ${type === 'success' ? 'text-green-400' : 'text-red-400'}`;
                statusDiv.innerHTML = `<i class="fas fa-${type === 'success' ? 'check' : 'exclamation-triangle'} mr-1"></i>${message}`;
                statusDiv.classList.remove('hidden');
            }

            window.openMessagesHistory = function() {
                openModal('messages-history-modal');
                loadMessagesHistory();
            }

            window.loadMessagesHistory = function() {
                const content = document.getElementById('messagesHistoryContent');
                content.innerHTML = `
                    <div class="flex justify-center items-center py-8">
                        <i class="fas fa-spinner fa-spin text-2xl text-blue-400"></i>
                        <span class="ml-2 text-gray-300">Loading message history...</span>
                    </div>
                `;
                
                setTimeout(() => {
                    content.innerHTML = `
                        <div class="space-y-4">
                            <div class="bg-gray-900 p-4 rounded-lg">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-semibold text-white">To: Admin</h4>
                                    <span class="text-xs text-gray-400">2 hours ago</span>
                                </div>
                                <p class="text-sm text-gray-300 mb-2"><strong>Subject:</strong> Question about job application</p>
                                <p class="text-sm text-gray-400">Hello, I have a question about my recent job application...</p>
                            </div>
                            <div class="bg-gray-900 p-4 rounded-lg">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-semibold text-white">To: ABC Construction Ltd</h4>
                                    <span class="text-xs text-gray-400">1 day ago</span>
                                </div>
                                <p class="text-sm text-gray-300 mb-2"><strong>Subject:</strong> Application follow-up</p>
                                <p class="text-sm text-gray-400">Thank you for considering my application for the construction helper position...</p>
                            </div>
                            <div class="text-center py-4 text-gray-500">
                                <p class="text-sm">No more messages to display</p>
                            </div>
                        </div>
                    `;
                }, 1000);
            }

            // Event listeners for messages functionality
        });

        // Modern Notification System
        function showModernNotification(message, type = 'info', showRefreshOption = false) {
            // Remove any existing notifications
            const existingNotification = document.getElementById('modern-notification');
            if (existingNotification) {
                existingNotification.remove();
            }

            // Create notification modal
            const modal = document.createElement('div');
            modal.id = 'modern-notification';
            modal.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm';
            
            // Determine colors and icons based on type
            const typeConfig = {
                success: {
                    bgColor: 'from-green-500 to-emerald-600',
                    icon: 'fa-check-circle',
                    borderColor: 'border-green-200'
                },
                error: {
                    bgColor: 'from-red-500 to-pink-600',
                    icon: 'fa-times-circle',
                    borderColor: 'border-red-200'
                },
                warning: {
                    bgColor: 'from-yellow-500 to-orange-600',
                    icon: 'fa-exclamation-triangle',
                    borderColor: 'border-yellow-200'
                },
                info: {
                    bgColor: 'from-blue-500 to-indigo-600',
                    icon: 'fa-info-circle',
                    borderColor: 'border-blue-200'
                }
            };

            const config = typeConfig[type] || typeConfig.info;

            modal.innerHTML = `
                <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="notification-content">
                    <div class="p-6">
                        <!-- Header -->
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br ${config.bgColor} rounded-full flex items-center justify-center mr-4">
                                <i class="fas ${config.icon} text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">${type.charAt(0).toUpperCase() + type.slice(1)}</h3>
                                <p class="text-sm text-gray-500">Profile Update</p>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="mb-6">
                            <div class="bg-gradient-to-r from-gray-50 to-gray-50 rounded-lg p-4 border ${config.borderColor}">
                                <p class="text-gray-800 leading-relaxed">${message}</p>
                            </div>
                            ${showRefreshOption ? `
                                <div class="mt-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4 border border-blue-200">
                                    <div class="flex items-center text-blue-800">
                                        <i class="fas fa-sync-alt mr-2 text-blue-600"></i>
                                        <span class="font-medium">Would you like to refresh the page to see if the image appears?</span>
                                    </div>
                                </div>
                            ` : ''}
                        </div>

                        <!-- Actions -->
                        <div class="flex space-x-3">
                            ${showRefreshOption ? `
                                <button onclick="closeNotification()" class="flex-1 px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200">
                                    <i class="fas fa-times mr-2"></i>Close
                                </button>
                                <button onclick="refreshPage()" class="flex-1 px-4 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg">
                                    <i class="fas fa-sync-alt mr-2"></i>Refresh Page
                                </button>
                            ` : `
                                <button onclick="closeNotification()" class="w-full px-4 py-3 bg-gradient-to-r ${config.bgColor} hover:opacity-90 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg">
                                    <i class="fas fa-check mr-2"></i>Got it!
                                </button>
                            `}
                        </div>
                    </div>
                </div>
            `;

            document.body.appendChild(modal);

            // Animate modal in
            setTimeout(() => {
                const content = document.getElementById('notification-content');
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);

            // Auto-close after 5 seconds for success messages
            if (type === 'success' && !showRefreshOption) {
                setTimeout(() => {
                    closeNotification();
                }, 5000);
            }

            // Close on backdrop click
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeNotification();
                }
            });

            // Close on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeNotification();
                }
            });
        }

        function closeNotification() {
            const modal = document.getElementById('modern-notification');
            if (modal) {
                const content = document.getElementById('notification-content');
                content.classList.add('scale-95', 'opacity-0');
                content.classList.remove('scale-100', 'opacity-100');
                
                setTimeout(() => {
                    modal.remove();
                }, 300);
            }
        }

        function refreshPage() {
            location.reload();
        }

        // Notification functions
        async function markAsRead(notificationId) {
            try {
                const response = await fetch('/api/notifications/mark-read', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ notification_ids: [notificationId] })
                });

                if (response.ok) {
                    const notificationItem = document.querySelector(`[data-notification-id="${notificationId}"]`);
                    if (notificationItem) {
                        notificationItem.classList.remove('border-l-4', 'border-blue-500');
                        const newBadge = notificationItem.querySelector('.bg-blue-500');
                        if (newBadge) newBadge.remove();
                        const markButton = notificationItem.querySelector('button[onclick*="markAsRead"]');
                        if (markButton) markButton.remove();
                    }
                    
                    // Update badge count
                    updateNotificationBadge();
                }
            } catch (error) {
                console.error('Error marking notification as read:', error);
            }
        }

        async function markAllAsRead() {
            try {
                const response = await fetch('/api/notifications/mark-all-read', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                if (response.ok) {
                    // Remove all "new" indicators
                    document.querySelectorAll('.notification-item').forEach(item => {
                        item.classList.remove('border-l-4', 'border-blue-500');
                        const newBadge = item.querySelector('.bg-blue-500');
                        if (newBadge) newBadge.remove();
                        const markButton = item.querySelector('button[onclick*="markAsRead"]');
                        if (markButton) markButton.remove();
                    });
                    
                    // Update badge count
                    updateNotificationBadge();
                }
            } catch (error) {
                console.error('Error marking all notifications as read:', error);
            }
        }

        function updateNotificationBadge() {
            const badge = document.querySelector('[data-content="notifications"] .bg-red-500');
            if (badge) {
                badge.remove();
            }
        }

        // Event listeners for message modal
        document.addEventListener('DOMContentLoaded', function() {
            const recipientSelect = document.getElementById('recipientSelect');
            if (recipientSelect) {
                recipientSelect.addEventListener('change', handleRecipientChange);
            }
            
            const messageContent = document.getElementById('messageContent');
            if (messageContent) {
                messageContent.addEventListener('input', updateCharCount);
            }
            
            // Check for approval notifications on page load
            checkApprovalNotifications();
            
            // Check every 30 seconds for new approvals
            setInterval(checkApprovalNotifications, 30000);
        });
        
        // Function to check for approval notifications
        function checkApprovalNotifications() {
            fetch('/api/check-approval-notifications', {
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(notifications => {
                if (notifications.length > 0) {
                    // Show the first unread approval notification
                    const notification = notifications[0];
                    showCongratsModal(notification);
                }
            })
            .catch(error => console.error('Error checking approval notifications:', error));
        }
        
        // Function to show congratulations modal
        function showCongratsModal(notification) {
            document.getElementById('congratsJobTitle').textContent = notification.job_title;
            document.getElementById('congratsEmployerName').textContent = notification.employer_name;
            document.getElementById('congratsMessage').textContent = 
                `Your application for ${notification.job_title} has been approved by ${notification.employer_name}!`;
            
            // Store notification ID to mark as read later
            window.currentApprovalNotificationId = notification.id;
            
            // Show modal
            document.getElementById('congratulations-modal').style.display = 'flex';
            
            // Play a success sound (optional)
            // new Audio('/sounds/success.mp3').play();
        }
        
        // Function to close congratulations modal
        function closeCongratsModal() {
            document.getElementById('congratulations-modal').style.display = 'none';
            
            // Mark notification as read
            if (window.currentApprovalNotificationId) {
                fetch(`/api/mark-approval-read/${window.currentApprovalNotificationId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Notification marked as read');
                    window.currentApprovalNotificationId = null;
                })
                .catch(error => console.error('Error marking notification as read:', error));
            }
        }
    </script>

    <!-- New Message Modal -->
    <div id="new-message-modal" class="modal-overlay">
        <div class="bg-gray-800 rounded-xl shadow-2xl w-full max-w-2xl mx-4 my-4 soft-shadow relative max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-gray-800 p-6 pb-4 border-b border-gray-700 rounded-t-xl">
                <h2 class="text-2xl font-bold text-blue-400">
                    <i class="fas fa-envelope mr-2"></i>
                    New Message
                </h2>
                <button onclick="closeModal('new-message-modal')" 
                        class="absolute top-4 right-4 text-gray-400 hover:text-white transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div class="p-6 pt-4">
                <form id="newMessageForm">
                    <!-- Recipient Selection -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Send To</label>
                        <select id="recipientSelect" class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-xl focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">Select recipient...</option>
                            <option value="admin">Admin</option>
                            <option value="employer">Employers</option>
                        </select>
                    </div>

                    <!-- Specific User Selection (for employers) -->
                    <div id="employerSelection" class="mb-4 hidden">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Select Employer</label>
                        <select id="employerSelect" class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Loading employers...</option>
                        </select>
                    </div>

                    <!-- Subject -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Subject</label>
                        <input type="text" id="messageSubject" placeholder="Enter message subject..." 
                               class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-xl focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400" required>
                    </div>

                    <!-- Message -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Message</label>
                        <textarea id="messageContent" rows="6" placeholder="Type your message here..." 
                                  class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-xl focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400 resize-none" 
                                  maxlength="1000" required></textarea>
                        <div class="text-xs text-gray-500 mt-1">
                            <span id="messageCharCount">0</span>/1000 characters
                        </div>
                    </div>

                    <div id="newMessageStatus" class="mb-4 text-sm hidden"></div>
                </form>
            </div>
            
            <div class="sticky bottom-0 bg-gray-800 p-6 pt-4 border-t border-gray-700 rounded-b-xl">
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeModal('new-message-modal')" 
                            class="px-6 py-2 border border-gray-600 text-gray-300 rounded-xl hover:bg-gray-700 transition">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </button>
                    <button type="button" onclick="sendNewMessage()"
                            class="px-6 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-semibold shadow-md">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Send Message
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Messages History Modal -->
    <div id="messages-history-modal" class="modal-overlay">
        <div class="bg-gray-800 rounded-xl shadow-2xl w-full max-w-4xl mx-4 my-4 soft-shadow relative max-h-[90vh] overflow-hidden">
            <div class="sticky top-0 bg-gray-800 p-4 border-b border-gray-700 rounded-t-xl flex justify-between items-center">
                <h2 class="text-xl font-bold text-blue-400">
                    <i class="fas fa-history mr-2"></i>
                    Message History
                </h2>
                <button onclick="closeModal('messages-history-modal')" 
                        class="text-gray-400 hover:text-white transition bg-gray-700 hover:bg-gray-600 rounded-lg p-2">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            
            <div class="p-4 overflow-y-auto" style="max-height: calc(90vh - 80px);">
                <div id="messagesHistoryContent">
                    <div class="flex justify-center items-center py-8">
                        <i class="fas fa-spinner fa-spin text-2xl text-blue-400"></i>
                        <span class="ml-2 text-gray-300">Loading message history...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Top Bar Dropdown Functions for Worker
        function toggleWorkerNotifications() {
            const dropdown = document.getElementById('workerNotificationsDropdown');
            dropdown.classList.toggle('hidden');
            closeOtherWorkerDropdowns('workerNotificationsDropdown');
        }
        
        function toggleWorkerQuickActions() {
            const dropdown = document.getElementById('workerQuickActionsDropdown');
            dropdown.classList.toggle('hidden');
            closeOtherWorkerDropdowns('workerQuickActionsDropdown');
        }
        
        function toggleWorkerTopBarProfile() {
            const dropdown = document.getElementById('workerTopBarProfileDropdown');
            dropdown.classList.toggle('hidden');
            closeOtherWorkerDropdowns('workerTopBarProfileDropdown');
        }
        
        function closeOtherWorkerDropdowns(exceptId) {
            const dropdowns = ['workerNotificationsDropdown', 'workerQuickActionsDropdown', 'workerTopBarProfileDropdown', 'themeMenuDropdown'];
            dropdowns.forEach(id => {
                if (id !== exceptId) {
                    const dropdown = document.getElementById(id);
                    if (dropdown) dropdown.classList.add('hidden');
                }
            });
        }
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.relative')) {
                closeOtherWorkerDropdowns('');
            }
        });
        
        // Theme Management Functions
        function toggleThemeMenu() {
            const dropdown = document.getElementById('themeMenuDropdown');
            dropdown.classList.toggle('hidden');
            closeOtherWorkerDropdowns('themeMenuDropdown');
        }
        
        function setTheme(theme) {
            localStorage.setItem('theme', theme);
            applyTheme(theme);
            updateThemeUI(theme);
            toggleThemeMenu();
        }
        
        function applyTheme(theme) {
            const html = document.documentElement;
            
            if (theme === 'dark') {
                html.classList.add('dark');
                updateThemeIcon('moon');
            } else if (theme === 'light') {
                html.classList.remove('dark');
                updateThemeIcon('sun');
            } else if (theme === 'system') {
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (prefersDark) {
                    html.classList.add('dark');
                    updateThemeIcon('desktop');
                } else {
                    html.classList.remove('dark');
                    updateThemeIcon('desktop');
                }
            }
        }
        
        function updateThemeIcon(icon) {
            const themeIcon = document.getElementById('theme-icon');
            if (themeIcon) {
                themeIcon.className = `fas fa-${icon} text-gray-400 group-hover:text-${icon === 'sun' ? 'yellow' : icon === 'moon' ? 'indigo' : 'gray'}-500 transition-colors`;
            }
        }
        
        function updateThemeUI(theme) {
            // Hide all checkmarks
            document.querySelectorAll('.light-check, .dark-check, .system-check').forEach(el => {
                el.classList.add('hidden');
            });
            
            // Show the active theme checkmark
            const checkmark = document.querySelector(`.${theme}-check`);
            if (checkmark) {
                checkmark.classList.remove('hidden');
            }
        }
        
        // Initialize theme on page load
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme') || 'system';
            applyTheme(savedTheme);
            updateThemeUI(savedTheme);
            
            // Listen for system theme changes
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                const currentTheme = localStorage.getItem('theme');
                if (currentTheme === 'system') {
                    applyTheme('system');
                }
            });
        });
    </script>

    <!-- Logout Confirmation Modal -->
    <div id="logoutModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full transform transition-all scale-95 opacity-0" id="logoutModalContent">
            <!-- Modal Header -->
            <div class="relative bg-gradient-to-r from-green-600 to-teal-600 p-6 text-white rounded-t-2xl overflow-hidden">
                <div class="absolute inset-0 opacity-20">
                    <div class="absolute -top-1/2 -left-1/2 w-full h-full bg-gradient-to-br from-white/20 to-transparent rounded-full blur-3xl animate-blob"></div>
                </div>
                <div class="relative z-10 flex items-center gap-4">
                    <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                        <i class="fas fa-sign-out-alt text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold">Confirm Logout</h3>
                        <p class="text-green-100 text-sm">End your session</p>
                    </div>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <div class="flex items-start gap-4 mb-6">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-green-600 dark:text-green-400 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-800 dark:text-gray-200 font-medium mb-2">Are you sure you want to logout?</p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">This will end your current session and you'll need to login again to access your dashboard.</p>
                    </div>
                </div>

                <!-- Session Info -->
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 mb-6">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Logged in as:</span>
                        <span class="font-medium text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm mt-2">
                        <span class="text-gray-600 dark:text-gray-400">Account type:</span>
                        <span class="font-medium text-gray-800 dark:text-gray-200">Worker</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3">
                    <button onclick="closeLogoutModal()" class="flex-1 px-4 py-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-medium transition-all">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </button>
                    <button onclick="proceedLogout()" class="flex-1 px-4 py-3 bg-gradient-to-r from-green-600 to-teal-600 hover:from-green-700 hover:to-teal-700 text-white rounded-lg font-medium transition-all shadow-lg hover:shadow-xl">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Logout
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Logout modal functions
        function showLogoutModal(event) {
            event.preventDefault();
            
            const modal = document.getElementById('logoutModal');
            const modalContent = document.getElementById('logoutModalContent');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
            
            return false;
        }
        
        function closeLogoutModal() {
            const modal = document.getElementById('logoutModal');
            const modalContent = document.getElementById('logoutModalContent');
            
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 200);
        }
        
        function proceedLogout() {
            const modal = document.getElementById('logoutModalContent');
            modal.innerHTML = `
                <div class="p-12 text-center">
                    <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-green-200 border-t-green-600 mb-4"></div>
                    <p class="text-gray-600 dark:text-gray-400">Logging out...</p>
                </div>
            `;
            
            setTimeout(() => {
                document.getElementById('logoutForm').submit();
            }, 500);
        }
        
        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('logoutModal');
                if (modal && !modal.classList.contains('hidden')) {
                    closeLogoutModal();
                }
            }
        });
        
        // Close modal when clicking outside
        document.getElementById('logoutModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeLogoutModal();
            }
        });
    </script>

</body>
</html>