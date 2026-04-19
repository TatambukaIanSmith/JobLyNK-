<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Join JOB-lyNK - Register</title>
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
    <link href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.0.0/css/flag-icons.min.css" rel="stylesheet">
    <style>
        .radio-card {
            transition: all 0.2s ease;
        }
        .radio-card:hover {
            border-color: #3b82f6;
        }
        .radio-card.selected {
            border-color: #1e40af !important;
            background-color: #dbeafe !important;
        }
        
        /* Flag icon styling */
        .fi {
            width: 20px;
            height: 15px;
            display: inline-block;
            margin-right: 8px;
            border-radius: 2px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }
        
        select option {
            padding: 8px;
            display: flex;
            align-items: center;
        }
        
        /* Flag icon styling */
        .fi {
            width: 20px;
            height: 15px;
            display: inline-block;
            margin-right: 8px;
            border-radius: 2px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }
        
        /* Custom select with flags */
        #countryCode {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
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
        
        /* Mobile adjustments */
        @media (max-width: 640px) {
            .grid-cols-2 {
                grid-template-columns: 1fr;
            }
        }
        
        /* Parallax scrolling effect for left panel */
        .parallax-content {
            transition: transform 0.3s ease-out;
        }
        
        /* Fade in animation for features */
        .feature-item {
            opacity: 0;
            transform: translateX(-20px);
            animation: fadeInLeft 0.6s ease-out forwards;
        }
        
        .feature-item:nth-child(1) {
            animation-delay: 0.2s;
        }
        
        .feature-item:nth-child(2) {
            animation-delay: 0.4s;
        }
        
        .feature-item:nth-child(3) {
            animation-delay: 0.6s;
        }
        
        @keyframes fadeInLeft {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('includes.navbar')

    <div class="min-h-screen flex flex-col lg:flex-row">
        <!-- Left side - Image/Info -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-blue-primary to-blue-secondary items-center justify-center p-8 overflow-hidden">
            <div class="text-center text-white max-w-lg parallax-content" id="parallaxContent">
                <i class="fas fa-users text-5xl lg:text-6xl mb-6"></i>
                <h2 class="text-2xl lg:text-3xl font-bold mb-4">Join Our Community</h2>
                <p class="text-lg lg:text-xl text-blue-light mb-6">Connect with thousands of workers and employers</p>
                <div class="space-y-4 text-left">
                    <div class="flex items-center feature-item">
                        <i class="fas fa-check-circle text-green-400 mr-3 text-xl"></i>
                        <span class="text-base lg:text-lg">Verified profiles and secure payments</span>
                    </div>
                    <div class="flex items-center feature-item">
                        <i class="fas fa-check-circle text-green-400 mr-3 text-xl"></i>
                        <span class="text-base lg:text-lg">Flexible work arrangements</span>
                    </div>
                    <div class="flex items-center feature-item">
                        <i class="fas fa-check-circle text-green-400 mr-3 text-xl"></i>
                        <span class="text-base lg:text-lg">24/7 customer support</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right side - Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-4 sm:p-6 lg:p-8">
            <div class="max-w-md w-full">
                <!-- Logo -->
                <div class="flex justify-center mb-6">
                    <img src="{{ asset('job-lynk-logo.png') }}" alt="JOB-lyNK Logo" class="w-40 sm:w-48 h-auto">
                </div>
                
                <div class="text-center mb-6 lg:mb-8">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Create Your Account</h2>
                    <p class="text-sm sm:text-base text-gray-600">Choose your account type to get started</p>
                </div>

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <strong>Please fix the following issues:</strong>
                        </div>
                        <ul class="list-disc list-inside text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        
                        @if ($errors->has('email') && str_contains($errors->first('email'), 'already exists'))
                            <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded">
                                <div class="flex items-center justify-between">
                                    <span class="text-blue-800 text-sm">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Already have an account?
                                    </span>
                                    <a href="{{ route('login') }}" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition-colors">
                                        <i class="fas fa-sign-in-alt mr-1"></i>
                                        Login Instead
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                @if (session('status'))
                    <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                        <p class="text-sm">{{ session('status') }}</p>
                    </div>
                @endif

                <!-- Account Type Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">I want to: <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="relative cursor-pointer" onclick="selectWorker()">
                            <input type="radio" name="accountType" value="worker" id="worker" class="sr-only" checked>
                            <div id="workerCard" class="border-2 border-blue-primary bg-blue-light rounded-lg p-4 transition-all">
                                <div class="text-center">
                                    <i class="fas fa-user text-2xl text-blue-primary mb-2"></i>
                                    <div class="font-semibold text-gray-900">Find Work</div>
                                    <div class="text-sm text-gray-600">Join as Worker</div>
                                </div>
                            </div>
                        </div>
                        <div class="relative cursor-pointer" onclick="selectEmployer()">
                            <input type="radio" name="accountType" value="employer" id="employer" class="sr-only">
                            <div id="employerCard" class="border-2 border-gray-300 rounded-lg p-4 transition-all">
                                <div class="text-center">
                                    <i class="fas fa-briefcase text-2xl text-blue-primary mb-2"></i>
                                    <div class="font-semibold text-gray-900">Hire Workers</div>
                                    <div class="text-sm text-gray-600">Join as Employer</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @error('accountType')
                        <p class="mt-2 text-sm text-red-600">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                    <div id="accountTypeError" class="mt-2 text-sm text-red-600 hidden">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        <span>Please select whether you want to join as a Worker or Employer.</span>
                    </div>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-6" id="registrationForm">
                    @csrf
                    
                    <!-- Hidden field for account type -->
                    <input type="hidden" name="accountType" id="accountTypeField" value="worker">

                    <!-- Basic Information -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="firstName" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                            <input type="text" id="firstName" name="firstName" value="{{ old('firstName') }}" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent">
                        </div>
                        <div>
                            <label for="lastName" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                            <input type="text" id="lastName" name="lastName" value="{{ old('lastName') }}" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent">
                        </div>
                    </div>

                    <!-- Hidden field to combine first and last name -->
                    <input type="hidden" name="name" id="fullName">

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <div class="relative">
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent @error('email') border-red-500 @enderror">
                            <div id="emailStatus" class="absolute right-3 top-3 hidden">
                                <i class="fas fa-spinner fa-spin text-gray-400" id="emailLoading"></i>
                                <i class="fas fa-check-circle text-green-500 hidden" id="emailAvailable"></i>
                                <i class="fas fa-times-circle text-red-500 hidden" id="emailTaken"></i>
                            </div>
                        </div>
                        <div id="emailMessage" class="mt-1 text-sm hidden">
                            <div id="emailAvailableMsg" class="text-green-600 hidden">
                                <i class="fas fa-check mr-1"></i>
                                Email is available
                            </div>
                            <div id="emailTakenMsg" class="text-red-600 hidden">
                                <i class="fas fa-times mr-1"></i>
                                <span id="emailTakenText">Email already exists</span>
                                <a href="{{ route('login') }}" class="ml-2 text-blue-600 hover:underline">Login instead?</a>
                            </div>
                        </div>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <div class="flex gap-2">
                            <!-- Custom Country Code Selector with Real Flags -->
                            <div class="relative w-48">
                                <button type="button" id="countryCodeBtn" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent bg-white text-sm flex items-center justify-between">
                                    <span class="flex items-center">
                                        <span class="fi fi-ug mr-2"></span>
                                        <span id="selectedCountry">Uganda +256</span>
                                    </span>
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </button>
                                <input type="hidden" id="countryCode" name="country_code" value="+256" required>
                                
                                <!-- Dropdown Menu -->
                                <div id="countryDropdown" class="hidden absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                    <input type="text" id="countrySearch" placeholder="Search country..." 
                                        class="w-full px-3 py-2 border-b border-gray-200 focus:outline-none text-sm sticky top-0 bg-white">
                                    <div id="countryList" class="py-1">
                                        <!-- East Africa -->
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+256" data-flag="ug" data-name="Uganda">
                                            <span class="fi fi-ug mr-2"></span>
                                            <span>Uganda +256</span>
                                        </div>
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+254" data-flag="ke" data-name="Kenya">
                                            <span class="fi fi-ke mr-2"></span>
                                            <span>Kenya +254</span>
                                        </div>
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+255" data-flag="tz" data-name="Tanzania">
                                            <span class="fi fi-tz mr-2"></span>
                                            <span>Tanzania +255</span>
                                        </div>
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+250" data-flag="rw" data-name="Rwanda">
                                            <span class="fi fi-rw mr-2"></span>
                                            <span>Rwanda +250</span>
                                        </div>
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+257" data-flag="bi" data-name="Burundi">
                                            <span class="fi fi-bi mr-2"></span>
                                            <span>Burundi +257</span>
                                        </div>
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+211" data-flag="ss" data-name="South Sudan">
                                            <span class="fi fi-ss mr-2"></span>
                                            <span>South Sudan +211</span>
                                        </div>
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+251" data-flag="et" data-name="Ethiopia">
                                            <span class="fi fi-et mr-2"></span>
                                            <span>Ethiopia +251</span>
                                        </div>
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+252" data-flag="so" data-name="Somalia">
                                            <span class="fi fi-so mr-2"></span>
                                            <span>Somalia +252</span>
                                        </div>
                                        
                                        <!-- West Africa -->
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+234" data-flag="ng" data-name="Nigeria">
                                            <span class="fi fi-ng mr-2"></span>
                                            <span>Nigeria +234</span>
                                        </div>
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+233" data-flag="gh" data-name="Ghana">
                                            <span class="fi fi-gh mr-2"></span>
                                            <span>Ghana +233</span>
                                        </div>
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+225" data-flag="ci" data-name="Ivory Coast">
                                            <span class="fi fi-ci mr-2"></span>
                                            <span>Ivory Coast +225</span>
                                        </div>
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+221" data-flag="sn" data-name="Senegal">
                                            <span class="fi fi-sn mr-2"></span>
                                            <span>Senegal +221</span>
                                        </div>
                                        
                                        <!-- Southern Africa -->
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+27" data-flag="za" data-name="South Africa">
                                            <span class="fi fi-za mr-2"></span>
                                            <span>South Africa +27</span>
                                        </div>
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+260" data-flag="zm" data-name="Zambia">
                                            <span class="fi fi-zm mr-2"></span>
                                            <span>Zambia +260</span>
                                        </div>
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+263" data-flag="zw" data-name="Zimbabwe">
                                            <span class="fi fi-zw mr-2"></span>
                                            <span>Zimbabwe +263</span>
                                        </div>
                                        
                                        <!-- North Africa -->
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+20" data-flag="eg" data-name="Egypt">
                                            <span class="fi fi-eg mr-2"></span>
                                            <span>Egypt +20</span>
                                        </div>
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+212" data-flag="ma" data-name="Morocco">
                                            <span class="fi fi-ma mr-2"></span>
                                            <span>Morocco +212</span>
                                        </div>
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+213" data-flag="dz" data-name="Algeria">
                                            <span class="fi fi-dz mr-2"></span>
                                            <span>Algeria +213</span>
                                        </div>
                                        
                                        <!-- North America -->
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+1" data-flag="us" data-name="USA/Canada">
                                            <span class="fi fi-us mr-2"></span>
                                            <span>USA/Canada +1</span>
                                        </div>
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+52" data-flag="mx" data-name="Mexico">
                                            <span class="fi fi-mx mr-2"></span>
                                            <span>Mexico +52</span>
                                        </div>
                                        
                                        <!-- Europe -->
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+44" data-flag="gb" data-name="United Kingdom">
                                            <span class="fi fi-gb mr-2"></span>
                                            <span>United Kingdom +44</span>
                                        </div>
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+49" data-flag="de" data-name="Germany">
                                            <span class="fi fi-de mr-2"></span>
                                            <span>Germany +49</span>
                                        </div>
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+33" data-flag="fr" data-name="France">
                                            <span class="fi fi-fr mr-2"></span>
                                            <span>France +33</span>
                                        </div>
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+39" data-flag="it" data-name="Italy">
                                            <span class="fi fi-it mr-2"></span>
                                            <span>Italy +39</span>
                                        </div>
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+34" data-flag="es" data-name="Spain">
                                            <span class="fi fi-es mr-2"></span>
                                            <span>Spain +34</span>
                                        </div>
                                        
                                        <!-- Asia -->
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+91" data-flag="in" data-name="India">
                                            <span class="fi fi-in mr-2"></span>
                                            <span>India +91</span>
                                        </div>
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+86" data-flag="cn" data-name="China">
                                            <span class="fi fi-cn mr-2"></span>
                                            <span>China +86</span>
                                        </div>
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+81" data-flag="jp" data-name="Japan">
                                            <span class="fi fi-jp mr-2"></span>
                                            <span>Japan +81</span>
                                        </div>
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+82" data-flag="kr" data-name="South Korea">
                                            <span class="fi fi-kr mr-2"></span>
                                            <span>South Korea +82</span>
                                        </div>
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+65" data-flag="sg" data-name="Singapore">
                                            <span class="fi fi-sg mr-2"></span>
                                            <span>Singapore +65</span>
                                        </div>
                                        
                                        <!-- Middle East -->
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+971" data-flag="ae" data-name="UAE">
                                            <span class="fi fi-ae mr-2"></span>
                                            <span>UAE +971</span>
                                        </div>
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+966" data-flag="sa" data-name="Saudi Arabia">
                                            <span class="fi fi-sa mr-2"></span>
                                            <span>Saudi Arabia +966</span>
                                        </div>
                                        
                                        <!-- Oceania -->
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+61" data-flag="au" data-name="Australia">
                                            <span class="fi fi-au mr-2"></span>
                                            <span>Australia +61</span>
                                        </div>
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+64" data-flag="nz" data-name="New Zealand">
                                            <span class="fi fi-nz mr-2"></span>
                                            <span>New Zealand +64</span>
                                        </div>
                                        
                                        <!-- South America -->
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+55" data-flag="br" data-name="Brazil">
                                            <span class="fi fi-br mr-2"></span>
                                            <span>Brazil +55</span>
                                        </div>
                                        <div class="country-option px-3 py-2 hover:bg-blue-50 cursor-pointer flex items-center text-sm" data-code="+54" data-flag="ar" data-name="Argentina">
                                            <span class="fi fi-ar mr-2"></span>
                                            <span>Argentina +54</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="712 345 678" required
                                class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent"
                                pattern="[0-9]{9,15}" title="Please enter a valid phone number (9-15 digits)">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Select your country code and enter your phone number</p>
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">City/Location</label>
                        <div class="relative">
                            <select id="location" name="location" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent appearance-none bg-white">
                                <option value="">Select country first...</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                        <!-- Custom city input (shown when "Other" is selected) -->
                        <div id="customCityInput" class="hidden mt-2">
                            <input type="text" id="customCity" name="custom_city" placeholder="Enter your city name"
                                class="w-full px-3 py-2 border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent">
                            <p class="text-xs text-blue-600 mt-1">
                                <i class="fas fa-info-circle mr-1"></i>
                                Please enter your city name
                            </p>
                        </div>
                        <p class="text-xs text-gray-500 mt-1" id="locationHint">Select your country code first to see available cities</p>
                    </div>

                    <div>
                        <label for="age" class="block text-sm font-medium text-gray-700 mb-1">Age <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select id="age" name="age" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent appearance-none bg-white @error('age') border-red-500 @enderror">
                                <option value="">Select your age</option>
                                @for ($i = 18; $i <= 65; $i++)
                                    <option value="{{ $i }}" {{ old('age') == $i ? 'selected' : '' }}>{{ $i }} years</option>
                                @endfor
                                <option value="65+" {{ old('age') == '65+' ? 'selected' : '' }}>65+ years</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-info-circle mr-1"></i>
                            You must be at least 18 years old to register
                        </p>
                        @error('age')
                            <p class="mt-1 text-sm text-red-600">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input type="password" id="password" name="password" required
                                autocomplete="new-password"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent">
                            <p class="text-xs text-gray-500 mt-1">Minimum 8 characters</p>
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                autocomplete="new-password"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent">
                        </div>
                    </div>

                    <!-- Worker-specific fields -->
                    <div id="workerFields" class="space-y-4">
                        <div>
                            <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">Brief Bio</label>
                            <textarea id="bio" name="bio" rows="3" placeholder="Tell us about yourself and your experience..." 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent">{{ old('bio') }}</textarea>
                        </div>
                    </div>

                    <!-- Employer-specific fields -->
                    <div id="employerFields" class="space-y-4 hidden">
                        <div>
                            <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">Company Description</label>
                            <textarea id="employerBio" name="bio" rows="3" placeholder="Tell us about your company and what you do..." 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-primary focus:border-transparent">{{ old('bio') }}</textarea>
                        </div>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="flex items-start">
                        <input type="checkbox" id="terms" name="terms" required
                            class="mt-1 h-4 w-4 text-blue-primary border-gray-300 rounded focus:ring-blue-primary">
                        <label for="terms" class="ml-2 text-sm text-gray-600">
                            I agree to the <a href="{{ route('terms-of-service') }}" target="_blank" class="text-blue-primary hover:text-blue-dark">Terms of Service</a> 
                            and <a href="{{ route('privacy-policy') }}" target="_blank" class="text-blue-primary hover:text-blue-dark">Privacy Policy</a>
                        </label>
                    </div>

                    <button type="submit" 
                        class="w-full bg-blue-primary text-white py-3 px-4 rounded-lg font-semibold hover:bg-blue-dark transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-primary focus:ring-offset-2">
                        <i class="fas fa-user-plus mr-2"></i>
                        Create Account
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-gray-600">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="text-blue-primary hover:text-blue-dark font-semibold">Sign in</a>
                    </p>
                </div>

                <!-- Social Registration -->
                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-gray-50 text-gray-500">Or continue with</span>
                        </div>
                    </div>
                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <a href="{{ route('auth.google') }}?type=worker" id="googleBtn" 
                           class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition-colors">
                            <i class="fab fa-google text-red-500"></i>
                            <span class="ml-2">Google</span>
                        </a>
                        <a href="{{ route('auth.facebook') }}?type=worker" id="facebookBtn"
                           class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition-colors">
                            <i class="fab fa-facebook-f text-blue-600"></i>
                            <span class="ml-2">Facebook</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Simple account type selection functions
        function selectWorker() {
            document.getElementById('worker').checked = true;
            document.getElementById('accountTypeField').value = 'worker';
            document.getElementById('workerCard').className = 'border-2 border-blue-primary bg-blue-light rounded-lg p-4 transition-all';
            document.getElementById('employerCard').className = 'border-2 border-gray-300 rounded-lg p-4 transition-all';
            showWorkerFields();
            hideAccountTypeError();
            updateSocialLinks('worker');
        }

        function selectEmployer() {
            document.getElementById('employer').checked = true;
            document.getElementById('accountTypeField').value = 'employer';
            document.getElementById('employerCard').className = 'border-2 border-blue-primary bg-blue-light rounded-lg p-4 transition-all';
            document.getElementById('workerCard').className = 'border-2 border-gray-300 rounded-lg p-4 transition-all';
            showEmployerFields();
            hideAccountTypeError();
            updateSocialLinks('employer');
        }

        function updateSocialLinks(type) {
            const googleBtn = document.getElementById('googleBtn');
            const facebookBtn = document.getElementById('facebookBtn');
            
            googleBtn.href = `{{ route('auth.google') }}?type=${type}`;
            facebookBtn.href = `{{ route('auth.facebook') }}?type=${type}`;
        }

        function showWorkerFields() {
            document.getElementById('workerFields').classList.remove('hidden');
            document.getElementById('employerFields').classList.add('hidden');
        }

        function showEmployerFields() {
            document.getElementById('workerFields').classList.add('hidden');
            document.getElementById('employerFields').classList.remove('hidden');
        }

        function hideAccountTypeError() {
            document.getElementById('accountTypeError').classList.add('hidden');
        }

        function showAccountTypeError() {
            document.getElementById('accountTypeError').classList.remove('hidden');
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Check URL parameter
            const urlParams = new URLSearchParams(window.location.search);
            const accountType = urlParams.get('type');
            
            if (accountType === 'employer') {
                selectEmployer();
            } else {
                selectWorker(); // Default to worker
            }
        });

        // Combine first and last name
        function updateFullName() {
            const firstName = document.getElementById('firstName').value;
            const lastName = document.getElementById('lastName').value;
            document.getElementById('fullName').value = `${firstName} ${lastName}`.trim();
        }

        document.getElementById('firstName').addEventListener('input', updateFullName);
        document.getElementById('lastName').addEventListener('input', updateFullName);

        // Email availability checking
        let emailCheckTimeout;
        const emailInput = document.getElementById('email');
        const emailStatus = document.getElementById('emailStatus');
        const emailMessage = document.getElementById('emailMessage');
        const emailLoading = document.getElementById('emailLoading');
        const emailAvailable = document.getElementById('emailAvailable');
        const emailTaken = document.getElementById('emailTaken');
        const emailAvailableMsg = document.getElementById('emailAvailableMsg');
        const emailTakenMsg = document.getElementById('emailTakenMsg');
        const emailTakenText = document.getElementById('emailTakenText');

        function hideAllEmailStatus() {
            emailStatus.classList.add('hidden');
            emailMessage.classList.add('hidden');
            emailLoading.classList.add('hidden');
            emailAvailable.classList.add('hidden');
            emailTaken.classList.add('hidden');
            emailAvailableMsg.classList.add('hidden');
            emailTakenMsg.classList.add('hidden');
        }

        function showEmailLoading() {
            hideAllEmailStatus();
            emailStatus.classList.remove('hidden');
            emailLoading.classList.remove('hidden');
        }

        function showEmailAvailable() {
            hideAllEmailStatus();
            emailStatus.classList.remove('hidden');
            emailMessage.classList.remove('hidden');
            emailAvailable.classList.remove('hidden');
            emailAvailableMsg.classList.remove('hidden');
        }

        function showEmailTaken(message) {
            hideAllEmailStatus();
            emailStatus.classList.remove('hidden');
            emailMessage.classList.remove('hidden');
            emailTaken.classList.remove('hidden');
            emailTakenMsg.classList.remove('hidden');
            emailTakenText.textContent = message;
        }

        async function checkEmailAvailability(email) {
            if (!email || email.length < 3) {
                hideAllEmailStatus();
                return;
            }

            showEmailLoading();

            try {
                const response = await fetch('/api/check-email', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                                       document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({ email: email })
                });

                const data = await response.json();

                if (data.available) {
                    showEmailAvailable();
                } else {
                    showEmailTaken(data.message);
                }
            } catch (error) {
                console.error('Email check error:', error);
                hideAllEmailStatus();
            }
        }

        emailInput.addEventListener('input', function() {
            clearTimeout(emailCheckTimeout);
            const email = this.value.trim();
            
            if (email.length > 0) {
                emailCheckTimeout = setTimeout(() => {
                    checkEmailAvailability(email);
                }, 500);
            } else {
                hideAllEmailStatus();
            }
        });

        // Form submission
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            updateFullName();
            
            // Ensure account type is set
            const accountTypeField = document.getElementById('accountTypeField');
            const selectedType = document.querySelector('input[name="accountType"]:checked');
            
            if (selectedType) {
                accountTypeField.value = selectedType.value;
            }
            
            console.log('Form submission - Account Type:', accountTypeField.value);
            
            // Check passwords
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                // Show inline password error
                let errorDiv = document.getElementById('passwordError');
                if (!errorDiv) {
                    errorDiv = document.createElement('div');
                    errorDiv.id = 'passwordError';
                    errorDiv.className = 'mt-2 text-sm text-red-600';
                    errorDiv.innerHTML = '<i class="fas fa-exclamation-circle mr-1"></i>Passwords do not match!';
                    document.getElementById('password_confirmation').parentNode.appendChild(errorDiv);
                }
                errorDiv.scrollIntoView({ behavior: 'smooth' });
                return false;
            }

            if (password.length < 8) {
                e.preventDefault();
                let errorDiv = document.getElementById('passwordError');
                if (!errorDiv) {
                    errorDiv = document.createElement('div');
                    errorDiv.id = 'passwordError';
                    errorDiv.className = 'mt-2 text-sm text-red-600';
                    errorDiv.innerHTML = '<i class="fas fa-exclamation-circle mr-1"></i>Password must be at least 8 characters long!';
                    document.getElementById('password_confirmation').parentNode.appendChild(errorDiv);
                }
                errorDiv.scrollIntoView({ behavior: 'smooth' });
                return false;
            }

            // Debug form data
            const formData = new FormData(this);
            console.log('Form data:');
            for (let [key, value] of formData.entries()) {
                console.log(`${key}: ${value}`);
            }

            return true;
        });
        
        // Parallax scrolling effect for left panel
        window.addEventListener('scroll', function() {
            const parallaxContent = document.getElementById('parallaxContent');
            if (parallaxContent) {
                const scrolled = window.pageYOffset;
                const rate = scrolled * 0.3;
                parallaxContent.style.transform = `translateY(${rate}px)`;
            }
        });

        // Phone number formatting and validation
        const phoneInput = document.getElementById('phone');
        const countryCodeSelect = document.getElementById('countryCode');
        
        // Only allow numbers in phone input
        phoneInput.addEventListener('input', function(e) {
            // Remove any non-digit characters
            this.value = this.value.replace(/\D/g, '');
            
            // Limit to 15 digits
            if (this.value.length > 15) {
                this.value = this.value.slice(0, 15);
            }
        });

        // Show full phone number preview
        function updatePhonePreview() {
            const countryCode = countryCodeSelect.value;
            const phoneNumber = phoneInput.value;
            
            if (phoneNumber) {
                const fullNumber = countryCode + phoneNumber;
                phoneInput.title = `Full number: ${fullNumber}`;
            }
        }

        phoneInput.addEventListener('input', updatePhonePreview);
        countryCodeSelect.addEventListener('change', updatePhonePreview);

        // Custom Country Dropdown Functionality
        const countryCodeBtn = document.getElementById('countryCodeBtn');
        const countryDropdown = document.getElementById('countryDropdown');
        const countrySearch = document.getElementById('countrySearch');
        const countryOptions = document.querySelectorAll('.country-option');
        const selectedCountrySpan = document.getElementById('selectedCountry');
        const countryCodeInput = document.getElementById('countryCode');

        // Toggle dropdown
        countryCodeBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            countryDropdown.classList.toggle('hidden');
            if (!countryDropdown.classList.contains('hidden')) {
                countrySearch.focus();
            }
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!countryCodeBtn.contains(e.target) && !countryDropdown.contains(e.target)) {
                countryDropdown.classList.add('hidden');
            }
        });

        // Search functionality
        countrySearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            countryOptions.forEach(option => {
                const countryName = option.dataset.name.toLowerCase();
                const countryCode = option.dataset.code.toLowerCase();
                if (countryName.includes(searchTerm) || countryCode.includes(searchTerm)) {
                    option.style.display = 'flex';
                } else {
                    option.style.display = 'none';
                }
            });
        });

        // Select country
        countryOptions.forEach(option => {
            option.addEventListener('click', function() {
                const code = this.dataset.code;
                const flag = this.dataset.flag;
                const name = this.dataset.name;
                
                console.log('Selected country:', name); // Debug log
                
                // Update button display
                countryCodeBtn.querySelector('.fi').className = `fi fi-${flag} mr-2`;
                selectedCountrySpan.textContent = `${name} ${code}`;
                
                // Update hidden input
                countryCodeInput.value = code;
                
                // Populate cities based on selected country
                populateCities(name);
                
                // Close dropdown
                countryDropdown.classList.add('hidden');
                countrySearch.value = '';
                
                // Reset search
                countryOptions.forEach(opt => opt.style.display = 'flex');
            });
        });
        
        // City data by country
        const citiesByCountry = {
            'Uganda': ['Kampala', 'Entebbe', 'Jinja', 'Mbarara', 'Gulu', 'Lira', 'Mbale', 'Masaka', 'Kasese', 'Fort Portal', 'Arua', 'Soroti', 'Kabale', 'Hoima', 'Tororo', 'Mukono', 'Njeru', 'Mityana', 'Wakiso'],
            'Kenya': ['Nairobi', 'Mombasa', 'Kisumu', 'Nakuru', 'Eldoret', 'Thika', 'Malindi', 'Kitale', 'Garissa', 'Kakamega', 'Nyeri', 'Meru'],
            'Tanzania': ['Dar es Salaam', 'Dodoma', 'Mwanza', 'Arusha', 'Mbeya', 'Morogoro', 'Tanga', 'Zanzibar City', 'Kigoma', 'Moshi', 'Tabora'],
            'Rwanda': ['Kigali', 'Butare', 'Gitarama', 'Ruhengeri', 'Gisenyi', 'Byumba', 'Cyangugu', 'Kibungo', 'Kibuye', 'Gikongoro'],
            'South Sudan': ['Juba', 'Wau', 'Malakal', 'Yei', 'Yambio', 'Bor', 'Torit', 'Aweil', 'Rumbek', 'Bentiu'],
            'Nigeria': ['Lagos', 'Abuja', 'Kano', 'Ibadan', 'Port Harcourt', 'Benin City', 'Kaduna', 'Enugu', 'Jos', 'Ilorin', 'Aba', 'Onitsha'],
            'Ghana': ['Accra', 'Kumasi', 'Tamale', 'Takoradi', 'Cape Coast', 'Tema', 'Koforidua', 'Sunyani', 'Ho', 'Wa'],
            'South Africa': ['Johannesburg', 'Cape Town', 'Durban', 'Pretoria', 'Port Elizabeth', 'Bloemfontein', 'East London', 'Polokwane', 'Nelspruit', 'Kimberley'],
            'Egypt': ['Cairo', 'Alexandria', 'Giza', 'Shubra El Kheima', 'Port Said', 'Suez', 'Luxor', 'Aswan', 'Mansoura', 'Tanta'],
            'Ethiopia': ['Addis Ababa', 'Dire Dawa', 'Mekelle', 'Gondar', 'Bahir Dar', 'Hawassa', 'Jimma', 'Dessie', 'Adama', 'Harar'],
            'United Kingdom': ['London', 'Manchester', 'Birmingham', 'Leeds', 'Glasgow', 'Liverpool', 'Newcastle', 'Sheffield', 'Bristol', 'Edinburgh', 'Cardiff', 'Belfast'],
            'United States': ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix', 'Philadelphia', 'San Antonio', 'San Diego', 'Dallas', 'San Jose', 'Austin', 'Miami'],
            'Canada': ['Toronto', 'Montreal', 'Vancouver', 'Calgary', 'Edmonton', 'Ottawa', 'Winnipeg', 'Quebec City', 'Hamilton', 'Victoria'],
            'India': ['Mumbai', 'Delhi', 'Bangalore', 'Hyderabad', 'Chennai', 'Kolkata', 'Pune', 'Ahmedabad', 'Jaipur', 'Surat', 'Lucknow', 'Kanpur'],
            'China': ['Beijing', 'Shanghai', 'Guangzhou', 'Shenzhen', 'Chengdu', 'Hangzhou', 'Wuhan', 'Xian', 'Chongqing', 'Tianjin', 'Nanjing', 'Suzhou'],
            'Australia': ['Sydney', 'Melbourne', 'Brisbane', 'Perth', 'Adelaide', 'Gold Coast', 'Canberra', 'Newcastle', 'Wollongong', 'Hobart'],
            'Germany': ['Berlin', 'Hamburg', 'Munich', 'Cologne', 'Frankfurt', 'Stuttgart', 'Düsseldorf', 'Dortmund', 'Essen', 'Leipzig'],
            'France': ['Paris', 'Marseille', 'Lyon', 'Toulouse', 'Nice', 'Nantes', 'Strasbourg', 'Montpellier', 'Bordeaux', 'Lille'],
            'Italy': ['Rome', 'Milan', 'Naples', 'Turin', 'Palermo', 'Genoa', 'Bologna', 'Florence', 'Bari', 'Venice'],
            'Spain': ['Madrid', 'Barcelona', 'Valencia', 'Seville', 'Zaragoza', 'Málaga', 'Murcia', 'Palma', 'Bilbao', 'Alicante'],
            'Brazil': ['São Paulo', 'Rio de Janeiro', 'Brasília', 'Salvador', 'Fortaleza', 'Belo Horizonte', 'Manaus', 'Curitiba', 'Recife', 'Porto Alegre'],
            'Argentina': ['Buenos Aires', 'Córdoba', 'Rosario', 'Mendoza', 'La Plata', 'San Miguel de Tucumán', 'Mar del Plata', 'Salta', 'Santa Fe', 'San Juan']
        };
        
        // Function to populate cities dropdown
        function populateCities(countryName) {
            const locationSelect = document.getElementById('location');
            const cities = citiesByCountry[countryName] || [];
            
            console.log('Populating cities for:', countryName, 'Found:', cities.length, 'cities'); // Debug log
            
            // Clear existing options
            locationSelect.innerHTML = '';
            
            if (cities.length > 0) {
                // Add default option
                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'Select a city...';
                locationSelect.appendChild(defaultOption);
                
                // Add city options
                cities.forEach(city => {
                    const option = document.createElement('option');
                    option.value = city;
                    option.textContent = city;
                    locationSelect.appendChild(option);
                });
                
                // Add "Other" option
                const otherOption = document.createElement('option');
                otherOption.value = 'Other';
                otherOption.textContent = 'Other (Not listed)';
                locationSelect.appendChild(otherOption);
            } else {
                // If no cities available, show message
                const noOption = document.createElement('option');
                noOption.value = '';
                noOption.textContent = 'No cities available for this country';
                locationSelect.appendChild(noOption);
                
                // Add "Other" option so they can still enter a city
                const otherOption = document.createElement('option');
                otherOption.value = 'Other';
                otherOption.textContent = 'Enter city manually';
                locationSelect.appendChild(otherOption);
            }
        }
        
        // Initialize with empty state
        populateCities('');
        
        // Test: Populate Uganda cities on page load for debugging
        console.log('Script loaded. Testing Uganda cities...');
        console.log('Uganda cities in data:', citiesByCountry['Uganda']);
        
        // Handle "Other" selection - show custom input
        const locationSelect = document.getElementById('location');
        const customCityInput = document.getElementById('customCityInput');
        const customCityField = document.getElementById('customCity');
        const locationHint = document.getElementById('locationHint');
        
        locationSelect.addEventListener('change', function() {
            if (this.value === 'Other') {
                // Show custom input field
                customCityInput.classList.remove('hidden');
                locationHint.classList.add('hidden');
                customCityField.focus();
                
                // Make custom field required
                customCityField.setAttribute('required', 'required');
                
                // Clear the select value so custom input is used
                this.removeAttribute('name');
                customCityField.setAttribute('name', 'location');
            } else {
                // Hide custom input field
                customCityInput.classList.add('hidden');
                locationHint.classList.remove('hidden');
                
                // Remove required from custom field
                customCityField.removeAttribute('required');
                customCityField.value = '';
                
                // Restore select name
                this.setAttribute('name', 'location');
                customCityField.removeAttribute('name');
            }
        });

        // Age dropdown sparkle effect
        const ageSelect = document.getElementById('age');
        
        ageSelect.addEventListener('change', function() {
            if (this.value) {
                // Create sparkle effect
                createSparkle(this);
            }
        });
        
        function createSparkle(element) {
            const rect = element.getBoundingClientRect();
            const sparkle = document.createElement('div');
            sparkle.className = 'age-sparkle';
            sparkle.style.left = (rect.left + rect.width / 2) + 'px';
            sparkle.style.top = (rect.top + rect.height / 2) + 'px';
            document.body.appendChild(sparkle);
            
            // Remove after animation
            setTimeout(() => {
                sparkle.remove();
            }, 800);
        }
    </script>
    
    <style>
        .age-sparkle {
            position: fixed;
            width: 20px;
            height: 20px;
            pointer-events: none;
            z-index: 9999;
            animation: sparkleAnimation 0.8s ease-out forwards;
        }
        
        .age-sparkle::before,
        .age-sparkle::after {
            content: '✨';
            position: absolute;
            font-size: 16px;
            color: #3b82f6;
            filter: drop-shadow(0 0 3px rgba(59, 130, 246, 0.8));
        }
        
        .age-sparkle::before {
            animation: sparkle1 0.8s ease-out forwards;
        }
        
        .age-sparkle::after {
            animation: sparkle2 0.8s ease-out forwards;
        }
        
        @keyframes sparkleAnimation {
            0% {
                transform: scale(0) rotate(0deg);
                opacity: 1;
            }
            50% {
                transform: scale(1.2) rotate(180deg);
                opacity: 1;
            }
            100% {
                transform: scale(0.8) rotate(360deg);
                opacity: 0;
            }
        }
        
        @keyframes sparkle1 {
            0% {
                transform: translate(0, 0) scale(1);
                opacity: 1;
            }
            100% {
                transform: translate(-15px, -15px) scale(0.5);
                opacity: 0;
            }
        }
        
        @keyframes sparkle2 {
            0% {
                transform: translate(0, 0) scale(1);
                opacity: 1;
            }
            100% {
                transform: translate(15px, -15px) scale(0.5);
                opacity: 0;
            }
        }
    </style>
</body>
</html>
   