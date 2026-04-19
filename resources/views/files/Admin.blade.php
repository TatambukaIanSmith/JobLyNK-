<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - JOB-lyNK</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        /* Top Bar Styles */
        .top-bar-dropdown {
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
        
        /* Search Results Animation */
        #adminSearchResults {
            animation: fadeIn 0.2s ease-out;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        /* Settings Tab Styles */
        .active-settings-tab {
            border-bottom-color: #2563eb !important;
            color: #2563eb !important;
            background-color: #eff6ff;
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
        
        /* Main Content Area */
        .dark .wave-container {
            background: #111827 !important;
        }
        
        .dark .bg-gray-100 {
            background-color: #1f2937 !important;
        }
        
        .dark .wave {
            opacity: 0.1;
        }
        
        /* Cards and Containers */
        .dark .glass-card {
            background: rgba(31, 41, 55, 0.8);
            border: 1px solid rgba(75, 85, 99, 0.3);
        }
        
        .dark .glass-card:hover {
            background: rgba(31, 41, 55, 0.95);
        }
        
        .dark .glass-card-large {
            background: rgba(31, 41, 55, 0.7);
            border: 1px solid rgba(75, 85, 99, 0.4);
        }
        
        .dark .glass-card-large:hover {
            background: rgba(31, 41, 55, 0.9);
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
        
        /* Content Container */
        .dark #admin-content-container {
            background-color: transparent !important;
        }
        
        .dark .p-4,
        .dark .p-6,
        .dark .p-8,
        .dark .p-10 {
            background-color: transparent !important;
        }
        
        /* Text Colors */
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
        
        .dark .text-gray-400 {
            color: #9ca3af !important;
        }
        
        /* Borders */
        .dark .border-gray-200 {
            border-color: #374151 !important;
        }
        
        .dark .border-gray-300 {
            border-color: #4b5563 !important;
        }
        
        .dark .divide-gray-200 > * + * {
            border-color: #374151 !important;
        }
        
        /* Sidebar */
        .dark .admin-sidebar {
            background-color: #111827 !important;
            border-right: 1px solid #374151;
        }
        
        .dark .sidebar-link {
            color: #9ca3af;
        }
        
        .dark .sidebar-link:hover {
            background-color: #1f2937;
            color: #e5e7eb;
        }
        
        .dark .sidebar-active {
            background-color: #374151 !important;
            color: white !important;
        }
        
        /* Top Bar */
        .dark .sticky.top-0 {
            background-color: rgba(31, 41, 55, 0.95) !important;
            backdrop-filter: blur(12px);
            border-bottom-color: #374151 !important;
        }
        
        /* Tables */
        .dark table thead {
            background-color: #111827 !important;
        }
        
        .dark table tbody {
            background-color: #1f2937 !important;
        }
        
        .dark table tbody tr:hover {
            background-color: #374151 !important;
        }
        
        .dark .bg-gray-50\/80 {
            background-color: rgba(17, 24, 39, 0.8) !important;
        }
        
        .dark .bg-white\/70 {
            background-color: rgba(31, 41, 55, 0.7) !important;
        }
        
        .dark .bg-white\/90 {
            background-color: rgba(31, 41, 55, 0.9) !important;
        }
        
        /* Forms and Inputs */
        .dark input[type="text"],
        .dark input[type="email"],
        .dark input[type="number"],
        .dark input[type="tel"],
        .dark input[type="password"],
        .dark input[type="search"],
        .dark textarea,
        .dark select {
            background-color: #111827 !important;
            border-color: #374151 !important;
            color: #e5e7eb !important;
        }
        
        .dark input::placeholder,
        .dark textarea::placeholder {
            color: #6b7280 !important;
        }
        
        .dark input:focus,
        .dark textarea:focus,
        .dark select:focus {
            border-color: #3b82f6 !important;
            background-color: #1f2937 !important;
        }
        
        /* Modals */
        .dark .fixed.inset-0.bg-black {
            background-color: rgba(0, 0, 0, 0.8) !important;
        }
        
        .dark .rounded-lg.shadow-xl,
        .dark .rounded-2xl.shadow-2xl,
        .dark .rounded-xl.shadow-2xl {
            background-color: #1f2937 !important;
            border: 1px solid #374151;
        }
        
        /* Dropdowns */
        .dark #notificationsDropdown,
        .dark #quickActionsDropdown,
        .dark #topBarProfileDropdown,
        .dark #themeMenuDropdown,
        .dark #adminSearchResults {
            background-color: #1f2937 !important;
            border-color: #374151 !important;
        }
        
        .dark .hover\:bg-gray-50:hover {
            background-color: #374151 !important;
        }
        
        /* Badges and Status */
        .dark .bg-green-100 {
            background-color: rgba(34, 197, 94, 0.2) !important;
        }
        
        .dark .bg-yellow-100 {
            background-color: rgba(234, 179, 8, 0.2) !important;
        }
        
        .dark .bg-red-100 {
            background-color: rgba(239, 68, 68, 0.2) !important;
        }
        
        .dark .bg-blue-100 {
            background-color: rgba(59, 130, 246, 0.2) !important;
        }
        
        .dark .bg-purple-100 {
            background-color: rgba(168, 85, 247, 0.2) !important;
        }
        
        .dark .bg-blue-50 {
            background-color: rgba(59, 130, 246, 0.1) !important;
        }
        
        .dark .bg-green-50 {
            background-color: rgba(34, 197, 94, 0.1) !important;
        }
        
        .dark .bg-yellow-50 {
            background-color: rgba(234, 179, 8, 0.1) !important;
        }
        
        .dark .bg-red-50 {
            background-color: rgba(239, 68, 68, 0.1) !important;
        }
        
        .dark .bg-purple-50 {
            background-color: rgba(168, 85, 247, 0.1) !important;
        }
        
        /* Shadows */
        .dark .shadow-md,
        .dark .shadow-lg,
        .dark .shadow-xl,
        .dark .shadow-2xl {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5), 0 8px 10px -6px rgba(0, 0, 0, 0.5) !important;
        }
        
        /* Settings Tabs */
        .dark .settings-tab {
            color: #9ca3af;
            border-bottom-color: transparent;
        }
        
        .dark .settings-tab:hover {
            color: #60a5fa;
            background-color: #1f2937;
        }
        
        .dark .active-settings-tab {
            border-bottom-color: #3b82f6 !important;
            color: #60a5fa !important;
            background-color: rgba(59, 130, 246, 0.1) !important;
        }
        
        /* Toggle Switches */
        .dark .peer:checked ~ div {
            background-color: #3b82f6 !important;
        }
        
        .dark .peer ~ div {
            background-color: #4b5563 !important;
        }
        
        /* Ripple Effects */
        .dark .ripple {
            background: radial-gradient(circle, rgba(59, 130, 246, 0.3) 0%, rgba(147, 197, 253, 0.1) 50%, transparent 100%);
        }
        
        /* Charts (preserve visibility) */
        .dark canvas {
            filter: brightness(0.9);
        }
        
        /* Preserve Button Colors */
        .dark .bg-blue-600,
        .dark .bg-green-600,
        .dark .bg-red-600,
        .dark .bg-yellow-600,
        .dark .bg-purple-600,
        .dark .bg-indigo-600,
        .dark .bg-gray-600 {
            /* Keep original colors */
        }
        
        /* Scrollbar */
        .dark ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        .dark ::-webkit-scrollbar-track {
            background: #1f2937;
        }
        
        .dark ::-webkit-scrollbar-thumb {
            background: #4b5563;
            border-radius: 4px;
        }
        
        .dark ::-webkit-scrollbar-thumb:hover {
            background: #6b7280;
        }
        
        /* Custom style for active sidebar link */
        .sidebar-active {
            background-color: #4b5563; /* gray-600 */
            color: white;
            font-weight: 600;
        }
        
        /* Ensure all content sections display in the same location */
        .content-section {
            display: block;
        }
        
        .content-section.hidden {
            display: none;
        }
        
        /* Sidebar container - ensure it stays contained */
        .admin-sidebar {
            width: 256px;
            min-width: 256px;
            max-width: 256px;
            height: 100vh;
            overflow: hidden;
        }
        
        /* Sidebar enhancements */
        .sidebar-link:hover {
            transform: translateX(2px);
        }
        
        /* Logout button hover effect */
        .logout-btn:hover {
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }
        
        /* Admin badge styling */
        .admin-badge {
            background: linear-gradient(45deg, #ef4444, #dc2626);
            animation: pulse 2s infinite;
        }
        
        /* Ensure bottom section stays at bottom */
        .sidebar-bottom {
            margin-top: auto;
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
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .glass-card:hover {
            background: rgba(255, 255, 255, 0.8);
            transform: translateY(-2px);
            box-shadow: 0 12px 40px 0 rgba(31, 38, 135, 0.2);
        }
        
        .glass-card-large {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            padding: 1.5rem;
            transition: all 0.3s ease;
        }
        
        .glass-card-large:hover {
            background: rgba(255, 255, 255, 0.7);
            box-shadow: 0 12px 40px 0 rgba(31, 38, 135, 0.2);
        }
        
        /* Water Reflection Effect */
        .water-reflection {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100%;
            transform: scaleY(-1);
            opacity: 0.3;
            pointer-events: none;
            background: linear-gradient(to bottom, transparent 0%, rgba(255, 255, 255, 0.5) 100%);
            mask-image: linear-gradient(to bottom, transparent 0%, black 50%, transparent 100%);
            -webkit-mask-image: linear-gradient(to bottom, transparent 0%, black 50%, transparent 100%);
            filter: blur(2px);
        }
        
        /* Animated Blob Backgrounds */
        @keyframes blob {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            25% {
                transform: translate(20px, -20px) scale(1.1);
            }
            50% {
                transform: translate(-20px, 20px) scale(0.9);
            }
            75% {
                transform: translate(20px, 20px) scale(1.05);
            }
        }
        
        .animate-blob {
            animation: blob 7s infinite;
        }
        
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        
        /* Wave Effect */
        .wave-container {
            position: relative;
            overflow: hidden;
        }
        
        .wave {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 200%;
            height: 150px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z' opacity='.25' fill='%233b82f6'/%3E%3Cpath d='M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z' opacity='.5' fill='%2360a5fa'/%3E%3Cpath d='M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z' fill='%2393c5fd'/%3E%3C/svg%3E");
            background-size: 50% 100%;
            animation: wave 15s linear infinite;
            opacity: 0.4;
        }
        
        .wave:nth-child(2) {
            bottom: 10px;
            animation: wave 20s linear reverse infinite;
            opacity: 0.35;
        }
        
        .wave:nth-child(3) {
            bottom: 20px;
            animation: wave 25s linear infinite;
            opacity: 0.3;
        }
        
        @keyframes wave {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-50%);
            }
        }
        
        /* Ripple Effect for Modals */
        .ripple-container {
            position: relative;
            overflow: hidden;
        }
        
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(239, 68, 68, 0.4) 0%, rgba(248, 113, 113, 0.2) 50%, transparent 100%);
            animation: ripple-animation 4s ease-out infinite;
            pointer-events: none;
        }
        
        .ripple:nth-child(1) {
            width: 300px;
            height: 300px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .ripple:nth-child(2) {
            width: 400px;
            height: 400px;
            top: 50%;
            right: 10%;
            animation-delay: 1.5s;
        }
        
        .ripple:nth-child(3) {
            width: 350px;
            height: 350px;
            bottom: 10%;
            left: 30%;
            animation-delay: 3s;
        }
        
        .ripple:nth-child(4) {
            width: 250px;
            height: 250px;
            top: 30%;
            right: 30%;
            animation-delay: 2s;
        }
        
        @keyframes ripple-animation {
            0% {
                transform: scale(0.8);
                opacity: 0;
            }
            50% {
                opacity: 0.5;
            }
            100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }
        
        /* Ensure content is above background */
        .admin-sidebar, .flex-1 {
            position: relative;
            z-index: 1;
        }
        
        /* Mobile Responsive Improvements */
        @media (max-width: 1023px) {
            .admin-sidebar {
                position: fixed;
                left: 0;
                top: 0;
                height: 100vh;
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
                box-shadow: 2px 0 20px rgba(0, 0, 0, 0.5);
                z-index: 50;
            }
            
            .admin-sidebar.mobile-open {
                transform: translateX(0);
            }
            
            .mobile-sidebar-overlay {
                background-color: rgba(0, 0, 0, 0.5);
            }
            
            /* Adjust main content for mobile */
            .flex-1 {
                width: 100%;
                margin-left: 0 !important;
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
    </style>
</head>
<body class="glass-background">
    <!-- Mobile Menu Button -->
    <button id="adminMobileMenuBtn" class="lg:hidden fixed top-4 left-4 z-50 bg-red-600 text-white p-4 rounded-xl shadow-2xl hover:bg-red-700 transition-all duration-200 border-2 border-white">
        <i class="fas fa-bars text-xl"></i>
        <span class="sr-only">Toggle Menu</span>
    </button>

    <!-- Mobile Sidebar Overlay -->
    <div id="adminMobileOverlay" class="lg:hidden fixed inset-0 mobile-sidebar-overlay z-40 hidden"></div>

    <div class="flex h-screen overflow-hidden">
        
        <div class="admin-sidebar bg-gray-800 shadow-xl flex flex-col">
            <!-- Header Section -->
            <div class="p-6 flex-shrink-0">
                <div class="flex items-center space-x-3 mb-2">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center p-1 shadow-sm">
                        <img src="{{ asset('job-lynk-logo.png') }}" alt="JOB-lyNK Logo" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <div class="text-xl font-bold text-red-500">Admin Control</div>
                        <p class="text-xs text-gray-400">System Management</p>
                    </div>
                </div>
            </div>
            
            <!-- Navigation Section -->
            <div class="flex-1 px-6 overflow-y-auto">
                <nav class="space-y-4">
                    <a href="#" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition duration-200 sidebar-active" data-content="overview">
                        <i class="fas fa-tachometer-alt w-6"></i>
                        <span>System Overview</span>
                    </a>
                    <a href="#" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition duration-200" data-content="users">
                        <i class="fas fa-users w-6"></i>
                        <span>User Management</span>
                    </a>
                    <a href="#" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition duration-200" data-content="jobs">
                        <i class="fas fa-briefcase w-6"></i>
                        <span>Job Management</span>
                    </a>
                    <a href="#" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition duration-200" data-content="moderation">
                        <i class="fas fa-gavel w-6"></i>
                        <span>Content Moderation</span>
                    </a>
                    <a href="#" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition duration-200" data-content="analytics">
                        <i class="fas fa-chart-bar w-6"></i>
                        <span>Analytics</span>
                    </a>
                    <a href="#" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition duration-200" data-content="messages">
                        <i class="fas fa-comments w-6"></i>
                        <span>Messages</span>
                        <span id="admin-unread-badge" class="hidden ml-2 px-2 py-1 text-xs bg-red-500 text-white rounded-full">0</span>
                    </a>
                    <a href="#" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition duration-200" data-content="settings">
                        <i class="fas fa-cog w-6"></i>
                        <span>Settings & Tools</span>
                    </a>
                </nav>
            </div>
            
            <!-- Bottom Section - User Info & Logout -->
            <div class="sidebar-bottom p-6 flex-shrink-0 border-t border-gray-700">
                <!-- User Info with Dropdown -->
                <div class="mb-4 relative">
                    <button onclick="toggleAdminProfileDropdown()" class="w-full p-3 bg-gray-750 rounded-lg hover:bg-gray-700 transition-all duration-200 group">
                        <div class="flex items-center">
                            <div class="relative">
                                <div class="h-10 w-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-full flex items-center justify-center mr-3 ring-2 ring-blue-400 ring-offset-2 ring-offset-gray-800">
                                    <i class="fas fa-user-shield text-white text-lg"></i>
                                </div>
                                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-gray-800"></div>
                            </div>
                            <div class="flex-1 text-left">
                                <div class="text-sm text-gray-300 font-medium truncate">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-gray-500 flex items-center">
                                    <span class="admin-badge inline-block w-2 h-2 rounded-full mr-2"></span>
                                    Administrator
                                </div>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 text-xs group-hover:text-white transition"></i>
                        </div>
                    </button>
                    
                    <!-- Profile Dropdown Menu -->
                    <div id="adminProfileDropdown" class="hidden absolute bottom-full left-0 right-0 mb-2 bg-gray-800 rounded-lg shadow-2xl border border-gray-700 overflow-hidden z-50">
                        <!-- Profile Header -->
                        <div class="p-4 bg-gradient-to-br from-blue-600 to-indigo-600 text-white">
                            <div class="flex items-center mb-3">
                                <div class="h-12 w-12 bg-white/20 rounded-full flex items-center justify-center mr-3 backdrop-blur-sm">
                                    <i class="fas fa-user-shield text-white text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="font-semibold">{{ Auth::user()->name }}</div>
                                    <div class="text-xs opacity-90">{{ Auth::user()->email }}</div>
                                </div>
                            </div>
                            <div class="flex items-center text-xs">
                                <i class="fas fa-clock mr-2"></i>
                                Last login: {{ now()->format('M d, H:i') }}
                            </div>
                        </div>
                        
                        <!-- Menu Items -->
                        <div class="p-2">
                            <a href="#" onclick="openAdminProfileEdit(); return false;" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition">
                                <i class="fas fa-user-edit w-5 text-blue-400"></i>
                                <span class="text-sm">Edit My Profile</span>
                            </a>
                            
                            <a href="#" onclick="openAdminPasswordReset(); return false;" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition">
                                <i class="fas fa-key w-5 text-green-400"></i>
                                <span class="text-sm">Reset My Password</span>
                            </a>
                            
                            <div class="border-t border-gray-700 my-2"></div>
                            
                            <div class="px-3 py-2 text-xs text-gray-500 uppercase tracking-wider">Admin Tools</div>
                            
                            <a href="#" onclick="openUserRoleManager(); return false;" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition">
                                <i class="fas fa-users-cog w-5 text-purple-400"></i>
                                <span class="text-sm">Manage User Roles</span>
                            </a>
                            
                            <a href="#" onclick="openAccountSuspension(); return false;" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition">
                                <i class="fas fa-user-slash w-5 text-red-400"></i>
                                <span class="text-sm">Suspend/Deactivate Accounts</span>
                            </a>
                            
                            <a href="#" onclick="openSystemUserData(); return false;" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition">
                                <i class="fas fa-database w-5 text-yellow-400"></i>
                                <span class="text-sm">View System-Wide Data</span>
                            </a>
                            
                            <div class="border-t border-gray-700 my-2"></div>
                            
                            <a href="#" onclick="openActivityLog(); return false;" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition">
                                <i class="fas fa-history w-5 text-indigo-400"></i>
                                <span class="text-sm">My Activity Log</span>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="text-xs text-gray-500 px-3 mb-3">
                    <i class="fas fa-clock mr-1"></i>
                    Session: {{ now()->diffForHumans(now()->subMinutes(45)) }}
                </div>
                
                <!-- Logout Button -->
                <form method="POST" action="{{ route('admin.logout') }}" id="logoutForm" onsubmit="return confirmLogout(event)">
                    @csrf
                    <button type="submit" class="logout-btn w-full flex items-center space-x-3 p-3 rounded-lg text-red-400 hover:text-white hover:bg-red-600 transition-all duration-300 border border-gray-600 hover:border-red-500 group">
                        <i class="fas fa-sign-out-alt w-6 group-hover:animate-pulse"></i>
                        <span class="font-medium">Logout Securely</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 w-full lg:w-auto overflow-y-auto wave-container bg-gray-100">
            <!-- Animated Waves -->
            <div class="wave"></div>
            <div class="wave"></div>
            <div class="wave"></div>
            
            <!-- Top Bar -->
            <div class="sticky top-0 z-40 bg-white/95 backdrop-blur-lg border-b border-gray-200 shadow-sm">
                <div class="px-4 lg:px-8 py-4">
                    <div class="flex items-center justify-between gap-4">
                        <!-- Left Section: Search Bar -->
                        <div class="flex-1 max-w-xl">
                            <div class="relative">
                                <input 
                                    type="text" 
                                    id="adminGlobalSearch"
                                    placeholder="Search users, jobs, or content..." 
                                    class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                >
                                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <!-- Search Results Dropdown -->
                                <div id="adminSearchResults" class="hidden absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-2xl border border-gray-200 max-h-96 overflow-y-auto z-50">
                                    <div class="p-4 text-sm text-gray-500 text-center">
                                        Start typing to search...
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Section: Actions & Profile -->
                        <div class="flex items-center gap-3">
                            <!-- Quick Stats -->
                            <div class="hidden lg:flex items-center gap-4 px-4 py-2 bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl border border-blue-100">
                                <div class="text-center">
                                    <div class="text-xs text-gray-500">Active Users</div>
                                    <div class="text-sm font-bold text-blue-600">{{ $stats['active_users'] ?? 0 }}</div>
                                </div>
                                <div class="w-px h-8 bg-gray-300"></div>
                                <div class="text-center">
                                    <div class="text-xs text-gray-500">Active Jobs</div>
                                    <div class="text-sm font-bold text-green-600">{{ $stats['active_jobs'] ?? 0 }}</div>
                                </div>
                            </div>

                            <!-- Notifications -->
                            <div class="relative">
                                <button 
                                    onclick="toggleNotifications()"
                                    class="relative p-2.5 bg-gray-50 hover:bg-gray-100 rounded-xl transition-all group"
                                >
                                    <i class="fas fa-bell text-gray-600 group-hover:text-blue-600 transition-colors"></i>
                                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold animate-pulse">
                                        3
                                    </span>
                                </button>
                                
                                <!-- Notifications Dropdown -->
                                <div id="notificationsDropdown" class="hidden absolute top-full right-0 mt-2 w-80 bg-white rounded-xl shadow-2xl border border-gray-200 overflow-hidden z-50 top-bar-dropdown">
                                    <div class="p-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white">
                                        <div class="flex items-center justify-between">
                                            <h3 class="font-semibold">Notifications</h3>
                                            <span class="text-xs bg-white/20 px-2 py-1 rounded-full">3 new</span>
                                        </div>
                                    </div>
                                    <div class="max-h-96 overflow-y-auto">
                                        <div class="p-3 hover:bg-gray-50 border-b border-gray-100 cursor-pointer transition">
                                            <div class="flex items-start gap-3">
                                                <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                                                <div class="flex-1">
                                                    <p class="text-sm font-medium text-gray-800">New user registration</p>
                                                    <p class="text-xs text-gray-500 mt-1">John Doe registered as a worker</p>
                                                    <p class="text-xs text-gray-400 mt-1">2 minutes ago</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-3 hover:bg-gray-50 border-b border-gray-100 cursor-pointer transition">
                                            <div class="flex items-start gap-3">
                                                <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                                                <div class="flex-1">
                                                    <p class="text-sm font-medium text-gray-800">Job posted</p>
                                                    <p class="text-xs text-gray-500 mt-1">New plumbing job requires approval</p>
                                                    <p class="text-xs text-gray-400 mt-1">15 minutes ago</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-3 hover:bg-gray-50 border-b border-gray-100 cursor-pointer transition">
                                            <div class="flex items-start gap-3">
                                                <div class="w-2 h-2 bg-yellow-500 rounded-full mt-2"></div>
                                                <div class="flex-1">
                                                    <p class="text-sm font-medium text-gray-800">User report</p>
                                                    <p class="text-xs text-gray-500 mt-1">User W-4592 reported for spam</p>
                                                    <p class="text-xs text-gray-400 mt-1">1 hour ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-3 bg-gray-50 text-center">
                                        <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View all notifications</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="relative">
                                <button 
                                    onclick="toggleQuickActions()"
                                    class="p-2.5 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 rounded-xl transition-all group shadow-lg"
                                >
                                    <i class="fas fa-bolt text-white"></i>
                                </button>
                                
                                <!-- Quick Actions Dropdown -->
                                <div id="quickActionsDropdown" class="hidden absolute top-full right-0 mt-2 w-64 bg-white rounded-xl shadow-2xl border border-gray-200 overflow-hidden z-50 top-bar-dropdown">
                                    <div class="p-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white">
                                        <h3 class="font-semibold text-sm">Quick Actions</h3>
                                    </div>
                                    <div class="p-2">
                                        <button onclick="showContent('users'); toggleQuickActions();" class="w-full text-left px-3 py-2 hover:bg-gray-50 rounded-lg transition flex items-center gap-3">
                                            <i class="fas fa-users text-blue-600 w-5"></i>
                                            <span class="text-sm text-gray-700">Manage Users</span>
                                        </button>
                                        <button onclick="openJobManagementModal(); toggleQuickActions();" class="w-full text-left px-3 py-2 hover:bg-gray-50 rounded-lg transition flex items-center gap-3">
                                            <i class="fas fa-briefcase text-green-600 w-5"></i>
                                            <span class="text-sm text-gray-700">Manage Jobs</span>
                                        </button>
                                        <button onclick="openAnalyticsModal(); toggleQuickActions();" class="w-full text-left px-3 py-2 hover:bg-gray-50 rounded-lg transition flex items-center gap-3">
                                            <i class="fas fa-chart-bar text-purple-600 w-5"></i>
                                            <span class="text-sm text-gray-700">View Analytics</span>
                                        </button>
                                        <button onclick="openMessagesModal(); toggleQuickActions();" class="w-full text-left px-3 py-2 hover:bg-gray-50 rounded-lg transition flex items-center gap-3">
                                            <i class="fas fa-comments text-yellow-600 w-5"></i>
                                            <span class="text-sm text-gray-700">Messages</span>
                                        </button>
                                        <div class="border-t border-gray-200 my-2"></div>
                                        <button onclick="backupDatabase(); toggleQuickActions();" class="w-full text-left px-3 py-2 hover:bg-gray-50 rounded-lg transition flex items-center gap-3">
                                            <i class="fas fa-database text-indigo-600 w-5"></i>
                                            <span class="text-sm text-gray-700">Backup Database</span>
                                        </button>
                                        <button onclick="clearCache(); toggleQuickActions();" class="w-full text-left px-3 py-2 hover:bg-gray-50 rounded-lg transition flex items-center gap-3">
                                            <i class="fas fa-broom text-orange-600 w-5"></i>
                                            <span class="text-sm text-gray-700">Clear Cache</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Theme Switcher -->
                            <div class="relative">
                                <button 
                                    onclick="toggleThemeMenu()"
                                    class="p-2.5 bg-gray-50 hover:bg-gray-100 rounded-xl transition-all group"
                                    title="Change Theme"
                                >
                                    <i id="theme-icon" class="fas fa-sun text-gray-600 group-hover:text-yellow-500 transition-colors"></i>
                                </button>
                                
                                <!-- Theme Menu Dropdown -->
                                <div id="themeMenuDropdown" class="hidden absolute top-full right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-200 overflow-hidden z-50 top-bar-dropdown">
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

                            <!-- Admin Profile -->
                            <div class="relative">
                                <button 
                                    onclick="toggleTopBarProfile()"
                                    class="flex items-center gap-3 pl-3 pr-4 py-2 bg-gradient-to-r from-gray-50 to-gray-100 hover:from-gray-100 hover:to-gray-200 rounded-xl transition-all border border-gray-200 group"
                                >
                                    <div class="relative">
                                        <div class="w-9 h-9 bg-gradient-to-br from-blue-600 to-purple-600 rounded-lg flex items-center justify-center ring-2 ring-blue-200">
                                            <i class="fas fa-user-shield text-white text-sm"></i>
                                        </div>
                                        <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></div>
                                    </div>
                                    <div class="hidden lg:block text-left">
                                        <div class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</div>
                                        <div class="text-xs text-gray-500">Administrator</div>
                                    </div>
                                    <i class="fas fa-chevron-down text-gray-400 text-xs group-hover:text-gray-600 transition"></i>
                                </button>
                                
                                <!-- Profile Dropdown -->
                                <div id="topBarProfileDropdown" class="hidden absolute top-full right-0 mt-2 w-64 bg-white rounded-xl shadow-2xl border border-gray-200 overflow-hidden z-50 top-bar-dropdown">
                                    <div class="p-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-user-shield text-white text-lg"></i>
                                            </div>
                                            <div>
                                                <div class="font-semibold">{{ Auth::user()->name }}</div>
                                                <div class="text-xs text-blue-100">{{ Auth::user()->email }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-2">
                                        <a href="#" onclick="showContent('settings'); toggleTopBarProfile(); return false;" class="flex items-center gap-3 px-3 py-2 hover:bg-gray-50 rounded-lg transition">
                                            <i class="fas fa-cog text-gray-600 w-5"></i>
                                            <span class="text-sm text-gray-700">Settings</span>
                                        </a>
                                        <a href="#" onclick="openActivityLog(); toggleTopBarProfile(); return false;" class="flex items-center gap-3 px-3 py-2 hover:bg-gray-50 rounded-lg transition">
                                            <i class="fas fa-history text-gray-600 w-5"></i>
                                            <span class="text-sm text-gray-700">Activity Log</span>
                                        </a>
                                        <div class="border-t border-gray-200 my-2"></div>
                                        <form method="POST" action="{{ route('admin.logout') }}" class="m-0">
                                            @csrf
                                            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 hover:bg-red-50 rounded-lg transition text-left">
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
            
            <div class="p-4 lg:p-10 max-w-7xl mx-auto pt-6" style="position: relative; z-index: 2;">
            <div id="admin-content-container">

                <!-- Overview Content -->
                <div id="overview-content" class="content-section">
                    <!-- Logo Footer Background -->
                    <div style="position: fixed; bottom: 40px; right: 40px; opacity: 0.15; pointer-events: none; z-index: 1;">
                        <img src="{{ asset('job-lynk-logo.png') }}" alt="JOB-lyNK" style="width: 200px; height: auto; filter: grayscale(50%);">
                    </div>
                    
                    <h2 class="text-2xl font-bold text-gray-700 mb-6">System Overview & Key Metrics</h2>
                    
                    <!-- Animated Background -->
                    <div class="relative overflow-hidden rounded-2xl mb-10 bg-gray-100">
                        <!-- Animated gradient blobs -->
                        <div class="absolute inset-0 overflow-hidden">
                            <div class="absolute -top-1/2 -left-1/2 w-full h-full bg-gradient-to-br from-blue-400/20 to-transparent rounded-full blur-3xl animate-blob"></div>
                            <div class="absolute -bottom-1/2 -right-1/2 w-full h-full bg-gradient-to-tl from-purple-400/20 to-transparent rounded-full blur-3xl animate-blob animation-delay-2000"></div>
                            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full h-full bg-gradient-to-r from-pink-400/20 to-transparent rounded-full blur-3xl animate-blob animation-delay-4000"></div>
                        </div>
                        
                        <div class="relative p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                <!-- Total Users Card -->
                                <div class="glass-card group">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm text-blue-600 font-medium">Total Users</p>
                                            <p class="text-2xl font-bold text-blue-800">{{ number_format($stats['total_users']) }}</p>
                                        </div>
                                        <i class="fas fa-users text-blue-500 text-xl"></i>
                                    </div>
                                    <div class="mt-2 text-sm text-green-600">
                                        <i class="fas fa-arrow-up mr-1"></i>+{{ $stats['new_users_today'] }} today
                                    </div>
                                    <!-- Water reflection -->
                                    <div class="water-reflection">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm text-blue-600/50 font-medium">Total Users</p>
                                                <p class="text-2xl font-bold text-blue-800/50">{{ number_format($stats['total_users']) }}</p>
                                            </div>
                                            <i class="fas fa-users text-blue-500/50 text-xl"></i>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Active Jobs Card -->
                                <div class="glass-card group">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm text-green-600 font-medium">Active Jobs</p>
                                            <p class="text-2xl font-bold text-green-800">{{ number_format($stats['active_jobs']) }}</p>
                                        </div>
                                        <i class="fas fa-briefcase text-green-500 text-xl"></i>
                                    </div>
                                    <div class="mt-2 text-sm text-green-600">
                                        <i class="fas fa-arrow-up mr-1"></i>+{{ $stats['new_jobs_today'] }} today
                                    </div>
                                    <!-- Water reflection -->
                                    <div class="water-reflection">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm text-green-600/50 font-medium">Active Jobs</p>
                                                <p class="text-2xl font-bold text-green-800/50">{{ number_format($stats['active_jobs']) }}</p>
                                            </div>
                                            <i class="fas fa-briefcase text-green-500/50 text-xl"></i>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Pending Approvals Card -->
                                <div class="glass-card group">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm text-yellow-600 font-medium">Pending Approvals</p>
                                            <p class="text-2xl font-bold text-yellow-800">{{ number_format($stats['pending_jobs']) }}</p>
                                        </div>
                                        <i class="fas fa-clock text-yellow-500 text-xl"></i>
                                    </div>
                                    <div class="mt-2 text-sm text-yellow-600">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>Requires attention
                                    </div>
                                    <!-- Water reflection -->
                                    <div class="water-reflection">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm text-yellow-600/50 font-medium">Pending Approvals</p>
                                                <p class="text-2xl font-bold text-yellow-800/50">{{ number_format($stats['pending_jobs']) }}</p>
                                            </div>
                                            <i class="fas fa-clock text-yellow-500/50 text-xl"></i>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Urgent Jobs Card -->
                                <div class="glass-card group">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm text-red-600 font-medium">Urgent Jobs</p>
                                            <p class="text-2xl font-bold text-red-800">{{ number_format($stats['urgent_jobs']) }}</p>
                                        </div>
                                        <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                                    </div>
                                    <div class="mt-2 text-sm text-red-600">
                                        <i class="fas fa-fire mr-1"></i>High priority
                                    </div>
                                    <!-- Water reflection -->
                                    <div class="water-reflection">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm text-red-600/50 font-medium">Urgent Jobs</p>
                                                <p class="text-2xl font-bold text-red-800/50">{{ number_format($stats['urgent_jobs']) }}</p>
                                            </div>
                                            <i class="fas fa-exclamation-circle text-red-500/50 text-xl"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Messages Statistics -->
                    <div class="glass-card-large mb-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Admin Messages Overview</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="text-center">
                                <p class="text-2xl font-bold text-blue-600">{{ $messagingStats['total_messages'] ?? 0 }}</p>
                                <p class="text-sm text-gray-500">Total Messages</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold text-red-600">{{ $messagingStats['unread_admin_messages'] ?? 0 }}</p>
                                <p class="text-sm text-gray-500">Unread Messages</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold text-green-600">{{ $messagingStats['messages_today'] ?? 0 }}</p>
                                <p class="text-sm text-gray-500">Messages Today</p>
                            </div>
                        </div>
                        <div class="mt-4 text-center">
                            <button onclick="openMessagesModal()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                <i class="fas fa-comments mr-2"></i>Open Messages Modal
                            </button>
                        </div>
                    </div>
                    
                    <!-- Recent Activity -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="glass-card-large">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4">Recent User Registrations</h3>
                            <div class="space-y-3">
                                @forelse($recentUsers->take(5) as $user)
                                    <div class="flex items-center justify-between p-3 bg-white/30 rounded-lg backdrop-blur-sm">
                                        <div class="flex items-center">
                                            <img class="h-8 w-8 rounded-full cursor-pointer hover:ring-2 hover:ring-blue-500 transition-all duration-200" 
                                                 src="{{ $user->getProfilePictureUrl() }}" 
                                                 alt="{{ $user->name }}"
                                                 onclick="viewUserProfilePicture('{{ $user->getProfilePictureUrl() }}', '{{ $user->name }}', '{{ $user->role }}')"
                                                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=ffffff&background=1e40af&size=150'">
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                                <p class="text-xs text-gray-500">{{ ucfirst($user->role) }} • {{ $user->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        <span class="px-2 py-1 text-xs rounded-full {{ $user->role === 'worker' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </div>
                                @empty
                                    <p class="text-gray-500 text-center py-4">No recent registrations</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="glass-card-large">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4">Recent Job Postings</h3>
                            <div class="space-y-3">
                                @forelse($recentJobs->take(5) as $job)
                                    <div class="p-3 bg-white/30 rounded-lg backdrop-blur-sm">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-gray-900">{{ \Illuminate\Support\Str::limit($job->title, 40) }}</p>
                                                <p class="text-xs text-gray-500">by {{ $job->employer->name }} • {{ $job->created_at->diffForHumans() }}</p>
                                                <p class="text-xs text-gray-600 mt-1">{{ $job->location }}</p>
                                            </div>
                                            <div class="text-right">
                                                <span class="px-2 py-1 text-xs rounded-full {{ $job->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ ucfirst($job->status) }}
                                                </span>
                                                <p class="text-xs text-gray-500 mt-1">UGX {{ number_format($job->budget) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-500 text-center py-4">No recent job postings</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Management Content -->
                <div id="users-content" class="content-section hidden ripple-container" style="position: relative;">
                    <!-- Ripple Effects -->
                    <div class="ripple"></div>
                    <div class="ripple"></div>
                    <div class="ripple"></div>
                    <div class="ripple"></div>
                    
                    <!-- Logo Footer Background -->
                    <div style="position: fixed; bottom: 40px; right: 40px; opacity: 0.15; pointer-events: none; z-index: 1;">
                        <img src="{{ asset('job-lynk-logo.png') }}" alt="JOB-lyNK" style="width: 200px; height: auto; filter: grayscale(50%);">
                    </div>
                    
                    <div style="position: relative; z-index: 2;">
                        <h2 class="text-2xl font-bold text-gray-700 mb-6">User Management</h2>
                        
                        <!-- User Statistics Cards -->
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                            <div class="glass-card">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-blue-600 font-medium">Total Workers</p>
                                        <p class="text-2xl font-bold text-blue-800">{{ number_format($stats['total_workers']) }}</p>
                                    </div>
                                    <i class="fas fa-user text-blue-500 text-xl"></i>
                                </div>
                            </div>
                            
                            <div class="glass-card">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-green-600 font-medium">Total Employers</p>
                                        <p class="text-2xl font-bold text-green-800">{{ number_format($stats['total_employers']) }}</p>
                                    </div>
                                    <i class="fas fa-building text-green-500 text-xl"></i>
                                </div>
                            </div>
                            
                            <div class="glass-card">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-red-600 font-medium">Suspended Users</p>
                                        <p class="text-2xl font-bold text-red-800">{{ number_format($stats['suspended_users']) }}</p>
                                    </div>
                                    <i class="fas fa-user-slash text-red-500 text-xl"></i>
                                </div>
                            </div>
                            
                            <div class="glass-card">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-purple-600 font-medium">New Today</p>
                                        <p class="text-2xl font-bold text-purple-800">{{ number_format($stats['new_users_today']) }}</p>
                                    </div>
                                    <i class="fas fa-user-plus text-purple-500 text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <!-- User Management Tools -->
                        <div class="glass-card-large mb-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xl font-semibold text-gray-800">User Management Tools</h3>
                                <div class="flex space-x-2">
                                    <button onclick="bulkUserAction()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                        <i class="fas fa-tasks mr-2"></i>Bulk Actions
                                    </button>
                                    <button onclick="exportUsers()" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                                        <i class="fas fa-download mr-2"></i>Export
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Advanced Filters -->
                            <div class="p-4 bg-white/30 rounded-lg backdrop-blur-sm mb-4">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Search Users</label>
                                        <input type="text" id="user-search" placeholder="Name, email, phone..." 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                                        <select id="user-role-filter" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">All Roles</option>
                                            <option value="worker">Workers</option>
                                            <option value="employer">Employers</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                        <select id="user-status-filter" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">All Status</option>
                                            <option value="active">Active</option>
                                            <option value="suspended">Suspended</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Actions</label>
                                        <button onclick="applyUserFilters()" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                            <i class="fas fa-filter mr-2"></i>Apply Filters
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Users Table -->
                            <div class="overflow-x-auto bg-white/50 rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50/80">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                <input type="checkbox" id="select-all-users" class="rounded border-gray-300">
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activity</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="users-table-body" class="bg-white/70 divide-y divide-gray-200">
                                        @foreach($recentUsers->take(10) as $user)
                                            <tr class="hover:bg-white/90 transition">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <input type="checkbox" class="user-checkbox rounded border-gray-300" value="{{ $user->id }}">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <img class="h-8 w-8 rounded-full" src="{{ $user->getProfilePictureUrl() }}" alt="{{ $user->name }}">
                                                        <div class="ml-3">
                                                            <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                                            <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 py-1 text-xs rounded-full {{ $user->role === 'worker' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                                        {{ ucfirst($user->role) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $user->created_at->format('M d, Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                                        Active
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $user->created_at->diffForHumans() }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    <button onclick="viewUserDetails({{ $user->id }})" class="text-blue-600 hover:text-blue-800 mr-2">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button onclick="suspendUser({{ $user->id }})" class="text-red-600 hover:text-red-800">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Job Management Content -->
                <div id="jobs-content" class="content-section hidden ripple-container" style="position: relative; min-height: 100vh;">
                    <!-- Ripple Effects -->
                    <div class="ripple"></div>
                    <div class="ripple"></div>
                    <div class="ripple"></div>
                    <div class="ripple"></div>
                    
                    <!-- Logo Footer Background -->
                    <div style="position: fixed; bottom: 40px; right: 40px; opacity: 0.15; pointer-events: none; z-index: 1;">
                        <img src="{{ asset('job-lynk-logo.png') }}" alt="JOB-lyNK" style="width: 200px; height: auto; filter: grayscale(50%);">
                    </div>
                    
                    <div style="position: relative; z-index: 2;">
                        <h2 class="text-2xl font-bold text-gray-700 mb-6">Job Management</h2>
                        
                        <!-- Job Statistics Cards -->
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                            <div class="glass-card">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-blue-600 font-medium">Total Jobs</p>
                                        <p class="text-2xl font-bold text-blue-800">{{ number_format($stats['total_jobs']) }}</p>
                                    </div>
                                    <i class="fas fa-briefcase text-blue-500 text-xl"></i>
                                </div>
                            </div>
                            
                            <div class="glass-card">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-green-600 font-medium">Active Jobs</p>
                                        <p class="text-2xl font-bold text-green-800">{{ number_format($stats['active_jobs']) }}</p>
                                    </div>
                                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                                </div>
                            </div>
                            
                            <div class="glass-card">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-yellow-600 font-medium">Pending Approval</p>
                                        <p class="text-2xl font-bold text-yellow-800">{{ number_format($stats['pending_jobs']) }}</p>
                                    </div>
                                    <i class="fas fa-clock text-yellow-500 text-xl"></i>
                                </div>
                            </div>
                            
                            <div class="glass-card">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-purple-600 font-medium">Posted Today</p>
                                        <p class="text-2xl font-bold text-purple-800">{{ number_format($stats['new_jobs_today']) }}</p>
                                    </div>
                                    <i class="fas fa-plus-circle text-purple-500 text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Jobs Pending Approval -->
                        @if($pendingJobs->count() > 0)
                            <div class="glass-card-large mb-6">
                                <h3 class="text-xl font-semibold text-gray-800 mb-4">Jobs Pending Approval</h3>
                                <div class="overflow-x-auto bg-white/50 rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50/80">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job Title</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employer</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Budget</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posted</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white/70 divide-y divide-gray-200">
                                            @foreach($pendingJobs as $job)
                                                <tr class="hover:bg-white/90 transition">
                                                    <td class="px-6 py-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $job->title }}</div>
                                                        <div class="text-sm text-gray-500">{{ \Illuminate\Support\Str::limit($job->description, 60) }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        {{ $job->employer->name }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        UGX {{ number_format($job->budget) }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $job->created_at->diffForHumans() }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                        <button onclick="approveJob({{ $job->id }})" class="text-green-600 hover:text-green-900 mr-3">
                                                            <i class="fas fa-check mr-1"></i>Approve
                                                        </button>
                                                        <button onclick="rejectJob({{ $job->id }})" class="text-red-600 hover:text-red-900">
                                                            <i class="fas fa-times mr-1"></i>Reject
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        <!-- Recent Job Postings -->
                        <div class="glass-card-large">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4">Recent Job Postings</h3>
                            <div class="overflow-x-auto bg-white/50 rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50/80">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employer</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applications</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white/70 divide-y divide-gray-200">
                                        @foreach($recentJobs->take(10) as $job)
                                            <tr class="hover:bg-white/90 transition">
                                                <td class="px-6 py-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $job->title }}</div>
                                                    <div class="text-sm text-gray-500">{{ $job->location }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $job->employer->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $job->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                        {{ ucfirst($job->status) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $job->applications_count }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <button onclick="viewJobDetails({{ $job->id }})" class="text-blue-600 hover:text-blue-900 font-medium">
                                                        <i class="fas fa-eye mr-1"></i>View
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Analytics Content -->
                <div id="analytics-content" class="content-section hidden ripple-container" style="position: relative;">
                    <!-- Ripple Effects -->
                    <div class="ripple"></div>
                    <div class="ripple"></div>
                    <div class="ripple"></div>
                    <div class="ripple"></div>
                    
                    <!-- Logo Footer Background -->
                    <div style="position: fixed; bottom: 40px; right: 40px; opacity: 0.15; pointer-events: none; z-index: 1;">
                        <img src="{{ asset('job-lynk-logo.png') }}" alt="JOB-lyNK" style="width: 200px; height: auto; filter: grayscale(50%);">
                    </div>
                    
                    <div style="position: relative; z-index: 2;">
                        <h2 class="text-2xl font-bold text-gray-700 mb-6">Analytics & Reports</h2>
                        
                        <!-- Key Metrics Cards -->
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                            <div class="glass-card">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-green-600 font-medium">Growth Rate</p>
                                        <p class="text-2xl font-bold text-green-800">+12.5%</p>
                                    </div>
                                    <i class="fas fa-chart-line text-green-500 text-xl"></i>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">vs last month</p>
                            </div>
                            
                            <div class="glass-card">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-blue-600 font-medium">Success Rate</p>
                                        <p class="text-2xl font-bold text-blue-800">68.3%</p>
                                    </div>
                                    <i class="fas fa-bullseye text-blue-500 text-xl"></i>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">job completion rate</p>
                            </div>
                            
                            <div class="glass-card">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-purple-600 font-medium">Avg. Response</p>
                                        <p class="text-2xl font-bold text-purple-800">2.4h</p>
                                    </div>
                                    <i class="fas fa-clock text-purple-500 text-xl"></i>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">application response time</p>
                            </div>
                            
                            <div class="glass-card">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-yellow-600 font-medium">Revenue</p>
                                        <p class="text-2xl font-bold text-yellow-800">UGX 2.4M</p>
                                    </div>
                                    <i class="fas fa-money-bill-wave text-yellow-500 text-xl"></i>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">this month</p>
                            </div>
                        </div>

                        <!-- Analytics Dashboard Header -->
                        <div class="glass-card-large mb-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Analytics Dashboard</h3>
                                    <p class="text-sm text-gray-600">Real-time insights and performance metrics</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-blue-800" id="current-date"></div>
                                    <div class="text-sm text-gray-600" id="current-time"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Main Charts Grid -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                            <!-- User Growth Chart -->
                            <div class="glass-card-large">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-800">User Growth Trends</h3>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm text-gray-500">Growth Rate:</span>
                                        <span class="text-sm font-bold text-green-600" id="user-growth-rate">+0%</span>
                                    </div>
                                </div>
                                <div class="relative h-80 bg-white/50 rounded-lg p-4">
                                    <canvas id="userGrowthPieChartStatic"></canvas>
                                </div>
                                <div class="mt-4 p-3 bg-blue-100/50 rounded-lg backdrop-blur-sm">
                                    <div class="text-sm text-blue-800 font-medium" id="user-growth-annotation">
                                        Loading insights...
                                    </div>
                                </div>
                            </div>

                            <!-- Job Posting Chart -->
                            <div class="glass-card-large">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-800">Job Posting Trends</h3>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm text-gray-500">Success Rate:</span>
                                        <span class="text-sm font-bold text-green-600" id="job-success-rate">0%</span>
                                    </div>
                                </div>
                                <div class="relative h-80 bg-white/50 rounded-lg p-4">
                                    <canvas id="jobTrendsDonutChartStatic"></canvas>
                                </div>
                                <div class="mt-4 p-3 bg-green-100/50 rounded-lg backdrop-blur-sm">
                                    <div class="text-sm text-green-800 font-medium" id="job-trends-annotation">
                                        Loading insights...
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Performance Metrics -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                            <!-- Monthly Performance -->
                            <div class="glass-card-large">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Monthly Performance</h3>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Best Month (Users)</span>
                                        <span class="text-sm font-bold text-blue-600" id="best-user-month">-</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Best Month (Jobs)</span>
                                        <span class="text-sm font-bold text-green-600" id="best-job-month">-</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Best Month (Revenue)</span>
                                        <span class="text-sm font-bold text-yellow-600" id="best-revenue-month">-</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Activity Insights -->
                            <div class="glass-card-large">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Activity Insights</h3>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Peak Activity Day</span>
                                        <span class="text-sm font-bold text-purple-600" id="peak-activity-day">-</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Avg. Daily Registrations</span>
                                        <span class="text-sm font-bold text-blue-600" id="avg-daily-registrations">0</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Conversion Rate</span>
                                        <span class="text-sm font-bold text-green-600" id="conversion-rate">0%</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="glass-card-large">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                                <div class="space-y-3">
                                    <button onclick="generateMonthlyReport()" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                        <i class="fas fa-file-alt mr-2"></i>Generate Report
                                    </button>
                                    <button onclick="exportAnalyticsData()" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                                        <i class="fas fa-download mr-2"></i>Export Data
                                    </button>
                                    <button onclick="refreshAnalytics()" class="w-full bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                                        <i class="fas fa-sync-alt mr-2"></i>Refresh
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="moderation-content" class="content-section hidden">
                    <!-- Logo Footer Background -->
                    <div style="position: fixed; bottom: 40px; right: 40px; opacity: 0.15; pointer-events: none; z-index: 1;">
                        <img src="{{ asset('job-lynk-logo.png') }}" alt="JOB-lyNK" style="width: 200px; height: auto; filter: grayscale(50%);">
                    </div>
                    
                    <!-- Modern Header with Gradient -->
                    <div class="bg-gradient-to-r from-purple-600 via-purple-700 to-indigo-700 rounded-2xl shadow-2xl p-8 mb-8 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-3xl font-bold mb-2 flex items-center">
                                    <i class="fas fa-shield-alt mr-3"></i>
                                    Content Moderation & Control
                                </h2>
                                <p class="text-purple-100">Monitor and manage platform content quality</p>
                            </div>
                            <div class="hidden md:block">
                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4">
                                    <div class="text-center">
                                        <div class="text-3xl font-bold">23</div>
                                        <div class="text-sm text-purple-100">Pending Reviews</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Stats Overview Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-4 text-white transform hover:scale-105 transition-all">
                            <div class="flex items-center justify-between mb-2">
                                <div class="bg-white/20 rounded-lg p-2">
                                    <i class="fas fa-check-circle text-lg"></i>
                                </div>
                                <i class="fas fa-arrow-up text-sm opacity-50"></i>
                            </div>
                            <h3 class="text-2xl font-bold mb-1">18</h3>
                            <p class="text-blue-100 text-xs">Pending Verifications</p>
                        </div>
                        
                        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-lg p-4 text-white transform hover:scale-105 transition-all">
                            <div class="flex items-center justify-between mb-2">
                                <div class="bg-white/20 rounded-lg p-2">
                                    <i class="fas fa-exclamation-triangle text-lg"></i>
                                </div>
                                <i class="fas fa-arrow-down text-sm opacity-50"></i>
                            </div>
                            <h3 class="text-2xl font-bold mb-1">3</h3>
                            <p class="text-red-100 text-xs">Reported Users</p>
                        </div>
                        
                        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg shadow-lg p-4 text-white transform hover:scale-105 transition-all">
                            <div class="flex items-center justify-between mb-2">
                                <div class="bg-white/20 rounded-lg p-2">
                                    <i class="fas fa-flag text-lg"></i>
                                </div>
                                <i class="fas fa-minus text-sm opacity-50"></i>
                            </div>
                            <h3 class="text-2xl font-bold mb-1">5</h3>
                            <p class="text-yellow-100 text-xs">Flagged Content</p>
                        </div>
                        
                        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-4 text-white transform hover:scale-105 transition-all">
                            <div class="flex items-center justify-between mb-2">
                                <div class="bg-white/20 rounded-lg p-2">
                                    <i class="fas fa-chart-line text-lg"></i>
                                </div>
                                <i class="fas fa-arrow-up text-sm opacity-50"></i>
                            </div>
                            <h3 class="text-2xl font-bold mb-1">94%</h3>
                            <p class="text-green-100 text-xs">Approval Rate</p>
                        </div>
                    </div>
                    
                    <!-- Pending Business Verifications -->
                    <div class="bg-gradient-to-br from-white to-blue-50 p-8 rounded-2xl shadow-xl mb-8 border border-blue-100">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-4 mr-4">
                                    <i class="fas fa-building text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-800">Pending Business Verifications</h3>
                                    <p class="text-gray-600">18 businesses awaiting verification</p>
                                </div>
                            </div>
                            <button class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                                <i class="fas fa-check-double mr-2"></i>Bulk Approve
                            </button>
                        </div>
                        
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-gray-50 to-blue-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                            <input type="checkbox" class="w-4 h-4 text-blue-600 rounded">
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Business Name</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Submitted Date</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    <tr class="hover:bg-blue-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="checkbox" class="w-4 h-4 text-blue-600 rounded">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="bg-blue-100 rounded-lg p-2 mr-3">
                                                    <i class="fas fa-building text-blue-600"></i>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-bold text-gray-900">KCCA Cleaning Services</div>
                                                    <div class="text-xs text-gray-500">Registration: BN-2024-1234</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            <div class="flex items-center">
                                                <i class="far fa-calendar text-gray-400 mr-2"></i>
                                                Oct 23, 2025
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Pending</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                            <button class="bg-blue-100 text-blue-700 px-4 py-2 rounded-lg hover:bg-blue-200 transition font-semibold">
                                                <i class="fas fa-eye mr-1"></i>Review
                                            </button>
                                            <button class="bg-green-100 text-green-700 px-4 py-2 rounded-lg hover:bg-green-200 transition font-semibold">
                                                <i class="fas fa-check mr-1"></i>Approve
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-blue-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="checkbox" class="w-4 h-4 text-blue-600 rounded">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="bg-green-100 rounded-lg p-2 mr-3">
                                                    <i class="fas fa-truck text-green-600"></i>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-bold text-gray-900">Nile Logistics Ltd.</div>
                                                    <div class="text-xs text-gray-500">Registration: BN-2024-5678</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            <div class="flex items-center">
                                                <i class="far fa-calendar text-gray-400 mr-2"></i>
                                                Oct 22, 2025
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Pending</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                            <button class="bg-blue-100 text-blue-700 px-4 py-2 rounded-lg hover:bg-blue-200 transition font-semibold">
                                                <i class="fas fa-eye mr-1"></i>Review
                                            </button>
                                            <button class="bg-green-100 text-green-700 px-4 py-2 rounded-lg hover:bg-green-200 transition font-semibold">
                                                <i class="fas fa-check mr-1"></i>Approve
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Reported Users -->
                    <div class="bg-gradient-to-br from-white to-red-50 p-8 rounded-2xl shadow-xl border border-red-100">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-4 mr-4">
                                    <i class="fas fa-user-slash text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-800">Reported Users</h3>
                                    <p class="text-gray-600">Review users reported for policy violations</p>
                                </div>
                            </div>
                            <select class="bg-white border-2 border-gray-200 rounded-xl px-4 py-2 text-sm font-semibold focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                <option>All Reports</option>
                                <option>High Priority</option>
                                <option>Medium Priority</option>
                                <option>Low Priority</option>
                            </select>
                        </div>
                        
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-gray-50 to-red-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">User Info</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Role</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Reports</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Reason</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    <tr class="hover:bg-red-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <img src="https://ui-avatars.com/api/?name=User&background=ef4444&color=fff" class="w-10 h-10 rounded-full mr-3 ring-2 ring-red-200">
                                                <div>
                                                    <div class="text-sm font-bold text-gray-900">W-4592</div>
                                                    <div class="text-xs text-gray-500">Joined: Jan 2025</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">Worker</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">5 Reports</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-700">Unprofessional behavior</div>
                                            <div class="text-xs text-gray-500">No-show to jobs</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                            <button class="bg-blue-100 text-blue-700 px-4 py-2 rounded-lg hover:bg-blue-200 transition font-semibold">
                                                <i class="fas fa-eye mr-1"></i>View
                                            </button>
                                            <button class="bg-orange-100 text-orange-700 px-4 py-2 rounded-lg hover:bg-orange-200 transition font-semibold">
                                                <i class="fas fa-pause mr-1"></i>Suspend
                                            </button>
                                            <button class="bg-red-100 text-red-700 px-4 py-2 rounded-lg hover:bg-red-200 transition font-semibold">
                                                <i class="fas fa-ban mr-1"></i>Ban
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="content-content" class="content-section hidden">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">W-4592</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">Worker</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">5</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <button class="text-red-600 hover:text-red-800 font-medium">Suspend</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="content-content" class="content-section hidden">
                    <h2 class="text-2xl font-bold text-gray-700 mb-6">Content Review & Job Approval</h2>
                    
                    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">New Jobs Awaiting Approval (5)</h3>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job Title</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employer</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Posted</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Review</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Need 2 Plumbers for 3-Day Job</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">SiteWorks Int.</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">Oct 23, 2025</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <button class="text-green-600 hover:text-green-800 font-medium mr-3">Approve</button>
                                        <button class="text-red-600 hover:text-red-800 font-medium">Reject</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Casual House Maid (Daily Pay)</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">Private User E-009</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">Oct 23, 2025</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <button class="text-green-600 hover:text-green-800 font-medium mr-3">Approve</button>
                                        <button class="text-red-600 hover:text-red-800 font-medium">Reject</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="settings-content" class="content-section hidden">
                    <!-- Modern Header with Gradient -->
                    <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 rounded-2xl shadow-2xl p-8 mb-8 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-3xl font-bold mb-2 flex items-center">
                                    <i class="fas fa-cogs mr-3"></i>
                                    System Settings & Admin Tools
                                </h2>
                                <p class="text-blue-100">Configure and manage your platform settings</p>
                            </div>
                            <div class="hidden md:block">
                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4">
                                    <div class="text-center">
                                        <div class="text-3xl font-bold">98%</div>
                                        <div class="text-sm text-blue-100">System Health</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Actions Panel -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                        <button onclick="showSettingsTab('platform')" class="bg-gradient-to-br from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                            <div class="flex items-center justify-between mb-3">
                                <i class="fas fa-sliders-h text-3xl"></i>
                                <i class="fas fa-arrow-right text-xl opacity-50"></i>
                            </div>
                            <h3 class="font-bold text-lg">Platform</h3>
                            <p class="text-sm text-blue-100">General settings</p>
                        </button>
                        
                        <button onclick="showSettingsTab('users')" class="bg-gradient-to-br from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                            <div class="flex items-center justify-between mb-3">
                                <i class="fas fa-users-cog text-3xl"></i>
                                <i class="fas fa-arrow-right text-xl opacity-50"></i>
                            </div>
                            <h3 class="font-bold text-lg">Users</h3>
                            <p class="text-sm text-purple-100">User controls</p>
                        </button>
                        
                        <button onclick="showSettingsTab('security')" class="bg-gradient-to-br from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                            <div class="flex items-center justify-between mb-3">
                                <i class="fas fa-shield-alt text-3xl"></i>
                                <i class="fas fa-arrow-right text-xl opacity-50"></i>
                            </div>
                            <h3 class="font-bold text-lg">Security</h3>
                            <p class="text-sm text-red-100">Protection settings</p>
                        </button>
                        
                        <button onclick="showSettingsTab('system')" class="bg-gradient-to-br from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                            <div class="flex items-center justify-between mb-3">
                                <i class="fas fa-server text-3xl"></i>
                                <i class="fas fa-arrow-right text-xl opacity-50"></i>
                            </div>
                            <h3 class="font-bold text-lg">System</h3>
                            <p class="text-sm text-green-100">Advanced tools</p>
                        </button>
                    </div>
                    
                    <!-- Settings Navigation Tabs -->
                    <div class="bg-white rounded-2xl shadow-lg mb-6 overflow-hidden border border-gray-100">
                        <div class="flex overflow-x-auto border-b border-gray-200 bg-gray-50">
                            <button onclick="showSettingsTab('platform')" class="settings-tab px-6 py-4 text-sm font-semibold text-gray-700 hover:text-blue-600 hover:bg-white border-b-3 border-transparent hover:border-blue-600 transition whitespace-nowrap active-settings-tab flex items-center space-x-2">
                                <i class="fas fa-cog"></i>
                                <span>Platform</span>
                            </button>
                            <button onclick="showSettingsTab('users')" class="settings-tab px-6 py-4 text-sm font-semibold text-gray-700 hover:text-blue-600 hover:bg-white border-b-3 border-transparent hover:border-blue-600 transition whitespace-nowrap flex items-center space-x-2">
                                <i class="fas fa-users-cog"></i>
                                <span>Users</span>
                            </button>
                            <button onclick="showSettingsTab('jobs')" class="settings-tab px-6 py-4 text-sm font-semibold text-gray-700 hover:text-blue-600 hover:bg-white border-b-3 border-transparent hover:border-blue-600 transition whitespace-nowrap flex items-center space-x-2">
                                <i class="fas fa-briefcase"></i>
                                <span>Jobs</span>
                            </button>
                            <button onclick="showSettingsTab('payments')" class="settings-tab px-6 py-4 text-sm font-semibold text-gray-700 hover:text-blue-600 hover:bg-white border-b-3 border-transparent hover:border-blue-600 transition whitespace-nowrap flex items-center space-x-2">
                                <i class="fas fa-money-bill-wave"></i>
                                <span>Payments</span>
                            </button>
                            <button onclick="showSettingsTab('notifications')" class="settings-tab px-6 py-4 text-sm font-semibold text-gray-700 hover:text-blue-600 hover:bg-white border-b-3 border-transparent hover:border-blue-600 transition whitespace-nowrap flex items-center space-x-2">
                                <i class="fas fa-bell"></i>
                                <span>Notifications</span>
                            </button>
                            <button onclick="showSettingsTab('security')" class="settings-tab px-6 py-4 text-sm font-semibold text-gray-700 hover:text-blue-600 hover:bg-white border-b-3 border-transparent hover:border-blue-600 transition whitespace-nowrap flex items-center space-x-2">
                                <i class="fas fa-shield-alt"></i>
                                <span>Security</span>
                            </button>
                            <button onclick="showSettingsTab('system')" class="settings-tab px-6 py-4 text-sm font-semibold text-gray-700 hover:text-blue-600 hover:bg-white border-b-3 border-transparent hover:border-blue-600 transition whitespace-nowrap flex items-center space-x-2">
                                <i class="fas fa-server"></i>
                                <span>System</span>
                            </button>
                        </div>
                    </div>

                    <!-- Platform Settings Tab -->
                    <div id="platform-settings-tab" class="settings-tab-content">
                        <!-- General Platform Settings -->
                        <div class="bg-gradient-to-br from-white to-blue-50 p-8 rounded-2xl shadow-xl mb-6 border border-blue-100">
                            <div class="flex items-center mb-6">
                                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-4 mr-4">
                                    <i class="fas fa-sliders-h text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-800">General Platform Settings</h3>
                                    <p class="text-gray-600">Configure core platform information</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-tag text-blue-500 mr-2"></i>
                                        Platform Name
                                    </label>
                                    <input type="text" value="JOB-lyNK" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                </div>
                                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-envelope text-blue-500 mr-2"></i>
                                        Support Email
                                    </label>
                                    <input type="email" value="support@joblynk.com" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                </div>
                                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-phone text-blue-500 mr-2"></i>
                                        Contact Phone
                                    </label>
                                    <input type="tel" value="+256 XXX XXX XXX" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                </div>
                                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-language text-blue-500 mr-2"></i>
                                        Default Language
                                    </label>
                                    <select class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                        <option>English</option>
                                        <option>Luganda</option>
                                        <option>Swahili</option>
                                    </select>
                                </div>
                                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-clock text-blue-500 mr-2"></i>
                                        Timezone
                                    </label>
                                    <select class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                        <option>Africa/Kampala (EAT)</option>
                                        <option>UTC</option>
                                    </select>
                                </div>
                                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-dollar-sign text-blue-500 mr-2"></i>
                                        Currency
                                    </label>
                                    <select class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                        <option>UGX - Ugandan Shilling</option>
                                        <option>USD - US Dollar</option>
                                    </select>
                                </div>
                            </div>
                            <button class="mt-6 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-8 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                                <i class="fas fa-save mr-2"></i>Save Platform Settings
                            </button>
                        </div>

                        <!-- Feature Toggles -->
                        <div class="bg-gradient-to-br from-white to-green-50 p-8 rounded-2xl shadow-xl mb-6 border border-green-100">
                            <div class="flex items-center mb-6">
                                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-4 mr-4">
                                    <i class="fas fa-toggle-on text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-800">Feature Toggles</h3>
                                    <p class="text-gray-600">Enable or disable platform features</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex items-center justify-between p-5 bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition">
                                    <div class="flex items-center">
                                        <div class="bg-blue-100 rounded-lg p-3 mr-4">
                                            <i class="fas fa-user-plus text-blue-600 text-xl"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-800">User Registration</h4>
                                            <p class="text-sm text-gray-600">Allow new users to register</p>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" checked class="sr-only peer">
                                        <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-gradient-to-r peer-checked:from-blue-500 peer-checked:to-blue-600"></div>
                                    </label>
                                </div>
                                <div class="flex items-center justify-between p-5 bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition">
                                    <div class="flex items-center">
                                        <div class="bg-green-100 rounded-lg p-3 mr-4">
                                            <i class="fas fa-briefcase text-green-600 text-xl"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-800">Job Posting</h4>
                                            <p class="text-sm text-gray-600">Allow employers to post jobs</p>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" checked class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Job Applications</h4>
                                        <p class="text-sm text-gray-600">Allow workers to apply for jobs</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" checked class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Messaging System</h4>
                                        <p class="text-sm text-gray-600">Enable direct messaging between users</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" checked class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Social Login</h4>
                                        <p class="text-sm text-gray-600">Allow login via Google, Facebook, etc.</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" checked class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">AI Matching</h4>
                                        <p class="text-sm text-gray-600">Enable AI-powered job matching</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" checked class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Controls Tab -->
                    <div id="users-settings-tab" class="settings-tab-content hidden">
                        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-user-shield text-purple-600 mr-3"></i>
                                User Registration & Verification
                            </h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Email Verification Required</h4>
                                        <p class="text-sm text-gray-600">Users must verify email before accessing platform</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" checked class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Phone Verification Required</h4>
                                        <p class="text-sm text-gray-600">Users must verify phone number</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Profile Completion Required</h4>
                                        <p class="text-sm text-gray-600">Users must complete profile before full access</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" checked class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-ban text-red-600 mr-3"></i>
                                Account Restrictions
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Max Failed Login Attempts</label>
                                    <input type="number" value="5" min="3" max="10" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    <p class="text-xs text-gray-500 mt-1">Account locked after this many failed attempts</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Account Lockout Duration (minutes)</label>
                                    <input type="number" value="30" min="5" max="1440" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Inactive Account Days</label>
                                    <input type="number" value="90" min="30" max="365" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    <p class="text-xs text-gray-500 mt-1">Mark accounts inactive after this period</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Auto-Delete Inactive Accounts (days)</label>
                                    <input type="number" value="365" min="180" max="730" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                            <button class="mt-6 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                                <i class="fas fa-save mr-2"></i>Save User Controls
                            </button>
                        </div>
                    </div>

                    <!-- Job Controls Tab -->
                    <div id="jobs-settings-tab" class="settings-tab-content hidden">
                        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-clipboard-check text-green-600 mr-3"></i>
                                Job Posting Controls
                            </h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Job Approval Required</h4>
                                        <p class="text-sm text-gray-600">Admin must approve jobs before they go live</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Max Applications Per Job</label>
                                        <input type="number" value="50" min="10" max="500" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Job Auto-Close Days</label>
                                        <input type="number" value="30" min="7" max="90" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                        <p class="text-xs text-gray-500 mt-1">Auto-close jobs after this many days</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Min Job Budget (UGX)</label>
                                        <input type="number" value="10000" min="1000" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Max Job Budget (UGX)</label>
                                        <input type="number" value="10000000" min="100000" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    </div>
                                </div>
                            </div>
                            <button class="mt-6 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                                <i class="fas fa-save mr-2"></i>Save Job Controls
                            </button>
                        </div>
                    </div>

                    <!-- Payments & Fees Tab -->
                    <div id="payments-settings-tab" class="settings-tab-content hidden">
                        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-percentage text-yellow-600 mr-3"></i>
                                Platform Fee Structure
                            </h3>
                            <p class="text-sm text-gray-600 mb-4">Adjust the commission rates for employers and workers.</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="employer-fee" class="block text-sm font-medium text-gray-700 mb-2">Employer Service Fee (%)</label>
                                    <input id="employer-fee" type="number" value="10" min="0" max="100" step="0.5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    <p class="text-xs text-gray-500 mt-1">Fee charged to employers per job completion</p>
                                </div>
                                <div>
                                    <label for="worker-fee" class="block text-sm font-medium text-gray-700 mb-2">Worker Commission Fee (%)</label>
                                    <input id="worker-fee" type="number" value="5" min="0" max="100" step="0.5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    <p class="text-xs text-gray-500 mt-1">Fee charged to workers per job completion</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Featured Job Fee (UGX)</label>
                                    <input type="number" value="50000" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    <p class="text-xs text-gray-500 mt-1">One-time fee for featuring a job</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Urgent Job Fee (UGX)</label>
                                    <input type="number" value="30000" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    <p class="text-xs text-gray-500 mt-1">One-time fee for marking job as urgent</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Profile Verification Fee (UGX)</label>
                                    <input type="number" value="20000" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    <p class="text-xs text-gray-500 mt-1">Fee for verified badge</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Premium Subscription (UGX/month)</label>
                                    <input type="number" value="100000" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    <p class="text-xs text-gray-500 mt-1">Monthly premium membership fee</p>
                                </div>
                            </div>
                            <button class="mt-6 bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition">
                                <i class="fas fa-save mr-2"></i>Save Fee Changes
                            </button>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-credit-card text-blue-600 mr-3"></i>
                                Payment Methods
                            </h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div class="flex items-center">
                                        <i class="fas fa-mobile-alt text-green-600 text-2xl mr-4"></i>
                                        <div>
                                            <h4 class="font-semibold text-gray-800">Mobile Money</h4>
                                            <p class="text-sm text-gray-600">MTN, Airtel Money</p>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" checked class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div class="flex items-center">
                                        <i class="fas fa-credit-card text-blue-600 text-2xl mr-4"></i>
                                        <div>
                                            <h4 class="font-semibold text-gray-800">Credit/Debit Cards</h4>
                                            <p class="text-sm text-gray-600">Visa, Mastercard</p>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" checked class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div class="flex items-center">
                                        <i class="fas fa-university text-purple-600 text-2xl mr-4"></i>
                                        <div>
                                            <h4 class="font-semibold text-gray-800">Bank Transfer</h4>
                                            <p class="text-sm text-gray-600">Direct bank deposits</p>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notifications Tab -->
                    <div id="notifications-settings-tab" class="settings-tab-content hidden">
                        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-envelope text-blue-600 mr-3"></i>
                                Email Notifications
                            </h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">New User Registration</h4>
                                        <p class="text-sm text-gray-600">Send welcome email to new users</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" checked class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Job Application Received</h4>
                                        <p class="text-sm text-gray-600">Notify employers of new applications</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" checked class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Application Status Update</h4>
                                        <p class="text-sm text-gray-600">Notify workers when application status changes</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" checked class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Job Matching Alerts</h4>
                                        <p class="text-sm text-gray-600">Send job recommendations to workers</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" checked class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Weekly Digest</h4>
                                        <p class="text-sm text-gray-600">Send weekly activity summary</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-sms text-green-600 mr-3"></i>
                                SMS Notifications
                            </h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Enable SMS Notifications</h4>
                                        <p class="text-sm text-gray-600">Send SMS for critical updates</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">SMS Provider</label>
                                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                            <option>Africa's Talking</option>
                                            <option>Twilio</option>
                                            <option>Nexmo</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Sender ID</label>
                                        <input type="text" value="JOBLYNK" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security Tab -->
                    <div id="security-settings-tab" class="settings-tab-content hidden">
                        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-lock text-red-600 mr-3"></i>
                                Security Settings
                            </h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Two-Factor Authentication</h4>
                                        <p class="text-sm text-gray-600">Require 2FA for all admin accounts</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" checked class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Force Password Change</h4>
                                        <p class="text-sm text-gray-600">Require password change every 90 days</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Session Timeout</h4>
                                        <p class="text-sm text-gray-600">Auto-logout after inactivity</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" checked class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Session Timeout (minutes)</label>
                                        <input type="number" value="30" min="5" max="120" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Min Password Length</label>
                                        <input type="number" value="8" min="6" max="20" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    </div>
                                </div>
                            </div>
                            <button class="mt-6 bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition">
                                <i class="fas fa-save mr-2"></i>Save Security Settings
                            </button>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-user-secret text-purple-600 mr-3"></i>
                                Privacy & Data Protection
                            </h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">GDPR Compliance Mode</h4>
                                        <p class="text-sm text-gray-600">Enable data protection features</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" checked class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Cookie Consent</h4>
                                        <p class="text-sm text-gray-600">Show cookie consent banner</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" checked class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Data Export Requests</h4>
                                        <p class="text-sm text-gray-600">Allow users to export their data</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" checked class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- System Tab -->
                    <div id="system-settings-tab" class="settings-tab-content hidden">
                        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-tools text-gray-600 mr-3"></i>
                                System Maintenance
                            </h3>
                            <p class="text-sm text-red-600 mb-4">WARNING: Use these tools only when necessary. Impacts all live users.</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <button onclick="clearCache()" class="bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition flex items-center justify-center">
                                    <i class="fas fa-broom mr-2"></i>Clear Cache
                                </button>
                                <button onclick="optimizeSystem()" class="bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 transition flex items-center justify-center">
                                    <i class="fas fa-rocket mr-2"></i>Optimize System
                                </button>
                                <button onclick="initiateBackup()" id="backupButton" class="bg-gray-600 text-white py-3 px-4 rounded-lg hover:bg-gray-700 transition flex items-center justify-center">
                                    <i class="fas fa-database mr-2"></i>Database Backup
                                </button>
                                <button onclick="viewSystemLogs()" class="bg-purple-600 text-white py-3 px-4 rounded-lg hover:bg-purple-700 transition flex items-center justify-center">
                                    <i class="fas fa-file-alt mr-2"></i>View System Logs
                                </button>
                                <button onclick="viewSystemReports()" class="bg-indigo-600 text-white py-3 px-4 rounded-lg hover:bg-indigo-700 transition flex items-center justify-center">
                                    <i class="fas fa-chart-line mr-2"></i>System Reports
                                </button>
                            </div>
                            
                            <!-- Maintenance Mode Toggle -->
                            <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg border">
                                <div class="flex items-center">
                                    <div class="mr-3">
                                        <span id="maintenance-status-indicator" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-700">
                                            <i class="fas fa-circle mr-1 text-xs"></i>
                                            <span id="maintenance-status-text">Online</span>
                                        </span>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Maintenance Mode</h4>
                                        <p class="text-sm text-gray-500" id="maintenance-description">
                                            System is live and accessible to all users
                                        </p>
                                    </div>
                                </div>
                                
                                <button onclick="toggleMaintenanceMode()" id="maintenance-toggle-btn" 
                                        class="px-4 py-2 rounded-lg text-white font-semibold transition-all duration-200 transform hover:scale-105 bg-red-600 hover:bg-red-700">
                                    <i class="fas fa-pause mr-2"></i>
                                    <span id="maintenance-btn-text">Turn Offline</span>
                                </button>
                            </div>
                        </div>
                    
                    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Platform Fee Structure</h3>
                        <p class="text-sm text-gray-600 mb-4">Adjust the commission rates for employers and workers.</p>
                        <div class="space-y-4 max-w-md">
                            <div>
                                <label for="employer-fee" class="block text-sm font-medium text-gray-700">Employer Service Fee (%)</label>
                                <input id="employer-fee" type="number" value="10" min="0" max="100" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="worker-fee" class="block text-sm font-medium text-gray-700">Worker Commission Fee (%)</label>
                                <input id="worker-fee" type="number" value="5" min="0" max="100" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <button class="bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition">Save Fee Changes</button>
                        </div>
                    </div>
                    
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">System Maintenance</h3>
                        <p class="text-sm text-red-600 mb-4">WARNING: Use these tools only when necessary. Impacts all live users.</p>
                        
                        <div class="flex flex-col sm:flex-row gap-4">
                            <button onclick="initiateBackup()" id="backupButton" class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600 transition">
                                <i class="fas fa-database mr-2"></i>Initiate Database Backup
                            </button>
                            
                            <!-- Maintenance Mode Toggle -->
                            <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg border">
                                <div class="flex items-center">
                                    <div class="mr-3">
                                        <span id="maintenance-status-indicator" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                            {{ \App\Models\Setting::get('maintenance_mode', 'off') === 'on' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                            <i class="fas fa-circle mr-1 text-xs"></i>
                                            <span id="maintenance-status-text">{{ \App\Models\Setting::get('maintenance_mode', 'off') === 'on' ? 'Offline' : 'Online' }}</span>
                                        </span>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Maintenance Mode</h4>
                                        <p class="text-sm text-gray-500" id="maintenance-description">
                                            {{ \App\Models\Setting::get('maintenance_mode', 'off') === 'on' 
                                                ? 'System is currently offline for maintenance' 
                                                : 'System is live and accessible to all users' }}
                                        </p>
                                    </div>
                                </div>
                                
                                <button onclick="toggleMaintenanceMode()" id="maintenance-toggle-btn" 
                                        class="px-4 py-2 rounded-lg text-white font-semibold transition-all duration-200 transform hover:scale-105
                                        {{ \App\Models\Setting::get('maintenance_mode', 'off') === 'on' 
                                            ? 'bg-green-600 hover:bg-green-700' 
                                            : 'bg-red-600 hover:bg-red-700' }}">
                                    <i class="fas {{ \App\Models\Setting::get('maintenance_mode', 'off') === 'on' ? 'fa-play' : 'fa-pause' }} mr-2"></i>
                                    <span id="maintenance-btn-text">{{ \App\Models\Setting::get('maintenance_mode', 'off') === 'on' ? 'Turn Online' : 'Turn Offline' }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Backup Management Section -->
                    <div class="bg-white p-6 rounded-lg shadow-md mt-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-semibold text-gray-800">Backup Management</h3>
                            <button onclick="refreshBackupList()" class="bg-blue-600 text-white px-3 py-2 rounded-lg hover:bg-blue-700 transition text-sm">
                                <i class="fas fa-sync-alt mr-1"></i>Refresh
                            </button>
                        </div>
                        <p class="text-sm text-gray-600 mb-4">Manage your database backups - download or delete backup files.</p>
                        
                        <!-- Backup Statistics -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                                <div class="flex items-center">
                                    <i class="fas fa-database text-blue-600 text-xl mr-3"></i>
                                    <div>
                                        <p class="text-sm text-blue-600 font-medium">Total Backups</p>
                                        <p class="text-xl font-bold text-blue-800" id="backup-count">-</p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                                <div class="flex items-center">
                                    <i class="fas fa-hdd text-green-600 text-xl mr-3"></i>
                                    <div>
                                        <p class="text-sm text-green-600 font-medium">Total Size</p>
                                        <p class="text-xl font-bold text-green-800" id="backup-total-size">-</p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                                <div class="flex items-center">
                                    <i class="fas fa-clock text-purple-600 text-xl mr-3"></i>
                                    <div>
                                        <p class="text-sm text-purple-600 font-medium">Latest Backup</p>
                                        <p class="text-sm font-bold text-purple-800" id="backup-latest">-</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Backup Files List -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200" id="backup-table">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Filename</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Size</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="backup-list">
                                    <tr id="backup-loading">
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                            <i class="fas fa-spinner fa-spin mr-2"></i>Loading backups...
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- No Backups Message -->
                        <div id="no-backups" class="hidden text-center py-8">
                            <i class="fas fa-database text-gray-400 text-4xl mb-4"></i>
                            <p class="text-gray-500 text-lg">No backups found</p>
                            <p class="text-gray-400 text-sm">Create your first backup using the button above</p>
                        </div>
                    </div>
                </div>

                <div id="messages-content" class="content-section hidden">
                    <h2 class="text-2xl font-bold text-gray-700 mb-6">Admin Messages & Communication</h2>
                    
                    <!-- Notification Area -->
                    <div id="messages-notification-area" class="hidden mb-6">
                        <div id="messages-notification" class="p-3 rounded-lg border flex items-center justify-between">
                            <div class="flex items-center">
                                <i id="messages-notification-icon" class="mr-2"></i>
                                <span id="messages-notification-message" class="text-sm font-medium"></span>
                            </div>
                            <button onclick="hideMessagesNotification()" class="text-lg font-bold ml-4">&times;</button>
                        </div>
                    </div>
                    
                    <!-- Messages Statistics -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <div class="flex items-center">
                                <div class="p-3 bg-blue-100 rounded-full mr-4">
                                    <i class="fas fa-envelope text-blue-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Total Messages</p>
                                    <p class="text-2xl font-bold text-gray-800" id="admin-total-messages">{{ $messagingStats['total_messages'] ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <div class="flex items-center">
                                <div class="p-3 bg-red-100 rounded-full mr-4">
                                    <i class="fas fa-envelope-open text-red-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Unread Messages</p>
                                    <p class="text-2xl font-bold text-gray-800" id="admin-unread-messages">{{ $messagingStats['unread_admin_messages'] ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <div class="flex items-center">
                                <div class="p-3 bg-green-100 rounded-full mr-4">
                                    <i class="fas fa-calendar-day text-green-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Today's Messages</p>
                                    <p class="text-2xl font-bold text-gray-800" id="admin-messages-today">{{ $messagingStats['messages_today'] ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <div class="flex items-center">
                                <div class="p-3 bg-purple-100 rounded-full mr-4">
                                    <i class="fas fa-users text-purple-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Active Conversations</p>
                                    <p class="text-2xl font-bold text-gray-800" id="admin-conversations-count">0</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Messages Interface -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="flex h-[600px]">
                            <!-- Conversations List -->
                            <div class="w-1/3 border-r border-gray-200 flex flex-col">
                                <div class="p-4 border-b border-gray-200 bg-gray-50">
                                    <div class="flex items-center justify-between mb-3">
                                        <h3 class="text-lg font-semibold text-gray-800">Conversations</h3>
                                        <div class="flex space-x-2">
                                            <button onclick="refreshAdminConversations()" class="text-blue-600 hover:text-blue-800 p-1 rounded" title="Refresh">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                            <button onclick="openNewMessageModal()" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition">
                                                <i class="fas fa-plus mr-1"></i>New
                                            </button>
                                        </div>
                                    </div>
                                    <div class="relative">
                                        <input type="text" id="admin-conversation-search" placeholder="Search conversations..." 
                                               class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <i class="fas fa-search absolute left-2.5 top-2.5 text-gray-400 text-sm"></i>
                                    </div>
                                </div>
                                
                                <div class="flex-1 overflow-y-auto" id="admin-conversations-list">
                                    <div class="text-center text-gray-500 py-8">
                                        <i class="fas fa-inbox text-4xl mb-4 text-gray-300"></i>
                                        <p class="font-medium">Loading conversations...</p>
                                        <p class="text-sm text-gray-400">User messages will appear here</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Messages Area -->
                            <div class="flex-1 flex flex-col">
                                <!-- Conversation Header -->
                                <div id="admin-conversation-header" class="p-4 border-b border-gray-200 bg-gray-50 hidden">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <img id="admin-conversation-avatar" class="h-10 w-10 rounded-full mr-3" src="" alt="">
                                            <div>
                                                <h4 id="admin-conversation-name" class="font-semibold text-gray-900"></h4>
                                                <p id="admin-conversation-role" class="text-sm text-gray-500"></p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <button onclick="viewUserProfile(currentAdminConversation)" class="text-blue-600 hover:text-blue-800 p-2 rounded" title="View Profile">
                                                <i class="fas fa-user"></i>
                                            </button>
                                            <button onclick="markConversationAsRead(currentAdminConversation)" class="text-green-600 hover:text-green-800 p-2 rounded" title="Mark as Read">
                                                <i class="fas fa-check-double"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Messages Container -->
                                <div id="admin-messages-container" class="flex-1 overflow-y-auto p-4 bg-gray-50">
                                    <div class="text-center text-gray-500 mt-20">
                                        <i class="fas fa-comment-dots text-6xl mb-4 text-gray-300"></i>
                                        <p class="text-lg font-medium">Select a conversation to start messaging</p>
                                        <p class="text-sm text-gray-400">Help users by responding to their questions and concerns</p>
                                    </div>
                                </div>

                                <!-- Message Input -->
                                <div id="admin-message-input" class="p-4 border-t border-gray-200 bg-white hidden">
                                    <form id="admin-send-message-form" class="flex space-x-3">
                                        <input type="hidden" id="admin-receiver-id" value="">
                                        <input type="text" id="admin-message-text" placeholder="Type your message..." 
                                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition flex items-center">
                                            <i class="fas fa-paper-plane mr-2"></i>Send
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Broadcast Message Section -->
                    <div class="bg-white p-6 rounded-lg shadow-md mt-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Broadcast Message</h3>
                        <p class="text-sm text-gray-600 mb-4">Send announcements to multiple users at once.</p>
                        
                        <form id="broadcast-message-form" class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="broadcast-audience" class="block text-sm font-medium text-gray-700 mb-2">Audience</label>
                                    <select id="broadcast-audience" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="all">All Users</option>
                                        <option value="workers">Workers Only</option>
                                        <option value="employers">Employers Only</option>
                                        <option value="new_users">New Users (Last 30 days)</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="broadcast-type" class="block text-sm font-medium text-gray-700 mb-2">Message Type</label>
                                    <select id="broadcast-type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="announcement">Announcement</option>
                                        <option value="maintenance">Maintenance Notice</option>
                                        <option value="feature">New Feature</option>
                                        <option value="promotion">Promotion</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div>
                                <label for="broadcast-message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                                <textarea id="broadcast-message" rows="4" placeholder="Enter your broadcast message..." 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                                <p class="text-xs text-gray-500 mt-1">Maximum 1000 characters</p>
                            </div>
                            
                            <div class="flex items-center space-x-4">
                                <label class="flex items-center">
                                    <input type="checkbox" id="broadcast-urgent" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">Mark as urgent</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" id="broadcast-email" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">Send email notification</span>
                                </label>
                            </div>
                            
                            <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition">
                                <i class="fas fa-bullhorn mr-2"></i>Send Broadcast Message
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- System Logs Content -->
    <div id="systemLogs-content" class="content-section hidden">
        <!-- Modern Header with Gradient -->
        <div class="bg-gradient-to-r from-purple-600 via-purple-700 to-indigo-700 rounded-2xl shadow-2xl p-8 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold mb-2 flex items-center">
                        <i class="fas fa-file-alt mr-3"></i>
                        System Logs
                    </h2>
                    <p class="text-purple-100">Monitor system activity and troubleshoot issues</p>
                </div>
                <div class="hidden md:block">
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4">
                        <div class="text-center">
                            <div class="text-3xl font-bold"><i class="fas fa-heartbeat"></i></div>
                            <div class="text-sm text-purple-100">Live Monitoring</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Log Controls -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex flex-wrap items-center gap-3">
                    <button onclick="filterLogs('all')" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-all">
                        <i class="fas fa-list mr-2"></i>All Logs
                    </button>
                    <button onclick="filterLogs('error')" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg font-medium transition-all">
                        <i class="fas fa-exclamation-circle mr-2"></i>Errors
                    </button>
                    <button onclick="filterLogs('warning')" class="px-4 py-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-lg font-medium transition-all">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Warnings
                    </button>
                    <button onclick="filterLogs('info')" class="px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg font-medium transition-all">
                        <i class="fas fa-info-circle mr-2"></i>Info
                    </button>
                </div>
                <div class="flex items-center gap-3">
                    <button onclick="refreshLogs()" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-all shadow-lg">
                        <i class="fas fa-sync-alt mr-2"></i>Refresh
                    </button>
                    <button onclick="clearLogs()" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-all shadow-lg">
                        <i class="fas fa-trash mr-2"></i>Clear Logs
                    </button>
                </div>
            </div>
        </div>

        <!-- Logs Display -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div id="systemLogsContent" class="space-y-3 max-h-[600px] overflow-y-auto">
                <div class="text-center py-12">
                    <i class="fas fa-spinner fa-spin text-gray-300 text-6xl mb-4"></i>
                    <p class="text-gray-500 text-lg">Loading system logs...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div id="logoutModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full transform transition-all scale-95 opacity-0" id="logoutModalContent">
            <!-- Modal Header -->
            <div class="relative bg-gradient-to-r from-red-600 to-red-700 p-6 text-white rounded-t-2xl overflow-hidden">
                <div class="absolute inset-0 opacity-20">
                    <div class="absolute -top-1/2 -left-1/2 w-full h-full bg-gradient-to-br from-white/20 to-transparent rounded-full blur-3xl animate-blob"></div>
                </div>
                <div class="relative z-10 flex items-center gap-4">
                    <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                        <i class="fas fa-sign-out-alt text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold">Confirm Logout</h3>
                        <p class="text-red-100 text-sm">End your admin session</p>
                    </div>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <div class="flex items-start gap-4 mb-6">
                    <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-800 dark:text-gray-200 font-medium mb-2">Are you sure you want to logout?</p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">This will end your current admin session and you'll need to login again to access the dashboard.</p>
                    </div>
                </div>

                <!-- Session Info -->
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 mb-6">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Logged in as:</span>
                        <span class="font-medium text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm mt-2">
                        <span class="text-gray-600 dark:text-gray-400">Session time:</span>
                        <span class="font-medium text-gray-800 dark:text-gray-200" id="sessionTime">-</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3">
                    <button onclick="closeLogoutModal()" class="flex-1 px-4 py-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-medium transition-all">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </button>
                    <button onclick="proceedLogout()" class="flex-1 px-4 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white rounded-lg font-medium transition-all shadow-lg hover:shadow-xl">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Logout
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global showContent function
        window.showContent = null;
        
        document.addEventListener('DOMContentLoaded', () => {
            // Mobile menu toggle
            const mobileMenuBtn = document.getElementById('adminMobileMenuBtn');
            const sidebar = document.querySelector('.admin-sidebar');
            const overlay = document.getElementById('adminMobileOverlay');
            
            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', () => {
                    sidebar.classList.toggle('mobile-open');
                    overlay.classList.toggle('hidden');
                });
            }
            
            // Close sidebar when clicking overlay
            if (overlay) {
                overlay.addEventListener('click', () => {
                    sidebar.classList.remove('mobile-open');
                    overlay.classList.add('hidden');
                });
            }
            
            const sidebarLinks = document.querySelectorAll('.sidebar-link');
            const contentSections = document.querySelectorAll('.content-section');

            // Define showContent as a global function
            window.showContent = function(contentId) {
                console.log('showContent called with:', contentId);
                
                // Hide all content sections
                contentSections.forEach(section => {
                    section.classList.add('hidden');
                    console.log('Hiding section:', section.id);
                });
                
                // Show the selected content section
                const targetContent = document.getElementById(contentId + '-content');
                if (targetContent) {
                    targetContent.classList.remove('hidden');
                    console.log('Showing section:', targetContent.id);
                    console.log('Content shown:', contentId);
                } else {
                    console.log('Target content not found:', contentId + '-content');
                }
            }

            // Function to manage active sidebar link style
            function updateSidebar(activeLink) {
                sidebarLinks.forEach(link => {
                    link.classList.remove('sidebar-active', 'bg-gray-700', 'text-white');
                    link.classList.add('text-gray-300', 'hover:bg-gray-700');
                });
                activeLink.classList.add('sidebar-active', 'bg-gray-700', 'text-white');
            }

            // Add click event listeners to sidebar links
            sidebarLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    
                    // Close mobile menu when link is clicked
                    if (window.innerWidth < 1024) {
                        sidebar.classList.remove('mobile-open');
                        overlay.classList.add('hidden');
                    }
                    const contentId = link.getAttribute('data-content');
                    
                    // Handle modal sections
                    if (contentId === 'messages') {
                        openMessagesModal();
                        return;
                    } else if (contentId === 'jobs') {
                        openJobManagementModal();
                        return;
                    } else if (contentId === 'analytics') {
                        openAnalyticsModal();
                        return;
                    }
                    
                    // Handle regular content sections
                    showContent(contentId);
                    updateSidebar(link);
                });
            });

            // Initialize: Set the default view to 'overview' on page load
            const defaultLink = document.querySelector('[data-content="overview"]');
            if (defaultLink) {
                updateSidebar(defaultLink);
                showContent('overview');
            }
        });

        // Top Bar Functions
        function toggleNotifications() {
            const dropdown = document.getElementById('notificationsDropdown');
            const quickActions = document.getElementById('quickActionsDropdown');
            const profile = document.getElementById('topBarProfileDropdown');
            
            // Close other dropdowns
            if (quickActions) quickActions.classList.add('hidden');
            if (profile) profile.classList.add('hidden');
            
            // Toggle notifications
            if (dropdown) {
                dropdown.classList.toggle('hidden');
            }
        }

        function toggleQuickActions() {
            const dropdown = document.getElementById('quickActionsDropdown');
            const notifications = document.getElementById('notificationsDropdown');
            const profile = document.getElementById('topBarProfileDropdown');
            
            // Close other dropdowns
            if (notifications) notifications.classList.add('hidden');
            if (profile) profile.classList.add('hidden');
            
            // Toggle quick actions
            if (dropdown) {
                dropdown.classList.toggle('hidden');
            }
        }

        function toggleTopBarProfile() {
            const dropdown = document.getElementById('topBarProfileDropdown');
            const notifications = document.getElementById('notificationsDropdown');
            const quickActions = document.getElementById('quickActionsDropdown');
            const themeMenu = document.getElementById('themeMenuDropdown');
            
            // Close other dropdowns
            if (notifications) notifications.classList.add('hidden');
            if (quickActions) quickActions.classList.add('hidden');
            if (themeMenu) themeMenu.classList.add('hidden');
            
            // Toggle profile
            if (dropdown) {
                dropdown.classList.toggle('hidden');
            }
        }

        function toggleThemeMenu() {
            const dropdown = document.getElementById('themeMenuDropdown');
            const notifications = document.getElementById('notificationsDropdown');
            const quickActions = document.getElementById('quickActionsDropdown');
            const profile = document.getElementById('topBarProfileDropdown');
            
            // Close other dropdowns
            if (notifications) notifications.classList.add('hidden');
            if (quickActions) quickActions.classList.add('hidden');
            if (profile) profile.classList.add('hidden');
            
            // Toggle theme menu
            if (dropdown) {
                dropdown.classList.toggle('hidden');
            }
        }

        // Theme Management
        function setTheme(theme) {
            // Save theme preference
            localStorage.setItem('admin-theme', theme);
            
            // Apply theme
            applyTheme(theme);
            
            // Update UI
            updateThemeUI(theme);
            
            // Close dropdown
            document.getElementById('themeMenuDropdown').classList.add('hidden');
            
            // Show notification
            const themeNames = {
                'light': 'Light Mode',
                'dark': 'Dark Mode',
                'system': 'System Default'
            };
            showNotification(`Theme changed to ${themeNames[theme]}`, 'success');
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
                // Check system preference
                if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
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
                themeIcon.className = `fas fa-${icon} text-gray-600 group-hover:text-yellow-500 transition-colors`;
            }
        }

        function updateThemeUI(theme) {
            // Hide all checkmarks
            document.querySelectorAll('.light-check, .dark-check, .system-check').forEach(check => {
                check.classList.add('hidden');
            });
            
            // Show active checkmark
            const checkClass = `${theme}-check`;
            document.querySelectorAll(`.${checkClass}`).forEach(check => {
                check.classList.remove('hidden');
            });
        }

        // Initialize theme on page load
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('admin-theme') || 'light';
            applyTheme(savedTheme);
            updateThemeUI(savedTheme);
            
            // Listen for system theme changes
            if (window.matchMedia) {
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                    const currentTheme = localStorage.getItem('admin-theme');
                    if (currentTheme === 'system') {
                        applyTheme('system');
                    }
                });
            }
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            const notifications = document.getElementById('notificationsDropdown');
            const quickActions = document.getElementById('quickActionsDropdown');
            const profile = document.getElementById('topBarProfileDropdown');
            const themeMenu = document.getElementById('themeMenuDropdown');
            
            // Check if click is outside all dropdowns
            if (!e.target.closest('.relative')) {
                if (notifications) notifications.classList.add('hidden');
                if (quickActions) quickActions.classList.add('hidden');
                if (profile) profile.classList.add('hidden');
                if (themeMenu) themeMenu.classList.add('hidden');
            }
        });

        // Admin Global Search
        let searchTimeout;
        const searchInput = document.getElementById('adminGlobalSearch');
        const searchResults = document.getElementById('adminSearchResults');

        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                clearTimeout(searchTimeout);
                const query = e.target.value.trim();
                
                if (query.length < 2) {
                    searchResults.classList.add('hidden');
                    return;
                }
                
                searchTimeout = setTimeout(() => {
                    performAdminSearch(query);
                }, 300);
            });

            // Close search results when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('#adminGlobalSearch') && !e.target.closest('#adminSearchResults')) {
                    searchResults.classList.add('hidden');
                }
            });
        }

        function performAdminSearch(query) {
            searchResults.innerHTML = '<div class="p-4 text-center"><i class="fas fa-spinner fa-spin text-blue-600"></i> Searching...</div>';
            searchResults.classList.remove('hidden');
            
            // Simulate search (replace with actual AJAX call)
            setTimeout(() => {
                searchResults.innerHTML = `
                    <div class="p-2">
                        <div class="px-3 py-2 text-xs text-gray-500 uppercase font-semibold">Users</div>
                        <a href="#" class="flex items-center gap-3 px-3 py-2 hover:bg-gray-50 rounded-lg transition">
                            <i class="fas fa-user text-blue-600"></i>
                            <div>
                                <div class="text-sm font-medium text-gray-800">John Doe</div>
                                <div class="text-xs text-gray-500">Worker • john@example.com</div>
                            </div>
                        </a>
                        <div class="px-3 py-2 text-xs text-gray-500 uppercase font-semibold mt-2">Jobs</div>
                        <a href="#" class="flex items-center gap-3 px-3 py-2 hover:bg-gray-50 rounded-lg transition">
                            <i class="fas fa-briefcase text-green-600"></i>
                            <div>
                                <div class="text-sm font-medium text-gray-800">Plumbing Job</div>
                                <div class="text-xs text-gray-500">Posted 2 days ago</div>
                            </div>
                        </a>
                    </div>
                `;
            }, 500);
        }

        // Profile Picture Viewing Functions
        function viewUserProfilePicture(imageUrl, userName, userRole) {
            const modal = document.getElementById('profile-picture-modal');
            const content = document.getElementById('profile-picture-content');
            const image = document.getElementById('profile-modal-image');
            const name = document.getElementById('profile-modal-name');
            const role = document.getElementById('profile-modal-role');
            const accountType = document.getElementById('profile-modal-account-type');

            // Ensure we have a valid image URL
            let finalImageUrl = imageUrl;
            if (!finalImageUrl || finalImageUrl === '' || finalImageUrl === 'null') {
                finalImageUrl = 'https://ui-avatars.com/api/?name=' + encodeURIComponent(userName) + '&color=ffffff&background=1e40af&size=150';
            }

            // Set modal content
            image.src = finalImageUrl;
            image.onerror = function() {
                this.src = 'https://ui-avatars.com/api/?name=' + encodeURIComponent(userName) + '&color=ffffff&background=1e40af&size=150';
            };
            
            name.textContent = userName;
            role.textContent = 'User Profile Picture';
            accountType.textContent = userRole.charAt(0).toUpperCase() + userRole.slice(1);

            // Show modal
            modal.classList.remove('hidden');
            
            // Animate modal in
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);

            // Store current image URL for download
            window.currentProfileImageUrl = finalImageUrl;
            window.currentProfileImageName = userName;

            // Close on backdrop click
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeProfilePictureModal();
                }
            });

            // Close on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeProfilePictureModal();
                }
            });
        }

        function closeProfilePictureModal() {
            const modal = document.getElementById('profile-picture-modal');
            const content = document.getElementById('profile-picture-content');
            
            content.classList.add('scale-95', 'opacity-0');
            content.classList.remove('scale-100', 'opacity-100');
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        function downloadProfilePicture() {
            if (window.currentProfileImageUrl && window.currentProfileImageName) {
                const link = document.createElement('a');
                link.href = window.currentProfileImageUrl;
                link.download = `${window.currentProfileImageName}_profile_picture.jpg`;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                
                showNotification(`Profile picture of ${window.currentProfileImageName} downloaded successfully!`, 'success');
            }
        }

        // Job Details Modal Functions
        function viewJobDetails(jobId) {
            const modal = document.getElementById('jobDetailsModal');
            const content = document.getElementById('jobDetailsContent');
            
            // Show modal
            modal.classList.remove('hidden');
            
            // Show loading state
            content.innerHTML = `
                <div class="flex items-center justify-center py-12">
                    <div class="text-center">
                        <i class="fas fa-spinner fa-spin text-4xl text-blue-600 mb-4"></i>
                        <p class="text-gray-600">Loading job details...</p>
                    </div>
                </div>
            `;
            
            // Fetch job details
            fetch(`/api/jobs/${jobId}`)
                .then(response => response.json())
                .then(data => {
                    displayJobDetails(data);
                })
                .catch(error => {
                    console.error('Error fetching job details:', error);
                    content.innerHTML = `
                        <div class="text-center py-12">
                            <i class="fas fa-exclamation-circle text-4xl text-red-600 mb-4"></i>
                            <p class="text-gray-600">Failed to load job details</p>
                            <button onclick="viewJobDetails(${jobId})" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Try Again
                            </button>
                        </div>
                    `;
                });
        }

        function displayJobDetails(job) {
            const content = document.getElementById('jobDetailsContent');
            
            // Format date
            const createdDate = new Date(job.created_at).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            
            // Format budget
            const budget = new Intl.NumberFormat('en-UG', {
                style: 'currency',
                currency: 'UGX',
                minimumFractionDigits: 0
            }).format(job.budget || 0);
            
            // Status badge color
            const statusColors = {
                'active': 'bg-green-100 text-green-800',
                'completed': 'bg-blue-100 text-blue-800',
                'cancelled': 'bg-red-100 text-red-800',
                'draft': 'bg-yellow-100 text-yellow-800'
            };
            
            const statusColor = statusColors[job.status] || 'bg-gray-100 text-gray-800';
            
            content.innerHTML = `
                <div class="space-y-6">
                    <!-- Job Header -->
                    <div class="bg-gradient-to-r from-blue-50 to-purple-50 p-6 rounded-xl border border-blue-100">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">${job.title}</h3>
                                <div class="flex items-center gap-4 text-sm text-gray-600">
                                    <span class="flex items-center">
                                        <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i>
                                        ${job.location || 'Not specified'}
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-calendar mr-2 text-blue-600"></i>
                                        ${createdDate}
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-briefcase mr-2 text-blue-600"></i>
                                        ${job.job_type || 'Not specified'}
                                    </span>
                                </div>
                            </div>
                            <span class="px-4 py-2 rounded-full text-sm font-semibold ${statusColor}">
                                ${job.status ? job.status.charAt(0).toUpperCase() + job.status.slice(1) : 'Unknown'}
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-3 gap-4 mt-4">
                            <div class="bg-white p-4 rounded-lg shadow-sm">
                                <div class="text-sm text-gray-500 mb-1">Budget</div>
                                <div class="text-xl font-bold text-green-600">${budget}</div>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow-sm">
                                <div class="text-sm text-gray-500 mb-1">Applications</div>
                                <div class="text-xl font-bold text-blue-600">${job.applications_count || 0}</div>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow-sm">
                                <div class="text-sm text-gray-500 mb-1">Category</div>
                                <div class="text-lg font-semibold text-gray-800">${job.category?.name || 'N/A'}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Job Description -->
                    <div class="bg-white p-6 rounded-xl border border-gray-200">
                        <h4 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                            <i class="fas fa-file-alt mr-2 text-blue-600"></i>
                            Job Description
                        </h4>
                        <div class="text-gray-700 leading-relaxed whitespace-pre-wrap">${job.description || 'No description provided'}</div>
                    </div>

                    <!-- Employer Information -->
                    <div class="bg-white p-6 rounded-xl border border-gray-200">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-building mr-2 text-blue-600"></i>
                            Employer Information
                        </h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <div class="text-sm text-gray-500 mb-1">Name</div>
                                <div class="font-medium text-gray-900">${job.employer?.name || 'N/A'}</div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500 mb-1">Email</div>
                                <div class="font-medium text-gray-900">${job.employer?.email || 'N/A'}</div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500 mb-1">Phone</div>
                                <div class="font-medium text-gray-900">${job.employer?.phone || 'N/A'}</div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500 mb-1">Account Type</div>
                                <div class="font-medium text-gray-900">${job.employer?.role || 'N/A'}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Details -->
                    <div class="bg-white p-6 rounded-xl border border-gray-200">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                            Additional Details
                        </h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <div class="text-sm text-gray-500 mb-1">Duration</div>
                                <div class="font-medium text-gray-900">${job.duration || 'Not specified'}</div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500 mb-1">Experience Level</div>
                                <div class="font-medium text-gray-900">${job.experience_level || 'Not specified'}</div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500 mb-1">Urgent</div>
                                <div class="font-medium ${job.is_urgent ? 'text-red-600' : 'text-gray-900'}">
                                    ${job.is_urgent ? 'Yes' : 'No'}
                                </div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500 mb-1">Featured</div>
                                <div class="font-medium ${job.is_featured ? 'text-blue-600' : 'text-gray-900'}">
                                    ${job.is_featured ? 'Yes' : 'No'}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Required Skills -->
                    ${job.skills && job.skills.length > 0 ? `
                        <div class="bg-white p-6 rounded-xl border border-gray-200">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-tools mr-2 text-blue-600"></i>
                                Required Skills
                            </h4>
                            <div class="flex flex-wrap gap-2">
                                ${job.skills.map(skill => `
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                        ${skill.name}
                                    </span>
                                `).join('')}
                            </div>
                        </div>
                    ` : ''}

                    <!-- Admin Actions -->
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-6 rounded-xl border border-gray-200">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-cog mr-2 text-gray-600"></i>
                            Admin Actions
                        </h4>
                        <div class="flex flex-wrap gap-3">
                            ${job.status === 'draft' ? `
                                <button onclick="approveJob(${job.id})" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                    <i class="fas fa-check mr-2"></i>Approve Job
                                </button>
                                <button onclick="rejectJob(${job.id})" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                    <i class="fas fa-times mr-2"></i>Reject Job
                                </button>
                            ` : ''}
                            <button onclick="suspendJob(${job.id})" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                                <i class="fas fa-pause mr-2"></i>Suspend Job
                            </button>
                            <button onclick="deleteJob(${job.id})" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                <i class="fas fa-trash mr-2"></i>Delete Job
                            </button>
                            <button onclick="contactEmployer(${job.employer?.id})" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                <i class="fas fa-envelope mr-2"></i>Contact Employer
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            // Store job data for export/print
            window.currentJobData = job;
        }

        function closeJobDetailsModal() {
            const modal = document.getElementById('jobDetailsModal');
            modal.classList.add('hidden');
        }

        function exportJobDetails() {
            if (!window.currentJobData) return;
            
            const job = window.currentJobData;
            const csvContent = `Job Details Export
Title,${job.title}
Location,${job.location || 'N/A'}
Status,${job.status}
Budget,${job.budget}
Applications,${job.applications_count || 0}
Category,${job.category?.name || 'N/A'}
Employer,${job.employer?.name || 'N/A'}
Employer Email,${job.employer?.email || 'N/A'}
Created Date,${job.created_at}
Description,"${job.description?.replace(/"/g, '""') || 'N/A'}"
`;
            
            const blob = new Blob([csvContent], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = `job_${job.id}_details.csv`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            window.URL.revokeObjectURL(url);
            
            showNotification('Job details exported successfully!', 'success');
        }

        function printJobDetails() {
            window.print();
        }

        // Job action functions
        function approveJob(jobId) {
            if (confirm('Are you sure you want to approve this job?')) {
                // Implement approval logic
                showNotification('Job approved successfully!', 'success');
                closeJobDetailsModal();
            }
        }

        function rejectJob(jobId) {
            const reason = prompt('Please provide a reason for rejection:');
            if (reason) {
                // Implement rejection logic
                showNotification('Job rejected successfully!', 'success');
                closeJobDetailsModal();
            }
        }

        function suspendJob(jobId) {
            if (confirm('Are you sure you want to suspend this job?')) {
                // Implement suspension logic
                showNotification('Job suspended successfully!', 'warning');
                closeJobDetailsModal();
            }
        }

        function deleteJob(jobId) {
            if (confirm('Are you sure you want to delete this job? This action cannot be undone.')) {
                // Implement deletion logic
                showNotification('Job deleted successfully!', 'success');
                closeJobDetailsModal();
            }
        }

        function contactEmployer(employerId) {
            // Open messages modal or redirect to employer contact
            showNotification('Opening employer contact...', 'info');
        }

        // Settings Tab Functions
        function showSettingsTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.settings-tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });
            
            // Remove active class from all tabs
            document.querySelectorAll('.settings-tab').forEach(tab => {
                tab.classList.remove('active-settings-tab', 'border-blue-600', 'text-blue-600');
            });
            
            // Show selected tab content
            const selectedTab = document.getElementById(`${tabName}-settings-tab`);
            if (selectedTab) {
                selectedTab.classList.remove('hidden');
            }
            
            // Add active class to clicked tab (if event is available)
            if (typeof event !== 'undefined' && event && event.target) {
                const clickedTab = event.target.closest('.settings-tab');
                if (clickedTab) {
                    clickedTab.classList.add('active-settings-tab', 'border-blue-600', 'text-blue-600');
                }
            }
        }

        // System maintenance functions
        async function clearCache() {
            // Show modern confirmation modal
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4';
            modal.innerHTML = `
                <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all animate-scale-in">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-3 mr-4">
                                <i class="fas fa-broom text-white text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Clear System Cache</h3>
                                <p class="text-sm text-gray-500">Cache management</p>
                            </div>
                        </div>
                        
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                            <p class="text-sm text-gray-700 mb-3">Are you sure you want to clear all system cache?</p>
                            <div class="space-y-2 text-sm text-gray-600">
                                <div class="flex items-start">
                                    <i class="fas fa-info-circle text-blue-500 mr-2 mt-0.5"></i>
                                    <span>This will clear application, config, route, and view caches</span>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-clock text-blue-500 mr-2 mt-0.5"></i>
                                    <span>First page loads will be temporarily slower</span>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-sync text-blue-500 mr-2 mt-0.5"></i>
                                    <span>Cache will rebuild automatically on next requests</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-triangle text-yellow-600 mr-2 mt-0.5"></i>
                                <p class="text-xs text-yellow-800">This action is safe but will temporarily impact performance until cache rebuilds.</p>
                            </div>
                        </div>
                        
                        <div class="flex gap-3">
                            <button onclick="this.closest('.fixed').remove()" class="flex-1 px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-all">
                                <i class="fas fa-times mr-2"></i>Cancel
                            </button>
                            <button onclick="executeClearCache(this)" class="flex-1 px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg font-medium transition-all shadow-lg">
                                <i class="fas fa-broom mr-2"></i>Clear Cache
                            </button>
                        </div>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
        }

        async function executeClearCache(button) {
            const modal = button.closest('.fixed');
            const modalContent = modal.querySelector('.bg-white');
            
            // Show progress
            modalContent.innerHTML = `
                <div class="p-8 text-center">
                    <div class="mb-6">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full mb-4">
                            <i class="fas fa-broom text-white text-3xl animate-bounce"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Clearing Cache</h3>
                        <p class="text-gray-600">Please wait while we clear the system cache...</p>
                    </div>
                    
                    <div class="mt-6">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full transition-all duration-1000 animate-pulse" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            `;

            try {
                const response = await fetch('/admin/system/clear-cache', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // Show success
                    modalContent.innerHTML = `
                        <div class="p-8 text-center">
                            <div class="mb-6">
                                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-full mb-4">
                                    <i class="fas fa-check text-white text-4xl"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">Cache Cleared!</h3>
                                <p class="text-gray-600">System cache has been successfully cleared</p>
                            </div>
                            
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                                <div class="flex items-center justify-center text-sm text-gray-700">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    <span>All cache types cleared successfully</span>
                                </div>
                            </div>
                            
                            <button onclick="this.closest('.fixed').remove()" class="w-full px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-lg font-medium transition-all shadow-lg">
                                <i class="fas fa-check mr-2"></i>Done
                            </button>
                        </div>
                    `;
                    
                    showNotification('✅ Cache cleared successfully!', 'success');
                } else {
                    throw new Error(data.message || 'Failed to clear cache');
                }
            } catch (error) {
                console.error('Cache clear error:', error);
                
                modalContent.innerHTML = `
                    <div class="p-8 text-center">
                        <div class="mb-6">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-red-100 rounded-full mb-4">
                                <i class="fas fa-exclamation-triangle text-red-600 text-4xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Clear Failed</h3>
                            <p class="text-gray-600">${error.message}</p>
                        </div>
                        
                        <button onclick="this.closest('.fixed').remove()" class="w-full px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-medium transition-all">
                            Close
                        </button>
                    </div>
                `;
                
                showNotification('❌ Failed to clear cache', 'error');
            }
        }

        function optimizeSystem() {
            // Show modern confirmation modal
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4';
            modal.innerHTML = `
                <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all animate-scale-in">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-3 mr-4">
                                <i class="fas fa-rocket text-white text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">System Optimization</h3>
                                <p class="text-sm text-gray-500">Performance enhancement</p>
                            </div>
                        </div>
                        
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                            <p class="text-sm text-gray-700 mb-3">This will perform the following optimizations:</p>
                            <ul class="space-y-2 text-sm text-gray-600">
                                <li class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    Clear application cache
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    Optimize configuration cache
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    Optimize route cache
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    Clear view cache
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    Optimize autoloader
                                </li>
                            </ul>
                        </div>
                        
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-triangle text-yellow-600 mr-2 mt-0.5"></i>
                                <p class="text-xs text-yellow-800">This process may take 10-30 seconds. The system will remain accessible during optimization.</p>
                            </div>
                        </div>
                        
                        <div class="flex gap-3">
                            <button onclick="this.closest('.fixed').remove()" class="flex-1 px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-all">
                                Cancel
                            </button>
                            <button onclick="executeOptimization(this)" class="flex-1 px-4 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-lg font-medium transition-all shadow-lg">
                                <i class="fas fa-rocket mr-2"></i>Optimize Now
                            </button>
                        </div>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
        }

        async function executeOptimization(button) {
            const modal = button.closest('.fixed');
            const modalContent = modal.querySelector('.bg-white');
            
            // Show progress
            modalContent.innerHTML = `
                <div class="p-8 text-center">
                    <div class="mb-6">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-full mb-4">
                            <i class="fas fa-rocket text-white text-3xl animate-bounce"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Optimizing System</h3>
                        <p class="text-gray-600">Please wait while we enhance performance...</p>
                    </div>
                    
                    <div class="space-y-3 text-left max-w-sm mx-auto" id="optimization-steps">
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-spinner fa-spin text-blue-500 mr-3"></i>
                            <span>Initializing optimization...</span>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div id="optimization-progress" class="bg-gradient-to-r from-green-500 to-green-600 h-2 rounded-full transition-all duration-500" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
            `;

            try {
                const response = await fetch('/admin/system/optimize', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // Show success with details
                    modalContent.innerHTML = `
                        <div class="p-8 text-center">
                            <div class="mb-6">
                                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-full mb-4">
                                    <i class="fas fa-check text-white text-4xl"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">Optimization Complete!</h3>
                                <p class="text-gray-600">Your system has been successfully optimized</p>
                            </div>
                            
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6 text-left">
                                <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    Completed Tasks
                                </h4>
                                <div class="space-y-2 text-sm text-gray-700">
                                    ${data.results.map(result => `
                                        <div class="flex items-start">
                                            <i class="fas fa-check text-green-500 mr-2 mt-0.5"></i>
                                            <span>${result}</span>
                                        </div>
                                    `).join('')}
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div class="bg-blue-50 rounded-lg p-3">
                                    <div class="text-2xl font-bold text-blue-600">${data.duration}s</div>
                                    <div class="text-xs text-gray-600">Duration</div>
                                </div>
                                <div class="bg-purple-50 rounded-lg p-3">
                                    <div class="text-2xl font-bold text-purple-600">${data.tasks_completed}</div>
                                    <div class="text-xs text-gray-600">Tasks</div>
                                </div>
                            </div>
                            
                            <button onclick="this.closest('.fixed').remove()" class="w-full px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-lg font-medium transition-all shadow-lg">
                                <i class="fas fa-times mr-2"></i>Close
                            </button>
                        </div>
                    `;
                    
                    showNotification('✅ System optimized successfully!', 'success');
                } else {
                    throw new Error(data.message || 'Optimization failed');
                }
            } catch (error) {
                console.error('Optimization error:', error);
                
                modalContent.innerHTML = `
                    <div class="p-8 text-center">
                        <div class="mb-6">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-red-100 rounded-full mb-4">
                                <i class="fas fa-exclamation-triangle text-red-600 text-4xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Optimization Failed</h3>
                            <p class="text-gray-600">${error.message}</p>
                        </div>
                        
                        <button onclick="this.closest('.fixed').remove()" class="w-full px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-medium transition-all">
                            Close
                        </button>
                    </div>
                `;
                
                showNotification('❌ Optimization failed', 'error');
            }
        }

        function viewSystemLogs() {
            // Create and show modal
            const modal = document.createElement('div');
            modal.id = 'systemLogsModal';
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4';
            modal.innerHTML = `
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-6xl max-h-[90vh] flex flex-col transform transition-all animate-scale-in">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-purple-600 via-purple-700 to-indigo-700 p-6 rounded-t-2xl flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3 mr-4">
                                <i class="fas fa-file-alt text-white text-2xl"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-white">System Logs</h2>
                                <p class="text-purple-100 text-sm">Monitor system activity and troubleshoot issues</p>
                            </div>
                        </div>
                        <button onclick="closeSystemLogsModal()" class="text-white hover:bg-white/20 rounded-lg p-2 transition-all">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    <!-- Controls -->
                    <div class="p-4 border-b border-gray-200 bg-gray-50">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <div class="flex flex-wrap items-center gap-2">
                                <button onclick="filterLogsInModal('all')" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition-all">
                                    <i class="fas fa-list mr-1"></i>All
                                </button>
                                <button onclick="filterLogsInModal('error')" class="px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg text-sm font-medium transition-all">
                                    <i class="fas fa-exclamation-circle mr-1"></i>Errors
                                </button>
                                <button onclick="filterLogsInModal('warning')" class="px-3 py-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-lg text-sm font-medium transition-all">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>Warnings
                                </button>
                                <button onclick="filterLogsInModal('info')" class="px-3 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg text-sm font-medium transition-all">
                                    <i class="fas fa-info-circle mr-1"></i>Info
                                </button>
                            </div>
                            <div class="flex items-center gap-2">
                                <button onclick="refreshLogsInModal()" class="px-3 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition-all shadow-lg">
                                    <i class="fas fa-sync-alt mr-1"></i>Refresh
                                </button>
                                <button onclick="clearLogsFromModal()" class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition-all shadow-lg">
                                    <i class="fas fa-trash mr-1"></i>Clear
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Logs Content -->
                    <div class="flex-1 overflow-y-auto p-6 bg-gray-50">
                        <div id="modalSystemLogsContent" class="space-y-3">
                            <div class="text-center py-12">
                                <i class="fas fa-spinner fa-spin text-gray-300 text-6xl mb-4"></i>
                                <p class="text-gray-500 text-lg">Loading system logs...</p>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="p-4 border-t border-gray-200 bg-gray-50 rounded-b-2xl flex justify-between items-center">
                        <div class="text-sm text-gray-600">
                            <i class="fas fa-info-circle mr-1"></i>
                            Showing last 100 log entries
                        </div>
                        <button onclick="closeSystemLogsModal()" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-medium transition-all">
                            Close
                        </button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            
            // Load logs
            loadSystemLogsInModal();
        }

        function closeSystemLogsModal() {
            const modal = document.getElementById('systemLogsModal');
            if (modal) {
                modal.remove();
            }
        }

        async function loadSystemLogsInModal() {
            try {
                const response = await fetch('/admin/system-logs', {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) throw new Error('Failed to load logs');

                const data = await response.json();
                displaySystemLogsInModal(data);
            } catch (error) {
                console.error('Error loading system logs:', error);
                const container = document.getElementById('modalSystemLogsContent');
                if (container) {
                    container.innerHTML = `
                        <div class="text-center py-12">
                            <i class="fas fa-exclamation-triangle text-red-300 text-6xl mb-4"></i>
                            <p class="text-red-500 text-lg">Failed to load system logs</p>
                        </div>
                    `;
                }
            }
        }

        function displaySystemLogsInModal(data) {
            const container = document.getElementById('modalSystemLogsContent');
            
            if (!container) return;
            
            if (!data.logs || data.logs.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-12">
                        <i class="fas fa-file-alt text-gray-300 text-6xl mb-4"></i>
                        <p class="text-gray-500 text-lg">No logs available</p>
                    </div>
                `;
                return;
            }

            const logsHtml = data.logs.map(log => {
                const levelColors = {
                    'ERROR': 'bg-red-100 text-red-800 border-red-300',
                    'WARNING': 'bg-yellow-100 text-yellow-800 border-yellow-300',
                    'INFO': 'bg-blue-100 text-blue-800 border-blue-300',
                    'DEBUG': 'bg-gray-100 text-gray-800 border-gray-300'
                };
                
                const levelIcons = {
                    'ERROR': 'fa-exclamation-circle',
                    'WARNING': 'fa-exclamation-triangle',
                    'INFO': 'fa-info-circle',
                    'DEBUG': 'fa-bug'
                };

                const colorClass = levelColors[log.level] || 'bg-gray-100 text-gray-800 border-gray-300';
                const iconClass = levelIcons[log.level] || 'fa-file-alt';

                return `
                    <div class="border-l-4 ${colorClass} p-4 rounded-r-lg bg-white shadow-sm log-entry" data-level="${log.level}">
                        <div class="flex items-start justify-between mb-2">
                            <div class="flex items-center space-x-2">
                                <i class="fas ${iconClass}"></i>
                                <span class="font-semibold">${log.level}</span>
                            </div>
                            <span class="text-sm opacity-75">${log.timestamp}</span>
                        </div>
                        <div class="text-sm font-mono bg-white bg-opacity-50 p-2 rounded">
                            ${escapeHtml(log.message)}
                        </div>
                        ${log.context ? `
                            <details class="mt-2">
                                <summary class="cursor-pointer text-sm opacity-75 hover:opacity-100">View Context</summary>
                                <pre class="text-xs mt-2 bg-white bg-opacity-50 p-2 rounded overflow-x-auto">${escapeHtml(JSON.stringify(log.context, null, 2))}</pre>
                            </details>
                        ` : ''}
                    </div>
                `;
            }).join('');

            container.innerHTML = logsHtml;
        }

        function filterLogsInModal(level) {
            const logs = document.querySelectorAll('#modalSystemLogsContent .log-entry');
            logs.forEach(log => {
                if (level === 'all' || log.dataset.level === level.toUpperCase()) {
                    log.style.display = 'block';
                } else {
                    log.style.display = 'none';
                }
            });
        }

        function refreshLogsInModal() {
            showNotification('Refreshing logs...', 'info');
            loadSystemLogsInModal();
        }

        function clearLogsFromModal() {
            if (!confirm('Are you sure you want to clear all system logs? This action cannot be undone.')) {
                return;
            }

            fetch('/admin/system-logs/clear', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Logs cleared successfully', 'success');
                    loadSystemLogsInModal();
                } else {
                    showNotification('Failed to clear logs', 'error');
                }
            })
            .catch(error => {
                console.error('Error clearing logs:', error);
                showNotification('Failed to clear logs', 'error');
            });
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeSystemLogsModal();
                closeSystemReportsModal();
            }
        });

        // System Reports Functions
        function viewSystemReports() {
            // Create and show modal
            const modal = document.createElement('div');
            modal.id = 'systemReportsModal';
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4';
            modal.innerHTML = `
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-7xl max-h-[90vh] flex flex-col transform transition-all animate-scale-in">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-indigo-600 via-blue-600 to-purple-600 p-6 rounded-t-2xl flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3 mr-4">
                                <i class="fas fa-chart-line text-white text-2xl"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-white">Weekly System Reports</h2>
                                <p class="text-indigo-100 text-sm">Automated platform performance analytics</p>
                            </div>
                        </div>
                        <button onclick="closeSystemReportsModal()" class="text-white hover:bg-white/20 rounded-lg p-2 transition-all">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    <!-- Controls -->
                    <div class="p-4 border-b border-gray-200 bg-gray-50">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <div class="text-sm text-gray-600">
                                <i class="fas fa-info-circle mr-1"></i>
                                Reports are automatically generated every Sunday at 11:59 PM
                            </div>
                            <button onclick="generateReportManually()" class="px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-lg text-sm font-medium transition-all shadow-lg">
                                <i class="fas fa-plus mr-2"></i>Generate Report Now
                            </button>
                        </div>
                    </div>

                    <!-- Reports Content -->
                    <div class="flex-1 overflow-y-auto p-6 bg-gray-50">
                        <div id="modalSystemReportsContent">
                            <div class="text-center py-12">
                                <i class="fas fa-spinner fa-spin text-gray-300 text-6xl mb-4"></i>
                                <p class="text-gray-500 text-lg">Loading reports...</p>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="p-4 border-t border-gray-200 bg-gray-50 rounded-b-2xl flex justify-between items-center">
                        <div class="text-sm text-gray-600">
                            <i class="fas fa-calendar-alt mr-1"></i>
                            Showing all generated reports
                        </div>
                        <button onclick="closeSystemReportsModal()" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-medium transition-all">
                            Close
                        </button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            
            // Load reports
            loadSystemReports();
        }

        function closeSystemReportsModal() {
            const modal = document.getElementById('systemReportsModal');
            if (modal) {
                modal.remove();
            }
        }

        async function loadSystemReports() {
            try {
                const response = await fetch('/admin/reports', {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) throw new Error('Failed to load reports');

                const data = await response.json();
                displaySystemReports(data);
            } catch (error) {
                console.error('Error loading system reports:', error);
                const container = document.getElementById('modalSystemReportsContent');
                if (container) {
                    container.innerHTML = `
                        <div class="text-center py-12">
                            <i class="fas fa-exclamation-triangle text-red-300 text-6xl mb-4"></i>
                            <p class="text-red-500 text-lg">Failed to load reports</p>
                        </div>
                    `;
                }
            }
        }

        function displaySystemReports(data) {
            const container = document.getElementById('modalSystemReportsContent');
            
            if (!container) return;
            
            if (!data.reports || !data.reports.data || data.reports.data.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-12">
                        <i class="fas fa-chart-line text-gray-300 text-6xl mb-4"></i>
                        <p class="text-gray-500 text-lg mb-4">No reports generated yet</p>
                        <button onclick="generateReportManually()" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-lg font-medium transition-all shadow-lg">
                            <i class="fas fa-plus mr-2"></i>Generate First Report
                        </button>
                    </div>
                `;
                return;
            }

            const reportsHtml = data.reports.data.map(report => {
                const weekStart = new Date(report.week_start_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
                const weekEnd = new Date(report.week_end_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                
                return `
                    <div class="bg-white rounded-xl shadow-lg p-6 mb-4 hover:shadow-xl transition-all border border-gray-200">
                        <!-- Header -->
                        <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-200">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">
                                    <i class="fas fa-calendar-week text-indigo-600 mr-2"></i>
                                    ${weekStart} - ${weekEnd}
                                </h3>
                                <p class="text-sm text-gray-500 mt-1">Report ID: #${report.id}</p>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-500">Generated</div>
                                <div class="text-sm font-medium text-gray-700">${new Date(report.created_at).toLocaleDateString()}</div>
                            </div>
                        </div>

                        <!-- Stats Grid -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                            <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                                <div class="flex items-center justify-between mb-2">
                                    <i class="fas fa-users text-blue-600 text-xl"></i>
                                    <span class="text-2xl font-bold text-blue-600">${report.total_new_users}</span>
                                </div>
                                <div class="text-xs text-gray-600">New Users</div>
                            </div>

                            <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                                <div class="flex items-center justify-between mb-2">
                                    <i class="fas fa-briefcase text-green-600 text-xl"></i>
                                    <span class="text-2xl font-bold text-green-600">${report.total_jobs_posted}</span>
                                </div>
                                <div class="text-xs text-gray-600">Jobs Posted</div>
                            </div>

                            <div class="bg-purple-50 rounded-lg p-4 border border-purple-200">
                                <div class="flex items-center justify-between mb-2">
                                    <i class="fas fa-file-alt text-purple-600 text-xl"></i>
                                    <span class="text-2xl font-bold text-purple-600">${report.total_applications}</span>
                                </div>
                                <div class="text-xs text-gray-600">Applications</div>
                            </div>

                            <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-200">
                                <div class="flex items-center justify-between mb-2">
                                    <i class="fas fa-user-check text-yellow-600 text-xl"></i>
                                    <span class="text-2xl font-bold text-yellow-600">${report.total_workers_hired}</span>
                                </div>
                                <div class="text-xs text-gray-600">Workers Hired</div>
                            </div>
                        </div>

                        <!-- Financial & Activity Stats -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg p-4 border border-green-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-sm text-gray-600 mb-1">Total Revenue</div>
                                        <div class="text-2xl font-bold text-green-600">UGX ${Number(report.total_revenue).toLocaleString()}</div>
                                    </div>
                                    <i class="fas fa-money-bill-wave text-green-600 text-3xl"></i>
                                </div>
                            </div>

                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4 border border-blue-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-sm text-gray-600 mb-1">Transactions</div>
                                        <div class="text-2xl font-bold text-blue-600">${report.total_transactions}</div>
                                    </div>
                                    <i class="fas fa-exchange-alt text-blue-600 text-3xl"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Top Performers -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-orange-50 rounded-lg p-4 border border-orange-200">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-trophy text-orange-600 mr-2"></i>
                                    <span class="text-sm font-semibold text-gray-700">Most Active Employer</span>
                                </div>
                                <div class="text-lg font-bold text-gray-900">${report.most_active_employer || 'N/A'}</div>
                            </div>

                            <div class="bg-pink-50 rounded-lg p-4 border border-pink-200">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-star text-pink-600 mr-2"></i>
                                    <span class="text-sm font-semibold text-gray-700">Most Active Worker</span>
                                </div>
                                <div class="text-lg font-bold text-gray-900">${report.most_active_worker || 'N/A'}</div>
                            </div>
                        </div>

                        ${report.system_errors > 0 ? `
                            <div class="mt-4 bg-red-50 border border-red-200 rounded-lg p-3">
                                <div class="flex items-center text-red-700">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                    <span class="text-sm font-medium">${report.system_errors} system errors detected this week</span>
                                </div>
                            </div>
                        ` : ''}

                        <!-- Action Buttons -->
                        <div class="mt-4 pt-4 border-t border-gray-200 flex gap-3">
                            <a href="/admin/reports/${report.id}/pdf" target="_blank" class="flex-1 px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-lg text-center font-medium transition-all shadow-lg">
                                <i class="fas fa-eye mr-2"></i>View PDF
                            </a>
                            <a href="/admin/reports/${report.id}/download" class="flex-1 px-4 py-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white rounded-lg text-center font-medium transition-all shadow-lg">
                                <i class="fas fa-download mr-2"></i>Download PDF
                            </a>
                        </div>
                    </div>
                `;
            }).join('');

            container.innerHTML = reportsHtml;
        }

        async function generateReportManually() {
            if (!confirm('Generate a new weekly report? This will create a report for the most recent completed week.')) {
                return;
            }

            showNotification('Generating report...', 'info');

            try {
                const response = await fetch('/admin/reports/generate', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    showNotification('✅ Report generated successfully!', 'success');
                    loadSystemReports(); // Reload reports
                } else {
                    showNotification('❌ Failed to generate report', 'error');
                }
            } catch (error) {
                console.error('Error generating report:', error);
                showNotification('❌ Error generating report', 'error');
            }
        }
    </script>

    <!-- Profile Picture Viewing Modal -->
    <div id="profile-picture-modal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 backdrop-blur-sm">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="profile-picture-content">
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-user text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900" id="profile-modal-name">User Profile</h3>
                                <p class="text-sm text-gray-500" id="profile-modal-role">Role</p>
                            </div>
                        </div>
                        <button onclick="closeProfilePictureModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    <!-- Profile Picture -->
                    <div class="text-center mb-6">
                        <div class="relative inline-block">
                            <img id="profile-modal-image" 
                                 class="w-64 h-64 rounded-2xl object-cover shadow-lg border-4 border-white" 
                                 src="" 
                                 alt="Profile Picture">
                            <div class="absolute inset-0 rounded-2xl bg-gradient-to-t from-black/20 to-transparent"></div>
                        </div>
                    </div>

                    <!-- User Info -->
                    <div class="bg-gradient-to-r from-gray-50 to-blue-50 rounded-xl p-4 mb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Account Type</p>
                                <p class="font-semibold text-gray-800" id="profile-modal-account-type">Worker</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600">Status</p>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-circle mr-1 text-xs"></i>Active
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex space-x-3">
                        <button onclick="downloadProfilePicture()" class="flex-1 px-4 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-download mr-2"></i>Download
                        </button>
                        <button onclick="closeProfilePictureModal()" class="flex-1 px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200">
                            <i class="fas fa-times mr-2"></i>Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>


            </div>
        </div>
    </div>

    <!-- Messages Modal -->
    <div id="messagesModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-6xl max-h-[95vh] flex flex-col overflow-hidden">
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200 flex-shrink-0">
                    <div class="flex items-center">
                        <i class="fas fa-comments text-blue-600 text-2xl mr-3"></i>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Admin Messages & Support</h2>
                            <p class="text-sm text-gray-500">Manage user conversations and send broadcasts</p>
                        </div>
                    </div>
                    <button onclick="closeMessagesModal()" class="text-gray-400 hover:text-gray-600 text-2xl">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- Inline Notification Area -->
                <div id="modal-notification-area" class="hidden px-6 py-3 border-b border-gray-200 flex-shrink-0">
                    <div id="modal-notification" class="p-3 rounded-lg border flex items-center justify-between">
                        <div class="flex items-center">
                            <i id="modal-notification-icon" class="mr-2"></i>
                            <span id="modal-notification-message" class="text-sm font-medium"></span>
                        </div>
                        <button onclick="hideModalNotification()" class="text-lg font-bold ml-4">&times;</button>
                    </div>
                </div>

                <!-- Modal Content - Scrollable -->
                <div class="flex-1 overflow-y-auto">
                    <!-- Messages Statistics Cards -->
                    <div class="p-6 border-b border-gray-200 flex-shrink-0">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-blue-600 font-medium">Total Messages</p>
                                        <p class="text-2xl font-bold text-blue-800" id="modal-total-messages">0</p>
                                    </div>
                                    <i class="fas fa-envelope text-blue-500 text-xl"></i>
                                </div>
                            </div>
                            
                            <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-red-600 font-medium">Unread Messages</p>
                                        <p class="text-2xl font-bold text-red-800" id="modal-unread-messages">0</p>
                                    </div>
                                    <i class="fas fa-envelope-open text-red-500 text-xl"></i>
                                </div>
                            </div>
                            
                            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-green-600 font-medium">Today's Messages</p>
                                        <p class="text-2xl font-bold text-green-800" id="modal-messages-today">0</p>
                                    </div>
                                    <i class="fas fa-calendar-day text-green-500 text-xl"></i>
                                </div>
                            </div>
                            
                            <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-purple-600 font-medium">Response Time</p>
                                        <p class="text-2xl font-bold text-purple-800">2.4h</p>
                                    </div>
                                    <i class="fas fa-clock text-purple-500 text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Messages Interface -->
                    <div class="flex flex-col lg:flex-row min-h-[500px]">
                        <!-- Conversations List -->
                        <div class="w-full lg:w-1/3 border-b lg:border-b-0 lg:border-r border-gray-200 flex flex-col">
                            <div class="p-4 border-b border-gray-200 flex-shrink-0">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="text-lg font-semibold text-gray-800">Conversations</h3>
                                    <button onclick="refreshModalMessages()" class="text-blue-600 hover:text-blue-800 p-1">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </div>
                                <div class="relative">
                                    <input type="text" id="modal-message-search" placeholder="Search conversations..." 
                                           class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    <i class="fas fa-search absolute left-2.5 top-2.5 text-gray-400 text-sm"></i>
                                </div>
                            </div>
                            
                            <div id="modal-conversations-list" class="flex-1 overflow-y-auto p-2" style="max-height: 400px;">
                                <!-- Sample conversation -->
                                <div class="conversation-item p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-blue-50 transition-colors mb-2 bg-white">
                                    <div class="flex items-start">
                                        <img class="h-10 w-10 rounded-full mr-3 flex-shrink-0" 
                                             src="https://ui-avatars.com/api/?name=Test+User&background=1e40af&color=ffffff" 
                                             alt="Test User">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between mb-1">
                                                <h4 class="font-semibold text-gray-900 text-sm truncate">Sample User</h4>
                                                <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded-full">New</span>
                                            </div>
                                            <p class="text-xs text-gray-500 mb-1">
                                                <i class="fas fa-user mr-1"></i>Worker
                                            </p>
                                            <p class="text-sm text-gray-600 truncate">Hello admin, I need help...</p>
                                            <p class="text-xs text-gray-400 mt-1">Just now</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-center text-gray-500 py-8">
                                    <i class="fas fa-comments text-3xl mb-3"></i>
                                    <p class="font-medium">Loading conversations...</p>
                                    <p class="text-sm">User messages will appear here</p>
                                </div>
                            </div>
                        </div>

                        <!-- Chat Area -->
                        <div class="flex-1 flex flex-col min-h-[500px]">
                            <!-- Chat Header -->
                            <div id="modal-chat-header" class="p-4 border-b border-gray-200 bg-gray-50 flex-shrink-0" style="display: none;">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <img id="modal-chat-user-avatar" class="h-10 w-10 rounded-full mr-3" src="" alt="">
                                        <div>
                                            <h4 id="modal-chat-user-name" class="font-semibold text-gray-800"></h4>
                                            <p id="modal-chat-user-role" class="text-sm text-gray-500"></p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <button onclick="viewModalUserProfile()" class="text-blue-600 hover:text-blue-800 p-2 rounded" title="View Profile">
                                            <i class="fas fa-user"></i>
                                        </button>
                                        <button onclick="markModalConversationAsRead()" class="text-green-600 hover:text-green-800 p-2 rounded" title="Mark as Read">
                                            <i class="fas fa-check-double"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Messages Container -->
                            <div id="modal-messages-container" class="flex-1 overflow-y-auto p-4 bg-gray-50" style="min-height: 300px; max-height: 400px;">
                                <div class="text-center text-gray-500 mt-20">
                                    <i class="fas fa-comment-dots text-6xl mb-4 text-gray-300"></i>
                                    <p class="text-lg font-medium">Select a conversation to start messaging</p>
                                    <p class="text-sm">Help users by responding to their questions and concerns</p>
                                </div>
                            </div>

                            <!-- Message Input Area -->
                            <div id="modal-message-input-area" class="p-4 border-t border-gray-200 bg-white flex-shrink-0" style="display: none;">
                                <div class="flex items-center space-x-3 mb-3">
                                    <input type="text" id="modal-message-input" placeholder="Type your message..." 
                                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                    <button onclick="sendModalMessage()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                        <i class="fas fa-paper-plane mr-1"></i>Send
                                    </button>
                                </div>
                                
                                <!-- Quick Reply Buttons -->
                                <div class="flex flex-wrap gap-2">
                                    <button onclick="sendModalQuickReply('Thank you for contacting us. How can I help you today?')" 
                                            class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full hover:bg-blue-200 transition">
                                        <i class="fas fa-smile mr-1"></i>Greeting
                                    </button>
                                    <button onclick="sendModalQuickReply('I will look into this issue and get back to you shortly.')" 
                                            class="text-xs bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full hover:bg-yellow-200 transition">
                                        <i class="fas fa-search mr-1"></i>Investigation
                                    </button>
                                    <button onclick="sendModalQuickReply('Thank you for your patience. This issue has been resolved.')" 
                                            class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full hover:bg-green-200 transition">
                                        <i class="fas fa-check mr-1"></i>Resolution
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Broadcast Section -->
                    <div class="border-t border-gray-200 p-6 bg-gray-50 flex-shrink-0">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">
                                <i class="fas fa-bullhorn mr-2 text-red-500"></i>
                                Broadcast Message
                            </h3>
                            <button onclick="toggleBroadcastSection()" class="text-blue-600 hover:text-blue-800 text-sm">
                                <i class="fas fa-chevron-down mr-1" id="broadcast-toggle-icon"></i>
                                <span id="broadcast-toggle-text">Show Broadcast</span>
                            </button>
                        </div>
                        
                        <div id="broadcast-section" class="hidden">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Target Audience</label>
                                    <select id="modal-broadcast-audience" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                                        <option value="all">All Users</option>
                                        <option value="workers">Workers Only</option>
                                        <option value="employers">Employers Only</option>
                                        <option value="new_users">New Users (Last 30 days)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Message Type</label>
                                    <select id="modal-broadcast-type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                                        <option value="announcement">📢 Announcement</option>
                                        <option value="maintenance">🔧 Maintenance Notice</option>
                                        <option value="feature">✨ New Feature</option>
                                        <option value="promotion">🎉 Promotion</option>
                                    </select>
                                </div>
                                <div class="flex items-end">
                                    <button onclick="sendModalBroadcast()" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition text-sm">
                                        <i class="fas fa-bullhorn mr-1"></i>Send Broadcast
                                    </button>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Message Content</label>
                                <textarea id="modal-broadcast-message" rows="3" placeholder="Enter your broadcast message..." 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm"></textarea>
                            </div>
                            
                            <div class="flex items-center space-x-4">
                                <label class="flex items-center">
                                    <input type="checkbox" id="modal-broadcast-email" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">
                                        <i class="fas fa-envelope mr-1"></i>Also send via email
                                    </span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" id="modal-broadcast-urgent" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                    <span class="ml-2 text-sm text-gray-700">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>Mark as urgent
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Management Modal -->
    <div id="userManagementModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-7xl max-h-[95vh] flex flex-col overflow-hidden ripple-container">
                <!-- Ripple Effects -->
                <div class="ripple"></div>
                <div class="ripple"></div>
                <div class="ripple"></div>
                <div class="ripple"></div>
                
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200 flex-shrink-0" style="position: relative; z-index: 2; background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px);">
                    <div class="flex items-center">
                        <i class="fas fa-users text-green-600 text-2xl mr-3"></i>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">User Management</h2>
                            <p class="text-sm text-gray-500">Manage users, view profiles, and handle suspensions</p>
                        </div>
                    </div>
                    <button onclick="closeUserManagementModal()" class="text-gray-400 hover:text-gray-600 text-2xl">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- Inline Notification Area -->
                <div id="user-notification-area" class="hidden px-6 py-3 border-b border-gray-200 flex-shrink-0" style="position: relative; z-index: 2;">
                    <div id="user-notification" class="p-3 rounded-lg border flex items-center justify-between">
                        <div class="flex items-center">
                            <i id="user-notification-icon" class="mr-2"></i>
                            <span id="user-notification-message" class="text-sm font-medium"></span>
                        </div>
                        <button onclick="hideUserNotification()" class="text-lg font-bold ml-4">&times;</button>
                    </div>
                </div>

                <!-- Modal Content - Scrollable -->
                <div class="flex-1 overflow-y-auto" style="position: relative; z-index: 2;">
                    <!-- User Statistics Cards -->
                    <div class="p-6 border-b border-gray-200 flex-shrink-0">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-blue-600 font-medium">Total Workers</p>
                                        <p class="text-2xl font-bold text-blue-800" id="modal-total-workers">{{ number_format($stats['total_workers']) }}</p>
                                    </div>
                                    <i class="fas fa-user text-blue-500 text-xl"></i>
                                </div>
                            </div>
                            
                            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-green-600 font-medium">Total Employers</p>
                                        <p class="text-2xl font-bold text-green-800" id="modal-total-employers">{{ number_format($stats['total_employers']) }}</p>
                                    </div>
                                    <i class="fas fa-building text-green-500 text-xl"></i>
                                </div>
                            </div>
                            
                            <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-red-600 font-medium">Suspended Users</p>
                                        <p class="text-2xl font-bold text-red-800" id="modal-suspended-users">{{ number_format($stats['suspended_users']) }}</p>
                                    </div>
                                    <i class="fas fa-user-slash text-red-500 text-xl"></i>
                                </div>
                            </div>
                            
                            <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-purple-600 font-medium">New Today</p>
                                        <p class="text-2xl font-bold text-purple-800" id="modal-new-users-today">{{ number_format($stats['new_users_today']) }}</p>
                                    </div>
                                    <i class="fas fa-user-plus text-purple-500 text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Management Tools -->
                    <div class="p-6">
                        <div class="bg-white rounded-lg shadow-md mb-6">
                            <div class="p-6 border-b border-gray-200">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-xl font-semibold text-gray-800">User Management Tools</h3>
                                    <div class="flex space-x-2">
                                        <button onclick="bulkUserAction()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                            <i class="fas fa-tasks mr-2"></i>Bulk Actions
                                        </button>
                                        <button onclick="exportUsers()" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                                            <i class="fas fa-download mr-2"></i>Export
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Advanced Filters -->
                            <div class="p-6 border-b border-gray-200 bg-gray-50">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Search Users</label>
                                        <input type="text" id="user-search" placeholder="Name, email, phone..." 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                                        <select id="user-role-filter" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">All Roles</option>
                                            <option value="worker">Workers</option>
                                            <option value="employer">Employers</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                        <select id="user-status-filter" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">All Status</option>
                                            <option value="active">Active</option>
                                            <option value="suspended">Suspended</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Actions</label>
                                        <button onclick="applyUserFilters()" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                            <i class="fas fa-filter mr-2"></i>Apply Filters
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Users Table -->
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                <input type="checkbox" id="select-all-users" class="rounded border-gray-300">
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activity</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="users-table-body" class="bg-white divide-y divide-gray-200">
                                        @foreach($recentUsers->take(10) as $user)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <input type="checkbox" class="user-checkbox rounded border-gray-300" value="{{ $user->id }}">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <img class="h-8 w-8 rounded-full cursor-pointer hover:ring-2 hover:ring-blue-500 transition-all duration-200" 
                                                             src="{{ $user->getProfilePictureUrl() }}" 
                                                             alt="{{ $user->name }}"
                                                             onclick="viewUserProfilePicture('{{ $user->getProfilePictureUrl() }}', '{{ $user->name }}', '{{ $user->role }}')"
                                                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=ffffff&background=1e40af&size=150'">
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role === 'worker' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                                        {{ ucfirst($user->role) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $user->created_at->format('M d, Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Active
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $user->applications->count() }} apps / {{ $user->jobs->count() }} jobs
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <button onclick="viewUserDetails({{ $user->id }})" class="text-blue-600 hover:text-blue-900 mr-3">
                                                        <i class="fas fa-eye mr-1"></i>View
                                                    </button>
                                                    <button onclick="suspendUser({{ $user->id }})" class="text-red-600 hover:text-red-900">
                                                        <i class="fas fa-user-slash mr-1"></i>Suspend
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Job Management Modal -->
    <div id="jobManagementModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-7xl max-h-[95vh] flex flex-col overflow-hidden">
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200 flex-shrink-0">
                    <div class="flex items-center">
                        <i class="fas fa-briefcase text-orange-600 text-2xl mr-3"></i>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Job Management</h2>
                            <p class="text-sm text-gray-500">Manage job postings, approvals, and monitoring</p>
                        </div>
                    </div>
                    <button onclick="closeJobManagementModal()" class="text-gray-400 hover:text-gray-600 text-2xl">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- Inline Notification Area -->
                <div id="job-notification-area" class="hidden px-6 py-3 border-b border-gray-200 flex-shrink-0">
                    <div id="job-notification" class="p-3 rounded-lg border flex items-center justify-between">
                        <div class="flex items-center">
                            <i id="job-notification-icon" class="mr-2"></i>
                            <span id="job-notification-message" class="text-sm font-medium"></span>
                        </div>
                        <button onclick="hideJobNotification()" class="text-lg font-bold ml-4">&times;</button>
                    </div>
                </div>

                <!-- Modal Content - Scrollable -->
                <div class="flex-1 overflow-y-auto">
                    <!-- Job Statistics Cards -->
                    <div class="p-6 border-b border-gray-200 flex-shrink-0">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-blue-600 font-medium">Total Jobs</p>
                                        <p class="text-2xl font-bold text-blue-800">{{ number_format($stats['total_jobs']) }}</p>
                                    </div>
                                    <i class="fas fa-briefcase text-blue-500 text-xl"></i>
                                </div>
                            </div>
                            
                            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-green-600 font-medium">Active Jobs</p>
                                        <p class="text-2xl font-bold text-green-800">{{ number_format($stats['active_jobs']) }}</p>
                                    </div>
                                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                                </div>
                            </div>
                            
                            <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-yellow-600 font-medium">Pending Approval</p>
                                        <p class="text-2xl font-bold text-yellow-800">{{ number_format($stats['pending_jobs']) }}</p>
                                    </div>
                                    <i class="fas fa-clock text-yellow-500 text-xl"></i>
                                </div>
                            </div>
                            
                            <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-purple-600 font-medium">Posted Today</p>
                                        <p class="text-2xl font-bold text-purple-800">{{ number_format($stats['new_jobs_today']) }}</p>
                                    </div>
                                    <i class="fas fa-plus-circle text-purple-500 text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Job Management Content -->
                    <div class="p-6">
                        @if($pendingJobs->count() > 0)
                            <div class="bg-white rounded-lg shadow-md mb-6">
                                <div class="p-6 border-b border-gray-200">
                                    <h3 class="text-xl font-semibold text-gray-800">Jobs Pending Approval</h3>
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job Title</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employer</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Budget</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posted</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($pendingJobs as $job)
                                                <tr>
                                                    <td class="px-6 py-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $job->title }}</div>
                                                        <div class="text-sm text-gray-500">{{ \Illuminate\Support\Str::limit($job->description, 60) }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        {{ $job->employer->name }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        UGX {{ number_format($job->budget) }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $job->created_at->diffForHumans() }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                        <button onclick="approveJob({{ $job->id }})" class="text-green-600 hover:text-green-900 mr-3">
                                                            <i class="fas fa-check mr-1"></i>Approve
                                                        </button>
                                                        <button onclick="rejectJob({{ $job->id }})" class="text-red-600 hover:text-red-900">
                                                            <i class="fas fa-times mr-1"></i>Reject
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        <div class="bg-white rounded-lg shadow-md">
                            <div class="p-6 border-b border-gray-200">
                                <h3 class="text-xl font-semibold text-gray-800">Recent Job Postings</h3>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employer</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applications</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($recentJobs->take(10) as $job)
                                            <tr>
                                                <td class="px-6 py-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $job->title }}</div>
                                                    <div class="text-sm text-gray-500">{{ $job->location }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $job->employer->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $job->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                        {{ ucfirst($job->status) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $job->applications_count }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <button onclick="viewJobDetails({{ $job->id }})" class="text-blue-600 hover:text-blue-900 font-medium">
                                                        <i class="fas fa-eye mr-1"></i>View
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Job Details Modal -->
    <div id="jobDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col overflow-hidden transform transition-all">
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-blue-600 to-purple-600">
                    <div class="flex items-center text-white">
                        <i class="fas fa-briefcase text-2xl mr-3"></i>
                        <div>
                            <h2 class="text-2xl font-bold">Job Details</h2>
                            <p class="text-sm text-blue-100">Complete job information</p>
                        </div>
                    </div>
                    <button onclick="closeJobDetailsModal()" class="text-white hover:text-gray-200 transition p-2 hover:bg-white/10 rounded-lg">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="flex-1 overflow-y-auto p-6">
                    <div id="jobDetailsContent">
                        <div class="flex items-center justify-center py-12">
                            <i class="fas fa-spinner fa-spin text-4xl text-blue-600"></i>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex items-center justify-between p-6 border-t border-gray-200 bg-gray-50">
                    <div class="flex items-center gap-3">
                        <button onclick="exportJobDetails()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            <i class="fas fa-download mr-2"></i>Export
                        </button>
                        <button onclick="printJobDetails()" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                            <i class="fas fa-print mr-2"></i>Print
                        </button>
                    </div>
                    <button onclick="closeJobDetailsModal()" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Modal -->
    <div id="analyticsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-7xl max-h-[95vh] flex flex-col overflow-hidden">
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200 flex-shrink-0">
                    <div class="flex items-center">
                        <i class="fas fa-chart-bar text-purple-600 text-2xl mr-3"></i>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Analytics & Reports</h2>
                            <p class="text-sm text-gray-500">Platform insights, trends, and performance metrics</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button onclick="testAnalyticsLoad()" class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700 transition">
                            <i class="fas fa-bug mr-1"></i>Debug Test
                        </button>
                        <button onclick="closeAnalyticsModal()" class="text-gray-400 hover:text-gray-600 text-2xl">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <!-- Inline Notification Area -->
                <div id="analytics-notification-area" class="hidden px-6 py-3 border-b border-gray-200 flex-shrink-0">
                    <div id="analytics-notification" class="p-3 rounded-lg border flex items-center justify-between">
                        <div class="flex items-center">
                            <i id="analytics-notification-icon" class="mr-2"></i>
                            <span id="analytics-notification-message" class="text-sm font-medium"></span>
                        </div>
                        <button onclick="hideAnalyticsNotification()" class="text-lg font-bold ml-4">&times;</button>
                    </div>
                </div>

                <!-- Modal Content - Scrollable -->
                <div class="flex-1 overflow-y-auto">
                    <!-- Key Metrics Cards -->
                    <div class="p-6 border-b border-gray-200 flex-shrink-0">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-green-600 font-medium">Growth Rate</p>
                                        <p class="text-2xl font-bold text-green-800">+12.5%</p>
                                    </div>
                                    <i class="fas fa-chart-line text-green-500 text-xl"></i>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">vs last month</p>
                            </div>
                            
                            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-blue-600 font-medium">Success Rate</p>
                                        <p class="text-2xl font-bold text-blue-800">68.3%</p>
                                    </div>
                                    <i class="fas fa-bullseye text-blue-500 text-xl"></i>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">job completion rate</p>
                            </div>
                            
                            <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-purple-600 font-medium">Avg. Response</p>
                                        <p class="text-2xl font-bold text-purple-800">2.4h</p>
                                    </div>
                                    <i class="fas fa-clock text-purple-500 text-xl"></i>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">application response time</p>
                            </div>
                            
                            <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-yellow-600 font-medium">Revenue</p>
                                        <p class="text-2xl font-bold text-yellow-800">UGX 2.4M</p>
                                    </div>
                                    <i class="fas fa-money-bill-wave text-yellow-500 text-xl"></i>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">this month</p>
                            </div>
                        </div>
                    </div>

                    <!-- Charts and Analytics Content -->
                    <div class="p-6">
                        <!-- Current Date Display -->
                        <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg border border-blue-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Analytics Dashboard</h3>
                                    <p class="text-sm text-gray-600">Real-time insights and performance metrics</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-blue-800" id="current-date"></div>
                                    <div class="text-sm text-gray-600" id="current-time"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Main Charts Grid -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                            <!-- User Growth Pie Chart -->
                            <div class="bg-white p-6 rounded-lg shadow-md">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-800">User Growth Trends</h3>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm text-gray-500">Growth Rate:</span>
                                        <span class="text-sm font-bold text-green-600" id="user-growth-rate">+0%</span>
                                    </div>
                                </div>
                                <div class="relative" style="height: 320px;">
                                    <canvas id="userGrowthPieChart" width="400" height="320"></canvas>
                                </div>
                                <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                                    <div class="text-sm text-blue-800 font-medium" id="user-growth-annotation">
                                        Loading insights...
                                    </div>
                                </div>
                            </div>

                            <!-- Job Posting Donut Chart -->
                            <div class="bg-white p-6 rounded-lg shadow-md">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-800">Job Posting Trends</h3>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm text-gray-500">Success Rate:</span>
                                        <span class="text-sm font-bold text-green-600" id="job-success-rate">0%</span>
                                    </div>
                                </div>
                                <div class="relative" style="height: 320px;">
                                    <canvas id="jobTrendsDonutChart" width="400" height="320"></canvas>
                                </div>
                                <div class="mt-4 p-3 bg-green-50 rounded-lg">
                                    <div class="text-sm text-green-800 font-medium" id="job-trends-annotation">
                                        Loading insights...
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Performance Metrics -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                            <!-- Monthly Performance Chart -->
                            <div class="bg-white p-6 rounded-lg shadow-md">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-chart-line mr-2 text-blue-600"></i>
                                    Monthly Performance Trends
                                </h3>
                                <div class="relative" style="height: 300px;">
                                    <canvas id="monthlyPerformanceChart"></canvas>
                                </div>
                                <div class="mt-4 grid grid-cols-3 gap-2 text-center">
                                    <div class="p-2 bg-blue-50 rounded">
                                        <div class="text-xs text-gray-600">Best Users</div>
                                        <div class="text-sm font-bold text-blue-600" id="best-user-month-summary">-</div>
                                    </div>
                                    <div class="p-2 bg-green-50 rounded">
                                        <div class="text-xs text-gray-600">Best Jobs</div>
                                        <div class="text-sm font-bold text-green-600" id="best-job-month-summary">-</div>
                                    </div>
                                    <div class="p-2 bg-yellow-50 rounded">
                                        <div class="text-xs text-gray-600">Best Revenue</div>
                                        <div class="text-sm font-bold text-yellow-600" id="best-revenue-month-summary">-</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Activity Insights Chart -->
                            <div class="bg-white p-6 rounded-lg shadow-md">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-chart-area mr-2 text-purple-600"></i>
                                    Activity Insights Over Time
                                </h3>
                                <div class="relative" style="height: 300px;">
                                    <canvas id="activityInsightsChart"></canvas>
                                </div>
                                <div class="mt-4 grid grid-cols-3 gap-2 text-center">
                                    <div class="p-2 bg-purple-50 rounded">
                                        <div class="text-xs text-gray-600">Peak Month</div>
                                        <div class="text-sm font-bold text-purple-600" id="peak-activity-summary">-</div>
                                    </div>
                                    <div class="p-2 bg-blue-50 rounded">
                                        <div class="text-xs text-gray-600">Avg. Daily</div>
                                        <div class="text-sm font-bold text-blue-600" id="avg-daily-summary">0</div>
                                    </div>
                                    <div class="p-2 bg-green-50 rounded">
                                        <div class="text-xs text-gray-600">Conversion</div>
                                        <div class="text-sm font-bold text-green-600" id="conversion-rate-summary">0%</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                <button onclick="testAnalyticsLoad()" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                                    <i class="fas fa-bug mr-2"></i>Test Load
                                </button>
                                <button onclick="generateMonthlyReport()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                    <i class="fas fa-file-alt mr-2"></i>Report
                                </button>
                                <button onclick="exportAnalyticsData()" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                                    <i class="fas fa-download mr-2"></i>Export
                                </button>
                                <button onclick="refreshAnalytics()" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                                    <i class="fas fa-sync-alt mr-2"></i>Refresh
                                </button>
                            </div>
                        </div>

                        <!-- Detailed Performance Tables -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Employer Performance -->
                            <div class="bg-white p-6 rounded-lg shadow-md">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Top Employers Performance</h3>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employer</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jobs Posted</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Success Rate</th>
                                            </tr>
                                        </thead>
                                        <tbody id="employer-performance-table" class="bg-white divide-y divide-gray-200">
                                            <!-- Data will be loaded here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Worker Performance -->
                            <div class="bg-white p-6 rounded-lg shadow-md">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Top Workers Performance</h3>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Worker</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Applications</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Success Rate</th>
                                            </tr>
                                        </thead>
                                        <tbody id="worker-performance-table" class="bg-white divide-y divide-gray-200">
                                            <!-- Data will be loaded here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Monthly Report Generation Modal -->
                        <div id="monthlyReportModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
                            <div class="flex items-center justify-center min-h-screen p-4">
                                <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                                    <div class="p-6 border-b border-gray-200">
                                        <h3 class="text-lg font-semibold text-gray-800">Generate Monthly Report</h3>
                                    </div>
                                    <div class="p-6">
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Month</label>
                                            <select id="report-month" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                                <!-- Options will be populated by JavaScript -->
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Report Type</label>
                                            <select id="report-type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                                <option value="comprehensive">Comprehensive Report</option>
                                                <option value="employers">Employers Performance</option>
                                                <option value="workers">Workers Performance</option>
                                                <option value="financial">Financial Summary</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                                        <button onclick="closeMonthlyReportModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800">Cancel</button>
                                        <button onclick="executeMonthlyReport()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Generate Report</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Setup CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Global variables for charts
        let userGrowthPieChart = null;
        let jobTrendsDonutChart = null;

        // Advanced Admin Functions

        function refreshData() {
            showNotification('Refreshing data...', 'info');
            setTimeout(() => {
                location.reload();
            }, 1000);
        }

        // Database Backup Function
        function initiateBackup() {
            // Show modern confirmation modal
            showBackupConfirmationModal();
        }

        function showBackupConfirmationModal() {
            // Create modern modal
            const modal = document.createElement('div');
            modal.id = 'backup-confirmation-modal';
            modal.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm';
            modal.innerHTML = `
                <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="backup-modal-content">
                    <div class="p-6">
                        <!-- Header -->
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Database Backup</h3>
                                <p class="text-sm text-gray-500">System maintenance operation</p>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="mb-6">
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4 mb-4 border border-blue-200">
                                <h4 class="font-semibold text-blue-900 mb-2 flex items-center">
                                    <i class="fas fa-database mr-2"></i>Data to be backed up:
                                </h4>
                                <ul class="text-sm text-blue-800 space-y-1">
                                    <li class="flex items-center"><i class="fas fa-users w-4 mr-2"></i>All users and profiles</li>
                                    <li class="flex items-center"><i class="fas fa-briefcase w-4 mr-2"></i>Job postings and applications</li>
                                    <li class="flex items-center"><i class="fas fa-comments w-4 mr-2"></i>Messages and conversations</li>
                                    <li class="flex items-center"><i class="fas fa-credit-card w-4 mr-2"></i>Payment records</li>
                                    <li class="flex items-center"><i class="fas fa-cog w-4 mr-2"></i>System settings</li>
                                </ul>
                            </div>

                            <div class="bg-gradient-to-r from-amber-50 to-yellow-50 rounded-lg p-4 border border-amber-200">
                                <div class="flex items-center text-amber-800">
                                    <i class="fas fa-clock mr-2 text-amber-600"></i>
                                    <span class="font-medium">This process may take several minutes</span>
                                </div>
                                <p class="text-sm text-amber-700 mt-1">Please do not close this window during the backup process.</p>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex space-x-3">
                            <button onclick="cancelBackup()" class="flex-1 px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-times mr-2"></i>Cancel
                            </button>
                            <button onclick="confirmBackup()" class="flex-1 px-4 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg">
                                <i class="fas fa-shield-alt mr-2"></i>Start Backup
                            </button>
                        </div>
                    </div>
                </div>
            `;

            document.body.appendChild(modal);

            // Animate modal in
            setTimeout(() => {
                const content = document.getElementById('backup-modal-content');
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);

            // Close on backdrop click
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    cancelBackup();
                }
            });

            // Close on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    cancelBackup();
                }
            });
        }

        function cancelBackup() {
            const modal = document.getElementById('backup-confirmation-modal');
            if (modal) {
                const content = document.getElementById('backup-modal-content');
                content.classList.add('scale-95', 'opacity-0');
                content.classList.remove('scale-100', 'opacity-100');
                
                setTimeout(() => {
                    modal.remove();
                }, 300);
            }
        }

        function confirmBackup() {
            // Close modal first
            cancelBackup();
            
            // Start the actual backup process
            const backupButton = document.getElementById('backupButton');
            const originalText = backupButton.innerHTML;
            
            // Disable button and show loading state
            backupButton.disabled = true;
            backupButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Creating Backup...';
            backupButton.classList.remove('hover:bg-gray-600');
            backupButton.classList.add('opacity-75', 'cursor-not-allowed');

            // Show progress notification
            showNotification('🔄 Database backup initiated. Please wait...', 'info');

            // Make actual API call to create backup
            fetch('/admin/backup-database', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Success state
                    backupButton.innerHTML = '<i class="fas fa-check-circle mr-2"></i>Backup Complete!';
                    backupButton.classList.add('bg-green-600');
                    backupButton.classList.remove('bg-gray-500');

                    // Show success notification with real data
                    showNotification(
                        `✅ Database backup completed successfully!\n\n` +
                        `📁 Backup file: ${data.filename}\n` +
                        `📊 Tables backed up: ${data.tables_backed_up} tables\n` +
                        `💾 File size: ${data.file_size}\n` +
                        `🔐 Status: Encrypted and secured\n` +
                        `📍 Location: ${data.location}\n` +
                        `⏰ Created: ${data.timestamp}\n\n` +
                        `💡 Your system data is now safely backed up!`, 
                        'success'
                    );

                    // Log the successful backup
                    console.log('🛡️ DATABASE BACKUP SUCCESS:', data);

                    // Refresh backup list if we're on the settings page
                    const settingsContent = document.getElementById('settings-content');
                    if (settingsContent && !settingsContent.classList.contains('hidden')) {
                        setTimeout(() => {
                            refreshBackupList();
                        }, 1000);
                    }

                } else {
                    // Error state
                    backupButton.innerHTML = '<i class="fas fa-exclamation-triangle mr-2"></i>Backup Failed';
                    backupButton.classList.add('bg-red-600');
                    backupButton.classList.remove('bg-gray-500');

                    showNotification(
                        `❌ Database backup failed!\n\n` +
                        `Error: ${data.message}\n\n` +
                        `Please try again or contact system administrator.`, 
                        'error'
                    );

                    console.error('🚨 DATABASE BACKUP FAILED:', data);
                }

                // Reset button after 3 seconds
                setTimeout(() => {
                    backupButton.disabled = false;
                    backupButton.innerHTML = originalText;
                    backupButton.classList.remove('bg-green-600', 'bg-red-600', 'opacity-75', 'cursor-not-allowed');
                    backupButton.classList.add('bg-gray-500', 'hover:bg-gray-600');
                }, 3000);

            })
            .catch(error => {
                console.error('🚨 BACKUP API ERROR:', error);
                
                // Error state
                backupButton.innerHTML = '<i class="fas fa-exclamation-triangle mr-2"></i>Connection Error';
                backupButton.classList.add('bg-red-600');
                backupButton.classList.remove('bg-gray-500');

                showNotification(
                    `❌ Backup connection failed!\n\n` +
                    `Network error: ${error.message}\n\n` +
                    `Please check your connection and try again.`, 
                    'error'
                );

                // Reset button after 3 seconds
                setTimeout(() => {
                    backupButton.disabled = false;
                    backupButton.innerHTML = originalText;
                    backupButton.classList.remove('bg-red-600', 'opacity-75', 'cursor-not-allowed');
                    backupButton.classList.add('bg-gray-500', 'hover:bg-gray-600');
                }, 3000);
            });
        }

        // Notification system for backup feedback
        function showNotification(message, type) {
            // Create notification element if it doesn't exist
            let notification = document.getElementById('backup-notification');
            if (!notification) {
                notification = document.createElement('div');
                notification.id = 'backup-notification';
                notification.className = 'fixed top-4 right-4 z-50 max-w-md p-4 rounded-lg shadow-lg border';
                document.body.appendChild(notification);
            }

            // Set notification style based on type
            const styles = {
                info: 'bg-blue-50 border-blue-200 text-blue-800',
                success: 'bg-green-50 border-green-200 text-green-800',
                error: 'bg-red-50 border-red-200 text-red-800',
                warning: 'bg-yellow-50 border-yellow-200 text-yellow-800'
            };

            const icons = {
                info: 'fas fa-info-circle',
                success: 'fas fa-check-circle',
                error: 'fas fa-exclamation-triangle',
                warning: 'fas fa-exclamation-circle'
            };

            notification.className = `fixed top-4 right-4 z-50 max-w-md p-4 rounded-lg shadow-lg border ${styles[type] || styles.info}`;
            notification.innerHTML = `
                <div class="flex items-start">
                    <i class="${icons[type] || icons.info} mr-3 mt-1"></i>
                    <div class="flex-1">
                        <div class="font-medium text-sm whitespace-pre-line">${message}</div>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-3 text-lg font-bold">&times;</button>
                </div>
            `;

            // Auto-remove after delay (longer for success messages)
            const delay = type === 'success' ? 8000 : 5000;
            setTimeout(() => {
                if (notification && notification.parentNode) {
                    notification.remove();
                }
            }, delay);
        }

        // Backup Management Functions
        function refreshBackupList() {
            const loadingRow = document.getElementById('backup-loading');
            const backupList = document.getElementById('backup-list');
            const noBackupsDiv = document.getElementById('no-backups');
            const backupTable = document.getElementById('backup-table');
            
            // Show loading state
            loadingRow.style.display = 'table-row';
            noBackupsDiv.classList.add('hidden');
            backupTable.style.display = 'table';
            
            fetch('/admin/backups', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                loadingRow.style.display = 'none';
                
                if (data.success) {
                    updateBackupStats(data);
                    
                    if (data.backups && data.backups.length > 0) {
                        displayBackupList(data.backups);
                        backupTable.style.display = 'table';
                        noBackupsDiv.classList.add('hidden');
                    } else {
                        backupTable.style.display = 'none';
                        noBackupsDiv.classList.remove('hidden');
                    }
                } else {
                    showNotification('Failed to load backups: ' + data.message, 'error');
                    backupTable.style.display = 'none';
                    noBackupsDiv.classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('Error loading backups:', error);
                loadingRow.style.display = 'none';
                showNotification('Failed to load backups: ' + error.message, 'error');
                backupTable.style.display = 'none';
                noBackupsDiv.classList.remove('hidden');
            });
        }

        function updateBackupStats(data) {
            document.getElementById('backup-count').textContent = data.total_count || 0;
            document.getElementById('backup-total-size').textContent = data.total_size || '0 bytes';
            
            if (data.backups && data.backups.length > 0) {
                document.getElementById('backup-latest').textContent = data.backups[0].created_at_human || 'Never';
            } else {
                document.getElementById('backup-latest').textContent = 'Never';
            }
        }

        function displayBackupList(backups) {
            const backupList = document.getElementById('backup-list');
            
            // Clear existing rows except loading row
            const rows = backupList.querySelectorAll('tr:not(#backup-loading)');
            rows.forEach(row => row.remove());
            
            backups.forEach(backup => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50';
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <i class="fas fa-database text-blue-600 mr-2"></i>
                            <span class="text-sm font-medium text-gray-900">${backup.filename}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        ${backup.size}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        <div>
                            <div class="font-medium">${backup.created_at_human}</div>
                            <div class="text-xs text-gray-400">${backup.created_at}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <div class="flex space-x-2">
                            <button onclick="downloadBackup('${backup.filename}')" 
                                    class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition text-xs">
                                <i class="fas fa-download mr-1"></i>Download
                            </button>
                            <button onclick="deleteBackup('${backup.filename}')" 
                                    class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition text-xs">
                                <i class="fas fa-trash mr-1"></i>Delete
                            </button>
                        </div>
                    </td>
                `;
                backupList.appendChild(row);
            });
        }

        function downloadBackup(filename) {
            // Create a temporary link and trigger download
            const link = document.createElement('a');
            link.href = `/admin/backups/download/${filename}`;
            link.download = filename;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            showNotification(`Downloading backup: ${filename}`, 'info');
        }

        function deleteBackup(filename) {
            // Show modern delete confirmation modal
            showDeleteConfirmationModal(filename);
        }
        
        function showDeleteConfirmationModal(filename) {
            // Create modern modal
            const modal = document.createElement('div');
            modal.id = 'delete-confirmation-modal';
            modal.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm';
            modal.innerHTML = `
                <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="delete-modal-content">
                    <div class="p-6">
                        <!-- Header -->
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-pink-600 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-trash-alt text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Delete Backup</h3>
                                <p class="text-sm text-gray-500">Permanent deletion</p>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="mb-6">
                            <div class="bg-gradient-to-r from-red-50 to-pink-50 rounded-lg p-4 mb-4 border border-red-200">
                                <h4 class="font-semibold text-red-900 mb-2 flex items-center">
                                    <i class="fas fa-database mr-2"></i>Backup to delete:
                                </h4>
                                <div class="bg-white rounded-md p-3 border border-red-100">
                                    <p class="text-sm font-mono text-gray-800 break-all">${filename}</p>
                                </div>
                            </div>

                            <div class="bg-gradient-to-r from-amber-50 to-red-50 rounded-lg p-4 border border-amber-200">
                                <div class="flex items-start text-red-800">
                                    <i class="fas fa-exclamation-triangle mr-2 text-red-600 mt-0.5"></i>
                                    <div>
                                        <span class="font-medium block">This action cannot be undone!</span>
                                        <p class="text-sm text-red-700 mt-1">The backup file will be permanently removed from the server and cannot be recovered.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex space-x-3">
                            <button onclick="cancelDelete()" class="flex-1 px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-times mr-2"></i>Cancel
                            </button>
                            <button onclick="confirmDelete('${filename}')" class="flex-1 px-4 py-3 bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg">
                                <i class="fas fa-trash-alt mr-2"></i>Delete Forever
                            </button>
                        </div>
                    </div>
                </div>
            `;

            document.body.appendChild(modal);

            // Animate modal in
            setTimeout(() => {
                const content = document.getElementById('delete-modal-content');
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);

            // Close on backdrop click
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    cancelDelete();
                }
            });

            // Close on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    cancelDelete();
                }
            });
        }

        function cancelDelete() {
            const modal = document.getElementById('delete-confirmation-modal');
            if (modal) {
                const content = document.getElementById('delete-modal-content');
                content.classList.add('scale-95', 'opacity-0');
                content.classList.remove('scale-100', 'opacity-100');
                
                setTimeout(() => {
                    modal.remove();
                }, 300);
            }
        }

        function confirmDelete(filename) {
            // Close modal first
            cancelDelete();
            
            // Proceed with deletion
            fetch(`/admin/backups/${filename}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(`Backup deleted successfully: ${filename}`, 'success');
                    refreshBackupList(); // Refresh the list
                } else {
                    showNotification('Failed to delete backup: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error deleting backup:', error);
                showNotification('Failed to delete backup: ' + error.message, 'error');
            });
        }

        // Load backup list when settings section is shown
        document.addEventListener('DOMContentLoaded', function() {
            // Load backups when settings section is first shown
            const settingsLink = document.querySelector('[data-content="settings"]');
            if (settingsLink) {
                settingsLink.addEventListener('click', function() {
                    setTimeout(() => {
                        refreshBackupList();
                    }, 100);
                });
            }
        });

        // Maintenance Mode Management Functions
        function toggleMaintenanceMode() {
            // Show modern confirmation modal
            showMaintenanceConfirmationModal();
        }

        function showMaintenanceConfirmationModal() {
            const currentMode = document.getElementById('maintenance-status-text').textContent;
            const isCurrentlyOffline = currentMode === 'Offline';
            const newMode = isCurrentlyOffline ? 'Online' : 'Offline';
            const actionColor = isCurrentlyOffline ? 'green' : 'red';
            const actionIcon = isCurrentlyOffline ? 'fa-play' : 'fa-pause';
            
            // Create modern modal
            const modal = document.createElement('div');
            modal.id = 'maintenance-confirmation-modal';
            modal.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm';
            modal.innerHTML = `
                <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="maintenance-modal-content">
                    <div class="p-6">
                        <!-- Header -->
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-${actionColor}-500 to-${actionColor}-600 rounded-full flex items-center justify-center mr-4">
                                <i class="fas ${actionIcon} text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Toggle Maintenance Mode</h3>
                                <p class="text-sm text-gray-500">System status change</p>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="mb-6">
                            <div class="bg-gradient-to-r from-${actionColor}-50 to-${actionColor}-50 rounded-lg p-4 mb-4 border border-${actionColor}-200">
                                <h4 class="font-semibold text-${actionColor}-900 mb-2 flex items-center">
                                    <i class="fas fa-info-circle mr-2"></i>Status Change:
                                </h4>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-${actionColor}-800">Current: <strong>${currentMode}</strong></span>
                                    <i class="fas fa-arrow-right text-${actionColor}-600 mx-2"></i>
                                    <span class="text-sm text-${actionColor}-800">New: <strong>${newMode}</strong></span>
                                </div>
                            </div>

                            <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-lg p-4 border border-amber-200">
                                <div class="flex items-start text-amber-800">
                                    <i class="fas fa-exclamation-triangle mr-2 text-amber-600 mt-0.5"></i>
                                    <div>
                                        <span class="font-medium block">${isCurrentlyOffline ? 'Bringing system online' : 'Taking system offline'}</span>
                                        <p class="text-sm text-amber-700 mt-1">
                                            ${isCurrentlyOffline 
                                                ? 'Users will be able to access the platform again.' 
                                                : 'All users (except admins) will see the maintenance page.'}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex space-x-3">
                            <button onclick="cancelMaintenanceToggle()" class="flex-1 px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-times mr-2"></i>Cancel
                            </button>
                            <button onclick="confirmMaintenanceToggle()" class="flex-1 px-4 py-3 bg-gradient-to-r from-${actionColor}-600 to-${actionColor}-600 hover:from-${actionColor}-700 hover:to-${actionColor}-700 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg">
                                <i class="fas ${actionIcon} mr-2"></i>Turn ${newMode}
                            </button>
                        </div>
                    </div>
                </div>
            `;

            document.body.appendChild(modal);

            // Animate modal in
            setTimeout(() => {
                const content = document.getElementById('maintenance-modal-content');
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);

            // Close on backdrop click
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    cancelMaintenanceToggle();
                }
            });

            // Close on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    cancelMaintenanceToggle();
                }
            });
        }

        function cancelMaintenanceToggle() {
            const modal = document.getElementById('maintenance-confirmation-modal');
            if (modal) {
                const content = document.getElementById('maintenance-modal-content');
                content.classList.add('scale-95', 'opacity-0');
                content.classList.remove('scale-100', 'opacity-100');
                
                setTimeout(() => {
                    modal.remove();
                }, 300);
            }
        }

        function confirmMaintenanceToggle() {
            // Close modal first
            cancelMaintenanceToggle();
            
            // Show loading state
            const toggleBtn = document.getElementById('maintenance-toggle-btn');
            const originalText = toggleBtn.innerHTML;
            toggleBtn.disabled = true;
            toggleBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Updating...';
            
            // Make API call
            fetch('/admin/maintenance/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update UI elements
                    updateMaintenanceUI(data.maintenance_mode);
                    showNotification(data.message, 'success');
                } else {
                    showNotification('Failed to toggle maintenance mode: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error toggling maintenance mode:', error);
                showNotification('Failed to toggle maintenance mode: ' + error.message, 'error');
            })
            .finally(() => {
                // Reset button
                toggleBtn.disabled = false;
                toggleBtn.innerHTML = originalText;
            });
        }

        function updateMaintenanceUI(mode) {
            const isOffline = mode === 'on';
            const statusIndicator = document.getElementById('maintenance-status-indicator');
            const statusText = document.getElementById('maintenance-status-text');
            const description = document.getElementById('maintenance-description');
            const toggleBtn = document.getElementById('maintenance-toggle-btn');
            
            // Update status indicator
            statusIndicator.className = `inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${
                isOffline ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700'
            }`;
            statusText.textContent = isOffline ? 'Offline' : 'Online';
            
            // Update description
            description.textContent = isOffline 
                ? 'System is currently offline for maintenance'
                : 'System is live and accessible to all users';
            
            // Update button
            toggleBtn.className = `px-4 py-2 rounded-lg text-white font-semibold transition-all duration-200 transform hover:scale-105 ${
                isOffline ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700'
            }`;
            toggleBtn.innerHTML = `<i class="fas ${isOffline ? 'fa-play' : 'fa-pause'} mr-2"></i><span id="maintenance-btn-text">${isOffline ? 'Turn Online' : 'Turn Offline'}</span>`;
        }

        // User Management Functions
        function loadUsersData(filters = {}) {
            showLoading('users-table');
            
            $.get('/admin/users', filters)
                .done(function(response) {
                    renderUsersTable(response.data);
                    renderUsersPagination(response);
                    hideLoading('users-table');
                })
                .fail(function() {
                    showNotification('Error loading users data', 'error');
                    hideLoading('users-table');
                });
        }

        function renderUsersTable(users) {
            const tableBody = $('#users-table-body');
            tableBody.empty();
            
            users.forEach(user => {
                const suspendedBadge = user.is_suspended 
                    ? '<span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Suspended</span>'
                    : '<span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span>';
                
                const roleBadge = user.role === 'worker' 
                    ? '<span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Worker</span>'
                    : '<span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Employer</span>';
                
                const row = `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <input type="checkbox" class="user-checkbox" value="${user.id}">
                                <img class="h-8 w-8 rounded-full cursor-pointer hover:ring-2 hover:ring-blue-500 transition-all duration-200" 
                     src="${user.profile_picture_url || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(user.name)}" 
                     alt="${user.name}"
                     onclick="viewUserProfilePicture('${user.profile_picture_url || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(user.name)}', '${user.name}', '${user.role}')"
                     onerror="this.src='https://ui-avatars.com/api/?name=' + encodeURIComponent('${user.name}') + '&color=ffffff&background=1e40af&size=150'">>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">${user.name}</div>
                                    <div class="text-sm text-gray-500">${user.email}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">${roleBadge}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${new Date(user.created_at).toLocaleDateString()}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${suspendedBadge}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${user.applications_count || 0} / ${user.jobs_count || 0}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="viewUserDetails(${user.id})" class="text-blue-600 hover:text-blue-900 mr-3">View</button>
                            ${user.is_suspended 
                                ? `<button onclick="unsuspendUser(${user.id})" class="text-green-600 hover:text-green-900">Unsuspend</button>`
                                : `<button onclick="suspendUser(${user.id})" class="text-red-600 hover:text-red-900">Suspend</button>`
                            }
                        </td>
                    </tr>
                `;
                tableBody.append(row);
            });
        }

        function viewUserDetails(userId) {
            showLoading('user-details-modal');
            
            $.get(`/admin/users/${userId}`)
                .done(function(response) {
                    renderUserDetailsModal(response);
                    $('#user-details-modal').removeClass('hidden');
                    hideLoading('user-details-modal');
                })
                .fail(function() {
                    showNotification('Error loading user details', 'error');
                    hideLoading('user-details-modal');
                });
        }

        function suspendUser(userId) {
            const reason = prompt('Please provide a reason for suspension:');
            if (!reason) return;
            
            const duration = prompt('Suspension duration (7, 30, 90 days or "permanent"):');
            if (!duration || !['7', '30', '90', 'permanent'].includes(duration)) {
                showNotification('Invalid duration. Please use 7, 30, 90, or permanent', 'error');
                return;
            }
            
            const notifyUser = confirm('Send notification email to user?');
            
            $.post(`/admin/users/${userId}/suspend`, { 
                reason: reason, 
                duration: duration,
                notify_user: notifyUser
            })
            .done(function(response) {
                if (response.success) {
                    showNotification(response.message, 'success');
                    loadUsersData();
                }
            })
            .fail(function() {
                showNotification('Error suspending user', 'error');
            });
        }

        function unsuspendUser(userId) {
            if (confirm('Are you sure you want to unsuspend this user?')) {
                $.post(`/admin/users/${userId}/unsuspend`)
                    .done(function(response) {
                        if (response.success) {
                            showNotification(response.message, 'success');
                            loadUsersData();
                        }
                    })
                    .fail(function() {
                        showNotification('Error unsuspending user', 'error');
                    });
            }
        }

        function bulkUserAction() {
            const selectedUsers = $('.user-checkbox:checked').map(function() {
                return this.value;
            }).get();
            
            if (selectedUsers.length === 0) {
                showNotification('Please select users first', 'warning');
                return;
            }
            
            const action = prompt('Action (suspend/unsuspend/delete):');
            if (!['suspend', 'unsuspend', 'delete'].includes(action)) {
                showNotification('Invalid action', 'error');
                return;
            }
            
            let reason = null, duration = null;
            if (action === 'suspend') {
                reason = prompt('Reason for suspension:');
                if (!reason) return;
                
                duration = prompt('Duration (7, 30, 90, permanent):');
                if (!duration || !['7', '30', '90', 'permanent'].includes(duration)) {
                    showNotification('Invalid duration', 'error');
                    return;
                }
            }
            
            if (confirm(`Are you sure you want to ${action} ${selectedUsers.length} users?`)) {
                $.post('/admin/users/bulk-action', {
                    action: action,
                    user_ids: selectedUsers,
                    reason: reason,
                    duration: duration
                })
                .done(function(response) {
                    if (response.success) {
                        showNotification(response.message, 'success');
                        loadUsersData();
                    }
                })
                .fail(function() {
                    showNotification('Error performing bulk action', 'error');
                });
            }
        }

        // Job Management Functions
        function loadJobsData(filters = {}) {
            showLoading('jobs-table');
            
            $.get('/admin/jobs', filters)
                .done(function(response) {
                    renderJobsTable(response.data);
                    renderJobsPagination(response);
                    hideLoading('jobs-table');
                })
                .fail(function() {
                    showNotification('Error loading jobs data', 'error');
                    hideLoading('jobs-table');
                });
        }

        function renderJobsTable(jobs) {
            const tableBody = $('#jobs-table-body');
            tableBody.empty();
            
            jobs.forEach(job => {
                const statusBadge = getJobStatusBadge(job.status);
                const urgentBadge = job.is_urgent ? '<span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Urgent</span>' : '';
                
                const row = `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" class="job-checkbox" value="${job.id}">
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">${job.title}</div>
                            <div class="text-sm text-gray-500">${job.employer.name}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${job.category.name}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${statusBadge} ${urgentBadge}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">UGX ${Number(job.budget).toLocaleString()}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${job.applications_count}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${new Date(job.created_at).toLocaleDateString()}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="/jobs/${job.id}" target="_blank" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                            ${job.status === 'draft' ? `
                                <button onclick="approveJob(${job.id})" class="text-green-600 hover:text-green-900 mr-3">Approve</button>
                                <button onclick="rejectJob(${job.id})" class="text-red-600 hover:text-red-900">Reject</button>
                            ` : ''}
                        </td>
                    </tr>
                `;
                tableBody.append(row);
            });
        }

        function getJobStatusBadge(status) {
            const badges = {
                'active': '<span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span>',
                'draft': '<span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>',
                'completed': '<span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Completed</span>',
                'cancelled': '<span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Cancelled</span>'
            };
            return badges[status] || status;
        }

        function approveJob(jobId) {
            if (confirm('Are you sure you want to approve this job?')) {
                $.post(`/admin/jobs/${jobId}/approve`)
                    .done(function(response) {
                        if (response.success) {
                            showNotification(response.message, 'success');
                            loadJobsData();
                        }
                    })
                    .fail(function() {
                        showNotification('Error approving job', 'error');
                    });
            }
        }

        function rejectJob(jobId) {
            const reason = prompt('Please provide a reason for rejection:');
            if (reason) {
                $.post(`/admin/jobs/${jobId}/reject`, { reason: reason })
                    .done(function(response) {
                        if (response.success) {
                            showNotification(response.message, 'success');
                            loadJobsData();
                        }
                    })
                    .fail(function() {
                        showNotification('Error rejecting job', 'error');
                    });
            }
        }

        function bulkJobAction(action) {
            const selectedJobs = $('.job-checkbox:checked').map(function() {
                return this.value;
            }).get();
            
            if (selectedJobs.length === 0) {
                showNotification('Please select jobs first', 'warning');
                return;
            }
            
            let reason = null;
            if (action === 'reject') {
                reason = prompt('Reason for rejection:');
                if (!reason) return;
            }
            
            if (confirm(`Are you sure you want to ${action} ${selectedJobs.length} jobs?`)) {
                const url = action === 'approve' ? '/admin/jobs/bulk-approve' : '/admin/jobs/bulk-reject';
                const data = { job_ids: selectedJobs };
                if (reason) data.reason = reason;
                
                $.post(url, data)
                    .done(function(response) {
                        if (response.success) {
                            showNotification(response.message, 'success');
                            loadJobsData();
                        }
                    })
                    .fail(function() {
                        showNotification(`Error ${action}ing jobs`, 'error');
                    });
            }
        }

        // Analytics Functions removed - using the comprehensive version below

        function renderUserGrowthChart(data) {
            const ctx = document.getElementById('userGrowthChart');
            if (!ctx) return;
            
            if (userGrowthChart) userGrowthChart.destroy();
            
            userGrowthChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.map(d => d.month),
                    datasets: [{
                        label: 'Workers',
                        data: data.map(d => d.workers),
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4
                    }, {
                        label: 'Employers',
                        data: data.map(d => d.employers),
                        borderColor: 'rgb(16, 185, 129)',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'User Growth Over Time'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        function renderJobTrendsChart(data) {
            const ctx = document.getElementById('jobTrendsChart');
            if (!ctx) return;
            
            if (jobTrendsChart) jobTrendsChart.destroy();
            
            jobTrendsChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.map(d => d.month),
                    datasets: [{
                        label: 'Jobs Posted',
                        data: data.map(d => d.posted),
                        backgroundColor: 'rgba(99, 102, 241, 0.8)'
                    }, {
                        label: 'Jobs Completed',
                        data: data.map(d => d.completed),
                        backgroundColor: 'rgba(16, 185, 129, 0.8)'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Job Posting Trends'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        function renderApplicationRatesChart(data) {
            const ctx = document.getElementById('applicationRatesChart');
            if (!ctx) return;
            
            if (applicationRatesChart) applicationRatesChart.destroy();
            
            applicationRatesChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Pending', 'Accepted', 'Rejected'],
                    datasets: [{
                        data: [data.pending, data.accepted, data.rejected],
                        backgroundColor: [
                            'rgba(251, 191, 36, 0.8)',
                            'rgba(16, 185, 129, 0.8)',
                            'rgba(239, 68, 68, 0.8)'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Application Status Distribution'
                        }
                    }
                }
            });
        }

        function renderCategoryChart(data) {
            const ctx = document.getElementById('categoryChart');
            if (!ctx) return;
            
            if (categoryChart) categoryChart.destroy();
            
            categoryChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: data.map(d => d.name),
                    datasets: [{
                        data: data.map(d => d.count),
                        backgroundColor: [
                            'rgba(239, 68, 68, 0.8)',
                            'rgba(245, 158, 11, 0.8)',
                            'rgba(16, 185, 129, 0.8)',
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(139, 92, 246, 0.8)',
                            'rgba(236, 72, 153, 0.8)',
                            'rgba(6, 182, 212, 0.8)',
                            'rgba(34, 197, 94, 0.8)'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Job Categories Distribution'
                        }
                    }
                }
            });
        }

        function renderRevenueChart(data) {
            const ctx = document.getElementById('revenueChart');
            if (!ctx) return;
            
            if (revenueChart) revenueChart.destroy();
            
            revenueChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.map(d => d.month),
                    datasets: [{
                        label: 'Platform Revenue (UGX)',
                        data: data.map(d => d.revenue),
                        borderColor: 'rgb(16, 185, 129)',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Platform Revenue Over Time'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'UGX ' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        }

        // System Management Functions
        function backupDatabase() {
            if (confirm('This will create a database backup. Continue?')) {
                showNotification('Database backup initiated...', 'info');
                
                $.post('/admin/system/maintenance', { action: 'backup' })
                    .done(function(response) {
                        if (response.success) {
                            showNotification(response.message, 'success');
                        } else {
                            showNotification(response.message, 'error');
                        }
                    })
                    .fail(function() {
                        showNotification('Error creating backup', 'error');
                    });
            }
        }

        function toggleMaintenance() {
            if (confirm('This will toggle maintenance mode. Continue?')) {
                $.post('/admin/system/maintenance', { action: 'maintenance_toggle' })
                    .done(function(response) {
                        if (response.success) {
                            showNotification(response.message, 'success');
                        } else {
                            showNotification(response.message, 'error');
                        }
                    })
                    .fail(function() {
                        showNotification('Error toggling maintenance mode', 'error');
                    });
            }
        }

        // Settings form submission
        $('#settingsForm').on('submit', function(e) {
            e.preventDefault();
            
            const formData = {
                employer_fee: $('#employer-fee').val(),
                worker_fee: $('#worker-fee').val(),
                maintenance_mode: $('#maintenance-mode').is(':checked'),
                max_job_applications: $('#max-job-applications').val(),
                job_approval_required: $('#job-approval-required').is(':checked'),
                user_verification_required: $('#user-verification-required').is(':checked'),
                max_file_upload_size: $('#max-file-upload-size').val()
            };
            
            $.post('/admin/settings', formData)
                .done(function(response) {
                    if (response.success) {
                        showNotification('Settings updated successfully', 'success');
                    }
                })
                .fail(function() {
                    showNotification('Error updating settings', 'error');
                });
        });

        // Utility Functions
        function showLoading(elementId) {
            const element = document.getElementById(elementId);
            if (element) {
                element.innerHTML = '<div class="flex justify-center items-center py-8"><i class="fas fa-spinner fa-spin text-2xl text-blue-600"></i></div>';
            }
        }

        function hideLoading(elementId) {
            // Loading will be replaced by actual content
        }

        function showNotification(message, type) {
            const alertClass = type === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 
                              type === 'error' ? 'bg-red-100 border-red-400 text-red-700' :
                              type === 'warning' ? 'bg-yellow-100 border-yellow-400 text-yellow-700' :
                              'bg-blue-100 border-blue-400 text-blue-700';
            
            const icon = type === 'success' ? 'fa-check-circle' :
                        type === 'error' ? 'fa-exclamation-circle' :
                        type === 'warning' ? 'fa-exclamation-triangle' :
                        'fa-info-circle';
            
            const notification = `
                <div class="fixed top-4 right-4 z-50 ${alertClass} border px-4 py-3 rounded shadow-lg max-w-md" role="alert">
                    <div class="flex items-center">
                        <i class="fas ${icon} mr-2"></i>
                        <span class="block sm:inline">${message}</span>
                        <button class="float-right ml-4 text-lg font-bold" onclick="this.parentElement.parentElement.remove()">&times;</button>
                    </div>
                </div>
            `;
            
            $('body').append(notification);
            
            setTimeout(function() {
                $('.fixed.top-4.right-4').fadeOut(function() {
                    $(this).remove();
                });
            }, 5000);
        }

        // Modal Functions (Global)
        window.openMessagesModal = function() {
            console.log('Opening messages modal...');
            const modal = document.getElementById('messagesModal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
            
            // Add fade-in animation
            modal.style.opacity = '0';
            setTimeout(() => {
                modal.style.opacity = '1';
                modal.style.transition = 'opacity 0.3s ease-in-out';
            }, 10);
            
            // Load modal data
            loadModalMessageStats();
            loadModalConversations();
            
            // Update unread badge in sidebar
            updateAdminUnreadBadge();
        }

        window.closeMessagesModal = function() {
            console.log('Closing messages modal...');
            const modal = document.getElementById('messagesModal');
            
            // Add fade-out animation
            modal.style.opacity = '0';
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto'; // Restore scrolling
                modal.style.transition = '';
            }, 300);
            
            // Clear current conversation
            currentModalConversation = null;
            $('#modal-chat-header').hide();
            $('#modal-message-input-area').hide();
        }

        function loadModalMessageStats() {
            $.get('/admin/messages/stats')
                .done(function(stats) {
                    $('#modal-total-messages').text(stats.total_messages || 0);
                    $('#modal-unread-messages').text(stats.unread_messages || 0);
                    $('#modal-messages-today').text(stats.messages_today || 0);
                    
                    // Update sidebar badge as well
                    const badge = $('#admin-unread-badge');
                    const unreadCount = stats.unread_messages || 0;
                    
                    if (unreadCount > 0) {
                        badge.text(unreadCount).removeClass('hidden');
                    } else {
                        badge.addClass('hidden');
                    }
                })
                .fail(function() {
                    console.log('Error loading modal message stats');
                    showModalNotification('Error loading message statistics', 'error');
                });
        }

        function showModalNotification(message, type = 'info') {
            const notificationArea = document.getElementById('modal-notification-area');
            const notification = document.getElementById('modal-notification');
            const icon = document.getElementById('modal-notification-icon');
            const messageSpan = document.getElementById('modal-notification-message');
            
            // Check if elements exist
            if (!notificationArea || !notification || !icon || !messageSpan) {
                console.warn('Modal notification elements not found, using console instead');
                console.log(`[${type.toUpperCase()}] ${message}`);
                alert(message); // Fallback to alert
                return;
            }
            
            // Define styles for different notification types
            const styles = {
                'success': {
                    classes: 'bg-green-100 border-green-400 text-green-700',
                    icon: 'fas fa-check-circle text-green-500'
                },
                'error': {
                    classes: 'bg-red-100 border-red-400 text-red-700',
                    icon: 'fas fa-exclamation-circle text-red-500'
                },
                'warning': {
                    classes: 'bg-yellow-100 border-yellow-400 text-yellow-700',
                    icon: 'fas fa-exclamation-triangle text-yellow-500'
                },
                'info': {
                    classes: 'bg-blue-100 border-blue-400 text-blue-700',
                    icon: 'fas fa-info-circle text-blue-500'
                }
            };
            
            const style = styles[type] || styles.info;
            
            // Reset classes and apply new ones
            notification.className = `p-3 rounded-lg border flex items-center justify-between ${style.classes}`;
            icon.className = style.icon + ' mr-2';
            messageSpan.textContent = message;
            
            // Show notification
            notificationArea.classList.remove('hidden');
            
            // Auto-hide after 5 seconds
            setTimeout(() => {
                hideModalNotification();
            }, 5000);
        }

        function hideModalNotification() {
            const notificationArea = document.getElementById('modal-notification-area');
            notificationArea.classList.add('hidden');
        }

        function loadModalConversations() {
            // Show loading state
            const container = $('#modal-conversations-list');
            container.html(`
                <div class="text-center text-gray-500 py-8">
                    <i class="fas fa-spinner fa-spin text-3xl mb-3"></i>
                    <p class="font-medium">Loading conversations...</p>
                    <p class="text-sm">Please wait while we fetch your messages</p>
                </div>
            `);
            
            $.get('/admin/messages/conversations')
                .done(function(conversations) {
                    renderModalConversations(conversations);
                })
                .fail(function() {
                    console.log('Error loading modal conversations');
                    container.html(`
                        <div class="text-center text-red-500 py-8">
                            <i class="fas fa-exclamation-triangle text-3xl mb-3"></i>
                            <p class="font-medium">Error loading conversations</p>
                            <p class="text-sm">Please try refreshing</p>
                            <button onclick="loadModalConversations()" class="mt-3 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm">
                                <i class="fas fa-sync-alt mr-1"></i>Retry
                            </button>
                        </div>
                    `);
                });
        }

        function renderModalConversations(conversations) {
            const container = $('#modal-conversations-list');
            container.empty();

            if (conversations.length === 0) {
                container.html(`
                    <div class="text-center text-gray-500 py-8">
                        <i class="fas fa-inbox text-4xl mb-4 text-gray-300"></i>
                        <p class="font-medium">No conversations yet</p>
                        <p class="text-sm text-gray-400">Users will appear here when they send messages</p>
                    </div>
                `);
                return;
            }

            conversations.forEach(conv => {
                const unreadBadge = conv.unread_count > 0 
                    ? `<span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">${conv.unread_count}</span>`
                    : '';
                
                const lastMessage = conv.last_message 
                    ? conv.last_message.message.substring(0, 40) + (conv.last_message.message.length > 40 ? '...' : '')
                    : 'No messages yet';

                const timeAgo = conv.last_message 
                    ? new Date(conv.last_message.created_at).toLocaleDateString() + ' ' + new Date(conv.last_message.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})
                    : '';

                const conversationHtml = `
                    <div class="conversation-item p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-blue-50 transition-colors mb-2 bg-white" 
                         onclick="openModalConversation(${conv.user.id})">
                        <div class="flex items-start">
                            <img class="h-10 w-10 rounded-full mr-3 flex-shrink-0" 
                                 src="${conv.user.profile_picture || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(conv.user.name) + '&background=1e40af&color=ffffff'}" 
                                 alt="${conv.user.name}">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <h4 class="font-semibold text-gray-900 text-sm truncate">${conv.user.name}</h4>
                                    ${unreadBadge}
                                </div>
                                <p class="text-xs text-gray-500 mb-1">
                                    <i class="fas fa-${conv.user.role === 'worker' ? 'user' : 'building'} mr-1"></i>
                                    ${conv.user.role}
                                </p>
                                <p class="text-sm text-gray-600 truncate">${lastMessage}</p>
                                <p class="text-xs text-gray-400 mt-1">${timeAgo}</p>
                            </div>
                        </div>
                    </div>
                `;
                container.append(conversationHtml);
            });
        }

        function refreshModalMessages() {
            loadModalConversations();
            loadModalMessageStats();
        }

        function toggleBroadcastSection() {
            const section = document.getElementById('broadcast-section');
            const icon = document.getElementById('broadcast-toggle-icon');
            const text = document.getElementById('broadcast-toggle-text');
            
            if (section.classList.contains('hidden')) {
                section.classList.remove('hidden');
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
                text.textContent = 'Hide Broadcast';
            } else {
                section.classList.add('hidden');
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
                text.textContent = 'Show Broadcast';
            }
        }

        function sendModalBroadcast() {
            const audience = $('#modal-broadcast-audience').val();
            const type = $('#modal-broadcast-type').val();
            const message = $('#modal-broadcast-message').val().trim();
            const sendEmail = $('#modal-broadcast-email').is(':checked');
            const isUrgent = $('#modal-broadcast-urgent').is(':checked');
            
            if (!message) {
                showToast('Please enter a broadcast message', 'warning');
                return;
            }
            
            // Use the enhanced broadcast confirmation dialog
            showBroadcastConfirmDialog(
                audience,
                type,
                message,
                sendEmail,
                isUrgent,
                function() {
                    // Proceed with sending broadcast
                    const sendButton = $('button[onclick="sendModalBroadcast()"]');
                    const originalText = sendButton.html();
                    sendButton.html('<i class="fas fa-spinner fa-spin mr-1"></i>Sending...').prop('disabled', true);
                    
                    $.ajax({
                        url: '/admin/messages/broadcast',
                        method: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            audience: audience,
                            type: type,
                            message: message,
                            send_email: sendEmail ? 1 : 0,
                            is_urgent: isUrgent ? 1 : 0
                        },
                        success: function(response) {
                            if (response.success) {
                                showToast(`Broadcast sent successfully to ${response.recipients_count || 'all'} users!`, 'success');
                                $('#modal-broadcast-message').val('');
                                $('#modal-broadcast-email').prop('checked', false);
                                $('#modal-broadcast-urgent').prop('checked', false);
                                if (typeof loadModalMessageStats === 'function') {
                                    loadModalMessageStats();
                                }
                            } else {
                                showToast('Failed to send broadcast message', 'error');
                            }
                        },
                        error: function(xhr) {
                            let errorMsg = 'Error sending broadcast message. Please try again.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                                const errors = Object.values(xhr.responseJSON.errors).flat();
                                errorMsg = errors.join(', ');
                            }
                            console.error('Broadcast error:', xhr.responseJSON);
                            showToast(errorMsg, 'error');
                        },
                        complete: function() {
                            sendButton.html(originalText).prop('disabled', false);
                        }
                    });
                }
            );
        }

        let currentModalConversation = null;

        function openModalConversation(userId) {
            currentModalConversation = userId;
            
            // Update conversation list styling
            $('.conversation-item').removeClass('bg-blue-50 border-blue-300').addClass('bg-white');
            $(`.conversation-item[onclick="openModalConversation(${userId})"]`).removeClass('bg-white').addClass('bg-blue-50 border-blue-300');
            
            // Load conversation messages
            $.get(`/messages/conversation/${userId}`)
                .done(function(response) {
                    renderModalConversation(response);
                    $('#modal-chat-header').show();
                    $('#modal-message-input-area').show();
                })
                .fail(function() {
                    showModalNotification('Error loading conversation', 'error');
                });
        }

        function renderModalConversation(response) {
            const { messages, other_user, current_user } = response;
            
            // Update chat header
            $('#modal-chat-user-avatar').attr('src', other_user.profile_picture || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(other_user.name) + '&background=1e40af&color=ffffff');
            $('#modal-chat-user-name').text(other_user.name);
            $('#modal-chat-user-role').text(other_user.role.charAt(0).toUpperCase() + other_user.role.slice(1));
            
            // Render messages
            const container = $('#modal-messages-container');
            container.empty();
            
            if (messages.length === 0) {
                container.html(`
                    <div class="text-center text-gray-500 mt-20">
                        <i class="fas fa-comment-dots text-4xl mb-4 text-gray-300"></i>
                        <p class="font-medium">No messages in this conversation</p>
                        <p class="text-sm">Start the conversation by sending a message below</p>
                    </div>
                `);
                return;
            }
            
            messages.forEach(message => {
                const isAdmin = message.sender_id === current_user.id;
                const messageClass = isAdmin ? 'justify-end' : 'justify-start';
                const bubbleClass = isAdmin 
                    ? 'bg-blue-600 text-white ml-12' 
                    : 'bg-white text-gray-800 border border-gray-200 mr-12';
                
                const senderName = isAdmin ? 'You (Admin)' : other_user.name;
                const timeFormatted = new Date(message.created_at).toLocaleDateString() + ' ' + 
                                    new Date(message.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                
                const messageHtml = `
                    <div class="flex ${messageClass} mb-4">
                        <div class="max-w-xs lg:max-w-md">
                            <div class="px-4 py-3 rounded-lg ${bubbleClass} shadow-sm">
                                <p class="text-sm font-medium mb-1 ${isAdmin ? 'text-blue-100' : 'text-gray-600'}">${senderName}</p>
                                <p class="text-sm leading-relaxed">${message.message}</p>
                                <p class="text-xs mt-2 ${isAdmin ? 'text-blue-200' : 'text-gray-500'}">
                                    ${timeFormatted}
                                </p>
                            </div>
                        </div>
                    </div>
                `;
                container.append(messageHtml);
            });
            
            // Scroll to bottom
            container.scrollTop(container[0].scrollHeight);
        }

        function sendModalMessage() {
            const messageInput = $('#modal-message-input');
            const sendButton = messageInput.siblings('button');
            const message = messageInput.val().trim();
            
            if (!message || !currentModalConversation) {
                showModalNotification('Please enter a message', 'warning');
                return;
            }
            
            // Disable input and show sending state
            messageInput.prop('disabled', true);
            sendButton.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i>Sending...');
            
            $.post('/messages/send', {
                receiver_id: currentModalConversation,
                message: message,
                _token: $('meta[name="csrf-token"]').attr('content')
            })
            .done(function(response) {
                if (response.success) {
                    messageInput.val('');
                    showModalNotification('Message sent successfully', 'success');
                    openModalConversation(currentModalConversation); // Refresh conversation
                    loadModalConversations(); // Refresh conversation list
                    loadModalMessageStats(); // Update stats
                } else {
                    showModalNotification('Failed to send message', 'error');
                }
            })
            .fail(function() {
                showModalNotification('Error sending message', 'error');
            })
            .always(function() {
                // Re-enable input and restore button
                messageInput.prop('disabled', false).focus();
                sendButton.prop('disabled', false).html('<i class="fas fa-paper-plane mr-1"></i>Send');
            });
        }

        function sendModalQuickReply(message) {
            if (!currentModalConversation) {
                showModalNotification('Please select a conversation first', 'warning');
                return;
            }
            
            $('#modal-message-input').val(message);
            sendModalMessage();
        }

        function markModalConversationAsRead() {
            if (!currentModalConversation) return;
            
            $.post(`/messages/conversation/${currentModalConversation}/read`)
                .done(function() {
                    loadModalConversations();
                    loadModalMessageStats();
                    showModalNotification('Conversation marked as read', 'success');
                })
                .fail(function() {
                    showModalNotification('Error marking conversation as read', 'error');
                });
        }

        function viewModalUserProfile() {
            if (currentModalConversation) {
                // You can implement user profile viewing here
                showModalNotification('User profile feature - User ID: ' + currentModalConversation, 'info');
            }
        }

        // Enter key to send message in modal
        $(document).on('keypress', '#modal-message-input', function(e) {
            if (e.which === 13) {
                sendModalMessage();
            }
        });

        // User Management Modal Functions (Global)
        window.openUserManagementModal = function() {
            console.log('Opening user management modal...');
            const modal = document.getElementById('userManagementModal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Add fade-in animation
            modal.style.opacity = '0';
            setTimeout(() => {
                modal.style.opacity = '1';
                modal.style.transition = 'opacity 0.3s ease-in-out';
            }, 10);
            
            // Load users data when modal opens
            loadUsersData();
            
            // Set up search functionality
            $('#user-search').on('input', function() {
                const filters = {
                    search: $(this).val(),
                    role: $('#user-role-filter').val(),
                    status: $('#user-status-filter').val()
                };
                
                // Debounce search
                clearTimeout(window.userSearchTimeout);
                window.userSearchTimeout = setTimeout(() => {
                    loadUsersData(filters);
                }, 500);
            });
            
            // Set up filter change handlers
            $('#user-role-filter, #user-status-filter').on('change', function() {
                applyUserFilters();
            });
        }

        window.closeUserManagementModal = function() {
            console.log('Closing user management modal...');
            const modal = document.getElementById('userManagementModal');
            
            modal.style.opacity = '0';
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                modal.style.transition = '';
            }, 300);
        }

        function showUserNotification(message, type = 'info') {
            const notificationArea = document.getElementById('user-notification-area');
            const notification = document.getElementById('user-notification');
            const icon = document.getElementById('user-notification-icon');
            const messageSpan = document.getElementById('user-notification-message');
            
            const styles = {
                'success': {
                    classes: 'bg-green-100 border-green-400 text-green-700',
                    icon: 'fas fa-check-circle text-green-500'
                },
                'error': {
                    classes: 'bg-red-100 border-red-400 text-red-700',
                    icon: 'fas fa-exclamation-circle text-red-500'
                },
                'warning': {
                    classes: 'bg-yellow-100 border-yellow-400 text-yellow-700',
                    icon: 'fas fa-exclamation-triangle text-yellow-500'
                },
                'info': {
                    classes: 'bg-blue-100 border-blue-400 text-blue-700',
                    icon: 'fas fa-info-circle text-blue-500'
                }
            };
            
            const style = styles[type] || styles.info;
            
            notification.className = `p-3 rounded-lg border flex items-center justify-between ${style.classes}`;
            icon.className = style.icon + ' mr-2';
            messageSpan.textContent = message;
            
            notificationArea.classList.remove('hidden');
            
            setTimeout(() => {
                hideUserNotification();
            }, 5000);
        }

        function hideUserNotification() {
            document.getElementById('user-notification-area').classList.add('hidden');
        }

        // Job Management Modal Functions (Global)
        window.openJobManagementModal = function() {
            console.log('Opening job management modal...');
            const modal = document.getElementById('jobManagementModal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            modal.style.opacity = '0';
            setTimeout(() => {
                modal.style.opacity = '1';
                modal.style.transition = 'opacity 0.3s ease-in-out';
            }, 10);
        }

        function closeJobManagementModal() {
            console.log('Closing job management modal...');
            const modal = document.getElementById('jobManagementModal');
            
            modal.style.opacity = '0';
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                modal.style.transition = '';
            }, 300);
        }

        function showJobNotification(message, type = 'info') {
            const notificationArea = document.getElementById('job-notification-area');
            const notification = document.getElementById('job-notification');
            const icon = document.getElementById('job-notification-icon');
            const messageSpan = document.getElementById('job-notification-message');
            
            const styles = {
                'success': {
                    classes: 'bg-green-100 border-green-400 text-green-700',
                    icon: 'fas fa-check-circle text-green-500'
                },
                'error': {
                    classes: 'bg-red-100 border-red-400 text-red-700',
                    icon: 'fas fa-exclamation-circle text-red-500'
                },
                'warning': {
                    classes: 'bg-yellow-100 border-yellow-400 text-yellow-700',
                    icon: 'fas fa-exclamation-triangle text-yellow-500'
                },
                'info': {
                    classes: 'bg-blue-100 border-blue-400 text-blue-700',
                    icon: 'fas fa-info-circle text-blue-500'
                }
            };
            
            const style = styles[type] || styles.info;
            
            notification.className = `p-3 rounded-lg border flex items-center justify-between ${style.classes}`;
            icon.className = style.icon + ' mr-2';
            messageSpan.textContent = message;
            
            notificationArea.classList.remove('hidden');
            
            setTimeout(() => {
                hideJobNotification();
            }, 5000);
        }

        function hideJobNotification() {
            document.getElementById('job-notification-area').classList.add('hidden');
        }

        // Analytics Modal Functions (Global)
        window.openAnalyticsModal = function() {
            console.log('Opening analytics modal...');
            const modal = document.getElementById('analyticsModal');
            
            if (!modal) {
                console.error('Analytics modal not found!');
                return;
            }
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            modal.style.opacity = '0';
            setTimeout(() => {
                modal.style.opacity = '1';
                modal.style.transition = 'opacity 0.3s ease-in-out';
                
                // Initialize analytics dashboard after modal is fully visible and rendered
                setTimeout(() => {
                    console.log('Modal is now visible, initializing analytics dashboard...');
                    initializeAnalyticsDashboard();
                }, 300); // Increased delay to ensure modal is fully rendered
            }, 10);
        }

        window.closeAnalyticsModal = function() {
            console.log('Closing analytics modal...');
            const modal = document.getElementById('analyticsModal');
            
            modal.style.opacity = '0';
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                modal.style.transition = '';
            }, 300);
        }

        // Analytics Dashboard Initialization
        function initializeAnalyticsDashboard() {
            console.log('=== Initializing Analytics Dashboard ===');
            console.log('Chart.js loaded:', typeof Chart !== 'undefined');
            console.log('jQuery loaded:', typeof $ !== 'undefined');
            
            // Initialize chart variables
            window.userGrowthPieChart = null;
            window.jobTrendsDonutChart = null;
            
            // Check if Chart.js is loaded
            if (typeof Chart === 'undefined') {
                console.error('Chart.js is not loaded!');
                showAnalyticsNotification('Chart.js library not loaded', 'error');
                return;
            }
            
            // Check if required elements exist
            const pieChartCanvas = document.getElementById('userGrowthPieChart');
            const donutChartCanvas = document.getElementById('jobTrendsDonutChart');
            
            if (!pieChartCanvas) {
                console.error('User growth pie chart canvas not found!');
                return;
            }
            
            if (!donutChartCanvas) {
                console.error('Job trends donut chart canvas not found!');
                return;
            }
            
            console.log('All required elements found');
            console.log('Pie canvas:', pieChartCanvas);
            console.log('Donut canvas:', donutChartCanvas);
            
            updateCurrentDateTime();
            loadAnalyticsData();
            populateReportMonths();
            
            // Update time every minute
            setInterval(updateCurrentDateTime, 60000);
            
            console.log('Analytics dashboard initialization completed');
        }

        function updateCurrentDateTime() {
            const now = new Date();
            const dateOptions = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            };
            const timeOptions = { 
                hour: '2-digit', 
                minute: '2-digit',
                hour12: true 
            };
            
            document.getElementById('current-date').textContent = now.toLocaleDateString('en-US', dateOptions);
            document.getElementById('current-time').textContent = now.toLocaleTimeString('en-US', timeOptions);
        }

        function loadAnalyticsData() {
            console.log('=== Loading Analytics Data ===');
            console.log('jQuery available:', typeof $ !== 'undefined');
            console.log('jQuery.ajax available:', typeof $.ajax !== 'undefined');
            console.log('$ is:', $);
            
            try {
                console.log('CSRF token:', $('meta[name="csrf-token"]').attr('content'));
            } catch (e) {
                console.error('Error getting CSRF token:', e);
            }
            
            // Update date and time immediately
            try {
                updateCurrentDateTime();
                console.log('DateTime updated successfully');
            } catch (e) {
                console.error('Error updating datetime:', e);
            }
            
            // Show loading state
            try {
                showAnalyticsNotification('Loading analytics data...', 'info');
                console.log('Notification shown');
            } catch (e) {
                console.error('Error showing notification:', e);
            }
            
            console.log('About to make AJAX request to: /admin/analytics');
            
            // Test if jQuery AJAX is working
            if (typeof $ === 'undefined') {
                console.error('jQuery is not loaded!');
                showAnalyticsNotification('jQuery library not loaded', 'error');
                return;
            }
            
            if (typeof $.ajax === 'undefined') {
                console.error('jQuery.ajax is not available!');
                showAnalyticsNotification('jQuery AJAX not available', 'error');
                return;
            }
            
            console.log('jQuery and $.ajax are available, starting AJAX call...');
            
            try {
                $.ajax({
                    url: '/admin/analytics',
                    method: 'GET',
                    dataType: 'json',
                    timeout: 10000,
                    cache: false,
                    beforeSend: function(xhr) {
                        console.log('✓ AJAX beforeSend triggered');
                        console.log('Request URL:', this.url);
                        console.log('Request method:', this.method);
                    },
                    success: function(response) {
                        console.log('=== Analytics Data Received ===');
                        console.log('Response:', response);
                        console.log('User Growth Data:', response.userGrowth);
                        console.log('Job Trends Data:', response.jobTrends);
                        
                        if (!response) {
                            console.error('Empty response received');
                            showAnalyticsNotification('Empty response from server', 'error');
                            return;
                        }
                        
                        if (!response.userGrowth) {
                            console.warn('No userGrowth data in response');
                        }
                        
                        if (!response.jobTrends) {
                            console.warn('No jobTrends data in response');
                        }
                        
                        console.log('Starting chart rendering...');
                        renderAnalyticsCharts(response);
                        
                        console.log('Updating metrics...');
                        updateAnalyticsMetrics(response);
                        
                        console.log('Updating performance tables...');
                        updatePerformanceTables(response);
                        
                        showAnalyticsNotification('Analytics data loaded successfully', 'success');
                        console.log('=== Analytics Load Complete ===');
                    },
                    error: function(xhr, status, error) {
                        console.error('=== Analytics Load Error ===');
                        console.error('XHR object:', xhr);
                        console.error('Status:', status);
                        console.error('Error:', error);
                        console.error('Response Text:', xhr.responseText);
                        console.error('Status Code:', xhr.status);
                        console.error('Response JSON:', xhr.responseJSON);
                        console.error('Ready State:', xhr.readyState);
                        
                        let message = 'Failed to load analytics data';
                        
                        if (xhr.status === 0) {
                            message = 'Network error - could not connect to server';
                            console.error('Possible causes: CORS issue, server not running, or network problem');
                        } else if (xhr.status === 401) {
                            message = 'Authentication required - please login as admin';
                        } else if (xhr.status === 403) {
                            message = 'Access denied - admin privileges required';
                        } else if (xhr.status === 404) {
                            message = 'Analytics endpoint not found';
                        } else if (xhr.status === 500) {
                            message = 'Server error - check logs for details';
                            if (xhr.responseJSON?.message) {
                                message += ': ' + xhr.responseJSON.message;
                            }
                        } else if (xhr.responseJSON?.message) {
                            message = xhr.responseJSON.message;
                        } else if (status === 'timeout') {
                            message = 'Request timeout - server took too long to respond';
                        } else if (status === 'parsererror') {
                            message = 'Invalid JSON response from server';
                        } else if (status === 'abort') {
                            message = 'Request was aborted';
                        }
                        
                        showAnalyticsNotification(message, 'error');
                        console.error('Error message shown to user:', message);
                        
                        // Show placeholder charts even on error
                        console.log('Rendering placeholder charts due to error...');
                        renderPlaceholderCharts();
                    },
                    complete: function(xhr, status) {
                        console.log('=== AJAX Request Complete ===');
                        console.log('Final status:', status);
                        console.log('Final XHR state:', xhr.readyState);
                    }
                });
                
                console.log('$.ajax() call completed (async)');
            } catch (e) {
                console.error('Exception thrown during $.ajax() call:', e);
                console.error('Stack trace:', e.stack);
                showAnalyticsNotification('Error initiating AJAX request: ' + e.message, 'error');
            }
        }
        
        function renderPlaceholderCharts() {
            console.log('Rendering placeholder charts...');
            
            // Placeholder data
            const placeholderData = {
                userGrowth: [
                    { month: 'Jan', count: 45 },
                    { month: 'Feb', count: 52 },
                    { month: 'Mar', count: 61 },
                    { month: 'Apr', count: 58 },
                    { month: 'May', count: 70 },
                    { month: 'Jun', count: 85 }
                ],
                jobTrends: [
                    { status: 'Active', count: 120 },
                    { status: 'Pending', count: 35 },
                    { status: 'Completed', count: 200 },
                    { status: 'Cancelled', count: 15 }
                ]
            };
            
            renderAnalyticsCharts(placeholderData);
        }

        function renderAnalyticsCharts(data) {
            console.log('=== Rendering Analytics Charts ===');
            console.log('Data received:', data);
            console.log('User Growth array length:', data.userGrowth?.length);
            console.log('Job Trends array length:', data.jobTrends?.length);
            
            // Get canvas elements
            const pieCanvas = document.getElementById('userGrowthPieChart');
            const donutCanvas = document.getElementById('jobTrendsDonutChart');
            
            console.log('Pie canvas element:', pieCanvas);
            console.log('Donut canvas element:', donutCanvas);
            
            // Destroy any existing Chart.js instances on these canvases
            if (pieCanvas) {
                const existingPieChart = Chart.getChart(pieCanvas);
                if (existingPieChart) {
                    console.log('Destroying existing pie chart instance with ID:', existingPieChart.id);
                    existingPieChart.destroy();
                } else {
                    console.log('No existing pie chart found');
                }
            }
            
            if (donutCanvas) {
                const existingDonutChart = Chart.getChart(donutCanvas);
                if (existingDonutChart) {
                    console.log('Destroying existing donut chart instance with ID:', existingDonutChart.id);
                    existingDonutChart.destroy();
                } else {
                    console.log('No existing donut chart found');
                }
            }
            
            // Clear global references
            window.userGrowthPieChart = null;
            window.jobTrendsDonutChart = null;

            // Render User Growth Pie Chart
            if (data.userGrowth && data.userGrowth.length > 0) {
                console.log('Calling renderUserGrowthPieChart with', data.userGrowth.length, 'data points');
                renderUserGrowthPieChart(data.userGrowth);
            } else {
                console.warn('No user growth data available, creating sample chart');
                // Create sample data for demonstration
                const sampleUserData = [
                    { month: 'Jan 2026', workers: 5, employers: 2 },
                    { month: 'Feb 2026', workers: 8, employers: 3 },
                    { month: 'Mar 2026', workers: 12, employers: 5 }
                ];
                console.log('Using sample data:', sampleUserData);
                renderUserGrowthPieChart(sampleUserData);
            }
            
            // Render Job Trends Donut Chart
            if (data.jobTrends && data.jobTrends.length > 0) {
                console.log('Calling renderJobTrendsDonutChart with', data.jobTrends.length, 'data points');
                renderJobTrendsDonutChart(data.jobTrends);
            } else {
                console.warn('No job trends data available, creating sample chart');
                // Create sample data for demonstration
                const sampleJobData = [
                    { month: 'Jan 2026', posted: 10, completed: 7, active: 2 },
                    { month: 'Feb 2026', posted: 15, completed: 12, active: 3 },
                    { month: 'Mar 2026', posted: 20, completed: 15, active: 5 }
                ];
                console.log('Using sample data:', sampleJobData);
                renderJobTrendsDonutChart(sampleJobData);
            }
            
            // Render Monthly Performance Trends Chart
            renderMonthlyPerformanceChart(data);
            
            // Render Activity Insights Chart
            renderActivityInsightsChart(data);
            
            console.log('=== Chart Rendering Complete ===');
        }
        
        function renderMonthlyPerformanceChart(data) {
            const canvas = document.getElementById('monthlyPerformanceChart');
            if (!canvas) {
                console.error('monthlyPerformanceChart canvas not found');
                return;
            }
            
            const ctx = canvas.getContext('2d');
            
            // Destroy existing chart if it exists using Chart.js method
            const existingChart = Chart.getChart(canvas);
            if (existingChart) {
                existingChart.destroy();
            }
            
            // Sample data - replace with actual data from backend
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
            const usersData = [120, 190, 300, 500, 420, 600];
            const jobsData = [80, 120, 200, 350, 280, 450];
            const revenueData = [1200, 1900, 3000, 5000, 4200, 6000];
            
            window.monthlyPerformanceChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [
                        {
                            label: 'Users',
                            data: usersData,
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.4,
                            fill: true
                        },
                        {
                            label: 'Jobs',
                            data: jobsData,
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            tension: 0.4,
                            fill: true
                        },
                        {
                            label: 'Revenue ($)',
                            data: revenueData,
                            borderColor: '#f59e0b',
                            backgroundColor: 'rgba(245, 158, 11, 0.1)',
                            tension: 0.4,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            
            // Update summary stats
            document.getElementById('best-user-month-summary').textContent = 'Jun (600)';
            document.getElementById('best-job-month-summary').textContent = 'Jun (450)';
            document.getElementById('best-revenue-month-summary').textContent = 'Jun ($6k)';
        }
        
        function renderActivityInsightsChart(data) {
            const canvas = document.getElementById('activityInsightsChart');
            if (!canvas) {
                console.error('activityInsightsChart canvas not found');
                return;
            }
            
            const ctx = canvas.getContext('2d');
            
            // Destroy existing chart if it exists using Chart.js method
            const existingChart = Chart.getChart(canvas);
            if (existingChart) {
                existingChart.destroy();
            }
            
            // Sample data - replace with actual data from backend
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
            const applicationsData = [45, 78, 120, 180, 150, 220];
            const messagesData = [120, 180, 250, 320, 280, 380];
            const viewsData = [300, 450, 600, 800, 700, 950];
            
            window.activityInsightsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [
                        {
                            label: 'Applications',
                            data: applicationsData,
                            borderColor: '#8b5cf6',
                            backgroundColor: 'rgba(139, 92, 246, 0.1)',
                            tension: 0.4,
                            fill: true
                        },
                        {
                            label: 'Messages',
                            data: messagesData,
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.4,
                            fill: true
                        },
                        {
                            label: 'Job Views',
                            data: viewsData,
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            tension: 0.4,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            
            // Update summary stats
            document.getElementById('peak-activity-summary').textContent = 'Jun';
            document.getElementById('avg-daily-summary').textContent = '42';
            document.getElementById('conversion-rate-summary').textContent = '23%';
        }

        function renderUserGrowthPieChart(userGrowthData) {
            console.log('=== Rendering User Growth Pie Chart ===');
            console.log('Data received:', userGrowthData);
            
            const canvasElement = document.getElementById('userGrowthPieChart');
            if (!canvasElement) {
                console.error('Canvas element userGrowthPieChart not found!');
                return;
            }
            
            console.log('Canvas element found:', canvasElement);
            
            // Destroy any existing chart on this canvas using Chart.js API
            const existingChart = Chart.getChart(canvasElement);
            if (existingChart) {
                console.log('Found existing chart, destroying it...');
                existingChart.destroy();
            }
            
            // Get context
            const ctx = canvasElement.getContext('2d');
            if (!ctx) {
                console.error('Could not get 2D context from canvas!');
                return;
            }
            
            console.log('Canvas context obtained successfully');
            
            // Handle empty data
            if (!userGrowthData || userGrowthData.length === 0) {
                console.log('No user growth data available');
                document.getElementById('user-growth-annotation').textContent = 'No user growth data available';
                return;
            }
            
            // Calculate totals and percentages
            const totalWorkers = userGrowthData.reduce((sum, month) => sum + (parseInt(month.workers) || 0), 0);
            const totalEmployers = userGrowthData.reduce((sum, month) => sum + (parseInt(month.employers) || 0), 0);
            const totalUsers = totalWorkers + totalEmployers;
            
            console.log('Calculated totals:', { totalWorkers, totalEmployers, totalUsers });
            
            if (totalUsers === 0) {
                document.getElementById('user-growth-annotation').textContent = 'No users registered yet';
                // Show a placeholder chart
                try {
                    window.userGrowthPieChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: ['No Data'],
                            datasets: [{
                                data: [1],
                                backgroundColor: ['#E5E7EB'],
                                borderWidth: 0
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                tooltip: { enabled: false }
                            }
                        }
                    });
                } catch (e) {
                    console.error('Error creating placeholder chart:', e);
                }
                return;
            }
            
            const workerPercentage = ((totalWorkers / totalUsers) * 100).toFixed(1);
            const employerPercentage = ((totalEmployers / totalUsers) * 100).toFixed(1);
            
            // Find peak month
            const peakMonth = userGrowthData.reduce((max, month) => {
                const maxTotal = (parseInt(max.workers) || 0) + (parseInt(max.employers) || 0);
                const currentTotal = (parseInt(month.workers) || 0) + (parseInt(month.employers) || 0);
                return currentTotal > maxTotal ? month : max;
            }, userGrowthData[0]);
            
            // Update growth rate and annotation
            const currentMonth = userGrowthData[userGrowthData.length - 1];
            const previousMonth = userGrowthData[userGrowthData.length - 2];
            let growthRate = 0;
            
            if (previousMonth) {
                const currentTotal = (parseInt(currentMonth.workers) || 0) + (parseInt(currentMonth.employers) || 0);
                const previousTotal = (parseInt(previousMonth.workers) || 0) + (parseInt(previousMonth.employers) || 0);
                if (previousTotal > 0) {
                    growthRate = ((currentTotal - previousTotal) / previousTotal * 100).toFixed(1);
                }
            }
            
            document.getElementById('user-growth-rate').textContent = `${growthRate >= 0 ? '+' : ''}${growthRate}%`;
            document.getElementById('user-growth-annotation').textContent = 
                `Peak activity in ${peakMonth.month} with ${(parseInt(peakMonth.workers) || 0) + (parseInt(peakMonth.employers) || 0)} new registrations. Workers represent ${workerPercentage}% of total users.`;
            
            // Create the pie chart
            try {
                console.log('Creating Chart.js pie chart...');
                
                const chartConfig = {
                    type: 'pie',
                    data: {
                        labels: ['Workers', 'Employers'],
                        datasets: [{
                            data: [totalWorkers, totalEmployers],
                            backgroundColor: [
                                '#3B82F6', // Blue for workers
                                '#10B981'  // Green for employers
                            ],
                            borderColor: [
                                '#2563EB',
                                '#059669'
                            ],
                            borderWidth: 2,
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true,
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.parsed;
                                        const percentage = ((value / totalUsers) * 100).toFixed(1);
                                        return `${label}: ${value.toLocaleString()} (${percentage}%)`;
                                    }
                                }
                            }
                        },
                        animation: {
                            animateRotate: true,
                            duration: 1000
                        }
                    }
                };
                
                console.log('Chart configuration:', chartConfig);
                
                window.userGrowthPieChart = new Chart(ctx, chartConfig);
                console.log('User growth pie chart created successfully:', window.userGrowthPieChart);
                
                // Force resize to ensure proper rendering
                setTimeout(() => {
                    if (window.userGrowthPieChart) {
                        window.userGrowthPieChart.resize();
                        console.log('Pie chart resized');
                    }
                }, 100);
            } catch (error) {
                console.error('Error creating user growth pie chart:', error);
                document.getElementById('user-growth-annotation').textContent = 'Error loading chart data';
            }
        }

        function renderJobTrendsDonutChart(jobTrendsData) {
            console.log('=== Rendering Job Trends Donut Chart ===');
            console.log('Data received:', jobTrendsData);
            
            const canvasElement = document.getElementById('jobTrendsDonutChart');
            if (!canvasElement) {
                console.error('Canvas element jobTrendsDonutChart not found!');
                return;
            }
            
            console.log('Canvas element found:', canvasElement);
            
            // Destroy any existing chart on this canvas using Chart.js API
            const existingChart = Chart.getChart(canvasElement);
            if (existingChart) {
                console.log('Found existing chart, destroying it...');
                existingChart.destroy();
            }
            
            // Get context
            const ctx = canvasElement.getContext('2d');
            if (!ctx) {
                console.error('Could not get 2D context from canvas!');
                return;
            }
            
            console.log('Canvas context obtained successfully');
            
            // Handle empty data
            if (!jobTrendsData || jobTrendsData.length === 0) {
                console.log('No job trends data available');
                document.getElementById('job-trends-annotation').textContent = 'No job trends data available';
                return;
            }
            
            // Calculate totals
            const totalPosted = jobTrendsData.reduce((sum, month) => sum + (parseInt(month.posted) || 0), 0);
            const totalCompleted = jobTrendsData.reduce((sum, month) => sum + (parseInt(month.completed) || 0), 0);
            const totalActive = jobTrendsData.reduce((sum, month) => sum + (parseInt(month.active) || 0), 0);
            
            console.log('Calculated totals:', { totalPosted, totalCompleted, totalActive });
            
            if (totalPosted === 0) {
                document.getElementById('job-trends-annotation').textContent = 'No jobs posted yet';
                // Show a placeholder chart
                try {
                    window.jobTrendsDonutChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ['No Data'],
                            datasets: [{
                                data: [1],
                                backgroundColor: ['#E5E7EB'],
                                borderWidth: 0
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '60%',
                            plugins: {
                                legend: { display: false },
                                tooltip: { enabled: false }
                            }
                        }
                    });
                } catch (e) {
                    console.error('Error creating placeholder chart:', e);
                }
                return;
            }
            
            const successRate = ((totalCompleted / totalPosted) * 100).toFixed(1);
            
            // Find best performing month
            const bestMonth = jobTrendsData.reduce((max, month) => 
                (parseInt(month.completed) || 0) > (parseInt(max.completed) || 0) ? month : max
            , jobTrendsData[0]);
            
            // Update success rate and annotation
            document.getElementById('job-success-rate').textContent = `${successRate}%`;
            document.getElementById('job-trends-annotation').textContent = 
                `Best performance in ${bestMonth.month} with ${parseInt(bestMonth.completed) || 0} completed jobs. ${totalActive} jobs currently active.`;
            
            // Calculate remaining jobs (posted but not completed or active)
            const remainingJobs = Math.max(0, totalPosted - totalCompleted - totalActive);
            
            try {
                console.log('Creating Chart.js donut chart...');
                
                const chartConfig = {
                    type: 'doughnut',
                    data: {
                        labels: ['Completed Jobs', 'Active Jobs', 'Other Jobs'],
                        datasets: [{
                            data: [totalCompleted, totalActive, remainingJobs],
                            backgroundColor: [
                                '#10B981', // Green for completed
                                '#F59E0B', // Yellow for active
                                '#6B7280'  // Gray for other
                            ],
                            borderColor: [
                                '#059669',
                                '#D97706',
                                '#4B5563'
                            ],
                            borderWidth: 2,
                            hoverOffset: 15
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '60%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true,
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.parsed;
                                        const total = totalPosted;
                                        const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                        return `${label}: ${value.toLocaleString()} (${percentage}%)`;
                                    }
                                }
                            }
                        },
                        animation: {
                            animateRotate: true,
                            duration: 1200
                        }
                    }
                };
                
                console.log('Chart configuration:', chartConfig);
                
                window.jobTrendsDonutChart = new Chart(ctx, chartConfig);
                console.log('Job trends donut chart created successfully:', window.jobTrendsDonutChart);
                
                // Force resize to ensure proper rendering
                setTimeout(() => {
                    if (window.jobTrendsDonutChart) {
                        window.jobTrendsDonutChart.resize();
                        console.log('Donut chart resized');
                    }
                }, 100);
            } catch (error) {
                console.error('Error creating job trends donut chart:', error);
                document.getElementById('job-trends-annotation').textContent = 'Error loading chart data';
            }
        }

        function updateAnalyticsMetrics(data) {
            console.log('Updating analytics metrics...');
            
            try {
                // Update best performing months
                if (data.userGrowth && data.userGrowth.length > 0) {
                    const bestUserMonth = data.userGrowth.reduce((max, month) => 
                        ((month.workers || 0) + (month.employers || 0)) > ((max.workers || 0) + (max.employers || 0)) ? month : max
                    );
                    const bestUserCount = (bestUserMonth.workers || 0) + (bestUserMonth.employers || 0);
                    document.getElementById('best-user-month').textContent = `${bestUserMonth.month} (${bestUserCount})`;
                } else {
                    document.getElementById('best-user-month').textContent = 'N/A';
                }
                
                if (data.jobTrends && data.jobTrends.length > 0) {
                    const bestJobMonth = data.jobTrends.reduce((max, month) => 
                        (month.posted || 0) > (max.posted || 0) ? month : max
                    );
                    document.getElementById('best-job-month').textContent = `${bestJobMonth.month} (${bestJobMonth.posted})`;
                } else {
                    document.getElementById('best-job-month').textContent = 'N/A';
                }
                
                if (data.revenueData && data.revenueData.length > 0) {
                    const bestRevenueMonth = data.revenueData.reduce((max, month) => 
                        (month.revenue || 0) > (max.revenue || 0) ? month : max
                    );
                    const revenueFormatted = new Intl.NumberFormat('en-UG', {
                        style: 'currency',
                        currency: 'UGX',
                        minimumFractionDigits: 0
                    }).format(bestRevenueMonth.revenue);
                    document.getElementById('best-revenue-month').textContent = `${bestRevenueMonth.month} (${revenueFormatted})`;
                } else {
                    document.getElementById('best-revenue-month').textContent = 'N/A';
                }
                
                // Update activity insights
                // Calculate peak activity day based on user registrations
                if (data.userGrowth && data.userGrowth.length > 0) {
                    // Calculate total users registered in the period
                    const totalUsers = data.userGrowth.reduce((sum, month) => sum + (month.total || 0), 0);
                    const monthsWithData = data.userGrowth.filter(m => m.total > 0).length;
                    
                    // Average daily registrations (total users / days in period)
                    const daysInPeriod = monthsWithData * 30; // Approximate
                    const avgDailyRegistrations = daysInPeriod > 0 ? Math.round(totalUsers / daysInPeriod * 10) / 10 : 0;
                    document.getElementById('avg-daily-registrations').textContent = avgDailyRegistrations;
                    
                    // Find peak activity month
                    const peakMonth = data.userGrowth.reduce((max, month) => 
                        (month.total || 0) > (max.total || 0) ? month : max
                    );
                    document.getElementById('peak-activity-day').textContent = peakMonth.month;
                } else {
                    document.getElementById('avg-daily-registrations').textContent = '0';
                    document.getElementById('peak-activity-day').textContent = 'N/A';
                }
                
                // Calculate conversion rate (applications accepted / total applications)
                if (data.applicationRates) {
                    const totalApplications = (data.applicationRates.pending || 0) + 
                                            (data.applicationRates.accepted || 0) + 
                                            (data.applicationRates.rejected || 0);
                    const conversionRate = totalApplications > 0 ? 
                        ((data.applicationRates.accepted || 0) / totalApplications * 100).toFixed(1) : 0;
                    document.getElementById('conversion-rate').textContent = `${conversionRate}%`;
                } else {
                    document.getElementById('conversion-rate').textContent = '0%';
                }
                
                console.log('Analytics metrics updated successfully');
            } catch (error) {
                console.error('Error updating analytics metrics:', error);
            }
        }

        function updatePerformanceTables(data) {
            console.log('Updating performance tables...');
            
            try {
                // Update employer performance table
                const employerTableBody = document.getElementById('employer-performance-table');
                employerTableBody.innerHTML = '';
                
                if (data.topEmployers && data.topEmployers.length > 0) {
                    data.topEmployers.forEach(employer => {
                        const row = `
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-900">${employer.name || 'Unknown'}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">${employer.jobs_count || 0}</td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="px-2 py-1 text-xs rounded-full ${(employer.success_rate || 0) >= 70 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'}">
                                        ${employer.success_rate || 0}%
                                    </span>
                                </td>
                            </tr>
                        `;
                        employerTableBody.innerHTML += row;
                    });
                } else {
                    employerTableBody.innerHTML = '<tr><td colspan="3" class="px-4 py-3 text-sm text-gray-500 text-center">No employer data available</td></tr>';
                }
                
                // Update worker performance table
                const workerTableBody = document.getElementById('worker-performance-table');
                workerTableBody.innerHTML = '';
                
                if (data.topWorkers && data.topWorkers.length > 0) {
                    data.topWorkers.forEach(worker => {
                        const row = `
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-900">${worker.name || 'Unknown'}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">${worker.applications_count || 0}</td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="px-2 py-1 text-xs rounded-full ${(worker.success_rate || 0) >= 50 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'}">
                                        ${worker.success_rate || 0}%
                                    </span>
                                </td>
                            </tr>
                        `;
                        workerTableBody.innerHTML += row;
                    });
                } else {
                    workerTableBody.innerHTML = '<tr><td colspan="3" class="px-4 py-3 text-sm text-gray-500 text-center">No worker data available</td></tr>';
                }
                
                console.log('Performance tables updated successfully');
            } catch (error) {
                console.error('Error updating performance tables:', error);
            }
        }

        function refreshAnalytics() {
            showAnalyticsNotification('Refreshing analytics data...', 'info');
            loadAnalyticsData();
        }

        function exportAnalyticsData() {
            showAnalyticsNotification('Preparing analytics export...', 'info');
            
            const exportUrl = '/admin/analytics/export';
            const link = document.createElement('a');
            link.href = exportUrl;
            link.download = `analytics_export_${new Date().toISOString().split('T')[0]}.csv`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            showAnalyticsNotification('Export started - download will begin shortly', 'success');
        }

        function generateMonthlyReport() {
            document.getElementById('monthlyReportModal').classList.remove('hidden');
        }

        function closeMonthlyReportModal() {
            document.getElementById('monthlyReportModal').classList.add('hidden');
        }

        function populateReportMonths() {
            const select = document.getElementById('report-month');
            const currentDate = new Date();
            
            // Populate last 12 months
            for (let i = 0; i < 12; i++) {
                const date = new Date(currentDate.getFullYear(), currentDate.getMonth() - i, 1);
                const option = document.createElement('option');
                option.value = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}`;
                option.textContent = date.toLocaleDateString('en-US', { year: 'numeric', month: 'long' });
                select.appendChild(option);
            }
        }

        function executeMonthlyReport() {
            const month = document.getElementById('report-month').value;
            const type = document.getElementById('report-type').value;
            
            if (!month) {
                showAnalyticsNotification('Please select a month', 'warning');
                return;
            }
            
            showAnalyticsNotification('Generating monthly report...', 'info');
            closeMonthlyReportModal();
            
            $.ajax({
                url: '/admin/reports/monthly',
                method: 'POST',
                data: {
                    month: month,
                    type: type
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        showAnalyticsNotification('Monthly report generated successfully', 'success');
                        
                        // Download the report
                        const link = document.createElement('a');
                        link.href = response.download_url;
                        link.download = response.filename;
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    } else {
                        showAnalyticsNotification(response.message || 'Failed to generate report', 'error');
                    }
                },
                error: function(xhr) {
                    const message = xhr.responseJSON?.message || 'An error occurred while generating the report';
                    showAnalyticsNotification(message, 'error');
                }
            });
        }

        function showAnalyticsNotification(message, type = 'info') {
            const notificationArea = document.getElementById('analytics-notification-area');
            const notification = document.getElementById('analytics-notification');
            const icon = document.getElementById('analytics-notification-icon');
            const messageSpan = document.getElementById('analytics-notification-message');
            
            const styles = {
                'success': {
                    classes: 'bg-green-100 border-green-400 text-green-700',
                    icon: 'fas fa-check-circle text-green-500'
                },
                'error': {
                    classes: 'bg-red-100 border-red-400 text-red-700',
                    icon: 'fas fa-exclamation-circle text-red-500'
                },
                'warning': {
                    classes: 'bg-yellow-100 border-yellow-400 text-yellow-700',
                    icon: 'fas fa-exclamation-triangle text-yellow-500'
                },
                'info': {
                    classes: 'bg-blue-100 border-blue-400 text-blue-700',
                    icon: 'fas fa-info-circle text-blue-500'
                }
            };
            
            const style = styles[type] || styles.info;
            
            notification.className = `p-3 rounded-lg border flex items-center justify-between ${style.classes}`;
            icon.className = style.icon + ' mr-2';
            messageSpan.textContent = message;
            
            notificationArea.classList.remove('hidden');
            
            setTimeout(() => {
                hideAnalyticsNotification();
            }, 5000);
        }

        function hideAnalyticsNotification() {
            document.getElementById('analytics-notification-area').classList.add('hidden');
        }

        // Helper function to safely destroy charts
        function safeDestroyChart(chartVariable) {
            if (chartVariable && typeof chartVariable.destroy === 'function') {
                try {
                    chartVariable.destroy();
                    console.log('Chart destroyed successfully');
                    return true;
                } catch (error) {
                    console.error('Error destroying chart:', error);
                    return false;
                }
            } else if (chartVariable) {
                console.log('Chart exists but no destroy method - clearing reference');
                return false;
            }
            return true;
        }

        // Test function for debugging
        function testAnalyticsLoad() {
            console.log('=== COMPREHENSIVE ANALYTICS DEBUG TEST ===');
            showAnalyticsNotification('Running comprehensive analytics test...', 'info');
            
            const results = [];
            
            // Test 1: Check if Chart.js is loaded
            const chartJsLoaded = typeof Chart !== 'undefined';
            results.push(`1. Chart.js loaded: ${chartJsLoaded}`);
            console.log(`1. Chart.js loaded: ${chartJsLoaded}`);
            
            if (!chartJsLoaded) {
                showAnalyticsNotification('Chart.js library not loaded! Check script tag.', 'error');
                return;
            }
            
            // Test 2: Check if canvas elements exist
            const pieCanvas = document.getElementById('userGrowthPieChart');
            const donutCanvas = document.getElementById('jobTrendsDonutChart');
            results.push(`2. Pie canvas exists: ${!!pieCanvas}`);
            results.push(`3. Donut canvas exists: ${!!donutCanvas}`);
            console.log(`2. Pie canvas exists: ${!!pieCanvas}`);
            console.log(`3. Donut canvas exists: ${!!donutCanvas}`);
            
            if (!pieCanvas || !donutCanvas) {
                showAnalyticsNotification('Canvas elements not found! Check HTML structure.', 'error');
                return;
            }
            
            // Test 3: Try to get canvas contexts
            let pieCtx = null, donutCtx = null;
            try {
                pieCtx = pieCanvas.getContext('2d');
                donutCtx = donutCanvas.getContext('2d');
                results.push(`4. Canvas contexts obtained: ${!!pieCtx && !!donutCtx}`);
                console.log(`4. Canvas contexts obtained: ${!!pieCtx && !!donutCtx}`);
            } catch (error) {
                results.push(`4. Canvas context error: ${error.message}`);
                console.error(`4. Canvas context error:`, error);
                showAnalyticsNotification('Canvas context error: ' + error.message, 'error');
                return;
            }
            
            // Test 4: Check modal visibility
            const modal = document.getElementById('analyticsModal');
            const modalVisible = modal && !modal.classList.contains('hidden');
            results.push(`5. Modal visible: ${modalVisible}`);
            console.log(`5. Modal visible: ${modalVisible}`);
            
            // Test 5: Try creating a simple test chart
            try {
                console.log('6. Creating test pie chart...');
                
                // Destroy existing chart if it exists and has destroy method
                if (window.userGrowthPieChart && typeof window.userGrowthPieChart.destroy === 'function') {
                    window.userGrowthPieChart.destroy();
                    console.log('Destroyed existing pie chart');
                } else if (window.userGrowthPieChart) {
                    console.log('Existing pie chart found but no destroy method - clearing reference');
                    window.userGrowthPieChart = null;
                }
                
                window.userGrowthPieChart = new Chart(pieCtx, {
                    type: 'pie',
                    data: {
                        labels: ['Test Workers', 'Test Employers'],
                        datasets: [{
                            data: [10, 5],
                            backgroundColor: ['#3B82F6', '#10B981'],
                            borderColor: ['#2563EB', '#059669'],
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
                
                results.push('6. Test pie chart created successfully');
                console.log('6. Test pie chart created successfully');
                
                // Update annotation
                document.getElementById('user-growth-annotation').textContent = 'Test chart created successfully!';
                
            } catch (error) {
                results.push(`6. Test chart error: ${error.message}`);
                console.error('6. Test chart error:', error);
                showAnalyticsNotification('Test chart creation failed: ' + error.message, 'error');
                return;
            }
            
            // Test 6: Try creating test donut chart
            try {
                console.log('7. Creating test donut chart...');
                
                // Destroy existing chart if it exists and has destroy method
                if (window.jobTrendsDonutChart && typeof window.jobTrendsDonutChart.destroy === 'function') {
                    window.jobTrendsDonutChart.destroy();
                    console.log('Destroyed existing donut chart');
                } else if (window.jobTrendsDonutChart) {
                    console.log('Existing donut chart found but no destroy method - clearing reference');
                    window.jobTrendsDonutChart = null;
                }
                
                window.jobTrendsDonutChart = new Chart(donutCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Test Completed', 'Test Active', 'Test Other'],
                        datasets: [{
                            data: [8, 3, 2],
                            backgroundColor: ['#10B981', '#F59E0B', '#6B7280'],
                            borderColor: ['#059669', '#D97706', '#4B5563'],
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '60%',
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
                
                results.push('7. Test donut chart created successfully');
                console.log('7. Test donut chart created successfully');
                
                // Update annotation
                document.getElementById('job-trends-annotation').textContent = 'Test chart created successfully!';
                
            } catch (error) {
                results.push(`7. Test donut chart error: ${error.message}`);
                console.error('7. Test donut chart error:', error);
                showAnalyticsNotification('Test donut chart creation failed: ' + error.message, 'error');
                return;
            }
            
            // Test 7: Try loading real data
            console.log('8. Testing real data load...');
            results.push('8. Attempting real data load...');
            
            $.ajax({
                url: '/admin/analytics',
                method: 'GET',
                timeout: 10000,
                success: function(response) {
                    results.push('9. Real data loaded successfully');
                    console.log('9. Real data loaded successfully:', response);
                    showAnalyticsNotification('All tests passed! Charts should be working.', 'success');
                    
                    // Try rendering with real data
                    if (response.userGrowth && response.userGrowth.length > 0) {
                        renderUserGrowthPieChart(response.userGrowth);
                    }
                    if (response.jobTrends && response.jobTrends.length > 0) {
                        renderJobTrendsDonutChart(response.jobTrends);
                    }
                },
                error: function(xhr, status, error) {
                    results.push(`9. Real data load failed: ${status} - ${error}`);
                    console.error('9. Real data load failed:', xhr, status, error);
                    showAnalyticsNotification(`Real data load failed: ${status}`, 'error');
                }
            });
            
            // Display all results
            console.log('=== TEST RESULTS SUMMARY ===');
            results.forEach(result => console.log(result));
        }

        // Close modals when clicking outside or pressing Escape
        document.addEventListener('click', function(e) {
            if (e.target.id === 'userManagementModal') closeUserManagementModal();
            if (e.target.id === 'jobManagementModal') closeJobManagementModal();
            if (e.target.id === 'analyticsModal') closeAnalyticsModal();
        });

        // Inline Confirmation System
        function showInlineConfirmation(message, onConfirm, onCancel = null, modalType = 'modal') {
            let notificationArea, notification, icon, messageSpan;
            
            // Determine which modal's notification area to use
            if (modalType === 'user') {
                notificationArea = document.getElementById('user-notification-area');
                notification = document.getElementById('user-notification');
                icon = document.getElementById('user-notification-icon');
                messageSpan = document.getElementById('user-notification-message');
            } else if (modalType === 'job') {
                notificationArea = document.getElementById('job-notification-area');
                notification = document.getElementById('job-notification');
                icon = document.getElementById('job-notification-icon');
                messageSpan = document.getElementById('job-notification-message');
            } else if (modalType === 'analytics') {
                notificationArea = document.getElementById('analytics-notification-area');
                notification = document.getElementById('analytics-notification');
                icon = document.getElementById('analytics-notification-icon');
                messageSpan = document.getElementById('analytics-notification-message');
            } else {
                // Default to messages modal
                notificationArea = document.getElementById('modal-notification-area');
                notification = document.getElementById('modal-notification');
                icon = document.getElementById('modal-notification-icon');
                messageSpan = document.getElementById('modal-notification-message');
            }
            
            // Check if elements exist, fallback to native confirm
            if (!notificationArea || !notification) {
                console.warn('Inline confirmation elements not found, using native confirm');
                if (confirm(message)) {
                    if (onConfirm) onConfirm();
                } else {
                    if (onCancel) onCancel();
                }
                return;
            }
            
            // Set confirmation styling
            notification.className = 'p-3 rounded-lg border flex items-center justify-between bg-yellow-100 border-yellow-400 text-yellow-700';
            if (icon) {
                icon.className = 'fas fa-question-circle text-yellow-500 mr-2';
            }
            
            // Create confirmation content
            const confirmationContent = `
                <div class="flex items-center flex-1">
                    <i class="fas fa-question-circle text-yellow-500 mr-2"></i>
                    <span class="text-sm font-medium">${message}</span>
                </div>
                <div class="flex space-x-2 ml-4">
                    <button onclick="handleInlineConfirm(true)" class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                        <i class="fas fa-check mr-1"></i>Yes
                    </button>
                    <button onclick="handleInlineConfirm(false)" class="bg-gray-600 text-white px-3 py-1 rounded text-sm hover:bg-gray-700">
                        <i class="fas fa-times mr-1"></i>No
                    </button>
                </div>
            `;
            
            notification.innerHTML = confirmationContent;
            notificationArea.classList.remove('hidden');
            
            // Store callbacks globally for the buttons to access
            window.currentConfirmCallback = onConfirm;
            window.currentCancelCallback = onCancel;
            window.currentNotificationArea = notificationArea;
        }

        function handleInlineConfirm(confirmed) {
            if (confirmed && window.currentConfirmCallback) {
                window.currentConfirmCallback();
            } else if (!confirmed && window.currentCancelCallback) {
                window.currentCancelCallback();
            }
            
            // Hide the notification
            if (window.currentNotificationArea) {
                window.currentNotificationArea.classList.add('hidden');
            }
            
            // Clean up global variables
            window.currentConfirmCallback = null;
            window.currentCancelCallback = null;
            window.currentNotificationArea = null;
        }

        // Admin Profile Dropdown Functions
        function toggleAdminProfileDropdown() {
            const dropdown = document.getElementById('adminProfileDropdown');
            dropdown.classList.toggle('hidden');
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('adminProfileDropdown');
            const button = event.target.closest('button[onclick="toggleAdminProfileDropdown()"]');
            
            if (!button && dropdown && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
        
        function openProfileSettings() {
            document.getElementById('adminProfileDropdown').classList.add('hidden');
            showProfileSettingsModal();
        }
        
        function openPasswordChange() {
            document.getElementById('adminProfileDropdown').classList.add('hidden');
            showPasswordChangeModal();
        }
        
        function openSessionManager() {
            document.getElementById('adminProfileDropdown').classList.add('hidden');
            showSessionManagerModal();
        }
        
        function openActivityLog() {
            document.getElementById('adminProfileDropdown').classList.add('hidden');
            showActivityLogModal();
        }
        
        function openSecuritySettings() {
            document.getElementById('adminProfileDropdown').classList.add('hidden');
            showSecuritySettingsModal();
        }
        
        function showProfileSettingsModal() {
            const modal = `
                <div id="profileSettingsModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full">
                        <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-blue-600 to-indigo-600">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-white">
                                    <i class="fas fa-user-cog text-2xl mr-3"></i>
                                    <div>
                                        <h3 class="text-xl font-semibold">Profile Settings</h3>
                                        <p class="text-sm opacity-90">Manage your admin profile information</p>
                                    </div>
                                </div>
                                <button onclick="closeProfileSettingsModal()" class="text-white hover:text-gray-200">
                                    <i class="fas fa-times text-2xl"></i>
                                </button>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                    <input type="text" value="{{ Auth::user()->name }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                    <input type="email" value="{{ Auth::user()->email }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                    <input type="tel" value="{{ Auth::user()->phone ?? 'Not set' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                        </div>
                        <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                            <button onclick="closeProfileSettingsModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                                Cancel
                            </button>
                            <button onclick="saveProfileSettings()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                <i class="fas fa-save mr-2"></i>Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', modal);
        }
        
        function closeProfileSettingsModal() {
            document.getElementById('profileSettingsModal')?.remove();
        }
        
        function saveProfileSettings() {
            showNotification('Profile settings saved successfully!', 'success');
            closeProfileSettingsModal();
        }
        
        function showPasswordChangeModal() {
            const modal = `
                <div id="passwordChangeModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                        <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-green-600 to-teal-600">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-white">
                                    <i class="fas fa-key text-2xl mr-3"></i>
                                    <div>
                                        <h3 class="text-xl font-semibold">Change Password</h3>
                                        <p class="text-sm opacity-90">Update your security credentials</p>
                                    </div>
                                </div>
                                <button onclick="closePasswordChangeModal()" class="text-white hover:text-gray-200">
                                    <i class="fas fa-times text-2xl"></i>
                                </button>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                                    <input type="password" autocomplete="current-password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                                    <input type="password" autocomplete="new-password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                                    <input type="password" autocomplete="new-password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                                </div>
                            </div>
                        </div>
                        <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                            <button onclick="closePasswordChangeModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                                Cancel
                            </button>
                            <button onclick="changePassword()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                <i class="fas fa-lock mr-2"></i>Update Password
                            </button>
                        </div>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', modal);
        }
        
        function closePasswordChangeModal() {
            document.getElementById('passwordChangeModal')?.remove();
        }
        
        function changePassword() {
            showNotification('Password updated successfully!', 'success');
            closePasswordChangeModal();
        }
        
        function showSessionManagerModal() {
            const modal = `
                <div id="sessionManagerModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                    <div class="bg-white rounded-lg shadow-xl max-w-3xl w-full">
                        <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-purple-600 to-pink-600">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-white">
                                    <i class="fas fa-sync text-2xl mr-3"></i>
                                    <div>
                                        <h3 class="text-xl font-semibold">Active Sessions</h3>
                                        <p class="text-sm opacity-90">Manage your login sessions across devices</p>
                                    </div>
                                </div>
                                <button onclick="closeSessionManagerModal()" class="text-white hover:text-gray-200">
                                    <i class="fas fa-times text-2xl"></i>
                                </button>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <i class="fas fa-desktop text-green-600 text-2xl mr-3"></i>
                                            <div>
                                                <div class="font-semibold text-gray-800">Current Session</div>
                                                <div class="text-sm text-gray-600">Windows • Chrome • {{ request()->ip() }}</div>
                                                <div class="text-xs text-gray-500 mt-1">Active now</div>
                                            </div>
                                        </div>
                                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs rounded-full">Active</span>
                                    </div>
                                </div>
                                
                                <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <i class="fas fa-mobile-alt text-gray-600 text-2xl mr-3"></i>
                                            <div>
                                                <div class="font-semibold text-gray-800">Mobile Device</div>
                                                <div class="text-sm text-gray-600">Android • Chrome Mobile</div>
                                                <div class="text-xs text-gray-500 mt-1">2 hours ago</div>
                                            </div>
                                        </div>
                                        <button class="px-3 py-1 bg-red-100 text-red-800 text-xs rounded-full hover:bg-red-200 transition">
                                            Revoke
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
                            <button onclick="closeSessionManagerModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', modal);
        }
        
        function closeSessionManagerModal() {
            document.getElementById('sessionManagerModal')?.remove();
        }
        
        function showActivityLogModal() {
            const modal = `
                <div id="activityLogModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                    <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] flex flex-col">
                        <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-yellow-600 to-orange-600 flex-shrink-0">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-white">
                                    <i class="fas fa-history text-2xl mr-3"></i>
                                    <div>
                                        <h3 class="text-xl font-semibold">Activity Log</h3>
                                        <p class="text-sm opacity-90">Recent admin actions and events</p>
                                    </div>
                                </div>
                                <button onclick="closeActivityLogModal()" class="text-white hover:text-gray-200">
                                    <i class="fas fa-times text-2xl"></i>
                                </button>
                            </div>
                        </div>
                        <div class="flex-1 overflow-y-auto p-6">
                            <div class="space-y-3">
                                <div class="flex items-start p-3 bg-blue-50 rounded-lg">
                                    <i class="fas fa-sign-in-alt text-blue-600 mt-1 mr-3"></i>
                                    <div class="flex-1">
                                        <div class="font-medium text-gray-800">Logged in</div>
                                        <div class="text-sm text-gray-600">{{ now()->format('M d, Y H:i') }}</div>
                                    </div>
                                </div>
                                <div class="flex items-start p-3 bg-green-50 rounded-lg">
                                    <i class="fas fa-check-circle text-green-600 mt-1 mr-3"></i>
                                    <div class="flex-1">
                                        <div class="font-medium text-gray-800">Approved job posting</div>
                                        <div class="text-sm text-gray-600">45 minutes ago</div>
                                    </div>
                                </div>
                                <div class="flex items-start p-3 bg-purple-50 rounded-lg">
                                    <i class="fas fa-user-check text-purple-600 mt-1 mr-3"></i>
                                    <div class="flex-1">
                                        <div class="font-medium text-gray-800">Verified user account</div>
                                        <div class="text-sm text-gray-600">1 hour ago</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 py-4 border-t border-gray-200 flex justify-end flex-shrink-0">
                            <button onclick="closeActivityLogModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', modal);
        }
        
        function closeActivityLogModal() {
            document.getElementById('activityLogModal')?.remove();
        }
        
        function showSecuritySettingsModal() {
            const modal = `
                <div id="securitySettingsModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full">
                        <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-red-600 to-pink-600">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-white">
                                    <i class="fas fa-shield-alt text-2xl mr-3"></i>
                                    <div>
                                        <h3 class="text-xl font-semibold">Security Settings</h3>
                                        <p class="text-sm opacity-90">Manage your account security</p>
                                    </div>
                                </div>
                                <button onclick="closeSecuritySettingsModal()" class="text-white hover:text-gray-200">
                                    <i class="fas fa-times text-2xl"></i>
                                </button>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <div class="font-medium text-gray-800">Two-Factor Authentication</div>
                                        <div class="text-sm text-gray-600">Add an extra layer of security</div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>
                                
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <div class="font-medium text-gray-800">Login Notifications</div>
                                        <div class="text-sm text-gray-600">Get notified of new logins</div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" checked class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>
                                
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <div class="font-medium text-gray-800">Session Timeout</div>
                                        <div class="text-sm text-gray-600">Auto-logout after inactivity</div>
                                    </div>
                                    <select class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                        <option>30 minutes</option>
                                        <option selected>1 hour</option>
                                        <option>2 hours</option>
                                        <option>Never</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                            <button onclick="closeSecuritySettingsModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                                Cancel
                            </button>
                            <button onclick="saveSecuritySettings()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                <i class="fas fa-save mr-2"></i>Save Settings
                            </button>
                        </div>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', modal);
        }
        
        function closeSecuritySettingsModal() {
            document.getElementById('securitySettingsModal')?.remove();
        }
        
        function saveSecuritySettings() {
            showNotification('Security settings updated successfully!', 'success');
            closeSecuritySettingsModal();
        }

        // Logout confirmation function
        function confirmLogout(event) {
            event.preventDefault();
            
            // Show the beautiful logout modal
            const modal = document.getElementById('logoutModal');
            const modalContent = document.getElementById('logoutModalContent');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            // Animate modal entrance
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
            
            // Calculate and display session time
            const sessionStart = new Date();
            sessionStart.setMinutes(sessionStart.getMinutes() - 45); // Approximate
            const duration = Math.floor((new Date() - sessionStart) / 60000);
            document.getElementById('sessionTime').textContent = `${duration} minutes`;
            
            return false;
        }
        
        function closeLogoutModal() {
            const modal = document.getElementById('logoutModal');
            const modalContent = document.getElementById('logoutModalContent');
            
            // Animate modal exit
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 200);
        }
        
        function proceedLogout() {
            // Show loading state
            const modal = document.getElementById('logoutModalContent');
            modal.innerHTML = `
                <div class="p-12 text-center">
                    <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-red-200 border-t-red-600 mb-4"></div>
                    <p class="text-gray-600 dark:text-gray-400">Logging out...</p>
                </div>
            `;
            
            // Submit the logout form
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
        
        // Admin Profile Dropdown Functions
        function toggleAdminProfileDropdown() {
            const dropdown = document.getElementById('adminProfileDropdown');
            dropdown.classList.toggle('hidden');
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('adminProfileDropdown');
            const button = event.target.closest('button[onclick="toggleAdminProfileDropdown()"]');
            
            if (!button && dropdown && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
        
        // Edit Admin Profile
        function openAdminProfileEdit() {
            document.getElementById('adminProfileDropdown').classList.add('hidden');
            
            const modal = document.createElement('div');
            modal.id = 'adminProfileEditModal';
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4';
            modal.innerHTML = `
                <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-user-edit text-blue-600 text-2xl mr-3"></i>
                                <h3 class="text-xl font-semibold text-gray-800">Edit Admin Profile</h3>
                            </div>
                            <button onclick="closeAdminProfileEditModal()" class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <form id="adminProfileForm">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                    <input type="text" value="{{ Auth::user()->name }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                    <input type="email" value="{{ Auth::user()->email }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                    <input type="tel" value="{{ Auth::user()->phone ?? '' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                                    <input type="text" value="Administrator" disabled class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100">
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                                <textarea rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Tell us about yourself..."></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                        <button onclick="closeAdminProfileEditModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                            Cancel
                        </button>
                        <button onclick="saveAdminProfile()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-save mr-2"></i>Save Changes
                        </button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
        }
        
        function closeAdminProfileEditModal() {
            const modal = document.getElementById('adminProfileEditModal');
            if (modal) modal.remove();
        }
        
        function saveAdminProfile() {
            showNotification('Profile updated successfully!', 'success');
            closeAdminProfileEditModal();
        }
        
        // Reset Admin Password
        function openAdminPasswordReset() {
            document.getElementById('adminProfileDropdown').classList.add('hidden');
            
            const modal = document.createElement('div');
            modal.id = 'adminPasswordResetModal';
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4';
            modal.innerHTML = `
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-key text-green-600 text-2xl mr-3"></i>
                                <h3 class="text-xl font-semibold text-gray-800">Reset Password</h3>
                            </div>
                            <button onclick="closeAdminPasswordResetModal()" class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <form id="adminPasswordForm">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                                <input type="password" autocomplete="current-password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                                <input type="password" autocomplete="new-password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                                <input type="password" autocomplete="new-password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                            </div>
                            <div class="p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <p class="text-xs text-yellow-800">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    Password must be at least 8 characters with uppercase, lowercase, and numbers.
                                </p>
                            </div>
                        </form>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                        <button onclick="closeAdminPasswordResetModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                            Cancel
                        </button>
                        <button onclick="resetAdminPassword()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            <i class="fas fa-check mr-2"></i>Reset Password
                        </button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
        }
        
        function closeAdminPasswordResetModal() {
            const modal = document.getElementById('adminPasswordResetModal');
            if (modal) modal.remove();
        }
        
        function resetAdminPassword() {
            showNotification('Password reset successfully!', 'success');
            closeAdminPasswordResetModal();
        }
        
        // Manage User Roles
        function openUserRoleManager() {
            document.getElementById('adminProfileDropdown').classList.add('hidden');
            showNotification('Opening User Role Manager...', 'info');
            // Navigate to users section with role filter
            showContent('users');
        }
        
        // Suspend/Deactivate Accounts
        function openAccountSuspension() {
            document.getElementById('adminProfileDropdown').classList.add('hidden');
            showNotification('Opening Account Suspension Manager...', 'info');
            // Navigate to users section
            showContent('users');
        }
        
        // View System-Wide User Data
        function openSystemUserData() {
            document.getElementById('adminProfileDropdown').classList.add('hidden');
            showNotification('Loading System-Wide User Data...', 'info');
            // Navigate to analytics section
            showContent('analytics');
        }
        
        // Activity Log
        function openActivityLog() {
            document.getElementById('adminProfileDropdown').classList.add('hidden');
            
            const modal = document.createElement('div');
            modal.id = 'activityLogModal';
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4';
            modal.innerHTML = `
                <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] flex flex-col">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-history text-indigo-600 text-2xl mr-3"></i>
                                <h3 class="text-xl font-semibold text-gray-800">My Activity Log</h3>
                            </div>
                            <button onclick="closeActivityLogModal()" class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                    </div>
                    <div class="flex-1 overflow-y-auto p-6">
                        <div class="space-y-4">
                            <div class="flex items-start p-4 bg-blue-50 rounded-lg border border-blue-200">
                                <i class="fas fa-sign-in-alt text-blue-600 mt-1 mr-3"></i>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">Logged in to admin panel</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ now()->format('M d, Y H:i:s') }}</p>
                                </div>
                            </div>
                            <div class="flex items-start p-4 bg-green-50 rounded-lg border border-green-200">
                                <i class="fas fa-check-circle text-green-600 mt-1 mr-3"></i>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">Approved job posting #1234</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ now()->subHours(2)->format('M d, Y H:i:s') }}</p>
                                </div>
                            </div>
                            <div class="flex items-start p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                                <i class="fas fa-user-slash text-yellow-600 mt-1 mr-3"></i>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">Suspended user account</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ now()->subHours(5)->format('M d, Y H:i:s') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
                        <button onclick="closeActivityLogModal()" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                            Close
                        </button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
        }
        
        function closeActivityLogModal() {
            const modal = document.getElementById('activityLogModal');
            if (modal) modal.remove();
        }

        // User Management Functions
        function suspendUser(userId) {
            // Create suspension modal
            const suspensionModal = `
                <div id="suspensionModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800">Suspend User</h3>
                            <p class="text-sm text-gray-600 mt-1">This action will restrict user access</p>
                        </div>
                        <div class="p-6">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Duration</label>
                                <select id="suspension-duration-single" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                    <option value="7">7 days</option>
                                    <option value="30">30 days</option>
                                    <option value="90">90 days</option>
                                    <option value="permanent">Permanent</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Reason</label>
                                <textarea id="suspension-reason-single" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Enter reason for suspension..."></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="flex items-center">
                                    <input type="checkbox" id="notify-user-suspension" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">Send notification email to user</span>
                                </label>
                            </div>
                        </div>
                        <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                            <button onclick="closeSuspensionModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800">Cancel</button>
                            <button onclick="executeSuspension(${userId})" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Suspend User</button>
                        </div>
                    </div>
                </div>
            `;
            
            $('body').append(suspensionModal);
        }

        function unsuspendUser(userId) {
            showInlineConfirmation(
                'Are you sure you want to unsuspend this user?',
                function() {
                    $.ajax({
                        url: `/admin/users/${userId}/unsuspend`,
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                showUserNotification('User unsuspended successfully', 'success');
                                loadUsersData();
                            } else {
                                showUserNotification(response.message || 'Failed to unsuspend user', 'error');
                            }
                        },
                        error: function(xhr) {
                            const message = xhr.responseJSON?.message || 'An error occurred';
                            showUserNotification(message, 'error');
                        }
                    });
                },
                function() {
                    showUserNotification('Unsuspension cancelled', 'info');
                },
                'user'
            );
        }

        function viewUserDetails(userId) {
            showUserNotification('Loading user details...', 'info');
            
            $.ajax({
                url: `/admin/users/${userId}`,
                method: 'GET',
                success: function(response) {
                    displayUserDetailsModal(response);
                },
                error: function(xhr) {
                    const message = xhr.responseJSON?.message || 'Failed to load user details';
                    showUserNotification(message, 'error');
                }
            });
        }

        function displayUserDetailsModal(data) {
            const user = data.user;
            const stats = data.stats;
            const recentActivity = data.recent_activity;
            
            const userDetailsModal = `
                <div id="userDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                    <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img class="h-16 w-16 rounded-full cursor-pointer hover:ring-2 hover:ring-blue-500 transition-all duration-200" 
                                         src="${user.profile_picture || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(user.name) + '&background=1e40af&color=ffffff'}" 
                                         alt="${user.name}"
                                         onclick="viewUserProfilePicture('${user.profile_picture || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(user.name) + '&background=1e40af&color=ffffff'}', '${user.name}', '${user.role}')"
                                         onerror="this.src='https://ui-avatars.com/api/?name=' + encodeURIComponent('${user.name}') + '&color=ffffff&background=1e40af&size=150'">>
                                    <div class="ml-4">
                                        <h3 class="text-xl font-semibold text-gray-800">${user.name}</h3>
                                        <p class="text-sm text-gray-600">${user.email}</p>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${user.role === 'worker' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'}">
                                            ${user.role.charAt(0).toUpperCase() + user.role.slice(1)}
                                        </span>
                                    </div>
                                </div>
                                <button onclick="closeUserDetailsModal()" class="text-gray-400 hover:text-gray-600 text-2xl">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <!-- User Statistics -->
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <div class="text-2xl font-bold text-blue-800">${stats.total_applications}</div>
                                    <div class="text-sm text-blue-600">Total Applications</div>
                                </div>
                                <div class="bg-green-50 p-4 rounded-lg">
                                    <div class="text-2xl font-bold text-green-800">${stats.accepted_applications}</div>
                                    <div class="text-sm text-green-600">Accepted</div>
                                </div>
                                <div class="bg-yellow-50 p-4 rounded-lg">
                                    <div class="text-2xl font-bold text-yellow-800">${stats.pending_applications}</div>
                                    <div class="text-sm text-yellow-600">Pending</div>
                                </div>
                                <div class="bg-red-50 p-4 rounded-lg">
                                    <div class="text-2xl font-bold text-red-800">${stats.rejected_applications}</div>
                                    <div class="text-sm text-red-600">Rejected</div>
                                </div>
                            </div>
                            
                            <!-- User Information -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h4 class="font-semibold text-gray-800 mb-3">Account Information</h4>
                                    <div class="space-y-2 text-sm">
                                        <div><span class="font-medium">Phone:</span> ${user.phone || 'Not provided'}</div>
                                        <div><span class="font-medium">Joined:</span> ${new Date(user.created_at).toLocaleDateString()}</div>
                                        <div><span class="font-medium">Account Age:</span> ${stats.account_age_days} days</div>
                                        <div><span class="font-medium">Status:</span> 
                                            <span class="${user.is_suspended ? 'text-red-600' : 'text-green-600'}">${user.is_suspended ? 'Suspended' : 'Active'}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h4 class="font-semibold text-gray-800 mb-3">Activity Stats</h4>
                                    <div class="space-y-2 text-sm">
                                        <div><span class="font-medium">Jobs Posted:</span> ${stats.total_jobs_posted}</div>
                                        <div><span class="font-medium">Active Jobs:</span> ${stats.active_jobs}</div>
                                        <div><span class="font-medium">Completed Jobs:</span> ${stats.completed_jobs}</div>
                                        <div><span class="font-medium">Avg Budget:</span> UGX ${Math.round(stats.average_job_budget || 0).toLocaleString()}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Recent Activity -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-gray-800 mb-3">Recent Activity</h4>
                                <div class="space-y-2 max-h-40 overflow-y-auto">
                                    ${recentActivity.map(activity => `
                                        <div class="flex items-center justify-between text-sm">
                                            <span>${activity.description}</span>
                                            <span class="text-gray-500">${new Date(activity.date).toLocaleDateString()}</span>
                                        </div>
                                    `).join('')}
                                </div>
                            </div>
                        </div>
                        
                        <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                            ${user.is_suspended ? 
                                `<button onclick="unsuspendUser(${user.id}); closeUserDetailsModal();" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Unsuspend User</button>` :
                                `<button onclick="suspendUser(${user.id}); closeUserDetailsModal();" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Suspend User</button>`
                            }
                            <button onclick="closeUserDetailsModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800">Close</button>
                        </div>
                    </div>
                </div>
            `;
            
            $('body').append(userDetailsModal);
        }

        function bulkUserAction() {
            const selectedUsers = $('.user-checkbox:checked').map(function() {
                return this.value;
            }).get();
            
            if (selectedUsers.length === 0) {
                showUserNotification('Please select at least one user', 'warning');
                return;
            }
            
            // Create bulk action modal
            const bulkActionModal = `
                <div id="bulkActionModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800">Bulk User Action</h3>
                            <p class="text-sm text-gray-600 mt-1">${selectedUsers.length} users selected</p>
                        </div>
                        <div class="p-6">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Action</label>
                                <select id="bulk-action-type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Action</option>
                                    <option value="suspend">Suspend Users</option>
                                    <option value="unsuspend">Unsuspend Users</option>
                                    <option value="delete">Delete Users</option>
                                </select>
                            </div>
                            <div id="suspension-options" class="hidden">
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Duration</label>
                                    <select id="suspension-duration" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                        <option value="7">7 days</option>
                                        <option value="30">30 days</option>
                                        <option value="90">90 days</option>
                                        <option value="permanent">Permanent</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Reason</label>
                                    <textarea id="suspension-reason" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Enter reason for suspension..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                            <button onclick="closeBulkActionModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800">Cancel</button>
                            <button onclick="executeBulkAction()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Execute Action</button>
                        </div>
                    </div>
                </div>
            `;
            
            $('body').append(bulkActionModal);
            
            // Show/hide suspension options based on action
            $('#bulk-action-type').on('change', function() {
                if ($(this).val() === 'suspend') {
                    $('#suspension-options').removeClass('hidden');
                } else {
                    $('#suspension-options').addClass('hidden');
                }
            });
        }

        function exportUsers() {
            showUserNotification('Preparing user export...', 'info');
            
            // Get current filters
            const filters = {
                search: $('#user-search').val(),
                role: $('#user-role-filter').val(),
                status: $('#user-status-filter').val()
            };
            
            // Create export URL with filters
            const params = new URLSearchParams();
            Object.keys(filters).forEach(key => {
                if (filters[key]) {
                    params.append(key, filters[key]);
                }
            });
            params.append('export', 'true');
            
            // Create download link
            const exportUrl = `/admin/users?${params.toString()}`;
            const link = document.createElement('a');
            link.href = exportUrl;
            link.download = `users_export_${new Date().toISOString().split('T')[0]}.csv`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            showUserNotification('Export started - download will begin shortly', 'success');
        }

        function applyUserFilters() {
            const filters = {
                search: $('#user-search').val(),
                role: $('#user-role-filter').val(),
                status: $('#user-status-filter').val()
            };
            
            showUserNotification('Applying filters...', 'info');
            loadUsersData(filters);
        }

        // Helper functions for user management modals and actions
        function closeBulkActionModal() {
            $('#bulkActionModal').remove();
        }
        
        function executeBulkAction() {
            const action = $('#bulk-action-type').val();
            const selectedUsers = $('.user-checkbox:checked').map(function() {
                return this.value;
            }).get();
            
            if (!action) {
                showUserNotification('Please select an action', 'warning');
                return;
            }
            
            let data = {
                action: action,
                user_ids: selectedUsers
            };
            
            if (action === 'suspend') {
                const reason = $('#suspension-reason').val().trim();
                const duration = $('#suspension-duration').val();
                
                if (!reason) {
                    showUserNotification('Please provide a reason for suspension', 'warning');
                    return;
                }
                
                data.reason = reason;
                data.duration = duration;
            }
            
            // Show loading
            showUserNotification('Processing bulk action...', 'info');
            closeBulkActionModal();
            
            $.ajax({
                url: '/admin/users/bulk-action',
                method: 'POST',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        showUserNotification(response.message, 'success');
                        // Refresh user table
                        loadUsersData();
                        // Uncheck all checkboxes
                        $('.user-checkbox').prop('checked', false);
                        $('#select-all-users').prop('checked', false);
                    } else {
                        showUserNotification(response.message || 'Action failed', 'error');
                    }
                },
                error: function(xhr) {
                    const message = xhr.responseJSON?.message || 'An error occurred';
                    showUserNotification(message, 'error');
                }
            });
        }
        
        function closeSuspensionModal() {
            $('#suspensionModal').remove();
        }
        
        function executeSuspension(userId) {
            const reason = $('#suspension-reason-single').val().trim();
            const duration = $('#suspension-duration-single').val();
            const notifyUser = $('#notify-user-suspension').is(':checked');
            
            if (!reason) {
                showUserNotification('Please provide a reason for suspension', 'warning');
                return;
            }
            
            closeSuspensionModal();
            showUserNotification('Processing suspension...', 'info');
            
            $.ajax({
                url: `/admin/users/${userId}/suspend`,
                method: 'POST',
                data: {
                    reason: reason,
                    duration: duration,
                    notify_user: notifyUser
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        showUserNotification('User suspended successfully', 'success');
                        loadUsersData();
                    } else {
                        showUserNotification(response.message || 'Failed to suspend user', 'error');
                    }
                },
                error: function(xhr) {
                    const message = xhr.responseJSON?.message || 'An error occurred';
                    showUserNotification(message, 'error');
                }
            });
        }
        
        function closeUserDetailsModal() {
            $('#userDetailsModal').remove();
        }
        
        function loadUsersData(filters = {}) {
            showUserNotification('Loading users...', 'info');
            
            $.ajax({
                url: '/admin/users',
                method: 'GET',
                data: filters,
                success: function(response) {
                    renderUsersTable(response.data);
                    renderUsersPagination(response);
                    showUserNotification('Users loaded successfully', 'success');
                },
                error: function(xhr) {
                    const message = xhr.responseJSON?.message || 'Failed to load users';
                    showUserNotification(message, 'error');
                }
            });
        }
        
        function renderUsersTable(users) {
            const tableBody = $('#users-table-body');
            tableBody.empty();
            
            if (users.length === 0) {
                tableBody.append(`
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            No users found matching the criteria
                        </td>
                    </tr>
                `);
                return;
            }
            
            users.forEach(user => {
                const statusBadge = user.is_suspended 
                    ? '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Suspended</span>'
                    : '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>';
                
                const roleBadge = user.role === 'worker' 
                    ? '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Worker</span>'
                    : '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Employer</span>';
                
                const suspendButton = user.is_suspended
                    ? `<button onclick="unsuspendUser(${user.id})" class="text-green-600 hover:text-green-900 mr-3">
                         <i class="fas fa-user-check mr-1"></i>Unsuspend
                       </button>`
                    : `<button onclick="suspendUser(${user.id})" class="text-red-600 hover:text-red-900">
                         <i class="fas fa-user-slash mr-1"></i>Suspend
                       </button>`;
                
                const row = `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" class="user-checkbox rounded border-gray-300" value="${user.id}">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <img class="h-8 w-8 rounded-full cursor-pointer hover:ring-2 hover:ring-blue-500 transition-all duration-200" 
                                     src="${user.profile_picture || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(user.name) + '&background=1e40af&color=ffffff'}" 
                                     alt="${user.name}"
                                     onclick="viewUserProfilePicture('${user.profile_picture || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(user.name) + '&background=1e40af&color=ffffff'}', '${user.name}', '${user.role}')"
                                     onerror="this.src='https://ui-avatars.com/api/?name=' + encodeURIComponent('${user.name}') + '&color=ffffff&background=1e40af&size=150'">>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">${user.name}</div>
                                    <div class="text-sm text-gray-500">${user.email}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">${roleBadge}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            ${new Date(user.created_at).toLocaleDateString()}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">${statusBadge}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            ${user.applications_count || 0} apps / ${user.jobs_count || 0} jobs
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="viewUserDetails(${user.id})" class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-eye mr-1"></i>View
                            </button>
                            ${suspendButton}
                        </td>
                    </tr>
                `;
                
                tableBody.append(row);
            });
        }
        
        function renderUsersPagination(response) {
            // Implement pagination if needed
            // This would depend on your pagination structure
        }

        // Select all users functionality
        $(document).on('change', '#select-all-users', function() {
            $('.user-checkbox').prop('checked', $(this).is(':checked'));
        });
        
        // Update select all when individual checkboxes change
        $(document).on('change', '.user-checkbox', function() {
            const totalCheckboxes = $('.user-checkbox').length;
            const checkedCheckboxes = $('.user-checkbox:checked').length;
            $('#select-all-users').prop('checked', totalCheckboxes === checkedCheckboxes);
        });

        // Job Management Functions
        function approveJob(jobId) {
            showInlineConfirmation(
                'Are you sure you want to approve this job?',
                function() {
                    showJobNotification('Job approved successfully', 'success');
                },
                function() {
                    showJobNotification('Job approval cancelled', 'info');
                },
                'job'
            );
        }

        function rejectJob(jobId) {
            showInlineConfirmation(
                'Are you sure you want to reject this job?',
                function() {
                    showJobNotification('Job rejected successfully', 'success');
                },
                function() {
                    showJobNotification('Job rejection cancelled', 'info');
                },
                'job'
            );
        }

        // System Management Functions (for settings modal)
        function backupDatabase() {
            showInlineConfirmation(
                'This will create a database backup. Continue?',
                function() {
                    showModalNotification('Database backup initiated...', 'info');
                },
                null,
                'modal'
            );
        }

        function toggleMaintenance() {
            showInlineConfirmation(
                'This will toggle maintenance mode. Continue?',
                function() {
                    showModalNotification('Maintenance mode toggled', 'success');
                },
                null,
                'modal'
            );
        }

        // Modal message search functionality
        $(document).on('input', '#modal-message-search', function() {
            const searchTerm = $(this).val().toLowerCase();
            $('#modal-conversations-list .conversation-item').each(function() {
                const userName = $(this).find('h4').text().toLowerCase();
                const userRole = $(this).find('.text-gray-500').text().toLowerCase();
                
                if (userName.includes(searchTerm) || userRole.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Close modal when clicking outside
        document.getElementById('messagesModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeMessagesModal();
            }
        });

        // Close modal with Escape key and add keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            const messagesModal = document.getElementById('messagesModal');
            const userModal = document.getElementById('userManagementModal');
            const jobModal = document.getElementById('jobManagementModal');
            const analyticsModal = document.getElementById('analyticsModal');
            
            const isMessagesOpen = !messagesModal.classList.contains('hidden');
            const isUserOpen = !userModal.classList.contains('hidden');
            const isJobOpen = !jobModal.classList.contains('hidden');
            const isAnalyticsOpen = !analyticsModal.classList.contains('hidden');
            
            if (e.key === 'Escape') {
                if (isMessagesOpen) closeMessagesModal();
                if (isUserOpen) closeUserManagementModal();
                if (isJobOpen) closeJobManagementModal();
                if (isAnalyticsOpen) closeAnalyticsModal();
            }
            
            if (isMessagesOpen) {
                switch(e.key) {
                    case 'Enter':
                        if (document.activeElement.id === 'modal-message-input') {
                            e.preventDefault();
                            sendModalMessage();
                        }
                        break;
                    case 'r':
                        if (e.ctrlKey || e.metaKey) {
                            e.preventDefault();
                            refreshModalMessages();
                        }
                        break;
                }
            }
        });

        // Comprehensive admin messaging test function
        function testAdminMessaging() {
            console.log('🔍 Testing Admin Messaging System...');
            
            // Test 1: Check if messages content exists and is positioned correctly
            const messagesContent = document.getElementById('messages-content');
            const adminContainer = document.getElementById('admin-content-container');
            const sidebar = document.querySelector('.w-64.bg-gray-800');
            
            if (!messagesContent) {
                console.error('❌ Messages content div not found');
                return;
            }
            
            console.log('✅ Messages content div found');
            
            // Test 2: Check positioning
            if (adminContainer && sidebar) {
                const messagesRect = messagesContent.getBoundingClientRect();
                const sidebarRect = sidebar.getBoundingClientRect();
                const containerRect = adminContainer.getBoundingClientRect();
                
                console.log('📍 Positioning Details:');
                console.log('- Sidebar right edge:', sidebarRect.right);
                console.log('- Messages left edge:', messagesRect.left);
                console.log('- Container left edge:', containerRect.left);
                console.log('- Messages is in main area:', messagesRect.left > sidebarRect.right);
                
                if (messagesRect.left > sidebarRect.right) {
                    console.log('✅ Messages content is correctly positioned in main area');
                } else {
                    console.log('❌ Messages content positioning issue');
                }
            }
            
            // Test 3: Test API endpoints
            console.log('🌐 Testing API endpoints...');
            
            fetch('/admin/messages/stats')
                .then(response => {
                    if (response.ok) {
                        console.log('✅ Message stats API working');
                        return response.json();
                    } else {
                        console.log('❌ Message stats API failed:', response.status);
                    }
                })
                .then(data => {
                    if (data) {
                        console.log('📊 Message stats:', data);
                    }
                })
                .catch(error => {
                    console.error('❌ API test failed:', error);
                });
            
            // Test 4: Test unread count API
            fetch('/admin/messages/unread-count')
                .then(response => {
                    if (response.ok) {
                        console.log('✅ Unread count API working');
                        return response.json();
                    } else {
                        console.log('❌ Unread count API failed:', response.status);
                    }
                })
                .then(data => {
                    if (data) {
                        console.log('📬 Unread count:', data);
                    }
                })
                .catch(error => {
                    console.error('❌ Unread count API test failed:', error);
                });
            
            console.log('🏁 Admin messaging system test completed. Check results above.');
        }

        // Auto-refresh stats every 5 minutes
        setInterval(function() {
            $.get('/admin/stats')
                .done(function(stats) {
                    updateDashboardStats(stats);
                });
        }, 300000); // 5 minutes

        function updateDashboardStats(stats) {
            // Update dashboard statistics in real-time
            $('.stat-total-users').text(stats.users.total.toLocaleString());
            $('.stat-active-jobs').text(stats.jobs.active.toLocaleString());
            $('.stat-pending-jobs').text(stats.jobs.pending.toLocaleString());
            $('.stat-total-applications').text(stats.applications.total.toLocaleString());
        }

        // Admin Messaging Functions
        let currentAdminConversation = null;
        let adminMessagePolling = null;

        function loadAdminMessages() {
            if (!$('#messages-content').hasClass('hidden')) {
                loadAdminConversations();
                loadAdminMessageStats();
                
                // Start polling for new messages
                if (adminMessagePolling) clearInterval(adminMessagePolling);
                adminMessagePolling = setInterval(loadAdminConversations, 30000); // Poll every 30 seconds
            }
        }

        function loadAdminConversations() {
            $.get('/admin/messages/conversations')
                .done(function(conversations) {
                    renderAdminConversations(conversations);
                    updateAdminUnreadBadge();
                })
                .fail(function() {
                    showNotification('Error loading conversations', 'error');
                });
        }

        function renderAdminConversations(conversations) {
            const container = $('#admin-conversations-list');
            container.empty();

            if (conversations.length === 0) {
                container.html(`
                    <div class="text-center text-gray-500 py-8">
                        <i class="fas fa-inbox text-4xl mb-4 text-gray-300"></i>
                        <p class="font-medium">No conversations yet</p>
                        <p class="text-sm text-gray-400">Users will appear here when they send messages</p>
                    </div>
                `);
                return;
            }

            conversations.forEach(conv => {
                const unreadBadge = conv.unread_count > 0 
                    ? `<span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">${conv.unread_count}</span>`
                    : '';
                
                const lastMessage = conv.last_message 
                    ? conv.last_message.message.substring(0, 50) + (conv.last_message.message.length > 50 ? '...' : '')
                    : 'No messages yet';

                const timeAgo = conv.last_message 
                    ? new Date(conv.last_message.created_at).toLocaleDateString() + ' ' + new Date(conv.last_message.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})
                    : '';

                const conversationHtml = `
                    <div class="conversation-item p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-blue-50 transition-colors mb-3 ${currentAdminConversation === conv.user.id ? 'bg-blue-50 border-blue-300' : 'bg-white'}" 
                         onclick="openAdminConversation(${conv.user.id})">
                        <div class="flex items-start">
                            <img class="h-12 w-12 rounded-full mr-3 flex-shrink-0" 
                                 src="${conv.user.profile_picture || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(conv.user.name) + '&background=1e40af&color=ffffff'}" 
                                 alt="${conv.user.name}">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <h4 class="font-semibold text-gray-900 text-sm truncate">${conv.user.name}</h4>
                                    ${unreadBadge}
                                </div>
                                <p class="text-xs text-gray-500 capitalize mb-2">
                                    <i class="fas fa-${conv.user.role === 'worker' ? 'user' : 'building'} mr-1"></i>
                                    ${conv.user.role}
                                </p>
                                <p class="text-sm text-gray-600 truncate mb-1">${lastMessage}</p>
                                <p class="text-xs text-gray-400">${timeAgo}</p>
                            </div>
                        </div>
                    </div>
                `;
                container.append(conversationHtml);
            });
        }

        function openAdminConversation(userId) {
            currentAdminConversation = userId;
            
            // Update conversation list styling
            $('.conversation-item').removeClass('bg-blue-50 border-blue-300').addClass('bg-white');
            $(`.conversation-item[onclick="openAdminConversation(${userId})"]`).removeClass('bg-white').addClass('bg-blue-50 border-blue-300');
            
            // Load conversation messages
            $.get(`/messages/conversation/${userId}`)
                .done(function(response) {
                    renderAdminConversation(response);
                    $('#admin-chat-header').show();
                    $('#admin-message-input-area').show();
                    $('#view-profile-btn').show();
                    $('#mark-read-btn').show();
                })
                .fail(function() {
                    showNotification('Error loading conversation', 'error');
                });
        }

        function renderAdminConversation(response) {
            const { messages, other_user, current_user } = response;
            
            // Update chat header
            $('#admin-chat-user-avatar').attr('src', other_user.profile_picture || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(other_user.name) + '&background=1e40af&color=ffffff');
            $('#admin-chat-user-name').text(other_user.name);
            $('#admin-chat-user-role').text(other_user.role.charAt(0).toUpperCase() + other_user.role.slice(1));
            
            // Render messages
            const container = $('#admin-messages-container');
            container.empty();
            
            if (messages.length === 0) {
                container.html(`
                    <div class="text-center text-gray-500 mt-20">
                        <i class="fas fa-comment-dots text-4xl mb-4 text-gray-300"></i>
                        <p class="font-medium">No messages in this conversation</p>
                        <p class="text-sm">Start the conversation by sending a message below</p>
                    </div>
                `);
                return;
            }
            
            messages.forEach(message => {
                const isAdmin = message.sender_id === current_user.id;
                const messageClass = isAdmin ? 'justify-end' : 'justify-start';
                const bubbleClass = isAdmin 
                    ? 'bg-blue-600 text-white ml-12' 
                    : 'bg-white text-gray-800 border border-gray-200 mr-12';
                
                const senderName = isAdmin ? 'You (Admin)' : other_user.name;
                const timeFormatted = new Date(message.created_at).toLocaleDateString() + ' ' + 
                                    new Date(message.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                
                const messageHtml = `
                    <div class="flex ${messageClass} mb-4">
                        <div class="max-w-xs lg:max-w-md">
                            <div class="px-4 py-3 rounded-lg ${bubbleClass} shadow-sm">
                                <p class="text-sm font-medium mb-1 ${isAdmin ? 'text-blue-100' : 'text-gray-600'}">${senderName}</p>
                                <p class="text-sm leading-relaxed">${message.message}</p>
                                <p class="text-xs mt-2 ${isAdmin ? 'text-blue-200' : 'text-gray-500'}">
                                    ${timeFormatted}
                                </p>
                            </div>
                        </div>
                    </div>
                `;
                container.append(messageHtml);
            });
            
            // Scroll to bottom
            container.scrollTop(container[0].scrollHeight);
        }

        function sendAdminMessage() {
            const messageInput = $('#admin-message-input');
            const message = messageInput.val().trim();
            
            if (!message || !currentAdminConversation) return;
            
            $.post('/messages/send', {
                receiver_id: currentAdminConversation,
                message: message
            })
            .done(function(response) {
                if (response.success) {
                    messageInput.val('');
                    openAdminConversation(currentAdminConversation); // Refresh conversation
                    loadAdminConversations(); // Refresh conversation list
                }
            })
            .fail(function() {
                showNotification('Error sending message', 'error');
            });
        }

        function sendQuickReply(message) {
            if (!currentAdminConversation) return;
            
            $('#admin-message-input').val(message);
            sendAdminMessage();
        }

        function refreshAdminMessages() {
            loadAdminConversations();
            if (currentAdminConversation) {
                openAdminConversation(currentAdminConversation);
            }
            showNotification('Messages refreshed', 'success');
        }

        function loadAdminMessageStats() {
            $.get('/admin/messages/stats')
                .done(function(stats) {
                    $('#admin-total-messages').text(stats.total_messages);
                    $('#admin-unread-messages').text(stats.unread_messages);
                    $('#admin-messages-today').text(stats.messages_today);
                })
                .fail(function() {
                    console.log('Error loading message stats');
                });
        }

        function updateAdminUnreadBadge() {
            $.get('/admin/messages/unread-count')
                .done(function(response) {
                    const count = response.count;
                    const badge = $('#admin-unread-badge');
                    
                    if (count > 0) {
                        badge.text(count).removeClass('hidden');
                    } else {
                        badge.addClass('hidden');
                    }
                    
                    $('#admin-unread-messages').text(count);
                })
                .fail(function() {
                    console.log('Error loading unread count');
                });
        }

        function markConversationAsRead() {
            if (!currentAdminConversation) return;
            
            $.post(`/messages/conversation/${currentAdminConversation}/read`)
                .done(function() {
                    loadAdminConversations();
                    updateAdminUnreadBadge();
                    showNotification('Conversation marked as read', 'success');
                })
                .fail(function() {
                    showNotification('Error marking conversation as read', 'error');
                });
        }

        // Enhanced Confirmation Dialog with User Count
        function showBroadcastConfirmDialog(audience, type, message, sendEmail, isUrgent, onConfirm) {
            const dialogId = 'broadcast-confirm-' + Date.now();
            
            const overlay = document.createElement('div');
            overlay.id = dialogId;
            overlay.className = 'fixed inset-0 bg-black bg-opacity-50 z-[9999] flex items-center justify-center p-4 animate-fade-in';
            overlay.innerHTML = `
                <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full transform animate-scale-in">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6 rounded-t-2xl">
                        <div class="flex items-center space-x-4">
                            <div class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                                <i class="fas fa-bullhorn text-white text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-white">Confirm Broadcast</h3>
                                <p class="text-blue-100 text-sm">Review before sending</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Body -->
                    <div class="p-6 space-y-4">
                        <!-- User Count Section -->
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-4 border border-blue-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-users text-white"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Recipients</p>
                                        <p class="text-2xl font-bold text-gray-800" id="recipient-count-${dialogId}">
                                            <i class="fas fa-spinner fa-spin text-blue-600"></i>
                                        </p>
                                    </div>
                                </div>
                                <button onclick="verifyRecipients('${dialogId}', '${audience}')" 
                                        class="px-4 py-2 bg-white hover:bg-gray-50 text-blue-600 rounded-lg font-semibold text-sm border border-blue-200 transition transform hover:scale-105 shadow-sm">
                                    <i class="fas fa-sync-alt mr-2"></i>Verify
                                </button>
                            </div>
                        </div>
                        
                        <!-- Message Details -->
                        <div class="space-y-3">
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-users-cog text-blue-600 mt-1"></i>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-500">Audience</p>
                                    <p class="font-semibold text-gray-800 capitalize">${audience.replace('_', ' ')}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-tag text-purple-600 mt-1"></i>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-500">Message Type</p>
                                    <p class="font-semibold text-gray-800 capitalize">${type}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-comment-alt text-green-600 mt-1"></i>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-500">Message Preview</p>
                                    <p class="text-gray-700 text-sm bg-gray-50 p-3 rounded-lg border border-gray-200 max-h-24 overflow-y-auto">${message}</p>
                                </div>
                            </div>
                            
                            ${sendEmail ? '<div class="flex items-center space-x-2 text-sm text-blue-600"><i class="fas fa-envelope"></i><span>Email notification enabled</span></div>' : ''}
                            ${isUrgent ? '<div class="flex items-center space-x-2 text-sm text-red-600"><i class="fas fa-exclamation-triangle"></i><span>Marked as urgent</span></div>' : ''}
                        </div>
                        
                        <!-- Warning -->
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 flex items-start space-x-3">
                            <i class="fas fa-info-circle text-yellow-600 mt-0.5"></i>
                            <p class="text-sm text-yellow-800">This message will be sent to all selected users and cannot be undone.</p>
                        </div>
                    </div>
                    
                    <!-- Footer -->
                    <div class="p-6 bg-gray-50 rounded-b-2xl flex space-x-3">
                        <button onclick="handleBroadcastConfirm('${dialogId}', false)" 
                                class="flex-1 px-6 py-3 bg-white hover:bg-gray-100 text-gray-700 rounded-xl font-semibold transition transform hover:scale-105 border border-gray-300 shadow-sm">
                            <i class="fas fa-times mr-2"></i>Cancel
                        </button>
                        <button onclick="handleBroadcastConfirm('${dialogId}', true)" 
                                class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl font-semibold transition transform hover:scale-105 shadow-lg">
                            <i class="fas fa-paper-plane mr-2"></i>Send Broadcast
                        </button>
                    </div>
                </div>
            `;
            
            document.body.appendChild(overlay);
            
            // Store callback
            window['broadcastConfirmCallback_' + dialogId] = onConfirm;
            
            // Auto-fetch recipient count
            verifyRecipients(dialogId, audience);
            
            // Close on overlay click
            overlay.addEventListener('click', function(e) {
                if (e.target === overlay) {
                    handleBroadcastConfirm(dialogId, false);
                }
            });
            
            return dialogId;
        }

        function verifyRecipients(dialogId, audience) {
            const countElement = document.getElementById('recipient-count-' + dialogId);
            if (!countElement) return;
            
            countElement.innerHTML = '<i class="fas fa-spinner fa-spin text-blue-600"></i>';
            
            $.ajax({
                url: '/admin/messages/count-recipients',
                method: 'GET',
                data: { audience: audience },
                success: function(response) {
                    if (response.success) {
                        countElement.innerHTML = `<span class="text-blue-600">${response.count}</span> <span class="text-sm text-gray-500">users</span>`;
                    } else {
                        countElement.innerHTML = '<span class="text-red-600">Error</span>';
                    }
                },
                error: function() {
                    countElement.innerHTML = '<span class="text-red-600">Error</span>';
                }
            });
        }

        function handleBroadcastConfirm(dialogId, confirmed) {
            const dialog = document.getElementById(dialogId);
            if (!dialog) return;
            
            if (confirmed && window['broadcastConfirmCallback_' + dialogId]) {
                window['broadcastConfirmCallback_' + dialogId]();
            }
            
            // Animate out
            dialog.classList.add('animate-fade-out');
            setTimeout(() => {
                dialog.remove();
                delete window['broadcastConfirmCallback_' + dialogId];
            }, 200);
        }

        function sendBroadcastMessage() {
            const audience = $('#broadcast-audience').val();
            const type = $('#broadcast-type').val();
            const message = $('#broadcast-message').val().trim();
            const sendEmail = $('#broadcast-email').is(':checked');
            const isUrgent = $('#broadcast-urgent').is(':checked');
            
            if (!message) {
                showToast('Please enter a message', 'warning');
                return;
            }
            
            showBroadcastConfirmDialog(
                audience,
                type,
                message,
                sendEmail,
                isUrgent,
                function() {
                    const button = $('#broadcast-message-form button[type="submit"]');
                    const originalText = button.html();
                    button.html('<i class="fas fa-spinner fa-spin mr-2"></i>Sending...').prop('disabled', true);
                    
                    $.ajax({
                        url: '/admin/messages/broadcast',
                        method: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            audience: audience,
                            type: type,
                            message: message,
                            send_email: sendEmail ? 1 : 0,
                            is_urgent: isUrgent ? 1 : 0
                        },
                        success: function(response) {
                            if (response.success) {
                                showToast(response.message || 'Broadcast sent successfully', 'success');
                                $('#broadcast-message').val('');
                                $('#broadcast-email').prop('checked', false);
                                $('#broadcast-urgent').prop('checked', false);
                                if (typeof loadAdminMessageStats === 'function') {
                                    loadAdminMessageStats();
                                }
                            } else {
                                showToast(response.message || 'Failed to send broadcast', 'error');
                            }
                        },
                        error: function(xhr) {
                            let errorMsg = 'Error sending broadcast message';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                                const errors = Object.values(xhr.responseJSON.errors).flat();
                                errorMsg = errors.join(', ');
                            }
                            console.error('Broadcast error:', xhr.responseJSON);
                            showToast(errorMsg, 'error');
                        },
                        complete: function() {
                            button.html(originalText).prop('disabled', false);
                        }
                    });
                }
            );
        }

        function viewUserProfile() {
            if (currentAdminConversation) {
                viewUserDetails(currentAdminConversation);
            }
        }

        // Messages notification functions
        function showMessagesNotification(message, type = 'info') {
            const notificationArea = document.getElementById('messages-notification-area');
            const notification = document.getElementById('messages-notification');
            const icon = document.getElementById('messages-notification-icon');
            const messageSpan = document.getElementById('messages-notification-message');
            
            if (!notificationArea || !notification || !icon || !messageSpan) {
                console.warn('Messages notification elements not found');
                return;
            }
            
            const styles = {
                'success': {
                    classes: 'bg-green-100 border-green-400 text-green-700',
                    icon: 'fas fa-check-circle text-green-500'
                },
                'error': {
                    classes: 'bg-red-100 border-red-400 text-red-700',
                    icon: 'fas fa-exclamation-circle text-red-500'
                },
                'warning': {
                    classes: 'bg-yellow-100 border-yellow-400 text-yellow-700',
                    icon: 'fas fa-exclamation-triangle text-yellow-500'
                },
                'info': {
                    classes: 'bg-blue-100 border-blue-400 text-blue-700',
                    icon: 'fas fa-info-circle text-blue-500'
                }
            };
            
            const style = styles[type] || styles.info;
            
            notification.className = `p-3 rounded-lg border flex items-center justify-between ${style.classes}`;
            icon.className = style.icon + ' mr-2';
            messageSpan.textContent = message;
            
            notificationArea.classList.remove('hidden');
            
            setTimeout(() => {
                hideMessagesNotification();
            }, 5000);
        }

        function hideMessagesNotification() {
            const notificationArea = document.getElementById('messages-notification-area');
            if (notificationArea) {
                notificationArea.classList.add('hidden');
            }
        }

        // Message search functionality
        $('#admin-message-search').on('input', function() {
            const searchTerm = $(this).val().toLowerCase();
            $('.conversation-item').each(function() {
                const userName = $(this).find('h4').text().toLowerCase();
                const userRole = $(this).find('.text-gray-500').text().toLowerCase();
                
                if (userName.includes(searchTerm) || userRole.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Enter key to send message
        $('#admin-message-input').on('keypress', function(e) {
            if (e.which === 13) {
                sendAdminMessage();
            }
        });

        // Update the showContent function to load messages when messages section is selected
        const originalShowContent = window.showContent;
        window.showContent = function(contentId) {
            if (originalShowContent) {
                originalShowContent(contentId);
            }
            if (contentId === 'messages') {
                loadAdminMessages();
            } else if (adminMessagePolling) {
                clearInterval(adminMessagePolling);
                adminMessagePolling = null;
            }
        };

        // Note: loadAnalyticsData() is defined comprehensively below in the analytics section

        function loadModerationData() {
            // Load moderation data
            console.log('Loading moderation data...');
        }

        // Helper functions for notifications and loading states
        function showNotification(message, type = 'info') {
            const alertClass = {
                'success': 'bg-green-100 border-green-400 text-green-700',
                'error': 'bg-red-100 border-red-400 text-red-700',
                'warning': 'bg-yellow-100 border-yellow-400 text-yellow-700',
                'info': 'bg-blue-100 border-blue-400 text-blue-700'
            };

            const notification = $(`
                <div class="fixed top-4 right-4 z-50 p-4 border rounded-lg ${alertClass[type]} notification-alert">
                    <div class="flex items-center">
                        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'} mr-2"></i>
                        <span>${message}</span>
                        <button onclick="$(this).parent().parent().remove()" class="ml-4 text-lg">&times;</button>
                    </div>
                </div>
            `);

            $('body').append(notification);
            
            setTimeout(() => {
                notification.fadeOut(() => notification.remove());
            }, 5000);
        }

        function showLoading(elementId) {
            $(`#${elementId}`).html('<div class="text-center py-4"><i class="fas fa-spinner fa-spin text-2xl"></i><p class="mt-2">Loading...</p></div>');
        }

        function hideLoading(elementId) {
            // Loading will be replaced by actual content
        }

        // Modern Toast Notification System
        function showToast(message, type = 'success', duration = 5000) {
            const toastContainer = document.getElementById('toast-container') || createToastContainer();
            
            const toastId = 'toast-' + Date.now();
            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                warning: 'fa-exclamation-triangle',
                info: 'fa-info-circle'
            };
            
            const colors = {
                success: 'from-green-500 to-green-600',
                error: 'from-red-500 to-red-600',
                warning: 'from-yellow-500 to-yellow-600',
                info: 'from-blue-500 to-blue-600'
            };
            
            const toast = document.createElement('div');
            toast.id = toastId;
            toast.className = 'toast-notification transform translate-x-full';
            toast.innerHTML = `
                <div class="bg-gradient-to-r ${colors[type]} text-white px-6 py-4 rounded-xl shadow-2xl flex items-center space-x-4 min-w-[320px] max-w-md">
                    <i class="fas ${icons[type]} text-2xl"></i>
                    <div class="flex-1">
                        <p class="font-semibold text-sm">${message}</p>
                    </div>
                    <button onclick="closeToast('${toastId}')" class="text-white hover:text-gray-200 transition">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
            `;
            
            toastContainer.appendChild(toast);
            
            // Trigger animation
            setTimeout(() => {
                toast.classList.remove('translate-x-full');
                toast.classList.add('translate-x-0');
            }, 10);
            
            // Auto remove
            if (duration > 0) {
                setTimeout(() => {
                    closeToast(toastId);
                }, duration);
            }
            
            return toastId;
        }

        function closeToast(toastId) {
            const toast = document.getElementById(toastId);
            if (toast) {
                toast.classList.remove('translate-x-0');
                toast.classList.add('translate-x-full');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }
        }

        function createToastContainer() {
            const container = document.createElement('div');
            container.id = 'toast-container';
            container.className = 'fixed top-20 right-4 z-[9999] space-y-3';
            document.body.appendChild(container);
            return container;
        }

        // Modern Confirmation Dialog
        function showConfirmDialog(message, onConfirm, onCancel = null) {
            const dialogId = 'confirm-dialog-' + Date.now();
            
            const overlay = document.createElement('div');
            overlay.id = dialogId;
            overlay.className = 'fixed inset-0 bg-black bg-opacity-50 z-[9999] flex items-center justify-center p-4 animate-fade-in';
            overlay.innerHTML = `
                <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform animate-scale-in">
                    <div class="p-6">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-question text-white text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">Confirm Action</h3>
                        </div>
                        <p class="text-gray-600 mb-6">${message}</p>
                        <div class="flex space-x-3">
                            <button onclick="handleConfirmDialog('${dialogId}', false)" 
                                    class="flex-1 px-4 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-xl font-semibold transition transform hover:scale-105">
                                <i class="fas fa-times mr-2"></i>Cancel
                            </button>
                            <button onclick="handleConfirmDialog('${dialogId}', true)" 
                                    class="flex-1 px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl font-semibold transition transform hover:scale-105 shadow-lg">
                                <i class="fas fa-check mr-2"></i>Confirm
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            document.body.appendChild(overlay);
            
            // Store callbacks
            window['confirmCallback_' + dialogId] = onConfirm;
            window['cancelCallback_' + dialogId] = onCancel;
            
            // Close on overlay click
            overlay.addEventListener('click', function(e) {
                if (e.target === overlay) {
                    handleConfirmDialog(dialogId, false);
                }
            });
            
            return dialogId;
        }

        function handleConfirmDialog(dialogId, confirmed) {
            const dialog = document.getElementById(dialogId);
            if (!dialog) return;
            
            if (confirmed && window['confirmCallback_' + dialogId]) {
                window['confirmCallback_' + dialogId]();
            } else if (!confirmed && window['cancelCallback_' + dialogId]) {
                window['cancelCallback_' + dialogId]();
            }
            
            // Animate out
            dialog.classList.add('animate-fade-out');
            setTimeout(() => {
                dialog.remove();
                delete window['confirmCallback_' + dialogId];
                delete window['cancelCallback_' + dialogId];
            }, 200);
        }

        // Add CSS animations
        const style = document.createElement('style');
        style.textContent = `
            .toast-notification {
                transition: transform 0.3s ease-out;
            }
            
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
            
            @keyframes fadeOut {
                from { opacity: 1; }
                to { opacity: 0; }
            }
            
            @keyframes scaleIn {
                from { 
                    opacity: 0;
                    transform: scale(0.9);
                }
                to { 
                    opacity: 1;
                    transform: scale(1);
                }
            }
            
            .animate-fade-in {
                animation: fadeIn 0.2s ease-out;
            }
            
            .animate-fade-out {
                animation: fadeOut 0.2s ease-out;
            }
            
            .animate-scale-in {
                animation: scaleIn 0.3s ease-out;
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>