<!-- Modern AI Assistant Widget -->
<div class="fixed bottom-6 right-6 z-50">
    <!-- Floating AI Assistant Button -->
    <div id="aiAssistantButton" 
         class="w-16 h-16 bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 rounded-full shadow-2xl cursor-pointer transform transition-all duration-300 hover:scale-110 hover:shadow-3xl flex items-center justify-center group"
         onclick="toggleAIAssistant()">
        
        <!-- AI Icon with Animation -->
        <div class="relative">
            <i class="fas fa-robot text-white text-2xl transition-transform duration-300 group-hover:rotate-12"></i>
            
            <!-- Pulse Animation -->
            <div class="absolute inset-0 rounded-full bg-gradient-to-br from-blue-400 to-purple-400 opacity-75 animate-ping"></div>
            
            <!-- Status Indicator -->
            <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-400 rounded-full border-2 border-white animate-pulse"></div>
        </div>
        
        <!-- Notification Badge -->
        @if(count($insights['alerts']) > 0)
            <div class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 rounded-full flex items-center justify-center text-white text-xs font-bold animate-bounce">
                {{ count($insights['alerts']) }}
            </div>
        @endif
    </div>

    <!-- Glassmorphism AI Assistant Panel -->
    <div id="aiAssistantPanel" 
         class="fixed top-4 bottom-4 right-6 w-[450px] transform translate-y-4 opacity-0 pointer-events-none transition-all duration-500 ease-out z-40">
        
        <!-- Glass Container -->
        <div class="backdrop-blur-xl bg-gray-900/80 border border-gray-600/30 rounded-3xl shadow-2xl overflow-hidden flex flex-col h-full">
            
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-500/30 to-purple-500/30 p-3 border-b border-gray-600/20 flex-shrink-0">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-robot text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-white font-bold text-lg">AI Assistant</h3>
                            <p class="text-gray-300 text-sm">Your hiring companion</p>
                        </div>
                    </div>
                    <button onclick="toggleAIAssistant()" class="text-gray-400 hover:text-white transition-colors p-1">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
            </div>

            <!-- Content Container -->
            <div class="flex-1 flex flex-col overflow-hidden min-h-0">
                <!-- Tab Navigation -->
                <div class="flex space-x-1 m-3 mb-2 bg-gray-800/50 rounded-2xl p-1 flex-shrink-0">
                    <button onclick="switchTab('insights')" 
                            class="ai-tab flex-1 py-2 px-4 rounded-xl text-sm font-medium transition-all duration-300 text-gray-400 hover:text-white active"
                            data-tab="insights">
                        <i class="fas fa-chart-line mr-2"></i>Insights
                    </button>
                    <button onclick="switchTab('chat')" 
                            class="ai-tab flex-1 py-2 px-4 rounded-xl text-sm font-medium transition-all duration-300 text-gray-400 hover:text-white"
                            data-tab="chat">
                        <i class="fas fa-comments mr-2"></i>Chat
                    </button>
                </div>

                <!-- Tab Content Container -->
                <div class="flex-1 overflow-hidden px-3 pb-3 min-h-0">

                <!-- Insights Tab Content -->
                <div id="insightsTab" class="tab-content flex-1 overflow-y-auto custom-scrollbar-dark pr-1 min-h-0 relative">
                    <!-- Scroll Navigation Buttons -->
                    <div class="absolute top-2 right-2 z-10 flex flex-col space-y-1">
                        <button onclick="scrollInsightsTo('top')" 
                                class="w-8 h-8 bg-blue-600/80 hover:bg-blue-600 text-white rounded-full flex items-center justify-center transition-all duration-200 shadow-lg backdrop-blur-sm"
                                title="Scroll to top">
                            <i class="fas fa-chevron-up text-xs"></i>
                        </button>
                        <button onclick="scrollInsightsTo('recommendations')" 
                                class="w-8 h-8 bg-green-600/80 hover:bg-green-600 text-white rounded-full flex items-center justify-center transition-all duration-200 shadow-lg backdrop-blur-sm"
                                title="Scroll to recommendations">
                            <i class="fas fa-lightbulb text-xs"></i>
                        </button>
                        <button onclick="scrollInsightsTo('performance')" 
                                class="w-8 h-8 bg-purple-600/80 hover:bg-purple-600 text-white rounded-full flex items-center justify-center transition-all duration-200 shadow-lg backdrop-blur-sm"
                                title="Scroll to performance">
                            <i class="fas fa-chart-bar text-xs"></i>
                        </button>
                        <button onclick="scrollInsightsTo('bottom')" 
                                class="w-8 h-8 bg-orange-600/80 hover:bg-orange-600 text-white rounded-full flex items-center justify-center transition-all duration-200 shadow-lg backdrop-blur-sm"
                                title="Scroll to bottom">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                    </div>

                    <!-- AI Greeting -->
                    <div id="insights-top" class="bg-white/5 backdrop-blur-sm rounded-2xl p-3 mb-3 border border-white/10">
                        <p class="text-white/90 text-sm leading-relaxed">{{ $insights['greeting'] }}</p>
                    </div>

                    <!-- Quick Stats -->
                    <div class="grid grid-cols-2 gap-2 mb-3">
                        <div class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 backdrop-blur-sm rounded-2xl p-3 border border-white/10">
                            <div class="text-xl font-bold text-white">{{ $insights['job_performance']['total_applications'] }}</div>
                            <div class="text-white/70 text-xs">Applications</div>
                        </div>
                        <div class="bg-gradient-to-br from-purple-500/20 to-purple-600/20 backdrop-blur-sm rounded-2xl p-3 border border-white/10">
                            <div class="text-xl font-bold text-white">{{ $insights['job_performance']['total_views'] }}</div>
                            <div class="text-white/70 text-xs">Job Views</div>
                        </div>
                    </div>

                    <!-- Alerts -->
                    @if(count($insights['alerts']) > 0)
                        <div class="mb-3">
                            <h4 class="text-white font-semibold mb-2 flex items-center text-sm">
                                <i class="fas fa-bell text-yellow-400 mr-2"></i>
                                Live Alerts
                            </h4>
                            <div class="space-y-2">
                                @foreach(array_slice($insights['alerts'], 0, 2) as $alert)
                                    <div class="bg-{{ $alert['priority'] === 'high' ? 'red' : 'yellow' }}-500/20 backdrop-blur-sm rounded-xl p-2 border border-white/10">
                                        <p class="text-white font-medium text-xs">{{ $alert['message'] }}</p>
                                        <p class="text-white/70 text-xs mt-1">💡 {{ $alert['action'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- AI Recommendations -->
                    @if(count($insights['recommendations']) > 0)
                        <div id="insights-recommendations" class="mb-3">
                            <h4 class="text-white font-semibold mb-2 flex items-center text-sm">
                                <i class="fas fa-lightbulb text-yellow-400 mr-2"></i>
                                AI Recommendations
                                <span class="ml-2 px-2 py-0.5 bg-green-600/30 text-green-200 text-xs rounded-full">{{ count($insights['recommendations']) }}</span>
                            </h4>
                            <div class="space-y-2">
                                @foreach($insights['recommendations'] as $index => $rec)
                                    <div class="bg-green-500/20 backdrop-blur-sm rounded-xl p-3 border border-white/10 {{ $index === 0 ? 'ring-2 ring-green-400/30' : '' }}">
                                        <p class="text-white font-medium text-sm leading-relaxed mb-2">{{ $rec['title'] }}</p>
                                        <p class="text-white/90 text-sm leading-relaxed mb-3">{{ $rec['message'] }}</p>
                                        <span class="inline-block px-2 py-1 bg-{{ $rec['priority'] === 'high' ? 'red' : 'blue' }}-600/40 text-white text-xs rounded-full border border-{{ $rec['priority'] === 'high' ? 'red' : 'blue' }}-500/50">
                                            {{ ucfirst($rec['priority']) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Troubleshooting Tips -->
                    @if(count($insights['troubleshooting']) > 0)
                        <div class="mb-3">
                            <h4 class="text-white font-semibold mb-2 flex items-center text-sm">
                                <i class="fas fa-tools text-orange-400 mr-2"></i>
                                Troubleshooting Tips
                                <span class="ml-2 px-2 py-0.5 bg-orange-600/30 text-orange-200 text-xs rounded-full">{{ count($insights['troubleshooting']) }}</span>
                            </h4>
                            <div class="space-y-2">
                                @foreach($insights['troubleshooting'] as $tip)
                                    <div class="bg-orange-500/20 backdrop-blur-sm rounded-xl p-2.5 border border-white/10">
                                        <p class="text-orange-100 font-medium text-xs leading-tight">🔧 {{ $tip['issue'] }}</p>
                                        <p class="text-orange-200 text-xs mt-1 leading-tight">{{ $tip['solution'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Performance Score -->
                    <div id="insights-performance" class="bg-white/5 backdrop-blur-sm rounded-2xl p-2.5 border border-white/10 mb-3">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-white/80 text-xs">Performance Score</span>
                            <span class="text-white font-bold text-xs">{{ $insights['admin_feedback']['performance_score'] }}/100</span>
                        </div>
                        <div class="w-full bg-white/10 rounded-full h-2">
                            <div class="bg-gradient-to-r from-blue-400 to-green-400 h-2 rounded-full transition-all duration-1000" 
                                 style="width: {{ $insights['admin_feedback']['performance_score'] }}%"></div>
                        </div>
                    </div>

                    <!-- Job Performance Details -->
                    <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-2.5 border border-white/10 mb-3">
                        <h4 class="text-white font-semibold mb-2 flex items-center text-xs">
                            <i class="fas fa-chart-bar text-blue-400 mr-2"></i>
                            Performance Details
                        </h4>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div class="text-gray-300">
                                <span class="block text-xs">Active Jobs:</span>
                                <span class="text-white font-medium">{{ $insights['job_performance']['active_jobs'] }}</span>
                            </div>
                            <div class="text-gray-300">
                                <span class="block text-xs">Avg Applications:</span>
                                <span class="text-white font-medium">{{ $insights['job_performance']['avg_applications_per_job'] }}</span>
                            </div>
                            <div class="text-gray-300">
                                <span class="block text-xs">Engagement:</span>
                                <span class="px-1 py-0.5 text-xs rounded bg-{{ $insights['admin_feedback']['engagement_level'] === 'High' ? 'green' : ($insights['admin_feedback']['engagement_level'] === 'Medium' ? 'yellow' : 'red') }}-600/30 text-white border border-{{ $insights['admin_feedback']['engagement_level'] === 'High' ? 'green' : ($insights['admin_feedback']['engagement_level'] === 'Medium' ? 'yellow' : 'red') }}-500/30">
                                    {{ $insights['admin_feedback']['engagement_level'] }}
                                </span>
                            </div>
                            <div class="text-gray-300">
                                <span class="block text-xs">Response Rate:</span>
                                <span class="text-white font-medium">{{ $insights['admin_feedback']['success_metrics']['response_rate'] }}%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Insights -->
                    <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-2.5 border border-white/10 mb-3">
                        <h4 class="text-white font-semibold mb-2 flex items-center text-xs">
                            <i class="fas fa-info-circle text-purple-400 mr-2"></i>
                            Additional Insights
                        </h4>
                        <div class="space-y-2 text-xs">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-300">Total Jobs Posted:</span>
                                <span class="text-white font-medium">{{ $insights['job_performance']['total_jobs'] }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-300">Job Completion Rate:</span>
                                <span class="text-white font-medium">{{ $insights['admin_feedback']['success_metrics']['job_completion_rate'] }}%</span>
                            </div>
                            @if($insights['job_performance']['top_performing_job'])
                                <div class="bg-blue-500/20 rounded-lg p-2 mt-2">
                                    <p class="text-blue-100 font-medium text-xs">🏆 Top Performing Job</p>
                                    <p class="text-blue-200 text-xs">{{ $insights['job_performance']['top_performing_job']['title'] }}</p>
                                    <p class="text-blue-300 text-xs">{{ $insights['job_performance']['top_performing_job']['views'] }} views • {{ $insights['job_performance']['top_performing_job']['applications'] }} applications</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Summary Message -->
                    <div id="insights-bottom" class="bg-gradient-to-r from-blue-500/20 to-purple-500/20 backdrop-blur-sm rounded-2xl p-2.5 border border-white/10 mb-2">
                        <h4 class="text-white font-semibold mb-1 flex items-center text-xs">
                            <i class="fas fa-star text-yellow-400 mr-2"></i>
                            AI Summary
                        </h4>
                        <p class="text-white/90 text-xs leading-tight">{{ $insights['summary'] }}</p>
                    </div>
                </div>

                <!-- Chat Tab Content -->
                <div id="chatTab" class="tab-content hidden h-full flex flex-col">
                    <!-- Chat Messages -->
                    <div id="chatMessages" class="flex-1 overflow-y-auto custom-scrollbar-dark mb-4 space-y-4 p-2 min-h-0">
                        <!-- Welcome Message -->
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-robot text-white text-sm"></i>
                            </div>
                            <div class="bg-gray-800/90 backdrop-blur-sm rounded-2xl rounded-tl-sm p-4 border border-gray-600/50 max-w-xs shadow-lg">
                                <p class="text-white text-sm leading-relaxed">{{ $insights['summary'] }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Chat Input -->
                    <div class="flex space-x-2 flex-shrink-0">
                        <input type="text" 
                               id="chatInput" 
                               placeholder="Ask me anything about your hiring..." 
                               class="flex-1 bg-gray-800/50 backdrop-blur-sm border border-gray-600/50 rounded-2xl px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-blue-400 focus:bg-gray-800/70 transition-all"
                               onkeypress="handleChatKeyPress(event)">
                        <button onclick="sendChatMessage()" 
                                class="bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white p-3 rounded-2xl transition-all duration-300 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 10px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.5);
    }
    
    .custom-scrollbar-dark::-webkit-scrollbar {
        width: 6px;
    }
    
    .custom-scrollbar-dark::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 10px;
    }
    
    .custom-scrollbar-dark::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
    }
    
    .custom-scrollbar-dark::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.4);
    }
    
    .ai-tab.active {
        background: rgba(59, 130, 246, 0.3);
        color: white;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    
    #aiAssistantButton {
        animation: float 3s ease-in-out infinite;
    }
    
    /* Chat message animations */
    .chat-message {
        animation: slideInMessage 0.3s ease-out;
    }
    
    @keyframes slideInMessage {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        #aiAssistantPanel {
            width: calc(100vw - 1rem);
            right: 0.5rem;
            left: 0.5rem;
            top: 1rem;
            bottom: 1rem;
        }
    }
    
    @media (max-height: 700px) {
        #aiAssistantPanel {
            top: 0.5rem;
            bottom: 0.5rem;
        }
    }
    
    @media (max-height: 600px) {
        #aiAssistantPanel {
            top: 0.25rem;
            bottom: 0.25rem;
        }
    }
</style>

<!-- JavaScript for AI Assistant -->
<script>
let isAIAssistantOpen = false;

function toggleAIAssistant() {
    const button = document.getElementById('aiAssistantButton');
    const panel = document.getElementById('aiAssistantPanel');
    
    if (!isAIAssistantOpen) {
        // Open panel
        panel.classList.remove('translate-y-4', 'opacity-0', 'pointer-events-none');
        panel.classList.add('translate-y-0', 'opacity-100', 'pointer-events-auto');
        button.style.animation = 'none';
        isAIAssistantOpen = true;
    } else {
        // Close panel
        panel.classList.add('translate-y-4', 'opacity-0', 'pointer-events-none');
        panel.classList.remove('translate-y-0', 'opacity-100', 'pointer-events-auto');
        button.style.animation = 'float 3s ease-in-out infinite';
        isAIAssistantOpen = false;
    }
}

function switchTab(tabName) {
    // Update tab buttons
    document.querySelectorAll('.ai-tab').forEach(tab => {
        tab.classList.remove('active');
    });
    document.querySelector(`[data-tab="${tabName}"]`).classList.add('active');
    
    // Update tab content
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    document.getElementById(tabName + 'Tab').classList.remove('hidden');
}

function sendChatMessage() {
    const input = document.getElementById('chatInput');
    const message = input.value.trim();
    
    if (!message) return;
    
    // Add user message to chat immediately
    addChatMessage(message, 'user');
    input.value = '';
    
    // Show typing indicator
    showTypingIndicator();
    
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        console.error('CSRF token not found');
        hideTypingIndicator();
        addChatMessage('Sorry, there was a security issue. Please refresh the page and try again.', 'ai');
        return;
    }
    
    // Send message to AI backend
    fetch('/employer/ai-agent/chat', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({ message: message })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        hideTypingIndicator();
        if (data.success && data.response) {
            // Add AI response to chat
            setTimeout(() => {
                addChatMessage(data.response, 'ai');
            }, 500); // Small delay for natural feel
        } else {
            console.error('API response error:', data);
            addChatMessage('Sorry, I encountered an error processing your request. Please try again.', 'ai');
        }
    })
    .catch(error => {
        hideTypingIndicator();
        console.error('Chat error:', error);
        addChatMessage('I apologize, but I\'m having trouble connecting right now. Please try again in a moment.', 'ai');
    });
}

function showTypingIndicator() {
    const chatMessages = document.getElementById('chatMessages');
    const typingDiv = document.createElement('div');
    typingDiv.id = 'typingIndicator';
    typingDiv.className = 'chat-message';
    typingDiv.innerHTML = `
        <div class="flex items-start space-x-3 mb-4">
            <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-robot text-white text-sm"></i>
            </div>
            <div class="bg-gray-800/90 backdrop-blur-sm rounded-2xl rounded-tl-sm p-4 border border-gray-600/50 shadow-lg">
                <div class="flex space-x-1">
                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                </div>
            </div>
        </div>
    `;
    chatMessages.appendChild(typingDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

function hideTypingIndicator() {
    const typingIndicator = document.getElementById('typingIndicator');
    if (typingIndicator) {
        typingIndicator.remove();
    }
}

function addChatMessage(message, sender) {
    const chatMessages = document.getElementById('chatMessages');
    const messageDiv = document.createElement('div');
    messageDiv.className = 'chat-message';
    
    if (sender === 'user') {
        messageDiv.innerHTML = `
            <div class="flex items-start space-x-3 justify-end mb-4">
                <div class="bg-blue-600/90 backdrop-blur-sm rounded-2xl rounded-tr-sm p-4 border border-blue-500/30 max-w-xs shadow-lg">
                    <p class="text-white text-sm leading-relaxed break-words">${message}</p>
                </div>
                <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-user text-white text-sm"></i>
                </div>
            </div>
        `;
    } else {
        messageDiv.innerHTML = `
            <div class="flex items-start space-x-3 mb-4">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-robot text-white text-sm"></i>
                </div>
                <div class="bg-gray-800/90 backdrop-blur-sm rounded-2xl rounded-tl-sm p-4 border border-gray-600/50 max-w-xs shadow-lg">
                    <p class="text-white text-sm leading-relaxed break-words">${message}</p>
                </div>
            </div>
        `;
    }
    
    chatMessages.appendChild(messageDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

function handleChatKeyPress(event) {
    if (event.key === 'Enter') {
        sendChatMessage();
    }
}

// Initialize with insights tab active
document.addEventListener('DOMContentLoaded', function() {
    switchTab('insights');
});

// Scroll navigation function for insights
function scrollInsightsTo(section) {
    const insightsTab = document.getElementById('insightsTab');
    let targetElement;
    
    switch(section) {
        case 'top':
            targetElement = document.getElementById('insights-top');
            break;
        case 'recommendations':
            targetElement = document.getElementById('insights-recommendations');
            break;
        case 'performance':
            targetElement = document.getElementById('insights-performance');
            break;
        case 'bottom':
            targetElement = document.getElementById('insights-bottom');
            break;
        default:
            targetElement = document.getElementById('insights-top');
    }
    
    if (targetElement && insightsTab) {
        // Calculate the position relative to the scrollable container
        const containerRect = insightsTab.getBoundingClientRect();
        const targetRect = targetElement.getBoundingClientRect();
        const scrollTop = insightsTab.scrollTop;
        const targetPosition = targetRect.top - containerRect.top + scrollTop - 10; // 10px offset
        
        // Smooth scroll to target
        insightsTab.scrollTo({
            top: targetPosition,
            behavior: 'smooth'
        });
        
        // Add temporary highlight effect
        targetElement.style.transition = 'all 0.3s ease';
        targetElement.style.transform = 'scale(1.02)';
        targetElement.style.boxShadow = '0 0 20px rgba(59, 130, 246, 0.3)';
        
        setTimeout(() => {
            targetElement.style.transform = 'scale(1)';
            targetElement.style.boxShadow = 'none';
        }, 600);
    }
}

// Initialize with insights tab active
document.addEventListener('DOMContentLoaded', function() {
    switchTab('insights');
});

// Auto-refresh insights every 5 minutes
setInterval(() => {
    if (isAIAssistantOpen) {
        fetch('/employer/ai-agent/insights')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('AI insights updated');
                    // Could update the UI here with new data
                }
            })
            .catch(error => console.error('Auto-refresh error:', error));
    }
}, 300000); // 5 minutes
</script>