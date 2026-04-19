<div class="bg-gray-800 p-6 rounded-xl shadow-xl">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center mr-4">
                <i class="fas fa-brain text-white text-xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-white">AI Agent Insights</h3>
                <p class="text-gray-400 text-sm">Employer performance monitoring</p>
            </div>
        </div>
        <button onclick="refreshAIFeedback()" class="bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded-lg text-sm transition">
            <i class="fas fa-sync-alt mr-2"></i>
            Refresh
        </button>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6" id="aiSummaryCards">
        <div class="bg-blue-900 bg-opacity-50 p-4 rounded-lg text-center">
            <div class="text-2xl font-bold text-blue-400" id="totalEmployers">-</div>
            <div class="text-blue-200 text-sm">Total Employers</div>
        </div>
        <div class="bg-green-900 bg-opacity-50 p-4 rounded-lg text-center">
            <div class="text-2xl font-bold text-green-400" id="highPerformers">-</div>
            <div class="text-green-200 text-sm">High Performers</div>
        </div>
        <div class="bg-red-900 bg-opacity-50 p-4 rounded-lg text-center">
            <div class="text-2xl font-bold text-red-400" id="needsSupport">-</div>
            <div class="text-red-200 text-sm">Needs Support</div>
        </div>
        <div class="bg-purple-900 bg-opacity-50 p-4 rounded-lg text-center">
            <div class="text-2xl font-bold text-purple-400" id="avgScore">-</div>
            <div class="text-purple-200 text-sm">Avg Score</div>
        </div>
    </div>

    <!-- Employer List -->
    <div class="bg-gray-700 rounded-lg overflow-hidden">
        <div class="p-4 bg-gray-600 border-b border-gray-500">
            <h4 class="text-white font-semibold flex items-center">
                <i class="fas fa-users mr-2"></i>
                Employer Performance Overview
            </h4>
        </div>
        <div class="max-h-96 overflow-y-auto" id="employerFeedbackList">
            <div class="p-8 text-center text-gray-400">
                <i class="fas fa-spinner fa-spin text-2xl mb-2"></i>
                <p>Loading AI feedback data...</p>
            </div>
        </div>
    </div>

    <!-- Detailed Modal -->
    <div id="employerDetailModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center">
        <div class="bg-gray-800 rounded-xl shadow-2xl w-full max-w-4xl mx-4 max-h-[90vh] overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-blue-600 p-6 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white" id="modalEmployerName">Employer Details</h2>
                    <p class="text-blue-100">Comprehensive AI analysis</p>
                </div>
                <button onclick="closeEmployerDetailModal()" class="text-white hover:text-gray-300 text-2xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]" id="modalContent">
                <!-- Content will be loaded dynamically -->
            </div>
        </div>
    </div>
</div>

<script>
// Load AI feedback data on page load
document.addEventListener('DOMContentLoaded', function() {
    loadAIFeedback();
});

function loadAIFeedback() {
    fetch('/admin/ai-feedback/employers')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateSummaryCards(data.summary);
                updateEmployerList(data.employer_feedback);
            }
        })
        .catch(error => {
            console.error('Error loading AI feedback:', error);
            document.getElementById('employerFeedbackList').innerHTML = 
                '<div class="p-8 text-center text-red-400"><i class="fas fa-exclamation-triangle text-2xl mb-2"></i><p>Error loading data</p></div>';
        });
}

function updateSummaryCards(summary) {
    document.getElementById('totalEmployers').textContent = summary.total_employers;
    document.getElementById('highPerformers').textContent = summary.high_performers;
    document.getElementById('needsSupport').textContent = summary.needs_support;
    document.getElementById('avgScore').textContent = summary.average_performance_score + '%';
}

function updateEmployerList(employers) {
    const container = document.getElementById('employerFeedbackList');
    
    if (employers.length === 0) {
        container.innerHTML = '<div class="p-8 text-center text-gray-400"><p>No employer data available</p></div>';
        return;
    }

    const employerHTML = employers.map(employer => `
        <div class="p-4 border-b border-gray-600 hover:bg-gray-600 transition cursor-pointer" 
             onclick="showEmployerDetails(${employer.employer_id})">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <h5 class="text-white font-medium">${employer.employer_name}</h5>
                    <div class="flex items-center space-x-4 mt-2 text-sm">
                        <span class="text-gray-300">
                            <i class="fas fa-briefcase mr-1"></i>
                            ${employer.success_metrics.jobs_posted} jobs
                        </span>
                        <span class="text-gray-300">
                            <i class="fas fa-users mr-1"></i>
                            ${employer.success_metrics.applications_received} applications
                        </span>
                        <span class="text-gray-300">
                            <i class="fas fa-percentage mr-1"></i>
                            ${employer.success_metrics.response_rate}% response rate
                        </span>
                    </div>
                </div>
                <div class="text-right">
                    <div class="flex items-center space-x-3">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full ${getEngagementColor(employer.engagement_level)}">
                            ${employer.engagement_level}
                        </span>
                        <div class="text-right">
                            <div class="text-lg font-bold text-white">${employer.performance_score}/100</div>
                            <div class="w-16 bg-gray-600 rounded-full h-2">
                                <div class="bg-gradient-to-r from-blue-400 to-green-400 h-2 rounded-full" 
                                     style="width: ${employer.performance_score}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            ${employer.areas_for_improvement.length > 0 ? `
                <div class="mt-3 p-2 bg-yellow-900 bg-opacity-30 rounded text-xs">
                    <i class="fas fa-exclamation-triangle text-yellow-400 mr-1"></i>
                    <span class="text-yellow-200">Areas for improvement: ${employer.areas_for_improvement.join(', ')}</span>
                </div>
            ` : ''}
        </div>
    `).join('');

    container.innerHTML = employerHTML;
}

function getEngagementColor(level) {
    switch(level) {
        case 'High': return 'bg-green-600 text-green-100';
        case 'Medium': return 'bg-yellow-600 text-yellow-100';
        case 'Low': return 'bg-red-600 text-red-100';
        default: return 'bg-gray-600 text-gray-100';
    }
}

function showEmployerDetails(employerId) {
    fetch(`/admin/ai-feedback/employer/${employerId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('modalEmployerName').textContent = data.employer_feedback.employer_name;
                document.getElementById('modalContent').innerHTML = generateDetailedView(data.full_insights);
                document.getElementById('employerDetailModal').classList.remove('hidden');
            }
        })
        .catch(error => {
            console.error('Error loading employer details:', error);
        });
}

function generateDetailedView(insights) {
    return `
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Performance Metrics -->
            <div class="bg-gray-700 p-4 rounded-lg">
                <h4 class="text-white font-semibold mb-3">Performance Metrics</h4>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-300">Active Jobs</span>
                        <span class="text-white font-medium">${insights.job_performance.active_jobs}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-300">Total Views</span>
                        <span class="text-white font-medium">${insights.job_performance.total_views}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-300">Total Applications</span>
                        <span class="text-white font-medium">${insights.job_performance.total_applications}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-300">Avg Applications/Job</span>
                        <span class="text-white font-medium">${insights.job_performance.avg_applications_per_job}</span>
                    </div>
                </div>
            </div>

            <!-- Current Alerts -->
            <div class="bg-gray-700 p-4 rounded-lg">
                <h4 class="text-white font-semibold mb-3">Current Alerts (${insights.alerts.length})</h4>
                <div class="space-y-2 max-h-48 overflow-y-auto">
                    ${insights.alerts.map(alert => `
                        <div class="bg-${alert.priority === 'high' ? 'red' : 'yellow'}-900 bg-opacity-50 p-2 rounded text-xs">
                            <p class="text-white font-medium">${alert.message}</p>
                        </div>
                    `).join('')}
                    ${insights.alerts.length === 0 ? '<p class="text-gray-400 text-sm">No active alerts</p>' : ''}
                </div>
            </div>

            <!-- AI Recommendations -->
            <div class="bg-gray-700 p-4 rounded-lg">
                <h4 class="text-white font-semibold mb-3">AI Recommendations (${insights.recommendations.length})</h4>
                <div class="space-y-2 max-h-48 overflow-y-auto">
                    ${insights.recommendations.map(rec => `
                        <div class="bg-blue-900 bg-opacity-30 p-2 rounded text-xs">
                            <p class="text-blue-100 font-medium">${rec.title}</p>
                            <p class="text-blue-200 text-xs mt-1">${rec.message}</p>
                        </div>
                    `).join('')}
                </div>
            </div>

            <!-- Admin Notes -->
            <div class="bg-gray-700 p-4 rounded-lg">
                <h4 class="text-white font-semibold mb-3">Admin Assessment</h4>
                <div class="space-y-3">
                    <div class="bg-purple-900 bg-opacity-30 p-3 rounded">
                        <p class="text-purple-100 text-sm">${insights.admin_feedback.admin_notes}</p>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-300">Performance Score</span>
                        <span class="text-white font-bold">${insights.admin_feedback.performance_score}/100</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-300">Engagement Level</span>
                        <span class="px-2 py-1 text-xs rounded ${getEngagementColor(insights.admin_feedback.engagement_level)}">${insights.admin_feedback.engagement_level}</span>
                    </div>
                </div>
            </div>
        </div>
    `;
}

function closeEmployerDetailModal() {
    document.getElementById('employerDetailModal').classList.add('hidden');
}

function refreshAIFeedback() {
    const button = event.target;
    const originalContent = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Refreshing...';
    button.disabled = true;

    loadAIFeedback();

    setTimeout(() => {
        button.innerHTML = originalContent;
        button.disabled = false;
    }, 2000);
}
</script>