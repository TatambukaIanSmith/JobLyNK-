<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - JOB-lyNK</title>
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
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-blue-primary shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="{{ route('home') }}" class="text-white text-2xl font-bold">JOB-lyNK</a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ Auth::user()->isEmployer() ? route('employerDashboard') : route('worker') }}" 
                           class="text-blue-light hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                            Back to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-blue-light hover:text-white px-3 py-2 rounded-md text-sm font-medium">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Complete Your Payment</h1>
            <p class="text-gray-600">Secure payment processing for your job posting</p>
        </div>

        <!-- Success/Error Messages -->
        <div id="alertContainer" class="mb-6 hidden">
            <div id="alertMessage" class="p-4 rounded-lg"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Payment Methods -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Choose Payment Method</h2>
                    
                    <!-- Mobile Money (Telecom) -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Mobile Money</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <!-- MTN Mobile Money -->
                            <label class="relative">
                                <input type="radio" name="paymentMethod" value="mtn" class="sr-only peer">
                                <div class="border-2 border-gray-300 rounded-lg p-4 cursor-pointer peer-checked:border-blue-primary peer-checked:bg-blue-light transition-all hover:border-gray-400">
                                    <div class="text-center">
                                        <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center mx-auto mb-2">
                                            <span class="text-white font-bold text-sm">MTN</span>
                                        </div>
                                        <div class="font-semibold text-sm">MTN MoMo</div>
                                        <div class="text-xs text-gray-600">Mobile Money</div>
                                    </div>
                                </div>
                            </label>

                            <!-- Airtel Money -->
                            <label class="relative">
                                <input type="radio" name="paymentMethod" value="airtel" class="sr-only peer">
                                <div class="border-2 border-gray-300 rounded-lg p-4 cursor-pointer peer-checked:border-blue-primary peer-checked:bg-blue-light transition-all hover:border-gray-400">
                                    <div class="text-center">
                                        <div class="w-12 h-12 bg-red-600 rounded-full flex items-center justify-center mx-auto mb-2">
                                            <span class="text-white font-bold text-xs">Airtel</span>
                                        </div>
                                        <div class="font-semibold text-sm">Airtel Money</div>
                                        <div class="text-xs text-gray-600">Mobile Money</div>
                                    </div>
                                </div>
                            </label>

                            <!-- Vodacom M-Pesa -->
                            <label class="relative">
                                <input type="radio" name="paymentMethod" value="mpesa" class="sr-only peer">
                                <div class="border-2 border-gray-300 rounded-lg p-4 cursor-pointer peer-checked:border-blue-primary peer-checked:bg-blue-light transition-all hover:border-gray-400">
                                    <div class="text-center">
                                        <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-2">
                                            <span class="text-white font-bold text-xs">M-Pesa</span>
                                        </div>
                                        <div class="font-semibold text-sm">M-Pesa</div>
                                        <div class="text-xs text-gray-600">Vodacom</div>
                                    </div>
                                </div>
                            </label>

                            <!-- Orange Money -->
                            <label class="relative">
                                <input type="radio" name="paymentMethod" value="orange" class="sr-only peer">
                                <div class="border-2 border-gray-300 rounded-lg p-4 cursor-pointer peer-checked:border-blue-primary peer-checked:bg-blue-light transition-all hover:border-gray-400">
                                    <div class="text-center">
                                        <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-2">
                                            <span class="text-white font-bold text-xs">Orange</span>
                                        </div>
                                        <div class="font-semibold text-sm">Orange Money</div>
                                        <div class="text-xs text-gray-600">Mobile Money</div>
                                    </div>
                                </div>
                            </label>

                            <!-- Tigo Pesa -->
                            <label class="relative">
                                <input type="radio" name="paymentMethod" value="tigo" class="sr-only peer">
                                <div class="border-2 border-gray-300 rounded-lg p-4 cursor-pointer peer-checked:border-blue-primary peer-checked:bg-blue-light transition-all hover:border-gray-400">
                                    <div class="text-center">
                                        <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-2">
                                            <span class="text-white font-bold text-xs">Tigo</span>
                                        </div>
                                        <div class="font-semibold text-sm">Tigo Pesa</div>
                                        <div class="text-xs text-gray-600">Mobile Money</div>
                                    </div>
                                </div>
                            </label>

                            <!-- Telecel Cash -->
                            <label class="relative">
                                <input type="radio" name="paymentMethod" value="telecel" class="sr-only peer">
                                <div class="border-2 border-gray-300 rounded-lg p-4 cursor-pointer peer-checked:border-blue-primary peer-checked:bg-blue-light transition-all hover:border-gray-400">
                                    <div class="text-center">
                                        <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center mx-auto mb-2">
                                            <span class="text-white font-bold text-xs">Telecel</span>
                                        </div>
                                        <div class="font-semibold text-sm">Telecel Cash</div>
                                        <div class="text-xs text-gray-600">Mobile Money</div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Bank Cards -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Bank Cards</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <!-- Visa -->
                            <label class="relative">
                                <input type="radio" name="paymentMethod" value="visa" class="sr-only peer">
                                <div class="border-2 border-gray-300 rounded-lg p-4 cursor-pointer peer-checked:border-blue-primary peer-checked:bg-blue-light transition-all hover:border-gray-400">
                                    <div class="text-center">
                                        <i class="fab fa-cc-visa text-3xl text-blue-600 mb-2"></i>
                                        <div class="font-semibold text-sm">Visa</div>
                                    </div>
                                </div>
                            </label>

                            <!-- Mastercard -->
                            <label class="relative">
                                <input type="radio" name="paymentMethod" value="mastercard" class="sr-only peer">
                                <div class="border-2 border-gray-300 rounded-lg p-4 cursor-pointer peer-checked:border-blue-primary peer-checked:bg-blue-light transition-all hover:border-gray-400">
                                    <div class="text-center">
                                        <i class="fab fa-cc-mastercard text-3xl text-red-600 mb-2"></i>
                                        <div class="font-semibold text-sm">Mastercard</div>
                                    </div>
                                </div>
                            </label>

                            <!-- American Express -->
                            <label class="relative">
                                <input type="radio" name="paymentMethod" value="amex" class="sr-only peer">
                                <div class="border-2 border-gray-300 rounded-lg p-4 cursor-pointer peer-checked:border-blue-primary peer-checked:bg-blue-light transition-all hover:border-gray-400">
                                    <div class="text-center">
                                        <i class="fab fa-cc-amex text-3xl text-green-600 mb-2"></i>
                                        <div class="font-semibold text-sm">Amex</div>
                                    </div>
                                </div>
                            </label>

                            <!-- Discover -->
                            <label class="relative">
                                <input type="radio" name="paymentMethod" value="discover" class="sr-only peer">
                                <div class="border-2 border-gray-300 rounded-lg p-4 cursor-pointer peer-checked:border-blue-primary peer-checked:bg-blue-light transition-all hover:border-gray-400">
                                    <div class="text-center">
                                        <i class="fab fa-cc-discover text-3xl text-orange-600 mb-2"></i>
                                        <div class="font-semibold text-sm">Discover</div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Digital Wallets -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Digital Wallets</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <!-- PayPal -->
                            <label class="relative">
                                <input type="radio" name="paymentMethod" value="paypal" class="sr-only peer">
                                <div class="border-2 border-gray-300 rounded-lg p-4 cursor-pointer peer-checked:border-blue-primary peer-checked:bg-blue-light transition-all hover:border-gray-400">
                                    <div class="text-center">
                                        <i class="fab fa-paypal text-3xl text-blue-600 mb-2"></i>
                                        <div class="font-semibold text-sm">PayPal</div>
                                    </div>
                                </div>
                            </label>

                            <!-- Apple Pay -->
                            <label class="relative">
                                <input type="radio" name="paymentMethod" value="applepay" class="sr-only peer">
                                <div class="border-2 border-gray-300 rounded-lg p-4 cursor-pointer peer-checked:border-blue-primary peer-checked:bg-blue-light transition-all hover:border-gray-400">
                                    <div class="text-center">
                                        <i class="fab fa-apple-pay text-3xl text-gray-800 mb-2"></i>
                                        <div class="font-semibold text-sm">Apple Pay</div>
                                    </div>
                                </div>
                            </label>

                            <!-- Google Pay -->
                            <label class="relative">
                                <input type="radio" name="paymentMethod" value="googlepay" class="sr-only peer">
                                <div class="border-2 border-gray-300 rounded-lg p-4 cursor-pointer peer-checked:border-blue-primary peer-checked:bg-blue-light transition-all hover:border-gray-400">
                                    <div class="text-center">
                                        <i class="fab fa-google-pay text-3xl text-green-600 mb-2"></i>
                                        <div class="font-semibold text-sm">Google Pay</div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Payment Form -->
                    <div id="paymentForm" class="mt-8">
                        <!-- Mobile Money Form -->
                        <div id="mobileMoneyForm" class="payment-form hidden">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Mobile Money Details</h3>
                            <div class="space-y-4">
                                <div>
                                    <label for="mobileNumber" class="block text-sm font-medium text-gray-700 mb-2">Mobile Number</label>
                                    <input type="tel" id="mobileNumber" name="mobileNumber" 
                                        placeholder="e.g., +255 123 456 789"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent">
                                </div>
                                <div class="bg-blue-light rounded-lg p-4">
                                    <div class="flex items-start">
                                        <i class="fas fa-info-circle text-blue-primary mt-1 mr-2"></i>
                                        <div class="text-sm text-blue-dark">
                                            <p class="font-semibold mb-1">How it works:</p>
                                            <p>1. Enter your mobile number</p>
                                            <p>2. You'll receive a payment prompt on your phone</p>
                                            <p>3. Confirm the payment using your mobile money PIN</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Form -->
                        <div id="cardForm" class="payment-form hidden">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Card Details</h3>
                            <div class="space-y-4">
                                <div>
                                    <label for="cardNumber" class="block text-sm font-medium text-gray-700 mb-2">Card Number</label>
                                    <input type="text" id="cardNumber" name="cardNumber" 
                                        placeholder="1234 5678 9012 3456"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent">
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="expiryDate" class="block text-sm font-medium text-gray-700 mb-2">Expiry Date</label>
                                        <input type="text" id="expiryDate" name="expiryDate" 
                                            placeholder="MM/YY"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent">
                                    </div>
                                    <div>
                                        <label for="cvv" class="block text-sm font-medium text-gray-700 mb-2">CVV</label>
                                        <input type="text" id="cvv" name="cvv" 
                                            placeholder="123"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent">
                                    </div>
                                </div>
                                <div>
                                    <label for="cardName" class="block text-sm font-medium text-gray-700 mb-2">Cardholder Name</label>
                                    <input type="text" id="cardName" name="cardName" 
                                        placeholder="John Doe"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent">
                                </div>
                            </div>
                        </div>

                        <!-- Digital Wallet Form -->
                        <div id="walletForm" class="payment-form hidden">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Digital Wallet</h3>
                            <div class="bg-gray-50 rounded-lg p-6 text-center">
                                <i class="fas fa-external-link-alt text-3xl text-gray-400 mb-4"></i>
                                <p class="text-gray-600 mb-4">You will be redirected to complete your payment securely.</p>
                                <p class="text-sm text-gray-500">Click "Pay Now" to continue to your wallet provider.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-lg p-6 sticky top-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>
                    
                    <div class="space-y-3 mb-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Job Posting Fee</span>
                            <span class="font-semibold">${{ number_format($jobPostingFee ?? 2.99, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Platform Fee</span>
                            <span class="font-semibold">${{ number_format($platformFee ?? 0.50, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Processing Fee</span>
                            <span class="font-semibold">${{ number_format($processingFee ?? 0.25, 2) }}</span>
                        </div>
                        <hr class="border-gray-200">
                        <div class="flex justify-between text-lg font-bold">
                            <span>Total</span>
                            <span class="text-blue-primary">${{ number_format($totalAmount ?? 3.74, 2) }}</span>
                        </div>
                    </div>

                    @if($job)
                    <div class="mb-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Job Details</h4>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p><strong>Title:</strong> {{ $job->title }}</p>
                            <p><strong>Category:</strong> {{ $job->category->name ?? 'N/A' }}</p>
                            <p><strong>Budget:</strong> UGX {{ number_format($job->budget) }} ({{ ucfirst($job->budget_type) }})</p>
                            <p><strong>Location:</strong> {{ $job->location }}</p>
                        </div>
                    </div>
                    @else
                    <div class="mb-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Service</h4>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p><strong>Type:</strong> Job Posting Fee</p>
                            <p><strong>Duration:</strong> 30 days visibility</p>
                        </div>
                    </div>
                    @endif

                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-900 mb-2">Benefits</h4>
                        <div class="text-sm text-gray-600 space-y-1">
                            <div class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>Reach verified workers</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>Secure payment protection</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>24/7 customer support</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>30-day job visibility</span>
                            </div>
                        </div>
                    </div>

                    <button id="payButton" disabled class="w-full bg-gray-400 text-white py-3 px-4 rounded-lg font-semibold transition duration-300 cursor-not-allowed">
                        Select Payment Method
                    </button>

                    <div class="mt-4 text-center">
                        <div class="flex items-center justify-center text-sm text-gray-500">
                            <i class="fas fa-lock mr-1"></i>
                            <span>Secure SSL encrypted payment</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Setup CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Payment method selection
        const paymentMethods = document.querySelectorAll('input[name="paymentMethod"]');
        const payButton = document.getElementById('payButton');
        const paymentForms = document.querySelectorAll('.payment-form');
        const totalAmount = {{ $totalAmount ?? 3.74 }};

        paymentMethods.forEach(method => {
            method.addEventListener('change', function() {
                // Hide all forms
                paymentForms.forEach(form => form.classList.add('hidden'));
                
                // Show appropriate form
                const value = this.value;
                
                if (['mtn', 'airtel', 'mpesa', 'orange', 'tigo', 'telecel'].includes(value)) {
                    document.getElementById('mobileMoneyForm').classList.remove('hidden');
                } else if (['visa', 'mastercard', 'amex', 'discover'].includes(value)) {
                    document.getElementById('cardForm').classList.remove('hidden');
                } else if (['paypal', 'applepay', 'googlepay'].includes(value)) {
                    document.getElementById('walletForm').classList.remove('hidden');
                }
                
                // Enable pay button
                payButton.disabled = false;
                payButton.className = 'w-full bg-blue-primary text-white py-3 px-4 rounded-lg font-semibold hover:bg-blue-dark transition duration-300';
                payButton.textContent = `Pay Now - $${totalAmount.toFixed(2)}`;
            });
        });

        // Payment processing
        payButton.addEventListener('click', function() {
            if (this.disabled) return;
            
            const selectedMethod = document.querySelector('input[name="paymentMethod"]:checked');
            if (!selectedMethod) {
                showAlert('Please select a payment method', 'error');
                return;
            }
            
            // Validate form fields based on payment method
            if (!validatePaymentForm(selectedMethod.value)) {
                return;
            }
            
            // Process payment
            processPayment(selectedMethod.value);
        });

        function validatePaymentForm(paymentMethod) {
            if (['mtn', 'airtel', 'mpesa', 'orange', 'tigo', 'telecel'].includes(paymentMethod)) {
                const mobileNumber = document.getElementById('mobileNumber').value;
                if (!mobileNumber) {
                    showAlert('Please enter your mobile number', 'error');
                    return false;
                }
            } else if (['visa', 'mastercard', 'amex', 'discover'].includes(paymentMethod)) {
                const cardNumber = document.getElementById('cardNumber').value;
                const expiryDate = document.getElementById('expiryDate').value;
                const cvv = document.getElementById('cvv').value;
                const cardName = document.getElementById('cardName').value;
                
                if (!cardNumber || !expiryDate || !cvv || !cardName) {
                    showAlert('Please fill in all card details', 'error');
                    return false;
                }
            }
            return true;
        }

        function processPayment(paymentMethod) {
            // Disable button and show processing state
            payButton.textContent = 'Processing...';
            payButton.disabled = true;
            payButton.className = 'w-full bg-gray-400 text-white py-3 px-4 rounded-lg font-semibold cursor-not-allowed';
            
            // Prepare payment data
            const paymentData = {
                payment_method: paymentMethod,
                amount: totalAmount,
                payment_type: 'job_posting',
                @if($job)
                job_id: {{ $job->id }},
                @endif
            };

            // Add method-specific data
            if (['mtn', 'airtel', 'mpesa', 'orange', 'tigo', 'telecel'].includes(paymentMethod)) {
                paymentData.mobile_number = document.getElementById('mobileNumber').value;
            } else if (['visa', 'mastercard', 'amex', 'discover'].includes(paymentMethod)) {
                paymentData.card_number = document.getElementById('cardNumber').value;
                paymentData.expiry_date = document.getElementById('expiryDate').value;
                paymentData.cvv = document.getElementById('cvv').value;
                paymentData.card_name = document.getElementById('cardName').value;
            }

            // Send payment request
            $.ajax({
                url: '{{ route("payment.process") }}',
                method: 'POST',
                data: paymentData,
                success: function(response) {
                    if (response.success) {
                        showAlert(response.message, 'success');
                        
                        // Handle different response types
                        if (response.redirect_url) {
                            // Redirect to external payment provider
                            setTimeout(() => {
                                window.location.href = response.redirect_url;
                            }, 2000);
                        } else if (response.requires_confirmation) {
                            // Mobile money - wait for confirmation
                            checkPaymentStatus(response.transaction_id);
                        } else {
                            // Payment completed immediately
                            setTimeout(() => {
                                window.location.href = '{{ Auth::check() && Auth::user()->isEmployer() ? route("employerDashboard") : route("home") }}';
                            }, 3000);
                        }
                    } else {
                        showAlert(response.message, 'error');
                        resetPayButton();
                    }
                },
                error: function(xhr) {
                    let message = 'Payment processing failed. Please try again.';
                    
                    if (xhr.status === 401) {
                        // Authentication required
                        const response = xhr.responseJSON;
                        if (response && response.redirect_url) {
                            showAlert(response.message || 'Please login to continue', 'warning');
                            setTimeout(() => {
                                window.location.href = response.redirect_url;
                            }, 2000);
                            return;
                        } else {
                            message = 'Please login to complete payment';
                        }
                    } else if (xhr.responseJSON?.message) {
                        message = xhr.responseJSON.message;
                    }
                    
                    showAlert(message, 'error');
                    resetPayButton();
                }
            });
        }

        function checkPaymentStatus(transactionId) {
            let attempts = 0;
            const maxAttempts = 30; // Check for 5 minutes (30 * 10 seconds)
            
            const checkStatus = () => {
                attempts++;
                
                $.ajax({
                    url: `{{ route("payment.status", ":id") }}`.replace(':id', transactionId),
                    method: 'GET',
                    success: function(response) {
                        const payment = response.payment;
                        
                        if (payment.status === 'completed') {
                            showAlert('Payment completed successfully! Redirecting...', 'success');
                            setTimeout(() => {
                                window.location.href = '{{ Auth::check() && Auth::user()->isEmployer() ? route("employerDashboard") : route("home") }}';
                            }, 2000);
                        } else if (payment.status === 'failed') {
                            showAlert('Payment failed. Please try again.', 'error');
                            resetPayButton();
                        } else if (attempts < maxAttempts) {
                            // Continue checking
                            setTimeout(checkStatus, 10000); // Check every 10 seconds
                        } else {
                            showAlert('Payment confirmation timeout. Please check your mobile money account.', 'warning');
                            resetPayButton();
                        }
                    },
                    error: function() {
                        if (attempts < maxAttempts) {
                            setTimeout(checkStatus, 10000);
                        } else {
                            showAlert('Unable to verify payment status. Please contact support.', 'error');
                            resetPayButton();
                        }
                    }
                });
            };
            
            // Start checking after 5 seconds
            setTimeout(checkStatus, 5000);
        }

        function resetPayButton() {
            payButton.disabled = false;
            payButton.className = 'w-full bg-blue-primary text-white py-3 px-4 rounded-lg font-semibold hover:bg-blue-dark transition duration-300';
            payButton.textContent = `Pay Now - $${totalAmount.toFixed(2)}`;
        }

        function showAlert(message, type) {
            const alertContainer = document.getElementById('alertContainer');
            const alertMessage = document.getElementById('alertMessage');
            
            const alertClasses = {
                'success': 'bg-green-100 border border-green-400 text-green-700',
                'error': 'bg-red-100 border border-red-400 text-red-700',
                'warning': 'bg-yellow-100 border border-yellow-400 text-yellow-700',
                'info': 'bg-blue-100 border border-blue-400 text-blue-700'
            };
            
            alertMessage.className = `p-4 rounded-lg ${alertClasses[type] || alertClasses.info}`;
            alertMessage.textContent = message;
            alertContainer.classList.remove('hidden');
            
            // Auto-hide success messages
            if (type === 'success') {
                setTimeout(() => {
                    alertContainer.classList.add('hidden');
                }, 5000);
            }
            
            // Scroll to top to show alert
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Card number formatting
        document.getElementById('cardNumber')?.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
            let formattedInputValue = value.match(/.{1,4}/g)?.join(' ');
            if (formattedInputValue) {
                e.target.value = formattedInputValue;
            }
        });

        // Expiry date formatting
        document.getElementById('expiryDate')?.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            e.target.value = value;
        });

        // CVV formatting
        document.getElementById('cvv')?.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '').substring(0, 4);
        });

        // Mobile number formatting
        document.getElementById('mobileNumber')?.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.startsWith('255')) {
                value = '+' + value;
            } else if (value.startsWith('0')) {
                value = '+255' + value.substring(1);
            }
            e.target.value = value;
        });
    </script>
</body>
</html>

