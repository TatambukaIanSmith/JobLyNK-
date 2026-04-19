<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - JOB-lyNK</title>

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
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
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
        }

        /* Glass Morphism Card */
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1), 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .demo-btn {
            transition: all 0.3s ease;
        }

        .demo-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>

<body class="glass-background">

@include('includes.navbar')

<div class="min-h-screen flex items-center justify-center p-6 relative z-10">
    <div class="max-w-md w-full glass-card p-6 rounded-lg">

        <!-- Logo -->
        <div class="flex justify-center mb-4">
            <img src="{{ asset('job-lynk-logo.png') }}" alt="JOB-lyNK Logo" class="w-40 h-auto">
        </div>

        <h2 class="text-2xl font-bold text-center mb-4">Sign In</h2>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                @foreach ($errors->all() as $error)
                    <p class="text-sm">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if (session('status'))
            <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                <p class="text-sm">{{ session('status') }}</p>
            </div>
        @endif

        <!-- 2FA Info Banner -->
        <div class="mb-4 p-3 bg-blue-50 border border-blue-200 text-blue-700 rounded flex items-start">
            <i class="fas fa-shield-alt mr-2 mt-0.5 flex-shrink-0"></i>
            <div class="text-sm">
                <p class="font-semibold">Two-Factor Authentication Enabled</p>
                <p class="text-xs mt-1">If you have 2FA enabled, you'll be asked for a verification code after entering your credentials.</p>
            </div>
        </div>

        <form id="loginForm" method="POST" action="{{ route('login.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Email</label>
                <input id="email" name="email" type="email" required value="{{ old('email') }}"
                       autocomplete="email"
                       class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-primary focus:border-transparent">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Password</label>
                <input id="password" name="password" type="password" required
                       autocomplete="current-password"
                       class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-primary focus:border-transparent">
            </div>

            <div class="mb-4 flex items-center">
                <input id="remember" name="remember" type="checkbox" class="mr-2">
                <label for="remember" class="text-sm text-gray-600">Remember me</label>
            </div>

            <button type="submit" class="w-full bg-blue-primary text-white py-2 rounded-lg font-semibold hover:bg-blue-dark transition-colors">
                Sign In
            </button>

        </form>

        <div class="mt-4 text-center">
            <a href="{{ route('password.request') }}" class="text-sm text-blue-primary hover:underline">
                Forgot your password?
            </a>
        </div>

        <div class="mt-6 text-center text-sm text-gray-600 font-medium">
            Quick Login:
        </div>

        <div class="grid grid-cols-2 gap-4 mt-3">
            <button onclick="quickLogin('worker')" class="demo-btn group border-2 border-gray-200 p-3 rounded-xl hover:border-green-500 hover:bg-green-50 transition-all">
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                        <i class="fas fa-hard-hat text-white"></i>
                    </div>
                    <span class="font-semibold text-gray-700 text-sm">Worker Demo</span>
                </div>
            </button>
            <button onclick="quickLogin('employer')" class="demo-btn group border-2 border-gray-200 p-3 rounded-xl hover:border-blue-500 hover:bg-blue-50 transition-all">
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                        <i class="fas fa-briefcase text-white"></i>
                    </div>
                    <span class="font-semibold text-gray-700 text-sm">Employer Demo</span>
                </div>
            </button>
        </div>

        <div class="mt-4 text-center text-xs text-gray-500">
            Demo accounts: test@example.com / employer@example.com (password: password)
        </div>

    </div>
</div>

<script>
    function quickLogin(type) {
        if (type === 'worker') {
            document.getElementById('email').value = 'test@example.com';
        } else {
            document.getElementById('email').value = 'employer@example.com';
        }
        document.getElementById('password').value = 'password';
    }
</script>

@include('includes.footer')

</body>
</html>
