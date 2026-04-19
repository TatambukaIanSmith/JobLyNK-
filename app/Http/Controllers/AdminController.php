<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Job;
use App\Models\Category;
use App\Models\Application;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
        // Get comprehensive statistics
        $stats = [
            'total_users' => User::count(),
            'total_workers' => User::where('role', 'worker')->count(),
            'total_employers' => User::where('role', 'employer')->count(),
            'total_jobs' => Job::count(),
            'active_jobs' => Job::where('status', 'active')->count(),
            'pending_jobs' => Job::where('status', 'draft')->count(),
            'completed_jobs' => Job::where('status', 'completed')->count(),
            'cancelled_jobs' => Job::where('status', 'cancelled')->count(),
            'total_applications' => Application::count(),
            'pending_applications' => Application::where('status', 'pending')->count(),
            'accepted_applications' => Application::where('status', 'accepted')->count(),
            'rejected_applications' => Application::where('status', 'rejected')->count(),
            'new_users_today' => User::whereDate('created_at', today())->count(),
            'new_jobs_today' => Job::whereDate('created_at', today())->count(),
            'urgent_jobs' => Job::where('is_urgent', true)->where('status', 'active')->count(),
            'suspended_users' => User::where('is_suspended', true)->count(),
            'featured_jobs' => Job::where('is_featured', true)->where('status', 'active')->count(),
        ];

        // Get recent activity
        $recentUsers = User::with('applications', 'jobs')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $recentJobs = Job::with(['employer', 'category'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $recentApplications = Application::with(['user', 'job'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Get pending approvals (jobs in draft status)
        $pendingJobs = Job::with(['employer', 'category'])
            ->where('status', 'draft')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get flagged content and reported users
        $reportedUsers = User::where('is_suspended', false)
            ->whereHas('applications', function($query) {
                $query->where('status', 'rejected');
            }, '>=', 3)
            ->withCount(['applications as rejected_applications' => function($query) {
                $query->where('status', 'rejected');
            }])
            ->orderBy('rejected_applications', 'desc')
            ->take(10)
            ->get();

        // Get suspicious jobs (high rejection rate or flagged)
        $suspiciousJobs = Job::where('status', 'active')
            ->where('applications_count', '>', 0)
            ->whereRaw('(SELECT COUNT(*) FROM applications WHERE job_id = job_postings.id AND status = "rejected") / applications_count > 0.7')
            ->with(['employer', 'category'])
            ->take(10)
            ->get();

        // Get monthly statistics for charts
        $monthlyStats = $this->getMonthlyStats();

        // Get category statistics
        $categoryStats = Category::withCount(['jobs' => function($query) {
            $query->where('status', 'active');
        }])
        ->orderBy('jobs_count', 'desc')
        ->get();

        // Get platform settings
        $platformSettings = cache('platform_settings', [
            'employer_fee' => 10,
            'worker_fee' => 5,
            'maintenance_mode' => false,
        ]);

        // Get messaging statistics for admin
        $messagingStats = [
            'total_messages' => \App\Models\Message::count(),
            'unread_admin_messages' => \App\Models\Message::where('receiver_id', auth()->id())->where('is_read', false)->count(),
            'messages_today' => \App\Models\Message::whereDate('created_at', today())->count(),
        ];

        return view('files.Admin', compact(
            'stats', 
            'recentUsers', 
            'recentJobs', 
            'recentApplications',
            'pendingJobs',
            'reportedUsers',
            'suspiciousJobs',
            'monthlyStats',
            'categoryStats',
            'platformSettings',
            'messagingStats'
        ));
    }

    /**
     * Get comprehensive analytics data for charts
     */
    public function getAnalytics()
    {
        try {
            \Log::info('Analytics endpoint called');
            
            // User growth over time
            $userGrowth = $this->getUserGrowthData();
            \Log::info('User growth data generated', ['count' => count($userGrowth)]);
            
            // Job posting trends
            $jobTrends = $this->getJobTrendsData();
            \Log::info('Job trends data generated', ['count' => count($jobTrends)]);
            
            // Application success rates
            $applicationRates = $this->getApplicationRatesData();
            \Log::info('Application rates data generated', $applicationRates);
            
            // Category distribution
            $categoryDistribution = $this->getCategoryDistributionData();
            \Log::info('Category distribution data generated', ['count' => count($categoryDistribution)]);
            
            // Revenue analytics (if applicable)
            $revenueData = $this->getRevenueData();
            \Log::info('Revenue data generated', ['count' => count($revenueData)]);
            
            // User activity patterns
            $activityPatterns = $this->getActivityPatternsData();
            \Log::info('Activity patterns data generated', ['count' => count($activityPatterns)]);
            
            // Geographic distribution
            $geographicData = $this->getGeographicData();
            \Log::info('Geographic data generated', ['count' => count($geographicData)]);

            // Top performing employers and workers
            $topEmployers = $this->getTopEmployers();
            $topWorkers = $this->getTopWorkers();
            \Log::info('Top performers data generated', [
                'employers' => count($topEmployers),
                'workers' => count($topWorkers)
            ]);

            $response = [
                'userGrowth' => $userGrowth,
                'jobTrends' => $jobTrends,
                'applicationRates' => $applicationRates,
                'categoryDistribution' => $categoryDistribution,
                'revenueData' => $revenueData,
                'activityPatterns' => $activityPatterns,
                'geographicData' => $geographicData,
                'topEmployers' => $topEmployers,
                'topWorkers' => $topWorkers,
            ];
            
            \Log::info('Analytics response prepared successfully');
            return response()->json($response);
            
        } catch (\Exception $e) {
            \Log::error('Analytics endpoint error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'Failed to load analytics data',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export analytics data to CSV
     */
    public function exportAnalytics()
    {
        $analytics = $this->getAnalytics()->getData();
        
        $filename = 'analytics_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($analytics) {
            $file = fopen('php://output', 'w');
            
            // User Growth Data
            fputcsv($file, ['USER GROWTH DATA']);
            fputcsv($file, ['Month', 'Workers', 'Employers', 'Total']);
            foreach ($analytics->userGrowth as $month) {
                fputcsv($file, [
                    $month['month'],
                    $month['workers'],
                    $month['employers'],
                    $month['total']
                ]);
            }
            
            fputcsv($file, []); // Empty row
            
            // Job Trends Data
            fputcsv($file, ['JOB TRENDS DATA']);
            fputcsv($file, ['Month', 'Posted', 'Completed', 'Active']);
            foreach ($analytics->jobTrends as $month) {
                fputcsv($file, [
                    $month['month'],
                    $month['posted'],
                    $month['completed'],
                    $month['active']
                ]);
            }
            
            fputcsv($file, []); // Empty row
            
            // Top Employers
            fputcsv($file, ['TOP EMPLOYERS']);
            fputcsv($file, ['Name', 'Jobs Posted', 'Success Rate']);
            foreach ($analytics->topEmployers as $employer) {
                fputcsv($file, [
                    $employer['name'],
                    $employer['jobs_count'],
                    $employer['success_rate'] . '%'
                ]);
            }
            
            fputcsv($file, []); // Empty row
            
            // Top Workers
            fputcsv($file, ['TOP WORKERS']);
            fputcsv($file, ['Name', 'Applications', 'Success Rate']);
            foreach ($analytics->topWorkers as $worker) {
                fputcsv($file, [
                    $worker['name'],
                    $worker['applications_count'],
                    $worker['success_rate'] . '%'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Generate monthly reports
     */
    public function generateMonthlyReport(Request $request)
    {
        $request->validate([
            'month' => 'required|date_format:Y-m',
            'type' => 'required|in:comprehensive,employers,workers,financial'
        ]);

        $month = $request->month;
        $type = $request->type;
        
        // Parse month
        $date = Carbon::createFromFormat('Y-m', $month);
        $startDate = $date->copy()->startOfMonth();
        $endDate = $date->copy()->endOfMonth();

        $reportData = $this->generateReportData($startDate, $endDate, $type);
        
        $filename = "monthly_report_{$type}_{$month}.pdf";
        $filePath = storage_path("app/reports/{$filename}");
        
        // Generate PDF report (you can use libraries like TCPDF, DOMPDF, etc.)
        $this->generatePDFReport($reportData, $filePath, $type, $date);
        
        return response()->json([
            'success' => true,
            'message' => 'Monthly report generated successfully',
            'download_url' => route('admin.download.report', ['filename' => $filename]),
            'filename' => $filename
        ]);
    }

    /**
     * Download generated report
     */
    public function downloadReport($filename)
    {
        $filePath = storage_path("app/reports/{$filename}");
        
        if (!file_exists($filePath)) {
            abort(404, 'Report not found');
        }
        
        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    /**
     * Get all users with advanced filtering and search
     */
    public function getUsers(Request $request)
    {
        $query = User::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        // Role filter
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status === 'suspended') {
                $query->where('is_suspended', true);
            } elseif ($request->status === 'active') {
                $query->where('is_suspended', false);
            }
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Handle export request
        if ($request->boolean('export')) {
            return $this->exportUsersToCSV($query);
        }

        // Get users with related data
        $users = $query->withCount(['applications', 'jobs'])
            ->paginate(20);

        // Add profile picture URLs to each user
        $users->getCollection()->transform(function ($user) {
            $user->profile_picture_url = $user->getProfilePictureUrl();
            return $user;
        });

        return response()->json($users);
    }

    /**
     * Export users to CSV
     */
    private function exportUsersToCSV($query)
    {
        $users = $query->withCount(['applications', 'jobs'])->get();
        
        $filename = 'users_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'ID',
                'Name',
                'Email',
                'Phone',
                'Role',
                'Status',
                'Applications Count',
                'Jobs Count',
                'Joined Date',
                'Last Login',
                'Suspended Until',
                'Suspension Reason'
            ]);

            // Add user data
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->phone ?? 'N/A',
                    ucfirst($user->role),
                    $user->is_suspended ? 'Suspended' : 'Active',
                    $user->applications_count ?? 0,
                    $user->jobs_count ?? 0,
                    $user->created_at->format('Y-m-d H:i:s'),
                    $user->last_login_at ? $user->last_login_at->format('Y-m-d H:i:s') : 'Never',
                    $user->suspended_until ? $user->suspended_until->format('Y-m-d H:i:s') : 'N/A',
                    $user->suspension_reason ?? 'N/A'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get all jobs with advanced filtering
     */
    public function getJobs(Request $request)
    {
        $query = Job::with(['employer', 'category']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('location', 'LIKE', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Job type filter
        if ($request->filled('job_type')) {
            $query->where('job_type', $request->job_type);
        }

        // Urgency filter
        if ($request->filled('urgent_only')) {
            $query->where('is_urgent', true);
        }

        // Budget range filter
        if ($request->filled('min_budget')) {
            $query->where('budget', '>=', $request->min_budget);
        }
        if ($request->filled('max_budget')) {
            $query->where('budget', '<=', $request->max_budget);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $jobs = $query->paginate(20);

        return response()->json($jobs);
    }

    /**
     * Bulk approve jobs
     */
    public function bulkApproveJobs(Request $request)
    {
        $request->validate([
            'job_ids' => 'required|array',
            'job_ids.*' => 'exists:job_postings,id'
        ]);

        $updated = Job::whereIn('id', $request->job_ids)
            ->where('status', 'draft')
            ->update(['status' => 'active']);

        // Log admin action
        \Log::info('Bulk job approval by admin', [
            'admin_id' => auth()->id(),
            'job_ids' => $request->job_ids,
            'count' => $updated,
            'timestamp' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => "{$updated} jobs approved successfully",
            'updated_count' => $updated
        ]);
    }

    /**
     * Bulk reject jobs
     */
    public function bulkRejectJobs(Request $request)
    {
        $request->validate([
            'job_ids' => 'required|array',
            'job_ids.*' => 'exists:job_postings,id',
            'reason' => 'required|string|max:500'
        ]);

        $updated = Job::whereIn('id', $request->job_ids)
            ->where('status', 'draft')
            ->update([
                'status' => 'cancelled',
                'admin_notes' => $request->reason
            ]);

        // Log admin action
        \Log::info('Bulk job rejection by admin', [
            'admin_id' => auth()->id(),
            'job_ids' => $request->job_ids,
            'reason' => $request->reason,
            'count' => $updated,
            'timestamp' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => "{$updated} jobs rejected successfully",
            'updated_count' => $updated
        ]);
    }

    /**
     * Get user details with comprehensive information
     */
    public function getUserDetails(User $user)
    {
        $user->load([
            'applications.job',
            'jobs.applications',
            'jobs.category'
        ]);

        // Get user statistics
        $userStats = [
            'total_applications' => $user->applications->count(),
            'accepted_applications' => $user->applications->where('status', 'accepted')->count(),
            'rejected_applications' => $user->applications->where('status', 'rejected')->count(),
            'pending_applications' => $user->applications->where('status', 'pending')->count(),
            'total_jobs_posted' => $user->jobs->count(),
            'active_jobs' => $user->jobs->where('status', 'active')->count(),
            'completed_jobs' => $user->jobs->where('status', 'completed')->count(),
            'average_job_budget' => $user->jobs->avg('budget'),
            'total_job_views' => $user->jobs->sum('views'),
            'account_age_days' => $user->created_at->diffInDays(now()),
        ];

        // Get recent activity
        $recentActivity = collect()
            ->merge($user->applications->take(5)->map(function($app) {
                return [
                    'type' => 'application',
                    'description' => "Applied for: {$app->job->title}",
                    'date' => $app->created_at,
                    'status' => $app->status
                ];
            }))
            ->merge($user->jobs->take(5)->map(function($job) {
                return [
                    'type' => 'job_posting',
                    'description' => "Posted job: {$job->title}",
                    'date' => $job->created_at,
                    'status' => $job->status
                ];
            }))
            ->sortByDesc('date')
            ->take(10)
            ->values();

        // Add profile picture URL
        $user->profile_picture = $user->getProfilePictureUrl();

        return response()->json([
            'user' => $user,
            'stats' => $userStats,
            'recent_activity' => $recentActivity
        ]);
    }

    /**
     * Advanced user suspension with email notification
     */
    public function suspendUser(Request $request, User $user)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
            'duration' => 'required|in:7,30,90,permanent',
            'notify_user' => 'boolean'
        ]);

        $suspendedUntil = $request->duration === 'permanent' 
            ? null 
            : now()->addDays((int)$request->duration);

        $user->update([
            'is_suspended' => true,
            'suspended_until' => $suspendedUntil,
            'suspension_reason' => $request->reason
        ]);

        // Send notification email if requested
        if ($request->boolean('notify_user')) {
            // You can implement email notification here
            // Mail::to($user->email)->send(new UserSuspendedMail($user, $request->reason, $suspendedUntil));
        }

        // Log admin action
        \Log::info('User suspended by admin', [
            'admin_id' => auth()->id(),
            'user_id' => $user->id,
            'user_email' => $user->email,
            'reason' => $request->reason,
            'duration' => $request->duration,
            'suspended_until' => $suspendedUntil,
            'notification_sent' => $request->boolean('notify_user'),
            'timestamp' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User suspended successfully',
            'suspended_until' => $suspendedUntil
        ]);
    }

    /**
     * Bulk user operations
     */
    public function bulkUserAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:suspend,unsuspend,delete',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'reason' => 'required_if:action,suspend|string|max:500',
            'duration' => 'required_if:action,suspend|in:7,30,90,permanent'
        ]);

        $users = User::whereIn('id', $request->user_ids)->get();
        $count = 0;

        foreach ($users as $user) {
            // Prevent admin from suspending themselves
            if ($user->id === auth()->id()) {
                continue;
            }

            switch ($request->action) {
                case 'suspend':
                    $suspendedUntil = $request->duration === 'permanent' 
                        ? null 
                        : now()->addDays((int)$request->duration);
                    
                    $user->update([
                        'is_suspended' => true,
                        'suspended_until' => $suspendedUntil,
                        'suspension_reason' => $request->reason
                    ]);
                    $count++;
                    break;

                case 'unsuspend':
                    $user->update([
                        'is_suspended' => false,
                        'suspended_until' => null,
                        'suspension_reason' => null
                    ]);
                    $count++;
                    break;

                case 'delete':
                    // Soft delete or hard delete based on your preference
                    $user->delete();
                    $count++;
                    break;
            }
        }

        // Log admin action
        \Log::info('Bulk user action by admin', [
            'admin_id' => auth()->id(),
            'action' => $request->action,
            'user_ids' => $request->user_ids,
            'affected_count' => $count,
            'reason' => $request->reason ?? null,
            'timestamp' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => "{$count} users {$request->action}ed successfully",
            'affected_count' => $count
        ]);
    }

    /**
     * Update platform settings with validation
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'employer_fee' => 'required|numeric|min:0|max:100',
            'worker_fee' => 'required|numeric|min:0|max:100',
            'maintenance_mode' => 'boolean',
            'max_job_applications' => 'nullable|integer|min:1|max:1000',
            'job_approval_required' => 'boolean',
            'user_verification_required' => 'boolean',
            'max_file_upload_size' => 'nullable|integer|min:1|max:100',
        ]);

        $settings = [
            'employer_fee' => $request->employer_fee,
            'worker_fee' => $request->worker_fee,
            'maintenance_mode' => $request->boolean('maintenance_mode'),
            'max_job_applications' => $request->max_job_applications ?? 50,
            'job_approval_required' => $request->boolean('job_approval_required'),
            'user_verification_required' => $request->boolean('user_verification_required'),
            'max_file_upload_size' => $request->max_file_upload_size ?? 10,
            'updated_by' => auth()->id(),
            'updated_at' => now()
        ];

        // Store settings in cache and optionally in database
        cache()->put('platform_settings', $settings, now()->addYear());

        // Log admin action
        \Log::info('Platform settings updated by admin', [
            'admin_id' => auth()->id(),
            'settings' => $settings,
            'timestamp' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Settings updated successfully',
            'settings' => $settings
        ]);
    }

    /**
     * System maintenance operations
     */
    public function systemMaintenance(Request $request)
    {
        $request->validate([
            'action' => 'required|in:backup,clear_cache,optimize,maintenance_toggle'
        ]);

        $result = ['success' => false, 'message' => ''];

        switch ($request->action) {
            case 'backup':
                // Implement database backup
                $result = $this->createDatabaseBackup();
                break;

            case 'clear_cache':
                // Clear all caches
                \Artisan::call('cache:clear');
                \Artisan::call('config:clear');
                \Artisan::call('route:clear');
                \Artisan::call('view:clear');
                
                $result = [
                    'success' => true,
                    'message' => 'All caches cleared successfully'
                ];
                break;

            case 'optimize':
                // Optimize the application
                \Artisan::call('optimize');
                
                $result = [
                    'success' => true,
                    'message' => 'Application optimized successfully'
                ];
                break;

            case 'maintenance_toggle':
                // Toggle maintenance mode
                if (app()->isDownForMaintenance()) {
                    \Artisan::call('up');
                    $result = [
                        'success' => true,
                        'message' => 'Maintenance mode disabled'
                    ];
                } else {
                    \Artisan::call('down', ['--secret' => 'admin-access']);
                    $result = [
                        'success' => true,
                        'message' => 'Maintenance mode enabled'
                    ];
                }
                break;
        }

        // Log admin action
        \Log::info('System maintenance action by admin', [
            'admin_id' => auth()->id(),
            'action' => $request->action,
            'result' => $result,
            'timestamp' => now()
        ]);

        return response()->json($result);
    }

    /**
     * Get admin conversations for messaging
     */
    public function getAdminConversations()
    {
        $admin = auth()->user();
        
        // Get all conversations where admin is involved
        $conversations = \App\Models\Message::where(function($query) use ($admin) {
                $query->where('sender_id', $admin->id)
                      ->orWhere('receiver_id', $admin->id);
            })
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function($message) use ($admin) {
                return $message->sender_id === $admin->id ? $message->receiver_id : $message->sender_id;
            })
            ->map(function($messages) use ($admin) {
                $lastMessage = $messages->first();
                $otherUserId = $lastMessage->sender_id === $admin->id ? $lastMessage->receiver_id : $lastMessage->sender_id;
                $otherUser = User::find($otherUserId);
                
                $unreadCount = $messages->where('receiver_id', $admin->id)
                                      ->where('is_read', false)
                                      ->count();
                
                return [
                    'user' => $otherUser,
                    'last_message' => $lastMessage,
                    'unread_count' => $unreadCount,
                    'last_message_time' => $lastMessage->created_at
                ];
            })
            ->sortByDesc('last_message_time')
            ->values();

        return response()->json($conversations);
    }

    /**
     * Get messaging statistics for admin dashboard
     */
    public function getMessageStats()
    {
        $admin = auth()->user();
        
        $stats = [
            'total_messages' => \App\Models\Message::count(),
            'unread_messages' => \App\Models\Message::where('receiver_id', $admin->id)
                                                  ->where('is_read', false)
                                                  ->count(),
            'messages_today' => \App\Models\Message::whereDate('created_at', today())->count(),
            'conversations_count' => \App\Models\Message::where(function($query) use ($admin) {
                    $query->where('sender_id', $admin->id)
                          ->orWhere('receiver_id', $admin->id);
                })
                ->select(\DB::raw('CASE 
                    WHEN sender_id = ' . $admin->id . ' THEN receiver_id 
                    ELSE sender_id 
                END as user_id'))
                ->distinct()
                ->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Count broadcast recipients
     */
    public function countBroadcastRecipients(Request $request)
    {
        $audience = $request->get('audience', 'all');
        
        // Get target users based on audience
        $query = User::where('role', '!=', 'admin');
        
        switch ($audience) {
            case 'workers':
                $query->where('role', 'worker');
                break;
            case 'employers':
                $query->where('role', 'employer');
                break;
            case 'new_users':
                $query->where('created_at', '>=', now()->subDays(30));
                break;
            // 'all' doesn't need additional filtering
        }
        
        $count = $query->count();
        
        return response()->json([
            'success' => true,
            'count' => $count,
            'audience' => $audience
        ]);
    }

    /**
     * Send broadcast message to users
     */
    public function sendBroadcastMessage(Request $request)
    {
        $request->validate([
            'audience' => 'required|in:all,workers,employers,new_users',
            'message' => 'required|string|max:1000',
            'type' => 'required|in:announcement,maintenance,feature,promotion',
            'send_email' => 'boolean',
            'is_urgent' => 'boolean'
        ]);

        $admin = auth()->user();
        
        // Get target users based on audience
        $query = User::where('role', '!=', 'admin');
        
        switch ($request->audience) {
            case 'workers':
                $query->where('role', 'worker');
                break;
            case 'employers':
                $query->where('role', 'employer');
                break;
            case 'new_users':
                $query->where('created_at', '>=', now()->subDays(30));
                break;
            // 'all' doesn't need additional filtering
        }
        
        $users = $query->get();
        $messagesSent = 0;
        
        foreach ($users as $user) {
            \App\Models\Message::create([
                'sender_id' => $admin->id,
                'receiver_id' => $user->id,
                'message' => "[{$request->type}] " . $request->message,
                'is_read' => false
            ]);
            $messagesSent++;
        }

        // Log admin action
        \Log::info('Broadcast message sent by admin', [
            'admin_id' => $admin->id,
            'audience' => $request->audience,
            'message_type' => $request->type,
            'recipients_count' => $messagesSent,
            'send_email' => $request->boolean('send_email'),
            'is_urgent' => $request->boolean('is_urgent'),
            'timestamp' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => "Broadcast message sent to {$messagesSent} users",
            'recipients_count' => $messagesSent
        ]);
    }

    /**
     * Get unread message count for admin
     */
    public function getUnreadCount()
    {
        $admin = auth()->user();
        $count = \App\Models\Message::where('receiver_id', $admin->id)
                                   ->where('is_read', false)
                                   ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Create a database backup
     */
    public function backupDatabase(Request $request)
    {
        try {
            // Create backups directory if it doesn't exist
            $backupDir = storage_path('app/backups');
            if (!file_exists($backupDir)) {
                mkdir($backupDir, 0755, true);
            }

            // Generate filename with timestamp
            $timestamp = now()->format('Y_m_d_H_i');
            $filename = "joblink_backup_{$timestamp}.sql";
            $filepath = $backupDir . '/' . $filename;

            // Get database configuration
            $database = config('database.connections.mysql.database');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');
            $host = config('database.connections.mysql.host');
            $port = config('database.connections.mysql.port', 3306);

            // Create backup using Laravel's database export
            $tables = [
                'users', 'jobs', 'applications', 'messages', 'categories', 
                'bookmarks', 'likes', 'payments', 'job_categories', 'password_resets'
            ];

            $sqlContent = "-- JOB-lyNK Database Backup\n";
            $sqlContent .= "-- Generated on: " . now()->toDateTimeString() . "\n";
            $sqlContent .= "-- Database: {$database}\n\n";

            foreach ($tables as $table) {
                try {
                    // Check if table exists
                    $tableExists = DB::select("SHOW TABLES LIKE '{$table}'");
                    if (empty($tableExists)) {
                        continue;
                    }

                    $sqlContent .= "\n-- Table structure for table `{$table}`\n";
                    $sqlContent .= "DROP TABLE IF EXISTS `{$table}`;\n";
                    
                    // Get table structure
                    $createTable = DB::select("SHOW CREATE TABLE `{$table}`");
                    if (!empty($createTable)) {
                        $sqlContent .= $createTable[0]->{'Create Table'} . ";\n\n";
                    }

                    // Get table data
                    $rows = DB::table($table)->get();
                    if ($rows->count() > 0) {
                        $sqlContent .= "-- Dumping data for table `{$table}`\n";
                        $sqlContent .= "LOCK TABLES `{$table}` WRITE;\n";
                        
                        foreach ($rows as $row) {
                            $values = [];
                            foreach ((array)$row as $value) {
                                if (is_null($value)) {
                                    $values[] = 'NULL';
                                } else {
                                    $values[] = "'" . addslashes($value) . "'";
                                }
                            }
                            $columns = implode('`,`', array_keys((array)$row));
                            $valueString = implode(',', $values);
                            $sqlContent .= "INSERT INTO `{$table}` (`{$columns}`) VALUES ({$valueString});\n";
                        }
                        
                        $sqlContent .= "UNLOCK TABLES;\n\n";
                    }
                } catch (\Exception $e) {
                    Log::warning("Failed to backup table {$table}: " . $e->getMessage());
                    continue;
                }
            }

            // Write backup file
            file_put_contents($filepath, $sqlContent);

            // Verify file was created
            if (!file_exists($filepath)) {
                throw new \Exception('Backup file was not created successfully');
            }

            $fileSize = filesize($filepath);
            $fileSizeMB = round($fileSize / 1024 / 1024, 2);

            // Log the backup action
            Log::info('Database backup created', [
                'admin_user' => auth()->user()->name,
                'admin_id' => auth()->id(),
                'filename' => $filename,
                'file_size' => $fileSizeMB . 'MB',
                'tables_backed_up' => $tables,
                'timestamp' => now()->toDateTimeString()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Database backup created successfully',
                'filename' => $filename,
                'file_size' => $fileSizeMB . 'MB',
                'location' => '/storage/backups/',
                'timestamp' => now()->toDateTimeString(),
                'tables_backed_up' => count($tables)
            ]);

        } catch (\Exception $e) {
            Log::error('Database backup failed', [
                'admin_user' => auth()->user()->name,
                'error' => $e->getMessage(),
                'timestamp' => now()->toDateTimeString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Backup failed: ' . $e->getMessage()
            ], 500);
        }
    }

    // Private helper methods for analytics data

    private function getUserGrowthData()
    {
        $months = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = [
                'month' => $date->format('M Y'),
                'workers' => User::where('role', 'worker')
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
                'employers' => User::where('role', 'employer')
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
                'total' => User::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
            ];
        }
        return $months;
    }

    private function getJobTrendsData()
    {
        $months = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = [
                'month' => $date->format('M Y'),
                'posted' => Job::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
                'completed' => Job::where('status', 'completed')
                    ->whereYear('updated_at', $date->year)
                    ->whereMonth('updated_at', $date->month)
                    ->count(),
                'active' => Job::where('status', 'active')
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
            ];
        }
        return $months;
    }

    private function getApplicationRatesData()
    {
        return [
            'pending' => Application::where('status', 'pending')->count(),
            'accepted' => Application::where('status', 'accepted')->count(),
            'rejected' => Application::where('status', 'rejected')->count(),
        ];
    }

    private function getCategoryDistributionData()
    {
        return Category::withCount(['jobs' => function($query) {
            $query->where('status', 'active');
        }])
        ->orderBy('jobs_count', 'desc')
        ->get()
        ->map(function($category) {
            return [
                'name' => $category->name,
                'count' => $category->jobs_count,
                'percentage' => Job::where('status', 'active')->count() > 0 
                    ? round(($category->jobs_count / Job::where('status', 'active')->count()) * 100, 1)
                    : 0
            ];
        });
    }

    private function getRevenueData()
    {
        // This would be based on your payment/transaction system
        // For now, returning estimated revenue based on job completions
        $months = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $completedJobs = Job::where('status', 'completed')
                ->whereYear('updated_at', $date->year)
                ->whereMonth('updated_at', $date->month)
                ->sum('budget');
            
            $months[] = [
                'month' => $date->format('M Y'),
                'revenue' => $completedJobs * 0.1, // Assuming 10% platform fee
            ];
        }
        return $months;
    }

    private function getTopEmployers()
    {
        return User::where('role', 'employer')
            ->withCount(['jobs as jobs_count'])
            ->with(['jobs' => function($query) {
                $query->withCount(['applications as total_applications'])
                      ->withCount(['applications as accepted_applications' => function($q) {
                          $q->where('status', 'accepted');
                      }]);
            }])
            ->get()
            ->map(function($employer) {
                $totalApplications = $employer->jobs->sum('total_applications');
                $acceptedApplications = $employer->jobs->sum('accepted_applications');
                $successRate = $totalApplications > 0 ? round(($acceptedApplications / $totalApplications) * 100, 1) : 0;
                
                return [
                    'id' => $employer->id,
                    'name' => $employer->name,
                    'jobs_count' => $employer->jobs_count,
                    'success_rate' => $successRate
                ];
            })
            ->sortByDesc('jobs_count')
            ->take(10)
            ->values();
    }

    private function getTopWorkers()
    {
        return User::where('role', 'worker')
            ->withCount(['applications as applications_count'])
            ->withCount(['applications as accepted_applications' => function($query) {
                $query->where('status', 'accepted');
            }])
            ->get()
            ->map(function($worker) {
                $successRate = $worker->applications_count > 0 ? 
                    round(($worker->accepted_applications / $worker->applications_count) * 100, 1) : 0;
                
                return [
                    'id' => $worker->id,
                    'name' => $worker->name,
                    'applications_count' => $worker->applications_count,
                    'success_rate' => $successRate
                ];
            })
            ->sortByDesc('applications_count')
            ->take(10)
            ->values();
    }

    private function generateReportData($startDate, $endDate, $type)
    {
        $data = [
            'period' => [
                'start' => $startDate->format('Y-m-d'),
                'end' => $endDate->format('Y-m-d'),
                'month_name' => $startDate->format('F Y')
            ]
        ];

        switch ($type) {
            case 'comprehensive':
                $data = array_merge($data, [
                    'users' => $this->getMonthlyUserData($startDate, $endDate),
                    'jobs' => $this->getMonthlyJobData($startDate, $endDate),
                    'applications' => $this->getMonthlyApplicationData($startDate, $endDate),
                    'revenue' => $this->getMonthlyRevenueData($startDate, $endDate),
                    'top_employers' => $this->getMonthlyTopEmployers($startDate, $endDate),
                    'top_workers' => $this->getMonthlyTopWorkers($startDate, $endDate)
                ]);
                break;
                
            case 'employers':
                $data['employers'] = $this->getDetailedEmployerData($startDate, $endDate);
                break;
                
            case 'workers':
                $data['workers'] = $this->getDetailedWorkerData($startDate, $endDate);
                break;
                
            case 'financial':
                $data['financial'] = $this->getDetailedFinancialData($startDate, $endDate);
                break;
        }

        return $data;
    }

    private function getMonthlyUserData($startDate, $endDate)
    {
        return [
            'new_users' => User::whereBetween('created_at', [$startDate, $endDate])->count(),
            'new_workers' => User::where('role', 'worker')->whereBetween('created_at', [$startDate, $endDate])->count(),
            'new_employers' => User::where('role', 'employer')->whereBetween('created_at', [$startDate, $endDate])->count(),
            'total_users' => User::where('created_at', '<=', $endDate)->count(),
            'active_users' => User::where('last_login_at', '>=', $startDate)->count()
        ];
    }

    private function getMonthlyJobData($startDate, $endDate)
    {
        return [
            'jobs_posted' => Job::whereBetween('created_at', [$startDate, $endDate])->count(),
            'jobs_completed' => Job::where('status', 'completed')->whereBetween('updated_at', [$startDate, $endDate])->count(),
            'jobs_active' => Job::where('status', 'active')->whereBetween('created_at', [$startDate, $endDate])->count(),
            'average_budget' => Job::whereBetween('created_at', [$startDate, $endDate])->avg('budget'),
            'total_budget' => Job::whereBetween('created_at', [$startDate, $endDate])->sum('budget')
        ];
    }

    private function getMonthlyApplicationData($startDate, $endDate)
    {
        return [
            'total_applications' => Application::whereBetween('created_at', [$startDate, $endDate])->count(),
            'accepted_applications' => Application::where('status', 'accepted')->whereBetween('created_at', [$startDate, $endDate])->count(),
            'rejected_applications' => Application::where('status', 'rejected')->whereBetween('created_at', [$startDate, $endDate])->count(),
            'pending_applications' => Application::where('status', 'pending')->whereBetween('created_at', [$startDate, $endDate])->count()
        ];
    }

    private function getMonthlyRevenueData($startDate, $endDate)
    {
        $completedJobs = Job::where('status', 'completed')
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->sum('budget');
            
        return [
            'gross_revenue' => $completedJobs,
            'platform_fee' => $completedJobs * 0.1, // Assuming 10% platform fee
            'net_revenue' => $completedJobs * 0.9
        ];
    }

    private function getMonthlyTopEmployers($startDate, $endDate)
    {
        return User::where('role', 'employer')
            ->whereHas('jobs', function($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->withCount(['jobs as monthly_jobs' => function($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->orderBy('monthly_jobs', 'desc')
            ->take(10)
            ->get();
    }

    private function getMonthlyTopWorkers($startDate, $endDate)
    {
        return User::where('role', 'worker')
            ->whereHas('applications', function($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->withCount(['applications as monthly_applications' => function($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->orderBy('monthly_applications', 'desc')
            ->take(10)
            ->get();
    }

    private function generatePDFReport($data, $filePath, $type, $date)
    {
        // Create reports directory if it doesn't exist
        $reportsDir = storage_path('app/reports');
        if (!file_exists($reportsDir)) {
            mkdir($reportsDir, 0755, true);
        }

        // For now, generate a simple HTML report that can be converted to PDF
        // You can integrate with libraries like TCPDF, DOMPDF, or wkhtmltopdf
        $html = $this->generateReportHTML($data, $type, $date);
        
        // Save as HTML for now (you can convert to PDF using your preferred library)
        file_put_contents(str_replace('.pdf', '.html', $filePath), $html);
        
        // For demonstration, we'll just copy the HTML file as PDF
        // In production, you'd use a proper PDF generation library
        copy(str_replace('.pdf', '.html', $filePath), $filePath);
    }

    private function generateReportHTML($data, $type, $date)
    {
        $html = "
        <!DOCTYPE html>
        <html>
        <head>
            <title>Monthly Report - {$date->format('F Y')}</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .header { text-align: center; margin-bottom: 30px; }
                .section { margin-bottom: 20px; }
                .metric { display: inline-block; margin: 10px; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
                table { width: 100%; border-collapse: collapse; margin: 10px 0; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
            </style>
        </head>
        <body>
            <div class='header'>
                <h1>JOB-lyNK Monthly Report</h1>
                <h2>{$date->format('F Y')}</h2>
                <p>Report Type: " . ucfirst($type) . "</p>
                <p>Generated on: " . now()->format('Y-m-d H:i:s') . "</p>
            </div>
        ";

        if ($type === 'comprehensive') {
            $html .= "
            <div class='section'>
                <h3>User Statistics</h3>
                <div class='metric'>New Users: {$data['users']['new_users']}</div>
                <div class='metric'>New Workers: {$data['users']['new_workers']}</div>
                <div class='metric'>New Employers: {$data['users']['new_employers']}</div>
                <div class='metric'>Active Users: {$data['users']['active_users']}</div>
            </div>
            
            <div class='section'>
                <h3>Job Statistics</h3>
                <div class='metric'>Jobs Posted: {$data['jobs']['jobs_posted']}</div>
                <div class='metric'>Jobs Completed: {$data['jobs']['jobs_completed']}</div>
                <div class='metric'>Jobs Active: {$data['jobs']['jobs_active']}</div>
                <div class='metric'>Average Budget: UGX " . number_format($data['jobs']['average_budget']) . "</div>
            </div>
            
            <div class='section'>
                <h3>Application Statistics</h3>
                <div class='metric'>Total Applications: {$data['applications']['total_applications']}</div>
                <div class='metric'>Accepted: {$data['applications']['accepted_applications']}</div>
                <div class='metric'>Rejected: {$data['applications']['rejected_applications']}</div>
                <div class='metric'>Pending: {$data['applications']['pending_applications']}</div>
            </div>
            
            <div class='section'>
                <h3>Revenue Statistics</h3>
                <div class='metric'>Gross Revenue: UGX " . number_format($data['revenue']['gross_revenue']) . "</div>
                <div class='metric'>Platform Fee: UGX " . number_format($data['revenue']['platform_fee']) . "</div>
                <div class='metric'>Net Revenue: UGX " . number_format($data['revenue']['net_revenue']) . "</div>
            </div>
            ";
        }

        $html .= "
        </body>
        </html>
        ";

        return $html;
    }

    private function getActivityPatternsData()
    {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $patterns = [];
        
        foreach ($days as $day) {
            $patterns[] = [
                'day' => $day,
                'users' => User::whereRaw('DAYNAME(created_at) = ?', [$day])->count(),
                'jobs' => Job::whereRaw('DAYNAME(created_at) = ?', [$day])->count(),
                'applications' => Application::whereRaw('DAYNAME(created_at) = ?', [$day])->count(),
            ];
        }
        
        return $patterns;
    }

    private function getGeographicData()
    {
        return User::select('location', DB::raw('count(*) as count'))
            ->whereNotNull('location')
            ->groupBy('location')
            ->orderBy('count', 'desc')
            ->take(10)
            ->get();
    }

    private function getMonthlyStats()
    {
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = [
                'month' => $date->format('M Y'),
                'users' => User::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
                'jobs' => Job::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
                'applications' => Application::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
            ];
        }
        return $months;
    }

    private function createDatabaseBackup()
    {
        try {
            $filename = 'backup_' . date('Y_m_d_H_i_s') . '.sql';
            $path = storage_path('app/backups/' . $filename);
            
            // Create backups directory if it doesn't exist
            if (!Storage::exists('backups')) {
                Storage::makeDirectory('backups');
            }
            
            // This is a simplified backup - in production, use proper backup tools
            \Artisan::call('backup:run', ['--only-db' => true]);
            
            return [
                'success' => true,
                'message' => 'Database backup created successfully',
                'filename' => $filename
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Backup failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Approve a job posting
     */
    public function approveJob(Request $request, Job $job)
    {
        $job->update(['status' => 'active']);

        // Log admin action
        \Log::info('Job approved by admin', [
            'admin_id' => auth()->id(),
            'job_id' => $job->id,
            'job_title' => $job->title,
            'employer_id' => $job->user_id,
            'timestamp' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Job approved successfully'
        ]);
    }

    /**
     * Reject a job posting
     */
    public function rejectJob(Request $request, Job $job)
    {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        $job->update([
            'status' => 'cancelled',
            'admin_notes' => $request->reason
        ]);

        // Log admin action
        \Log::info('Job rejected by admin', [
            'admin_id' => auth()->id(),
            'job_id' => $job->id,
            'job_title' => $job->title,
            'employer_id' => $job->user_id,
            'reason' => $request->reason,
            'timestamp' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Job rejected successfully'
        ]);
    }

    /**
     * Unsuspend a user account
     */
    public function unsuspendUser(User $user)
    {
        $user->update([
            'is_suspended' => false,
            'suspended_until' => null,
            'suspension_reason' => null
        ]);

        // Log admin action
        \Log::info('User unsuspended by admin', [
            'admin_id' => auth()->id(),
            'user_id' => $user->id,
            'user_email' => $user->email,
            'timestamp' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User unsuspended successfully'
        ]);
    }

    /**
     * Get system statistics for API
     */
    public function getStats()
    {
        $stats = [
            'users' => [
                'total' => User::count(),
                'workers' => User::where('role', 'worker')->count(),
                'employers' => User::where('role', 'employer')->count(),
                'suspended' => User::where('is_suspended', true)->count(),
                'new_today' => User::whereDate('created_at', today())->count(),
                'new_this_week' => User::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
                'new_this_month' => User::whereMonth('created_at', now()->month)->count(),
            ],
            'jobs' => [
                'total' => Job::count(),
                'active' => Job::where('status', 'active')->count(),
                'pending' => Job::where('status', 'draft')->count(),
                'completed' => Job::where('status', 'completed')->count(),
                'cancelled' => Job::where('status', 'cancelled')->count(),
                'urgent' => Job::where('is_urgent', true)->where('status', 'active')->count(),
                'featured' => Job::where('is_featured', true)->where('status', 'active')->count(),
                'new_today' => Job::whereDate('created_at', today())->count(),
            ],
            'applications' => [
                'total' => Application::count(),
                'pending' => Application::where('status', 'pending')->count(),
                'accepted' => Application::where('status', 'accepted')->count(),
                'rejected' => Application::where('status', 'rejected')->count(),
                'new_today' => Application::whereDate('created_at', today())->count(),
            ],
            'system' => [
                'maintenance_mode' => app()->isDownForMaintenance(),
                'cache_size' => $this->getCacheSize(),
                'storage_used' => $this->getStorageUsed(),
                'last_backup' => $this->getLastBackupDate(),
            ]
        ];

        return response()->json($stats);
    }

    /**
     * Get admin activity logs
     */
    public function getActivityLogs(Request $request)
    {
        // This would typically come from a dedicated logs table
        // For now, we'll return recent activities from various models
        $activities = collect();

        // Recent user registrations
        $recentUsers = User::orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->map(function($user) {
                return [
                    'type' => 'user_registration',
                    'message' => "{$user->name} registered as {$user->role}",
                    'timestamp' => $user->created_at,
                    'user_id' => $user->id,
                    'icon' => 'fas fa-user-plus',
                    'color' => 'text-green-600'
                ];
            });

        // Recent job postings
        $recentJobs = Job::with('employer')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->map(function($job) {
                return [
                    'type' => 'job_posting',
                    'message' => "{$job->employer->name} posted '{$job->title}'",
                    'timestamp' => $job->created_at,
                    'job_id' => $job->id,
                    'icon' => 'fas fa-briefcase',
                    'color' => 'text-blue-600'
                ];
            });

        // Recent applications
        $recentApplications = Application::with(['user', 'job'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->map(function($app) {
                return [
                    'type' => 'application',
                    'message' => "{$app->user->name} applied for '{$app->job->title}'",
                    'timestamp' => $app->created_at,
                    'application_id' => $app->id,
                    'icon' => 'fas fa-file-alt',
                    'color' => 'text-purple-600'
                ];
            });

        $activities = $activities->merge($recentUsers)
            ->merge($recentJobs)
            ->merge($recentApplications)
            ->sortByDesc('timestamp')
            ->take(50)
            ->values();

        return response()->json($activities);
    }

    /**
     * Send message to employer or user
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
            'job_id' => 'nullable|exists:job_postings,id'
        ]);

        $admin = auth()->user();
        
        $message = \App\Models\Message::create([
            'sender_id' => $admin->id,
            'receiver_id' => $request->receiver_id,
            'job_id' => $request->job_id,
            'message' => $request->message,
            'is_read' => false
        ]);

        // Log admin action
        \Log::info('Message sent by admin', [
            'admin_id' => $admin->id,
            'receiver_id' => $request->receiver_id,
            'job_id' => $request->job_id,
            'message_length' => strlen($request->message),
            'timestamp' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully',
            'data' => $message->load(['sender', 'receiver', 'job'])
        ]);
    }

    /**
     * List all backup files
     */
    public function listBackups()
    {
        try {
            $backupDir = storage_path('app/backups');
            
            if (!file_exists($backupDir)) {
                return response()->json([
                    'success' => true,
                    'backups' => [],
                    'message' => 'No backups directory found'
                ]);
            }

            $files = glob($backupDir . '/*.sql');
            $backups = [];

            foreach ($files as $file) {
                $filename = basename($file);
                $backups[] = [
                    'filename' => $filename,
                    'size' => $this->formatFileSize(filesize($file)),
                    'size_bytes' => filesize($file),
                    'created_at' => date('Y-m-d H:i:s', filemtime($file)),
                    'created_at_human' => $this->timeAgo(filemtime($file)),
                    'download_url' => route('admin.backups.download', ['filename' => $filename])
                ];
            }

            // Sort by creation date (newest first)
            usort($backups, function($a, $b) {
                return strtotime($b['created_at']) - strtotime($a['created_at']);
            });

            return response()->json([
                'success' => true,
                'backups' => $backups,
                'total_count' => count($backups),
                'total_size' => $this->formatFileSize(array_sum(array_column($backups, 'size_bytes')))
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to list backups', [
                'error' => $e->getMessage(),
                'admin_id' => auth()->id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to list backups: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download a backup file
     */
    public function downloadBackup($filename)
    {
        try {
            // Validate filename to prevent directory traversal
            if (!preg_match('/^joblink_backup_\d{4}_\d{2}_\d{2}_\d{2}_\d{2}\.sql$/', $filename)) {
                abort(404, 'Invalid backup filename');
            }

            $filePath = storage_path('app/backups/' . $filename);

            if (!file_exists($filePath)) {
                abort(404, 'Backup file not found');
            }

            // Log the download action
            Log::info('Backup file downloaded', [
                'admin_id' => auth()->id(),
                'admin_name' => auth()->user()->name,
                'filename' => $filename,
                'file_size' => filesize($filePath),
                'timestamp' => now()->toDateTimeString()
            ]);

            return response()->download($filePath, $filename, [
                'Content-Type' => 'application/sql',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"'
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to download backup', [
                'filename' => $filename,
                'error' => $e->getMessage(),
                'admin_id' => auth()->id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to download backup: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a backup file
     */
    public function deleteBackup($filename)
    {
        try {
            // Validate filename to prevent directory traversal
            if (!preg_match('/^joblink_backup_\d{4}_\d{2}_\d{2}_\d{2}_\d{2}\.sql$/', $filename)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid backup filename'
                ], 400);
            }

            $filePath = storage_path('app/backups/' . $filename);

            if (!file_exists($filePath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Backup file not found'
                ], 404);
            }

            $fileSize = filesize($filePath);
            
            if (unlink($filePath)) {
                // Log the deletion action
                Log::info('Backup file deleted', [
                    'admin_id' => auth()->id(),
                    'admin_name' => auth()->user()->name,
                    'filename' => $filename,
                    'file_size' => $fileSize,
                    'timestamp' => now()->toDateTimeString()
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Backup deleted successfully'
                ]);
            } else {
                throw new \Exception('Failed to delete backup file');
            }

        } catch (\Exception $e) {
            Log::error('Failed to delete backup', [
                'filename' => $filename,
                'error' => $e->getMessage(),
                'admin_id' => auth()->id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete backup: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper method to format file size
     */
    private function formatFileSize($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    /**
     * Helper method to get human readable time ago
     */
    private function timeAgo($timestamp)
    {
        $time = time() - $timestamp;

        if ($time < 60) {
            return 'just now';
        } elseif ($time < 3600) {
            return floor($time / 60) . ' minutes ago';
        } elseif ($time < 86400) {
            return floor($time / 3600) . ' hours ago';
        } elseif ($time < 2592000) {
            return floor($time / 86400) . ' days ago';
        } elseif ($time < 31536000) {
            return floor($time / 2592000) . ' months ago';
        } else {
            return floor($time / 31536000) . ' years ago';
        }
    }

    /**
     * Get messages for admin
     */
    public function getMessages(Request $request)
    {
        $admin = auth()->user();
        
        $query = \App\Models\Message::where(function($q) use ($admin) {
            $q->where('sender_id', $admin->id)
              ->orWhere('receiver_id', $admin->id);
        })->with(['sender', 'receiver', 'job']);

        // Filter by conversation partner
        if ($request->filled('user_id')) {
            $query->where(function($q) use ($admin, $request) {
                $q->where(function($subQ) use ($admin, $request) {
                    $subQ->where('sender_id', $admin->id)
                         ->where('receiver_id', $request->user_id);
                })->orWhere(function($subQ) use ($admin, $request) {
                    $subQ->where('sender_id', $request->user_id)
                         ->where('receiver_id', $admin->id);
                });
            });
        }

        // Filter by job
        if ($request->filled('job_id')) {
            $query->where('job_id', $request->job_id);
        }

        // Search in message content
        if ($request->filled('search')) {
            $query->where('message', 'LIKE', '%' . $request->search . '%');
        }

        $messages = $query->orderBy('created_at', 'desc')
                         ->paginate(20);

        return response()->json($messages);
    }

    /**
     * Get conversation with specific user
     */
    public function getConversation(Request $request, $userId)
    {
        $admin = auth()->user();
        
        $messages = \App\Models\Message::where(function($query) use ($admin, $userId) {
            $query->where(function($q) use ($admin, $userId) {
                $q->where('sender_id', $admin->id)
                  ->where('receiver_id', $userId);
            })->orWhere(function($q) use ($admin, $userId) {
                $q->where('sender_id', $userId)
                  ->where('receiver_id', $admin->id);
            });
        })
        ->with(['sender', 'receiver', 'job'])
        ->orderBy('created_at', 'asc')
        ->get();

        // Mark messages as read
        \App\Models\Message::where('sender_id', $userId)
            ->where('receiver_id', $admin->id)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        $user = User::find($userId);

        return response()->json([
            'messages' => $messages,
            'user' => $user
        ]);
    }

    /**
     * Get all employers for messaging
     */
    public function getEmployers()
    {
        $employers = User::where('role', 'employer')
            ->select('id', 'name', 'email', 'created_at')
            ->withCount(['jobs', 'applications'])
            ->orderBy('name')
            ->get();

        return response()->json($employers);
    }

    /**
     * Get all workers for messaging
     */
    public function getWorkers()
    {
        $workers = User::where('role', 'worker')
            ->select('id', 'name', 'email', 'created_at')
            ->withCount(['applications'])
            ->orderBy('name')
            ->get();

        return response()->json($workers);
    }

    /**
     * Search users for messaging
     */
    public function searchUsers(Request $request)
    {
        $search = $request->get('search', '');
        
        $users = User::where('role', '!=', 'admin')
            ->where(function($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%");
            })
            ->select('id', 'name', 'email', 'role')
            ->limit(10)
            ->get();

        return response()->json($users);
    }

    /**
     * Mark conversation as read
     */
    public function markConversationAsRead(Request $request, $userId)
    {
        $admin = auth()->user();
        
        $updated = \App\Models\Message::where('sender_id', $userId)
            ->where('receiver_id', $admin->id)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return response()->json([
            'success' => true,
            'marked_count' => $updated
        ]);
    }

    /**
     * Delete a message
     */
    public function deleteMessage(Request $request, $messageId)
    {
        $admin = auth()->user();
        
        $message = \App\Models\Message::where('id', $messageId)
            ->where(function($query) use ($admin) {
                $query->where('sender_id', $admin->id)
                      ->orWhere('receiver_id', $admin->id);
            })
            ->first();

        if (!$message) {
            return response()->json([
                'success' => false,
                'message' => 'Message not found'
            ], 404);
        }

        $message->delete();

        return response()->json([
            'success' => true,
            'message' => 'Message deleted successfully'
        ]);
    }

    // Helper methods for system statistics
    private function getCacheSize()
    {
        // This would depend on your cache driver
        // For demonstration, returning a placeholder
        return '45.2 MB';
    }

    private function getStorageUsed()
    {
        // Calculate storage usage
        $bytes = disk_total_space(storage_path()) - disk_free_space(storage_path());
        return $this->formatBytes($bytes);
    }

    private function getLastBackupDate()
    {
        // Check for latest backup file
        $backupPath = storage_path('app/backups');
        if (!is_dir($backupPath)) {
            return 'Never';
        }
        
        $files = glob($backupPath . '/*');
        if (empty($files)) {
            return 'Never';
        }
        
        $latestFile = max($files);
        return date('Y-m-d H:i:s', filemtime($latestFile));
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }

    /**
     * Toggle maintenance mode
     */
    public function toggleMaintenance()
    {
        try {
            $current = \App\Models\Setting::get('maintenance_mode', 'off');
            $newMode = $current === 'on' ? 'off' : 'on';
            
            \App\Models\Setting::set('maintenance_mode', $newMode);
            
            // Log the action
            \Log::info('Maintenance mode toggled', [
                'admin_id' => auth()->id(),
                'admin_name' => auth()->user()->name,
                'previous_mode' => $current,
                'new_mode' => $newMode,
                'timestamp' => now()->toDateTimeString()
            ]);
            
            $message = $newMode === 'on' 
                ? 'Maintenance mode enabled. Site is now offline for regular users.'
                : 'Maintenance mode disabled. Site is now online for all users.';
            
            return response()->json([
                'success' => true,
                'message' => $message,
                'maintenance_mode' => $newMode,
                'status' => $newMode === 'on' ? 'offline' : 'online'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Failed to toggle maintenance mode', [
                'admin_id' => auth()->id(),
                'error' => $e->getMessage(),
                'timestamp' => now()->toDateTimeString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to toggle maintenance mode: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get system logs
     */
    public function getSystemLogs(Request $request)
    {
        try {
            $logs = [];
            $logFile = storage_path('logs/laravel.log');

            if (file_exists($logFile)) {
                $content = file_get_contents($logFile);
                $lines = explode("\n", $content);
                
                // Parse last 100 log entries
                $currentLog = null;
                $parsedLogs = [];
                
                foreach (array_reverse($lines) as $line) {
                    if (preg_match('/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\] \w+\.(\w+): (.+)$/', $line, $matches)) {
                        // New log entry
                        if ($currentLog) {
                            $parsedLogs[] = $currentLog;
                        }
                        
                        $currentLog = [
                            'timestamp' => $matches[1],
                            'level' => strtoupper($matches[2]),
                            'message' => $matches[3],
                            'context' => null
                        ];
                    } elseif ($currentLog && trim($line)) {
                        // Continuation of previous log
                        $currentLog['message'] .= "\n" . $line;
                    }
                    
                    if (count($parsedLogs) >= 100) {
                        break;
                    }
                }
                
                if ($currentLog) {
                    $parsedLogs[] = $currentLog;
                }
                
                $logs = array_reverse($parsedLogs);
            }

            return response()->json([
                'success' => true,
                'logs' => $logs,
                'file_exists' => file_exists($logFile),
                'file_size' => file_exists($logFile) ? filesize($logFile) : 0
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching system logs: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to load system logs',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clear system logs
     */
    public function clearSystemLogs(Request $request)
    {
        try {
            $logFile = storage_path('logs/laravel.log');
            
            if (file_exists($logFile)) {
                // Backup current log before clearing
                $backupFile = storage_path('logs/laravel_backup_' . date('Y-m-d_His') . '.log');
                copy($logFile, $backupFile);
                
                // Clear the log file
                file_put_contents($logFile, '');
                
                $userName = auth()->check() && auth()->user() ? auth()->user()->name : 'Unknown Admin';
                Log::info('System logs cleared by admin: ' . $userName);
                
                return response()->json([
                    'success' => true,
                    'message' => 'System logs cleared successfully',
                    'backup_file' => basename($backupFile)
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Log file not found'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error clearing system logs: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear system logs',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Optimize system performance
     */
    public function optimizeSystem(Request $request)
    {
        try {
            $startTime = microtime(true);
            $results = [];

            // 1. Clear application cache
            Artisan::call('cache:clear');
            $results[] = 'Application cache cleared';

            // 2. Clear config cache and recache
            Artisan::call('config:clear');
            Artisan::call('config:cache');
            $results[] = 'Configuration optimized';

            // 3. Clear route cache and try to recache (skip if duplicate routes exist)
            Artisan::call('route:clear');
            try {
                Artisan::call('route:cache');
                $results[] = 'Routes optimized';
            } catch (\Exception $e) {
                // Skip route caching if there are duplicate route names
                $results[] = 'Routes cleared (caching skipped due to duplicate route names)';
                Log::warning('Route caching skipped: ' . $e->getMessage());
            }

            // 4. Clear view cache
            Artisan::call('view:clear');
            $results[] = 'View cache cleared';

            // 5. Optimize autoloader (skip if route caching fails)
            try {
                Artisan::call('optimize');
                $results[] = 'Autoloader optimized';
            } catch (\Exception $e) {
                // Skip optimization if there are route issues
                $results[] = 'Autoloader optimization skipped (route conflicts detected)';
                Log::warning('Autoloader optimization skipped: ' . $e->getMessage());
            }

            // 6. Clear expired password reset tokens
            try {
                DB::table('password_reset_tokens')
                    ->where('created_at', '<', now()->subHours(24))
                    ->delete();
                $results[] = 'Expired tokens cleaned';
            } catch (\Exception $e) {
                // Table might not exist
                Log::warning('Token cleanup skipped: ' . $e->getMessage());
            }

            $duration = round(microtime(true) - $startTime, 2);

            // Log with safe user name retrieval
            $userName = auth()->check() && auth()->user() ? auth()->user()->name : 'Unknown Admin';
            Log::info('System optimization completed by admin: ' . $userName, [
                'duration' => $duration,
                'tasks' => count($results)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'System optimized successfully',
                'results' => $results,
                'tasks_completed' => count($results),
                'duration' => $duration
            ]);
        } catch (\Exception $e) {
            Log::error('Error optimizing system: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to optimize system',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clear system cache
     */
    public function clearCache(Request $request)
    {
        try {
            // Clear all cache types
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');

            $userName = auth()->check() && auth()->user() ? auth()->user()->name : 'Unknown Admin';
            Log::info('System cache cleared by admin: ' . $userName);

            return response()->json([
                'success' => true,
                'message' => 'All system cache cleared successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error clearing cache: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear cache',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * View system reports
     */
    public function viewReports()
    {
        $reports = \App\Models\SystemReport::orderBy('week_start_date', 'desc')
            ->paginate(10);
        
        return response()->json([
            'success' => true,
            'reports' => $reports
        ]);
    }

    /**
     * Get specific report data
     */
    public function getReportData($id)
    {
        try {
            $report = \App\Models\SystemReport::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'report' => $report
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Report not found'
            ], 404);
        }
    }

    /**
     * Generate report manually
     */
    public function generateReportManually(Request $request)
    {
        try {
            Artisan::call('report:weekly', ['--force' => true]);
            
            return response()->json([
                'success' => true,
                'message' => 'Report generated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Manual report generation failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate report',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download report as PDF
     */
    public function downloadReportPDF($id)
    {
        try {
            $report = \App\Models\SystemReport::findOrFail($id);
            
            // Generate PDF
            $pdf = \PDF::loadView('reports.weekly-report-pdf', compact('report'));
            
            // Set paper size and orientation
            $pdf->setPaper('a4', 'portrait');
            
            // Generate filename
            $filename = 'JOB-lyNK_Weekly_Report_' . 
                        $report->week_start_date->format('Y-m-d') . '_to_' . 
                        $report->week_end_date->format('Y-m-d') . '.pdf';
            
            // Save PDF path to database
            $pdfPath = 'reports/' . $filename;
            $report->update(['pdf_path' => $pdfPath]);
            
            // Return PDF download
            return $pdf->download($filename);
            
        } catch (\Exception $e) {
            Log::error('PDF generation failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate PDF',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * View report as PDF in browser
     */
    public function viewReportPDF($id)
    {
        try {
            $report = \App\Models\SystemReport::findOrFail($id);
            
            // Generate PDF
            $pdf = \PDF::loadView('reports.weekly-report-pdf', compact('report'));
            
            // Set paper size and orientation
            $pdf->setPaper('a4', 'portrait');
            
            // Stream PDF to browser
            return $pdf->stream('JOB-lyNK_Weekly_Report.pdf');
            
        } catch (\Exception $e) {
            Log::error('PDF view failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to view PDF',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
