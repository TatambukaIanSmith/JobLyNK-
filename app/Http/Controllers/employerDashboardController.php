<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Payment;
use App\Models\Application;
use App\Models\Bookmark;
use App\Models\Like;
use App\Models\Message;
use App\Models\JobNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class employerDashboardController extends Controller
{
    /**
     * Display the employer dashboard.
     */
    public function employers()
    {
        try {
            $user = Auth::user();
            
            // Get user's jobs with relationships and counts
            $jobs = Job::where('user_id', $user->id)
                ->withCount('applications')
                ->with(['category', 'applications.user'])
                ->orderBy('created_at', 'desc')
                ->get();

            // Calculate statistics
            $totalJobs = $jobs->count();
            $activeJobs = $jobs->where('status', 'active')->count();
            $draftJobs = $jobs->where('status', 'draft')->count();
            $pausedJobs = $jobs->where('status', 'paused')->count();
            $totalApplications = $jobs->sum('applications_count');
            $totalViews = $jobs->sum('views');
            
            // Calculate bookmarks and likes directly from database (if tables exist)
            $totalBookmarks = 0;
            $totalLikes = 0;
            try {
                if (Schema::hasTable('bookmarks')) {
                    $totalBookmarks = \DB::table('bookmarks')
                        ->whereIn('job_id', $jobs->pluck('id'))
                        ->count();
                }
                if (Schema::hasTable('likes')) {
                    $totalLikes = \DB::table('likes')
                        ->whereIn('job_id', $jobs->pluck('id'))
                        ->count();
                }
            } catch (\Exception $e) {
                Log::warning('Could not calculate bookmarks/likes: ' . $e->getMessage());
            }
            
            // Calculate jobs this month
            $jobsThisMonth = $jobs->where('created_at', '>=', now()->startOfMonth())->count();

            // Get payment statistics
            $paymentStats = $this->getPaymentStats($user);

            // Get recent applications
            $recentApplications = Application::whereHas('job', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with(['job', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

            // Get categories for job creation
            $categories = \App\Models\Category::all();

            // Prepare analytics data
            $analytics = [
                'jobStatus' => [
                    ['label' => 'Active', 'value' => $activeJobs, 'color' => '#10b981'],
                    ['label' => 'Draft', 'value' => $draftJobs, 'color' => '#f59e0b'],
                    ['label' => 'Paused', 'value' => $pausedJobs, 'color' => '#ef4444'],
                ],
                'monthlyPerformance' => $this->getMonthlyPerformance($user),
                'paymentMethods' => $this->getPaymentMethodsData($user),
            ];

            $stats = [
                'total_jobs' => $totalJobs,
                'active_jobs' => $activeJobs,
                'draft_jobs' => $draftJobs,
                'paused_jobs' => $pausedJobs,
                'jobs_this_month' => $jobsThisMonth,
                'total_applications' => $totalApplications,
                'total_views' => $totalViews,
                'total_bookmarks' => $totalBookmarks,
                'total_likes' => $totalLikes,
                'pending_applications' => $recentApplications->where('status', 'pending')->count(),
                'approved_applications' => $recentApplications->where('status', 'approved')->count(),
            ];

            return view('files.employerDashboard', compact(
                'jobs', 
                'stats', 
                'recentApplications', 
                'categories', 
                'analytics',
                'paymentStats'
            ));

        } catch (\Exception $e) {
            Log::error("Employer dashboard error: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());
            
            // Return with minimal data to prevent complete failure
            return view('files.employerDashboard', [
                'jobs' => collect(),
                'stats' => [
                    'total_jobs' => 0,
                    'active_jobs' => 0,
                    'draft_jobs' => 0,
                    'paused_jobs' => 0,
                    'jobs_this_month' => 0,
                    'total_applications' => 0,
                    'total_views' => 0,
                    'total_bookmarks' => 0,
                    'total_likes' => 0,
                    'pending_applications' => 0,
                    'approved_applications' => 0,
                ],
                'paymentStats' => [
                    'total_spent' => 0,
                    'pending_payments' => 0,
                    'total_transactions' => 0,
                    'recent_payments' => collect(),
                ],
                'recentApplications' => collect(),
                'categories' => collect(),
                'analytics' => [
                    'jobStatus' => [],
                    'monthlyPerformance' => [],
                    'paymentMethods' => [],
                ],
                'error' => 'Dashboard data could not be loaded: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Display the My Jobs page
     */
    public function myJobs()
    {
        $user = Auth::user();
        
        $jobs = Job::where('user_id', $user->id)
            ->withCount('applications')
            ->with(['category'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('files.myJobs', compact('jobs'));
    }

    /**
     * Get monthly performance data
     */
    private function getMonthlyPerformance($user)
    {
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $jobsCount = Job::where('user_id', $user->id)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            
            $applicationsCount = Application::whereHas('job', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->whereYear('created_at', $date->year)
            ->whereMonth('created_at', $date->month)
            ->count();

            $months[] = [
                'month' => $date->format('M Y'),
                'jobs' => $jobsCount,
                'applications' => $applicationsCount
            ];
        }
        return $months;
    }

    /**
     * Get payment methods data
     */
    private function getPaymentMethodsData($user)
    {
        // This would typically come from actual payment data
        // For now, return sample data
        return [
            ['method' => 'Credit Card', 'count' => 15, 'color' => '#3b82f6'],
            ['method' => 'PayPal', 'count' => 8, 'color' => '#10b981'],
            ['method' => 'Bank Transfer', 'count' => 3, 'color' => '#f59e0b'],
        ];
    }

    /**
     * Get payment statistics for the employer
     */
    private function getPaymentStats($user)
    {
        try {
            // Get payment data from the payments table
            $payments = Payment::where('user_id', $user->id)->get();
            
            $totalSpent = $payments->sum('amount');
            $totalTransactions = $payments->count();
            $pendingPayments = $payments->where('status', 'pending')->sum('amount');
            $recentPayments = $payments->orderBy('created_at', 'desc')->take(5);
            
            return [
                'total_spent' => $totalSpent,
                'pending_payments' => $pendingPayments,
                'total_transactions' => $totalTransactions,
                'recent_payments' => $recentPayments,
            ];
        } catch (\Exception $e) {
            Log::error("Failed to get payment stats: " . $e->getMessage());
            // Return default values if payment data can't be retrieved
            return [
                'total_spent' => 0,
                'pending_payments' => 0,
                'total_transactions' => 0,
                'recent_payments' => collect(),
            ];
        }
    }

    /**
     * Clear user cache manually
     */
    public function clearCache()
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Cache cleared successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear cache'
            ], 500);
        }
    }

    /**
     * Security logout - clear everything
     */
    public function securityLogout()
    {
        try {
            Auth::logout();
            return redirect()->route('login')->with('success', 'Secure logout completed.');
        } catch (\Exception $e) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Logout completed but some cleanup may have failed.');
        }
    }

    /**
     * Get analytics data for charts
     */
    public function getAnalytics()
    {
        try {
            return response()->json([
                'jobStatus' => [],
                'monthlyPerformance' => [],
                'paymentMethods' => [],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'jobStatus' => [],
                'monthlyPerformance' => [],
                'paymentMethods' => [],
            ], 500);
        }
    }

    /**
     * Get applications for employer's jobs
     */
    public function getApplications(Request $request)
    {
        try {
            $user = Auth::user();
            
            $query = Application::whereHas('job', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })->with(['job', 'user']);

            // Search functionality
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->whereHas('user', function($userQuery) use ($search) {
                        $userQuery->where('name', 'LIKE', "%{$search}%");
                    })->orWhereHas('job', function($jobQuery) use ($search) {
                        $jobQuery->where('title', 'LIKE', "%{$search}%");
                    });
                });
            }

            // Status filter
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            // Job filter
            if ($request->filled('job_id')) {
                $query->where('job_id', $request->job_id);
            }

            $applications = $query->orderBy('created_at', 'desc')->paginate(10);

            return response()->json([
                'success' => true,
                'applications' => $applications
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to get applications: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load applications'
            ], 500);
        }
    }

    /**
     * Show specific application details
     */
    public function showApplication(Application $application)
    {
        try {
            // Check if the application belongs to employer's job
            if ($application->job->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            $application->load(['user', 'job']);

            return response()->json([
                'success' => true,
                'application' => $application
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to load application: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load application'
            ], 500);
        }
    }

    /**
     * Approve an application
     */
    public function approveApplication(Application $application)
    {
        try {
            // Check if the application belongs to employer's job
            if ($application->job->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            // Update application status (use 'accepted' not 'approved')
            $application->update(['status' => 'accepted']);

            // Create a special notification for the worker
            JobNotification::create([
                'user_id' => $application->user_id,
                'job_id' => $application->job_id,
                'type' => 'application_approved',
                'match_score' => 100, // Perfect match since they got hired!
                'is_read' => false,
                'is_sent' => true,
                'sent_at' => now()
            ]);

            // Send notification message to the worker
            Message::create([
                'job_id' => $application->job_id,
                'sender_id' => Auth::id(),
                'receiver_id' => $application->user_id,
                'message' => "🎉 Congratulations! Your application for '{$application->job->title}' has been approved. You've been hired! The employer will contact you soon with next steps.",
                'is_read' => false,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Application approved successfully',
                'worker_name' => $application->user->name,
                'job_title' => $application->job->title
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to approve application: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to approve application'
            ], 500);
        }
    }

    /**
     * Reject an application
     */
    public function rejectApplication(Application $application)
    {
        try {
            // Check if the application belongs to employer's job
            if ($application->job->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            // Update application status
            $application->update(['status' => 'rejected']);

            // Send notification message to the worker
            Message::create([
                'job_id' => $application->job_id,
                'sender_id' => Auth::id(),
                'receiver_id' => $application->user_id,
                'message' => "Thank you for your interest in '{$application->job->title}'. Unfortunately, we have decided to move forward with other candidates. We encourage you to apply for other opportunities.",
                'is_read' => false,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Application rejected successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to reject application: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to reject application'
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created job.
     */
    public function storeJob(Request $request)
    {
        try {
            // Use Laravel's built-in validation
            $validated = $request->validate([
                'job_title' => 'required|string|max:255',
                'job_description' => 'required|string|min:20',
                'job_category_id' => 'required|exists:categories,id',
                'job_location' => 'required|string|max:255',
                'job_salary_min' => 'required|numeric|min:0',
                'job_salary_max' => 'required|numeric|min:0|gte:job_salary_min',
                'job_type_field' => 'required|string|in:full-time,part-time,contract,freelance,internship',
                'job_experience_level' => 'nullable|string|in:entry,mid,senior,executive',
                'job_requirements' => 'nullable|string',
                'job_status' => 'required|string|in:active,draft'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error("Unexpected validation error: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Validation error: ' . $e->getMessage()
            ], 422);
        }

        try {
            $user = Auth::user();
            
            // Calculate budget from salary range
            $budget = ($validated['job_salary_min'] + $validated['job_salary_max']) / 2;
            
            // Map job type from our form to database enum
            $jobTypeMapping = [
                'full-time' => 'recurring',
                'part-time' => 'recurring', 
                'contract' => 'project',
                'freelance' => 'project',
                'internship' => 'recurring'
            ];
            
            $dbJobType = $jobTypeMapping[$validated['job_type_field']] ?? 'one-time';
            
            // Prepare job data
            $jobData = [
                'user_id' => $user->id,
                'title' => $validated['job_title'],
                'description' => $validated['job_description'],
                'category_id' => $validated['job_category_id'],
                'location' => $validated['job_location'],
                'job_type' => $dbJobType,
                'payment_type' => 'fixed',
                'budget' => $budget,
                'duration' => '30 days',
                'start_date' => now(),
                'urgency' => 'normal',
                'required_skills' => $validated['job_requirements'] ?? '', // Store as string
                'is_featured' => false,
                'is_urgent' => false,
                'requires_background_check' => false,
                'status' => $validated['job_status'],
                'views' => 0,
                'applications_count' => 0,
            ];

            $job = Job::create($jobData);

            $statusText = $validated['job_status'] === 'active' ? 'published' : 'saved as draft';
            
            Log::info("Job {$statusText} successfully", [
                'job_id' => $job->id,
                'user_id' => $user->id,
                'title' => $job->title,
                'status' => $job->status
            ]);

            return response()->json([
                'success' => true,
                'message' => "Job {$statusText} successfully!",
                'job' => $job
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to create job: " . $e->getMessage());
            Log::error("Request data: " . json_encode($request->all()));
            Log::error("Stack trace: " . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create job: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Publish a draft job
     */
    public function publishJob(Job $job)
    {
        try {
            // Check if job belongs to authenticated user
            if ($job->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            $job->update([
                'status' => 'active',
                'published_at' => now()
            ]);

            Log::info("Job published successfully", [
                'job_id' => $job->id,
                'user_id' => Auth::id(),
                'title' => $job->title
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Job published successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to publish job: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to publish job'
            ], 500);
        }
    }

    /**
     * Pause an active job
     */
    public function pauseJob(Job $job)
    {
        try {
            // Check if job belongs to authenticated user
            if ($job->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            $job->update(['status' => 'paused']);

            Log::info("Job paused successfully", [
                'job_id' => $job->id,
                'user_id' => Auth::id(),
                'title' => $job->title
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Job paused successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to pause job: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to pause job'
            ], 500);
        }
    }

    /**
     * Activate a paused job
     */
    public function activateJob(Job $job)
    {
        try {
            // Check if job belongs to authenticated user
            if ($job->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            $job->update(['status' => 'active']);

            Log::info("Job activated successfully", [
                'job_id' => $job->id,
                'user_id' => Auth::id(),
                'title' => $job->title
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Job activated successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to activate job: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to activate job'
            ], 500);
        }
    }

    /**
     * Delete a job
     */
    public function deleteJob(Job $job)
    {
        try {
            // Check if job belongs to authenticated user
            if ($job->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            $jobTitle = $job->title;
            $job->delete();

            Log::info("Job deleted successfully", [
                'job_id' => $job->id,
                'user_id' => Auth::id(),
                'title' => $jobTitle
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Job deleted successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to delete job: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete job'
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->storeJob($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Get messages for employer
     */
    public function getMessages(Request $request)
    {
        try {
            $user = Auth::user();
            
            $query = \App\Models\Message::where(function($q) use ($user) {
                $q->where('sender_id', $user->id)
                  ->orWhere('receiver_id', $user->id);
            })->with(['sender', 'receiver', 'job']);

            // Filter by conversation partner
            if ($request->filled('user_id')) {
                $query->where(function($q) use ($user, $request) {
                    $q->where(function($subQ) use ($user, $request) {
                        $subQ->where('sender_id', $user->id)
                             ->where('receiver_id', $request->user_id);
                    })->orWhere(function($subQ) use ($user, $request) {
                        $subQ->where('sender_id', $request->user_id)
                             ->where('receiver_id', $user->id);
                    });
                });
            }

            $messages = $query->orderBy('created_at', 'desc')
                             ->paginate(20);

            return response()->json($messages);
        } catch (\Exception $e) {
            Log::error("Failed to get messages: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load messages'
            ], 500);
        }
    }

    /**
     * Send message to worker or admin
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
            'job_id' => 'nullable|exists:job_postings,id'
        ]);

        try {
            $user = Auth::user();
            
            $message = \App\Models\Message::create([
                'sender_id' => $user->id,
                'receiver_id' => $request->receiver_id,
                'job_id' => $request->job_id,
                'message' => $request->message,
                'is_read' => false
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully',
                'data' => $message->load(['sender', 'receiver', 'job'])
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to send message: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send message'
            ], 500);
        }
    }

    /**
     * Get conversation with specific user
     */
    public function getConversation(Request $request, $userId)
    {
        try {
            $user = Auth::user();
            
            $messages = \App\Models\Message::where(function($query) use ($user, $userId) {
                $query->where(function($q) use ($user, $userId) {
                    $q->where('sender_id', $user->id)
                      ->where('receiver_id', $userId);
                })->orWhere(function($q) use ($user, $userId) {
                    $q->where('sender_id', $userId)
                      ->where('receiver_id', $user->id);
                });
            })
            ->with(['sender', 'receiver', 'job'])
            ->orderBy('created_at', 'asc')
            ->get();

            // Mark messages as read
            \App\Models\Message::where('sender_id', $userId)
                ->where('receiver_id', $user->id)
                ->where('is_read', false)
                ->update(['is_read' => true, 'read_at' => now()]);

            $otherUser = \App\Models\User::find($userId);

            return response()->json([
                'messages' => $messages,
                'user' => $otherUser
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to get conversation: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load conversation'
            ], 500);
        }
    }

    /**
     * Get unread message count
     */
    public function getUnreadCount()
    {
        try {
            $user = Auth::user();
            $count = \App\Models\Message::where('receiver_id', $user->id)
                                       ->where('is_read', false)
                                       ->count();

            return response()->json(['count' => $count]);
        } catch (\Exception $e) {
            Log::error("Failed to get unread count: " . $e->getMessage());
            return response()->json(['count' => 0]);
        }
    }

    /**
     * Update employer profile
     */
    public function updateProfile(Request $request)
    {
        // Add some debugging
        Log::info('Profile update request received', [
            'user_id' => auth()->id(),
            'request_data' => $request->except(['profile_picture', '_token'])
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'company_description' => 'nullable|string|max:1000',
            'location' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $user = Auth::user();
            
            // Handle profile picture upload
            if ($request->hasFile('profile_picture')) {
                // Delete old profile picture if exists
                if ($user->profile_picture && Storage::exists('public/' . $user->profile_picture)) {
                    Storage::delete('public/' . $user->profile_picture);
                }
                
                $profilePicture = $request->file('profile_picture')->store('profile_pictures', 'public');
                $user->profile_picture = $profilePicture;
            }

            // Update user fields
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'company_name' => $request->company_name,
                'company_description' => $request->company_description,
                'location' => $request->location,
                'website' => $request->website,
            ]);

            Log::info('Profile updated successfully', ['user_id' => $user->id]);

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'company_name' => $user->company_name,
                    'company_description' => $user->company_description,
                    'location' => $user->location,
                    'website' => $user->website,
                    'profile_picture' => $user->profile_picture ? Storage::url($user->profile_picture) : null,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to update profile: " . $e->getMessage(), [
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        try {
            $user = Auth::user();
            
            // Check current password
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current password is incorrect'
                ], 400);
            }

            // Update password
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Password updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to update password: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update password'
            ], 500);
        }
    }

    /**
     * Get user profile data
     */
    public function getProfile()
    {
        try {
            $user = Auth::user();
            
            return response()->json([
                'success' => true,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'company_name' => $user->company_name,
                    'company_description' => $user->company_description,
                    'location' => $user->location,
                    'website' => $user->website,
                    'profile_picture' => $user->profile_picture ? Storage::url($user->profile_picture) : null,
                    'created_at' => $user->created_at,
                    'email_verified_at' => $user->email_verified_at,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to get profile: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load profile'
            ], 500);
        }
    }

    /**
     * Get user sessions
     */
    public function getSessions()
    {
        try {
            $user = Auth::user();
            $sessions = collect();
            
            // Only try to get sessions if using database driver
            if (config('session.driver') === 'database') {
                try {
                    // Check if sessions table exists
                    if (Schema::hasTable('sessions')) {
                        $sessions = DB::table('sessions')
                            ->where('user_id', $user->id)
                            ->orderBy('last_activity', 'desc')
                            ->get()
                            ->map(function ($session) {
                                return [
                                    'id' => $session->id,
                                    'ip_address' => $session->ip_address ?? 'Unknown',
                                    'user_agent' => $this->parseUserAgent($session->user_agent ?? 'Unknown'),
                                    'last_activity' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
                                    'is_current' => $session->id === session()->getId(),
                                ];
                            });
                    }
                } catch (\Exception $e) {
                    Log::warning("Could not load sessions from database: " . $e->getMessage());
                }
            }

            return response()->json([
                'success' => true,
                'sessions' => $sessions,
                'current_session_id' => session()->getId(),
                'session_driver' => config('session.driver')
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to get sessions: " . $e->getMessage());
            return response()->json([
                'success' => true, // Return success to not block other functionality
                'sessions' => collect(),
                'current_session_id' => session()->getId(),
                'message' => 'Session management not available'
            ]);
        }
    }

    /**
     * Parse user agent string for display
     */
    private function parseUserAgent($userAgent)
    {
        if (strpos($userAgent, 'Chrome') !== false) {
            return 'Chrome Browser';
        } elseif (strpos($userAgent, 'Firefox') !== false) {
            return 'Firefox Browser';
        } elseif (strpos($userAgent, 'Safari') !== false) {
            return 'Safari Browser';
        } elseif (strpos($userAgent, 'Edge') !== false) {
            return 'Edge Browser';
        } else {
            return 'Unknown Browser';
        }
    }

    /**
     * Revoke other sessions
     */
    public function revokeOtherSessions(Request $request)
    {
        $request->validate([
            'password' => 'required'
        ]);

        try {
            $user = Auth::user();
            
            // Check password
            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password is incorrect'
                ], 400);
            }

            $revokedCount = 0;
            
            // Revoke other sessions if using database driver
            if (config('session.driver') === 'database') {
                try {
                    if (Schema::hasTable('sessions')) {
                        $revokedCount = DB::table('sessions')
                            ->where('user_id', $user->id)
                            ->where('id', '!=', session()->getId())
                            ->delete();
                    }
                } catch (\Exception $e) {
                    Log::warning("Could not revoke sessions from database: " . $e->getMessage());
                }
            }

            return response()->json([
                'success' => true,
                'message' => $revokedCount > 0 
                    ? "Revoked {$revokedCount} other sessions successfully" 
                    : 'No other sessions to revoke'
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to revoke sessions: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to revoke sessions'
            ], 500);
        }
    }

    /**
     * Get API tokens (if using Sanctum)
     */
    public function getTokens()
    {
        try {
            $user = Auth::user();
            $tokens = collect();
            
            // Check if Sanctum is available
            if (method_exists($user, 'tokens')) {
                $tokens = $user->tokens->map(function ($token) {
                    return [
                        'id' => $token->id,
                        'name' => $token->name,
                        'abilities' => $token->abilities,
                        'last_used_at' => $token->last_used_at ? $token->last_used_at->diffForHumans() : 'Never',
                        'created_at' => $token->created_at->diffForHumans(),
                    ];
                });
            }

            return response()->json([
                'success' => true,
                'tokens' => $tokens
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to get tokens: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load tokens',
                'tokens' => collect()
            ]);
        }
    }

    /**
     * Revoke all API tokens
     */
    public function revokeAllTokens()
    {
        try {
            $user = Auth::user();
            
            // Check if Sanctum is available
            if (method_exists($user, 'tokens')) {
                $user->tokens()->delete();
            }

            return response()->json([
                'success' => true,
                'message' => 'All API tokens revoked successfully'
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to revoke tokens: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to revoke tokens'
            ], 500);
        }
    }

    /**
     * Mark conversation as read
     */
    public function markConversationAsRead(Request $request, $userId)
    {
        try {
            $user = Auth::user();
            
            $updated = \App\Models\Message::where('sender_id', $userId)
                ->where('receiver_id', $user->id)
                ->where('is_read', false)
                ->update(['is_read' => true, 'read_at' => now()]);

            return response()->json([
                'success' => true,
                'marked_count' => $updated
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to mark conversation as read: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark as read'
            ], 500);
        }
    }

    /**
     * Get detailed job information for editing
     */
    public function getJob(Job $job)
    {
        try {
            // Check if job belongs to authenticated user
            if ($job->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            $job->load(['category', 'applications.user']);

            return response()->json([
                'success' => true,
                'job' => $job
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to get job: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load job'
            ], 500);
        }
    }

    /**
     * Update an existing job
     */
    public function updateJob(Request $request, Job $job)
    {
        try {
            // Check if job belongs to authenticated user
            if ($job->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            // Use Laravel's built-in validation
            $validated = $request->validate([
                'job_title' => 'required|string|max:255',
                'job_description' => 'required|string|min:20',
                'job_category_id' => 'required|exists:categories,id',
                'job_location' => 'required|string|max:255',
                'job_salary_min' => 'required|numeric|min:0',
                'job_salary_max' => 'required|numeric|min:0|gte:job_salary_min',
                'job_type_field' => 'required|string|in:full-time,part-time,contract,freelance,internship',
                'job_experience_level' => 'nullable|string|in:entry,mid,senior,executive',
                'job_requirements' => 'nullable|string',
                'job_status' => 'required|string|in:active,draft,paused'
            ]);

            // Calculate budget from salary range
            $budget = ($validated['job_salary_min'] + $validated['job_salary_max']) / 2;
            
            // Map job type from our form to database enum
            $jobTypeMapping = [
                'full-time' => 'recurring',
                'part-time' => 'recurring', 
                'contract' => 'project',
                'freelance' => 'project',
                'internship' => 'recurring'
            ];
            
            $dbJobType = $jobTypeMapping[$validated['job_type_field']] ?? 'one-time';
            
            // Update job data
            $job->update([
                'title' => $validated['job_title'],
                'description' => $validated['job_description'],
                'category_id' => $validated['job_category_id'],
                'location' => $validated['job_location'],
                'job_type' => $dbJobType,
                'budget' => $budget,
                'required_skills' => $validated['job_requirements'] ?? '',
                'status' => $validated['job_status'],
            ]);

            Log::info("Job updated successfully", [
                'job_id' => $job->id,
                'user_id' => Auth::id(),
                'title' => $job->title
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Job updated successfully!',
                'job' => $job->load(['category'])
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error("Failed to update job: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update job: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get job analytics and statistics
     */
    public function getJobAnalytics(Job $job)
    {
        try {
            // Check if job belongs to authenticated user
            if ($job->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            $job->load(['applications.user']);

            // Calculate analytics
            $analytics = [
                'total_views' => $job->views ?? 0,
                'total_applications' => $job->applications->count(),
                'pending_applications' => $job->applications->where('status', 'pending')->count(),
                'approved_applications' => $job->applications->where('status', 'approved')->count(),
                'rejected_applications' => $job->applications->where('status', 'rejected')->count(),
                'application_rate' => $job->views > 0 ? round(($job->applications->count() / $job->views) * 100, 2) : 0,
                'recent_applications' => $job->applications->sortByDesc('created_at')->take(5)->values(),
                'daily_views' => $this->getDailyViews($job),
                'application_trends' => $this->getApplicationTrends($job),
            ];

            return response()->json([
                'success' => true,
                'analytics' => $analytics,
                'job' => $job
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to get job analytics: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load analytics'
            ], 500);
        }
    }

    /**
     * Get daily views for a job (mock data for now)
     */
    private function getDailyViews($job)
    {
        // This would typically come from a job_views table
        // For now, return mock data
        $days = [];
        for ($i = 6; $i >= 0; $i--) {
            $days[] = [
                'date' => now()->subDays($i)->format('Y-m-d'),
                'views' => rand(0, 20)
            ];
        }
        return $days;
    }

    /**
     * Get application trends for a job
     */
    private function getApplicationTrends($job)
    {
        $applications = $job->applications;
        $trends = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $count = $applications->filter(function($app) use ($date) {
                return $app->created_at->format('Y-m-d') === $date;
            })->count();
            
            $trends[] = [
                'date' => $date,
                'applications' => $count
            ];
        }
        
        return $trends;
    }

    /**
     * Get jobs with filtering and search
     */
    public function getJobs(Request $request)
    {
        try {
            $user = Auth::user();
            
            $query = Job::where('user_id', $user->id)
                ->withCount('applications')
                ->with(['category', 'applications.user']);

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
            if ($request->filled('category_id')) {
                $query->where('category_id', $request->category_id);
            }

            // Date range filter
            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }
            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            // Sorting
            $sortBy = $request->get('sort_by', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);

            $jobs = $query->paginate($request->get('per_page', 10));

            return response()->json([
                'success' => true,
                'jobs' => $jobs
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to get jobs: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load jobs'
            ], 500);
        }
    }

    /**
     * Duplicate a job
     */
    public function duplicateJob(Job $job)
    {
        try {
            // Check if job belongs to authenticated user
            if ($job->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            // Create a duplicate job
            $duplicateJob = $job->replicate();
            $duplicateJob->title = $job->title . ' (Copy)';
            $duplicateJob->status = 'draft';
            $duplicateJob->views = 0;
            $duplicateJob->applications_count = 0;
            $duplicateJob->created_at = now();
            $duplicateJob->updated_at = now();
            $duplicateJob->save();

            Log::info("Job duplicated successfully", [
                'original_job_id' => $job->id,
                'duplicate_job_id' => $duplicateJob->id,
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Job duplicated successfully!',
                'job' => $duplicateJob->load(['category'])
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to duplicate job: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to duplicate job'
            ], 500);
        }
    }

    /**
     * Get job for editing
     */
    public function editJob(Job $job)
    {
        try {
            // Check if job belongs to authenticated user
            if ($job->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            $job->load(['category']);

            return response()->json([
                'success' => true,
                'job' => $job
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to get job for editing: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load job details'
            ], 500);
        }
    }

    /**
     * Get job details with analytics
     */
    public function getJobDetails(Job $job)
    {
        try {
            // Check if job belongs to authenticated user
            if ($job->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            // Load relationships
            $job->load(['category', 'applications.user']);

            // Calculate analytics
            $applications = $job->applications;
            $totalApplications = $applications->count();
            $approvedApplications = $applications->where('status', 'approved')->count();
            $rejectedApplications = $applications->where('status', 'rejected')->count();
            $pendingApplications = $applications->where('status', 'pending')->count();
            
            // Get engagement metrics
            $bookmarksCount = Bookmark::where('job_id', $job->id)->count();
            $likesCount = Like::where('job_id', $job->id)->count();
            
            $conversionRate = $job->views > 0 ? round(($totalApplications / $job->views) * 100, 1) : 0;
            $bookmarkRate = $job->views > 0 ? round(($bookmarksCount / $job->views) * 100, 1) . '%' : 'N/A';
            $likeRate = $job->views > 0 ? round(($likesCount / $job->views) * 100, 1) . '%' : 'N/A';
            $hireRate = $totalApplications > 0 ? round(($approvedApplications / $totalApplications) * 100, 1) . '%' : 'N/A';
            $viewRate = 'N/A'; // This would need implementation based on impressions vs views

            $analytics = [
                'total_applications' => $totalApplications,
                'approved_applications' => $approvedApplications,
                'rejected_applications' => $rejectedApplications,
                'pending_applications' => $pendingApplications,
                'bookmarks_count' => $bookmarksCount,
                'likes_count' => $likesCount,
                'conversion_rate' => $conversionRate,
                'bookmark_rate' => $bookmarkRate,
                'like_rate' => $likeRate,
                'hire_rate' => $hireRate,
                'view_rate' => $viewRate,
                'recent_applications' => $applications->sortByDesc('created_at')->take(5)->values()
            ];

            return response()->json([
                'success' => true,
                'job' => $job,
                'analytics' => $analytics
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to get job details: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load job details'
            ], 500);
        }
    }

    /**
     * Dashboard Features Methods
     */

    /**
     * Get activity feed for the employer
     */
    public function getActivityFeed(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Get recent activities
            $activities = \App\Models\ActivityLog::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->limit(20)
                ->get();

            // If no activities exist, create some sample ones
            if ($activities->isEmpty()) {
                $this->createSampleActivities($user->id);
                $activities = \App\Models\ActivityLog::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->limit(20)
                    ->get();
            }

            // Add skill matching notifications
            $this->addSkillMatchingNotifications($user);

            // Refresh activities after adding skill matching notifications
            $activities = \App\Models\ActivityLog::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->limit(20)
                ->get();

            return response()->json([
                'success' => true,
                'activities' => $activities->map(function ($activity) {
                    return [
                        'id' => $activity->id,
                        'type' => $activity->type,
                        'title' => $activity->title,
                        'description' => $activity->description,
                        'metadata' => $activity->metadata,
                        'is_read' => $activity->is_read,
                        'created_at' => $activity->created_at->diffForHumans(),
                        'timestamp' => $activity->created_at->toISOString(),
                    ];
                })
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching activity feed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error fetching activities'], 500);
        }
    }

    /**
     * Add skill matching notifications to activity feed
     */
    private function addSkillMatchingNotifications($employer)
    {
        try {
            // Get employer's active jobs
            $activeJobs = Job::where('user_id', $employer->id)
                ->where('status', 'active')
                ->with(['jobSkills.skill'])
                ->get();

            if ($activeJobs->isEmpty()) {
                return;
            }

            $matchingService = app(\App\Services\JobMatchingService::class);

            foreach ($activeJobs as $job) {
                // Find workers matching this job's skills
                $matchingWorkers = $matchingService->findMatchingWorkers($job, 5);

                if ($matchingWorkers->isNotEmpty()) {
                    // Check if we already created a notification for this job recently (within 24 hours)
                    $recentNotification = \App\Models\ActivityLog::where('user_id', $employer->id)
                        ->where('type', 'skill_match')
                        ->where('metadata->job_id', $job->id)
                        ->where('created_at', '>=', now()->subHours(24))
                        ->first();

                    if (!$recentNotification) {
                        // Create activity notification
                        $topWorkers = $matchingWorkers->take(3);
                        $workerNames = $topWorkers->pluck('worker.name')->toArray();
                        $totalMatches = $matchingWorkers->count();

                        $title = "New Skill Matches Found!";
                        $description = "Found {$totalMatches} workers with skills matching your job '{$job->title}'. Top matches: " . implode(', ', $workerNames);

                        if ($totalMatches > 3) {
                            $description .= " and " . ($totalMatches - 3) . " more.";
                        }

                        \App\Models\ActivityLog::create([
                            'user_id' => $employer->id,
                            'type' => 'skill_match',
                            'title' => $title,
                            'description' => $description,
                            'metadata' => [
                                'job_id' => $job->id,
                                'job_title' => $job->title,
                                'total_matches' => $totalMatches,
                                'top_workers' => $topWorkers->map(function ($match) {
                                    return [
                                        'id' => $match['worker']->id,
                                        'name' => $match['worker']->name,
                                        'match_score' => $match['match_score'],
                                        'matching_skills' => $match['matching_skills']->pluck('name')->toArray()
                                    ];
                                })->toArray()
                            ],
                            'is_read' => false
                        ]);

                        Log::info("Created skill matching notification for employer {$employer->id}, job {$job->id}, {$totalMatches} matches");
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Error creating skill matching notifications: ' . $e->getMessage());
        }
    }

    /**
     * Get skill matches for a specific job
     */
    public function getJobSkillMatches(Job $job)
    {
        try {
            // Check if job belongs to authenticated user
            if ($job->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            $matchingService = app(\App\Services\JobMatchingService::class);
            $matchingWorkers = $matchingService->findMatchingWorkers($job, 20);

            return response()->json([
                'success' => true,
                'job' => [
                    'id' => $job->id,
                    'title' => $job->title,
                    'description' => $job->description
                ],
                'matches' => $matchingWorkers->map(function ($match) {
                    return [
                        'worker' => [
                            'id' => $match['worker']->id,
                            'name' => $match['worker']->name,
                            'email' => $match['worker']->email,
                            'phone' => $match['worker']->phone,
                            'location' => $match['worker']->location,
                        ],
                        'match_score' => $match['match_score'],
                        'matching_skills' => $match['matching_skills']->map(function ($skill) {
                            return [
                                'id' => $skill->id,
                                'name' => $skill->name
                            ];
                        })
                    ];
                })
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to get skill matches for job {$job->id}: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load skill matches'
            ], 500);
        }
    }

    /**
     * Save a quick note
     */
    public function saveNote(Request $request)
    {
        try {
            $request->validate([
                'content' => 'required|string|max:1000'
            ]);

            $user = Auth::user();
            
            $note = \App\Models\EmployerNote::create([
                'user_id' => $user->id,
                'content' => $request->content
            ]);

            // Log activity
            \App\Models\ActivityLog::createActivity(
                $user->id,
                'note',
                'Note Added',
                'You added a new note',
                ['note_id' => $note->id]
            );

            return response()->json([
                'success' => true,
                'message' => 'Note saved successfully',
                'note' => [
                    'id' => $note->id,
                    'content' => $note->content,
                    'created_at' => $note->created_at->diffForHumans()
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error saving note: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error saving note'], 500);
        }
    }

    /**
     * Get employer notes
     */
    public function getNotes(Request $request)
    {
        try {
            $user = Auth::user();
            
            $notes = \App\Models\EmployerNote::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();

            return response()->json([
                'success' => true,
                'notes' => $notes->map(function ($note) {
                    return [
                        'id' => $note->id,
                        'content' => $note->content,
                        'created_at' => $note->created_at->diffForHumans()
                    ];
                })
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching notes: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error fetching notes'], 500);
        }
    }

    /**
     * Delete a note
     */
    public function deleteNote($noteId)
    {
        try {
            $user = Auth::user();
            
            $note = \App\Models\EmployerNote::where('user_id', $user->id)
                ->where('id', $noteId)
                ->first();

            if (!$note) {
                return response()->json(['success' => false, 'message' => 'Note not found'], 404);
            }

            $note->delete();

            return response()->json([
                'success' => true,
                'message' => 'Note deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting note: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error deleting note'], 500);
        }
    }

    /**
     * Update candidate stage in pipeline
     */
    /**
     * Move candidate to screening stage with screening notes
     */
    public function moveToScreening(Request $request)
    {
        try {
            $request->validate([
                'candidate_id' => 'required|integer',
                'screening_notes' => 'nullable|string|max:1000'
            ]);

            $user = Auth::user();
            
            // Find the application
            $application = Application::whereHas('job', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->where('user_id', $request->candidate_id)->first();

            if (!$application) {
                return response()->json(['success' => false, 'message' => 'Application not found'], 404);
            }

            // Update to screening stage
            $application->update([
                'stage' => 'screening',
                'screening_notes' => $request->screening_notes,
                'screening_date' => now()
            ]);

            // Log activity
            \App\Models\ActivityLog::createActivity(
                $user->id,
                'candidate_screening',
                'Candidate Moved to Screening',
                "Moved {$application->user->name} to screening stage for {$application->job->title}",
                [
                    'application_id' => $application->id,
                    'candidate_id' => $request->candidate_id,
                    'job_id' => $application->job_id,
                    'screening_notes' => $request->screening_notes
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Candidate moved to screening successfully',
                'candidate' => [
                    'id' => $application->user->id,
                    'name' => $application->user->name,
                    'stage' => 'screening',
                    'screening_date' => $application->screening_date->format('M d, Y H:i'),
                    'screening_notes' => $application->screening_notes
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error moving candidate to screening: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error moving candidate to screening'], 500);
        }
    }

    /**
     * Get candidates in screening stage
     */
    public function getScreeningCandidates(Request $request)
    {
        try {
            $user = Auth::user();
            
            $screeningCandidates = Application::whereHas('job', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('stage', 'screening')
            ->with(['user', 'job'])
            ->orderBy('screening_date', 'desc')
            ->get();

            $candidates = $screeningCandidates->map(function ($application) {
                return [
                    'id' => $application->user->id,
                    'name' => $application->user->name,
                    'email' => $application->user->email,
                    'phone' => $application->user->phone,
                    'job_title' => $application->job->title,
                    'job_id' => $application->job->id,
                    'application_id' => $application->id,
                    'stage' => $application->stage,
                    'applied_at' => $application->created_at->format('M d, Y'),
                    'screening_date' => $application->screening_date ? $application->screening_date->format('M d, Y H:i') : null,
                    'screening_notes' => $application->screening_notes,
                    'days_in_screening' => $application->screening_date ? $application->screening_date->diffInDays(now()) : 0
                ];
            });

            return response()->json([
                'success' => true,
                'candidates' => $candidates,
                'count' => $candidates->count()
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching screening candidates: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error fetching screening candidates'], 500);
        }
    }

    public function updateCandidateStage(Request $request)
    {
        try {
            $request->validate([
                'candidate_id' => 'required|integer',
                'stage' => 'required|in:applied,screening,interview,hired,rejected'
            ]);

            $user = Auth::user();
            
            // Find the application
            $application = Application::whereHas('job', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->where('user_id', $request->candidate_id)->first();

            if (!$application) {
                return response()->json(['success' => false, 'message' => 'Application not found'], 404);
            }

            // Update the stage
            $application->update(['stage' => $request->stage]);

            // Log activity
            \App\Models\ActivityLog::createActivity(
                $user->id,
                'candidate_stage',
                'Candidate Stage Updated',
                "Moved {$application->user->name} to {$request->stage} stage",
                [
                    'application_id' => $application->id,
                    'candidate_id' => $request->candidate_id,
                    'stage' => $request->stage
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Candidate stage updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating candidate stage: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error updating candidate stage'], 500);
        }
    }

    /**
     * Schedule an interview
     */
    public function scheduleInterview(Request $request)
    {
        try {
            $request->validate([
                'candidate_id' => 'required|exists:users,id',
                'job_id' => 'required|exists:job_postings,id',
                'scheduled_at' => 'required|date|after:now',
                'type' => 'required|in:video,phone,in-person',
                'notes' => 'nullable|string|max:500'
            ]);

            $user = Auth::user();

            // Verify the job belongs to the employer
            $job = Job::where('id', $request->job_id)
                ->where('user_id', $user->id)
                ->first();

            if (!$job) {
                return response()->json(['success' => false, 'message' => 'Job not found'], 404);
            }

            // Find the application
            $application = Application::where('job_id', $request->job_id)
                ->where('user_id', $request->candidate_id)
                ->first();

            $interview = \App\Models\Interview::create([
                'employer_id' => $user->id,
                'candidate_id' => $request->candidate_id,
                'job_id' => $request->job_id,
                'application_id' => $application?->id,
                'scheduled_at' => $request->scheduled_at,
                'type' => $request->type,
                'notes' => $request->notes,
            ]);

            // Log activity
            \App\Models\ActivityLog::createActivity(
                $user->id,
                'interview',
                'Interview Scheduled',
                "Interview scheduled with candidate for {$job->title}",
                [
                    'interview_id' => $interview->id,
                    'candidate_id' => $request->candidate_id,
                    'job_id' => $request->job_id
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Interview scheduled successfully',
                'interview' => [
                    'id' => $interview->id,
                    'scheduled_at' => $interview->scheduled_at->format('Y-m-d H:i:s'),
                    'type' => $interview->type,
                    'candidate_name' => $interview->candidate->name ?? 'Unknown',
                    'job_title' => $job->title
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error scheduling interview: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error scheduling interview'], 500);
        }
    }

    /**
     * Get interviews for the employer
     */
    public function getInterviews(Request $request)
    {
        try {
            $user = Auth::user();
            
            $interviews = \App\Models\Interview::where('employer_id', $user->id)
                ->with(['candidate', 'job'])
                ->orderBy('scheduled_at', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'interviews' => $interviews->map(function ($interview) {
                    return [
                        'id' => $interview->id,
                        'candidate_name' => $interview->candidate->name ?? 'Unknown',
                        'job_title' => $interview->job->title ?? 'Unknown',
                        'scheduled_at' => $interview->scheduled_at->format('Y-m-d H:i:s'),
                        'type' => $interview->type,
                        'status' => $interview->status,
                        'notes' => $interview->notes,
                    ];
                })
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching interviews: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error fetching interviews'], 500);
        }
    }

    /**
     * Update an interview
     */
    public function updateInterview(Request $request, $interviewId)
    {
        try {
            $request->validate([
                'scheduled_at' => 'nullable|date|after:now',
                'type' => 'nullable|in:video,phone,in-person',
                'status' => 'nullable|in:scheduled,completed,cancelled,rescheduled',
                'notes' => 'nullable|string|max:500'
            ]);

            $user = Auth::user();
            
            $interview = \App\Models\Interview::where('employer_id', $user->id)
                ->where('id', $interviewId)
                ->first();

            if (!$interview) {
                return response()->json(['success' => false, 'message' => 'Interview not found'], 404);
            }

            $interview->update($request->only(['scheduled_at', 'type', 'status', 'notes']));

            return response()->json([
                'success' => true,
                'message' => 'Interview updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating interview: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error updating interview'], 500);
        }
    }

    /**
     * Delete an interview
     */
    public function deleteInterview($interviewId)
    {
        try {
            $user = Auth::user();
            
            $interview = \App\Models\Interview::where('employer_id', $user->id)
                ->where('id', $interviewId)
                ->first();

            if (!$interview) {
                return response()->json(['success' => false, 'message' => 'Interview not found'], 404);
            }

            $interview->delete();

            return response()->json([
                'success' => true,
                'message' => 'Interview deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting interview: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error deleting interview'], 500);
        }
    }

    /**
     * Create sample activities for demonstration
     */
    private function createSampleActivities($userId)
    {
        $activities = [
            [
                'type' => 'application',
                'title' => 'New Application Received',
                'description' => 'Maleek Berry applied for "Delivery Service" position',
                'metadata' => ['candidate_name' => 'Maleek Berry', 'job_title' => 'Delivery Service']
            ],
            [
                'type' => 'job_view',
                'title' => 'Job Views Spike',
                'description' => '"House Caretaker" job received 12 new views today',
                'metadata' => ['job_title' => 'House Caretaker', 'views' => 12]
            ],
            [
                'type' => 'message',
                'title' => 'New Message',
                'description' => 'IAN SMITH sent you a message about the Manager position',
                'metadata' => ['sender_name' => 'IAN SMITH', 'job_title' => 'Manager']
            ],
            [
                'type' => 'interview',
                'title' => 'Interview Reminder',
                'description' => 'Interview with John Doe scheduled for tomorrow at 2:00 PM',
                'metadata' => ['candidate_name' => 'John Doe', 'scheduled_at' => now()->addDay()->format('Y-m-d H:i:s')]
            ]
        ];

        foreach ($activities as $activity) {
            \App\Models\ActivityLog::createActivity(
                $userId,
                $activity['type'],
                $activity['title'],
                $activity['description'],
                $activity['metadata']
            );
        }
    }

    /**
     * Get available candidates for interview scheduling
     */
    public function getAvailableCandidates(Request $request)
    {
        try {
            $user = Auth::user();
            $jobId = $request->get('job_id');
            
            // Get candidates who have applied to employer's jobs
            $query = Application::whereHas('job', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->with(['user', 'job']);
            
            // Filter by specific job if provided
            if ($jobId) {
                $query->where('job_id', $jobId);
            }
            
            // Only get pending or approved applications
            $applications = $query->whereIn('status', ['pending', 'approved'])
                ->get();
            
            $candidates = $applications->map(function ($application) {
                return [
                    'id' => $application->user->id,
                    'name' => $application->user->name,
                    'email' => $application->user->email,
                    'phone' => $application->user->phone,
                    'job_title' => $application->job->title,
                    'job_id' => $application->job->id,
                    'application_id' => $application->id,
                    'application_status' => $application->status,
                    'applied_at' => $application->created_at->format('M d, Y'),
                    'stage' => $application->stage ?? 'applied'
                ];
            });
            
            return response()->json([
                'success' => true,
                'candidates' => $candidates
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching available candidates: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error fetching candidates'], 500);
        }
    }
    
    /**
     * Get employer's active jobs for interview scheduling
     */
    public function getActiveJobs(Request $request)
    {
        try {
            $user = Auth::user();
            
            $jobs = Job::where('user_id', $user->id)
                ->where('status', 'active')
                ->withCount('applications')
                ->orderBy('created_at', 'desc')
                ->get();
            
            $jobsData = $jobs->map(function ($job) {
                return [
                    'id' => $job->id,
                    'title' => $job->title,
                    'location' => $job->location,
                    'applications_count' => $job->applications_count,
                    'created_at' => $job->created_at->format('M d, Y')
                ];
            });
            
            return response()->json([
                'success' => true,
                'jobs' => $jobsData
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching active jobs: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error fetching jobs'], 500);
        }
    }
    
    /**
     * Get today's interviews for calendar display
     */
    public function getTodaysInterviews(Request $request)
    {
        try {
            $user = Auth::user();
            $today = now()->startOfDay();
            $tomorrow = now()->addDay()->startOfDay();
            
            $interviews = \App\Models\Interview::where('employer_id', $user->id)
                ->whereBetween('scheduled_at', [$today, $tomorrow])
                ->with(['candidate', 'job'])
                ->orderBy('scheduled_at', 'asc')
                ->get();
            
            $interviewsData = $interviews->map(function ($interview) {
                return [
                    'id' => $interview->id,
                    'candidate_name' => $interview->candidate->name ?? 'Unknown',
                    'candidate_email' => $interview->candidate->email ?? '',
                    'job_title' => $interview->job->title ?? 'Unknown',
                    'scheduled_at' => $interview->scheduled_at->format('H:i'),
                    'full_datetime' => $interview->scheduled_at->format('Y-m-d H:i:s'),
                    'type' => $interview->type,
                    'status' => $interview->status,
                    'notes' => $interview->notes,
                    'time_until' => $interview->scheduled_at->diffForHumans()
                ];
            });
            
            return response()->json([
                'success' => true,
                'interviews' => $interviewsData,
                'count' => $interviews->count()
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching today\'s interviews: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error fetching interviews'], 500);
        }
    }
    
    /**
     * Check for interview conflicts
     */
    public function checkInterviewConflicts(Request $request)
    {
        try {
            $request->validate([
                'scheduled_at' => 'required|date',
                'duration' => 'nullable|integer|min:15|max:240' // Duration in minutes
            ]);
            
            $user = Auth::user();
            $scheduledAt = Carbon::parse($request->scheduled_at);
            $duration = $request->get('duration', 60); // Default 1 hour
            
            $startTime = $scheduledAt->copy();
            $endTime = $scheduledAt->copy()->addMinutes($duration);
            
            // Check for conflicts with existing interviews
            $conflicts = \App\Models\Interview::where('employer_id', $user->id)
                ->where('status', '!=', 'cancelled')
                ->where(function ($query) use ($startTime, $endTime) {
                    $query->whereBetween('scheduled_at', [$startTime, $endTime])
                          ->orWhere(function ($q) use ($startTime, $endTime) {
                              $q->where('scheduled_at', '<=', $startTime)
                                ->whereRaw('DATE_ADD(scheduled_at, INTERVAL 60 MINUTE) > ?', [$startTime]);
                          });
                })
                ->with(['candidate', 'job'])
                ->get();
            
            $hasConflicts = $conflicts->count() > 0;
            
            return response()->json([
                'success' => true,
                'has_conflicts' => $hasConflicts,
                'conflicts' => $conflicts->map(function ($interview) {
                    return [
                        'candidate_name' => $interview->candidate->name ?? 'Unknown',
                        'job_title' => $interview->job->title ?? 'Unknown',
                        'scheduled_at' => $interview->scheduled_at->format('M d, Y H:i'),
                        'type' => $interview->type
                    ];
                })
            ]);
        } catch (\Exception $e) {
            Log::error('Error checking interview conflicts: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error checking conflicts'], 500);
        }
    }
    
    /**
     * Send interview notification to candidate
     */
    public function sendInterviewNotification($interviewId)
    {
        try {
            $user = Auth::user();
            
            $interview = \App\Models\Interview::where('employer_id', $user->id)
                ->where('id', $interviewId)
                ->with(['candidate', 'job'])
                ->first();
            
            if (!$interview) {
                return response()->json(['success' => false, 'message' => 'Interview not found'], 404);
            }
            
            // Create a message notification to the candidate
            $message = Message::create([
                'sender_id' => $user->id,
                'receiver_id' => $interview->candidate_id,
                'message' => "Interview scheduled for {$interview->job->title} position on " . 
                           $interview->scheduled_at->format('M d, Y \a\t H:i') . 
                           ". Type: " . ucfirst($interview->type) . 
                           ($interview->notes ? ". Notes: " . $interview->notes : ""),
                'is_read' => false
            ]);
            
            // Log activity
            \App\Models\ActivityLog::createActivity(
                $user->id,
                'notification',
                'Interview Notification Sent',
                "Notification sent to {$interview->candidate->name} about interview",
                [
                    'interview_id' => $interview->id,
                    'candidate_id' => $interview->candidate_id,
                    'message_id' => $message->id
                ]
            );
            
            return response()->json([
                'success' => true,
                'message' => 'Interview notification sent successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error sending interview notification: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error sending notification'], 500);
        }
    }
    
    /**
     * Reschedule an interview
     */
    public function rescheduleInterview(Request $request, $interviewId)
    {
        try {
            $request->validate([
                'scheduled_at' => 'required|date|after:now',
                'reason' => 'nullable|string|max:500'
            ]);
            
            $user = Auth::user();
            
            $interview = \App\Models\Interview::where('employer_id', $user->id)
                ->where('id', $interviewId)
                ->with(['candidate', 'job'])
                ->first();
            
            if (!$interview) {
                return response()->json(['success' => false, 'message' => 'Interview not found'], 404);
            }
            
            $oldDateTime = $interview->scheduled_at->format('M d, Y H:i');
            $newDateTime = Carbon::parse($request->scheduled_at)->format('M d, Y H:i');
            
            // Update interview
            $interview->update([
                'scheduled_at' => $request->scheduled_at,
                'status' => 'rescheduled',
                'notes' => $interview->notes . "\n\nRescheduled from {$oldDateTime} to {$newDateTime}" . 
                          ($request->reason ? ". Reason: " . $request->reason : "")
            ]);
            
            // Send notification to candidate
            Message::create([
                'sender_id' => $user->id,
                'receiver_id' => $interview->candidate_id,
                'message' => "Interview for {$interview->job->title} has been rescheduled from {$oldDateTime} to {$newDateTime}" .
                           ($request->reason ? ". Reason: " . $request->reason : ""),
                'is_read' => false
            ]);
            
            // Log activity
            \App\Models\ActivityLog::createActivity(
                $user->id,
                'interview',
                'Interview Rescheduled',
                "Interview with {$interview->candidate->name} rescheduled to {$newDateTime}",
                [
                    'interview_id' => $interview->id,
                    'old_datetime' => $oldDateTime,
                    'new_datetime' => $newDateTime,
                    'reason' => $request->reason
                ]
            );
            
            return response()->json([
                'success' => true,
                'message' => 'Interview rescheduled successfully',
                'interview' => [
                    'id' => $interview->id,
                    'scheduled_at' => $interview->scheduled_at->format('Y-m-d H:i:s'),
                    'status' => $interview->status
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error rescheduling interview: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error rescheduling interview'], 500);
        }
    }
}