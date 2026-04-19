<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Settings - JOB-lyNK</title>
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
                <p class="text-xs text-gray-600 font-medium">Employer Settings & Preferences</p>
            </div>
        </div>
        <div class="flex items-center space-x-6">
            <div class="hidden md:flex items-center space-x-2 bg-white/50 backdrop-blur-sm px-4 py-2 rounded-full">
                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                <span class="text-gray-700 font-semibold">{{ Auth::user()->name ?? 'User' }}</span>
            </div>
            <a href="{{ route('employerDashboard') }}" class="flex items-center space-x-2 bg-gradient-to-r from-blue-primary to-blue-secondary text-white px-4 py-2 rounded-full hover:shadow-lg transition-all transform hover:scale-105">
                <i class="fas fa-home"></i>
                <span class="hidden md:inline">Dashboard</span>
            </a>
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
        <p class="text-gray-600 text-sm font-medium">Customize your employer experience</p>
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
                            <span class="status-badge bg-blue-100 text-blue-700 text-xs">
                                <i class="fas fa-briefcase mr-1"></i>Employer
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
                <a href="#company-profile" onclick="showSection('company-profile')" class="settings-nav-item active flex items-center p-4 rounded-xl transition-all duration-200 group">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-gradient-to-br from-blue-100 to-purple-100 group-hover:from-blue-200 group-hover:to-purple-200 mr-3">
                        <i class="fas fa-building text-blue-600"></i>
                    </div>
                    <span class="font-medium">Company Profile</span>
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
                <a href="#notifications" onclick="showSection('notifications')" class="settings-nav-item flex items-center p-4 rounded-xl transition-all duration-200 group">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-gradient-to-br from-indigo-100 to-purple-100 group-hover:from-indigo-200 group-hover:to-purple-200 mr-3">
                        <i class="fas fa-bell text-indigo-600"></i>
                    </div>
                    <span class="font-medium">Notifications</span>
                </a>
                <a href="#hiring-preferences" onclick="showSection('hiring-preferences')" class="settings-nav-item flex items-center p-4 rounded-xl transition-all duration-200 group">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-gradient-to-br from-cyan-100 to-blue-100 group-hover:from-cyan-200 group-hover:to-blue-200 mr-3">
                        <i class="fas fa-user-check text-cyan-600"></i>
                    </div>
                    <span class="font-medium">Hiring Preferences</span>
                </a>
                <a href="#billing" onclick="showSection('billing')" class="settings-nav-item flex items-center p-4 rounded-xl transition-all duration-200 group">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-gradient-to-br from-yellow-100 to-orange-100 group-hover:from-yellow-200 group-hover:to-orange-200 mr-3">
                        <i class="fas fa-credit-card text-yellow-600"></i>
                    </div>
                    <span class="font-medium">Billing & Plans</span>
                </a>
            </nav>
            
            <!-- Quick Stats -->
            <div class="mt-6 p-4 bg-gradient-to-br from-blue-light to-blue-50 rounded-xl border-2 border-blue-200">
                <h3 class="text-xs font-bold text-gray-600 uppercase mb-3">Quick Stats</h3>
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Active Jobs</span>
                        <span class="font-bold text-blue-primary">5</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Applications</span>
                        <span class="font-bold text-blue-primary">23</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            
            <!-- Company Profile Section -->
            <div id="company-profile-section" class="settings-section settings-card p-8 animate-slide-in">
                <div class="section-header flex items-center justify-between mb-8">
                    <div class="flex-1">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Company Profile</h2>
                        <p class="text-gray-600">Manage your company information and branding</p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-100 to-purple-100 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-building section-icon text-4xl"></i>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('employer.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Company Logo -->
                    <div class="feature-card flex items-center space-x-6 p-8 bg-gradient-to-r from-blue-50 via-purple-50 to-pink-50 rounded-2xl mb-6 border-2 border-transparent hover:border-purple-300">
                        <div class="relative">
                            <img class="h-32 w-32 rounded-xl object-cover border-4 border-white shadow-2xl" 
                                 src="{{ Auth::user()->company_logo ?? asset('default-company.png') }}" 
                                 alt="Company Logo"
                                 id="companyLogoPreview">
                            <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center shadow-lg">
                        elect class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option>Real-time (as they happen)</option>
                            <option>Daily digest</option>
                            <option>Weekly summary</option>
                        </select>
                    </div>
                </div>
            </div>

                              <input type="checkbox" checked>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Notification Frequency -->
                    <div class="p-6 border-2 border-gray-200 rounded-xl">
                        <h3 class="font-semibold text-gray-800 mb-4">Notification Frequency</h3>
                        <s                          </label>
                            </div>
                            <div class="feature-card flex items-center justify-between p-4">
                                <div>
                                    <p class="font-medium text-gray-800">Interview Reminders</p>
                                    <p class="text-sm text-gray-600">SMS reminders for scheduled interviews</p>
                                </div>
                                <label class="toggle-switch">
      items-center justify-between p-4">
                                <div>
                                    <p class="font-medium text-gray-800">Urgent Applications</p>
                                    <p class="text-sm text-gray-600">SMS for high-priority applications</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox">
                                    <span class="toggle-slider"></span>
      >

                    <!-- SMS Notifications -->
                    <div class="p-6 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border-2 border-green-200">
                        <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-sms text-green-600 mr-2"></i>
                            SMS Notifications
                        </h3>
                        <div class="space-y-3">
                            <div class="feature-card flex 00">Messages from Applicants</p>
                                    <p class="text-sm text-gray-600">When applicants send you messages</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" checked>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>
                    </div                           </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" checked>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                            <div class="feature-card flex items-center justify-between p-4">
                                <div>
                                    <p class="font-medium text-gray-8<input type="checkbox" checked>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                            <div class="feature-card flex items-center justify-between p-4">
                                <div>
                                    <p class="font-medium text-gray-800">Application Updates</p>
                                    <p class="text-sm text-gray-600">Status changes on applications</p>
               <div class="space-y-3">
                            <div class="feature-card flex items-center justify-between p-4">
                                <div>
                                    <p class="font-medium text-gray-800">New Applications</p>
                                    <p class="text-sm text-gray-600">Get notified when someone applies to your jobs</p>
                                </div>
                                <label class="toggle-switch">
                                      </div>
                </div>
                
                <div class="space-y-6">
                    <!-- Email Notifications -->
                    <div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border-2 border-blue-200">
                        <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-envelope text-blue-600 mr-2"></i>
                            Email Notifications
                        </h3>
              >
                    <div class="flex-1">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Notification Settings</h2>
                        <p class="text-gray-600">Choose how you want to be notified about applications and updates</p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-bell section-icon text-4xl"></i>
                  ion">
                                <i class="fas fa-shield-alt mr-2"></i>
                                Enable Two-Factor Authentication
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Hiring Preferences Section -->
            <div id="hiring-preferences-section" class="settings-section settings-card p-8 hidden animate-slide-in">
                <div class="section-header flex items-center justify-between mb-8">
                    <div class="flex-1">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Hiring Preferences</h2>
                        <p class="text-gray-600">Set your preferences for candidate screening and hiring</p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-cyan-100 to-blue-100 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-user-check section-icon text-4xl"></i>
                    </div>
                </div>

                <form method="POST" action="{{ route('employer.preferences.update') }}" class="space-y-6">
                    @csrf

                    <!-- Automatic Screening -->
                    <div class="p-6 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-xl border-2 border-cyan-200">
                        <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-robot text-cyan-600 mr-2"></i>
                            Automatic Screening
                        </h3>
                        <div class="space-y-3">
                            <div class="feature-card flex items-center justify-between p-4">
                                <div>
                                    <p class="font-medium text-gray-800">AI-Powered Candidate Matching</p>
                                    <p class="text-sm text-gray-600">Automatically rank candidates based on job requirements</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="ai_matching" checked>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                            <div class="feature-card flex items-center justify-between p-4">
                                <div>
                                    <p class="font-medium text-gray-800">Auto-Reject Unqualified</p>
                                    <p class="text-sm text-gray-600">Automatically reject candidates who don't meet minimum requirements</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="auto_reject">
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Candidate Requirements -->
                    <div class="p-6 border-2 border-gray-200 rounded-xl">
                        <h3 class="font-semibold text-gray-800 mb-4">Minimum Candidate Requirements</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Minimum Experience (Years)</label>
                                <input type="number" name="min_experience" min="0" value="0"
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Education Level</label>
                                <select name="min_education" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                    <option>No Requirement</option>
                                    <option>High School</option>
                                    <option>Diploma</option>
                                    <option>Bachelor's Degree</option>
                                    <option>Master's Degree</option>
                                    <option>PhD</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Application Settings -->
                    <div class="p-6 border-2 border-gray-200 rounded-xl">
                        <h3 class="font-semibold text-gray-800 mb-4">Application Settings</h3>
                        <div class="space-y-3">
                            <div class="feature-card flex items-center justify-between p-4">
                                <div>
                                    <p class="font-medium text-gray-800">Require Cover Letter</p>
                                    <p class="text-sm text-gray-600">Make cover letter mandatory for all applications</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="require_cover_letter">
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                            <div class="feature-card flex items-center justify-between p-4">
                                <div>
                                    <p class="font-medium text-gray-800">Require Resume/CV</p>
                                    <p class="text-sm text-gray-600">Make resume upload mandatory</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="require_resume" checked>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                            <div class="feature-card flex items-center justify-between p-4">
                                <div>
                                    <p class="font-medium text-gray-800">Allow Quick Apply</p>
                                    <p class="text-sm text-gray-600">Let candidates apply with saved profile information</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="allow_quick_apply" checked>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Interview Preferences -->
                    <div class="p-6 border-2 border-gray-200 rounded-xl">
                        <h3 class="font-semibold text-gray-800 mb-4">Interview Preferences</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Preferred Interview Method</label>
                                <select name="interview_method" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                    <option>In-Person</option>
                                    <option>Video Call</option>
                                    <option>Phone Call</option>
                                    <option>Flexible</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Typical Interview Duration</label>
                                <select name="interview_duration" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                    <option>15 minutes</option>
                                    <option>30 minutes</option>
                                    <option>45 minutes</option>
                                    <option>1 hour</option>
                                    <option>1.5 hours</option>
                                    <option>2 hours</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t-2 border-gray-100">
                        <p class="text-sm text-gray-500 flex items-center">
                            <i class="fas fa-info-circle mr-2 text-blue-primary"></i>
                            These preferences will apply to all your job postings
                        </p>
                        <button type="submit" class="gradient-button text-white px-10 py-4 rounded-xl font-bold shadow-2xl transform hover:scale-105 transition-all">
                            <i class="fas fa-save mr-2"></i>
                            Save Preferences
                        </button>
                    </div>
                </form>
            </div>

            <!-- Billing & Plans Section -->
            <div id="billing-section" class="settings-section settings-card p-8 hidden animate-slide-in">
                <div class="section-header flex items-center justify-between mb-8">
                    <div class="flex-1">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Billing & Plans</h2>
                        <p class="text-gray-600">Manage your subscription and payment methods</p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-100 to-orange-100 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-credit-card section-icon text-4xl"></i>
                    </div>
                </div>

                <!-- Current Plan -->
                <div class="p-6 bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl border-2 border-yellow-200 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">Free Plan</h3>
                            <p class="text-gray-600">Perfect for getting started</p>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-bold text-blue-primary">UGX 0</p>
                            <p class="text-sm text-gray-600">per month</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                        <div class="flex items-center text-sm text-gray-700">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            Post up to 3 jobs per month
                        </div>
                        <div class="flex items-center text-sm text-gray-700">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            Basic candidate matching
                        </div>
                        <div class="flex items-center text-sm text-gray-700">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            Email support
                        </div>
                        <div class="flex items-center text-sm text-gray-700">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            Standard job visibility
                        </div>
                    </div>
                    <button class="gradient-button text-white px-6 py-3 rounded-xl font-semibold shadow-lg w-full">
                        <i class="fas fa-arrow-up mr-2"></i>
                        Upgrade to Premium
                    </button>
                </div>

                <!-- Available Plans -->
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Available Plans</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Basic Plan -->
                        <div class="feature-card p-6 border-2 border-gray-200">
                            <div class="text-center mb-4">
                                <h4 class="text-xl font-bold text-gray-800 mb-2">Basic</h4>
                                <p class="text-3xl font-bold text-blue-primary mb-1">UGX 50,000</p>
                                <p class="text-sm text-gray-600">per month</p>
                            </div>
                            <ul class="space-y-2 mb-4">
                                <li class="flex items-start text-sm">
                                    <i class="fas fa-check text-green-500 mr-2 mt-1"></i>
                                    <span>10 job postings/month</span>
                                </li>
                                <li class="flex items-start text-sm">
                                    <i class="fas fa-check text-green-500 mr-2 mt-1"></i>
                                    <span>AI candidate matching</span>
                                </li>
                                <li class="flex items-start text-sm">
                                    <i class="fas fa-check text-green-500 mr-2 mt-1"></i>
                                    <span>Priority support</span>
                                </li>
                                <li class="flex items-start text-sm">
                                    <i class="fas fa-check text-green-500 mr-2 mt-1"></i>
                                    <span>Enhanced visibility</span>
                                </li>
                            </ul>
                            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-xl font-semibold transition">
                                Select Plan
                            </button>
                        </div>

                        <!-- Professional Plan -->
                        <div class="feature-card p-6 border-4 border-blue-primary relative">
                            <div class="absolute -top-3 left-1/2 transform -translate-x-1/2">
                                <span class="bg-blue-primary text-white px-4 py-1 rounded-full text-xs font-bold">POPULAR</span>
                            </div>
                            <div class="text-center mb-4">
                                <h4 class="text-xl font-bold text-gray-800 mb-2">Professional</h4>
                                <p class="text-3xl font-bold text-blue-primary mb-1">UGX 150,000</p>
                                <p class="text-sm text-gray-600">per month</p>
                            </div>
                            <ul class="space-y-2 mb-4">
                                <li class="flex items-start text-sm">
                                    <i class="fas fa-check text-green-500 mr-2 mt-1"></i>
                                    <span>Unlimited job postings</span>
                                </li>
                                <li class="flex items-start text-sm">
                                    <i class="fas fa-check text-green-500 mr-2 mt-1"></i>
                                    <span>Advanced AI matching</span>
                                </li>
                                <li class="flex items-start text-sm">
                                    <i class="fas fa-check text-green-500 mr-2 mt-1"></i>
                                    <span>24/7 priority support</span>
                                </li>
                                <li class="flex items-start text-sm">
                                    <i class="fas fa-check text-green-500 mr-2 mt-1"></i>
                                    <span>Featured job listings</span>
                                </li>
                                <li class="flex items-start text-sm">
                                    <i class="fas fa-check text-green-500 mr-2 mt-1"></i>
                                    <span>Analytics dashboard</span>
                                </li>
                            </ul>
                            <button class="w-full gradient-button text-white px-4 py-3 rounded-xl font-semibold shadow-lg">
                                Select Plan
                            </button>
                        </div>

                        <!-- Enterprise Plan -->
                        <div class="feature-card p-6 border-2 border-gray-200">
                            <div class="text-center mb-4">
                                <h4 class="text-xl font-bold text-gray-800 mb-2">Enterprise</h4>
                                <p class="text-3xl font-bold text-blue-primary mb-1">Custom</p>
                                <p class="text-sm text-gray-600">Contact us</p>
                            </div>
                            <ul class="space-y-2 mb-4">
                                <li class="flex items-start text-sm">
                                    <i class="fas fa-check text-green-500 mr-2 mt-1"></i>
                                    <span>Everything in Professional</span>
                                </li>
                                <li class="flex items-start text-sm">
                                    <i class="fas fa-check text-green-500 mr-2 mt-1"></i>
                                    <span>Dedicated account manager</span>
                                </li>
                                <li class="flex items-start text-sm">
                                    <i class="fas fa-check text-green-500 mr-2 mt-1"></i>
                                    <span>Custom integrations</span>
                                </li>
                                <li class="flex items-start text-sm">
                                    <i class="fas fa-check text-green-500 mr-2 mt-1"></i>
                                    <span>White-label options</span>
                                </li>
                                <li class="flex items-start text-sm">
                                    <i class="fas fa-check text-green-500 mr-2 mt-1"></i>
                                    <span>API access</span>
                                </li>
                            </ul>
                            <button class="w-full bg-gray-800 hover:bg-gray-900 text-white px-4 py-3 rounded-xl font-semibold transition">
                                Contact Sales
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="p-6 border-2 border-gray-200 rounded-xl mb-6">
                    <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-wallet text-blue-primary mr-2"></i>
                        Payment Methods
                    </h3>
                    <div class="space-y-3">
                        <div class="feature-card p-4 flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-purple-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-credit-card text-blue-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">No payment method added</p>
                                    <p class="text-sm text-gray-600">Add a payment method to upgrade your plan</p>
                                </div>
                            </div>
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition">
                                <i class="fas fa-plus mr-1"></i>
                                Add Method
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Billing History -->
                <div class="p-6 border-2 border-gray-200 rounded-xl">
                    <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-history text-blue-primary mr-2"></i>
                        Billing History
                    </h3>
                    <div class="text-center py-8">
                        <i class="fas fa-receipt text-gray-300 text-5xl mb-4"></i>
                        <p class="text-gray-600">No billing history yet</p>
                        <p class="text-sm text-gray-500">Your payment history will appear here</p>
                    </div>
                </div>
            </div>

            <!-- Notifications Section -->
            <div id="notifications-section" class="settings-section settings-card p-8 hidden animate-slide-in">
                <div class="section-header flex items-center justify-between mb-8"bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-semibold transition">
                                    <i class="fas fa-shield-alt mr-2"></i>
                                    Disable Two-Factor Authentication
                                </button>
                            </form>
                        @else
                            <a href="{{ route('two-factor.setup') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-semibold transitass="mb-4">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Enter your password to disable 2FA:</label>
                                    <input type="password" name="password" required 
                                           autocomplete="current-password"
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                </div>
                                <button type="submit" class="                 Two-factor authentication adds an extra layer of security by requiring a code from your phone in addition to your password.
                        </p>
                        
                        @if(Auth::user()->two_factor_secret)
                            <form method="POST" action="{{ route('two-factor.disable') }}" onsubmit="return confirm('Are you sure you want to disable two-factor authentication?');">
                                @csrf
                                <div cl  <i class="fas fa-check-circle mr-1"></i>Enabled
                            </span>
                        @else
                            <span class="bg-red-100 text-red-800 px-4 py-2 rounded-full text-sm font-semibold">
                                <i class="fas fa-times-circle mr-1"></i>Disabled
                            </span>
                        @endif
                    </div>

                    <div class="space-y-4">
                        <p class="text-sm text-gray-600">
                         <i class="fas fa-mobile-alt text-blue-500 mr-2"></i>
                                Two-Factor Authentication
                            </h3>
                            <p class="text-gray-600 text-sm mt-1">Add an extra layer of security to your account</p>
                        </div>
                        @if(Auth::user()->two_factor_secret)
                            <span class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-semibold">
                              >
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
                  <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm New Password</label>
                            <input type="password" name="password_confirmation" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition"sm font-semibold text-gray-700 mb-2">New Password</label>
                            <input type="password" name="password" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <p class="text-xs text-gray-500 mt-1">Must be at least 8 characters with letters and numbers</p>
                        </div>
                        <div>
                                    
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Current Password</label>
                            <input type="password" name="current_password" required
                                   autocomplete="current-password"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                        <div>
                            <label class="block text-           <!-- Password Change -->
                <div class="mb-6 p-6 border-2 border-gray-200 rounded-xl">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="fas fa-key text-blue-500 mr-2"></i>
                        Change Password
                    </h3>
                    <form method="POST" action="{{ route('password.reset.put') }}" class="space-y-4">
                        @csrf
                        @method('PUT')
                
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Security Settings</h2>
                        <p class="text-gray-600">Protect your account with advanced security features</p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-red-100 to-pink-100 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-shield-alt section-icon text-4xl"></i>
                    </div>
                </div>
                
     ull text-sm font-semibold">
                                <i class="fas fa-briefcase mr-1"></i>Employer
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Section -->
            <div id="security-section" class="settings-section settings-card p-8 hidden animate-slide-in">
                <div class="section-header flex items-center justify-between mb-8">
                    <div class="flex-1">           <!-- Account Type -->
                    <div class="p-6 border-2 border-gray-200 rounded-xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-1">Account Type</h3>
                                <p class="text-sm text-gray-600">Employer Account</p>
                            </div>
                            <span class="bg-blue-100 text-blue-800 px-4 py-2 rounded-fed-full text-sm font-medium">
                                    <i class="fas fa-check-circle mr-1"></i>Verified
                                </span>
                            @else
                                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition">
                                    Verify Email
                                </button>
                            @endif
                        </div>
                    </div>

         ray-200 rounded-xl">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-1">Email Verification</h3>
                                <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                            </div>
                            @if(Auth::user()->email_verified_at)
                                <span class="bg-green-100 text-green-800 px-3 py-1 round                       <p class="text-sm text-gray-600">Your employer account is active</p>
                            </div>
                            <span class="bg-green-500 text-white px-4 py-2 rounded-full text-sm font-semibold">
                                <i class="fas fa-check-circle mr-1"></i>Active
                            </span>
                        </div>
                    </div>

                    <!-- Email Verification -->
                    <div class="p-6 border-2 border-gi class="fas fa-user-cog section-icon text-4xl"></i>
                    </div>
                </div>

                <div class="space-y-6">
                    <!-- Account Status -->
                    <div class="p-6 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border-2 border-green-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-1">Account Status</h3>
         -in">
                <div class="section-header flex items-center justify-between mb-8">
                    <div class="flex-1">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Account Settings</h2>
                        <p class="text-gray-600">Manage your account details and verification</p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-green-100 to-emerald-100 rounded-2xl flex items-center justify-center">
                        <>
                        <button type="submit" class="gradient-button text-white px-10 py-4 rounded-xl font-bold shadow-2xl transform hover:scale-105 transition-all">
                            <i class="fas fa-save mr-2"></i>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Account Section -->
            <div id="account-section" class="settings-section settings-card p-8 hidden animate-slide   placeholder="Tell job seekers about your company...">{{ Auth::user()->company_description ?? '' }}</textarea>
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t-2 border-gray-100">
                        <p class="text-sm text-gray-500 flex items-center">
                            <i class="fas fa-clock mr-2 text-blue-primary"></i>
                            Last updated: {{ Auth::user()->updated_at->diffForHumans() }}
                        </pelative">
                        <label class="block text-sm font-bold text-gray-700 mb-3">
                            <i class="fas fa-info-circle text-blue-primary mr-2"></i>Company Description
                        </label>
                        <textarea name="company_description" rows="4" 
                                  class="fancy-input w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-primary focus:border-transparent transition"
                               fa-map-marker-alt text-blue-primary mr-2"></i>Company Address
                        </label>
                        <textarea name="address" rows="3" 
                                  class="fancy-input w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-primary focus:border-transparent transition"
                                  placeholder="Full company address...">{{ Auth::user()->address ?? '' }}</textarea>
                    </div>

                    <div class="r              <option>51-200 employees</option>
                                <option>201-500 employees</option>
                                <option>501-1000 employees</option>
                                <option>1000+ employees</option>
                            </select>
                        </div>
                    </div>

                    <div class="relative">
                        <label class="block text-sm font-bold text-gray-700 mb-3">
                            <i class="fas t-sm font-bold text-gray-700 mb-3">
                                <i class="fas fa-users text-blue-primary mr-2"></i>Company Size
                            </label>
                            <select name="company_size" class="fancy-input w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-primary focus:border-transparent transition">
                                <option>1-10 employees</option>
                                <option>11-50 employees</option>
                                      </label>
                            <input type="url" name="website" value="{{ Auth::user()->website ?? '' }}" 
                                   class="fancy-input w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-primary focus:border-transparent transition"
                                   placeholder="https://yourcompany.com">
                        </div>
                        <div class="relative">
                            <label class="block tex }}" 
                                   class="fancy-input w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-primary focus:border-transparent transition"
                                   placeholder="+256 700 000 000">
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                <i class="fas fa-globe text-blue-primary mr-2"></i>Website
        y-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-primary focus:border-transparent transition">
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                <i class="fas fa-phone text-blue-primary mr-2"></i>Company Phone
                            </label>
                            <input type="tel" name="company_phone" value="{{ Auth::user()->phone ?? ''                 </select>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                <i class="fas fa-envelope text-blue-primary mr-2"></i>Company Email
                            </label>
                            <input type="email" name="company_email" value="{{ Auth::user()->email ?? '' }}" required
                                   class="fancy-input w-full px-4 p <option>Technology</option>
                                <option>Healthcare</option>
                                <option>Finance</option>
                                <option>Education</option>
                                <option>Retail</option>
                                <option>Manufacturing</option>
                                <option>Hospitality</option>
                                <option>Construction</option>
                                <option>Other</option>
                       </div>
                        <div class="relative">
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                <i class="fas fa-industry text-blue-primary mr-2"></i>Industry
                            </label>
                            <select name="industry" class="fancy-input w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-primary focus:border-transparent transition">
                               <label class="block text-sm font-bold text-gray-700 mb-3">
                                <i class="fas fa-building text-blue-primary mr-2"></i>Company Name
                            </label>
                            <input type="text" name="company_name" value="{{ Auth::user()->company_name ?? '' }}" required
                                   class="fancy-input w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-primary focus:border-transparent transition">
            shadow-lg">
                                <i class="fas fa-upload mr-2"></i>
                                <span>Upload Logo</span>
                                <input type="file" name="company_logo" accept="image/*" class="hidden" onchange="previewCompanyLogo(this)">
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="relative">
                                    <i class="fas fa-camera text-white"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800 mb-2 text-lg">Company Logo</h3>
                            <p class="text-sm text-gray-600 mb-4">Upload your company logo (JPG, PNG, max 2MB)</p>
                            <label class="cursor-pointer gradient-button text-white px-6 py-3 rounded-xl inline-flex items-center font-semibold 

        </div>
    </div>
</div>

<script>
    // Section Navigation
    function showSection(sectionId) {
        // Hide all sections
        document.querySelectorAll('.settings-section').forEach(section => {
            section.classList.add('hidden');
        });
        
        // Remove active class from all nav items
        document.querySelectorAll('.settings-nav-item').forEach(item => {
            item.classList.remove('active');
        });
        
        // Show selected section
        const targetSection = document.getElementById(sectionId + '-section');
        if (targetSection) {
            targetSection.classList.remove('hidden');
        }
        
        // Add active class to clicked nav item
        const activeLink = document.querySelector(`a[href="#${sectionId}"]`);
        if (activeLink) {
            activeLink.classList.add('active');
        }
    }

    // Profile Picture Preview
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profilePreview').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Company Logo Preview
    function previewCompanyLogo(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('companyLogoPreview').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Initialize - Show first section by default
    document.addEventListener('DOMContentLoaded', function() {
        showSection('company-profile');
    });
</script>

</body>
</html>
