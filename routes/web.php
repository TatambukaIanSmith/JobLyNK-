<?php

use Livewire\Volt\Volt;
use Laravel\Fortify\Features;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\homeController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\postController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\paymentController;
use App\Http\Controllers\postjobController;
use App\Http\Controllers\messagesController;
use App\Http\Controllers\registerController;
use App\Http\Controllers\settingsController;
use App\Http\Controllers\JoblistingsController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\applicationFormController;
use App\Http\Controllers\workerdashboardController;
use App\Http\Controllers\employerDashboardController;

Route::get('/', function () {
    return redirect()->route('home');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', 'role.redirect'])
    ->name('dashboard');

Route::get('/home', [homeController::class, 'home'])->name('home');

// Static pages
Route::view('/how-it-works', 'files.how-it-works')->name('how-it-works');
Route::view('/pricing', 'files.pricing')->name('pricing');
Route::view('/about', 'files.about')->name('about');
Route::view('/help-center', 'files.help-center')->name('help-center');
Route::view('/enterprise-solutions', 'files.enterprise-solutions')->name('enterprise-solutions');
Route::view('/talent-network', 'files.talent-network')->name('talent-network');
Route::get('/talent-network/join', function() {
    return view('files.talent-network-join');
})->name('talent-network.join');
Route::post('/talent-network/register', [registerController::class, 'talentNetworkRegister'])->name('talent-network.register');
Route::view('/careers', 'files.careers')->name('careers');
Route::view('/blog', 'files.blog')->name('blog');
Route::view('/press-media-kit', 'files.press-media-kit')->name('press-media-kit');
Route::view('/tutorials', 'files.tutorials')->name('tutorials');

Route::get('/jobs', [JobsController::class, 'jobs'])->name('jobs');
Route::get('/jobs/search', [JobsController::class, 'search'])->name('jobs.search');
Route::get('/jobs/{job}', [JobsController::class, 'show'])->name('jobs.show');
Route::post('/jobs/{job}/apply', [JobsController::class, 'apply'])->name('jobs.apply')->middleware('auth');
Route::post('/jobs/{job}/bookmark', [JobsController::class, 'bookmark'])->name('jobs.bookmark')->middleware('auth');
Route::get('/api/jobs/suggestions', [JobsController::class, 'suggestions'])->name('jobs.suggestions');

// Admin Authentication Routes (Hidden from regular users)
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin login routes
    Route::get('/login', [App\Http\Controllers\AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\AdminAuthController::class, 'login'])->name('login.submit');
    
    // Protected admin routes
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('/backup-database', [AdminController::class, 'backupDatabase'])->name('backup.database');
        Route::get('/backups', [AdminController::class, 'listBackups'])->name('backups.list');
        Route::get('/backups/download/{filename}', [AdminController::class, 'downloadBackup'])->name('backups.download');
        Route::delete('/backups/{filename}', [AdminController::class, 'deleteBackup'])->name('backups.delete');
        Route::post('/logout', [App\Http\Controllers\AdminAuthController::class, 'logout'])->name('logout');
        
        // Analytics and Statistics
        Route::get('/analytics', [AdminController::class, 'getAnalytics'])->name('analytics');
        Route::get('/analytics/export', [AdminController::class, 'exportAnalytics'])->name('analytics.export');
        Route::get('/stats', [AdminController::class, 'getStats'])->name('stats');
        Route::get('/activity-logs', [AdminController::class, 'getActivityLogs'])->name('activity.logs');
        
        // Reports
        Route::post('/reports/monthly', [AdminController::class, 'generateMonthlyReport'])->name('reports.monthly');
        Route::get('/reports/download/{filename}', [AdminController::class, 'downloadReport'])->name('download.report');
        
        // User Management
        Route::get('/users', [AdminController::class, 'getUsers'])->name('users.index');
        Route::get('/users/{user}', [AdminController::class, 'getUserDetails'])->name('users.show');
        Route::post('/users/{user}/suspend', [AdminController::class, 'suspendUser'])->name('users.suspend');
        Route::post('/users/{user}/unsuspend', [AdminController::class, 'unsuspendUser'])->name('users.unsuspend');
        Route::post('/users/bulk-action', [AdminController::class, 'bulkUserAction'])->name('users.bulk');
        
        // Job Management
        Route::get('/jobs', [AdminController::class, 'getJobs'])->name('jobs.index');
        Route::post('/jobs/{job}/approve', [AdminController::class, 'approveJob'])->name('jobs.approve');
        Route::post('/jobs/{job}/reject', [AdminController::class, 'rejectJob'])->name('jobs.reject');
        Route::post('/jobs/bulk-approve', [AdminController::class, 'bulkApproveJobs'])->name('jobs.bulk.approve');
        Route::post('/jobs/bulk-reject', [AdminController::class, 'bulkRejectJobs'])->name('jobs.bulk.reject');
        
        // System Management
        Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
        Route::post('/system/maintenance', [AdminController::class, 'systemMaintenance'])->name('system.maintenance');
        Route::post('/maintenance/toggle', [AdminController::class, 'toggleMaintenance'])->name('maintenance.toggle');
        
        // Admin Messaging
        Route::get('/messages/conversations', [AdminController::class, 'getAdminConversations'])->name('messages.conversations');
        Route::get('/messages/stats', [AdminController::class, 'getMessageStats'])->name('messages.stats');
        Route::get('/messages/unread-count', [AdminController::class, 'getUnreadCount'])->name('messages.unread-count');
        Route::post('/messages/broadcast', [AdminController::class, 'sendBroadcastMessage'])->name('messages.broadcast');
    });
});

// Test route for debugging
Route::get('/test-employer', function() {
    return view('files.employerDashboard', [
        'jobs' => collect(),
        'stats' => [
            'total_jobs' => 0,
            'active_jobs' => 0,
            'draft_jobs' => 0,
            'pending_payment_jobs' => 0,
            'total_applications' => 0,
            'total_views' => 0,
            'jobs_this_month' => 0,
        ],
        'paymentStats' => [
            'total_spent' => 0,
            'pending_payments' => 0,
            'total_transactions' => 0,
            'recent_payments' => collect(),
        ],
        'monthlyJobTrends' => collect(),
        'applicationTrends' => collect(),
        'recentApplications' => collect(),
    ]);
})->name('test.employer');

Route::get('/employerDashboard', [employerDashboardController::class, 'employers'])
    ->middleware(['auth', 'role.employer', 'no-cache'])
    ->name('employerDashboard');

Route::get('/employer/my-jobs', [employerDashboardController::class, 'myJobs'])
    ->middleware(['auth', 'role.employer'])
    ->name('employer.myJobs');

// Employer Dashboard API Routes
Route::middleware(['auth', 'role.employer', 'no-cache'])->group(function () {
    Route::get('/employer/analytics', [employerDashboardController::class, 'getAnalytics'])->name('employer.analytics');
    Route::post('/employer/clear-cache', [employerDashboardController::class, 'clearCache'])->name('employer.clear-cache');
    Route::post('/employer/revoke-tokens', [employerDashboardController::class, 'revokeAllTokens'])->name('employer.revoke-tokens');
    Route::post('/employer/revoke-sessions', [employerDashboardController::class, 'revokeOtherSessions'])->name('employer.revoke-sessions');
    Route::post('/employer/security-logout', [employerDashboardController::class, 'securityLogout'])->name('employer.security-logout');
});
    
// Worker Dashboard Routes
Route::middleware(['auth', 'role.worker'])->group(function () {
    Route::get('/worker', [workerdashboardController::class, 'worker'])->name('worker');
    Route::get('/worker/skills', [workerdashboardController::class, 'worker'])->name('worker.skills');
    Route::get('/worker/applications', [workerdashboardController::class, 'worker'])->name('worker.applications');
    Route::get('/worker/notifications', [workerdashboardController::class, 'worker'])->name('worker.notifications');
    Route::get('/worker/workplace', [workerdashboardController::class, 'worker'])->name('worker.workplace');
    Route::get('/worker/messages', [workerdashboardController::class, 'worker'])->name('worker.messages');
    Route::get('/worker/saved', [workerdashboardController::class, 'worker'])->name('worker.saved');
});

Route::get('/applicationForm', [applicationFormController::class, 'applicationForm'])->name('applicationForm');
Route::get('/postjob', [postjobController::class, 'postjob'])
    ->middleware(['auth', 'role.employer'])
    ->name('postjob');
    
Route::post('/postjob', [postjobController::class, 'store'])
    ->middleware(['auth', 'role.employer'])
    ->name('postjob.store');

// Application management routes for employers
Route::middleware(['auth', 'role.employer'])->group(function () {
    // Job management routes
    Route::post('/employer/dashboard/create-job', [employerDashboardController::class, 'storeJob'])->name('employer.jobs.store');
    Route::get('/employer/jobs/{job}', [employerDashboardController::class, 'getJob'])->name('employer.jobs.show');
    Route::get('/employer/jobs/{job}/edit', [employerDashboardController::class, 'editJob'])->name('employer.jobs.edit');
    Route::put('/employer/jobs/{job}', [employerDashboardController::class, 'updateJob'])->name('employer.jobs.update');
    Route::get('/employer/jobs/{job}/details', [employerDashboardController::class, 'getJobDetails'])->name('employer.jobs.details');
    Route::get('/employer/jobs/{job}/skill-matches', [employerDashboardController::class, 'getJobSkillMatches'])->name('employer.jobs.skill-matches');
    Route::get('/employer/jobs/{job}/analytics', [employerDashboardController::class, 'getJobAnalytics'])->name('employer.jobs.analytics');
    Route::post('/employer/jobs/{job}/duplicate', [employerDashboardController::class, 'duplicateJob'])->name('employer.jobs.duplicate');
    Route::get('/employer/jobs', [employerDashboardController::class, 'getJobs'])->name('employer.jobs.index');
    Route::post('/employer/jobs/{job}/publish', [employerDashboardController::class, 'publishJob'])->name('employer.jobs.publish');
    Route::post('/employer/jobs/{job}/pause', [employerDashboardController::class, 'pauseJob'])->name('employer.jobs.pause');
    Route::post('/employer/jobs/{job}/activate', [employerDashboardController::class, 'activateJob'])->name('employer.jobs.activate');
    Route::delete('/employer/jobs/{job}', [employerDashboardController::class, 'deleteJob'])->name('employer.jobs.delete');
    
    // Debug route to test job creation
    Route::post('/employer/jobs/debug', function(Request $request) {
        \Illuminate\Support\Facades\Log::info('Debug route hit', [
            'all_data' => $request->all(),
            'has_skills' => $request->has('skills'),
            'skills_value' => $request->get('skills'),
            'skills_type' => gettype($request->get('skills'))
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Debug route working',
            'data' => $request->all()
        ]);
    })->name('employer.jobs.debug');
    
    // Application management routes
    Route::get('/employer/applications', [employerDashboardController::class, 'getApplications'])->name('employer.applications');
    Route::post('/employer/applications/{application}/approve', [employerDashboardController::class, 'approveApplication'])->name('employer.applications.approve');
    Route::post('/employer/applications/{application}/reject', [employerDashboardController::class, 'rejectApplication'])->name('employer.applications.reject');
    Route::get('/employer/applications/{application}', [employerDashboardController::class, 'showApplication'])->name('employer.applications.show');
    
    // Employer messaging routes
    Route::get('/employer/messages', [employerDashboardController::class, 'getMessages'])->name('employer.messages');
    Route::post('/employer/messages/send', [employerDashboardController::class, 'sendMessage'])->name('employer.messages.send');
    Route::get('/employer/messages/conversation/{userId}', [employerDashboardController::class, 'getConversation'])->name('employer.messages.conversation');
    Route::get('/employer/messages/unread-count', [employerDashboardController::class, 'getUnreadCount'])->name('employer.messages.unread-count');
    Route::post('/employer/messages/conversation/{userId}/read', [employerDashboardController::class, 'markConversationAsRead'])->name('employer.messages.read');
    
    // Employer profile & settings routes
    Route::get('/employer/profile', [employerDashboardController::class, 'getProfile'])->name('employer.profile');
    Route::post('/employer/profile/update', [employerDashboardController::class, 'updateProfile'])->name('employer.profile.update');
    Route::post('/employer/profile/password', [employerDashboardController::class, 'updatePassword'])->name('employer.profile.password');
    Route::get('/employer/sessions', [employerDashboardController::class, 'getSessions'])->name('employer.sessions');
    Route::post('/employer/sessions/revoke', [employerDashboardController::class, 'revokeOtherSessions'])->name('employer.sessions.revoke');
    Route::get('/employer/tokens', [employerDashboardController::class, 'getTokens'])->name('employer.tokens');
    Route::post('/employer/tokens/revoke', [employerDashboardController::class, 'revokeAllTokens'])->name('employer.tokens.revoke');
    
    // Employer settings page
    Route::get('/employer/settings', function() {
        return view('files.employerSettings');
    })->name('employer.settings');
    
    // AI Agent routes for employers
    Route::get('/employer/ai-agent/insights', [App\Http\Controllers\EmployerAIAgentController::class, 'getInsights'])->name('employer.ai.insights');
    Route::get('/employer/ai-agent/widget', [App\Http\Controllers\EmployerAIAgentController::class, 'getWidget'])->name('employer.ai.widget');
    Route::get('/employer/ai-agent/recommendations', [App\Http\Controllers\EmployerAIAgentController::class, 'getRecommendations'])->name('employer.ai.recommendations');
    Route::post('/employer/ai-agent/chat', [App\Http\Controllers\EmployerAIAgentController::class, 'chat'])->name('employer.ai.chat');
    
    // Dashboard Features Routes
    Route::get('/employer/activity-feed', [employerDashboardController::class, 'getActivityFeed'])->name('employer.activity.feed');
    Route::post('/employer/notes', [employerDashboardController::class, 'saveNote'])->name('employer.notes.save');
    Route::get('/employer/notes', [employerDashboardController::class, 'getNotes'])->name('employer.notes.index');
    Route::delete('/employer/notes/{note}', [employerDashboardController::class, 'deleteNote'])->name('employer.notes.delete');
    Route::post('/employer/candidates/update-stage', [employerDashboardController::class, 'updateCandidateStage'])->name('employer.candidates.stage');
    
    // Screening Management Routes
    Route::post('/employer/candidates/move-to-screening', [employerDashboardController::class, 'moveToScreening'])->name('employer.candidates.screening');
    Route::get('/employer/candidates/screening', [employerDashboardController::class, 'getScreeningCandidates'])->name('employer.candidates.screening.list');
    
    Route::post('/employer/interviews/schedule', [employerDashboardController::class, 'scheduleInterview'])->name('employer.interviews.schedule');
    Route::get('/employer/interviews', [employerDashboardController::class, 'getInterviews'])->name('employer.interviews.index');
    Route::put('/employer/interviews/{interview}', [employerDashboardController::class, 'updateInterview'])->name('employer.interviews.update');
    Route::delete('/employer/interviews/{interview}', [employerDashboardController::class, 'deleteInterview'])->name('employer.interviews.delete');
    
    // New Interview Management Routes
    Route::get('/employer/candidates/available', [employerDashboardController::class, 'getAvailableCandidates'])->name('employer.candidates.available');
    Route::get('/employer/jobs/active', [employerDashboardController::class, 'getActiveJobs'])->name('employer.jobs.active');
    Route::get('/employer/interviews/today', [employerDashboardController::class, 'getTodaysInterviews'])->name('employer.interviews.today');
    Route::post('/employer/interviews/check-conflicts', [employerDashboardController::class, 'checkInterviewConflicts'])->name('employer.interviews.conflicts');
    Route::post('/employer/interviews/{interview}/notify', [employerDashboardController::class, 'sendInterviewNotification'])->name('employer.interviews.notify');
    Route::put('/employer/interviews/{interview}/reschedule', [employerDashboardController::class, 'rescheduleInterview'])->name('employer.interviews.reschedule');
});

// Admin messaging routes
Route::middleware(['auth', 'role.admin'])->group(function () {
    Route::post('/admin/messages/send', [AdminController::class, 'sendMessage'])->name('admin.messages.send');
    Route::get('/admin/messages', [AdminController::class, 'getMessages'])->name('admin.messages');
    Route::get('/admin/messages/conversation/{userId}', [AdminController::class, 'getConversation'])->name('admin.messages.conversation');
    Route::get('/admin/messages/employers', [AdminController::class, 'getEmployers'])->name('admin.messages.employers');
    Route::get('/admin/messages/workers', [AdminController::class, 'getWorkers'])->name('admin.messages.workers');
    Route::get('/admin/messages/search-users', [AdminController::class, 'searchUsers'])->name('admin.messages.search-users');
    Route::post('/admin/messages/conversation/{userId}/read', [AdminController::class, 'markConversationAsRead'])->name('admin.messages.read');
    Route::delete('/admin/messages/delete/{messageId}', [AdminController::class, 'deleteMessage'])->name('admin.messages.delete');
    Route::get('/admin/messages/stats', [AdminController::class, 'getMessageStats'])->name('admin.messages.stats');
    Route::get('/admin/messages/conversations', [AdminController::class, 'getAdminConversations'])->name('admin.messages.conversations');
    Route::get('/admin/messages/count-recipients', [AdminController::class, 'countBroadcastRecipients'])->name('admin.messages.count');
    Route::post('/admin/messages/broadcast', [AdminController::class, 'sendBroadcastMessage'])->name('admin.messages.broadcast');
    
    // Admin system logs routes
    Route::get('/admin/system-logs', [AdminController::class, 'getSystemLogs'])->name('admin.system.logs');
    Route::post('/admin/system-logs/clear', [AdminController::class, 'clearSystemLogs'])->name('admin.system.logs.clear');
    
    // Admin system optimization routes
    Route::post('/admin/system/optimize', [AdminController::class, 'optimizeSystem'])->name('admin.system.optimize');
    Route::post('/admin/system/clear-cache', [AdminController::class, 'clearCache'])->name('admin.system.clear-cache');
    
    // Admin system reports routes
    Route::get('/admin/reports', [AdminController::class, 'viewReports'])->name('admin.reports');
    Route::get('/admin/reports/{id}', [AdminController::class, 'getReportData'])->name('admin.reports.show');
    Route::post('/admin/reports/generate', [AdminController::class, 'generateReportManually'])->name('admin.reports.generate');
    Route::get('/admin/reports/{id}/pdf', [AdminController::class, 'viewReportPDF'])->name('admin.reports.pdf');
    Route::get('/admin/reports/{id}/download', [AdminController::class, 'downloadReportPDF'])->name('admin.reports.download');
    
    // Admin profile pictures route
    Route::get('/admin/profile-pictures/{filename}', function($filename) {
        $path = storage_path('app/public/profile_pictures/' . $filename);
        if (!file_exists($path)) {
            // Return a default avatar SVG if file doesn't exist
            return response()->file(public_path('default-avatar.svg'));
        }
        return response()->file($path);
    })->name('admin.profile.picture');
    
    // Admin AI feedback routes
    Route::get('/admin/ai-feedback/employers', [App\Http\Controllers\AdminAIFeedbackController::class, 'getEmployerFeedback'])->name('admin.ai.feedback');
    Route::get('/admin/ai-feedback/employer/{employerId}', [App\Http\Controllers\AdminAIFeedbackController::class, 'getSpecificEmployerFeedback'])->name('admin.ai.employer');
    Route::get('/admin/ai-feedback/activity-logs', [App\Http\Controllers\AdminAIFeedbackController::class, 'getAIActivityLogs'])->name('admin.ai.logs');
    
    // Test route for AI agent (remove in production)
    Route::get('/test-ai-agent', function() {
        if (Auth::check() && Auth::user()->role === 'employer') {
            $aiService = app(\App\Services\EmployerAIAgentService::class);
            $insights = $aiService->generateInsights(Auth::user());
            return response()->json(['success' => true, 'insights' => $insights]);
        }
        return response()->json(['error' => 'Must be logged in as employer'], 403);
    });
});
Route::get('/post', [postController::class, 'post'])->name('post');;
Route::get('/contact', [ContactController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.submit');
Route::get('/payment',[paymentController::class, 'payment'])->name('payment');

// Payment processing routes
Route::prefix('payment')->name('payment.')->group(function () {
    Route::post('/process', [paymentController::class, 'processPayment'])->name('process');
    Route::post('/callback', [paymentController::class, 'paymentCallback'])->name('callback');
    
    // These routes require authentication
    Route::middleware(['auth'])->group(function () {
        Route::get('/status/{transactionId}', [paymentController::class, 'getPaymentStatus'])->name('status');
        Route::get('/history', [paymentController::class, 'getPaymentHistory'])->name('history');
    });
});

// Admin payment routes
Route::middleware(['auth', 'admin'])->prefix('admin/payments')->name('admin.payments.')->group(function () {
    Route::get('/', [paymentController::class, 'adminGetPayments'])->name('index');
});
Route::get('/joblistings',[JoblistingsController::class, 'joblistings'])->name('joblistings');
Route::get('messages',[messagesController::class, 'messages'])->name('messages')->middleware('auth');

// Messaging API routes
Route::middleware(['auth'])->prefix('api/messages')->name('messages.')->group(function () {
    Route::get('/conversations/{userId}', [messagesController::class, 'getConversation'])->name('conversation');
    Route::post('/send', [messagesController::class, 'sendMessage'])->name('send');
    Route::get('/users', [messagesController::class, 'getAvailableUsers'])->name('users');
    Route::get('/search-users', [messagesController::class, 'searchUsers'])->name('search.users');
    Route::get('/unread-count', [messagesController::class, 'getUnreadCount'])->name('unread.count');
    Route::post('/mark-read/{userId}', [messagesController::class, 'markConversationAsRead'])->name('mark.read');
    Route::delete('/delete/{messageId}', [messagesController::class, 'deleteMessage'])->name('delete');
});

// API endpoint for checking approval notifications
Route::middleware(['auth'])->get('/api/check-approval-notifications', function() {
    $notifications = App\Models\JobNotification::where('user_id', Auth::id())
        ->where('type', 'application_approved')
        ->where('is_read', false)
        ->with('job.employer')
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function($notification) {
            return [
                'id' => $notification->id,
                'job_title' => $notification->job->title,
                'employer_name' => $notification->job->employer->name,
                'created_at' => $notification->created_at->diffForHumans()
            ];
        });
    
    return response()->json($notifications);
})->name('check.approval.notifications');

Route::middleware(['auth'])->post('/api/mark-approval-read/{notificationId}', function($notificationId) {
    $notification = App\Models\JobNotification::where('id', $notificationId)
        ->where('user_id', Auth::id())
        ->first();
    
    if ($notification) {
        $notification->markAsRead();
        return response()->json(['success' => true]);
    }
    
    return response()->json(['success' => false], 404);
})->name('mark.approval.read');

// Login Routes with 2FA
Route::get('/login',[loginController::class, 'login'])->name('login');
Route::post('/login',[loginController::class, 'store'])->name('login.store');
Route::get('/two-factor-challenge',[loginController::class, 'showTwoFactorChallenge'])->name('two-factor.login');
Route::post('/two-factor-verify',[loginController::class, 'verifyTwoFactor'])->name('two-factor.verify');

Route::get('/register',[registerController::class, 'register'])->name('register');
Route::post('/register',[registerController::class, 'store'])->name('register.store');
Route::get('/settings',[settingsController::class, 'settings'])->name('settings');
Route::middleware(['auth'])->group(function () {
    Route::get('/two-factor-setup', [settingsController::class, 'showTwoFactorSetup'])->name('two-factor.setup');
    Route::post('/two-factor-setup/confirm', [settingsController::class, 'confirmTwoFactorSetup'])->name('two-factor.setup.confirm');
    Route::post('/two-factor-disable', [settingsController::class, 'disableTwoFactor'])->name('two-factor.disable');
});
Route::get('/PasswordReset',[PasswordResetController::class, 'PasswordReset'])->name('PasswordReset');

// Legal Pages
Route::get('/terms-of-service', function () {
    return view('legal.terms-of-service');
})->name('terms-of-service');

Route::get('/privacy-policy', function () {
    return view('legal.privacy-policy');
})->name('privacy-policy');

// API routes for user checking
Route::prefix('api')->group(function () {
    Route::post('/check-email', [App\Http\Controllers\Api\UserCheckController::class, 'checkEmail'])->name('api.check-email');
    Route::post('/check-phone', [App\Http\Controllers\Api\UserCheckController::class, 'checkPhone'])->name('api.check-phone');
    
    // Skills API routes
    Route::get('/skills', [App\Http\Controllers\Api\SkillsController::class, 'index']);
    Route::post('/skills', [App\Http\Controllers\Api\SkillsController::class, 'store']);
    Route::get('/skills/search', [App\Http\Controllers\Api\SkillsController::class, 'search']);
    Route::get('/skills/categories', [App\Http\Controllers\Api\SkillsController::class, 'skillCategories']);
    Route::get('/skills/category/{category}', [App\Http\Controllers\Api\SkillsController::class, 'byCategory']);
    Route::get('/job-categories', [App\Http\Controllers\Api\SkillsController::class, 'jobCategories']);
    
    // User skills and preferences (requires authentication)
    Route::middleware('auth')->group(function () {
        Route::get('/user/skills', [App\Http\Controllers\Api\UserSkillsController::class, 'getUserSkills']);
        Route::post('/user/skills', [App\Http\Controllers\Api\UserSkillsController::class, 'updateUserSkills']);
        Route::get('/user/preferences', [App\Http\Controllers\Api\UserSkillsController::class, 'getUserPreferences']);
        Route::post('/user/preferences', [App\Http\Controllers\Api\UserSkillsController::class, 'updateUserPreferences']);
        Route::get('/user/job-notifications', [App\Http\Controllers\Api\UserSkillsController::class, 'getUserJobNotifications']);
        Route::post('/user/notifications/read', [App\Http\Controllers\Api\UserSkillsController::class, 'markNotificationsAsRead']);
        Route::get('/user/matching-jobs', [App\Http\Controllers\Api\UserSkillsController::class, 'getMatchingJobs']);
        
        // Notification management routes
        Route::post('/notifications/mark-read', [App\Http\Controllers\Api\UserSkillsController::class, 'markNotificationsAsRead']);
        Route::post('/notifications/mark-all-read', [App\Http\Controllers\Api\UserSkillsController::class, 'markAllNotificationsAsRead']);
        
        // Employer notifications
        Route::get('/employer/worker-notifications', [App\Http\Controllers\Api\UserSkillsController::class, 'getEmployerWorkerNotifications']);
        
        // Worker profile endpoints for employers
        Route::get('/worker/{workerId}/profile', [App\Http\Controllers\Api\UserSkillsController::class, 'getWorkerProfile']);
        Route::get('/worker/{workerId}/skills', [App\Http\Controllers\Api\UserSkillsController::class, 'getWorkerSkills']);
        Route::get('/worker/{workerId}/contact', [App\Http\Controllers\Api\UserSkillsController::class, 'getWorkerContact']);
    });
});

// Social Authentication Routes
Route::prefix('auth')->group(function () {
    // Google OAuth
    Route::get('/google', [App\Http\Controllers\SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/google/callback', [App\Http\Controllers\SocialAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
    
    // Facebook OAuth
    Route::get('/facebook', [App\Http\Controllers\SocialAuthController::class, 'redirectToFacebook'])->name('auth.facebook');
    Route::get('/facebook/callback', [App\Http\Controllers\SocialAuthController::class, 'handleFacebookCallback'])->name('auth.facebook.callback');
});

// Messages routes (accessible to all authenticated users including admin)
Route::middleware(['auth'])->group(function () {
    Route::get('/messages/conversation/{userId}', [messagesController::class, 'getConversation'])->name('messages.conversation');
    Route::post('/messages/send', [messagesController::class, 'sendMessage'])->name('messages.send');
    Route::get('/messages/unread-count', [messagesController::class, 'getUnreadCount'])->name('messages.unread-count');
    Route::post('/messages/conversation/{userId}/read', [messagesController::class, 'markConversationAsRead'])->name('messages.read');
});

// Profile update routes
Route::middleware(['auth'])->group(function () {
    Route::match(['PUT', 'PATCH'], '/profile/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/picture/update', [App\Http\Controllers\ProfileController::class, 'updateProfilePicture'])->name('profile.picture.update');
    Route::post('/profile/skills/add', [App\Http\Controllers\ProfileController::class, 'addSkill'])->name('profile.skills.add');
    Route::delete('/profile/skills/remove', [App\Http\Controllers\ProfileController::class, 'removeSkill'])->name('profile.skills.remove');
    Route::post('/profile/certificate/upload', [App\Http\Controllers\ProfileController::class, 'uploadCertificate'])->name('profile.certificate.upload');
    Route::delete('/profile/certificate/delete', [App\Http\Controllers\ProfileController::class, 'deleteCertificate'])->name('profile.certificate.delete');
    Route::get('/profile/saved-jobs', [App\Http\Controllers\ProfileController::class, 'getSavedJobs'])->name('profile.saved-jobs');
    Route::delete('/profile/unsave-job', [App\Http\Controllers\ProfileController::class, 'unsaveJob'])->name('profile.unsave-job');
    Route::get('/profile/my-applications', [App\Http\Controllers\ProfileController::class, 'getMyApplications'])->name('profile.my-applications');
    
    // Handle password reset with PUT method (for settings page)
    Route::put('/reset-password', function(Illuminate\Http\Request $request) {
        // Redirect to the correct Fortify password update route
        return redirect()->route('password.update')->with($request->all());
    })->name('password.reset.put');
});

// Debug logout route (remove in production)
Route::get('/debug/logout', function() {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login')->with('message', 'Logged out successfully');
})->name('debug.logout');

// Location-based job matching routes
use App\Http\Controllers\LocationJobController;

// Nearby Jobs Page
Route::get('/nearby-jobs', function() {
    return view('files.nearby-jobs');
})->middleware(['auth'])->name('nearby-jobs');

Route::middleware(['auth'])->group(function () {
    // Worker location routes
    Route::get('/api/location/nearby-jobs', [LocationJobController::class, 'getNearbyJobs'])->name('location.nearby-jobs');
    Route::post('/api/location/update-worker', [LocationJobController::class, 'updateWorkerLocation'])->name('location.update-worker');
    Route::get('/api/location/job-radar', [LocationJobController::class, 'getJobRadar'])->name('location.job-radar');
    Route::post('/api/location/calculate-distance', [LocationJobController::class, 'calculateDistance'])->name('location.calculate-distance');
    
    // Worker availability zone routes
    Route::get('/api/availability-zone', [LocationJobController::class, 'getAvailabilityZone'])->name('availability-zone.get');
    Route::post('/api/availability-zone', [LocationJobController::class, 'updateAvailabilityZone'])->name('availability-zone.update');
    
    // Employer location routes
    Route::post('/api/location/update-job/{jobId}', [LocationJobController::class, 'updateJobLocation'])->name('location.update-job');
});
