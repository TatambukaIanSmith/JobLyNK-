<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Factor Authentication - JOB-lyNK</title>
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
</head>

<body class="bg-gray-50">

<nav class="bg-blue-primary shadow-lg">
    <div class="max-w-7xl mx-auto px-4 h-16 flex justify-between items-center">
        <a href="{{ route('home') }}" class="text-white text-2xl font-bold">JOB-lyNK</a>
        <div class="text-blue-light text-sm">
            <i class="fas fa-shield-alt mr-1"></i>
            Secure Login
        </div>
    </div>
</nav>

<div class="min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow">

        <div class="text-center mb-6">
            <div class="mx-auto w-16 h-16 bg-blue-light rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-mobile-alt text-2xl text-blue-primary"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900" id="challenge-title">
                Two-Factor Authentication
            </h2>
            <p class="text-gray-600 mt-2" id="challenge-description">
                Enter the 6-digit code from your authenticator app
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                @foreach ($errors->all() as $error)
                    <p class="text-sm">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('two-factor.verify') }}">
            @csrf

            <!-- TOTP Code Input -->
            <div id="totp-section" class="space-y-4">
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2 text-center">Authentication Code</label>
                    <div class="flex justify-center">
                        <input 
                            type="text" 
                            name="code" 
                            id="code"
                            maxlength="6" 
                            pattern="[0-9]{6}"
                            placeholder="000000"
                            class="w-32 text-center text-2xl font-mono px-3 py-3 border-2 rounded-lg focus:ring-2 focus:ring-blue-primary focus:border-transparent tracking-widest"
                            autocomplete="one-time-code"
                            autofocus
                        >
                    </div>
                    <p class="text-xs text-gray-500 text-center mt-2">
                        Enter the 6-digit code from your authenticator app
                    </p>
                </div>
            </div>

            <!-- Recovery Code Input -->
            <div id="recovery-section" class="space-y-4 hidden">
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2 text-center">Recovery Code</label>
                    <input 
                        type="text" 
                        name="recovery_code" 
                        id="recovery_code"
                        placeholder="Enter recovery code"
                        class="w-full text-center px-3 py-3 border-2 rounded-lg focus:ring-2 focus:ring-blue-primary focus:border-transparent"
                        autocomplete="one-time-code"
                    >
                    <p class="text-xs text-gray-500 text-center mt-2">
                        Enter one of your emergency recovery codes
                    </p>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-primary text-white py-3 rounded-lg font-semibold hover:bg-blue-dark transition-colors">
                <i class="fas fa-sign-in-alt mr-2"></i>
                Continue
            </button>
        </form>

        <div class="mt-6 text-center">
            <button 
                onclick="toggleRecoveryMode()" 
                class="text-sm text-blue-primary hover:underline"
                id="toggle-button"
            >
                <i class="fas fa-key mr-1"></i>
                Use recovery code instead
            </button>
        </div>

        <div class="mt-4 text-center">
            <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-gray-700">
                <i class="fas fa-arrow-left mr-1"></i>
                Back to login
            </a>
        </div>

    </div>
</div>

<script>
    let isRecoveryMode = false;

    function toggleRecoveryMode() {
        const totpSection = document.getElementById('totp-section');
        const recoverySection = document.getElementById('recovery-section');
        const title = document.getElementById('challenge-title');
        const description = document.getElementById('challenge-description');
        const toggleButton = document.getElementById('toggle-button');
        const codeInput = document.getElementById('code');
        const recoveryInput = document.getElementById('recovery_code');

        isRecoveryMode = !isRecoveryMode;

        if (isRecoveryMode) {
            // Switch to recovery mode
            totpSection.classList.add('hidden');
            recoverySection.classList.remove('hidden');
            title.textContent = 'Recovery Code';
            description.textContent = 'Enter one of your emergency recovery codes';
            toggleButton.innerHTML = '<i class="fas fa-mobile-alt mr-1"></i>Use authenticator code instead';
            
            // Clear and focus recovery input
            codeInput.value = '';
            recoveryInput.focus();
            recoveryInput.required = true;
            codeInput.required = false;
        } else {
            // Switch to TOTP mode
            recoverySection.classList.add('hidden');
            totpSection.classList.remove('hidden');
            title.textContent = 'Two-Factor Authentication';
            description.textContent = 'Enter the 6-digit code from your authenticator app';
            toggleButton.innerHTML = '<i class="fas fa-key mr-1"></i>Use recovery code instead';
            
            // Clear and focus code input
            recoveryInput.value = '';
            codeInput.focus();
            codeInput.required = true;
            recoveryInput.required = false;
        }
    }

    // Auto-format TOTP code input
    document.getElementById('code').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
        if (value.length > 6) value = value.slice(0, 6);
        e.target.value = value;
        
        // Auto-submit when 6 digits entered
        if (value.length === 6) {
            setTimeout(() => {
                e.target.form.submit();
            }, 500);
        }
    });

    // Auto-focus on page load
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('code').focus();
    });
</script>

</body>
</html>