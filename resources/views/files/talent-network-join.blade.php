<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Talent Network - JOB-lyNK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .glass-background {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #60a5fa 100%);
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }
        .glass-background::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(50px, 50px) rotate(180deg); }
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        .step-indicator {
            transition: all 0.3s ease;
        }
        .step-indicator.active {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            color: white;
            transform: scale(1.1);
        }
        .step-indicator.completed {
            background: #10b981;
            color: white;
        }
        .form-section {
            display: none;
        }
        .form-section.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .skill-tag {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            border: 1px solid #3b82f6;
            transition: all 0.3s ease;
        }
        .skill-tag:hover {
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            color: white;
            transform: translateY(-2px);
        }
        .skill-tag.selected {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            color: white;
        }
        .form-container {
            max-height: 85vh;
            overflow-y: auto;
        }
        .form-container::-webkit-scrollbar {
            width: 8px;
        }
        .form-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .form-container::-webkit-scrollbar-thumb {
            background: #3b82f6;
            border-radius: 10px;
        }
    </style>
</head>
<body class="glass-background">
    <div class="min-h-screen flex items-center justify-center p-4 relative z-10 py-6">
        <div class="glass-card rounded-2xl p-6 md:p-8 max-w-3xl w-full">
            <!-- Header -->
            <div class="text-center mb-6">
                <div class="flex justify-center mb-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl flex items-center justify-center shadow-lg">
                        <img src="{{ asset('job-lynk-logo.png') }}" alt="JOB-lyNK Logo" class="w-10 h-10 object-contain">
                    </div>
                </div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-1">Join Our Talent Network</h1>
                <p class="text-sm text-gray-600">Complete your profile in 4 easy steps</p>
            </div>

            <!-- Progress Steps -->
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center space-x-2">
                    <div class="step-indicator active w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm" data-step="1">1</div>
                    <span class="text-xs font-medium text-gray-700 hidden sm:inline">Personal</span>
                </div>
                <div class="flex-1 h-1 bg-gray-300 mx-2"></div>
                <div class="flex items-center space-x-2">
                    <div class="step-indicator w-8 h-8 rounded-full flex items-center justify-center font-bold bg-gray-300 text-sm" data-step="2">2</div>
                    <span class="text-xs font-medium text-gray-700 hidden sm:inline">Skills</span>
                </div>
                <div class="flex-1 h-1 bg-gray-300 mx-2"></div>
                <div class="flex items-center space-x-2">
                    <div class="step-indicator w-8 h-8 rounded-full flex items-center justify-center font-bold bg-gray-300 text-sm" data-step="3">3</div>
                    <span class="text-xs font-medium text-gray-700 hidden sm:inline">Experience</span>
                </div>
                <div class="flex-1 h-1 bg-gray-300 mx-2"></div>
                <div class="flex items-center space-x-2">
                    <div class="step-indicator w-8 h-8 rounded-full flex items-center justify-center font-bold bg-gray-300 text-sm" data-step="4">4</div>
                    <span class="text-xs font-medium text-gray-700 hidden sm:inline">Preferences</span>
                </div>
            </div>

            <!-- Form Container with Scroll -->
            <div class="form-container">
                <form id="talentNetworkForm" method="POST" action="{{ route('talent-network.register') }}">
                    @csrf
                    <input type="hidden" name="account_type" value="worker">

                    <!-- Step 1: Personal Information -->
                    <div class="form-section active" data-section="1">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Personal Information</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Full Name *</label>
                                <input type="text" name="name" required class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Email Address *</label>
                                <input type="email" name="email" required class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Phone Number *</label>
                                <input type="tel" name="phone" required class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Gender *</label>
                                <select name="gender" required class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Country *</label>
                                <select name="country" id="country" required class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                    <option value="">Select Country</option>
                                    <option value="Uganda">Uganda</option>
                                    <option value="Kenya">Kenya</option>
                                    <option value="Tanzania">Tanzania</option>
                                    <option value="Rwanda">Rwanda</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">City *</label>
                                <select name="location" id="city" required class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                    <option value="">Select City</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Password *</label>
                                <input type="password" name="password" required autocomplete="new-password" class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Confirm Password *</label>
                                <input type="password" name="password_confirmation" required autocomplete="new-password" class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="button" onclick="nextStep()" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-2 rounded-lg font-semibold hover:from-blue-700 hover:to-blue-800 transition text-sm">
                                Next <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Skills -->
                    <div class="form-section" data-section="2">
                        <h2 class="text-xl font-bold text-gray-900 mb-3">Your Skills</h2>
                        <p class="text-xs text-gray-600 mb-4">Select all skills that apply to you</p>

                        <div id="skillsContainer" class="grid grid-cols-2 md:grid-cols-3 gap-2 mb-4">
                            <!-- Skills will be populated here -->
                        </div>

                        <div class="mb-4">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Add Custom Skill</label>
                            <div class="flex gap-2">
                                <input type="text" id="customSkill" placeholder="Enter skill name" class="flex-1 px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <button type="button" onclick="addCustomSkill()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <input type="hidden" name="skills" id="selectedSkills">

                        <div class="flex justify-between mt-6">
                            <button type="button" onclick="prevStep()" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-semibold hover:bg-gray-400 transition text-sm">
                                <i class="fas fa-arrow-left mr-2"></i> Back
                            </button>
                            <button type="button" onclick="nextStep()" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-2 rounded-lg font-semibold hover:from-blue-700 hover:to-blue-800 transition text-sm">
                                Next <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 3: Experience -->
                    <div class="form-section" data-section="3">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Work Experience</h2>
                        
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Years of Experience *</label>
                                <select name="experience_years" required class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                    <option value="">Select Experience</option>
                                    <option value="0-1">Less than 1 year</option>
                                    <option value="1-3">1-3 years</option>
                                    <option value="3-5">3-5 years</option>
                                    <option value="5-10">5-10 years</option>
                                    <option value="10+">10+ years</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Education Level *</label>
                                <select name="education_level" required class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                    <option value="">Select Education Level</option>
                                    <option value="primary">Primary</option>
                                    <option value="secondary">Secondary (O-Level)</option>
                                    <option value="advanced">Advanced (A-Level)</option>
                                    <option value="certificate">Certificate</option>
                                    <option value="diploma">Diploma</option>
                                    <option value="degree">Bachelor's Degree</option>
                                    <option value="masters">Master's Degree</option>
                                    <option value="phd">PhD</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Brief Work History</label>
                                <textarea name="work_history" rows="3" placeholder="Tell us about your previous work experience..." class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"></textarea>
                            </div>
                        </div>

                        <div class="flex justify-between mt-6">
                            <button type="button" onclick="prevStep()" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-semibold hover:bg-gray-400 transition text-sm">
                                <i class="fas fa-arrow-left mr-2"></i> Back
                            </button>
                            <button type="button" onclick="nextStep()" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-2 rounded-lg font-semibold hover:from-blue-700 hover:to-blue-800 transition text-sm">
                                Next <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 4: Job Preferences -->
                    <div class="form-section" data-section="4">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Job Preferences</h2>
                        
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Availability Status *</label>
                                <select name="availability" required class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                    <option value="">Select Availability</option>
                                    <option value="immediately">Available Immediately</option>
                                    <option value="2weeks">Available in 2 weeks</option>
                                    <option value="1month">Available in 1 month</option>
                                    <option value="not_looking">Not actively looking</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Expected Wage Range (UGX per month)</label>
                                <div class="grid grid-cols-2 gap-3">
                              :ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
g-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-2">Preferred Job Type *</label>
                                <div class="space-y-2">
                                    <label class="flex items-center space-x-2 p-2 rounded-lg border border-gray-300 hover:bg-blue-50 cursor-pointer">
                                        <input type="checkbox" name="job_types[]" value="full-time" class="w-4 h-4 text-blue-600">
                                        <span class="text-sm">Full-time</span>
                                    </label>
                                    <label class="flex items-center space-x-2 p-2 rounded-lg border border-gray-300 hover:bg-blue-50 cursor-pointer">
                                        <input type="checkbox" name="job_types[]" value="part-time" class="w-4 h-4 text-blue-600">
                                        <span class="text-sm">Part-time</span>
                                    </label>
                                    <lab p-2 rounded-lg border border-gray-300 hover:bg-blue-50 cursor-pointer">
                                        <input type="checkbox" name="job_types[]" value="contract" class="w-4 h-4 text-blue-600">
                                        <span class="text-sm">Contract</span>
                                    </label>
                                    <label class="flex items-center space-x-2 p-2 rounded-lg border border-gray-300 hover:bg-blue-50 cursor-pointer">
                                    <input type="checkbox" name="job_types[]" value="casual" class="w-4 h-4 text-blue-600">
                                        <span class="text-sm">Casual/Daily</span>
                                    </label>
                                </div>
                            </div>

                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                <label class="flex items-start space-x-2 cursor-pointer">
                              type="checkbox" name="terms_accepted" required class="w-4 h-4 text-blue-600 mt-0.5">
                          -600 hover:underline">Terms of Service</a> and <a href="#" class="text-blue-600 hover:underline">Privacy Policy</a></span>
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-between mt-6">
                            <button type="button" onclick="prevStep()" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-semibold hover:bg-gray-400 transition text-sm">
                                <i class="fas fa-arrow-left mr-2"></i> Back
                            </button>
                            <button type="submit" class="bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-2 rounded-lg font-semibold hover:from-green-700 hover:to-green-800 transition text-sm">
                      lete
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Already have account -->
            <div class="text-center mt-6 pt-4 border-t border-gray-200">
ss="text-blue-600 hover:underline font-semibold">Sign In</a></p>
            </div>
        </div>
    </div>

    <script>
        let currentStep = 1;
        const totalSteps = 4;
        const selectedSkills = new Set();

        // Popular skills
        const popularSkills = [
            'Carpentry', 'Plumbing', 'Electrical Work', 'Masonry', 'Painting',
            'Cleaning', 'Cooking', 'Delivery', 'Security', 'Gardening',
            'Welding', 'Tailoring', 'Hair Styling', 'Mechanic', 'Driver',
            'Construction', 'Roofing', 'Tiling', 'Bricklaying', 'Plastering'
        ];

        // Cities by country
        const citiesByCountry = {
            'Uganda': ['Kampala', 'Entebbe', 'Jinja', 'Mbarara', 'Gulu', 'Lira', 'Mbale', 'Masaka', 'Kasese', 'Fort Portal', 'Arua', 'Soroti', 'Kabale', 'Hoima', 'Tororo', 'Mukono', 'Njeru', 'Mityana', 'Wakiso'],
            'Kenya': ['Nairobi', 'Mombasa', 'Kisumu', 'Nakuru', 'Eldoret'],
            'Tanzania': ['Dar es Salaam', 'Mwanza', 'Arusha', 'Dodoma', 'Mbeya'],
            'Rwanda': ['Kigali', 'Butare', 'Gitarama', 'Ruhengeri', 'Gisenyi']
        };

        // Initialize skills
        function initializeSkills() {
            const container = document.getElementById('skillsContainer');
            popularSkills.forEach(skill => {
                const tag = document.createElement('div');
                tag.className = 'skill-tag px-3 py-2 rounded-lg cursor-pointer text-center font-medium text-sm';
                tag.textContent = skill;
=> toggleSkill(skill, tag);
                container.appendChild(tag);
            });
        }

        // Toggle skill selection
        function toggleSkill(skill, element) {
            if (selectedSkills.has(skill)) {
                selectedSkills.delete(skill);
                element.classList.remove('selected');
            } else {
                selectedSkills.add(skill);
                element.classList.add('selected');
            }
            updateSelectedSkillsInput();
        }

        // Add custom skill
        function addCustomSkill() {
            const input = document.getElementById('customSkill');
            const skill = input.value.trim();
            
            if (skill && !selectedSkills.has(skill)) {
                const container = document.getElementById('skillsContainer');
                const tag = document.createElement('div');
                tag.className = 'skill-tag selected px-3 py-2 rounded-lg cursor-pointer text-center font-medium text-sm';
                tag.textContent = skill;
                tag.onclick = () => toggleSkill(skill, tag);
                container.appendChild(tag);
                
                selectedSkills.add(skill);
                updateSelectedSkillsInput();
                input.value = '';
            }
        }

        // Update hidden input with selected skills
        function updateSelectedSkillsInput() {
            document.getElementById('selectedSkills').value = Array.from(selectedSkills).join(',');
        }

        // Country change handler
        document.getElementById('country').addEventListener('change', function() {
            const country = this.value;
            const citySelect = document.getElementById('city');
            citySelect.innerHTML = '<option value="">Select City</option>';
            
            if (citiesByCountry[country]) {
                citiesByCountry[country].forEach(city => {
                    const option = document.createElement('option');
                    option.value = city;
                    option.textContent = city;
                    citySelect.appendChild(option);
                });
            }
        });

        // Navigation functions
        function nextStep() {
            if (validateStep(currentStep)) {
                document.querySelector(`[data-section="${currentStep}"]`).classList.remove('active');
                document.querySelector(`[data-step="${currentStep}"]`).classList.remove('active');
                document.querySelector(`[data-step="${currentStep}"]`).classList.add('completed');
                
                currentStep++;
                
                document.querySelector(`[data-section="${currentStep}"]`).classList.add('active');
                document.querySelector(`[data-step="${currentStep}"]`).classList.add('active');
                
                document.querySelector('.form-container').scrollTop = 0;
            }
        }

        function prevStep() {
            ('active');
            document.querySelector(`[data-step="${currentStep}"]`).classList.remove('active');
            
            currentStep--;
            
            document.querySelector(`[data-section="${currentStep}"]`).classList.add('active');
            document.querySelector(`[data-step="${currentStep}"]`).classList.add('active');
            document.querySelector(`[data-step="${currentStep}"]`).classList.remove('completed');
            
            document.querySelector('.crollTop = 0;
        }

        // Validation
        function validateStep(step) {
            const section = document.querySelector(`[data-section="${step}"]`);
            const requiredFields = section.querySelectorAll('[required]');
            
            for (let field of requiredFields) {
                if (!field.value.trim()) {
                    field.focus();
                    alert('Please fill in all required fields');
                    return false;
                }
            }
            
            if (step === 2 && selectedSkills.size === 0) {
                alert('Please select at least one skill');
                return false;
            }
            
            return true;
        }

        // Initialize on load
        document.addEventListener('DOMContentLoaded', function() {
            initializeSkills();
        });
    </script>
</body>
</html>
