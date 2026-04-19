<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Two-Factor Authentication - JOB-lyNK</title>
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
        <div class="flex items-center space-x-4">
            <a href="{{ url()->previous() }}" class="text-white hover:text-blue-light transition-colors flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                <span class="hidden md:inline">Back</span>
            </a>
            <a href="{{ route('home') }}" class="text-white text-2xl font-bold">JOB-lyNK</a>
        </div>
        <div class="text-blue-light text-sm">
            <i class="fas fa-shield-alt mr-1"></i>
            Setup Two-Factor Authentication
        </div>
    </div>
</nav>

<div class="min-h-screen flex items-center justify-center p-6">
    <div class="max-w-2xl w-full bg-white rounded-lg shadow-lg p-8">

        <div class="text-center mb-8">
            <div class="mx-auto w-16 h-16 bg-blue-light rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-mobile-alt text-2xl text-blue-primary"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-900">Setup Two-Factor Authentication</h2>
            <p class="text-gray-600 mt-2">Secure your account with an extra layer of protection</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            
            <!-- Step 1: Download App -->
            <div class="p-4 border-2 border-blue-200 rounded-lg bg-blue-50">
                <div class="flex items-start mb-3">
                    <div class="flex-shrink-0 flex items-center justify-center h-8 w-8 rounded-full bg-blue-primary text-white font-bold">
                        1
                    </div>
                    <h3 class="ml-3 text-lg font-medium text-gray-900">Download Authenticator App</h3>
                </div>
                <p class="text-sm text-gray-600 ml-11">
                    Download an authenticator app on your phone:
                </p>
                <ul class="text-sm text-gray-600 ml-11 mt-2 space-y-1">
                    <li>• Google Authenticator</li>
                    <li>• Microsoft Authenticator</li>
                    <li>• Authy</li>
                    <li>• FreeOTP</li>
                </ul>
            </div>

            <!-- Step 2: Scan QR Code -->
            <div class="p-4 border-2 border-blue-200 rounded-lg bg-blue-50">
                <div class="flex items-start mb-3">
                    <div class="flex-shrink-0 flex items-center justify-center h-8 w-8 rounded-full bg-blue-primary text-white font-bold">
                        2
                    </div>
                    <h3 class="ml-3 text-lg font-medium text-gray-900">Scan QR Code</h3>
                </div>
                <p class="text-sm text-gray-600 ml-11">
                    Open your authenticator app and scan the QR code below, or enter the secret key manually.
                </p>
            </div>

        </div>

        <!-- QR Code Section -->
        <div class="bg-gray-50 p-8 rounded-lg mb-8 text-center">
            <h3 class="text-lg font-semibold mb-4">Scan this QR code with your authenticator app:</h3>
            <div class="flex justify-center mb-4">
                @if($qrCodeUrl)
                    <img src="{{ $qrCodeUrl }}" alt="QR Code" class="w-64 h-64 border-2 border-gray-300 rounded-lg">
                @else
                    <div class="w-64 h-64 border-2 border-gray-300 rounded-lg bg-gray-100 flex items-center justify-center">
                        <p class="text-gray-500">Unable to generate QR code</p>
                    </div>
                @endif
            </div>
            
            <div class="mt-6 p-4 bg-white border-2 border-dashed border-gray-300 rounded-lg">
                <p class="text-sm text-gray-600 mb-2">Or enter this secret key manually:</p>
                <div class="flex items-center justify-center gap-2">
                    <code class="text-lg font-mono font-bold text-gray-900 break-all">{{ $secret }}</code>
                    <button type="button" onclick="copySecret()" class="text-blue-primary hover:text-blue-dark">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Verification Form -->
        <form method="POST" action="{{ route('two-factor.setup.confirm') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="secret" value="{{ $secret }}">

            @if ($errors->any())
                <div class="p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    @foreach ($errors->all() as $error)
                        <p class="text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div>
                <label class="block text-sm font-medium mb-2">Enter the 6-digit code from your authenticator app:</label>
                <div class="flex justify-center">
                    <input 
                        type="text" 
                        name="code" 
                        id="code"
                        maxlength="6" 
                        pattern="[0-9]{6}"
                        placeholder="000000"
                        class="w-32 text-center text-2xl font-mono px-3 py-3 border-2 rounded-lg focus:ring-2 focus:ring-blue-primary focus:border-transparent tracking-widest"
                        autofocus
                        required
                    >
                </div>
            </div>

            <div class="flex gap-4">
                <a href="{{ route('settings') }}" class="flex-1 bg-gray-300 text-gray-800 py-2 rounded-lg font-semibold hover:bg-gray-400 transition-colors text-center">
                    Cancel
                </a>
                <button type="submit" class="flex-1 bg-blue-primary text-white py-2 rounded-lg font-semibold hover:bg-blue-dark transition-colors">
                    <i class="fas fa-check mr-2"></i>
                    Verify & Enable
                </button>
            </div>
        </form>

        <!-- Warning -->
        <div class="mt-8 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
            <div class="flex items-start">
                <i class="fas fa-exclamation-triangle text-yellow-600 mt-1 mr-3"></i>
                <div>
                    <h4 class="font-semibold text-yellow-800">Important:</h4>
                    <p class="text-sm text-yellow-700 mt-1">
                        After enabling 2FA, you'll need your authenticator app to log in. Make sure you have access to it before proceeding.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    // Auto-format code input
    document.getElementById('code').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 6) value = value.slice(0, 6);
        e.target.value = value;
    });

    function copySecret() {
        const secret = document.querySelector('code').textContent;
        navigator.clipboard.writeText(secret).then(() => {
            alert('Secret key copied to clipboard!');
        });
    }
</script>

</body>
</html>
