<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Employer Dashboard - JOB-lyNK</title>
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
                        'blue-dark': '#1e3a8a',
                        'sidebar-bg': '#0f172a',
                        'sidebar-hover': '#1e293b',
                        'sidebar-active': '#3b82f6'
                    },
                    animation: {
                        'slide-in': 'slideIn 0.3s ease-out',
                        'fade-in': 'fadeIn 0.2s ease-out',
                        'bounce-subtle': 'bounceSubtle 0.6s ease-out'
                    },
                    keyframes: {
                        slideIn: {
                            '0%': { transform: 'translateX(-100%)' },
                            '100%': { transform: 'translateX(0)' }
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        },
                        bounceSubtle: {
                            '0%, 20%, 50%, 80%, 100%': { transform: 'translateY(0)' },
                            '40%': { transform: 'translateY(-4px)' },
                            '60%': { transform: 'translateY(-2px)' }
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Essential Functions - Load First -->
    <script>
        // Define essential functions immediately
        window.showContent = function(contentId) {
            console.log('🎯 showContent called with:', contentId);
            
            // Close mobile menu when showing content
            if (window.innerWidth < 1024) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('mobileOverlay');
                if (sidebar) {
                    sidebar.classList.add('-translate-x-full');
                    sidebar.classList.remove('translate-x-0');
                }
                if (overlay) {
                    overlay.classList.add('hidden');
                }
            }
            
            // Hide all content sections
            const allSections = document.querySelectorAll('.content-section');
            allSections.forEach(section => {
                section.style.display = 'none';
                section.classList.add('hidden');
                section.classList.remove('force-display-block');
            });
            
            // Show the requested content
            const targetSection = document.getElementById(contentId + '-content');
            if (targetSection) {
                targetSection.classList.remove('hidden');
                targetSection.classList.add('force-display-block');
                targetSection.style.setProperty('display', 'block', 'important');
                targetSection.style.setProperty('visibility', 'visible', 'important');
                targetSection.style.setProperty('opacity', '1', 'important');
                
                console.log('✅ Content shown:', contentId);
                console.log('📊 Section display:', window.getComputedStyle(targetSection).display);
                return true;
            } else {
                console.error('❌ Content section not found:', contentId + '-content');
                return false;
            }
        };
        
        window.updateSidebar = function(activeContentId) {
            console.log('🎯 updateSidebar called with:', activeContentId);
            
            // Remove active class from all sidebar links
            document.querySelectorAll('.sidebar-link').forEach(link => {
                link.classList.remove('sidebar-active');
            });
            
            // Add active class to the correct link
            const activeLink = document.querySelector(`[data-content="${activeContentId}"]`);
            if (activeLink) {
                activeLink.classList.add('sidebar-active');
                console.log('✅ Sidebar updated for:', activeContentId);
            } else {
                console.error('❌ Sidebar link not found for:', activeContentId);
            }
        };
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        /* Sidebar Styles */
        .sidebar {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }
        
        .sidebar-link {
            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 12px;
            margin: 4px 0;
            cursor: pointer;
        }
        
        .sidebar-link:active {
            transform: translateX(2px) scale(0.98);
        }
        
        .sidebar-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 0;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 2px;
            transition: height 0.3s ease;
        }
        
        .sidebar-link:hover {
            background: rgba(59, 130, 246, 0.1);
            transform: translateX(4px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
        }
        
        .sidebar-link:hover::before {
            height: 24px;
        }
        
        .sidebar-active {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(139, 92, 246, 0.1));
            color: #60a5fa !important;
            transform: translateX(4px);
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.25);
        }
        
        .sidebar-active::before {
            height: 32px;
        }
        
        .sidebar-icon {
            transition: all 0.3s ease;
        }
        
        .sidebar-link:hover .sidebar-icon {
            transform: scale(1.1);
            color: #60a5fa;
        }
        
        .sidebar-active .sidebar-icon {
            color: #60a5fa;
            transform: scale(1.1);
        }
        
        /* Mobile Sidebar */
        .mobile-sidebar-overlay {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }
        
        /* Logo Animation */
        .logo-text {
            background: linear-gradient(135deg, #60a5fa, #a78bfa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Notification Badge */
        .notification-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: linear-gradient(135deg, #ef4444, #f97316);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            border: 2px solid #1f2937;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            animation: bounce-subtle 2s infinite;
            min-width: 20px;
            min-height: 20px;
        }
        
        /* User Profile Section */
        .user-profile {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }
        
        /* Action Buttons */
        .action-btn {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .action-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .action-btn:hover::before {
            left: 100%;
        }
        
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        /* Line Clamp Utility */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        /* Force Display Override for Content Sections */
        .force-display-block {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        /* Application Card Hover Effects */
        .application-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .application-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        /* Status Badge Animations */
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
        
        /* Filter Section Enhancements */
        .filter-section {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: 1px solid #e2e8f0;
        }
        
        /* Empty State Animation */
        .empty-state-icon {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        /* Skill Tags */
        .skill-tag {
            transition: all 0.2s ease;
        }
        
        .skill-tag:hover {
            transform: scale(1.05);
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
        }
        
        /* Mobile Responsive Improvements */
        @media (max-width: 1023px) {
            #sidebar {
                box-shadow: 2px 0 20px rgba(0, 0, 0, 0.5);
            }
            
            .mobile-sidebar-overlay {
                background-color: rgba(0, 0, 0, 0.5);
            }
            
            /* Adjust padding for mobile */
            .content-section {
                padding: 0.5rem;
            }
            
            /* Make cards stack on mobile */
            .grid {
                grid-template-columns: 1fr !important;
            }
        }
        
        /* Ensure proper box-sizing */
        * {
            box-sizing: border-box;
        }
        
        /* Responsive images */
        img {
            max-width: 100%;
            height: auto;
        }
        
        /* Prevent horizontal scroll */
        body {
            overflow-x: hidden;
        }
        
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
            z-index: 0;
        }

        /* Glass Morphism Cards */
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 16px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            background: rgba(255, 255, 255, 0.8);
            transform: translateY(-2px);
            box-shadow: 0 12px 40px 0 rgba(31, 38, 135, 0.2);
        }
        
        /* Ensure content is above background */
        #sidebar, .flex-1 {
            position: relative;
            z-index: 1;
        }
        
        /* Top Bar Dropdown Animations */
        #employerNotificationsDropdown,
        #employerQuickActionsDropdown,
        #employerTopBarProfileDropdown,
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
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            color: #e5e7eb;
        }
        
        .dark .glass-background {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
        }
        
        .dark .glass-background::before {
            background: 
                radial-gradient(circle at 20% 80%, rgba(31, 41, 55, 0.4) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(17, 24, 39, 0.4) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(55, 65, 81, 0.4) 0%, transparent 50%);
        }
        
        .dark .bg-white {
            background-color: #1f2937 !important;
        }
        
        .dark .bg-gray-50 {
            background-color: #111827 !important;
        }
        
        .dark .bg-gray-100 {
            background-color: #1f2937 !important;
        }
        
        .dark .bg-gray-200 {
            background-color: #374151 !important;
        }
        
        .dark .text-gray-700,
        .dark .text-gray-800,
        .dark .text-gray-900 {
            color: #e5e7eb !important;
        }
        
        .dark .text-gray-600 {
            color: #9ca3af !important;
        }
        
        .dark .text-gray-500 {
            color: #6b7280 !important;
        }
        
        .dark .border-gray-200 {
            border-color: #374151 !important;
        }
        
        .dark .border-gray-300 {
            border-color: #4b5563 !important;
        }
        
        .dark .glass-card {
            background: rgba(31, 41, 55, 0.8);
            border: 1px solid rgba(75, 85, 99, 0.3);
        }
        
        .dark .glass-card:hover {
            background: rgba(31, 41, 55, 0.95);
        }
        
        /* Theme dropdown */
        .dark #themeMenuDropdown {
            background-color: #1f2937 !important;
            border-color: #374151 !important;
        }
        
        .dark .theme-option:hover {
            background-color: #374151 !important;
        }
        
        .dark .sidebar {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }
        
        /* Top Bar Dark Mode */
        .dark .sticky.top-0 {
            background-color: rgba(31, 41, 55, 0.95) !important;
            backdrop-filter: blur(12px);
            border-bottom-color: #374151 !important;
        }
        
        .dark #employerNotificationsDropdown,
        .dark #employerQuickActionsDropdown,
        .dark #employerTopBarProfileDropdown {
            background-color: #1f2937 !important;
            border-color: #374151 !important;
        }
        
        .dark #employerGlobalSearch {
            background-color: #111827 !important;
            border-color: #374151 !important;
            color: #e5e7eb !important;
        }
        
        .dark #employerGlobalSearch::placeholder {
            color: #6b7280 !important;
        }
    </style>
</head>
<body class="glass-background">
    <!-- Mobile Menu Button -->
    <button id="mobileMenuBtn" class="lg:hidden fixed top-4 left-4 z-[70] bg-blue-600 text-white p-4 rounded-xl shadow-2xl hover:bg-blue-700 transition-all duration-200 border-2 border-white" 
            onclick="
                console.log('Mobile menu clicked!');
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('mobileOverlay');
                
                if (sidebar.classList.contains('-translate-x-full')) {
                    sidebar.classList.remove('-translate-x-full');
                    sidebar.classList.add('translate-x-0');
                    overlay.classList.remove('hidden');
                    console.log('Menu opened');
                } else {
                    sidebar.classList.add('-translate-x-full');
                    sidebar.classList.remove('translate-x-0');
                    overlay.classList.add('hidden');
                    console.log('Menu closed');
                }
            ">
        <i class="fas fa-bars text-xl"></i>
        <span class="sr-only">Toggle Menu</span>
    </button>

    <!-- Mobile Notification Button -->
    <button id="mobileNotificationBtn" class="lg:hidden fixed top-4 right-4 z-[70] bg-blue-600 text-white p-4 rounded-xl shadow-2xl hover:bg-blue-700 transition-all duration-200 border-2 border-white relative"
            onclick="toggleNotificationsPanel()">
        <i class="fas fa-bell text-xl"></i>
        <span class="notification-badge" id="mobileNotificationBadge" style="display: none;">0</span>
        <span class="sr-only">Notifications</span>
    </button>

    <!-- Mobile Sidebar Overlay -->
    <div id="mobileOverlay" class="lg:hidden fixed inset-0 mobile-sidebar-overlay z-40 hidden"
         onclick="
             console.log('Overlay clicked!');
             const sidebar = document.getElementById('sidebar');
             const overlay = document.getElementById('mobileOverlay');
             sidebar.classList.add('-translate-x-full');
             sidebar.classList.remove('translate-x-0');
             overlay.classList.add('hidden');
             console.log('Menu closed via overlay');
         "></div>

    <div class="flex h-screen">
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar w-72 fixed lg:relative h-full z-[60] transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
            <div class="flex flex-col h-full p-6 custom-scrollbar overflow-y-auto">
                <!-- Logo Section -->
                <div class="mb-8">
                    <div class="flex items-center space-x-3 mb-2">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center p-1 shadow-sm">
                            <img src="{{ asset('job-lynk-logo.png') }}" alt="JOB-lyNK Logo" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <h1 class="text-xl font-bold logo-text">Employer Hub</h1>
                            <p class="text-xs text-gray-400">Professional Dashboard</p>
                        </div>
                    </div>
                </div>

                <!-- User Profile Section -->
                <div class="user-profile rounded-xl p-4 mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center">
                            <span class="text-white font-semibold text-lg">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-white font-medium truncate">{{ Auth::user()->name }}</p>
                            <p class="text-gray-300 text-sm truncate">{{ Auth::user()->email }}</p>
                        </div>
                        <div class="relative">
                            <i class="fas fa-bell text-gray-300 text-lg cursor-pointer hover:text-white transition-colors" onclick="toggleNotificationsPanel()"></i>
                            <span class="notification-badge" id="notificationBadge">0</span>
                        </div>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="flex-1 space-y-2">
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4 px-3">Main Menu</div>
                    
                    <a href="#dashboard" class="sidebar-link flex items-center space-x-3 p-3 text-gray-300 hover:text-white sidebar-active" data-content="dashboard" onclick="
                        console.log('🎯 Dashboard clicked');
                        
                        // Use the proper functions
                        showContent('dashboard');
                        updateSidebar('dashboard');
                        
                        // Update URL hash for navigation
                        window.history.pushState(null, null, '#dashboard');
                        
                        // Initialize calendar features when dashboard is shown
                        setTimeout(() => {
                            initializeCalendarFeatures();
                        }, 100);
                        
                        return false;
                    ">
                        <i class="fas fa-home sidebar-icon w-5 h-5 flex items-center justify-center"></i>
                        <span class="font-medium">Dashboard</span>
                        <div class="ml-auto">
                            <i class="fas fa-chevron-right text-xs opacity-50"></i>
                        </div>
                    </a>

                    <a href="#applications" class="sidebar-link flex items-center space-x-3 p-3 text-gray-300 hover:text-white" data-content="applications" onclick="
                        console.log('🎯 Applications clicked');
                        console.log('📄 Looking for element:', 'applications-content');
                        const targetElement = document.getElementById('applications-content');
                        console.log('🔍 Found element:', targetElement);
                        if (targetElement) {
                            console.log('📊 Element classes:', targetElement.className);
                            console.log('📊 Element display:', window.getComputedStyle(targetElement).display);
                        }
                        showContent('applications');
                        updateSidebar('applications');
                        window.history.pushState(null, null, '#applications');
                        return false;
                    ">
                        <i class="fas fa-file-alt sidebar-icon w-5 h-5 flex items-center justify-center"></i>
                        <span class="font-medium">Applications</span>
                        <div class="ml-auto flex items-center space-x-2">
                            <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full">{{ $stats['total_applications'] ?? 0 }}</span>
                            <i class="fas fa-chevron-right text-xs opacity-50"></i>
                        </div>
                    </a>

                    <a href="{{ route('employer.myJobs') }}" class="sidebar-link flex items-center space-x-3 p-3 text-gray-300 hover:text-white">
                        <i class="fas fa-briefcase sidebar-icon w-5 h-5 flex items-center justify-center"></i>
                        <span class="font-medium">My Jobs</span>
                        <div class="ml-auto flex items-center space-x-2">
                            <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded-full">{{ $stats['active_jobs'] ?? 0 }}</span>
                            <i class="fas fa-chevron-right text-xs opacity-50"></i>
                        </div>
                    </a>

                    <a href="{{ route('messages') }}" class="sidebar-link flex items-center space-x-3 p-3 text-gray-300 hover:text-white">
                        <i class="fas fa-envelope sidebar-icon w-5 h-5 flex items-center justify-center"></i>
                        <span class="font-medium">Messages</span>
                        <div class="ml-auto flex items-center space-x-2">
                            <span class="bg-orange-500 text-white text-xs px-2 py-1 rounded-full">2</span>
                            <i class="fas fa-chevron-right text-xs opacity-50"></i>
                        </div>
                    </a>

                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4 px-3 mt-8">Management</div>
                    
                    <a href="{{ route('payment') }}" class="sidebar-link flex items-center space-x-3 p-3 text-gray-300 hover:text-white" data-content="billing">
                        <i class="fas fa-credit-card sidebar-icon w-5 h-5 flex items-center justify-center"></i>
                        <span class="font-medium">Billing & Payments</span>
                        <div class="ml-auto">
                            <i class="fas fa-chevron-right text-xs opacity-50"></i>
                        </div>
                    </a>
                    
                    <a href="{{ route('settings') }}" class="sidebar-link flex items-center space-x-3 p-3 text-gray-300 hover:text-white" data-content="settings">
                        <i class="fas fa-cog sidebar-icon w-5 h-5 flex items-center justify-center"></i>
                        <span class="font-medium">Profile & Settings</span>
                        <div class="ml-auto">
                            <i class="fas fa-chevron-right text-xs opacity-50"></i>
                        </div>
                    </a>
                </nav>

                <!-- Bottom Actions -->
                <div class="mt-8 space-y-3">
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4 px-3">Quick Actions</div>
                    
                    <a href="{{ route('postjob') }}" class="action-btn w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold py-3 px-4 rounded-xl hover:from-blue-600 hover:to-purple-700 transition duration-300 flex items-center justify-center space-x-2">
                        <i class="fas fa-plus"></i>
                        <span>Post New Job</span>
                    </a>
                    
                    <!-- Employer Profile Dropdown -->
                    <div class="relative">
                        <button onclick="toggleEmployerProfileDropdown()" class="w-full p-3 bg-gray-750 rounded-xl hover:bg-gray-700 transition-all duration-200 group">
                            <div class="flex items-center">
                                <div class="relative">
                                    <div class="h-10 w-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center ring-2 ring-blue-400 ring-offset-2 ring-offset-gray-800">
                                        <span class="text-white font-semibold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    </div>
                                    <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-gray-800"></div>
                                </div>
                                <div class="flex-1 text-left ml-3">
                                    <div class="text-sm text-gray-300 font-medium truncate">{{ Auth::user()->name }}</div>
                                    <div class="text-xs text-gray-500">Employer Account</div>
                                </div>
                                <i class="fas fa-chevron-up text-gray-400 text-xs group-hover:text-white transition"></i>
                            </div>
                        </button>
                        
                        <!-- Employer Profile Dropdown Menu -->
                        <div id="employerProfileDropdown" class="hidden absolute bottom-full left-0 right-0 mb-2 bg-gray-800 rounded-lg shadow-2xl border border-gray-700 overflow-hidden z-50 max-h-[80vh] overflow-y-auto">
                            <!-- Profile Header -->
                            <div class="p-4 bg-gradient-to-br from-blue-600 to-purple-600 text-white">
                                <div class="flex items-center mb-3">
                                    <div class="h-12 w-12 bg-white/20 rounded-full flex items-center justify-center ring-2 ring-white/30 backdrop-blur-sm">
                                        <span class="text-white font-bold text-xl">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    </div>
                                    <div class="flex-1 ml-3">
                                        <div class="font-semibold">{{ Auth::user()->name }}</div>
                                        <div class="text-xs opacity-90">{{ Auth::user()->email }}</div>
                                    </div>
                                </div>
                                <div class="flex items-center text-xs">
                                    <i class="fas fa-building mr-2"></i>
                                    Member since {{ Auth::user()->created_at->format('M Y') }}
                                </div>
                            </div>
                            
                            <!-- Menu Items -->
                            <div class="p-2">
                                <div class="px-3 py-2 text-xs text-gray-500 uppercase tracking-wider">Business Info</div>
                                
                                <a href="#" onclick="openBusinessInfo(); return false;" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition">
                                    <i class="fas fa-building w-5 text-blue-400"></i>
                                    <span class="text-sm">Business Information</span>
                                </a>
                                
                                <a href="#" onclick="openBusinessVerification(); return false;" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition">
                                    <i class="fas fa-certificate w-5 text-green-400"></i>
                                    <span class="text-sm">Business Verification</span>
                                </a>
                                
                                <a href="#" onclick="openEmployerPasswordChange(); return false;" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition">
                                    <i class="fas fa-key w-5 text-yellow-400"></i>
                                    <span class="text-sm">Change Password</span>
                                </a>
                                
                                <div class="border-t border-gray-700 my-2"></div>
                                
                                <div class="px-3 py-2 text-xs text-gray-500 uppercase tracking-wider">Activity Overview</div>
                                
                                <a href="#" onclick="openPostedJobs(); return false;" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition">
                                    <i class="fas fa-briefcase w-5 text-purple-400"></i>
                                    <span class="text-sm">Posted Jobs</span>
                                </a>
                                
                                <a href="#" onclick="openActiveJobs(); return false;" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition">
                                    <i class="fas fa-check-circle w-5 text-green-400"></i>
                                    <span class="text-sm">Active Jobs</span>
                                </a>
                                
                                <a href="#" onclick="openHiredWorkers(); return false;" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition">
                                    <i class="fas fa-users w-5 text-indigo-400"></i>
                                    <span class="text-sm">Hired Workers</span>
                                </a>
                                
                                <a href="#" onclick="openRatingsGiven(); return false;" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition">
                                    <i class="fas fa-star w-5 text-yellow-500"></i>
                                    <span class="text-sm">Ratings Given</span>
                                </a>
                                
                                <div class="border-t border-gray-700 my-2"></div>
                                
                                <a href="{{ route('settings') }}" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition">
                                    <i class="fas fa-cog w-5 text-gray-400"></i>
                                    <span class="text-sm">Account Settings</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('logout') }}" id="logoutForm" class="w-full">
                        @csrf
                        <button type="submit" onclick="return showLogoutModal(event)" class="action-btn w-full bg-red-600 text-white font-medium py-2 px-4 rounded-xl hover:bg-red-700 transition duration-300 flex items-center justify-center space-x-2">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Log Out</span>
                        </button>
                    </form>
                </div>

                <!-- Version Info -->
                <div class="mt-6 pt-4 border-t border-gray-700">
                    <div class="text-center">
                        <p class="text-xs text-gray-500">JOB-lyNK v2.0</p>
                        <p class="text-xs text-gray-600">© 2024 All rights reserved</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 w-full lg:w-auto overflow-hidden">
            <!-- Top Bar -->
            <div class="sticky top-0 z-40 bg-white/95 backdrop-blur-lg border-b border-gray-200 shadow-sm">
                <div class="px-4 lg:px-8 py-4">
                    <div class="flex items-center justify-between gap-4">
                        <!-- Left Section: Search Bar -->
                        <div class="flex-1 max-w-xl">
                            <div class="relative">
                                <input 
                                    type="text" 
                                    id="employerGlobalSearch"
                                    placeholder="Search jobs, applications, or candidates..." 
                                    class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                >
                                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>

                        <!-- Right Section: Actions & Profile -->
                        <div class="flex items-center gap-3">
                            <!-- Quick Stats -->
                            <div class="hidden lg:flex items-center gap-4 px-4 py-2 bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl border border-blue-100">
                                <div class="text-center">
                                    <div class="text-xs text-gray-500">Active Jobs</div>
                                    <div class="text-sm font-bold text-blue-600">{{ $activeJobsCount ?? 0 }}</div>
                                </div>
                                <div class="w-px h-8 bg-gray-300"></div>
                                <div class="text-center">
                                    <div class="text-xs text-gray-500">Applications</div>
                                    <div class="text-sm font-bold text-green-600">{{ $totalApplicationsCount ?? 0 }}</div>
                                </div>
                            </div>

                            <!-- Notifications -->
                            <div class="relative">
                                <button 
                                    onclick="toggleEmployerNotifications()"
                                    class="relative p-2.5 bg-gray-50 hover:bg-gray-100 rounded-xl transition-all group"
                                >
                                    <i class="fas fa-bell text-gray-600 group-hover:text-blue-600 transition-colors"></i>
                                    @php
                                        $aiAgentService = app(\App\Services\EmployerAIAgentService::class);
                                        $insights = $aiAgentService->generateInsights(Auth::user());
                                        $alertsCount = count($insights['alerts']);
                                    @endphp
                                    @if($alertsCount > 0)
                                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold animate-pulse">
                                        {{ $alertsCount }}
                                    </span>
                                    @endif
                                </button>
                                
                                <!-- Notifications Dropdown -->
                                <div id="employerNotificationsDropdown" class="hidden absolute top-full right-0 mt-2 w-96 bg-white rounded-xl shadow-2xl border border-gray-200 overflow-hidden z-50">
                                    <div class="p-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white">
                                        <div class="flex items-center justify-between">
                                            <h3 class="font-semibold">Job Match Alerts & Notifications</h3>
                                            <span class="text-xs bg-white/20 px-2 py-1 rounded-full">{{ $alertsCount }} new</span>
                                        </div>
                                    </div>
                                    <div class="max-h-96 overflow-y-auto">
                                        @if($alertsCount > 0)
                                            @foreach($insights['alerts'] as $alert)
                                            <div class="p-4 hover:bg-gray-50 border-b border-gray-100 cursor-pointer transition">
                                                <div class="flex items-start gap-3">
                                                    <div class="flex-shrink-0 mt-1">
                                                        @if($alert['type'] === 'new_applications')
                                                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                                                <i class="fas fa-user-check text-green-600"></i>
                                                            </div>
                                                        @elseif($alert['type'] === 'job_views')
                                                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                                <i class="fas fa-eye text-blue-600"></i>
                                                            </div>
                                                        @elseif($alert['type'] === 'low_performance')
                                                            <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                                                <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                                                            </div>
                                                        @else
                                                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                                                <i class="fas fa-bell text-purple-600"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex items-start justify-between gap-2">
                                                            <p class="text-sm font-semibold text-gray-800">{{ $alert['message'] }}</p>
                                                            <span class="flex-shrink-0 px-2 py-0.5 text-xs font-medium rounded-full
                                                                {{ $alert['priority'] === 'high' ? 'bg-red-100 text-red-700' : 
                                                                   ($alert['priority'] === 'medium' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-700') }}">
                                                                {{ ucfirst($alert['priority']) }}
                                                            </span>
                                                        </div>
                                                        <p class="text-xs text-gray-600 mt-1">{{ $alert['action'] }}</p>
                                                        <div class="flex items-center gap-2 mt-2">
                                                            @if($alert['type'] === 'new_applications')
                                                                <button onclick="showContent('applications'); toggleEmployerNotifications();" class="text-xs text-blue-600 hover:text-blue-700 font-medium">
                                                                    View Applications →
                                                                </button>
                                                            @elseif($alert['type'] === 'low_performance')
                                                                <button onclick="showContent('my-jobs'); toggleEmployerNotifications();" class="text-xs text-blue-600 hover:text-blue-700 font-medium">
                                                                    Manage Jobs →
                                                                </button>
                                                            @endif
                                                            <span class="text-xs text-gray-400">• Just now</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        @else
                                            <div class="p-8 text-center">
                                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                                    <i class="fas fa-bell-slash text-gray-400 text-2xl"></i>
                                                </div>
                                                <p class="text-sm text-gray-600 font-medium">No new alerts</p>
                                                <p class="text-xs text-gray-500 mt-1">You're all caught up!</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-3 bg-gray-50 text-center border-t border-gray-200">
                                        <button onclick="showContent('dashboard'); toggleEmployerNotifications();" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                                            View AI Dashboard →
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="relative">
                                <button 
                                    onclick="toggleEmployerQuickActions()"
                                    class="p-2.5 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 rounded-xl transition-all group shadow-lg"
                                >
                                    <i class="fas fa-bolt text-white"></i>
                                </button>
                                
                                <!-- Quick Actions Dropdown -->
                                <div id="employerQuickActionsDropdown" class="hidden absolute top-full right-0 mt-2 w-64 bg-white rounded-xl shadow-2xl border border-gray-200 overflow-hidden z-50">
                                    <div class="p-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white">
                                        <h3 class="font-semibold text-sm">Quick Actions</h3>
                                    </div>
                                    <div class="p-2">
                                        <button onclick="showContent('post-job'); toggleEmployerQuickActions();" class="w-full text-left px-3 py-2 hover:bg-gray-50 rounded-lg transition flex items-center gap-3">
                                            <i class="fas fa-plus-circle text-blue-600 w-5"></i>
                                            <span class="text-sm text-gray-700">Post New Job</span>
                                        </button>
                                        <button onclick="showContent('applications'); toggleEmployerQuickActions();" class="w-full text-left px-3 py-2 hover:bg-gray-50 rounded-lg transition flex items-center gap-3">
                                            <i class="fas fa-file-alt text-green-600 w-5"></i>
                                            <span class="text-sm text-gray-700">View Applications</span>
                                        </button>
                                        <button onclick="showContent('talent-search'); toggleEmployerQuickActions();" class="w-full text-left px-3 py-2 hover:bg-gray-50 rounded-lg transition flex items-center gap-3">
                                            <i class="fas fa-search text-purple-600 w-5"></i>
                                            <span class="text-sm text-gray-700">Search Talent</span>
                                        </button>
                                        <button onclick="showContent('messages'); toggleEmployerQuickActions();" class="w-full text-left px-3 py-2 hover:bg-gray-50 rounded-lg transition flex items-center gap-3">
                                            <i class="fas fa-comments text-yellow-600 w-5"></i>
                                            <span class="text-sm text-gray-700">Messages</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Theme Switcher (moved from header) -->
                            <div class="relative">
                                <button 
                                    onclick="toggleThemeMenu()"
                                    class="p-2.5 bg-gray-50 hover:bg-gray-100 rounded-xl transition-all group"
                                    title="Change Theme"
                                >
                                    <i id="theme-icon" class="fas fa-sun text-gray-600 group-hover:text-yellow-500 transition-colors"></i>
                                </button>
                                
                                <!-- Theme Menu Dropdown -->
                                <div id="themeMenuDropdown" class="hidden absolute top-full right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-200 overflow-hidden z-50">
                                    <div class="p-3 bg-gradient-to-r from-gray-700 to-gray-900 text-white">
                                        <h3 class="font-semibold text-sm flex items-center">
                                            <i class="fas fa-palette mr-2"></i>
                                            Theme Settings
                                        </h3>
                                    </div>
                                    <div class="p-2">
                                        <button onclick="setTheme('light')" class="theme-option w-full text-left px-3 py-3 hover:bg-gray-50 rounded-lg transition flex items-center gap-3 group">
                                            <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-orange-400 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                                <i class="fas fa-sun text-white"></i>
                                            </div>
                                            <div class="flex-1">
                                                <div class="text-sm font-medium text-gray-800">Light Mode</div>
                                                <div class="text-xs text-gray-500">Bright and clear</div>
                                            </div>
                                            <i class="fas fa-check text-blue-600 hidden light-check"></i>
                                        </button>
                                        <button onclick="setTheme('dark')" class="theme-option w-full text-left px-3 py-3 hover:bg-gray-50 rounded-lg transition flex items-center gap-3 group">
                                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-700 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                                <i class="fas fa-moon text-white"></i>
                                            </div>
                                            <div class="flex-1">
                                                <div class="text-sm font-medium text-gray-800">Dark Mode</div>
                                                <div class="text-xs text-gray-500">Easy on the eyes</div>
                                            </div>
                                            <i class="fas fa-check text-blue-600 hidden dark-check"></i>
                                        </button>
                                        <button onclick="setTheme('system')" class="theme-option w-full text-left px-3 py-3 hover:bg-gray-50 rounded-lg transition flex items-center gap-3 group">
                                            <div class="w-10 h-10 bg-gradient-to-br from-gray-500 to-gray-700 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                                <i class="fas fa-desktop text-white"></i>
                                            </div>
                                            <div class="flex-1">
                                                <div class="text-sm font-medium text-gray-800">System Default</div>
                                                <div class="text-xs text-gray-500">Match your OS</div>
                                            </div>
                                            <i class="fas fa-check text-blue-600 hidden system-check"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Employer Profile -->
                            <div class="relative">
                                <button 
                                    onclick="toggleEmployerTopBarProfile()"
                                    class="flex items-center gap-3 pl-3 pr-4 py-2 bg-gradient-to-r from-gray-50 to-gray-100 hover:from-gray-100 hover:to-gray-200 rounded-xl transition-all border border-gray-200 group"
                                >
                                    <div class="relative">
                                        <div class="w-9 h-9 bg-gradient-to-br from-blue-600 to-purple-600 rounded-lg flex items-center justify-center ring-2 ring-blue-200">
                                            <i class="fas fa-building text-white text-sm"></i>
                                        </div>
                                        <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></div>
                                    </div>
                                    <div class="hidden lg:block text-left">
                                        <div class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</div>
                                        <div class="text-xs text-gray-500">Employer</div>
                                    </div>
                                    <i class="fas fa-chevron-down text-gray-400 text-xs group-hover:text-gray-600 transition"></i>
                                </button>
                                
                                <!-- Profile Dropdown -->
                                <div id="employerTopBarProfileDropdown" class="hidden absolute top-full right-0 mt-2 w-64 bg-white rounded-xl shadow-2xl border border-gray-200 overflow-hidden z-50">
                                    <div class="p-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-building text-white text-lg"></i>
                                            </div>
                                            <div>
                                                <div class="font-semibold">{{ Auth::user()->name }}</div>
                                                <div class="text-xs text-blue-100">{{ Auth::user()->email }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-2">
                                        <a href="#" onclick="showContent('profile'); toggleEmployerTopBarProfile(); return false;" class="flex items-center gap-3 px-3 py-2 hover:bg-gray-50 rounded-lg transition">
                                            <i class="fas fa-user text-gray-600 w-5"></i>
                                            <span class="text-sm text-gray-700">My Profile</span>
                                        </a>
                                        <a href="#" onclick="showContent('settings'); toggleEmployerTopBarProfile(); return false;" class="flex items-center gap-3 px-3 py-2 hover:bg-gray-50 rounded-lg transition">
                                            <i class="fas fa-cog text-gray-600 w-5"></i>
                                            <span class="text-sm text-gray-700">Settings</span>
                                        </a>
                                        <div class="border-t border-gray-200 my-2"></div>
                                        <form method="POST" action="{{ route('logout') }}" id="logoutForm" class="m-0">
                                            @csrf
                                            <button type="submit" onclick="return showLogoutModal(event)" class="w-full flex items-center gap-3 px-3 py-2 hover:bg-red-50 rounded-lg transition text-left">
                                                <i class="fas fa-sign-out-alt text-red-600 w-5"></i>
                                                <span class="text-sm text-red-600 font-medium">Logout</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="p-4 lg:p-8 custom-scrollbar overflow-y-auto h-screen max-w-7xl mx-auto">
                <!-- Header -->
                <!-- Welcome Section with Glassmorphism -->
                <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-6 lg:mb-8 space-y-4 lg:space-y-0 pt-4 lg:pt-0 bg-white bg-opacity-40 backdrop-blur-lg rounded-2xl p-6 shadow-xl border border-white border-opacity-30">
                    <div class="animate-fade-in">
                        <h1 class="text-xl lg:text-3xl font-bold text-gray-800">Welcome back, {{ Auth::user()->name }}!</h1>
                        <p class="text-sm lg:text-base text-gray-600 mt-1">Manage your talent acquisition and job postings with ease.</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <!-- Theme Switcher -->
                        <div class="relative">
                            <button 
                                onclick="toggleThemeMenu()"
                                class="p-2.5 bg-white/80 hover:bg-white rounded-xl transition-all group shadow-md border border-gray-200"
                                title="Change Theme"
                            >
                                <i id="theme-icon" class="fas fa-sun text-gray-600 group-hover:text-yellow-500 transition-colors"></i>
                            </button>
                            
                            <!-- Theme Menu Dropdown -->
                            <div id="themeMenuDropdown" class="hidden absolute top-full right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-200 overflow-hidden z-50">
                                <div class="p-3 bg-gradient-to-r from-gray-700 to-gray-900 text-white">
                                    <h3 class="font-semibold text-sm flex items-center">
                                        <i class="fas fa-palette mr-2"></i>
                                        Theme Settings
                                    </h3>
                                </div>
                                <div class="p-2">
                                    <button onclick="setTheme('light')" class="theme-option w-full text-left px-3 py-3 hover:bg-gray-50 rounded-lg transition flex items-center gap-3 group">
                                        <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-orange-400 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                            <i class="fas fa-sun text-white"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="text-sm font-medium text-gray-800">Light Mode</div>
                                            <div class="text-xs text-gray-500">Bright and clear</div>
                                        </div>
                                        <i class="fas fa-check text-blue-600 hidden light-check"></i>
                                    </button>
                                    <button onclick="setTheme('dark')" class="theme-option w-full text-left px-3 py-3 hover:bg-gray-50 rounded-lg transition flex items-center gap-3 group">
                                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-700 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                            <i class="fas fa-moon text-white"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="text-sm font-medium text-gray-800">Dark Mode</div>
                                            <div class="text-xs text-gray-500">Easy on the eyes</div>
                                        </div>
                                        <i class="fas fa-check text-blue-600 hidden dark-check"></i>
                                    </button>
                                    <button onclick="setTheme('system')" class="theme-option w-full text-left px-3 py-3 hover:bg-gray-50 rounded-lg transition flex items-center gap-3 group">
                                        <div class="w-10 h-10 bg-gradient-to-br from-gray-500 to-gray-700 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                            <i class="fas fa-desktop text-white"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="text-sm font-medium text-gray-800">System Default</div>
                                            <div class="text-xs text-gray-500">Match your OS</div>
                                        </div>
                                        <i class="fas fa-check text-blue-600 hidden system-check"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-right hidden lg:block">
                            <div class="text-sm text-gray-500">Member since</div>
                            <div class="text-lg font-semibold text-gray-800">{{ Auth::user()->created_at->format('M Y') }}</div>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center lg:hidden">
                            <span class="text-white font-semibold text-lg">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                    </div>
                </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            <div id="employer-content-container">
                


                <div id="dashboard-content" class="content-section">
                    <h2 class="text-2xl font-semibold text-gray-700 mb-6">Overview & Quick Actions</h2>

                    <!-- Enhanced Statistics Cards -->
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                                <div class="bg-gray-100 backdrop-blur-sm border border-white/30 p-5 rounded-2xl hover:shadow-xl hover:bg-gray-200 transition-all duration-300 group">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="flex items-center space-x-2 mb-2">
                                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                                                    <i class="fas fa-briefcase text-white text-sm"></i>
                                                </div>
                                                <p class="text-slate-600 text-sm font-medium">Total Jobs</p>
                                            </div>
                                            <p class="text-2xl font-bold text-slate-800">{{ $stats['total_jobs'] ?? 0 }}</p>
                                            <p class="text-xs text-slate-500 mt-1">{{ $stats['jobs_this_month'] ?? 0 }} this month</p>
                                        </div>
                                        <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                                            <i class="fas fa-arrow-up text-green-500 text-sm"></i>
                                        </div>
                                    </div>
                                </div>
                        
                        <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 p-4 rounded-xl hover:shadow-md transition-all duration-200 group">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-green-600 text-xs font-medium uppercase tracking-wide">Active Jobs</p>
                                    <p class="text-2xl font-bold text-green-900 mt-1">{{ $stats['active_jobs'] ?? 0 }}</p>
                                    <p class="text-green-500 text-xs mt-1">{{ $stats['draft_jobs'] ?? 0 }} drafts</p>
                                </div>
                                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fas fa-check-circle text-white text-sm"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gradient-to-br from-amber-50 to-amber-100 border border-amber-200 p-4 rounded-xl hover:shadow-md transition-all duration-200 group">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-amber-600 text-xs font-medium uppercase tracking-wide">Total Views</p>
                                    <p class="text-2xl font-bold text-amber-900 mt-1">{{ $stats['total_views'] ?? 0 }}</p>
                                    <p class="text-amber-500 text-xs mt-1">Avg {{ $stats['total_jobs'] > 0 ? round(($stats['total_views'] ?? 0) / $stats['total_jobs'], 1) : 0 }} per job</p>
                                </div>
                                <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fas fa-eye text-white text-sm"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 p-4 rounded-xl hover:shadow-md transition-all duration-200 group">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-purple-600 text-xs font-medium uppercase tracking-wide">Applications</p>
                                    <p class="text-2xl font-bold text-purple-900 mt-1">{{ $stats['total_applications'] ?? 0 }}</p>
                                    <p class="text-purple-500 text-xs mt-1">{{ $stats['application_rate'] ?? 0 }}% rate</p>
                                </div>
                                <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fas fa-users text-white text-sm"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- AI Agent Widget -->
                    <div class="mb-8">
                        @php
                            $aiAgentService = app(\App\Services\EmployerAIAgentService::class);
                            $insights = $aiAgentService->generateInsights(Auth::user());
                        @endphp
                        @include('components.ai-agent-widget', ['insights' => $insights])
                    </div>

                    <!-- Innovative Dashboard Features -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                        
                        <!-- Real-Time Activity Feed -->
                        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200">
                            <div class="p-6 border-b border-gray-100">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-stream text-white text-sm"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">Activity Feed</h3>
                                            <p class="text-sm text-gray-500">Real-time updates and notifications</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="relative flex h-3 w-3">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                                        </span>
                                        <span class="text-xs text-green-600 font-medium">Live</span>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="space-y-4 max-h-96 overflow-y-auto custom-scrollbar">
                                    <!-- Activity Item 1 -->
                                    <div class="flex items-start space-x-4 p-4 bg-blue-50 rounded-lg border border-blue-100 hover:bg-blue-100 transition-colors group">
                                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-user-plus text-white text-xs"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <p class="text-sm font-medium text-gray-900">New Application Received</p>
                                                <span class="text-xs text-gray-500">2 min ago</span>
                                            </div>
                                            <p class="text-sm text-gray-600 mt-1">Maleek Berry applied for "Delivery Service" position</p>
                                            <div class="flex items-center space-x-2 mt-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <button class="text-xs bg-blue-600 text-white px-3 py-1 rounded-full hover:bg-blue-700 transition">
                                                    View Application
                                                </button>
                                                <button class="text-xs bg-green-600 text-white px-3 py-1 rounded-full hover:bg-green-700 transition">
                                                    Quick Approve
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Activity Item 2 -->
                                    <div class="flex items-start space-x-4 p-4 bg-green-50 rounded-lg border border-green-100 hover:bg-green-100 transition-colors group">
                                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-eye text-white text-xs"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <p class="text-sm font-medium text-gray-900">Job Views Spike</p>
                                                <span class="text-xs text-gray-500">15 min ago</span>
                                            </div>
                                            <p class="text-sm text-gray-600 mt-1">"House Caretaker" job received 12 new views today</p>
                                            <div class="flex items-center space-x-2 mt-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <button class="text-xs bg-green-600 text-white px-3 py-1 rounded-full hover:bg-green-700 transition">
                                                    View Analytics
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Activity Item 3 -->
                                    <div class="flex items-start space-x-4 p-4 bg-purple-50 rounded-lg border border-purple-100 hover:bg-purple-100 transition-colors group">
                                        <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-envelope text-white text-xs"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <p class="text-sm font-medium text-gray-900">New Message</p>
                                                <span class="text-xs text-gray-500">1 hour ago</span>
                                            </div>
                                            <p class="text-sm text-gray-600 mt-1">IAN SMITH sent you a message about the Manager position</p>
                                            <div class="flex items-center space-x-2 mt-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <button class="text-xs bg-purple-600 text-white px-3 py-1 rounded-full hover:bg-purple-700 transition">
                                                    Reply
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Activity Item 4 -->
                                    <div class="flex items-start space-x-4 p-4 bg-amber-50 rounded-lg border border-amber-100 hover:bg-amber-100 transition-colors group">
                                        <div class="w-8 h-8 bg-amber-500 rounded-full flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-clock text-white text-xs"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <p class="text-sm font-medium text-gray-900">Interview Reminder</p>
                                                <span class="text-xs text-gray-500">2 hours ago</span>
                                            </div>
                                            <p class="text-sm text-gray-600 mt-1">Interview with Kamuntu Emmanuel scheduled for tomorrow at 2:00 PM</p>
                                            <div class="flex items-center space-x-2 mt-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <button class="text-xs bg-amber-600 text-white px-3 py-1 rounded-full hover:bg-amber-700 transition">
                                                    Reschedule
                                                </button>
                                                <button class="text-xs bg-green-600 text-white px-3 py-1 rounded-full hover:bg-green-700 transition">
                                                    Confirm
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <button class="w-full text-sm text-gray-600 hover:text-gray-900 font-medium transition">
                                        View All Activities <i class="fas fa-arrow-right ml-1"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Tools Panel -->
                        <div class="space-y-6">
                            
                            <!-- Calendar Integration -->
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                                <div class="p-4 border-b border-gray-100">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-calendar-alt text-white text-xs"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-semibold text-gray-900">Today's Schedule</h3>
                                            <p class="text-xs text-gray-500">{{ date('M d, Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <div class="space-y-3">
                                        <div class="flex items-center space-x-3 p-2 bg-blue-50 rounded-lg">
                                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                            <div class="flex-1">
                                                <p class="text-xs font-medium text-gray-900">Interview - John Doe</p>
                                                <p class="text-xs text-gray-500">2:00 PM - 3:00 PM</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-3 p-2 bg-green-50 rounded-lg">
                                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                            <div class="flex-1">
                                                <p class="text-xs font-medium text-gray-900">Review Applications</p>
                                                <p class="text-xs text-gray-500">4:00 PM - 5:00 PM</p>
                                            </div>
                                        </div>
                                    </div>
                                    <button id="scheduleInterviewBtn" onclick="showScheduleInterviewModal()" class="w-full mt-3 text-xs bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105">
                                        <i class="fas fa-calendar-plus mr-2"></i> Schedule Interview
                                    </button>
                                </div>
                            </div>

                            <!-- Quick Notes -->
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                                <div class="p-4 border-b border-gray-100">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-sticky-note text-white text-xs"></i>
                                        </div>
                                        <h3 class="text-sm font-semibold text-gray-900">Quick Notes</h3>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <textarea 
                                        placeholder="Add a quick note or reminder..."
                                        class="w-full h-20 text-xs border border-gray-200 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                                        id="quickNote"
                                    ></textarea>
                                    <div class="flex justify-between items-center mt-2">
                                        <span class="text-xs text-gray-400" id="saveStatus">Auto-saved</span>
                                        <button onclick="saveCurrentNote()" class="text-xs bg-yellow-600 text-white px-3 py-1 rounded-full hover:bg-yellow-700 transition">
                                            <i class="fas fa-save mr-1"></i>Save Note
                                        </button>
                                    </div>
                                    
                                    <!-- Recent Notes -->
                                    <div class="mt-3 space-y-2" id="recentNotesContainer">
                                        <!-- Notes will be loaded here dynamically -->
                                        <div class="p-2 bg-yellow-50 rounded border border-yellow-100">
                                            <p class="text-xs text-gray-700">Follow up with top candidates by Friday</p>
                                            <div class="flex justify-between items-center mt-1">
                                                <span class="text-xs text-gray-400">2 hours ago</span>
                                                <button onclick="deleteNote(1)" class="text-xs text-red-500 hover:text-red-700">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="p-2 bg-yellow-50 rounded border border-yellow-100">
                                            <p class="text-xs text-gray-700">Update job requirements for Manager position</p>
                                            <div class="flex justify-between items-center mt-1">
                                                <span class="text-xs text-gray-400">1 day ago</span>
                                                <button onclick="deleteNote(2)" class="text-xs text-red-500 hover:text-red-700">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- View All Notes Button -->
                                    <div class="mt-3 text-center">
                                        <button onclick="showAllNotes()" class="text-xs text-blue-600 hover:text-blue-800 underline">
                                            <i class="fas fa-eye mr-1"></i>View All Notes
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Candidate Pipeline Tracker -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8">
                        <div class="p-6 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-teal-600 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-users-cog text-white text-sm"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Candidate Pipeline</h3>
                                        <p class="text-sm text-gray-500">Drag and drop to manage candidates</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <select class="text-sm border border-gray-200 rounded-lg px-3 py-1 focus:ring-2 focus:ring-blue-500">
                                        <option>All Jobs</option>
                                        <option>Delivery Service</option>
                                        <option>House Caretaker</option>
                                        <option>Manager</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <!-- Mobile: Horizontal scroll, Desktop: Grid -->
                            <div class="md:grid md:grid-cols-4 md:gap-4 flex md:flex-none overflow-x-auto gap-4 pb-4">
                                
                                <!-- Applied Stage -->
                                <div class="bg-blue-50 rounded-lg border border-blue-200 min-w-72 md:min-w-0 flex-shrink-0">
                                    <div class="p-3 border-b border-blue-200">
                                        <div class="flex items-center justify-between">
                                            <h4 class="text-sm font-semibold text-blue-900">Applied</h4>
                                            <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded-full">2</span>
                                        </div>
                                    </div>
                                    <div class="p-3 space-y-2 min-h-32">
                                        <div class="bg-white p-3 rounded-lg shadow-sm border border-blue-100 cursor-move hover:shadow-md transition-shadow touch-manipulation" 
                                             draggable="true" 
                                             data-candidate-id="1" 
                                             data-candidate-name="Maleek Berry" 
                                             data-current-stage="applied">
                                            <div class="flex items-center space-x-2">
                                                <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                                                    <span class="text-white text-xs font-bold">M</span>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="text-xs font-medium text-gray-900">Maleek Berry</p>
                                                    <p class="text-xs text-gray-500">Delivery Service</p>
                                                </div>
                                                <div class="flex items-center space-x-1">
                                                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                                    <span class="text-xs text-green-600">85</span>
                                                </div>
                                            </div>
                                            <!-- Mobile: Add tap to move button -->
                                            <div class="mt-2 md:hidden">
                                                <button onclick="showMobileMoveOptions(1, 'Maleek Berry')" 
                                                        class="w-full text-xs bg-blue-500 text-white py-1 px-2 rounded hover:bg-blue-600 transition">
                                                    Move to Stage
                                                </button>
                                            </div>
                                        </div>
                                        <div class="bg-white p-3 rounded-lg shadow-sm border border-blue-100 cursor-move hover:shadow-md transition-shadow touch-manipulation" 
                                             draggable="true" 
                                             data-candidate-id="2" 
                                             data-candidate-name="IAN SMITH" 
                                             data-current-stage="applied">
                                            <div class="flex items-center space-x-2">
                                                <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                                                    <span class="text-white text-xs font-bold">I</span>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="text-xs font-medium text-gray-900">IAN SMITH</p>
                                                    <p class="text-xs text-gray-500">Delivery Service</p>
                                                </div>
                                                <div class="flex items-center space-x-1">
                                                    <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                                                    <span class="text-xs text-yellow-600">72</span>
                                                </div>
                                            </div>
                                            <!-- Mobile: Add tap to move button -->
                                            <div class="mt-2 md:hidden">
                                                <button onclick="showMobileMoveOptions(2, 'IAN SMITH')" 
                                                        class="w-full text-xs bg-blue-500 text-white py-1 px-2 rounded hover:bg-blue-600 transition">
                                                    Move to Stage
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Screening Stage -->
                                <div class="bg-yellow-50 rounded-lg border border-yellow-200">
                                    <div class="p-3 border-b border-yellow-200">
                                        <div class="flex items-center justify-between">
                                            <h4 class="text-sm font-semibold text-yellow-900">Screening</h4>
                                            <span class="bg-yellow-600 text-white text-xs px-2 py-1 rounded-full">0</span>
                                        </div>
                                    </div>
                                    <div class="p-3 min-h-32 border-2 border-dashed border-yellow-300 rounded-lg flex items-center justify-center" data-stage="screening">
                                        <p class="text-xs text-yellow-600">Drop candidates here</p>
                                    </div>
                                </div>

                                <!-- Interview Stage -->
                                <div class="bg-purple-50 rounded-lg border border-purple-200">
                                    <div class="p-3 border-b border-purple-200">
                                        <div class="flex items-center justify-between">
                                            <h4 class="text-sm font-semibold text-purple-900">Interview</h4>
                                            <span class="bg-purple-600 text-white text-xs px-2 py-1 rounded-full">0</span>
                                        </div>
                                    </div>
                                    <div class="p-3 min-h-32 border-2 border-dashed border-purple-300 rounded-lg flex items-center justify-center">
                                        <p class="text-xs text-purple-600">Drop candidates here</p>
                                    </div>
                                </div>

                                <!-- Hired Stage -->
                                <div class="bg-green-50 rounded-lg border border-green-200">
                                    <div class="p-3 border-b border-green-200">
                                        <div class="flex items-center justify-between">
                                            <h4 class="text-sm font-semibold text-green-900">Hired</h4>
                                            <span class="bg-green-600 text-white text-xs px-2 py-1 rounded-full">0</span>
                                        </div>
                                    </div>
                                    <div class="p-3 min-h-32 border-2 border-dashed border-green-300 rounded-lg flex items-center justify-center">
                                        <p class="text-xs text-green-600">Drop candidates here</p>
                                    </div>
                                </div>

                            </!-->
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-blue-600 text-white p-6 rounded-xl mb-10 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                        <div>
                            <h3 class="text-xl font-semibold mb-2">
                                <i class="fas fa-plus-circle mr-2"></i>
                                Need a Worker Fast?
                            </h3>
                            <p class="opacity-90">Post a new job and reach thousands of skilled workers instantly.</p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('postjob') }}" class="bg-white text-blue-700 font-semibold py-3 px-6 rounded-lg hover:bg-blue-50 transition duration-300 shadow-lg">
                                <i class="fas fa-plus mr-2"></i>
                                Post New Job
                            </a>
                        </div>
                    </div>
                </div>

                <div id="job-posts-content" class="content-section hidden">
                    <h2 class="text-2xl font-semibold text-gray-700 mb-6">💼 My Job Posts</h2>
                    <p class="text-gray-600 mb-6">View and manage all your job postings.</p>
                    
                    <!-- Debug Info -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                        <h3 class="text-blue-800 font-semibold mb-2">🔍 Debug Info</h3>
                        <p class="text-blue-700 text-sm">Job Posts section is loading...</p>
                        <p class="text-blue-700 text-sm">Total Jobs: {{ $stats['total_jobs'] ?? 0 }}</p>
                        <p class="text-blue-700 text-sm">Jobs Collection Count: {{ isset($jobs) ? $jobs->count() : 'Not set' }}</p>
                    </div>
                    
                    @php
                        $jobPosts = $jobs ?? collect();
                        $totalJobPosts = $jobPosts->count();
                    @endphp
                    @include('files.jobPosts')
                </div>

                <div id="create-job-content" class="content-section hidden">
                    <h2 class="text-2xl font-semibold text-gray-700 mb-6">+ Create New Job Post</h2>
                    <p class="text-gray-600 mb-6">Fill in the details below to publish your job opportunity instantly.</p>
                    
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <form id="createJobForm" class="space-y-6" onsubmit="return false;" action="javascript:void(0);">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="job_title" class="block text-sm font-medium text-gray-700 mb-2">Job Title *</label>
                                    <input type="text" id="job_title" name="title" required 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="e.g. Senior Software Developer">
                                </div>
                                <div>
                                    <label for="job_category" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                                    <select id="job_category" name="category_id" required 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="">Select Category</option>
                                        @if(isset($categories) && $categories->count() > 0)
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="job_description" class="block text-sm font-medium text-gray-700 mb-2">Job Description *</label>
                                <textarea id="job_description" name="description" rows="6" required 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                          placeholder="Describe the job responsibilities, requirements, and what you're looking for... (minimum 20 characters)"
                                          minlength="20"></textarea>
                                <div class="text-sm text-gray-500 mt-1">
                                    <span id="description-counter">0</span> / 20 characters minimum
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="job_location" class="block text-sm font-medium text-gray-700 mb-2">Location *</label>
                                    <input type="text" id="job_location" name="location" required 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="e.g. Kampala, Uganda">
                                </div>
                                <div>
                                    <label for="salary_min" class="block text-sm font-medium text-gray-700 mb-2">Min Salary (UGX) *</label>
                                    <input type="number" id="salary_min" name="salary_min" required 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="500000">
                                </div>
                                <div>
                                    <label for="salary_max" class="block text-sm font-medium text-gray-700 mb-2">Max Salary (UGX) *</label>
                                    <input type="number" id="salary_max" name="salary_max" required 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="1000000">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="job_type" class="block text-sm font-medium text-gray-700 mb-2">Job Type *</label>
                                    <select id="job_type" name="job_type" required 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="">Select Job Type</option>
                                        <option value="full-time">Full Time</option>
                                        <option value="part-time">Part Time</option>
                                        <option value="contract">Contract</option>
                                        <option value="freelance">Freelance</option>
                                        <option value="internship">Internship</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="experience_level" class="block text-sm font-medium text-gray-700 mb-2">Experience Level</label>
                                    <select id="experience_level" name="experience_level" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="">Select Experience Level</option>
                                        <option value="entry">Entry Level</option>
                                        <option value="mid">Mid Level</option>
                                        <option value="senior">Senior Level</option>
                                        <option value="executive">Executive</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="requirements" class="block text-sm font-medium text-gray-700 mb-2">Requirements & Skills</label>
                                <textarea id="requirements" name="requirements" rows="4" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                          placeholder="List the key requirements and qualifications (separate with commas)...&#10;Example: Bachelor's degree, 3+ years experience, JavaScript, React, Communication skills"></textarea>
                                <div class="text-sm text-gray-500 mt-1">
                                    Separate multiple requirements with commas for better organization
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                                <div class="flex space-x-4">
                                    <a href="#job-posts" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition inline-flex items-center">
                                        <i class="fas fa-arrow-left mr-2"></i>
                                        Back to Jobs
                                    </a>
                                </div>
                                <div class="flex space-x-3">
                                    <button type="button" onclick="saveJobDraft()" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                                        <i class="fas fa-save mr-2"></i>
                                        Save as Draft
                                    </button>
                                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                                        <i class="fas fa-paper-plane mr-2"></i>
                                        Publish Job
                                    </button>
                                </div>
                            </div>
                        </form>
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
                    <div class="bg-white p-4 rounded-lg shadow-md mb-6">
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

                    <!-- Applications List -->
                    <div class="space-y-4" id="applicationsList">
                        @if(isset($recentApplications) && $recentApplications->count() > 0)
                            @foreach($recentApplications as $application)
                                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200 hover:shadow-lg transition-shadow duration-200">
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
                </div>

                <div id="billing-content" class="content-section hidden">
                    <h2 class="text-2xl font-semibold text-gray-700 mb-6">💳 Billing & Payments</h2>
                    <p class="text-gray-600 mb-6">Manage your account balance and payment history.</p>
                    
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Payment Management</h3>
                        <p class="text-gray-600">Billing information will appear here. This section is now working!</p>
                    </div>
                </div>

                <div id="settings-content" class="content-section hidden" style="background-color: #dfe3ed;">
                    <h2 class="text-2xl font-semibold text-gray-700 mb-6">⚙️ Profile & Settings</h2>
                    <p class="text-gray-600 mb-6">Update your profile information and account settings.</p>
                    
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Account Settings</h3>
                        <p class="text-gray-600">Profile settings will appear here. This section is now working!</p>
                    </div>
                </div>

                <div id="applications-content" class="content-section hidden">
                    <h2 class="text-2xl font-semibold text-gray-700 mb-6">📋 Job Applications</h2>
                    <p class="text-gray-600 mb-6">Manage and review all applications for your job postings.</p>
                    
                    @php
                        $applications = $recentApplications ?? collect();
                        $totalApplications = $applications->count();
                    @endphp
                    @include('files.applications')
                </div>

            </div>
        </div>
    </div>

    <script>
    // Define global functions first, before DOMContentLoaded
    
    // Content Management Functions - Available immediately
    window.showContent = function(contentId) {
        console.log('🎯 showContent called with:', contentId);
        
        // Hide all content sections
        const allSections = document.querySelectorAll('.content-section');
        allSections.forEach(section => {
            section.style.display = 'none';
            section.classList.add('hidden');
            section.classList.remove('force-display-block');
        });
        
        // Show the requested content
        const targetSection = document.getElementById(contentId + '-content');
        if (targetSection) {
            targetSection.classList.remove('hidden');
            targetSection.classList.add('force-display-block');
            targetSection.style.setProperty('display', 'block', 'important');
            targetSection.style.setProperty('visibility', 'visible', 'important');
            targetSection.style.setProperty('opacity', '1', 'important');
            
            console.log('✅ Content shown:', contentId);
            console.log('📊 Section display:', window.getComputedStyle(targetSection).display);
            return true;
        } else {
            console.error('❌ Content section not found:', contentId + '-content');
            return false;
        }
    };
    
    window.updateSidebar = function(activeContentId) {
        console.log('🎯 updateSidebar called with:', activeContentId);
        
        // Remove active class from all sidebar links
        document.querySelectorAll('.sidebar-link').forEach(link => {
            link.classList.remove('sidebar-active');
        });
        
        // Add active class to the correct link
        const activeLink = document.querySelector(`[data-content="${activeContentId}"]`);
        if (activeLink) {
            activeLink.classList.add('sidebar-active');
            console.log('✅ Sidebar updated for:', activeContentId);
        } else {
            console.error('❌ Sidebar link not found for:', activeContentId);
        }
    };
    
    // Global functions for quick actions
    window.scheduleInterview = scheduleInterview;
    
    window.showScheduleInterviewModal = function() {
        console.log('📅 Opening schedule interview modal...');
        
        try {
            // Create the modal directly without API calls for now
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4';
            modal.innerHTML = `
                <div class="bg-white rounded-xl shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-semibold text-gray-900">Schedule Appointment</h3>
                            <button onclick="this.closest('.fixed').remove()" class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Appointment Type Selection -->
                    <div class="p-6 border-b border-gray-100">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Select Appointment Type</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="appointment-type-card cursor-pointer p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all duration-200" data-type="screening">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-search text-yellow-600"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-medium text-gray-900">Screening</h5>
                                        <p class="text-sm text-gray-600">Initial candidate evaluation</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="appointment-type-card cursor-pointer p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all duration-200" data-type="interview">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-comments text-blue-600"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-medium text-gray-900">Interview</h5>
                                        <p class="text-sm text-gray-600">Formal candidate interview</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="appointment-type-card cursor-pointer p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all duration-200" data-type="hiring">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-handshake text-green-600"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-medium text-gray-900">Hiring</h5>
                                        <p class="text-sm text-gray-600">Final hiring discussion</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <form id="scheduleInterviewForm" class="p-6 space-y-6">
                        <input type="hidden" id="appointmentType" name="appointment_type" value="">
                        
                        <!-- Selected Type Display -->
                        <div id="selectedTypeDisplay" class="hidden bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-lg border border-blue-200">
                            <div class="flex items-center space-x-3">
                                <div id="selectedTypeIcon" class="w-8 h-8 rounded-lg flex items-center justify-center"></div>
                                <div>
                                    <h4 class="font-medium text-blue-900" id="selectedTypeName"></h4>
                                    <p class="text-sm text-blue-700" id="selectedTypeDescription"></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Job Position *</label>
                                <select id="jobSelect" name="job_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                    <option value="">Select Job Position</option>
                                    <option value="1">Software Developer (5 applications)</option>
                                    <option value="2">Marketing Manager (3 applications)</option>
                                    <option value="3">Graphic Designer (7 applications)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Candidate *</label>
                                <select id="candidateSelect" name="candidate_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                    <option value="">Select Candidate</option>
                                    <option value="1" data-job-id="1" data-email="john@example.com" data-phone="+256700000001">John Doe - Software Developer (pending)</option>
                                    <option value="2" data-job-id="1" data-email="jane@example.com" data-phone="+256700000002">Jane Smith - Software Developer (screening)</option>
                                    <option value="3" data-job-id="2" data-email="mike@example.com" data-phone="+256700000003">Mike Johnson - Marketing Manager (pending)</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Date & Time *</label>
                                <input type="datetime-local" id="scheduledAt" name="scheduled_at" required 
                                       min="${new Date().toISOString().slice(0, 16)}"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Meeting Type *</label>
                                <select id="interviewType" name="type" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                    <option value="">Select Type</option>
                                    <option value="video">Video Call</option>
                                    <option value="phone">Phone Call</option>
                                    <option value="in-person">In-Person</option>
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Notes (Optional)</label>
                            <textarea id="interviewNotes" name="notes" rows="3" 
                                      class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                      placeholder="Add any additional notes or instructions for the appointment..."></textarea>
                        </div>
                    </form>
                    
                    <div class="p-6 border-t border-gray-200 flex justify-end space-x-3">
                        <button onclick="this.closest('.fixed').remove()" class="px-6 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                            Cancel
                        </button>
                        <button id="scheduleSubmitBtn" onclick="submitScheduleInterview()" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition" disabled>
                            <i class="fas fa-calendar-plus mr-2"></i>Schedule Appointment
                        </button>
                    </div>
                </div>
            `;
            
            document.body.appendChild(modal);
            console.log('✅ Modal created and added to DOM');
            
            // Add event listeners for appointment type selection
            const appointmentTypeCards = modal.querySelectorAll('.appointment-type-card');
            const submitBtn = modal.querySelector('#scheduleSubmitBtn');
            const appointmentTypeInput = modal.querySelector('#appointmentType');
            const selectedTypeDisplay = modal.querySelector('#selectedTypeDisplay');
            
            appointmentTypeCards.forEach(card => {
                card.addEventListener('click', function() {
                    // Remove active state from all cards
                    appointmentTypeCards.forEach(c => {
                        c.classList.remove('border-blue-500', 'bg-blue-50');
                        c.classList.add('border-gray-200');
                    });
                    
                    // Add active state to clicked card
                    this.classList.remove('border-gray-200');
                    this.classList.add('border-blue-500', 'bg-blue-50');
                    
                    // Update hidden input and display
                    const type = this.dataset.type;
                    appointmentTypeInput.value = type;
                    
                    // Show selected type display
                    selectedTypeDisplay.classList.remove('hidden');
                    const icon = selectedTypeDisplay.querySelector('#selectedTypeIcon');
                    const name = selectedTypeDisplay.querySelector('#selectedTypeName');
                    const description = selectedTypeDisplay.querySelector('#selectedTypeDescription');
                    
                    if (type === 'screening') {
                        icon.className = 'w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center';
                        icon.innerHTML = '<i class="fas fa-search text-yellow-600"></i>';
                        name.textContent = 'Screening';
                        description.textContent = 'Initial candidate evaluation';
                    } else if (type === 'interview') {
                        icon.className = 'w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center';
                        icon.innerHTML = '<i class="fas fa-comments text-blue-600"></i>';
                        name.textContent = 'Interview';
                        description.textContent = 'Formal candidate interview';
                    } else if (type === 'hiring') {
                        icon.className = 'w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center';
                        icon.innerHTML = '<i class="fas fa-handshake text-green-600"></i>';
                        name.textContent = 'Hiring';
                        description.textContent = 'Final hiring discussion';
                    }
                    
                    // Enable submit button
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50');
                });
            });
            
            console.log('✅ Event listeners set up');
            
        } catch (error) {
            console.error('❌ Error in showScheduleInterviewModal:', error);
            alert('An error occurred while opening the interview scheduler: ' + error.message);
        }
    };
    
    window.submitScheduleInterview = function() {
        console.log('📅 Submitting schedule interview form...');
        
        const form = document.getElementById('scheduleInterviewForm');
        const formData = new FormData(form);
        
        // Add CSRF token
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        
        // Show loading state
        const submitBtn = document.getElementById('scheduleSubmitBtn');
        const originalContent = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Scheduling...';
        submitBtn.disabled = true;
        
        fetch('/employer/interviews/schedule', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Interview scheduled successfully!');
                document.querySelector('.fixed.inset-0').remove();
                // Optionally refresh the page or update the UI
                location.reload();
            } else {
                alert('Error scheduling interview: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error scheduling interview. Please try again.');
        })
        .finally(() => {
            submitBtn.innerHTML = originalContent;
            submitBtn.disabled = false;
        });
    };
    
    // Notes Management Functions - Global scope
    window.saveCurrentNote = function() {
        const noteTextarea = document.getElementById('quickNote');
        const content = noteTextarea.value.trim();
        
        if (content) {
            console.log('💾 Manually saving note:', content);
            
            // Show saving state
            const saveStatus = document.getElementById('saveStatus');
            saveStatus.textContent = 'Saving...';
            saveStatus.className = 'text-xs text-blue-600';
            
            // Make API call to save note
            fetch('/employer/notes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ content: content })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('✅ Note saved successfully');
                    
                    // Clear the textarea
                    noteTextarea.value = '';
                    
                    // Show success feedback
                    saveStatus.textContent = '✅ Note saved!';
                    saveStatus.className = 'text-xs text-green-600';
                    
                    // Reset status after 2 seconds
                    setTimeout(() => {
                        saveStatus.textContent = 'Auto-saved';
                        saveStatus.className = 'text-xs text-gray-400';
                    }, 2000);
                    
                    // Refresh notes list
                    loadRecentNotes();
                    
                    // Show success toast
                    showToast('Note saved successfully!', 'success');
                } else {
                    console.error('❌ Error saving note:', data.message);
                    saveStatus.textContent = '❌ Save failed';
                    saveStatus.className = 'text-xs text-red-600';
                    
                    setTimeout(() => {
                        saveStatus.textContent = 'Auto-saved';
                        saveStatus.className = 'text-xs text-gray-400';
                    }, 3000);
                    
                    showToast('Failed to save note. Please try again.', 'error');
                }
            })
            .catch(error => {
                console.error('❌ Error saving note:', error);
                saveStatus.textContent = '❌ Save failed';
                saveStatus.className = 'text-xs text-red-600';
                
                setTimeout(() => {
                    saveStatus.textContent = 'Auto-saved';
                    saveStatus.className = 'text-xs text-gray-400';
                }, 3000);
                
                showToast('Network error. Please check your connection.', 'error');
            });
        } else {
            showToast('Please enter a note before saving.', 'warning');
        }
    };
    
    window.deleteNote = function(noteId) {
        if (confirm('Are you sure you want to delete this note?')) {
            console.log('🗑️ Deleting note:', noteId);
            
            // Show loading state on the note
            const noteElement = document.querySelector(`[data-note-id="${noteId}"]`);
            if (noteElement) {
                noteElement.style.opacity = '0.5';
                noteElement.style.pointerEvents = 'none';
            }
            
            fetch(`/employer/notes/${noteId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('✅ Note deleted successfully');
                    
                    // Remove the note with animation
                    if (noteElement) {
                        noteElement.style.transform = 'translateX(-100%)';
                        noteElement.style.transition = 'all 0.3s ease';
                        setTimeout(() => {
                            loadRecentNotes(); // Refresh the notes list
                        }, 300);
                    }
                    
                    showToast('Note deleted successfully!', 'success');
                } else {
                    console.error('❌ Error deleting note:', data.message);
                    
                    // Restore note appearance
                    if (noteElement) {
                        noteElement.style.opacity = '1';
                        noteElement.style.pointerEvents = 'auto';
                    }
                    
                    showToast('Failed to delete note. Please try again.', 'error');
                }
            })
            .catch(error => {
                console.error('❌ Error deleting note:', error);
                
                // Restore note appearance
                if (noteElement) {
                    noteElement.style.opacity = '1';
                    noteElement.style.pointerEvents = 'auto';
                }
                
                showToast('Network error. Please check your connection.', 'error');
            });
        }
    };
    
    window.showAllNotes = function() {
        console.log('👁️ Showing all notes modal');
        
        // Fetch all notes
        fetch('/employer/notes?all=true')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotesModal(data.notes);
                } else {
                    showToast('Failed to load notes. Please try again.', 'error');
                }
            })
            .catch(error => {
                console.error('Error loading all notes:', error);
                showToast('Network error. Please check your connection.', 'error');
            });
    };
    
    window.deleteNoteFromModal = function(noteId) {
        deleteNote(noteId);
        // Refresh the modal after a short delay
        setTimeout(() => {
            const modal = document.querySelector('.fixed.inset-0');
            if (modal) {
                modal.remove();
                showAllNotes(); // Reopen with updated data
            }
        }, 500);
    };
    
    function showNotesModal(notes) {
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4';
        modal.innerHTML = `
            <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full max-h-[80vh] overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-semibold text-gray-900">
                            <i class="fas fa-sticky-note text-yellow-600 mr-2"></i>All Notes
                        </h3>
                        <button onclick="this.closest('.fixed').remove()" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>
                <div class="p-6 overflow-y-auto max-h-96">
                    ${notes && notes.length > 0 ? 
                        notes.map(note => `
                            <div class="p-3 bg-yellow-50 rounded-lg border border-yellow-100 mb-3 note-item" data-note-id="${note.id}">
                                <p class="text-sm text-gray-700 mb-2">${escapeHtml(note.content)}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-500">${formatTimeAgo(note.created_at)}</span>
                                    <button onclick="deleteNoteFromModal(${note.id})" class="text-xs text-red-500 hover:text-red-700 transition">
                                        <i class="fas fa-trash mr-1"></i>Delete
                                    </button>
                                </div>
                            </div>
                        `).join('') :
                        `<div class="text-center py-8 text-gray-500">
                            <i class="fas fa-sticky-note text-4xl mb-4 opacity-50"></i>
                            <p>No notes found. Start adding some notes to keep track of important reminders!</p>
                        </div>`
                    }
                </div>
                <div class="p-6 border-t border-gray-200 text-center">
                    <button onclick="this.closest('.fixed').remove()" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        Close
                    </button>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
    }
    
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        const bgColor = type === 'success' ? 'bg-green-500' : 
                       type === 'error' ? 'bg-red-500' : 
                       type === 'warning' ? 'bg-yellow-500' : 'bg-blue-500';
        
        toast.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300`;
        toast.innerHTML = `
            <div class="flex items-center space-x-2">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 
                               type === 'error' ? 'fa-exclamation-circle' : 
                               type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle'}"></i>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        // Slide in
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 100);
        
        // Slide out and remove
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => {
                if (toast.parentNode) {
                    document.body.removeChild(toast);
                }
            }, 300);
        }, 3000);
    }
    
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    function formatTimeAgo(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const diffInSeconds = Math.floor((now - date) / 1000);
        
        if (diffInSeconds < 60) return 'Just now';
        if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)} min ago`;
        if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)} hours ago`;
        if (diffInSeconds < 604800) return `${Math.floor(diffInSeconds / 86400)} days ago`;
        return date.toLocaleDateString();
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🚀 Employer Dashboard JavaScript loaded!');
        
        // Function to handle hash changes from browser navigation
        function handleHashChange() {
            const hash = window.location.hash.substring(1);
            if (hash) {
                console.log('🔗 Hash detected:', hash);
                
                // Find the corresponding link and trigger its click
                const targetLink = document.querySelector(`[data-content="${hash}"]`);
                if (targetLink && targetLink.onclick) {
                    targetLink.onclick.call(targetLink);
                }
            } else {
                // Default to dashboard if no hash
                const dashboardLink = document.querySelector('[data-content="dashboard"]');
                if (dashboardLink && dashboardLink.onclick) {
                    dashboardLink.onclick.call(dashboardLink);
                }
            }
        }
        
        // Listen for hash changes (browser back/forward buttons)
        window.addEventListener('hashchange', handleHashChange);
        
        // Handle initial page load
        handleHashChange();
        
        // Make navigation functions globally available
        window.navigateTo = function(section) {
            window.history.pushState(null, null, '#' + section);
            handleHashChange();
        };
        
        // Innovative Dashboard Features JavaScript
        initializeDashboardFeatures();
        
        function initializeDashboardFeatures() {
            console.log('🚀 Initializing innovative dashboard features...');
            
            // Load initial data
            updateActivityFeed();
            loadRecentNotes();
            loadTodaysSchedule();
            
            // Real-time Activity Feed Auto-refresh
            setInterval(updateActivityFeed, 30000); // Update every 30 seconds
            
            // Quick Notes Auto-save
            const quickNoteTextarea = document.getElementById('quickNote');
            if (quickNoteTextarea) {
                let saveTimeout;
                quickNoteTextarea.addEventListener('input', function() {
                    clearTimeout(saveTimeout);
                    saveTimeout = setTimeout(() => {
                        saveQuickNote(this.value);
                    }, 1000); // Auto-save after 1 second of inactivity
                });
            }
            
            // Initialize Drag and Drop for Candidate Pipeline
            initializeCandidatePipeline();
            
            // Initialize Calendar Integration
            initializeCalendarFeatures();
        }
        
        function updateActivityFeed() {
            console.log('🔄 Updating activity feed...');
            
            // Fetch real activity data
            fetch('/employer/activity-feed')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateActivityDisplay(data.activities);
                        
                        // Add visual indicator for updates
                        const activityFeed = document.querySelector('.space-y-4.max-h-96');
                        if (activityFeed) {
                            activityFeed.classList.add('animate-pulse');
                            setTimeout(() => {
                                activityFeed.classList.remove('animate-pulse');
                            }, 1000);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error updating activity feed:', error);
                });
        }
        
        function updateActivityDisplay(activities) {
            const activityContainer = document.querySelector('.space-y-4.max-h-96');
            if (activityContainer && activities.length > 0) {
                activityContainer.innerHTML = activities.slice(0, 6).map(activity => {
                    const colorMap = {
                        'application': 'blue',
                        'job_view': 'green', 
                        'message': 'purple',
                        'interview': 'amber',
                        'skill_match': 'indigo',
                        'candidate_stage': 'teal'
                    };
                    const color = colorMap[activity.type] || 'gray';
                    
                    return `
                        <div class="flex items-start space-x-4 p-4 bg-${color}-50 rounded-lg border border-${color}-100 hover:bg-${color}-100 transition-colors group">
                            <div class="w-8 h-8 bg-${color}-500 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-${getActivityIcon(activity.type)} text-white text-xs"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-gray-900">${activity.title}</p>
                                    <span class="text-xs text-gray-500">${activity.created_at}</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">${activity.description}</p>
                                ${activity.type === 'skill_match' ? getSkillMatchDetails(activity) : ''}
                                <div class="flex items-center space-x-2 mt-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    ${getActivityActions(activity)}
                                </div>
                            </div>
                        </div>
                    `;
                }).join('');
            }
        }
        
        function getSkillMatchDetails(activity) {
            if (activity.metadata && activity.metadata.top_workers) {
                const workers = activity.metadata.top_workers.slice(0, 2);
                return `
                    <div class="mt-2 space-y-1">
                        ${workers.map(worker => `
                            <div class="flex items-center justify-between text-xs bg-white rounded p-2 border">
                                <div class="flex items-center space-x-2">
                                    <div class="w-6 h-6 bg-indigo-500 rounded-full flex items-center justify-center">
                                        <span class="text-white text-xs font-semibold">${worker.name.charAt(0)}</span>
                                    </div>
                                    <span class="font-medium text-gray-700">${worker.name}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-indigo-600 font-semibold">${Math.round(worker.match_score)}% match</span>
                                    <div class="flex space-x-1">
                                        ${worker.matching_skills.slice(0, 2).map(skill => 
                                            `<span class="bg-indigo-100 text-indigo-700 px-1 py-0.5 rounded text-xs">${skill}</span>`
                                        ).join('')}
                                    </div>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                `;
            }
            return '';
        }
        
        function getActivityIcon(type) {
            const icons = {
                'application': 'user-plus',
                'job_view': 'eye',
                'message': 'envelope',
                'interview': 'clock',
                'skill_match': 'users-cog',
                'candidate_stage': 'arrow-right'
            };
            return icons[type] || 'info-circle';
        }
        
        function getActivityActions(activity) {
            switch (activity.type) {
                case 'skill_match':
                    return `
                        <button onclick="viewSkillMatches(${activity.metadata?.job_id})" class="text-xs bg-indigo-600 text-white px-3 py-1 rounded-full hover:bg-indigo-700 transition">
                            View All Matches
                        </button>
                        <button onclick="contactWorker(${activity.metadata?.top_workers?.[0]?.id})" class="text-xs bg-green-600 text-white px-3 py-1 rounded-full hover:bg-green-700 transition">
                            Contact Top Match
                        </button>
                    `;
                case 'application':
                    return `
                        <button class="text-xs bg-blue-600 text-white px-3 py-1 rounded-full hover:bg-blue-700 transition">
                            View Application
                        </button>
                        <button class="text-xs bg-green-600 text-white px-3 py-1 rounded-full hover:bg-green-700 transition">
                            Quick Approve
                        </button>
                    `;
                case 'message':
                    return `
                        <button class="text-xs bg-purple-600 text-white px-3 py-1 rounded-full hover:bg-purple-700 transition">
                            Reply
                        </button>
                    `;
                case 'interview':
                    return `
                        <button class="text-xs bg-amber-600 text-white px-3 py-1 rounded-full hover:bg-amber-700 transition">
                            Reschedule
                        </button>
                        <button class="text-xs bg-green-600 text-white px-3 py-1 rounded-full hover:bg-green-700 transition">
                            Confirm
                        </button>
                    `;
                default:
                    return '';
            }
        }
        
        function saveQuickNote(content) {
            if (content.trim()) {
                console.log('💾 Auto-saving note:', content);
                
                // Make API call to save note
                fetch('/employer/notes', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ content: content })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('✅ Note saved successfully');
                        showNoteSavedFeedback();
                        // Refresh notes list
                        loadRecentNotes();
                    } else {
                        console.error('❌ Error saving note:', data.message);
                    }
                })
                .catch(error => {
                    console.error('❌ Error saving note:', error);
                });
            }
        }
        
        function loadRecentNotes() {
            fetch('/employer/notes')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateNotesDisplay(data.notes);
                    }
                })
                .catch(error => {
                    console.error('Error loading notes:', error);
                });
        }
        
        function updateNotesDisplay(notes) {
            const notesContainer = document.getElementById('recentNotesContainer');
            if (notesContainer) {
                if (notes && notes.length > 0) {
                    notesContainer.innerHTML = notes.slice(0, 3).map(note => `
                        <div class="p-2 bg-yellow-50 rounded border border-yellow-100 note-item" data-note-id="${note.id}">
                            <p class="text-xs text-gray-700">${escapeHtml(note.content)}</p>
                            <div class="flex justify-between items-center mt-1">
                                <span class="text-xs text-gray-400">${formatTimeAgo(note.created_at)}</span>
                                <button onclick="deleteNote(${note.id})" class="text-xs text-red-500 hover:text-red-700 transition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    `).join('');
                } else {
                    notesContainer.innerHTML = `
                        <div class="p-4 text-center text-gray-500">
                            <i class="fas fa-sticky-note text-2xl mb-2 opacity-50"></i>
                            <p class="text-xs">No notes yet. Add your first note above!</p>
                        </div>
                    `;
                }
            }
        }
        
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
        
        function formatTimeAgo(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diffInSeconds = Math.floor((now - date) / 1000);
            
            if (diffInSeconds < 60) return 'Just now';
            if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)} min ago`;
            if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)} hours ago`;
            if (diffInSeconds < 604800) return `${Math.floor(diffInSeconds / 86400)} days ago`;
            return date.toLocaleDateString();
        }
        
        // Mobile-friendly candidate movement function
        function showMobileMoveOptions(candidateId, candidateName) {
            console.log('📱 Mobile move options for:', candidateName);
            
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4';
            modal.innerHTML = `
                <div class="bg-white rounded-xl shadow-xl max-w-sm w-full">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Move ${candidateName}</h3>
                        <p class="text-sm text-gray-500 mt-1">Select the stage to move this candidate to:</p>
                    </div>
                    <div class="p-6 space-y-3">
                        <button onclick="moveCandidateToStage(${candidateId}, '${candidateName}', 'screening')" 
                                class="w-full p-3 text-left bg-yellow-50 border border-yellow-200 rounded-lg hover:bg-yellow-100 transition">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-yellow-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-search text-white text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-yellow-900">Screening</p>
                                    <p class="text-xs text-yellow-600">Review and evaluate candidate</p>
                                </div>
                            </div>
                        </button>
                        
                        <button onclick="moveCandidateToStage(${candidateId}, '${candidateName}', 'interview')" 
                                class="w-full p-3 text-left bg-purple-50 border border-purple-200 rounded-lg hover:bg-purple-100 transition">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-video text-white text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-purple-900">Interview</p>
                                    <p class="text-xs text-purple-600">Schedule interview with candidate</p>
                                </div>
                            </div>
                        </button>
                        
                        <button onclick="moveCandidateToStage(${candidateId}, '${candidateName}', 'hired')" 
                                class="w-full p-3 text-left bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 transition">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-check text-white text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-green-900">Hired</p>
                                    <p class="text-xs text-green-600">Candidate has been hired</p>
                                </div>
                            </div>
                        </button>
                    </div>
                    <div class="p-6 border-t border-gray-200">
                        <button onclick="this.closest('.fixed').remove()" 
                                class="w-full py-2 px-4 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                            Cancel
                        </button>
                    </div>
                </div>
            `;
            
            document.body.appendChild(modal);
        }
        
        // Function to move candidate to specific stage (works for both mobile and desktop)
        function moveCandidateToStage(candidateId, candidateName, newStage) {
            console.log('🔄 Moving candidate:', candidateName, 'to stage:', newStage);
            
            // Close any open modals
            const modal = document.querySelector('.fixed.inset-0');
            if (modal) modal.remove();
            
            // Show loading toast
            alert('Moving ' + candidateName + ' to ' + newStage + ' stage...');
            
            // Call the appropriate backend API based on the stage
            let apiUrl = '/employer/candidates/update-stage';
            let requestData = {
                candidate_id: candidateId,
                stage: newStage
            };
            
            // If moving to screening, use the specific screening endpoint
            if (newStage === 'screening') {
                apiUrl = '/employer/candidates/move-to-screening';
                requestData = {
                    candidate_id: candidateId,
                    screening_notes: `Moved to screening via mobile interface on ${new Date().toLocaleDateString()}`
                };
            }
            
            fetch(apiUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(requestData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`✅ ${candidateName} moved to ${newStage} stage successfully!`);
                    
                    // Refresh the page to show updated pipeline
                    location.reload();
                } else {
                    alert('❌ Failed to move candidate: ' + data.message);
                }
            })
            .catch(error => {
                console.error('❌ Error moving candidate:', error);
                alert('❌ Error moving candidate. Please try again.');
            });
        }
        
        // Make functions globally available
        window.showMobileMoveOptions = showMobileMoveOptions;
        window.moveCandidateToStage = moveCandidateToStage;
        
        function initializeCandidatePipeline() {
            console.log('🎯 Initializing candidate pipeline...');
            
            const candidateCards = document.querySelectorAll('[draggable="true"]');
            const dropZones = document.querySelectorAll('.border-dashed');
            
            console.log('🔍 Found candidate cards:', candidateCards.length);
            console.log('🔍 Found drop zones:', dropZones.length);
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ content: content })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('✅ Note saved successfully');
                        
                        // Clear the textarea
                        noteTextarea.value = '';
                        
                        // Show success feedback
                        saveStatus.textContent = '✅ Note saved!';
                        saveStatus.className = 'text-xs text-green-600';
                        
                        // Reset status after 2 seconds
                        setTimeout(() => {
                            saveStatus.textContent = 'Auto-saved';
                            saveStatus.className = 'text-xs text-gray-400';
                        }, 2000);
                        
                        // Refresh notes list
                        loadRecentNotes();
                        
                        // Show success toast
                        showToast('Note saved successfully!', 'success');
                    } else {
                        console.error('❌ Error saving note:', data.message);
                        saveStatus.textContent = '❌ Save failed';
                        saveStatus.className = 'text-xs text-red-600';
                        
                        setTimeout(() => {
                            saveStatus.textContent = 'Auto-saved';
                            saveStatus.className = 'text-xs text-gray-400';
                        }, 3000);
                        
                        showToast('Failed to save note. Please try again.', 'error');
                    }
                })
                .catch(error => {
                    console.error('❌ Error saving note:', error);
                    saveStatus.textContent = '❌ Save failed';
                    saveStatus.className = 'text-xs text-red-600';
                    
                    setTimeout(() => {
                        saveStatus.textContent = 'Auto-saved';
                        saveStatus.className = 'text-xs text-gray-400';
                    }, 3000);
                    
                    showToast('Network error. Please check your connection.', 'error');
                });
            } else {
                showToast('Please enter a note before saving.', 'warning');
            }
        };
        
        window.deleteNote = function(noteId) {
            if (confirm('Are you sure you want to delete this note?')) {
                console.log('🗑️ Deleting note:', noteId);
                
                // Show loading state on the note
                const noteElement = document.querySelector(`[data-note-id="${noteId}"]`);
                if (noteElement) {
                    noteElement.style.opacity = '0.5';
                    noteElement.style.pointerEvents = 'none';
                }
                
                fetch(`/employer/notes/${noteId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('✅ Note deleted successfully');
                        
                        // Remove the note with animation
                        if (noteElement) {
                            noteElement.style.transform = 'translateX(-100%)';
                            noteElement.style.transition = 'all 0.3s ease';
                            setTimeout(() => {
                                loadRecentNotes(); // Refresh the notes list
                            }, 300);
                        }
                        
                        showToast('Note deleted successfully!', 'success');
                    } else {
                        console.error('❌ Error deleting note:', data.message);
                        
                        // Restore note appearance
                        if (noteElement) {
                            noteElement.style.opacity = '1';
                            noteElement.style.pointerEvents = 'auto';
                        }
                        
                        showToast('Failed to delete note. Please try again.', 'error');
                    }
                })
                .catch(error => {
                    console.error('❌ Error deleting note:', error);
                    
                    // Restore note appearance
                    if (noteElement) {
                        noteElement.style.opacity = '1';
                        noteElement.style.pointerEvents = 'auto';
                    }
                    
                    showToast('Network error. Please check your connection.', 'error');
                });
            }
        };
        
        window.showAllNotes = function() {
            console.log('👁️ Showing all notes modal');
            
            // Fetch all notes
            fetch('/employer/notes?all=true')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotesModal(data.notes);
                    } else {
                        showToast('Failed to load notes. Please try again.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error loading all notes:', error);
                    showToast('Network error. Please check your connection.', 'error');
                });
        };
        
        function showNotesModal(notes) {
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4';
            modal.innerHTML = `
                <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full max-h-[80vh] overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-semibold text-gray-900">
                                <i class="fas fa-sticky-note text-yellow-600 mr-2"></i>All Notes
                            </h3>
                            <button onclick="this.closest('.fixed').remove()" class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                    </div>
                    <div class="p-6 overflow-y-auto max-h-96">
                        ${notes && notes.length > 0 ? 
                            notes.map(note => `
                                <div class="p-3 bg-yellow-50 rounded-lg border border-yellow-100 mb-3 note-item" data-note-id="${note.id}">
                                    <p class="text-sm text-gray-700 mb-2">${escapeHtml(note.content)}</p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-gray-500">${formatTimeAgo(note.created_at)}</span>
                                        <button onclick="deleteNoteFromModal(${note.id})" class="text-xs text-red-500 hover:text-red-700 transition">
                                            <i class="fas fa-trash mr-1"></i>Delete
                                        </button>
                                    </div>
                                </div>
                            `).join('') :
                            `<div class="text-center py-8 text-gray-500">
                                <i class="fas fa-sticky-note text-4xl mb-4 opacity-50"></i>
                                <p>No notes found. Start adding some notes to keep track of important reminders!</p>
                            </div>`
                        }
                    </div>
                    <div class="p-6 border-t border-gray-200 text-center">
                        <button onclick="this.closest('.fixed').remove()" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                            Close
                        </button>
                    </div>
                </div>
            `;
            
            document.body.appendChild(modal);
        }
        
        window.deleteNoteFromModal = function(noteId) {
            deleteNote(noteId);
            // Refresh the modal after a short delay
            setTimeout(() => {
                const modal = document.querySelector('.fixed.inset-0');
                if (modal) {
                    modal.remove();
                    showAllNotes(); // Reopen with updated data
                }
            }, 500);
        };
        
        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            const bgColor = type === 'success' ? 'bg-green-500' : 
                           type === 'error' ? 'bg-red-500' : 
                           type === 'warning' ? 'bg-yellow-500' : 'bg-blue-500';
            
            toast.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300`;
            toast.innerHTML = `
                <div class="flex items-center space-x-2">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : 
                                   type === 'error' ? 'fa-exclamation-circle' : 
                                   type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle'}"></i>
                    <span>${message}</span>
                </div>
            `;
            
            document.body.appendChild(toast);
            
            // Slide in
            setTimeout(() => {
                toast.classList.remove('translate-x-full');
            }, 100);
            
            // Slide out and remove
            setTimeout(() => {
                toast.classList.add('translate-x-full');
                setTimeout(() => {
                    if (toast.parentNode) {
                        document.body.removeChild(toast);
                    }
                }, 300);
            }, 3000);
        }
        
        function showNoteSavedFeedback() {
            const saveStatus = document.getElementById('saveStatus');
            if (saveStatus) {
                saveStatus.textContent = '✅ Saved';
                saveStatus.className = 'text-xs text-green-600';
                setTimeout(() => {
                    saveStatus.textContent = 'Auto-saved';
                    saveStatus.className = 'text-xs text-gray-400';
                }, 2000);
            }
        }
        
        // Mobile-friendly candidate movement function
        function showMobileMoveOptions(candidateId, candidateName) {
            console.log('📱 Mobile move options for:', candidateName);
            
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4';
            modal.innerHTML = `
                <div class="bg-white rounded-xl shadow-xl max-w-sm w-full">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Move ${candidateName}</h3>
                        <p class="text-sm text-gray-500 mt-1">Select the stage to move this candidate to:</p>
                    </div>
                    <div class="p-6 space-y-3">
                        <button onclick="moveCandidateToStage(${candidateId}, '${candidateName}', 'screening')" 
                                class="w-full p-3 text-left bg-yellow-50 border border-yellow-200 rounded-lg hover:bg-yellow-100 transition">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-yellow-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-search text-white text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-yellow-900">Screening</p>
                                    <p class="text-xs text-yellow-600">Review and evaluate candidate</p>
                                </div>
                            </div>
                        </button>
                        
                        <button onclick="moveCandidateToStage(${candidateId}, '${candidateName}', 'interview')" 
                                class="w-full p-3 text-left bg-purple-50 border border-purple-200 rounded-lg hover:bg-purple-100 transition">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-video text-white text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-purple-900">Interview</p>
                                    <p class="text-xs text-purple-600">Schedule interview with candidate</p>
                                </div>
                            </div>
                        </button>
                        
                        <button onclick="moveCandidateToStage(${candidateId}, '${candidateName}', 'hired')" 
                                class="w-full p-3 text-left bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 transition">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-check text-white text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-green-900">Hired</p>
                                    <p class="text-xs text-green-600">Candidate has been hired</p>
                                </div>
                            </div>
                        </button>
                    </div>
                    <div class="p-6 border-t border-gray-200">
                        <button onclick="this.closest('.fixed').remove()" 
                                class="w-full py-2 px-4 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                            Cancel
                        </button>
                    </div>
                </div>
            `;
            
            document.body.appendChild(modal);
        }
        
        // Function to move candidate to specific stage (works for both mobile and desktop)
        function moveCandidateToStage(candidateId, candidateName, newStage) {
            console.log('🔄 Moving candidate:', candidateName, 'to stage:', newStage);
            
            // Close any open modals
            const modal = document.querySelector('.fixed.inset-0');
            if (modal) modal.remove();
            
            // Show loading toast
            alert('Moving ' + candidateName + ' to ' + newStage + ' stage...');
            
            // Call the appropriate backend API based on the stage
            let apiUrl = '/employer/candidates/update-stage';
            let requestData = {
                candidate_id: candidateId,
                stage: newStage
            };
            
            // If moving to screening, use the specific screening endpoint
            if (newStage === 'screening') {
                apiUrl = '/employer/candidates/move-to-screening';
                requestData = {
                    candidate_id: candidateId,
                    screening_notes: `Moved to screening via mobile interface on ${new Date().toLocaleDateString()}`
                };
            }
            
            fetch(apiUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(requestData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`✅ ${candidateName} moved to ${newStage} stage successfully!`);
                    
                    // Refresh the page to show updated pipeline
                    location.reload();
                } else {
                    alert('❌ Failed to move candidate: ' + data.message);
                }
            })
            .catch(error => {
                console.error('❌ Error moving candidate:', error);
                alert('❌ Error moving candidate. Please try again.');
            });
        }
        
        // Make functions globally available
        window.showMobileMoveOptions = showMobileMoveOptions;
        window.moveCandidateToStage = moveCandidateToStage;
        
        function initializeCandidatePipeline() {
            console.log('🎯 Initializing candidate pipeline...');
            
            const candidateCards = document.querySelectorAll('[draggable="true"]');
            const dropZones = document.querySelectorAll('.border-dashed');
            
            console.log('🔍 Found candidate cards:', candidateCards.length);
            console.log('🔍 Found drop zones:', dropZones.length);
            
            // Debug: Log all candidate cards
            candidateCards.forEach((card, index) => {
                const candidateId = card.getAttribute('data-candidate-id');
                const candidateName = card.getAttribute('data-candidate-name');
                const currentStage = card.getAttribute('data-current-stage');
                console.log(`Card ${index}:`, {candidateId, candidateName, currentStage});
            });
            
            // Debug: Log all drop zones
            dropZones.forEach((zone, index) => {
                const stage = zone.getAttribute('data-stage');
                console.log(`Drop zone ${index}:`, {stage, element: zone});
            });
            
            candidateCards.forEach(card => {
                card.addEventListener('dragstart', function(e) {
                    console.log('🎯 DRAGSTART EVENT TRIGGERED');
                    
                    // Store candidate data for the drop event
                    const candidateId = this.getAttribute('data-candidate-id');
                    const candidateName = this.getAttribute('data-candidate-name');
                    const currentStage = this.getAttribute('data-current-stage');
                    
                    console.log('🎯 Dragging candidate:', {candidateId, candidateName, currentStage});
                    
                    e.dataTransfer.setData('text/plain', this.outerHTML);
                    e.dataTransfer.setData('candidate-id', candidateId);
                    e.dataTransfer.setData('candidate-name', candidateName);
                    e.dataTransfer.setData('current-stage', currentStage);
                    
                    this.style.opacity = '0.5';
                    console.log('🎯 Started dragging candidate:', candidateName, 'ID:', candidateId);
                });
                
                card.addEventListener('dragend', function(e) {
                    console.log('🎯 DRAGEND EVENT TRIGGERED');
                    this.style.opacity = '1';
                    console.log('🎯 Finished dragging candidate');
                });
            });
            
            dropZones.forEach(zone => {
                zone.addEventListener('dragover', function(e) {
                    console.log('🎯 DRAGOVER EVENT TRIGGERED');
                    e.preventDefault();
                    this.classList.add('bg-blue-100', 'border-blue-400');
                });
                
                zone.addEventListener('dragleave', function(e) {
                    console.log('🎯 DRAGLEAVE EVENT TRIGGERED');
                    this.classList.remove('bg-blue-100', 'border-blue-400');
                });
                
                zone.addEventListener('drop', function(e) {
                    console.log('🎯 DROP EVENT TRIGGERED');
                    e.preventDefault();
                    this.classList.remove('bg-blue-100', 'border-blue-400');
                    
                    const candidateHtml = e.dataTransfer.getData('text/plain');
                    const candidateId = e.dataTransfer.getData('candidate-id');
                    const candidateName = e.dataTransfer.getData('candidate-name');
                    const currentStage = e.dataTransfer.getData('current-stage');
                    const newStage = this.getAttribute('data-stage');
                    
                    console.log('🎯 Drop data:', {candidateId, candidateName, currentStage, newStage});
                    
                    if (!candidateId || !newStage) {
                        console.error('❌ Missing candidate ID or stage information');
                        alert('Error: Missing candidate information');
                        return;
                    }
                    
                    // Show loading state
                    this.innerHTML = '<div class="flex items-center justify-center p-4"><div class="animate-spin rounded-full h-6 w-6 border-b-2 border-indigo-600"></div><span class="ml-2 text-sm text-gray-600">Moving candidate...</span></div>';
                    
                    // Call the appropriate backend API based on the stage
                    let apiUrl = '/employer/candidates/update-stage';
                    let requestData = {
                        candidate_id: candidateId,
                        stage: newStage
                    };
                    
                    // If moving to screening, use the specific screening endpoint
                    if (newStage === 'screening') {
                        apiUrl = '/employer/candidates/move-to-screening';
                        requestData = {
                            candidate_id: candidateId,
                            screening_notes: `Moved to screening via drag and drop on ${new Date().toLocaleDateString()}`
                        };
                    }
                    
                    console.log('🔄 Making API call:', {apiUrl, requestData});
                    
                    fetch(apiUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(requestData)
                    })
                    .then(response => {
                        console.log('📡 API Response status:', response.status);
                        return response.json();
                    })
                    .then(data => {
                        console.log('📡 API Response data:', data);
                        
                        if (data.success) {
                            // Remove the dashed border placeholder and add the candidate
                            this.innerHTML = candidateHtml;
                            this.classList.remove('border-dashed', 'flex', 'items-center', 'justify-center');
                            
                            // Update the candidate card's stage attribute
                            const candidateCard = this.querySelector('[draggable="true"]');
                            if (candidateCard) {
                                candidateCard.setAttribute('data-current-stage', newStage);
                            }
                            
                            console.log('✅ Candidate moved successfully to', newStage);
                            alert(`${candidateName} moved to ${newStage} stage successfully!`);
                            
                            // Refresh activity feed to show the update
                            if (typeof updateActivityFeed === 'function') {
                                updateActivityFeed();
                            }
                        } else {
                            console.error('❌ Failed to move candidate:', data.message);
                            alert('Failed to move candidate: ' + data.message);
                            
                            // Reset the drop zone
                            this.innerHTML = '<p class="text-xs text-yellow-600">Drop candidates here</p>';
                            this.classList.add('border-dashed', 'flex', 'items-center', 'justify-center');
                        }
                    })
                    .catch(error => {
                        console.error('❌ Error moving candidate:', error);
                        alert('Error moving candidate. Please try again.');
                        
                        // Reset the drop zone
                        this.innerHTML = '<p class="text-xs text-yellow-600">Drop candidates here</p>';
                        this.classList.add('border-dashed', 'flex', 'items-center', 'justify-center');
                    });
                });
            });
            
            console.log('✅ Candidate pipeline initialization complete');
        }
        
        function initializeCalendarFeatures() {
            console.log('📅 Initializing calendar features...');
            
            // Wait a bit for DOM to be fully ready
            setTimeout(() => {
                // Initialize other dashboard features
                console.log('✅ Dashboard features initialized');
            }, 100); // Reduced timeout
        }
                
                // Create the enhanced modal
                const modal = document.createElement('div');
                modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4';
                modal.innerHTML = `
                    <div class="bg-white rounded-xl shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex justify-between items-center">
                                <h3 class="text-xl font-semibold text-gray-900">Schedule Appointment</h3>
                                <button onclick="this.closest('.fixed').remove()" class="text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-times text-xl"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Appointment Type Selection -->
                        <div class="p-6 border-b border-gray-100">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Select Appointment Type</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="appointment-type-card cursor-pointer p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all duration-200" data-type="screening">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-search text-yellow-600"></i>
                                        </div>
                                        <div>
                                            <h5 class="font-medium text-gray-900">Screening</h5>
                                            <p class="text-sm text-gray-600">Initial candidate evaluation</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="appointment-type-card cursor-pointer p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all duration-200" data-type="interview">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-comments text-blue-600"></i>
                                        </div>
                                        <div>
                                            <h5 class="font-medium text-gray-900">Interview</h5>
                                            <p class="text-sm text-gray-600">Formal candidate interview</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="appointment-type-card cursor-pointer p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all duration-200" data-type="hiring">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-handshake text-green-600"></i>
                                        </div>
                                        <div>
                                            <h5 class="font-medium text-gray-900">Hiring</h5>
                                            <p class="text-sm text-gray-600">Final hiring discussion</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <form id="scheduleInterviewForm" class="p-6 space-y-6">
                            <input type="hidden" id="appointmentType" name="appointment_type" value="">
                            
                            <!-- Selected Type Display -->
                            <div id="selectedTypeDisplay" class="hidden bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-lg border border-blue-200">
                                <div class="flex items-center space-x-3">
                                    <div id="selectedTypeIcon" class="w-8 h-8 rounded-lg flex items-center justify-center"></div>
                                    <div>
                                        <h4 class="font-medium text-blue-900" id="selectedTypeName"></h4>
                                        <p class="text-sm text-blue-700" id="selectedTypeDescription"></p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Job Position *</label>
                                    <select id="jobSelect" name="job_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                        <option value="">Select Job Position</option>
                                        ${jobsData.jobs.map(job => `
                                            <option value="${job.id}">${job.title} (${job.applications_count} applications)</option>
                                        `).join('')}
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Candidate *</label>
                                    <select id="candidateSelect" name="candidate_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                        <option value="">Select Candidate</option>
                                        ${candidatesData.candidates.map(candidate => `
                                            <option value="${candidate.id}" data-job-id="${candidate.job_id}" data-email="${candidate.email}" data-phone="${candidate.phone}">
                                                ${candidate.name} - ${candidate.job_title} (${candidate.stage})
                                            </option>
                                        `).join('')}
                                    </select>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Date & Time *</label>
                                    <input type="datetime-local" id="scheduledAt" name="scheduled_at" required 
                                           min="${new Date().toISOString().slice(0, 16)}"
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Meeting Type *</label>
                                    <select id="interviewType" name="type" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                        <option value="">Select Type</option>
                                        <option value="video">Video Call</option>
                                        <option value="phone">Phone Call</option>
                                        <option value="in-person">In-Person</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Duration and Location -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Duration (minutes)</label>
                                    <select id="duration" name="duration" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                        <option value="30">30 minutes</option>
                                        <option value="45">45 minutes</option>
                                        <option value="60" selected>1 hour</option>
                                        <option value="90">1.5 hours</option>
                                        <option value="120">2 hours</option>
                                    </select>
                                </div>
                                <div id="locationField" class="hidden">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Location/Meeting Link</label>
                                    <input type="text" id="location" name="location" 
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                           placeholder="Enter meeting location or video call link">
                                </div>
                            </div>
                            
                            <!-- Appointment-specific fields -->
                            <div id="screeningFields" class="hidden space-y-4">
                                <h5 class="font-medium text-gray-900">Screening Details</h5>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Focus Areas</label>
                                        <div class="space-y-2">
                                            <label class="flex items-center">
                                                <input type="checkbox" name="screening_focus[]" value="skills" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                                <span class="ml-2 text-sm text-gray-700">Technical Skills</span>
                                            </label>
                                            <label class="flex items-center">
                                                <input type="checkbox" name="screening_focus[]" value="experience" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                                <span class="ml-2 text-sm text-gray-700">Work Experience</span>
                                            </label>
                                            <label class="flex items-center">
                                                <input type="checkbox" name="screening_focus[]" value="culture" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                                <span class="ml-2 text-sm text-gray-700">Cultural Fit</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="interviewFields" class="hidden space-y-4">
                                <h5 class="font-medium text-gray-900">Interview Details</h5>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Interview Round</label>
                                        <select name="interview_round" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                            <option value="1">First Round</option>
                                            <option value="2">Second Round</option>
                                            <option value="3">Final Round</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Interviewers</label>
                                        <input type="text" name="interviewers" 
                                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                               placeholder="Names of interviewers">
                                    </div>
                                </div>
                            </div>
                            
                            <div id="hiringFields" class="hidden space-y-4">
                                <h5 class="font-medium text-gray-900">Hiring Discussion</h5>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Salary Discussion</label>
                                        <select name="salary_discussion" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                            <option value="yes">Yes, discuss salary</option>
                                            <option value="no">No, salary already agreed</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Start Date Discussion</label>
                                        <select name="start_date_discussion" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                            <option value="yes">Yes, discuss start date</option>
                                            <option value="no">Start date already set</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Notes (Optional)</label>
                                <textarea id="interviewNotes" name="notes" rows="3" 
                                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                          placeholder="Add any additional notes or instructions for the appointment..."></textarea>
                            </div>
                            
                            <!-- Candidate Info Display -->
                            <div id="candidateInfo" class="hidden bg-blue-50 p-4 rounded-lg border border-blue-200">
                                <h4 class="text-sm font-medium text-blue-900 mb-2">Candidate Information</h4>
                                <div class="text-sm text-blue-800 space-y-1">
                                    <p><strong>Email:</strong> <span id="candidateEmail"></span></p>
                                    <p><strong>Phone:</strong> <span id="candidatePhone"></span></p>
                                    <p><strong>Application Stage:</strong> <span id="candidateStage"></span></p>
                                </div>
                            </div>
                            
                            <!-- Conflict Warning -->
                            <div id="conflictWarning" class="hidden bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                                <div class="flex items-start space-x-2">
                                    <i class="fas fa-exclamation-triangle text-yellow-600 mt-0.5"></i>
                                    <div>
                                        <h4 class="text-sm font-medium text-yellow-800">Schedule Conflict Detected</h4>
                                        <div id="conflictDetails" class="text-sm text-yellow-700 mt-1"></div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        
                        <div class="p-6 border-t border-gray-200 flex justify-end space-x-3">
                            <button onclick="this.closest('.fixed').remove()" class="px-6 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                                Cancel
                            </button>
                            <button id="scheduleSubmitBtn" onclick="submitScheduleInterview()" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition" disabled>
                                <i class="fas fa-calendar-plus mr-2"></i>Schedule Appointment
                            </button>
                        </div>
                    </div>
                `;
                
                document.body.appendChild(modal);
                
                console.log('✅ Modal created and added to DOM');
            })
            .catch(error => {
                console.error('❌ Error loading interview data:', error);
                alert('Error loading interview scheduling data. Please check your connection and try again.');
            });
        } catch (error) {
            console.error('❌ Error in showScheduleInterviewModal:', error);
            alert('An error occurred while opening the interview scheduler. Please try again.');
        }
    }
                candidateStage.textContent = option.textContent.split('(')[1]?.replace(')', '') || 'Unknown';
                
                candidateInfo.classList.remove('hidden');
            }
            
            function hideCandidateInfo() {
                document.getElementById('candidateInfo').classList.add('hidden');
            }
            
            function checkScheduleConflicts(scheduledDateTime) {
                if (!scheduledDateTime) return;
                
                // This would typically make an API call to check for conflicts
                // For now, we'll simulate conflict checking
                console.log('Checking schedule conflicts for:', scheduledDateTime);
                
                // Hide conflict warning by default
                document.getElementById('conflictWarning').classList.add('hidden');
                
                // Simulate conflict detection (you would replace this with actual API call)
                setTimeout(() => {
                    const hasConflict = Math.random() < 0.2; // 20% chance of conflict for demo
                    
                    if (hasConflict) {
                        const conflictWarning = document.getElementById('conflictWarning');
                        const conflictDetails = document.getElementById('conflictDetails');
                        
                        conflictDetails.innerHTML = `
                            <p>You have another appointment scheduled at this time:</p>
                            <p class="font-medium mt-1">Interview with John Doe - Software Developer (2:00 PM - 3:00 PM)</p>
                            <p class="mt-1">Consider rescheduling to avoid conflicts.</p>
                        `;
                        
                        conflictWarning.classList.remove('hidden');
                    }
                }, 500);
            }
        }
        
        function checkInterviewConflicts(scheduledAt) {
            fetch('/employer/interviews/check-conflicts', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ scheduled_at: scheduledAt })
            })
            .then(response => response.json())
            .then(data => {
                const conflictWarning = document.getElementById('conflictWarning');
                const conflictDetails = document.getElementById('conflictDetails');
                
                if (data.success && data.has_conflicts) {
                    const conflictList = data.conflicts.map(conflict => 
                        `• ${conflict.candidate_name} - ${conflict.job_title} at ${conflict.scheduled_at}`
                    ).join('<br>');
                    
                    conflictDetails.innerHTML = conflictList;
                    conflictWarning.classList.remove('hidden');
                } else {
                    conflictWarning.classList.add('hidden');
                }
            })
            .catch(error => {
                console.error('Error checking conflicts:', error);
            });
        }
        
        function submitScheduleInterview() {
            const form = document.getElementById('scheduleInterviewForm');
            const formData = new FormData(form);
            
            // Get appointment type
            const appointmentType = document.getElementById('appointmentType').value;
            
            // Validate required fields
            const requiredFields = ['job_id', 'candidate_id', 'scheduled_at', 'type'];
            const missingFields = requiredFields.filter(field => !formData.get(field));
            
            if (!appointmentType) {
                showToast('Please select an appointment type', 'error');
                return;
            }
            
            if (missingFields.length > 0) {
                showToast('Please fill in all required fields', 'error');
                return;
            }
            
            // Show loading state
            const submitBtn = document.getElementById('scheduleSubmitBtn');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Scheduling...';
            submitBtn.disabled = true;
            
            // Prepare appointment data
            const appointmentData = {
                job_id: formData.get('job_id'),
                candidate_id: formData.get('candidate_id'),
                scheduled_at: formData.get('scheduled_at'),
                type: formData.get('type'),
                appointment_type: appointmentType,
                duration: formData.get('duration') || 60,
                location: formData.get('location') || '',
                notes: formData.get('notes') || '',
            };
            
            // Add appointment-specific data
            if (appointmentType === 'screening') {
                const screeningFocus = Array.from(form.querySelectorAll('input[name="screening_focus[]"]:checked'))
                    .map(cb => cb.value);
                appointmentData.screening_focus = screeningFocus;
            } else if (appointmentType === 'interview') {
                appointmentData.interview_round = formData.get('interview_round') || 1;
                appointmentData.interviewers = formData.get('interviewers') || '';
            } else if (appointmentType === 'hiring') {
                appointmentData.salary_discussion = formData.get('salary_discussion') === 'yes';
                appointmentData.start_date_discussion = formData.get('start_date_discussion') === 'yes';
            }
            
            // Submit the form
            fetch('/employer/interviews/schedule', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(appointmentData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const appointmentTypeNames = {
                        'screening': 'Screening',
                        'interview': 'Interview',
                        'hiring': 'Hiring Meeting'
                    };
                    
                    showToast(`${appointmentTypeNames[appointmentType]} scheduled successfully!`, 'success');
                    
                    // Close modal
                    document.querySelector('.fixed.inset-0').remove();
                    
                    // Refresh activity feed and calendar
                    updateActivityFeed();
                    loadTodaysSchedule();
                    
                    // Ask if user wants to send notification
                    setTimeout(() => {
                        const appointmentName = appointmentTypeNames[appointmentType].toLowerCase();
                        if (confirm(`Would you like to send a notification to the candidate about this ${appointmentName}?`)) {
                            sendInterviewNotification(data.interview.id);
                        }
                    }, 1000);
                } else {
                    showToast('Error scheduling appointment: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error scheduling appointment:', error);
                showToast('Error scheduling appointment. Please try again.', 'error');
            })
            .finally(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        }
        
        function sendInterviewNotification(interviewId) {
            fetch(`/employer/interviews/${interviewId}/notify`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Notification sent to candidate!', 'success');
                } else {
                    showToast('Interview scheduled but notification failed to send', 'warning');
                }
            })
            .catch(error => {
                console.error('Error sending notification:', error);
                showToast('Interview scheduled but notification failed to send', 'warning');
            });
        }
        
        function scheduleInterview() {
            console.log('📅 Scheduling interview...');
            
            // Get form data from the modal
            const modal = document.querySelector('.fixed.inset-0');
            if (modal) {
                const candidateSelect = modal.querySelector('select');
                const dateTimeInput = modal.querySelector('input[type="datetime-local"]');
                const typeSelect = modal.querySelectorAll('select')[1];
                
                const formData = {
                    candidate_id: candidateSelect.value,
                    job_id: 20, // This should be dynamic based on context
                    scheduled_at: dateTimeInput.value,
                    type: typeSelect.value.toLowerCase().replace(' ', '-'),
                    notes: 'Scheduled via dashboard'
                };
                
                // Make API call
                fetch('/employer/interviews/schedule', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('Interview scheduled successfully!', 'success');
                        // Refresh activity feed and calendar
                        updateActivityFeed();
                        loadTodaysSchedule();
                    } else {
                        showToast('Error scheduling interview: ' + data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error scheduling interview:', error);
                    showToast('Error scheduling interview', 'error');
                });
            }
        }
        
        function loadTodaysSchedule() {
            fetch('/employer/interviews/today')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateCalendarDisplay(data.interviews);
                        
                        // Update the calendar header with count
                        const calendarHeader = document.querySelector('.text-sm.font-semibold.text-gray-900');
                        if (calendarHeader && calendarHeader.textContent.includes("Today's Schedule")) {
                            calendarHeader.textContent = `Today's Schedule (${data.count} interviews)`;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error loading schedule:', error);
                });
        }
        
        function updateCalendarDisplay(interviews) {
            const calendarContainer = document.querySelector('.space-y-3');
            if (calendarContainer) {
                if (interviews.length > 0) {
                    calendarContainer.innerHTML = interviews.map(interview => {
                        const statusColors = {
                            'scheduled': 'blue',
                            'rescheduled': 'yellow',
                            'completed': 'green',
                            'cancelled': 'red'
                        };
                        const color = statusColors[interview.status] || 'blue';
                        
                        return `
                            <div class="flex items-center space-x-3 p-3 bg-${color}-50 rounded-lg border border-${color}-100 hover:bg-${color}-100 transition-colors group">
                                <div class="w-3 h-3 bg-${color}-500 rounded-full flex-shrink-0"></div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            ${interview.candidate_name} - ${interview.job_title}
                                        </p>
                                        <span class="text-xs text-${color}-600 font-medium">${interview.scheduled_at}</span>
                                    </div>
                                    <div class="flex items-center justify-between mt-1">
                                        <p class="text-xs text-gray-500">${interview.type} • ${interview.time_until}</p>
                                        <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button onclick="rescheduleInterview(${interview.id})" class="text-xs text-${color}-600 hover:text-${color}-800 mr-2">
                                                Reschedule
                                            </button>
                                            <button onclick="viewInterviewDetails(${interview.id})" class="text-xs text-${color}-600 hover:text-${color}-800">
                                                Details
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    }).join('');
                } else {
                    calendarContainer.innerHTML = `
                        <div class="text-center py-6 text-gray-500">
                            <i class="fas fa-calendar-day text-2xl mb-2"></i>
                            <p class="text-sm">No interviews scheduled for today</p>
                        </div>
                    `;
                }
            }
        }
        
        function rescheduleInterview(interviewId) {
            // Create reschedule modal
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4';
            modal.innerHTML = `
                <div class="bg-white rounded-xl shadow-xl max-w-md w-full">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Reschedule Interview</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">New Date & Time *</label>
                            <input type="datetime-local" id="newScheduledAt" required 
                                   min="${new Date().toISOString().slice(0, 16)}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Reason (Optional)</label>
                            <textarea id="rescheduleReason" rows="3" 
                                      class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                      placeholder="Reason for rescheduling..."></textarea>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 flex justify-end space-x-3">
                        <button onclick="this.closest('.fixed').remove()" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                            Cancel
                        </button>
                        <button onclick="submitReschedule(${interviewId})" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            Reschedule
                        </button>
                    </div>
                </div>
            `;
            
            document.body.appendChild(modal);
        }
        
        function submitReschedule(interviewId) {
            const newScheduledAt = document.getElementById('newScheduledAt').value;
            const reason = document.getElementById('rescheduleReason').value;
            
            if (!newScheduledAt) {
                showToast('Please select a new date and time', 'error');
                return;
            }
            
            fetch(`/employer/interviews/${interviewId}/reschedule`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    scheduled_at: newScheduledAt,
                    reason: reason
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Interview rescheduled successfully!', 'success');
                    document.querySelector('.fixed.inset-0').remove();
                    loadTodaysSchedule();
                    updateActivityFeed();
                } else {
                    showToast('Error rescheduling interview: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error rescheduling interview:', error);
                showToast('Error rescheduling interview', 'error');
            });
        }
        
        function viewInterviewDetails(interviewId) {
            // This would show detailed interview information
            showToast('Interview details feature coming soon!', 'info');
        }
        
        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white transform translate-x-full transition-transform duration-300 ${
                type === 'success' ? 'bg-green-600' : 
                type === 'error' ? 'bg-red-600' : 
                'bg-blue-600'
            }`;
            toast.textContent = message;
            
            document.body.appendChild(toast);
            
            // Slide in
            setTimeout(() => {
                toast.classList.remove('translate-x-full');
            }, 100);
            
            // Slide out and remove
            setTimeout(() => {
                toast.classList.add('translate-x-full');
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 3000);
        }
        
        // Global functions for quick actions
        window.scheduleInterview = scheduleInterview;
                    link.setAttribute('data-listener-added', 'true');
                }
            });
        };
        
        // Add click event listeners to quick post buttons
        const quickPostBtns = document.querySelectorAll('.quick-post-btn');
        console.log('🚀 Found', quickPostBtns.length, 'quick post buttons');
        
        quickPostBtns.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = button.getAttribute('data-target');
                console.log('🖱️ Quick post button clicked:', targetId);
                
                if (targetId) {
                    showContent(targetId);
                    updateSidebar('job-posts'); // Set job-posts as active for create-job
                }
            });
        });
        
        // Enhanced Mobile menu functionality
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const sidebar = document.getElementById('sidebar');
        const mobileOverlay = document.getElementById('mobileOverlay');
        
        function toggleMobileMenu() {
            console.log('📱 Mobile menu toggle called');
            
            if (sidebar && mobileOverlay) {
                // Toggle sidebar visibility
                const isHidden = sidebar.classList.contains('-translate-x-full');
                
                if (isHidden) {
                    // Show sidebar
                    sidebar.classList.remove('-translate-x-full');
                    sidebar.classList.add('translate-x-0');
                    mobileOverlay.classList.remove('hidden');
                    mobileOverlay.classList.add('block');
                    console.log('📱 Mobile menu opened');
                } else {
                    // Hide sidebar
                    sidebar.classList.add('-translate-x-full');
                    sidebar.classList.remove('translate-x-0');
                    mobileOverlay.classList.add('hidden');
                    mobileOverlay.classList.remove('block');
                    console.log('📱 Mobile menu closed');
                }
            } else {
                console.error('❌ Mobile menu elements not found');
            }
        }
        
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('📱 Mobile menu button clicked');
                toggleMobileMenu();
            });
            console.log('📱 Mobile menu button set up');
        } else {
            console.error('❌ Mobile menu button not found');
        }
        
        if (mobileOverlay) {
            mobileOverlay.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('📱 Mobile overlay clicked');
                toggleMobileMenu();
            });
            console.log('📱 Mobile overlay set up');
        } else {
            console.error('❌ Mobile overlay not found');
        }
        
        // Application Management Functions
        window.viewApplication = function(applicationId) {
            console.log('👁️ Viewing application:', applicationId);
            // You can implement a modal or redirect to detailed view
            alert('Viewing application #' + applicationId + '\n\nThis will open the detailed application view.');
        };
        
        window.viewApplicationDetails = function(applicationId) {
            console.log('👁️ Viewing application details:', applicationId);
            // Fetch and display detailed application information
            fetch(`/employer/applications/${applicationId}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Display application details in a modal or alert
                    const app = data.application;
                    alert(`Application Details:\n\nName: ${app.user.name}\nEmail: ${app.user.email}\nJob: ${app.job.title}\nApplied: ${new Date(app.created_at).toLocaleDateString()}\nStatus: ${app.status}\n\nCover Letter:\n${app.cover_letter || 'No cover letter provided'}`);
                } else {
                    alert('Error loading application details: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error loading application details. Please try again.');
            });
        };
        
        window.contactApplicant = function(userId) {
            console.log('📧 Contacting applicant:', userId);
            // Redirect to messages with the specific user
            window.location.href = `/messages?user=${userId}`;
        };
        
        window.refreshApplications = function() {
            console.log('🔄 Refreshing applications list');
            location.reload();
        };
        
        window.approveApplication = function(applicationId) {
            console.log('✅ Approving application:', applicationId);
            
            // Show confirmation modal
            showConfirmModal(
                'Approve Application',
                'Are you sure you want to approve this application? The worker will be notified.',
                'approve',
                function() {
                    // Proceed with approval
                    fetch(`/employer/applications/${applicationId}/approve`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        closeConfirmModal();
                        if (data.success) {
                            showSuccessModal(`Application approved! ${data.worker_name} has been notified about their hiring for ${data.job_title}.`);
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        } else {
                            showErrorModal(data.message || 'Failed to approve application');
                        }
                    })
                    .catch(error => {
                        closeConfirmModal();
                        console.error('Error:', error);
                        showErrorModal('An error occurred while approving the application');
                    });
                }
            );
        };
        
        window.rejectApplication = function(applicationId) {
            console.log('❌ Rejecting application:', applicationId);
            
            // Show confirmation modal
            showConfirmModal(
                'Reject Application',
                'Are you sure you want to reject this application? This action cannot be undone.',
                'reject',
                function() {
                    // Proceed with rejection
                    fetch(`/employer/applications/${applicationId}/reject`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        closeConfirmModal();
                        if (data.success) {
                            showSuccessModal('Application rejected successfully.');
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        } else {
                            showErrorModal(data.message || 'Failed to reject application');
                        }
                    })
                    .catch(error => {
                        closeConfirmModal();
                        console.error('Error:', error);
                        showErrorModal('An error occurred while rejecting the application');
                    });
                }
            );
        };
        
        // Modal helper functions
        function showConfirmModal(title, message, type, onConfirm) {
            const modal = document.getElementById('confirmationModal');
            const confirmIcon = document.getElementById('confirmIcon');
            const confirmTitle = document.getElementById('confirmTitle');
            const confirmMessage = document.getElementById('confirmMessage');
            const confirmButton = document.getElementById('confirmButton');
            
            confirmTitle.textContent = title;
            confirmMessage.textContent = message;
            
            if (type === 'approve') {
                confirmIcon.className = 'flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full bg-green-100';
                confirmIcon.innerHTML = '<i class="fas fa-check text-green-600 text-2xl"></i>';
                confirmButton.className = 'flex-1 px-4 py-3 rounded-xl font-semibold text-white transition bg-green-600 hover:bg-green-700';
                confirmButton.textContent = 'Approve';
            } else {
                confirmIcon.className = 'flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full bg-red-100';
                confirmIcon.innerHTML = '<i class="fas fa-times text-red-600 text-2xl"></i>';
                confirmButton.className = 'flex-1 px-4 py-3 rounded-xl font-semibold text-white transition bg-red-600 hover:bg-red-700';
                confirmButton.textContent = 'Reject';
            }
            
            confirmButton.onclick = onConfirm;
            modal.classList.remove('hidden');
        }
        
        function closeConfirmModal() {
            document.getElementById('confirmationModal').classList.add('hidden');
        }
        
        function showSuccessModal(message) {
            document.getElementById('successMessage').textContent = message;
            document.getElementById('successModal').classList.remove('hidden');
        }
        
        function closeSuccessModal() {
            document.getElementById('successModal').classList.add('hidden');
        }
        
        function showErrorModal(message) {
            document.getElementById('errorMessage').textContent = message;
            document.getElementById('errorModal').classList.remove('hidden');
        }
        
        function closeErrorModal() {
            document.getElementById('errorModal').classList.add('hidden');
        }
        
        // Search and Filter Functionality
        const applicationSearch = document.getElementById('applicationSearch');
        const statusFilter = document.getElementById('statusFilter');
        const jobFilter = document.getElementById('jobFilter');
        
        if (applicationSearch) {
            applicationSearch.addEventListener('input', function() {
                console.log('🔍 Searching applications:', this.value);
                // Implement search functionality
                filterApplications();
            });
        }
        
        if (statusFilter) {
            statusFilter.addEventListener('change', function() {
                console.log('📊 Filtering by status:', this.value);
                filterApplications();
            });
        }
        
        if (jobFilter) {
            jobFilter.addEventListener('change', function() {
                console.log('💼 Filtering by job:', this.value);
                filterApplications();
            });
        }
        
        function filterApplications() {
            const searchTerm = applicationSearch?.value.toLowerCase() || '';
            const statusValue = statusFilter?.value || '';
            const jobValue = jobFilter?.value || '';
            
            // Get all application cards
            const applicationCards = document.querySelectorAll('#applications-content .bg-white.rounded-xl.shadow-lg');
            
            applicationCards.forEach(card => {
                const applicantName = card.querySelector('h3')?.textContent.toLowerCase() || '';
                const applicantEmail = card.querySelector('p')?.textContent.toLowerCase() || '';
                const statusBadge = card.querySelector('.inline-flex')?.textContent.toLowerCase() || '';
                
                const matchesSearch = applicantName.includes(searchTerm) || applicantEmail.includes(searchTerm);
                const matchesStatus = !statusValue || statusBadge.includes(statusValue);
                // Job filtering would need additional data attributes on cards
                
                if (matchesSearch && matchesStatus) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }
        
        console.log('✅ Employer Dashboard setup complete!');
        
        // Job Management Functions
        window.refreshJobs = function() {
            console.log('🔄 Refreshing jobs list');
            location.reload();
        };
        
        window.viewJobLive = function(jobId) {
            console.log('👁️ Viewing job live:', jobId);
            // Open job in new tab to view it live on the jobs page
            window.open(`/jobs/${jobId}`, '_blank');
        };
        
        window.editJob = function(jobId) {
            console.log('✏️ Editing job:', jobId);
            
            // Show loading state
            const editBtn = document.querySelector(`button[onclick="editJob(${jobId})"]`);
            const originalContent = editBtn.innerHTML;
            editBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            editBtn.disabled = true;
            
            // Fetch job details for editing
            fetch(`/employer/jobs/${jobId}/edit`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showEditJobModal(data.job);
                } else {
                    alert('Failed to load job details: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error loading job details:', error);
                alert('Failed to load job details. Please try again.');
            })
            .finally(() => {
                editBtn.innerHTML = originalContent;
                editBtn.disabled = false;
            });
        };
        
        window.showEditJobModal = function(job) {
            // Store current job being edited
            window.currentEditingJob = job;
            window.editJobSelectedSkills = [];
            
            // Load existing job skills
            fetch(`/api/jobs/${job.id}/skills`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.skills) {
                        window.editJobSelectedSkills = data.skills.map(skill => ({
                            skill_id: skill.skill_id,
                            skill: { name: skill.skill_name },
                            required_level: skill.required_level || 'Beginner',
                            is_required: skill.is_required !== undefined ? skill.is_required : true
                        }));
                    }
                })
                .catch(error => console.error('Error loading job skills:', error));
            
            // Create edit modal
            const modal = document.createElement('div');
            modal.id = 'editJobModal';
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4';
            modal.innerHTML = `
                <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-semibold text-gray-900">Edit Job Post</h3>
                            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <form id="editJobForm" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Job Title *</label>
                                    <input type="text" id="edit_job_title" value="${job.title}" required 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Location *</label>
                                    <input type="text" id="edit_job_location" value="${job.location}" required 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Job Description *</label>
                                <textarea id="edit_job_description" rows="6" required 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                          minlength="20">${job.description}</textarea>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Budget (UGX) *</label>
                                    <input type="number" id="edit_job_budget" value="${job.budget}" required min="0"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Job Type *</label>
                                    <select id="edit_job_type" required 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="one-time" ${job.job_type === 'one-time' ? 'selected' : ''}>One-time</option>
                                        <option value="recurring" ${job.job_type === 'recurring' ? 'selected' : ''}>Recurring</option>
                                        <option value="project" ${job.job_type === 'project' ? 'selected' : ''}>Project</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Skills Selection -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">Skills Required</label>
                                <div class="border border-gray-300 rounded-lg p-4">
                                    <div class="flex justify-between items-center mb-4">
                                        <span class="text-sm text-gray-600">Select skills needed for this job</span>
                                        <button type="button" onclick="openEditJobSkillsModal()" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                            <i class="fas fa-plus mr-1"></i>Manage Skills
                                        </button>
                                    </div>
                                    <div id="editSelectedJobSkills" class="space-y-2">
                                        <!-- Selected skills will appear here -->
                                    </div>
                                    <div id="editNoSkillsSelected" class="text-center py-4 text-gray-500">
                                        <i class="fas fa-tools text-2xl mb-2"></i>
                                        <p class="text-sm">No skills selected yet</p>
                                        <p class="text-xs">Click "Manage Skills" to add required skills</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                                <button type="button" onclick="closeEditModal()" 
                                        class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                                    Cancel
                                </button>
                                <button type="submit" 
                                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                    <i class="fas fa-save mr-2"></i>Update Job
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            `;
            
            document.body.appendChild(modal);
            
            // Update skills display after a short delay to ensure skills are loaded
            setTimeout(() => {
                updateEditJobSkillsDisplay();
            }, 500);
            
            // Handle form submission
            document.getElementById('editJobForm').addEventListener('submit', function(e) {
                e.preventDefault();
                updateJob(job.id);
            });
        };
        
        window.closeEditModal = function() {
            const modal = document.querySelector('.fixed.inset-0');
            if (modal) {
                modal.remove();
            }
        };
        
        window.updateJob = function(jobId) {
            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            formData.append('_method', 'PUT');
            formData.append('title', document.getElementById('edit_job_title').value);
            formData.append('location', document.getElementById('edit_job_location').value);
            formData.append('description', document.getElementById('edit_job_description').value);
            formData.append('budget', document.getElementById('edit_job_budget').value);
            formData.append('job_type', document.getElementById('edit_job_type').value);
            formData.append('required_skills', document.getElementById('edit_job_skills').value);
            
            const submitBtn = document.querySelector('#editJobForm button[type="submit"]');
            const originalContent = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Updating...';
            submitBtn.disabled = true;
            
            fetch(`/employer/jobs/${jobId}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Job updated successfully!');
                    closeEditModal();
                    refreshJobs();
                } else {
                    alert('Failed to update job: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error updating job:', error);
                alert('Failed to update job. Please try again.');
            })
            .finally(() => {
                submitBtn.innerHTML = originalContent;
                submitBtn.disabled = false;
            });
        };
        
        window.showJobDetails = function(jobId) {
            console.log('📊 Showing job details:', jobId);
            
            fetch(`/employer/jobs/${jobId}/details`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showJobDetailsModal(data.job, data.analytics);
                } else {
                    alert('Failed to load job details: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error loading job details:', error);
                alert('Failed to load job details. Please try again.');
            });
        };
        
        window.showJobDetailsModal = function(job, analytics) {
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4';
            modal.innerHTML = `
                <div class="bg-white rounded-lg shadow-xl max-w-6xl w-full max-h-[90vh] overflow-y-auto">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-semibold text-gray-900">Job Details & Analytics</h3>
                            <button onclick="closeJobDetailsModal()" class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Job Information -->
                            <div class="lg:col-span-2">
                                <div class="bg-gray-50 p-6 rounded-lg mb-6">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-4">${job.title}</h4>
                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div><strong>Location:</strong> ${job.location}</div>
                                        <div><strong>Budget:</strong> UGX ${parseInt(job.budget).toLocaleString()}</div>
                                        <div><strong>Type:</strong> ${job.job_type}</div>
                                        <div><strong>Status:</strong> <span class="capitalize">${job.status}</span></div>
                                        <div><strong>Created:</strong> ${new Date(job.created_at).toLocaleDateString()}</div>
                                        <div><strong>Category:</strong> ${job.category ? job.category.name : 'N/A'}</div>
                                    </div>
                                    <div class="mt-4">
                                        <strong>Description:</strong>
                                        <p class="mt-2 text-gray-700">${job.description}</p>
                                    </div>
                                    ${job.required_skills ? `
                                        <div class="mt-4">
                                            <strong>Required Skills:</strong>
                                            <div class="flex flex-wrap gap-2 mt-2">
                                                ${job.required_skills.split(',').map(skill => 
                                                    `<span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">${skill.trim()}</span>`
                                                ).join('')}
                                            </div>
                                        </div>
                                    ` : ''}
                                </div>
                                
                                <!-- Recent Applications -->
                                <div class="bg-white border rounded-lg p-6">
                                    <h5 class="text-lg font-semibold text-gray-900 mb-4">Recent Applications</h5>
                                    <div id="recentApplications" class="space-y-3">
                                        ${analytics.recent_applications && analytics.recent_applications.length > 0 ? 
                                            analytics.recent_applications.map(app => `
                                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                                                    <div>
                                                        <div class="font-medium">${app.user ? app.user.name : 'Unknown'}</div>
                                                        <div class="text-sm text-gray-500">${new Date(app.created_at).toLocaleDateString()}</div>
                                                    </div>
                                                    <span class="px-2 py-1 text-xs rounded ${
                                                        app.status === 'approved' ? 'bg-green-100 text-green-800' :
                                                        app.status === 'rejected' ? 'bg-red-100 text-red-800' :
                                                        'bg-yellow-100 text-yellow-800'
                                                    }">${app.status}</span>
                                                </div>
                                            `).join('') : 
                                            '<p class="text-gray-500 text-center py-4">No applications yet</p>'
                                        }
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Analytics Sidebar -->
                            <div class="space-y-6">
                                <!-- Key Metrics -->
                                <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 rounded-lg text-white">
                                    <h5 class="text-lg font-semibold mb-4">Key Metrics</h5>
                                    <div class="space-y-3">
                                        <div class="flex justify-between">
                                            <span><i class="fas fa-eye mr-2"></i>Views:</span>
                                            <span class="font-bold">${job.views || 0}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span><i class="fas fa-users mr-2"></i>Applications:</span>
                                            <span class="font-bold">${analytics.total_applications || 0}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span><i class="fas fa-bookmark mr-2"></i>Bookmarks:</span>
                                            <span class="font-bold">${analytics.bookmarks_count || 0}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span><i class="fas fa-heart mr-2"></i>Likes:</span>
                                            <span class="font-bold">${analytics.likes_count || 0}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span><i class="fas fa-percentage mr-2"></i>Conv. Rate:</span>
                                            <span class="font-bold">${analytics.conversion_rate || 0}%</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span><i class="fas fa-check-circle mr-2"></i>Hired:</span>
                                            <span class="font-bold">${analytics.approved_applications || 0}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Application Status -->
                                <div class="bg-white border rounded-lg p-6">
                                    <h5 class="text-lg font-semibold text-gray-900 mb-4">Application Status</h5>
                                    <div class="space-y-3">
                                        <div class="flex justify-between items-center">
                                            <span class="text-yellow-600"><i class="fas fa-clock mr-2"></i>Pending</span>
                                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm">${analytics.pending_applications || 0}</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-green-600"><i class="fas fa-check mr-2"></i>Approved</span>
                                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">${analytics.approved_applications || 0}</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-red-600"><i class="fas fa-times mr-2"></i>Rejected</span>
                                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm">${analytics.rejected_applications || 0}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Engagement Stats -->
                                <div class="bg-white border rounded-lg p-6">
                                    <h5 class="text-lg font-semibold text-gray-900 mb-4">Engagement</h5>
                                    <div class="space-y-3">
                                        <div class="flex justify-between items-center">
                                            <span class="text-blue-600"><i class="fas fa-eye mr-2"></i>View Rate</span>
                                            <span class="text-sm font-medium">${analytics.view_rate || 'N/A'}</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-purple-600"><i class="fas fa-bookmark mr-2"></i>Save Rate</span>
                                            <span class="text-sm font-medium">${analytics.bookmark_rate || 'N/A'}</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-red-600"><i class="fas fa-heart mr-2"></i>Like Rate</span>
                                            <span class="text-sm font-medium">${analytics.like_rate || 'N/A'}</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-green-600"><i class="fas fa-handshake mr-2"></i>Hire Rate</span>
                                            <span class="text-sm font-medium">${analytics.hire_rate || 'N/A'}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Quick Actions -->
                                <div class="bg-white border rounded-lg p-6">
                                    <h5 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h5>
                                    <div class="space-y-2">
                                        <button onclick="viewJobLive(${job.id})" class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition">
                                            <i class="fas fa-external-link-alt mr-2"></i>View Live
                                        </button>
                                        <button onclick="editJob(${job.id}); closeJobDetailsModal();" class="w-full bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 transition">
                                            <i class="fas fa-edit mr-2"></i>Edit Job
                                        </button>
                                        <button onclick="duplicateJob(${job.id}); closeJobDetailsModal();" class="w-full bg-purple-500 text-white py-2 px-4 rounded hover:bg-purple-600 transition">
                                            <i class="fas fa-copy mr-2"></i>Duplicate Job
                                        </button>
                                        ${job.status === 'active' ? 
                                            `<button onclick="pauseJob(${job.id}); closeJobDetailsModal();" class="w-full bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-600 transition">
                                                <i class="fas fa-pause mr-2"></i>Pause Job
                                            </button>` :
                                            job.status === 'draft' ?
                                            `<button onclick="publishJob(${job.id}); closeJobDetailsModal();" class="w-full bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 transition">
                                                <i class="fas fa-play mr-2"></i>Publish Job
                                            </button>` : ''
                                        }
                                        <button onclick="if(confirm('Delete this job?')) { deleteJob(${job.id}); closeJobDetailsModal(); }" class="w-full bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600 transition">
                                            <i class="fas fa-trash mr-2"></i>Delete Job
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            document.body.appendChild(modal);
        };
        
        window.closeJobDetailsModal = function() {
            const modal = document.querySelector('.fixed.inset-0');
            if (modal) {
                modal.remove();
            }
        };
        
        window.duplicateJob = function(jobId) {
            console.log('📋 Duplicating job:', jobId);
            
            if (confirm('Are you sure you want to duplicate this job? A copy will be created as a draft.')) {
                const duplicateBtn = document.querySelector(`button[onclick="duplicateJob(${jobId})"]`);
                const originalContent = duplicateBtn.innerHTML;
                duplicateBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                duplicateBtn.disabled = true;
                
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
                        alert('Job duplicated successfully! The copy has been saved as a draft.');
                        refreshJobs();
                    } else {
                        alert('Failed to duplicate job: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error duplicating job:', error);
                    alert('Failed to duplicate job. Please try again.');
                })
                .finally(() => {
                    duplicateBtn.innerHTML = originalContent;
                    duplicateBtn.disabled = false;
                });
            }
        };
        
        window.refreshJobs = function() {
            console.log('🔄 Refreshing jobs list...');
            location.reload();
        };
        
        window.testJobPosts = function() {
            console.log('🧪 Testing job posts functionality...');
            const debugStatus = document.getElementById('debug-status');
            let status = '';
            
            console.log('📊 Current content sections:', document.querySelectorAll('.content-section').length);
            console.log('🔗 Current sidebar links:', document.querySelectorAll('.sidebar-link').length);
            
            // Check if job posts content exists
            const jobPostsContent = document.getElementById('job-posts-content');
            if (jobPostsContent) {
                console.log('✅ Found job-posts-content element');
                status += '✅ job-posts-content found | ';
                
                // Check if it's hidden
                const isHidden = jobPostsContent.classList.contains('hidden');
                status += `Hidden: ${isHidden} | `;
                console.log('🔍 Is hidden:', isHidden);
                
                // Try to show it
                showContent('job-posts');
                updateSidebar('job-posts');
                status += 'showContent called | ';
                
                // Check again after showing
                const stillHidden = jobPostsContent.classList.contains('hidden');
                status += `Still hidden: ${stillHidden}`;
                console.log('🔍 Still hidden after showContent:', stillHidden);
                
            } else {
                console.error('❌ job-posts-content element not found');
                status = '❌ job-posts-content element not found';
            }
            
            if (debugStatus) {
                debugStatus.textContent = status;
            }
        };
        
        // Function to highlight and find job posts content
        window.highlightJobPosts = function() {
            console.log('🔍 Highlighting job posts content...');
            const debugStatus = document.getElementById('debug-status');
            
            const jobPostsContent = document.getElementById('job-posts-content');
            if (jobPostsContent) {
                console.log('✅ Found job-posts-content element');
                
                // Make it SUPER visible with extreme styling
                jobPostsContent.style.border = '10px solid red';
                jobPostsContent.style.backgroundColor = 'rgba(255, 0, 0, 0.3)';
                jobPostsContent.style.minHeight = '500px';
                jobPostsContent.style.display = 'block';
                jobPostsContent.style.visibility = 'visible';
                jobPostsContent.style.opacity = '1';
                jobPostsContent.style.position = 'relative';
                jobPostsContent.style.zIndex = '9999';
                jobPostsContent.style.padding = '20px';
                jobPostsContent.classList.remove('hidden');
                
                // Add a big text indicator
                const indicator = document.createElement('div');
                indicator.innerHTML = '🎯 THIS IS THE JOB POSTS CONTENT!';
                indicator.style.cssText = `
                    background: red;
                    color: white;
                    padding: 20px;
                    font-size: 24px;
                    font-weight: bold;
                    text-align: center;
                    margin-bottom: 20px;
                `;
                jobPostsContent.insertBefore(indicator, jobPostsContent.firstChild);
                
                // Remove after 10 seconds
                setTimeout(() => {
                    jobPostsContent.style.border = '';
                    jobPostsContent.style.backgroundColor = '';
                    jobPostsContent.style.zIndex = '';
                    if (indicator.parentNode) {
                        indicator.remove();
                    }
                }, 10000);
                
                if (debugStatus) {
                    debugStatus.innerHTML = '🔍 job-posts-content highlighted with red border and indicator!';
                }
            } else {
                console.error('❌ job-posts-content element not found');
                if (debugStatus) {
                    debugStatus.innerHTML = '❌ job-posts-content element not found in DOM';
                }
            }
        };
                if (debugStatus) {
                    debugStatus.textContent = '❌ job-posts-content element not found in DOM';
                }
            }
            
            // Also check all content sections
            const contentSections = document.querySelectorAll('.content-section');
            console.log('📄 All content sections:');
            contentSections.forEach((section, index) => {
                console.log(`  ${index + 1}. ID: "${section.id}", Hidden: ${section.classList.contains('hidden')}`);
            });
        };

        window.testAllSections = function() {
            console.log('🧪 Testing all content sections...');
            const debugStatus = document.getElementById('debug-status');
            let results = [];
            
            const sectionsToTest = ['dashboard', 'job-posts', 'applications', 'create-job'];
            
            sectionsToTest.forEach(sectionId => {
                console.log(`\n🔍 Testing section: ${sectionId}`);
                
                // Check if content section exists
                const contentElement = document.getElementById(sectionId + '-content');
                const linkElement = document.querySelector(`[data-content="${sectionId}"]`);
                
                const result = {
                    section: sectionId,
                    contentExists: !!contentElement,
                    linkExists: !!linkElement,
                    canShow: false
                };
                
                if (contentElement) {
                    // Test showing the section
                    const success = showContent(sectionId);
                    result.canShow = success;
                    
                    // Wait a moment then test if it's visible
                    setTimeout(() => {
                        const isVisible = !contentElement.classList.contains('hidden');
                        console.log(`  📊 ${sectionId}: Content=${result.contentExists}, Link=${result.linkExists}, Show=${result.canShow}, Visible=${isVisible}`);
                    }, 100);
                } else {
                    console.log(`  ❌ ${sectionId}: Content section not found`);
                }
                
                results.push(result);
            });
            
            // Show results summary
            setTimeout(() => {
                const summary = results.map(r => 
                    `${r.section}: ${r.contentExists && r.linkExists && r.canShow ? '✅' : '❌'}`
                ).join(' | ');
                
                if (debugStatus) {
                    debugStatus.textContent = `Test Results: ${summary}`;
                }
                
                console.log('🏁 Test Summary:', summary);
                
                // Return to dashboard
                window.location.hash = '#dashboard';
            }, 1000);
        };
        
        // Enhanced showJobPosts function with immediate visual feedback
        window.showJobPosts = function() {
            console.log('🎯 showJobPosts called directly!');
            
            // Add immediate visual feedback
            document.body.style.border = '5px solid red';
            setTimeout(() => document.body.style.border = '', 2000);
            
            const debugStatus = document.getElementById('debug-status');
            if (debugStatus) {
                debugStatus.textContent = '🎯 showJobPosts function called...';
                debugStatus.style.backgroundColor = '#fef3c7';
            }
            
            // Check if elements exist
            const jobPostsContent = document.getElementById('job-posts-content');
            const jobPostsLink = document.querySelector('[data-content="job-posts"]');
            
            console.log('🔍 Elements check:');
            console.log('  - jobPostsContent:', !!jobPostsContent);
            console.log('  - jobPostsLink:', !!jobPostsLink);
            
            if (jobPostsContent) {
                console.log('  - jobPostsContent classes before:', jobPostsContent.className);
                console.log('  - jobPostsContent display before:', window.getComputedStyle(jobPostsContent).display);
                console.log('  - jobPostsContent visibility before:', window.getComputedStyle(jobPostsContent).visibility);
            }
            
            if (jobPostsContent && jobPostsLink) {
                console.log('✅ Both elements found, proceeding...');
                
                // Hide all content first
                document.querySelectorAll('.content-section').forEach(section => {
                    section.classList.add('hidden');
                    console.log('  - Hidden section:', section.id);
                });
                
                // Show job posts content with multiple methods
                jobPostsContent.classList.remove('hidden');
                jobPostsContent.style.display = 'block';
                jobPostsContent.style.visibility = 'visible';
                jobPostsContent.style.opacity = '1';
                
                console.log('  - jobPostsContent classes after:', jobPostsContent.className);
                console.log('  - jobPostsContent display after:', window.getComputedStyle(jobPostsContent).display);
                console.log('  - jobPostsContent visibility after:', window.getComputedStyle(jobPostsContent).visibility);
                
                // Update sidebar
                document.querySelectorAll('.sidebar-link').forEach(link => {
                    link.classList.remove('sidebar-active');
                });
                jobPostsLink.classList.add('sidebar-active');
                
                if (debugStatus) {
                    debugStatus.textContent = '✅ showJobPosts executed - job posts should be visible!';
                    debugStatus.style.backgroundColor = '#d1fae5';
                }
                console.log('✅ showJobPosts completed successfully');
                
                // Additional check after a moment
                setTimeout(() => {
                    const isVisible = !jobPostsContent.classList.contains('hidden');
                    const computedDisplay = window.getComputedStyle(jobPostsContent).display;
                    console.log('🔍 Final check - Hidden class:', jobPostsContent.classList.contains('hidden'));
                    console.log('🔍 Final check - Computed display:', computedDisplay);
                    
                    if (debugStatus) {
                        debugStatus.textContent += ` | Final: Hidden=${!isVisible}, Display=${computedDisplay}`;
                    }
                }, 500);
                
            } else {
                const error = `❌ Missing elements - Content: ${!!jobPostsContent}, Link: ${!!jobPostsLink}`;
                console.error(error);
                if (debugStatus) {
                    debugStatus.textContent = error;
                    debugStatus.style.backgroundColor = '#fecaca';
                }
            }
        };
        
        window.publishJob = function(jobId) {
            console.log('📢 Publishing job:', jobId);
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
                        location.reload();
                    } else {
                        alert('Error publishing job: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error publishing job. Please try again.');
                });
            }
        };
        
        window.pauseJob = function(jobId) {
            console.log('⏸️ Pausing job:', jobId);
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
        };
        
        window.deleteJob = function(jobId) {
            console.log('🗑️ Deleting job:', jobId);
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
        };
        
        window.saveJobDraft = function() {
            console.log('💾 Saving job as draft');
            
            // For drafts, we can be more lenient with validation
            const description = document.getElementById('job_description').value;
            if (description.length > 0 && description.length < 20) {
                if (!confirm('Your job description is less than 20 characters. You can save it as a draft, but you\'ll need to expand it before publishing. Continue?')) {
                    return;
                }
            }
            
            submitJobForm('draft');
        };
        
        // Job Form Submission
        const createJobForm = document.getElementById('createJobForm');
        if (createJobForm) {
            console.log('🎯 Form found, setting up event listeners');
            
            createJobForm.addEventListener('submit', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('📝 Form submit event triggered');
                
                // Validate description length
                const description = document.getElementById('job_description').value;
                if (description.length < 20) {
                    alert('Job description must be at least 20 characters long.');
                    return false;
                }
                
                console.log('📝 Submitting job form for publication');
                submitJobForm('active');
                return false;
            });
            
            // Also prevent any other form submission
            createJobForm.onsubmit = function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('📝 onsubmit triggered - preventing default');
                return false;
            };
            
            // Add character counter for description
            const descriptionField = document.getElementById('job_description');
            const descriptionCounter = document.getElementById('description-counter');
            
            if (descriptionField && descriptionCounter) {
                descriptionField.addEventListener('input', function() {
                    const length = this.value.length;
                    descriptionCounter.textContent = length;
                    
                    // Change color based on length
                    if (length < 20) {
                        descriptionCounter.className = 'text-red-500 font-medium';
                    } else {
                        descriptionCounter.className = 'text-green-500 font-medium';
                    }
                });
            }
        } else {
            console.error('❌ createJobForm not found!');
        }
        
        function submitJobForm(status) {
            console.log('🚀 submitJobForm called with status:', status);
            
            // Create a new FormData object and manually add fields to avoid conflicts
            const formData = new FormData();
            
            console.log('📝 Creating form data...');
            
            // Add all form fields manually
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            formData.append('job_title', document.getElementById('job_title').value);
            formData.append('job_description', document.getElementById('job_description').value);
            formData.append('job_category_id', document.getElementById('job_category').value);
            formData.append('job_location', document.getElementById('job_location').value);
            formData.append('job_salary_min', document.getElementById('salary_min').value);
            formData.append('job_salary_max', document.getElementById('salary_max').value);
            formData.append('job_type_field', document.getElementById('job_type').value);
            formData.append('job_experience_level', document.getElementById('experience_level').value);
            formData.append('job_requirements', document.getElementById('requirements').value);
            formData.append('job_status', status);
            
            console.log('📝 Form data created, making fetch request to /employer/dashboard/create-job');
            
            // Show loading state
            const submitBtn = createJobForm.querySelector('button[type="submit"]');
            const draftBtn = createJobForm.querySelector('button[onclick="saveJobDraft()"]');
            const originalSubmitText = submitBtn.innerHTML;
            const originalDraftText = draftBtn.innerHTML;
            
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Publishing...';
            draftBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
            submitBtn.disabled = true;
            draftBtn.disabled = true;
            
            fetch('/employer/dashboard/create-job', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                console.log('📡 Response received:', response.status, response.statusText);
                return response.json();
            })
            .then(data => {
                console.log('📊 Response data:', data);
                if (data.success) {
                    alert(data.message || (status === 'active' ? 'Job published successfully!' : 'Job saved as draft!'));
                    createJobForm.reset();
                    // Reset character counter
                    const descriptionCounter = document.getElementById('description-counter');
                    if (descriptionCounter) {
                        descriptionCounter.textContent = '0';
                        descriptionCounter.className = 'text-red-500 font-medium';
                    }
                    showContent('job-posts');
                    updateSidebar('job-posts');
                    location.reload(); // Refresh to show new job
                } else {
                    console.error('❌ Server returned error:', data);
                    // Handle validation errors
                    if (data.errors) {
                        let errorMessage = 'Please fix the following errors:\n\n';
                        for (const field in data.errors) {
                            errorMessage += `• ${data.errors[field].join('\n• ')}\n`;
                        }
                        alert(errorMessage);
                    } else {
                        alert('Error: ' + data.message);
                    }
                }
            })
            .catch(error => {
                console.error('❌ Fetch error:', error);
                alert('Error submitting job. Please try again.');
            })
            .finally(() => {
                // Restore button states
                submitBtn.innerHTML = originalSubmitText;
                draftBtn.innerHTML = originalDraftText;
                submitBtn.disabled = false;
                draftBtn.disabled = false;
            });
        }
        
        // Job Status Filter
        const jobStatusFilter = document.getElementById('jobStatusFilter');
        if (jobStatusFilter) {
            jobStatusFilter.addEventListener('change', function() {
                console.log('🔍 Filtering jobs by status:', this.value);
                filterJobs();
            });
        }
        
        // Job Search
        const jobSearchInput = document.getElementById('jobSearchInput');
        if (jobSearchInput) {
            jobSearchInput.addEventListener('input', function() {
                console.log('🔍 Searching jobs:', this.value);
                filterJobs();
            });
        }
        
        function filterJobs() {
            const statusFilter = document.getElementById('jobStatusFilter').value;
            const searchTerm = document.getElementById('jobSearchInput').value.toLowerCase();
            const jobCards = document.querySelectorAll('#jobsList > div');
            
            jobCards.forEach(card => {
                let showCard = true;
                
                // Status filter
                if (statusFilter) {
                    const statusBadge = card.querySelector('.inline-flex');
                    const cardStatus = statusBadge ? statusBadge.textContent.toLowerCase().trim() : '';
                    if (!cardStatus.includes(statusFilter.replace('_', ' '))) {
                        showCard = false;
                    }
                }
                
                // Search filter
                if (searchTerm && showCard) {
                    const title = card.querySelector('h3').textContent.toLowerCase();
                    const description = card.querySelector('p').textContent.toLowerCase();
                    const location = card.querySelector('.fas.fa-map-marker-alt').parentElement.textContent.toLowerCase();
                    
                    if (!title.includes(searchTerm) && 
                        !description.includes(searchTerm) && 
                        !location.includes(searchTerm)) {
                        showCard = false;
                    }
                }
                
                card.style.display = showCard ? 'block' : 'none';
            });
        }
        
        function filterJobsByStatus(status) {
            // Legacy function - now uses filterJobs()
            filterJobs();
        }
                    }
                }
            });
        }
        
        // Application Filtering Functions
        const applicationSearch = document.getElementById('applicationSearch');
        const applicationStatusFilter = document.getElementById('applicationStatusFilter');
        const applicationJobFilter = document.getElementById('applicationJobFilter');
        
        if (applicationSearch) {
            applicationSearch.addEventListener('input', function() {
                console.log('🔍 Searching applications:', this.value);
                filterApplications();
            });
        }
        
        if (applicationStatusFilter) {
            applicationStatusFilter.addEventListener('change', function() {
                console.log('📊 Filtering applications by status:', this.value);
                filterApplications();
            });
        }
        
        if (applicationJobFilter) {
            applicationJobFilter.addEventListener('change', function() {
                console.log('💼 Filtering applications by job:', this.value);
                filterApplications();
            });
        }
        
        function filterApplications() {
            const searchTerm = applicationSearch?.value.toLowerCase() || '';
            const statusValue = applicationStatusFilter?.value || '';
            const jobValue = applicationJobFilter?.value || '';
            
            // Get all application cards
            const applicationCards = document.querySelectorAll('#applicationsList > div');
            
            applicationCards.forEach(card => {
                const applicantName = card.querySelector('h3')?.textContent.toLowerCase() || '';
                const applicantEmail = card.querySelector('p')?.textContent.toLowerCase() || '';
                const statusBadge = card.querySelector('.inline-flex')?.textContent.toLowerCase() || '';
                const jobTitle = card.querySelector('.fa-briefcase')?.parentElement?.textContent.toLowerCase() || '';
                
                const matchesSearch = applicantName.includes(searchTerm) || applicantEmail.includes(searchTerm);
                const matchesStatus = !statusValue || statusBadge.includes(statusValue);
                const matchesJob = !jobValue || jobTitle.includes(jobValue);
                
                if (matchesSearch && matchesStatus && matchesJob) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }
        
        // Simple direct functions for navigation
        window.showJobPostsSimple = function() {
            console.log('🎯 showJobPostsSimple called');
            
            // Visual debug display
            const debugBox = document.getElementById('visual-debug');
            const debugMessages = document.getElementById('debug-messages');
            let messages = [];
            
            function addDebugMessage(msg) {
                messages.push(msg);
                if (debugMessages) {
                    debugMessages.innerHTML = messages.join('<br>');
                }
                if (debugBox) {
                    debugBox.classList.remove('hidden');
                }
                console.log(msg);
            }
            
            addDebugMessage('🎯 showJobPostsSimple called');
            
            // First, let's check what content sections exist
            const allSections = document.querySelectorAll('.content-section');
            addDebugMessage(`📄 Found ${allSections.length} content sections`);
            
            allSections.forEach((section, index) => {
                addDebugMessage(`  ${index + 1}. ID: "${section.id}"`);
            });
            
            // Hide all content sections
            allSections.forEach(section => {
                section.style.display = 'none';
                section.classList.add('hidden');
            });
            addDebugMessage(`Hidden ${allSections.length} sections`);
            
            // Show job posts content
            const jobPostsSection = document.getElementById('job-posts-content');
            addDebugMessage(`🔍 job-posts-content found: ${!!jobPostsSection}`);
            
            if (jobPostsSection) {
                jobPostsSection.style.display = 'block';
                jobPostsSection.classList.remove('hidden');
                jobPostsSection.style.visibility = 'visible';
                jobPostsSection.style.opacity = '1';
                addDebugMessage('✅ Job Posts section shown');
                
                // Check if it's actually visible
                const rect = jobPostsSection.getBoundingClientRect();
                addDebugMessage(`📊 Position: ${rect.width}x${rect.height}`);
            } else {
                addDebugMessage('❌ Job Posts section not found');
                // Let's see what IDs we do have
                const allElements = document.querySelectorAll('[id*="job"]');
                addDebugMessage(`🔍 Found ${allElements.length} job-related elements`);
                allElements.forEach(el => addDebugMessage(`  - ${el.id}`));
            }
            
            // Update sidebar
            document.querySelectorAll('.sidebar-link').forEach(link => {
                link.classList.remove('sidebar-active');
            });
            const jobPostsLink = document.querySelector('[data-content="job-posts"]');
            if (jobPostsLink) {
                jobPostsLink.classList.add('sidebar-active');
                addDebugMessage('✅ Sidebar updated');
            }
            
            // Auto-hide debug after 10 seconds
            setTimeout(() => {
                if (debugBox) debugBox.classList.add('hidden');
            }, 10000);
        };
        
        window.showApplicationsSimple = function() {
            console.log('🎯 showApplicationsSimple called');
            
            // First, let's check what content sections exist
            const allSections = document.querySelectorAll('.content-section');
            console.log('📄 Found content sections:', allSections.length);
            
            // Hide all content sections
            allSections.forEach(section => {
                section.style.display = 'none';
                section.classList.add('hidden');
                console.log(`  Hidden: ${section.id}`);
            });
            
            // Show applications content
            const applicationsSection = document.getElementById('applications-content');
            console.log('🔍 Looking for applications-content:', !!applicationsSection);
            
            if (applicationsSection) {
                applicationsSection.style.display = 'block';
                applicationsSection.classList.remove('hidden');
                applicationsSection.style.visibility = 'visible';
                applicationsSection.style.opacity = '1';
                console.log('✅ Applications section shown');
                console.log('📊 Final styles:', {
                    display: applicationsSection.style.display,
                    visibility: applicationsSection.style.visibility,
                    opacity: applicationsSection.style.opacity,
                    hidden: applicationsSection.classList.contains('hidden')
                });
            } else {
                console.error('❌ Applications section not found');
                // Let's see what IDs we do have
                const allElements = document.querySelectorAll('[id*="application"]');
                console.log('🔍 Elements with "application" in ID:');
                allElements.forEach(el => console.log(`  - ${el.id}`));
            }
            
            // Update sidebar
            document.querySelectorAll('.sidebar-link').forEach(link => {
                link.classList.remove('sidebar-active');
            });
            const applicationsLink = document.querySelector('[data-content="applications"]');
            if (applicationsLink) {
                applicationsLink.classList.add('sidebar-active');
                console.log('✅ Sidebar updated');
            }
        };
    });
    </script>

    <!-- Notifications Panel -->
    <div id="notificationsPanel" class="fixed top-0 right-0 h-full w-full sm:w-96 bg-white shadow-2xl transform translate-x-full transition-transform duration-300 z-50 border-l border-gray-200">
        <div class="flex flex-col h-full">
            <!-- Header -->
            <div class="flex items-center justify-between p-4 sm:p-6 border-b border-gray-200 bg-gradient-to-r from-blue-500 to-purple-600">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-semibold text-white">Worker Matches</h3>
                        <p class="text-xs sm:text-sm text-blue-100">Workers matching your jobs</p>
                    </div>
                </div>
                <button onclick="toggleNotificationsPanel()" class="text-white hover:text-blue-100 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <!-- Notifications Content -->
            <div class="flex-1 overflow-y-auto">
                <div id="workerNotificationsContainer" class="p-3 sm:p-4 space-y-3 sm:space-y-4">
                    <!-- Notifications will be loaded here -->
                    <div class="flex justify-center items-center py-8">
                        <i class="fas fa-spinner fa-spin text-2xl text-blue-500"></i>
                        <span class="ml-2 text-gray-600">Loading notifications...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications Panel Overlay -->
    <div id="notificationsOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden" onclick="toggleNotificationsPanel()"></div>

    <!-- Modern Toast Notification -->
    <div id="modernToast" class="fixed top-4 right-4 z-50 transform translate-x-full transition-transform duration-300">
        <div class="bg-white rounded-lg shadow-2xl border border-gray-200 p-4 min-w-80 max-w-md">
            <div class="flex items-start space-x-3">
                <div id="toastIcon" class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-info text-white"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 id="toastTitle" class="text-sm font-semibold text-gray-900">Notification</h4>
                    <p id="toastMessage" class="text-sm text-gray-600 mt-1">Message content</p>
                </div>
                <button onclick="hideModernToast()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mt-3 flex space-x-2">
                <button id="toastActionBtn" onclick="handleToastAction()" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                    View Details
                </button>
                <button onclick="hideModernToast()" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    <!-- Worker Profile Modal -->
    <div id="workerProfileModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-6 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">Worker Profile</h3>
                    <button onclick="closeWorkerProfileModal()" class="text-white hover:text-blue-100 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            
            <!-- Modal Content -->
            <div id="workerProfileContent" class="p-6">
                <!-- Loading state -->
                <div class="flex justify-center items-center py-8">
                    <i class="fas fa-spinner fa-spin text-2xl text-blue-500"></i>
                    <span class="ml-2 text-gray-600">Loading worker profile...</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Confirmation Toast (matching Contact Toast style) -->
    <div id="profileConfirmationModal" class="fixed top-4 right-4 z-50 hidden transform transition-transform duration-300">
        <div class="bg-white rounded-lg shadow-2xl border border-gray-200 p-4 min-w-80 max-w-md">
            <div class="flex items-start space-x-3">
                <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 bg-blue-500">
                    <i class="fas fa-user text-white"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-sm font-semibold text-gray-900">View Worker Profile</h4>
                    <p class="text-sm text-gray-600 mt-1">Would you like to view the detailed profile of this worker?</p>
                </div>
                <button onclick="closeProfileConfirmationModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mt-3 flex space-x-2">
                <button onclick="confirmViewProfile()" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                    <i class="fas fa-eye mr-1"></i>View Details
                </button>
                <button onclick="closeProfileConfirmationModal()" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    <!-- Contact Worker Modal -->
    <div id="contactWorkerModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-green-500 to-teal-600 p-6 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">Contact Worker</h3>
                    <button onclick="closeContactWorkerModal()" class="text-white hover:text-green-100 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            
            <!-- Modal Content -->
            <div id="contactWorkerContent" class="p-6">
                <!-- Loading state -->
                <div class="flex justify-center items-center py-8">
                    <i class="fas fa-spinner fa-spin text-2xl text-green-500"></i>
                    <span class="ml-2 text-gray-600">Loading contact information...</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        let notificationsPanelOpen = false;

        function toggleNotificationsPanel() {
            const panel = document.getElementById('notificationsPanel');
            const overlay = document.getElementById('notificationsOverlay');
            
            if (notificationsPanelOpen) {
                // Close panel
                panel.classList.add('translate-x-full');
                overlay.classList.add('hidden');
                notificationsPanelOpen = false;
            } else {
                // Open panel and load notifications
                panel.classList.remove('translate-x-full');
                overlay.classList.remove('hidden');
                notificationsPanelOpen = true;
                loadWorkerNotifications();
            }
        }

        function loadWorkerNotifications() {
            fetch('/api/employer/worker-notifications', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Received data:', data);
                    console.log('Data type:', typeof data);
                    console.log('Is array:', Array.isArray(data));
                    renderWorkerNotifications(data);
                })
                .catch(error => {
                    console.error('Error loading worker notifications:', error);
                    console.error('Error stack:', error.stack);
                    const container = document.getElementById('workerNotificationsContainer');
                    container.innerHTML = `
                        <div class="text-center py-8 text-red-500">
                            <i class="fas fa-exclamation-triangle text-3xl mb-2"></i>
                            <p class="text-lg">Error loading notifications</p>
                            <p class="text-sm">Network error: ${error.message}</p>
                            <button onclick="loadWorkerNotifications()" class="mt-2 bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition-colors">
                                Try Again
                            </button>
                        </div>
                    `;
                });
        }

        function renderWorkerNotifications(notifications) {
            const container = document.getElementById('workerNotificationsContainer');
            
            if (!notifications || notifications.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-user-slash text-3xl mb-2"></i>
                        <p class="text-lg">No worker matches yet</p>
                        <p class="text-sm">We'll notify you when workers matching your job requirements are found</p>
                    </div>
                `;
                return;
            }

            // Filter out notifications with missing data
            const validNotifications = notifications.filter(notification => 
                notification.worker_name && notification.job_title && notification.match_percentage
            );

            if (validNotifications.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-user-slash text-3xl mb-2"></i>
                        <p class="text-lg">No active worker matches</p>
                        <p class="text-sm">Previous matches were for jobs or workers that are no longer available</p>
                    </div>
                `;
                return;
            }

            const notificationsHtml = validNotifications.map(notification => `
                <div class="bg-gray-50 rounded-lg p-3 sm:p-4 border border-gray-200 ${!notification.is_read ? 'border-blue-300 bg-blue-50' : ''}">
                    <div class="flex items-start space-x-3 sm:space-x-4">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-500 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-user text-white text-sm sm:text-base"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2 gap-1">
                                <h4 class="text-base sm:text-lg font-semibold text-gray-900 truncate">${notification.worker_name}</h4>
                                <div class="text-left sm:text-right">
                                    <div class="text-base sm:text-lg font-bold text-green-600">${Math.round(notification.match_percentage)}% Match</div>
                                </div>
                            </div>
                            <p class="text-xs sm:text-sm text-gray-600 mb-2">
                                <i class="fas fa-briefcase mr-1"></i>
                                Matches: <strong class="break-words">${notification.job_title}</strong>
                            </p>
                            <p class="text-xs sm:text-sm text-gray-500 mb-2 break-all">
                                <i class="fas fa-envelope mr-1"></i>
                                ${notification.worker_email}
                            </p>
                            ${notification.worker_location ? `
                            <p class="text-xs sm:text-sm text-gray-500 mb-2">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                ${notification.worker_location}
                            </p>
                            ` : ''}
                            ${notification.matched_skills && notification.matched_skills.length > 0 ? `
                            <div class="mb-2">
                                <p class="text-xs text-gray-600 mb-1">Matched Skills:</p>
                                <div class="flex flex-wrap gap-1">
                                    ${notification.matched_skills.map(skill => `
                                        <span class="inline-block px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full">${skill}</span>
                                    `).join('')}
                                </div>
                            </div>
                            ` : ''}
                            <p class="text-xs text-gray-400 mb-2">
                                <i class="fas fa-clock mr-1"></i>
                                ${new Date(notification.created_at).toLocaleDateString()}
                            </p>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <button onclick="viewWorkerProfile(${notification.worker_id})" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition">
                                    <i class="fas fa-eye mr-1"></i>View Profile
                                </button>
                                <button onclick="contactWorker(${notification.worker_id})" class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700 transition">
                                    <i class="fas fa-envelope mr-1"></i>Contact
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');

            container.innerHTML = notificationsHtml;
        }

        function viewWorkerProfile(workerId) {
            showModernToast(
                'View Worker Profile',
                'Would you like to view the detailed profile of this worker?',
                'info',
                () => openWorkerProfileModal(workerId),
                'profile' // Action type
            );
        }

        function contactWorker(workerId) {
            showModernToast(
                'Contact Worker',
                'Would you like to view contact information for this worker?',
                'success',
                () => openContactWorkerModal(workerId),
                'contact' // Action type
            );
        }

        function viewSkillMatches(jobId) {
            console.log('🔍 Viewing skill matches for job:', jobId);
            
            // Show loading toast
            showModernToast(
                'Loading Skill Matches',
                'Finding workers with matching skills...',
                'info'
            );

            // Fetch detailed skill matches for this job
            fetch(`/employer/jobs/${jobId}/skill-matches`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showSkillMatchesModal(data.matches, data.job);
                    } else {
                        showModernToast('Error', 'Failed to load skill matches', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error fetching skill matches:', error);
                    showModernToast('Error', 'Failed to load skill matches', 'error');
                });
        }

        function showSkillMatchesModal(matches, job) {
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
            modal.innerHTML = `
                <div class="bg-white rounded-xl shadow-xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900">Skill Matches for "${job.title}"</h3>
                                <p class="text-gray-600 mt-1">Found ${matches.length} workers with matching skills</p>
                            </div>
                            <button onclick="this.closest('.fixed').remove()" class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                    </div>
                    <div class="p-6 overflow-y-auto max-h-[70vh]">
                        <div class="space-y-4">
                            ${matches.map(match => `
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-indigo-500 rounded-full flex items-center justify-center">
                                                <span class="text-white font-semibold">${match.worker.name.charAt(0)}</span>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900">${match.worker.name}</h4>
                                                <p class="text-sm text-gray-600">${match.worker.email}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-lg font-bold text-indigo-600">${Math.round(match.match_score)}%</div>
                                            <div class="text-xs text-gray-500">Match Score</div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <h5 class="text-sm font-medium text-gray-700 mb-2">Matching Skills:</h5>
                                        <div class="flex flex-wrap gap-2">
                                            ${match.matching_skills.map(skill => 
                                                `<span class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded-full text-xs">${skill.name}</span>`
                                            ).join('')}
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button onclick="contactWorker(${match.worker.id})" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm">
                                            <i class="fas fa-envelope mr-1"></i> Contact
                                        </button>
                                        <button onclick="viewWorkerProfile(${match.worker.id})" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm">
                                            <i class="fas fa-user mr-1"></i> View Profile
                                        </button>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
        }

        function viewWorkerProfile(workerId) {
            console.log('👤 Viewing worker profile:', workerId);
            
            // Store the worker ID for later use
            window.pendingWorkerProfileId = workerId;
            
            // Show confirmation modal instead of directly opening profile
            showProfileConfirmationModal(workerId);
        }

        // Modern Toast Notification System
        let currentToastAction = null;
        let currentActionType = null;

        function showModernToast(title, message, type = 'info', actionCallback = null, actionType = null) {
            const toast = document.getElementById('modernToast');
            const icon = document.getElementById('toastIcon');
            const titleEl = document.getElementById('toastTitle');
            const messageEl = document.getElementById('toastMessage');
            const actionBtn = document.getElementById('toastActionBtn');

            // Set content
            titleEl.textContent = title;
            messageEl.textContent = message;
            currentToastAction = actionCallback;
            currentActionType = actionType;

            // Set icon, colors, and button text based on type and action
            if (type === 'success' && actionType === 'contact') {
                icon.className = 'w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 bg-green-500';
                icon.innerHTML = '<i class="fas fa-envelope text-white"></i>';
                actionBtn.className = 'bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition-colors';
                actionBtn.textContent = 'View Contact Info';
            } else if (type === 'info' && actionType === 'profile') {
                icon.className = 'w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 bg-blue-500';
                icon.innerHTML = '<i class="fas fa-user text-white"></i>';
                actionBtn.className = 'bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors';
                actionBtn.textContent = 'View Full Profile';
            } else {
                // Default fallback
                icon.className = 'w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 bg-blue-500';
                icon.innerHTML = '<i class="fas fa-info text-white"></i>';
                actionBtn.className = 'bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors';
                actionBtn.textContent = 'View Details';
            }

            // Show toast
            toast.classList.remove('translate-x-full');
            
            // Auto hide after 10 seconds
            setTimeout(() => {
                if (!toast.classList.contains('translate-x-full')) {
                    hideModernToast();
                }
            }, 10000);
        }

        function hideModernToast() {
            const toast = document.getElementById('modernToast');
            toast.classList.add('translate-x-full');
            currentToastAction = null;
            currentActionType = null;
        }

        function handleToastAction() {
            console.log('🎯 handleToastAction called');
            console.log('📋 currentToastAction:', currentToastAction);
            console.log('📋 currentActionType:', currentActionType);
            
            if (currentToastAction && currentActionType) {
                // Execute the appropriate action based on the action type
                if (currentActionType === 'profile') {
                    console.log('👤 Executing profile action');
                    currentToastAction(); // This will call openWorkerProfileModal(workerId)
                } else if (currentActionType === 'contact') {
                    console.log('📞 Executing contact action');
                    currentToastAction(); // This will call openContactWorkerModal(workerId)
                }
            } else {
                console.warn('⚠️ No action or action type set');
            }
            hideModernToast();
        }

        // Test function for debugging (can be called from browser console)
        window.testWorkerModal = function(workerId = 1) {
            console.log('🧪 Testing worker modal with ID:', workerId);
            openWorkerProfileModal(workerId);
        };

        window.testConfirmationModal = function(workerId = 1) {
            console.log('🧪 Testing confirmation modal with ID:', workerId);
            showProfileConfirmationModal(workerId);
        };

        // Profile Confirmation Modal Functions
        function showProfileConfirmationModal(workerId) {
            console.log('🔍 Showing profile confirmation modal for worker ID:', workerId);
            
            const modal = document.getElementById('profileConfirmationModal');
            if (modal) {
                modal.classList.remove('hidden');
                console.log('✅ Profile confirmation modal should now be visible');
                
                // Add keyboard event listener for ESC key
                document.addEventListener('keydown', handleConfirmationModalKeydown);
            } else {
                console.error('❌ Profile confirmation modal not found!');
            }
        }

        function closeProfileConfirmationModal() {
            console.log('❌ Closing profile confirmation modal');
            
            const modal = document.getElementById('profileConfirmationModal');
            if (modal) {
                modal.classList.add('hidden');
                window.pendingWorkerProfileId = null;
                
                // Remove keyboard event listener
                document.removeEventListener('keydown', handleConfirmationModalKeydown);
                
                console.log('✅ Profile confirmation modal closed');
            }
        }

        function handleConfirmationModalKeydown(event) {
            if (event.key === 'Escape') {
                closeProfileConfirmationModal();
            }
        }

        function confirmViewProfile() {
            console.log('✅ User confirmed to view profile');
            
            const workerId = window.pendingWorkerProfileId;
            if (workerId) {
                console.log('🚀 Opening worker profile modal for worker ID:', workerId);
                
                // Close confirmation modal
                closeProfileConfirmationModal();
                
                // Open the actual worker profile modal
                openWorkerProfileModal(workerId);
            } else {
                console.error('❌ No pending worker profile ID found');
            }
        }

        // Worker Profile Modal Functions
        function openWorkerProfileModal(workerId) {
            console.log('🔍 Opening worker profile modal for worker ID:', workerId);
            
            const modal = document.getElementById('workerProfileModal');
            const content = document.getElementById('workerProfileContent');
            
            console.log('📋 Modal element found:', modal);
            console.log('📋 Content element found:', content);
            
            if (!modal) {
                console.error('❌ Worker profile modal not found!');
                return;
            }
            
            if (!content) {
                console.error('❌ Worker profile content not found!');
                return;
            }
            
            // Show modal
            modal.classList.remove('hidden');
            console.log('✅ Modal should now be visible');
            
            // Load worker profile data
            console.log('🌐 Making API call to:', `/api/worker/${workerId}/profile`);
            
            // Set loading content
            content.innerHTML = `
                <div class="flex justify-center items-center py-8">
                    <i class="fas fa-spinner fa-spin text-2xl text-blue-500"></i>
                    <span class="ml-2 text-gray-600">Loading worker profile...</span>
                </div>
            `;
            
            fetch(`/api/worker/${workerId}/profile`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
                .then(response => {
                    console.log('📡 API Response status:', response.status);
                    console.log('📡 API Response ok:', response.ok);
                    
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('📊 API Response data:', data);
                    
                    if (data.success) {
                        console.log('✅ Worker data received:', data.worker);
                        renderWorkerProfile(data.worker);
                    } else {
                        console.error('❌ API returned error:', data.message);
                        content.innerHTML = `
                            <div class="text-center py-8 text-red-500">
                                <i class="fas fa-exclamation-triangle text-3xl mb-2"></i>
                                <p class="text-lg">Error loading profile</p>
                                <p class="text-sm">${data.message || 'Please try again later'}</p>
                                <button onclick="openWorkerProfileModal(${workerId})" class="mt-2 bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition-colors">
                                    Try Again
                                </button>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('❌ Error loading worker profile:', error);
                    content.innerHTML = `
                        <div class="text-center py-8 text-red-500">
                            <i class="fas fa-exclamation-triangle text-3xl mb-2"></i>
                            <p class="text-lg">Error loading profile</p>
                            <p class="text-sm">Network error: ${error.message}</p>
                            <button onclick="openWorkerProfileModal(${workerId})" class="mt-2 bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition-colors">
                                Try Again
                            </button>
                            <div class="mt-4 p-4 bg-gray-100 rounded-lg text-left">
                                <p class="text-xs text-gray-600 mb-2">Debug Info:</p>
                                <p class="text-xs text-gray-600">Worker ID: ${workerId}</p>
                                <p class="text-xs text-gray-600">URL: /api/worker/${workerId}/profile</p>
                                <p class="text-xs text-gray-600">Error: ${error.message}</p>
                            </div>
                        </div>
                    `;
                });
        }

        function renderWorkerProfile(worker) {
            console.log('🎨 Rendering worker profile:', worker);
            
            const content = document.getElementById('workerProfileContent');
            
            if (!content) {
                console.error('❌ Worker profile content element not found!');
                return;
            }
            
            // Render skills HTML
            let skillsHtml = '';
            if (worker.skills && worker.skills.length > 0) {
                skillsHtml = worker.skills.map(skill => `
                    <div class="flex items-center justify-between p-3 bg-white border border-gray-200 rounded-lg">
                        <div>
                            <span class="font-medium text-gray-900">${skill.name}</span>
                            <span class="text-sm text-gray-500 ml-2">(${skill.years_experience || 0} years)</span>
                        </div>
                        <span class="px-3 py-1 text-xs font-medium rounded-full ${
                            skill.proficiency_level === 'expert' ? 'bg-green-100 text-green-800' :
                            skill.proficiency_level === 'advanced' ? 'bg-blue-100 text-blue-800' :
                            skill.proficiency_level === 'intermediate' ? 'bg-yellow-100 text-yellow-800' :
                            'bg-gray-100 text-gray-800'
                        }">${skill.proficiency_level || 'Beginner'}</span>
                    </div>
                `).join('');
            } else {
                skillsHtml = `
                    <div class="text-center py-4 text-gray-500">
                        <i class="fas fa-tools text-2xl mb-2"></i>
                        <p>No skills listed</p>
                    </div>
                `;
            }
            
            content.innerHTML = `
                <div class="space-y-6">
                    <!-- Worker Header -->
                    <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-xl">
                        <div class="w-20 h-20 rounded-full overflow-hidden bg-gray-300 flex items-center justify-center">
                            ${worker.profile_picture ? 
                                `<img src="/storage/${worker.profile_picture}" alt="${worker.name}" class="w-full h-full object-cover">` :
                                `<i class="fas fa-user text-gray-500 text-2xl"></i>`
                            }
                        </div>
                        <div>
                            <h4 class="text-2xl font-bold text-gray-900">${worker.name}</h4>
                            <p class="text-gray-600">${worker.email}</p>
                            <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                                ${worker.phone ? `<span><i class="fas fa-phone mr-1"></i>${worker.phone}</span>` : ''}
                                ${worker.location ? `<span><i class="fas fa-map-marker-alt mr-1"></i>${worker.location}</span>` : ''}
                            </div>
                        </div>
                    </div>

                    <!-- Bio -->
                    ${worker.bio ? `
                        <div>
                            <h5 class="text-lg font-semibold text-gray-900 mb-2">About</h5>
                            <p class="text-gray-700 bg-gray-50 p-4 rounded-lg">${worker.bio}</p>
                        </div>
                    ` : ''}

                    <!-- Skills -->
                    <div>
                        <h5 class="text-lg font-semibold text-gray-900 mb-3">Skills & Experience</h5>
                        <div id="workerSkillsList" class="space-y-2">
                            ${skillsHtml}
                        </div>
                    </div>

                    <!-- Contact Actions -->
                    <div class="flex space-x-3 pt-4 border-t border-gray-200">
                        <button onclick="initiateContact('${worker.email}')" class="flex-1 bg-green-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-green-700 transition-colors">
                            <i class="fas fa-envelope mr-2"></i>Send Email
                        </button>
                        ${worker.phone ? `
                            <button onclick="initiateCall('${worker.phone}')" class="flex-1 bg-blue-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                                <i class="fas fa-phone mr-2"></i>Call
                            </button>
                        ` : ''}
                    </div>
                </div>
            `;
        }

        function closeWorkerProfileModal() {
            document.getElementById('workerProfileModal').classList.add('hidden');
        }

        // Contact Worker Modal Functions
        function openContactWorkerModal(workerId) {
            const modal = document.getElementById('contactWorkerModal');
            const content = document.getElementById('contactWorkerContent');
            
            // Show modal
            modal.classList.remove('hidden');
            
            // Show loading state
            content.innerHTML = `
                <div class="flex justify-center items-center py-8">
                    <i class="fas fa-spinner fa-spin text-blue-500 text-2xl"></i>
                    <span class="ml-3 text-gray-600">Loading contact info...</span>
                </div>
            `;
            
            // Load worker profile data (which includes contact info)
            fetch(`/api/worker/${workerId}/profile`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        renderContactInfo(data.worker);
                    } else {
                        content.innerHTML = `
                            <div class="text-center py-8 text-red-500">
                                <i class="fas fa-exclamation-triangle text-3xl mb-2"></i>
                                <p class="text-lg">Error loading contact info</p>
                                <p class="text-sm">${data.message || 'Please try again later'}</p>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error loading contact info:', error);
                    content.innerHTML = `
                        <div class="text-center py-8 text-red-500">
                            <i class="fas fa-exclamation-triangle text-3xl mb-2"></i>
                            <p class="text-lg">Error loading contact info</p>
                            <p class="text-sm">Network error: ${error.message}</p>
                            <button onclick="openContactWorkerModal(${workerId})" class="mt-2 bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700 transition-colors">
                                Try Again
                            </button>
                        </div>
                    `;
                });
        }

        function renderContactInfo(worker) {
            const content = document.getElementById('contactWorkerContent');
            
            content.innerHTML = `
                <div class="text-center space-y-6">
                    <!-- Worker Image -->
                    <div class="w-24 h-24 mx-auto rounded-full overflow-hidden bg-gray-300 flex items-center justify-center">
                        ${worker.profile_picture ? 
                            `<img src="/storage/${worker.profile_picture}" alt="${worker.name}" class="w-full h-full object-cover">` :
                            `<i class="fas fa-user text-gray-500 text-3xl"></i>`
                        }
                    </div>

                    <!-- Worker Info -->
                    <div>
                        <h4 class="text-xl font-bold text-gray-900 mb-2">${worker.name}</h4>
                        <div class="space-y-3">
                            <div class="flex items-center justify-center space-x-2 text-gray-600">
                                <i class="fas fa-envelope w-4"></i>
                                <span>${worker.email}</span>
                            </div>
                            ${worker.phone ? `
                                <div class="flex items-center justify-center space-x-2 text-gray-600">
                                    <i class="fas fa-phone w-4"></i>
                                    <span>${worker.phone}</span>
                                </div>
                            ` : ''}
                            ${worker.location ? `
                                <div class="flex items-center justify-center space-x-2 text-gray-600">
                                    <i class="fas fa-map-marker-alt w-4"></i>
                                    <span>${worker.location}</span>
                                </div>
                            ` : ''}
                        </div>
                    </div>

                    <!-- Contact Actions -->
                    <div class="space-y-3">
                        <button onclick="initiateContact('${worker.email}')" class="w-full bg-green-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-green-700 transition-colors">
                            <i class="fas fa-envelope mr-2"></i>Send Email
                        </button>
                        ${worker.phone ? `
                            <button onclick="initiateCall('${worker.phone}')" class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                                <i class="fas fa-phone mr-2"></i>Call ${worker.phone}
                            </button>
                        ` : ''}
                    </div>
                </div>
            `;
        }

        function closeContactWorkerModal() {
            document.getElementById('contactWorkerModal').classList.add('hidden');
        }

        // Contact Actions
        function initiateContact(email) {
            window.location.href = `mailto:${email}?subject=Job Opportunity&body=Hello, I found your profile matches one of my job requirements. I would like to discuss a potential opportunity with you.`;
        }

        function initiateCall(phone) {
            window.location.href = `tel:${phone}`;
        }

        // Load notification count on page load
        function loadNotificationCount() {
            fetch('/api/employer/worker-notifications', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    const badge = document.getElementById('notificationBadge');
                    const mobileBadge = document.getElementById('mobileNotificationBadge');
                    const unreadCount = data.filter(n => !n.is_read).length;
                    badge.textContent = unreadCount;
                    badge.style.display = unreadCount > 0 ? 'block' : 'none';
                    
                    if (mobileBadge) {
                        mobileBadge.textContent = unreadCount;
                        mobileBadge.style.display = unreadCount > 0 ? 'block' : 'none';
                    }
                })
                .catch(error => {
                    console.error('Error loading notification count:', error);
                });
        }

        // Load notification count when page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadNotificationCount();
        });
    </script>
    
    <!-- Confirmation Modal for Approve/Reject -->
    <div id="confirmationModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all">
            <div class="p-6">
                <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full" id="confirmIcon">
                    <!-- Icon will be inserted here -->
                </div>
                <h3 class="text-2xl font-bold text-center text-gray-900 mb-2" id="confirmTitle">Confirm Action</h3>
                <p class="text-center text-gray-600 mb-6" id="confirmMessage">Are you sure you want to proceed?</p>
                <div class="flex gap-3">
                    <button onclick="closeConfirmModal()" class="flex-1 px-4 py-3 bg-gray-200 text-gray-800 rounded-xl font-semibold hover:bg-gray-300 transition">
                        Cancel
                    </button>
                    <button id="confirmButton" class="flex-1 px-4 py-3 rounded-xl font-semibold text-white transition">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Success Modal -->
    <div id="successModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-2xl max-w-md w-full transform transition-all">
            <div class="p-8 text-center">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce">
                    <i class="fas fa-check text-green-600 text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">Success!</h3>
                <p class="text-green-50 mb-6" id="successMessage">Operation completed successfully!</p>
                <button onclick="closeSuccessModal()" class="bg-white text-green-600 px-8 py-3 rounded-xl font-semibold hover:bg-green-50 transition shadow-lg">
                    <i class="fas fa-thumbs-up mr-2"></i>
                    Great!
                </button>
            </div>
        </div>
    </div>
    
    <!-- Error Modal -->
    <div id="errorModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-2xl shadow-2xl max-w-md w-full transform transition-all">
            <div class="p-8 text-center">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">Oops!</h3>
                <p class="text-red-50 mb-6" id="errorMessage">Something went wrong. Please try again.</p>
                <button onclick="closeErrorModal()" class="bg-white text-red-600 px-8 py-3 rounded-xl font-semibold hover:bg-red-50 transition shadow-lg">
                    <i class="fas fa-times mr-2"></i>
                    Close
                </button>
            </div>
        </div>
    </div>
    
    <script>
        // Top Bar Dropdown Functions for Employer
        function toggleEmployerNotifications() {
            const dropdown = document.getElementById('employerNotificationsDropdown');
            dropdown.classList.toggle('hidden');
            closeOtherEmployerDropdowns('employerNotificationsDropdown');
        }
        
        function toggleEmployerQuickActions() {
            const dropdown = document.getElementById('employerQuickActionsDropdown');
            dropdown.classList.toggle('hidden');
            closeOtherEmployerDropdowns('employerQuickActionsDropdown');
        }
        
        function toggleEmployerTopBarProfile() {
            const dropdown = document.getElementById('employerTopBarProfileDropdown');
            dropdown.classList.toggle('hidden');
            closeOtherEmployerDropdowns('employerTopBarProfileDropdown');
        }
        
        function closeOtherEmployerDropdowns(exceptId) {
            const dropdowns = ['employerNotificationsDropdown', 'employerQuickActionsDropdown', 'employerTopBarProfileDropdown', 'themeMenuDropdown'];
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
                closeOtherEmployerDropdowns('');
            }
        });
        
        // Theme Management Functions
        function toggleThemeMenu() {
            const dropdown = document.getElementById('themeMenuDropdown');
            dropdown.classList.toggle('hidden');
            closeOtherEmployerDropdowns('themeMenuDropdown');
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
                themeIcon.className = `fas fa-${icon} text-gray-600 group-hover:text-${icon === 'sun' ? 'yellow' : icon === 'moon' ? 'indigo' : 'gray'}-500 transition-colors`;
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
            <div class="relative bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-white rounded-t-2xl overflow-hidden">
                <div class="absolute inset-0 opacity-20">
                    <div class="absolute -top-1/2 -left-1/2 w-full h-full bg-gradient-to-br from-white/20 to-transparent rounded-full blur-3xl animate-blob"></div>
                </div>
                <div class="relative z-10 flex items-center gap-4">
                    <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                        <i class="fas fa-sign-out-alt text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold">Confirm Logout</h3>
                        <p class="text-blue-100 text-sm">End your session</p>
                    </div>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <div class="flex items-start gap-4 mb-6">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-blue-600 dark:text-blue-400 text-xl"></i>
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
                        <span class="font-medium text-gray-800 dark:text-gray-200">Employer</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3">
                    <button onclick="closeLogoutModal()" class="flex-1 px-4 py-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-medium transition-all">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </button>
                    <button onclick="proceedLogout()" class="flex-1 px-4 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-lg font-medium transition-all shadow-lg hover:shadow-xl">
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
                    <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-blue-200 border-t-blue-600 mb-4"></div>
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


<script>
// Employer Profile Dropdown Functions
function toggleEmployerProfileDropdown() {
    const dropdown = document.getElementById('employerProfileDropdown');
    dropdown.classList.toggle('hidden');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('employerProfileDropdown');
    const button = event.target.closest('button[onclick="toggleEmployerProfileDropdown()"]');
    
    if (!button && dropdown && !dropdown.contains(event.target)) {
        dropdown.classList.add('hidden');
    }
});

// Business Information
function openBusinessInfo() {
    document.getElementById('employerProfileDropdown').classList.add('hidden');
    alert('Business Information - Coming soon!\n\nEdit:\n- Business Name\n- Business Type\n- Contact Person\n- Phone & Email\n- Business Location');
}

// Business Verification
function openBusinessVerification() {
    document.getElementById('employerProfileDropdown').classList.add('hidden');
    alert('Business Verification - Coming soon!\n\nUpload:\n- Business License\n- National ID\n- Other verification documents');
}

// Change Password
function openEmployerPasswordChange() {
    document.getElementById('employerProfileDropdown').classList.add('hidden');
    alert('Change Password - Coming soon!');
}

// Posted Jobs
function openPostedJobs() {
    document.getElementById('employerProfileDropdown').classList.add('hidden');
    // Navigate to job posts section
    const jobPostsLink = document.querySelector('[data-content="job-posts"]');
    if (jobPostsLink) jobPostsLink.click();
}

// Active Jobs
function openActiveJobs() {
    document.getElementById('employerProfileDropdown').classList.add('hidden');
    // Navigate to dashboard to see active jobs
    const dashboardLink = document.querySelector('[data-content="dashboard"]');
    if (dashboardLink) dashboardLink.click();
}

// Hired Workers
function openHiredWorkers() {
    document.getElementById('employerProfileDropdown').classList.add('hidden');
    alert('Hired Workers - Coming soon!\n\nView all workers you have hired');
}

// Ratings Given
function openRatingsGiven() {
    document.getElementById('employerProfileDropdown').classList.add('hidden');
    alert('Ratings Given - Coming soon!\n\nView all ratings you have given to workers');
}
</script>
