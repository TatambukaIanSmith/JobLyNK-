
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - JOB-lyNK</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }
        
        /* Animated Gradient Background */
        .glass-background {
            background: #e8effc;
            min-height: 100vh;
            position: relative;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* Floating Particles */
        .glass-background::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 20% 30%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(255, 255, 255, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(255, 255, 255, 0.06) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite;
            pointer-events: none;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        /* Enhanced Sidebar */
        .settings-sidebar {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            border-radius: 24px;
            position: sticky;
            top: 24px;
        }
        
        .settings-nav-item {
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .settings-nav-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }
        
        .settings-nav-item:hover {
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.1) 0%, rgba(59, 130, 246, 0.1) 100%);
            transform: translateX(4px);
        }
        
        .settings-nav-item.active {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: white;
            font-weight: 600;
            box-shadow: 0 8px 20px rgba(30, 64, 175, 0.4);
            transform: translateX(4px);
        }
        
        .settings-nav-item.active::before {
            transform: scaleY(1);
        }
        
        .settings-nav-item i {
            transition: transform 0.3s ease;
        }
        
        .settings-nav-item:hover i,
        .settings-nav-item.active i {
            transform: scale(1.2) rotate(5deg);
        }
        
        /* Profile Card Enhancement */
        .profile-card {
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.1) 0%, rgba(59, 130, 246, 0.1) 100%);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }
        
        .profile-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .profile-avatar {
            position: relative;
            border: 4px solid white;
            box-shadow: 0 10px 30px rgba(30, 64, 175, 0.3);
            transition: all 0.3s ease;
        }
        
        .profile-avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 40px rgba(30, 64, 175, 0.5);
        }
        
        /* Content Cards */
        .settings-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .settings-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #1e40af, #3b82f6, #60a5fa, #3b82f6);
            background-size: 300% 100%;
            animation: shimmer 3s linear infinite;
        }
        
        @keyframes shimmer {
            0% { background-position: 0% 0%; }
            100% { background-position: 300% 0%; }
        }
        
        .settings-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.15);
        }
        
        /* Section Headers */
        .section-header {
            position: relative;
            padding-bottom: 16px;
            margin-bottom: 24px;
        }
        
        .section-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, #1e40af, #3b82f6);
            border-radius: 2px;
        }
        
        .section-icon {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: pulse 2s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        
        /* Enhanced Toggle Switches */
        .toggle-switch {
            position: relative;
            width: 56px;
            height: 28px;
        }
        
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%);
            transition: 0.4s;
            border-radius: 34px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 4px;
            bottom: 4px;
            background: white;
            transition: 0.4s;
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }
        
        input:checked + .toggle-slider {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            box-shadow: 0 0 20px rgba(30, 64, 175, 0.5);
        }
        
        input:checked + .toggle-slider:before {
            transform: translateX(28px);
        }
        
        /* Animated Input Fields */
        .fancy-input {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .fancy-input:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(30, 64, 175, 0.2);
        }
        
        /* Gradient Buttons */
        .gradient-button {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            background-size: 200% 200%;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }
        
        .gradient-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }
        
        .gradient-button:hover {
            background-position: 100% 0;
            box-shadow: 0 15px 40px rgba(30, 64, 175, 0.4);
            transform: translateY(-2px);
        }
        
        .gradient-button:hover::before {
            left: 100%;
        }
        
        /* Feature Cards */
        .feature-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }
        
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.05) 0%, rgba(59, 130, 246, 0.05) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .feature-card:hover {
            border-color: #1e40af;
            transform: translateY(-4px);
            box-shadow: 0 15px 40px rgba(30, 64, 175, 0.2);
        }
        
        .feature-card:hover::before {
            opacity: 1;
        }
        
        /* Checkbox Styling */
        .fancy-checkbox {
            appearance: none;
            width: 24px;
            height: 24px;
            border: 2px solid #d1d5db;
            border-radius: 6px;
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .fancy-checkbox:checked {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            border-color: #1e40af;
        }
        
        .fancy-checkbox:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 14px;
            font-weight: bold;
        }
        
        /* Radio Button Styling */
        .fancy-radio {
            appearance: none;
            width: 24px;
            height: 24px;
            border: 2px solid #d1d5db;
            border-radius: 50%;
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .fancy-radio:checked {
            border-color: #1e40af;
            background: white;
        }
        
        .fancy-radio:checked::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 12px;
            height: 12px;
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            border-radius: 50%;
        }
        
        /* Theme Cards */
        .theme-card {
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .theme-card input:checked ~ div {
            border-color: #1e40af;
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.1) 0%, rgba(59, 130, 246, 0.1) 100%);
            box-shadow: 0 10px 30px rgba(30, 64, 175, 0.3);
            transform: scale(1.05);
        }
        
        /* Animations */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-slide-in {
            animation: slideIn 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.3s ease;
        }
        
        /* Progress Bar */
        .progress-bar {
            position: relative;
            overflow: hidden;
        }
        
        .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            animation: progressShine 2s infinite;
        }
        
        @keyframes progressShine {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        /* Badge Styling */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            animation: badgePulse 2s ease-in-out infinite;
        }
        
        @keyframes badgePulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
        }
        
        /* Navbar Enhancement */
        .fancy-navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }
        
        /* Tag Styling */
        .location-tag {
            transition: all 0.3s ease;
        }
        
        .location-tag:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
        }
    </style>
</head>
<body class="glass-background">

<!-- Modern Navigation -->
<nav class="fancy-navbar border-b border-white/20 shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 h-20 flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center p-2 shadow-lg transform hover:scale-110 transition-transform">
                <img src="{{ asset('job-lynk-logo.png') }}" alt="JOB-lyNK Logo" class="w-full h-full object-contain">
            </div>
            <div>
                <a href="{{ route('home') }}" class="text-2xl font-bold bg-gradient-to-r from-blue-primary to-blue-secondary bg-clip-text text-transparent hover:from-blue-dark hover:to-blue-primary transition">
                    JOB-lyNK
                </a>
                <p class="text-xs text-gray-600 font-medium">Settings & Preferences</p>
            </div>
        </div>
        <div class="flex items-center space-x-6">
            <div class="hidden md:flex items-center space-x-2 bg-white/50 backdrop-blur-sm px-4 py-2 rounded-full">
                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                <span class="text-gray-700 font-semibold">{{ Auth::user()->name ?? 'User' }}</span>
            </div>
            @if(Auth::user()->isWorker())
                <a href="{{ route('worker') }}" class="flex items-center space-x-2 bg-gradient-to-r from-blue-primary to-blue-secondary text-white px-4 py-2 rounded-full hover:shadow-lg transition-all transform hover:scale-105">
                    <i class="fas fa-home"></i>
                    <span class="hidden md:inline">Dashboard</span>
                </a>
            @elseif(Auth::user()->isEmployer())
                <a href="{{ route('employerDashboard') }}" class="flex items-center space-x-2 bg-gradient-to-r from-blue-primary to-blue-secondary text-white px-4 py-2 rounded-full hover:shadow-lg transition-all transform hover:scale-105">
                    <i class="fas fa-home"></i>
                    <span class="hidden md:inline">Dashboard</span>
                </a>
            @endif
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="flex items-center space-x-2 bg-red-500 text-white px-4 py-2 rounded-full hover:bg-red-600 hover:shadow-lg transition-all transform hover:scale-105">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="hidden md:inline">Logout</span>
                </button>
            </form>
        </div>
    </div>
</nav>

<div class="max-w-7xl mx-auto px-4 py-4">
    <!-- Page Header with Animation -->
    <div class="mb-4 text-center animate-fade-in">
        <p class="text-gray-600 text-sm font-medium">Customize your JOB-lyNK experience</p>
    </div>

    <div class="flex gap-4">
        
        <!-- Enhanced Sidebar -->
        <div class="w-80 settings-sidebar p-6 h-fit animate-slide-in">
            <div class="profile-card mb-6 relative z-10">
                <div class="flex items-center space-x-4 mb-4">
                    <img class="profile-avatar h-20 w-20 rounded-full object-cover" 
                         src="{{ Auth::user()->getProfilePictureUrl() }}" 
                         alt="{{ Auth::user()->name }}">
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-800 text-lg">{{ Auth::user()->name }}</h3>
                        <p class="text-sm text-gray-600 truncate">{{ Auth::user()->email }}</p>
                        <div class="flex items-center mt-2">
                            <span class="status-badge bg-green-100 text-green-700 text-xs">
                                <i class="fas fa-check-circle mr-1"></i>Active
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mb-4">
                <h2 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3 flex items-center">
                    <i class="fas fa-sliders-h mr-2"></i>
                    Settings Menu
                </h2>
            </div>
            
            <nav class="space-y-2">
                <a href="#profile" onclick="showSection('profile')" class="settings-nav-item active flex items-center p-4 rounded-xl transition-all duration-200 group">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-gradient-to-br from-blue-100 to-purple-100 group-hover:from-blue-200 group-hover:to-purple-200 mr-3">
                        <i class="fas fa-user text-blue-600"></i>
                    </div>
                    <span class="font-medium">Profile</span>
                </a>
                <a href="#account" onclick="showSection('account')" class="settings-nav-item flex items-center p-4 rounded-xl transition-all duration-200 group">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-gradient-to-br from-green-100 to-emerald-100 group-hover:from-green-200 group-hover:to-emerald-200 mr-3">
                        <i class="fas fa-user-cog text-green-600"></i>
                    </div>
                    <span class="font-medium">Account</span>
                </a>
                <a href="#security" onclick="showSection('security')" class="settings-nav-item flex items-center p-4 rounded-xl transition-all duration-200 group">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-gradient-to-br from-red-100 to-pink-100 group-hover:from-red-200 group-hover:to-pink-200 mr-3">
                        <i class="fas fa-shield-alt text-red-600"></i>
                    </div>
                    <span class="font-medium">Security</span>
                </a>
                <a href="#privacy" onclick="showSection('privacy')" class="settings-nav-item flex items-center p-4 rounded-xl transition-all duration-200 group">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-gradient-to-br from-yellow-100 to-orange-100 group-hover:from-yellow-200 group-hover:to-orange-200 mr-3">
                        <i class="fas fa-lock text-yellow-600"></i>
                    </div>
                    <span class="font-medium">Privacy</span>
                </a>
                <a href="#notifications" onclick="showSection('notifications')" class="settings-nav-item flex items-center p-4 rounded-xl transition-all duration-200 group">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-gradient-to-br from-indigo-100 to-purple-100 group-hover:from-indigo-200 group-hover:to-purple-200 mr-3">
                        <i class="fas fa-bell text-indigo-600"></i>
                    </div>
                    <span class="font-medium">Notifications</span>
                </a>
                <a href="#job-preferences" onclick="showSection('job-preferences')" class="settings-nav-item flex items-center p-4 rounded-xl transition-all duration-200 group">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-gradient-to-br from-cyan-100 to-blue-100 group-hover:from-cyan-200 group-hover:to-blue-200 mr-3">
                        <i class="fas fa-briefcase text-cyan-600"></i>
                    </div>
                    <span class="font-medium">Job Preferences</span>
                </a>
                <a href="#communication" onclick="showSection('communication')" class="settings-nav-item flex items-center p-4 rounded-xl transition-all duration-200 group">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-gradient-to-br from-pink-100 to-rose-100 group-hover:from-pink-200 group-hover:to-rose-200 mr-3">
                        <i class="fas fa-comments text-pink-600"></i>
                    </div>
                    <span class="font-medium">Communication</span>
                </a>
                <a href="#data" onclick="showSection('data')" class="settings-nav-item flex items-center p-4 rounded-xl transition-all duration-200 group">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-gradient-to-br from-gray-100 to-slate-100 group-hover:from-gray-200 group-hover:to-slate-200 mr-3">
                        <i class="fas fa-database text-gray-600"></i>
                    </div>
                    <span class="font-medium">Data & Storage</span>
                </a>
            </nav>
            
            <!-- Quick Stats -->
            <div class="mt-6 p-4 bg-gradient-to-br from-blue-light to-blue-50 rounded-xl border-2 border-blue-200">
                <h3 class="text-xs font-bold text-gray-600 uppercase mb-3">Quick Stats</h3>
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Profile Completion</span>
                        <span class="font-bold text-blue-primary">85%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-gradient-to-r from-blue-primary to-blue-secondary h-2 rounded-full progress-bar" style="width: 85%"></div>
                    </div>
                    <div class="flex items-center justify-between text-sm text-gray-600">
                        <span>2.4 MB used of 15 MB</span>
                        <span>84% free</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            
            <!-- Profile Section -->
            <div id="profile-section" class="settings-section settings-card p-8 animate-slide-in">
                <div class="section-header flex items-center justify-between mb-8">
                    <div class="flex-1">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Profile Settings</h2>
                        <p class="text-gray-600">Update your personal information and profile picture</p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-100 to-purple-100 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-user section-icon text-4xl"></i>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <!-- Profile Picture -->
                    <div class="feature-card flex items-center space-x-6 p-8 bg-gradient-to-r from-blue-50 via-purple-50 to-pink-50 rounded-2xl mb-6 border-2 border-transparent hover:border-purple-300">
                        <div class="relative">
                            <img class="h-32 w-32 rounded-full object-cover border-4 border-white shadow-2xl" 
                                 src="{{ Auth::user()->getProfilePictureUrl() }}" 
                                 alt="{{ Auth::user()->name }}"
                                 id="profilePreview">
                            <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center shadow-lg">
                                <i class="fas fa-camera text-white"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800 mb-2 text-lg">Profile Picture</h3>
                            <p class="text-sm text-gray-600 mb-4">Upload a professional photo (JPG, PNG, max 2MB)</p>
                            <label class="cursor-pointer gradient-button text-white px-6 py-3 rounded-xl inline-flex items-center font-semibold shadow-lg">
                                <i class="fas fa-upload mr-2"></i>
                                <span>Upload New Photo</span>
                                <input type="file" name="profile_picture" accept="image/*" class="hidden" onchange="previewImage(this)">
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="relative">
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                <i class="fas fa-user text-blue-primary mr-2"></i>Full Name
                            </label>
                            <input type="text" name="name" value="{{ Auth::user()->name ?? '' }}" required
                                   class="fancy-input w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-primary focus:border-transparent transition">
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                <i class="fas fa-envelope text-blue-primary mr-2"></i>Email Address
                            </label>
                            <input type="email" name="email" value="{{ Auth::user()->email ?? '' }}" required
                                   class="fancy-input w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-primary focus:border-transparent transition">
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                <i class="fas fa-phone text-blue-primary mr-2"></i>Phone Number
                            </label>
                            <input type="tel" name="phone" value="{{ Auth::user()->phone ?? '' }}" 
                                   class="fancy-input w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-primary focus:border-transparent transition"
                                   placeholder="+256 700 000 000">
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                <i class="fas fa-map-marker-alt text-blue-primary mr-2"></i>Location
                            </label>
                            <input type="text" name="location" value="{{ Auth::user()->location ?? '' }}" 
                                   class="fancy-input w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-primary focus:border-transparent transition"
                                   placeholder="City, District">
                        </div>
                    </div>

                    <div class="relative">
                        <label class="block text-sm font-bold text-gray-700 mb-3">
                            <i class="fas fa-info-circle text-blue-primary mr-2"></i>Bio / About Me
                        </label>
                        <textarea name="bio" rows="4" 
                                  class="fancy-input w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-primary focus:border-transparent transition"
                                  placeholder="Tell employers about yourself...">{{ Auth::user()->bio ?? '' }}</textarea>
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t-2 border-gray-100">
                        <p class="text-sm text-gray-500 flex items-center">
                            <i class="fas fa-clock mr-2 text-blue-primary"></i>
                            Last updated: {{ Auth::user()->updated_at->diffForHumans() }}
                        </p>
                        <button type="submit" class="gradient-button text-white px-10 py-4 rounded-xl font-bold shadow-2xl transform hover:scale-105 transition-all">
                            <i class="fas fa-save mr-2"></i>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Account Section -->
            <div id="account-section" class="settings-section settings-card p-8 hidden animate-slide-in">
                <div class="section-header flex items-center justify-between mb-8">
                    <div class="flex-1">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Account Settings</h2>
                        <p class="text-gray-600">Manage your account details and verification</p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-green-100 to-emerald-100 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-user-cog section-icon text-4xl"></i>
                    </div>
                </div>

                <div class="space-y-6">
                    <!-- Account Status -->
                    <div class="p-6 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border-2 border-green-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-1">Account Status</h3>
                                <p class="text-sm text-gray-600">Your account is active and verified</p>
                            </div>
                            <span class="bg-green-500 text-white px-4 py-2 rounded-full text-sm font-semibold">
                                <i class="fas fa-check-circle mr-1"></i>Active
                            </span>
                        </div>
                    </div>

                    <!-- Email Verification -->
                    <div class="p-6 border-2 border-gray-200 rounded-xl">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-1">Email Verification</h3>
                                <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                            </div>
                            @if(Auth::user()->email_verified_at)
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                    <i class="fas fa-check-circle mr-1"></i>Verified
                                </span>
                            @else
                                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition">
                                    Verify Email
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Phone Verification -->
                    <div class="p-6 border-2 border-gray-200 rounded-xl">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-1">Phone Verification</h3>
                                <p class="text-sm text-gray-600">{{ Auth::user()->phone ?? 'No phone number added' }}</p>
                            </div>
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition">
                                Verify Phone
                            </button>
                        </div>
                    </div>

                    <!-- Account Type -->
                    <div class="p-6 border-2 border-gray-200 rounded-xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-1">Account Type</h3>
                                <p class="text-sm text-gray-600">{{ ucfirst(Auth::user()->account_type) }} Account</p>
                            </div>
                            <span class="bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-semibold">
                                {{ ucfirst(Auth::user()->account_type) }}
                            </span>
                        </div>
                    </div>

                    <!-- Danger Zone -->
                    <div class="p-6 bg-red-50 border-2 border-red-200 rounded-xl">
                        <h3 class="font-semibold text-red-800 mb-3 flex items-center">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Danger Zone
                        </h3>
                        <div class="space-y-3">
                            <button class="w-full text-left px-4 py-3 bg-white border-2 border-red-300 rounded-lg hover:bg-red-50 transition">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-800">Deactivate Account</p>
                                        <p class="text-sm text-gray-600">Temporarily disable your account</p>
                                    </div>
                                    <i class="fas fa-chevron-right text-gray-400"></i>
                                </div>
                            </button>
                            <button class="w-full text-left px-4 py-3 bg-white border-2 border-red-300 rounded-lg hover:bg-red-50 transition">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-red-600">Delete Account</p>
                                        <p class="text-sm text-gray-600">Permanently delete your account and data</p>
                                    </div>
                                    <i class="fas fa-chevron-right text-gray-400"></i>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Section -->
            <div id="security-section" class="settings-section settings-card p-8 hidden animate-slide-in">
                <div class="section-header flex items-center justify-between mb-8">
                    <div class="flex-1">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Security Settings</h2>
                        <p class="text-gray-600">Protect your account with advanced security features</p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-red-100 to-pink-100 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-shield-alt section-icon text-4xl"></i>
                    </div>
                </div>
                
                <!-- Password Change -->
                <div class="mb-6 p-6 border-2 border-gray-200 rounded-xl">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="fas fa-key text-blue-500 mr-2"></i>
                        Change Password
                    </h3>
                    <form method="POST" action="{{ route('password.reset.put') }}" class="space-y-4">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Current Password</label>
                            <input type="password" name="current_password" required
                                   autocomplete="current-password"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">New Password</label>
                            <input type="password" name="password" required
                                   autocomplete="new-password"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <p class="text-xs text-gray-500 mt-1">Must be at least 8 characters with letters and numbers</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm New Password</label>
                            <input type="password" name="password_confirmation" required
                                   autocomplete="new-password"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition">
                            <i class="fas fa-lock mr-2"></i>
                            Update Password
                        </button>
                    </form>
                </div>

                <!-- Two-Factor Authentication -->
                <div class="p-6 border-2 border-gray-200 rounded-xl">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold flex items-center">
                                <i class="fas fa-mobile-alt text-blue-500 mr-2"></i>
                                Two-Factor Authentication
                            </h3>
                            <p class="text-gray-600 text-sm mt-1">Add an extra layer of security to your account</p>
                        </div>
                        @if(Auth::user()->two_factor_secret)
                            <span class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-semibold">
                                <i class="fas fa-check-circle mr-1"></i>Enabled
                            </span>
                        @else
                            <span class="bg-red-100 text-red-800 px-4 py-2 rounded-full text-sm font-semibold">
                                <i class="fas fa-times-circle mr-1"></i>Disabled
                            </span>
                        @endif
                    </div>

                    <div class="space-y-4">
                        <p class="text-sm text-gray-600">
                            Two-factor authentication adds an extra layer of security by requiring a code from your phone in addition to your password.
                        </p>
                        
                        @if(Auth::user()->two_factor_secret)
                            <form method="POST" action="{{ route('two-factor.disable') }}" onsubmit="return confirm('Are you sure you want to disable two-factor authentication?');">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Enter your password to disable 2FA:</label>
                                    <input type="password" name="password" required 
                                           autocomplete="current-password"
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                </div>
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-semibold transition">
                                    <i class="fas fa-shield-alt mr-2"></i>
                                    Disable Two-Factor Authentication
                                </button>
                            </form>
                        @else
                            <a href="{{ route('two-factor.setup') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-semibold transition">
                                <i class="fas fa-shield-alt mr-2"></i>
                                Enable Two-Factor Authentication
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Privacy Section -->
            <div id="privacy-section" class="settings-section settings-card p-8 hidden animate-slide-in">
                <div class="section-header flex items-center justify-between mb-8">
                    <div class="flex-1">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Privacy Settings</h2>
                        <p class="text-gray-600">Control who can see your information</p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-100 to-orange-100 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-lock section-icon text-4xl"></i>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="feature-card flex items-center justify-between p-6">
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800 mb-1 text-lg">Profile Visibility</h3>
                            <p class="text-sm text-gray-600">Make your profile visible to employers</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" checked>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>

                    <div class="feature-card flex items-center justify-between p-6">
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800 mb-1 text-lg">Show in Search Results</h3>
                            <p class="text-sm text-gray-600">Allow employers to find you in search</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" checked>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>

                    <div class="feature-card flex items-center justify-between p-6">
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800 mb-1 text-lg">Show Contact Information</h3>
                            <p class="text-sm text-gray-600">Display your phone and email to employers</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" checked>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>

                    <div class="feature-card flex items-center justify-between p-6">
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800 mb-1 text-lg">Activity Status</h3>
                            <p class="text-sm text-gray-600">Show when you're online</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox">
                            <span class="toggle-slider"></span>
                        </label>
                    </div>

                    <div class="feature-card flex items-center justify-between p-6">
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800 mb-1 text-lg">Data Sharing</h3>
                            <p class="text-sm text-gray-600">Share anonymous usage data to improve JOB-lyNK</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" checked>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Notifications Section -->
            <div id="notifications-section" class="settings-section settings-card p-8 hidden animate-slide-in">
                <div class="section-header flex items-center justify-between mb-8">
                    <div class="flex-1">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Notification Settings</h2>
                        <p class="text-gray-600">Choose how you want to be notified</p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-bell section-icon text-4xl"></i>
                    </div>
                </div>
                
                <div class="space-y-6">
                    <!-- Email Notifications -->
                    <div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border-2 border-blue-200">
                        <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-envelope text-blue-600 mr-2"></i>
                            Email Notifications
                        </h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-4 bg-white rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-800">Job Matches</p>
                                    <p class="text-sm text-gray-600">Get notified about jobs matching your profile</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" checked>
                                    <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-white rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-800">Application Updates</p>
                                    <p class="text-sm text-gray-600">Status changes on your applications</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" checked>
                                    <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-white rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-800">New Messages</p>
                                    <p class="text-sm text-gray-600">When employers send you messages</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" checked>
                                    <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- SMS Notifications -->
                    <div class="p-6 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border-2 border-green-200">
                        <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-sms text-green-600 mr-2"></i>
                            SMS Notifications
                        </h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-4 bg-white rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-800">Urgent Job Alerts</p>
                                    <p class="text-sm text-gray-600">SMS for urgent job opportunities</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer">
                                    <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-white rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-800">Interview Reminders</p>
                                    <p class="text-sm text-gray-600">SMS reminders for scheduled interviews</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" checked>
                                    <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Push Notifications -->
                    <div class="p-6 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl border-2 border-purple-200">
                        <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-mobile-alt text-purple-600 mr-2"></i>
                            Push Notifications
                        </h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-4 bg-white rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-800">Real-time Updates</p>
                                    <p class="text-sm text-gray-600">Instant notifications on your device</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" checked>
                                    <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Notification Frequency -->
                    <div class="p-6 border-2 border-gray-200 rounded-xl">
                        <h3 class="font-semibold text-gray-800 mb-4">Notification Frequency</h3>
                        <select class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option>Real-time (as they happen)</option>
                            <option>Daily digest</option>
                            <option>Weekly summary</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Job Preferences Section -->
            <div id="job-preferences-section" class="settings-section settings-card p-8 hidden animate-slide-in">
                <div class="section-header flex items-center justify-between mb-8">
                    <div class="flex-1">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Job Preferences</h2>
                        <p class="text-gray-600">Set your job search preferences</p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-cyan-100 to-blue-100 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-briefcase section-icon text-4xl"></i>
                    </div>
                </div>

                <div class="space-y-6">
                    <!-- Job Types -->
                    <div class="feature-card p-6">
                        <h3 class="font-bold text-gray-800 mb-4 text-lg flex items-center">
                            <i class="fas fa-briefcase text-blue-primary mr-2"></i>
                            Preferred Job Types
                        </h3>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-primary hover:bg-blue-50 transition-all">
                                <input type="checkbox" class="fancy-checkbox mr-3" checked>
                                <span class="text-gray-700 font-medium">Full-time</span>
                            </label>
                            <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-primary hover:bg-blue-50 transition-all">
                                <input type="checkbox" class="fancy-checkbox mr-3" checked>
                                <span class="text-gray-700 font-medium">Part-time</span>
                            </label>
                            <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-primary hover:bg-blue-50 transition-all">
                                <input type="checkbox" class="fancy-checkbox mr-3">
                                <span class="text-gray-700 font-medium">Contract</span>
                            </label>
                            <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-primary hover:bg-blue-50 transition-all">
                                <input type="checkbox" class="fancy-checkbox mr-3" checked>
                                <span class="text-gray-700 font-medium">Temporary</span>
                            </label>
                        </div>
                    </div>

                    <!-- Preferred Locations -->
                    <div class="feature-card p-6">
                        <h3 class="font-bold text-gray-800 mb-4 text-lg flex items-center">
                            <i class="fas fa-map-marker-alt text-blue-primary mr-2"></i>
                            Preferred Locations
                        </h3>
                        <div class="space-y-3">
                            <input type="text" placeholder="Add location (e.g., Kampala, Entebbe)"
                                   class="fancy-input w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-primary focus:border-transparent transition">
                            <div class="flex flex-wrap gap-3">
                                <span class="location-tag bg-gradient-to-r from-blue-light to-blue-100 text-blue-primary px-4 py-2 rounded-full text-sm font-semibold flex items-center shadow-md">
                                    <i class="fas fa-map-pin mr-2"></i>
                                    Kampala
                                    <i class="fas fa-times ml-3 cursor-pointer hover:text-red-600 transition"></i>
                                </span>
                                <span class="location-tag bg-gradient-to-r from-blue-light to-blue-100 text-blue-primary px-4 py-2 rounded-full text-sm font-semibold flex items-center shadow-md">
                                    <i class="fas fa-map-pin mr-2"></i>
                                    Entebbe
                                    <i class="fas fa-times ml-3 cursor-pointer hover:text-red-600 transition"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Salary Range -->
                    <div class="p-6 border-2 border-gray-200 rounded-xl">
                        <h3 class="font-semibold text-gray-800 mb-4">Expected Salary Range (UGX)</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-gray-600 mb-2">Minimum</label>
                                <input type="number" placeholder="50,000"
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-2">Maximum</label>
                                <input type="number" placeholder="500,000"
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            </div>
                        </div>
                    </div>

                    <!-- Availability -->
                    <div class="p-6 border-2 border-gray-200 rounded-xl">
                        <h3 class="font-semibold text-gray-800 mb-4">Availability</h3>
                        <select class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option>Available immediately</option>
                            <option>Available in 1 week</option>
                            <option>Available in 2 weeks</option>
                            <option>Available in 1 month</option>
                            <option>Not actively looking</option>
                        </select>
                    </div>

                    <!-- Work Schedule -->
                    <div class="feature-card p-6">
                        <h3 class="font-bold text-gray-800 mb-4 text-lg flex items-center">
                            <i class="fas fa-clock text-blue-primary mr-2"></i>
                            Preferred Work Schedule
                        </h3>
                        <div class="space-y-3">
                            <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-primary hover:bg-blue-50 transition-all">
                                <input type="radio" name="schedule" class="fancy-radio mr-3" checked>
                                <span class="text-gray-700 font-medium">Flexible hours</span>
                            </label>
                            <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-primary hover:bg-blue-50 transition-all">
                                <input type="radio" name="schedule" class="fancy-radio mr-3">
                                <span class="text-gray-700 font-medium">Day shift (8am - 5pm)</span>
                            </label>
                            <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-primary hover:bg-blue-50 transition-all">
                                <input type="radio" name="schedule" class="fancy-radio mr-3">
                                <span class="text-gray-700 font-medium">Night shift</span>
                            </label>
                            <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-primary hover:bg-blue-50 transition-all">
                                <input type="radio" name="schedule" class="fancy-radio mr-3">
                                <span class="text-gray-700 font-medium">Weekend work</span>
                            </label>
                        </div>
                    </div>

                    <button class="w-full gradient-button text-white px-10 py-5 rounded-xl font-bold shadow-2xl transform hover:scale-105 transition-all text-lg">
                        <i class="fas fa-save mr-2"></i>
                        Save Job Preferences
                    </button>
                </div>
            </div>

            <!-- Communication Section -->
            <div id="communication-section" class="settings-section settings-card p-8 hidden animate-slide-in">
                <div class="section-header flex items-center justify-between mb-8">
                    <div class="flex-1">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Communication Settings</h2>
                        <p class="text-gray-600">Manage how you communicate with employers</p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-100 to-rose-100 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-comments section-icon text-4xl"></i>
                    </div>
                </div>

                <div class="space-y-6">
                    <!-- Message Preferences -->
                    <div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border-2 border-blue-200">
                        <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-envelope-open-text text-blue-600 mr-2"></i>
                            Message Preferences
                        </h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-4 bg-white rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-800">Allow Direct Messages</p>
                                    <p class="text-sm text-gray-600">Let employers message you directly</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" checked>
                                    <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-white rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-800">Auto-Reply</p>
                                    <p class="text-sm text-gray-600">Send automatic replies when unavailable</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer">
                                    <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Response Time -->
                    <div class="p-6 border-2 border-gray-200 rounded-xl">
                        <h3 class="font-semibold text-gray-800 mb-4">Expected Response Time</h3>
                        <select class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option>Within 1 hour</option>
                            <option>Within 24 hours</option>
                            <option>Within 2-3 days</option>
                            <option>Within a week</option>
                        </select>
                        <p class="text-sm text-gray-500 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            This helps employers know when to expect your reply
                        </p>
                    </div>

                    <!-- Contact Methods -->
                    <div class="p-6 border-2 border-gray-200 rounded-xl">
                        <h3 class="font-semibold text-gray-800 mb-4">Preferred Contact Methods</h3>
                        <div class="space-y-3">
                            <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                <input type="checkbox" class="w-5 h-5 text-blue-600 rounded mr-3" checked>
                                <i class="fas fa-envelope text-blue-500 mr-2"></i>
                                <span class="text-gray-700">Email</span>
                            </label>
                            <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                <input type="checkbox" class="w-5 h-5 text-blue-600 rounded mr-3" checked>
                                <i class="fas fa-phone text-green-500 mr-2"></i>
                                <span class="text-gray-700">Phone Call</span>
                            </label>
                            <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                <input type="checkbox" class="w-5 h-5 text-blue-600 rounded mr-3" checked>
                                <i class="fas fa-comment text-purple-500 mr-2"></i>
                                <span class="text-gray-700">Platform Messages</span>
                            </label>
                            <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                <input type="checkbox" class="w-5 h-5 text-blue-600 rounded mr-3">
                                <i class="fab fa-whatsapp text-green-600 mr-2"></i>
                                <span class="text-gray-700">WhatsApp</span>
                            </label>
                        </div>
                    </div>

                    <!-- Auto-Reply Message -->
                    <div class="p-6 border-2 border-gray-200 rounded-xl">
                        <h3 class="font-semibold text-gray-800 mb-4">Auto-Reply Message</h3>
                        <textarea rows="4" 
                                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                  placeholder="Thank you for your message. I will get back to you within 24 hours..."></textarea>
                    </div>

                    <button class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-8 py-4 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                        <i class="fas fa-save mr-2"></i>
                        Save Communication Settings
                    </button>
                </div>
            </div>

            <!-- Data & Storage Section -->
            <div id="data-section" class="settings-section settings-card p-8 hidden animate-slide-in">
                <div class="section-header flex items-center justify-between mb-8">
                    <div class="flex-1">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Data & Storage</h2>
                        <p class="text-gray-600">Manage your data and storage preferences</p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-gray-100 to-slate-100 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-database section-icon text-4xl"></i>
                    </div>
                </div>

                <div class="space-y-6">
                    <!-- Storage Usage -->
                    <div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border-2 border-blue-200">
                        <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-hdd text-blue-600 mr-2"></i>
                            Storage Usage
                        </h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-700">Profile Data</span>
                                <span class="font-semibold text-gray-800">2.4 MB</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: 15%"></div>
                            </div>
                            <div class="flex items-center justify-between text-sm text-gray-600">
                                <span>2.4 MB used of 15 MB</span>
                                <span>84% free</span>
                            </div>
                        </div>
                    </div>

                    <!-- Download Data -->
                    <div class="p-6 border-2 border-gray-200 rounded-xl">
                        <h3 class="font-semibold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-download text-green-600 mr-2"></i>
                            Download Your Data
                        </h3>
                        <p class="text-sm text-gray-600 mb-4">
                            Download a copy of your profile, applications, and activity data
                        </p>
                        <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-semibold transition">
                            <i class="fas fa-file-download mr-2"></i>
                            Request Data Export
                        </button>
                    </div>

                    <!-- Clear Cache -->
                    <div class="p-6 border-2 border-gray-200 rounded-xl">
                        <h3 class="font-semibold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-broom text-orange-600 mr-2"></i>
                            Clear Cache
                        </h3>
                        <p class="text-sm text-gray-600 mb-4">
                            Clear temporary files and cached data to free up space
                        </p>
                        <button class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-3 rounded-xl font-semibold transition">
                            <i class="fas fa-trash-alt mr-2"></i>
                            Clear Cache (1.2 MB)
                        </button>
                    </div>

                    <!-- Data Retention -->
                    <div class="p-6 border-2 border-gray-200 rounded-xl">
                        <h3 class="font-semibold text-gray-800 mb-4">Data Retention</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-800">Keep Application History</p>
                                    <p class="text-sm text-gray-600">How long to keep your application records</p>
                                </div>
                                <select class="px-3 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 transition">
                                    <option>Forever</option>
                                    <option>1 year</option>
                                    <option>6 months</option>
                                    <option>3 months</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Account -->
                    <div class="p-6 bg-red-50 border-2 border-red-200 rounded-xl">
                        <h3 class="font-semibold text-red-800 mb-3 flex items-center">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Delete All Data
                        </h3>
                        <p class="text-sm text-gray-700 mb-4">
                            Permanently delete your account and all associated data. This action cannot be undone.
                        </p>
                        <button class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-semibold transition">
                            <i class="fas fa-trash-alt mr-2"></i>
                            Delete Account & Data
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function showSection(sectionName) {
        // Hide all sections
        document.querySelectorAll('.settings-section').forEach(section => {
            section.classList.add('hidden');
        });
        
        // Remove active class from all nav items
        document.querySelectorAll('.settings-nav-item').forEach(item => {
            item.classList.remove('active', 'bg-blue-100', 'text-blue-primary');
        });
        
        // Show selected section
        document.getElementById(sectionName + '-section').classList.remove('hidden');
        
        // Add active class to clicked nav item
        event.target.closest('.settings-nav-item').classList.add('active', 'bg-blue-100', 'text-blue-primary');
    }
    
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profilePreview').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

</body>
</html>
