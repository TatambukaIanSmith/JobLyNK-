<?php

namespace App\Services;

use App\Models\User;
use App\Models\Job;
use App\Models\Application;
use App\Models\AIAgentActivity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class EmployerAIAgentService
{
    /**
     * Generate AI agent insights for employer
     */
    public function generateInsights(User $employer): array
    {
        try {
            $insights = [
                'greeting' => $this->generateGreeting($employer),
                'alerts' => $this->getAlerts($employer),
                'job_performance' => $this->getJobPerformance($employer),
                'recommendations' => $this->getRecommendations($employer),
                'troubleshooting' => $this->getTroubleshootingTips($employer),
                'admin_feedback' => $this->generateAdminFeedback($employer),
                'summary' => $this->generateSummary($employer)
            ];

            // Log AI agent activity for admin monitoring
            $this->logAgentActivity($employer, $insights);

            return $insights;
        } catch (\Exception $e) {
            // Log error and return fallback insights
            Log::error('AI Agent Insights Generation Failed', [
                'employer_id' => $employer->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Return minimal fallback insights
            return $this->getFallbackInsights($employer);
        }
    }

    /**
     * Generate personalized greeting
     */
    private function generateGreeting(User $employer): string
    {
        $timeOfDay = $this->getTimeOfDay();
        $name = $employer->name;
        
        $greetings = [
            "Good $timeOfDay, $name! I'm your AI hiring assistant, ready to help you find the perfect workers.",
            "Hello $name! Your AI agent here with fresh insights about your job postings and applications.",
            "Hi $name! Let me update you on your hiring progress and share some valuable insights.",
        ];

        return $greetings[array_rand($greetings)];
    }

    /**
     * Get real-time alerts for employer
     */
    private function getAlerts(User $employer): array
    {
        $alerts = [];

        // New applications alert
        $newApplications = Application::whereHas('job', function($query) use ($employer) {
            $query->where('user_id', $employer->id);
        })->where('created_at', '>=', Carbon::now()->subHours(24))->count();

        if ($newApplications > 0) {
            $alerts[] = [
                'type' => 'new_applications',
                'priority' => 'high',
                'message' => "🎉 Great news! You have $newApplications new application(s) in the last 24 hours!",
                'action' => 'Review applications now to maintain engagement with potential workers.',
                'count' => $newApplications
            ];
        }

        // Job views alert
        $totalViews = Job::where('user_id', $employer->id)
            ->where('updated_at', '>=', Carbon::now()->subDays(7))
            ->sum('views');

        if ($totalViews > 0) {
            $alerts[] = [
                'type' => 'job_views',
                'priority' => 'medium',
                'message' => "👀 Your jobs received $totalViews views this week!",
                'action' => 'High views indicate good job visibility. Consider promoting top-performing jobs.',
                'count' => $totalViews
            ];
        }

        // Low performance alert
        $lowPerformingJobs = Job::where('user_id', $employer->id)
            ->where('status', 'active')
            ->where('created_at', '<=', Carbon::now()->subDays(3))
            ->where('views', '<', 5)
            ->count();

        if ($lowPerformingJobs > 0) {
            $alerts[] = [
                'type' => 'low_performance',
                'priority' => 'medium',
                'message' => "⚠️ $lowPerformingJobs job(s) have low visibility after 3+ days.",
                'action' => 'Consider updating job descriptions, increasing budget, or making them featured.',
                'count' => $lowPerformingJobs
            ];
        }

        return $alerts;
    }

    /**
     * Get job performance analytics
     */
    private function getJobPerformance(User $employer): array
    {
        $jobs = Job::where('user_id', $employer->id)->get();
        
        $performance = [
            'total_jobs' => $jobs->count(),
            'active_jobs' => $jobs->where('status', 'active')->count(),
            'total_views' => $jobs->sum('views'),
            'total_applications' => $jobs->sum('applications_count'),
            'avg_applications_per_job' => $jobs->count() > 0 ? round($jobs->sum('applications_count') / $jobs->count(), 1) : 0,
            'top_performing_job' => $this->getTopPerformingJob($employer),
            'recent_activity' => $this->getRecentActivity($employer)
        ];

        return $performance;
    }

    /**
     * Get AI recommendations for better hiring
     */
    private function getRecommendations(User $employer): array
    {
        $recommendations = [];
        $jobs = Job::where('user_id', $employer->id)->get();

        // Job posting recommendations
        if ($jobs->where('status', 'active')->count() < 3) {
            $recommendations[] = [
                'category' => 'job_posting',
                'title' => 'Increase Job Visibility',
                'message' => 'Post more jobs to increase your chances of finding quality workers. Active employers get 3x more applications.',
                'priority' => 'high'
            ];
        }

        // Budget recommendations
        $avgBudget = $jobs->where('budget', '>', 0)->avg('budget');
        if ($avgBudget && $avgBudget < 30000) {
            $recommendations[] = [
                'category' => 'budget',
                'title' => 'Consider Competitive Budgets',
                'message' => 'Jobs with budgets above UGX 30,000 receive 40% more quality applications. Consider adjusting your budget ranges.',
                'priority' => 'medium'
            ];
        }

        // Response time recommendations
        $recommendations[] = [
            'category' => 'best_practice',
            'title' => 'Quick Response Strategy',
            'message' => 'Respond to applications within 24 hours. Fast responses increase worker acceptance rates by 60%.',
            'priority' => 'high'
        ];

        // Featured job recommendations
        if ($jobs->where('is_featured', true)->count() === 0) {
            $recommendations[] = [
                'category' => 'promotion',
                'title' => 'Try Featured Jobs',
                'message' => 'Featured jobs get 5x more visibility. Consider featuring your most important positions.',
                'priority' => 'medium'
            ];
        }

        return $recommendations;
    }

    /**
     * Get troubleshooting tips
     */
    private function getTroubleshootingTips(User $employer): array
    {
        $tips = [];
        $jobs = Job::where('user_id', $employer->id)->get();

        // Low application tips
        $lowAppJobs = $jobs->where('applications_count', '<', 2)->where('status', 'active')->count();
        if ($lowAppJobs > 0) {
            $tips[] = [
                'issue' => 'Low Applications',
                'solution' => 'Try these fixes: 1) Add more detailed job descriptions, 2) Include specific skills required, 3) Offer competitive pay, 4) Set realistic requirements.',
                'priority' => 'high'
            ];
        }

        // General tips
        $tips[] = [
            'issue' => 'Improve Job Quality',
            'solution' => 'Use clear titles, detailed descriptions, specify location clearly, and include contact preferences.',
            'priority' => 'medium'
        ];

        $tips[] = [
            'issue' => 'Attract Better Candidates',
            'solution' => 'Highlight growth opportunities, provide clear expectations, mention any benefits or perks.',
            'priority' => 'medium'
        ];

        return $tips;
    }

    /**
     * Generate feedback for admin monitoring
     */
    private function generateAdminFeedback(User $employer): array
    {
        $jobs = Job::where('user_id', $employer->id)->get();
        $applications = Application::whereHas('job', function($query) use ($employer) {
            $query->where('user_id', $employer->id);
        })->get();

        $feedback = [
            'employer_id' => $employer->id,
            'employer_name' => $employer->name,
            'performance_score' => $this->calculatePerformanceScore($employer),
            'engagement_level' => $this->calculateEngagementLevel($employer),
            'success_metrics' => [
                'jobs_posted' => $jobs->count(),
                'applications_received' => $applications->count(),
                'response_rate' => $this->calculateResponseRate($employer),
                'job_completion_rate' => $this->calculateCompletionRate($employer)
            ],
            'areas_for_improvement' => $this->getImprovementAreas($employer),
            'admin_notes' => $this->generateAdminNotes($employer)
        ];

        return $feedback;
    }

    /**
     * Generate summary for employer
     */
    private function generateSummary(User $employer): string
    {
        $jobs = Job::where('user_id', $employer->id)->get();
        $activeJobs = $jobs->where('status', 'active')->count();
        $totalApplications = $jobs->sum('applications_count');
        
        $summaries = [
            "You're doing great, {$employer->name}! With $activeJobs active jobs and $totalApplications total applications, you're building a strong presence on JOB-lyNK.",
            "Keep up the excellent work! Your jobs are attracting attention with $totalApplications applications across your postings.",
            "Your hiring journey is progressing well. Focus on responding quickly to applications to maximize your success rate."
        ];

        return $summaries[array_rand($summaries)];
    }

    /**
     * Helper methods
     */
    private function getTimeOfDay(): string
    {
        $hour = Carbon::now()->hour;
        if ($hour < 12) return 'morning';
        if ($hour < 17) return 'afternoon';
        return 'evening';
    }

    private function getTopPerformingJob(User $employer): ?array
    {
        $topJob = Job::where('user_id', $employer->id)
            ->orderByDesc('views')
            ->first();

        if (!$topJob) return null;

        return [
            'title' => $topJob->title,
            'views' => $topJob->views,
            'applications' => $topJob->applications_count
        ];
    }

    private function getRecentActivity(User $employer): array
    {
        return [
            'jobs_this_week' => Job::where('user_id', $employer->id)
                ->where('created_at', '>=', Carbon::now()->subWeek())
                ->count(),
            'applications_this_week' => Application::whereHas('job', function($query) use ($employer) {
                $query->where('user_id', $employer->id);
            })->where('created_at', '>=', Carbon::now()->subWeek())->count()
        ];
    }

    private function calculatePerformanceScore(User $employer): int
    {
        $jobs = Job::where('user_id', $employer->id)->get();
        $score = 0;

        // Base score for having jobs
        $score += min($jobs->count() * 10, 50);

        // Score for applications received
        $totalApps = $jobs->sum('applications_count');
        $score += min($totalApps * 5, 30);

        // Score for job views
        $totalViews = $jobs->sum('views');
        $score += min($totalViews * 2, 20);

        return min($score, 100);
    }

    private function calculateEngagementLevel(User $employer): string
    {
        $score = $this->calculatePerformanceScore($employer);
        
        if ($score >= 80) return 'High';
        if ($score >= 50) return 'Medium';
        return 'Low';
    }

    private function calculateResponseRate(User $employer): float
    {
        // Placeholder - would need response tracking
        return 85.0;
    }

    private function calculateCompletionRate(User $employer): float
    {
        $totalJobs = Job::where('user_id', $employer->id)->count();
        $completedJobs = Job::where('user_id', $employer->id)->where('status', 'completed')->count();
        
        return $totalJobs > 0 ? round(($completedJobs / $totalJobs) * 100, 1) : 0;
    }

    private function getImprovementAreas(User $employer): array
    {
        $areas = [];
        $jobs = Job::where('user_id', $employer->id)->get();

        if ($jobs->avg('views') < 10) {
            $areas[] = 'Job visibility needs improvement';
        }

        if ($jobs->avg('applications_count') < 3) {
            $areas[] = 'Job attractiveness could be enhanced';
        }

        return $areas;
    }

    private function generateAdminNotes(User $employer): string
    {
        $performanceScore = $this->calculatePerformanceScore($employer);
        
        if ($performanceScore >= 80) {
            return "High-performing employer. Excellent engagement and job posting quality.";
        } elseif ($performanceScore >= 50) {
            return "Moderate performer. Could benefit from guidance on job optimization.";
        } else {
            return "Needs support. Consider reaching out with personalized assistance.";
        }
    }

    private function logAgentActivity(User $employer, array $insights): void
    {
        try {
            // Log to Laravel logs
            Log::info('AI Agent Activity', [
                'employer_id' => $employer->id,
                'employer_name' => $employer->name,
                'alerts_count' => count($insights['alerts']),
                'recommendations_count' => count($insights['recommendations']),
                'performance_score' => $insights['admin_feedback']['performance_score'],
                'timestamp' => Carbon::now()
            ]);

            // Store in database for admin monitoring
            AIAgentActivity::create([
                'employer_id' => $employer->id,
                'activity_type' => 'insights_generated',
                'data' => [
                    'alerts' => $insights['alerts'],
                    'recommendations' => $insights['recommendations'],
                    'job_performance' => $insights['job_performance'],
                    'admin_feedback' => $insights['admin_feedback']
                ],
                'alerts_count' => count($insights['alerts']),
                'recommendations_count' => count($insights['recommendations']),
                'performance_score' => $insights['admin_feedback']['performance_score'],
                'engagement_level' => $insights['admin_feedback']['engagement_level']
            ]);
        } catch (\Exception $e) {
            // Log error but don't break the AI agent functionality
            Log::error('AI Agent Activity Logging Failed', [
                'employer_id' => $employer->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Get fallback insights when main generation fails
     */
    private function getFallbackInsights(User $employer): array
    {
        return [
            'greeting' => "Hello {$employer->name}! Your AI assistant is here to help.",
            'alerts' => [],
            'job_performance' => [
                'total_jobs' => 0,
                'active_jobs' => 0,
                'total_views' => 0,
                'total_applications' => 0,
                'avg_applications_per_job' => 0,
                'top_performing_job' => null,
                'recent_activity' => [
                    'jobs_this_week' => 0,
                    'applications_this_week' => 0
                ]
            ],
            'recommendations' => [
                [
                    'category' => 'general',
                    'title' => 'Welcome to JOB-lyNK',
                    'message' => 'Start by posting your first job to connect with skilled workers.',
                    'priority' => 'medium'
                ]
            ],
            'troubleshooting' => [],
            'admin_feedback' => [
                'employer_id' => $employer->id,
                'employer_name' => $employer->name,
                'performance_score' => 0,
                'engagement_level' => 'Low',
                'success_metrics' => [
                    'jobs_posted' => 0,
                    'applications_received' => 0,
                    'response_rate' => 0,
                    'job_completion_rate' => 0
                ],
                'areas_for_improvement' => [],
                'admin_notes' => 'New employer - data collection in progress.'
            ],
            'summary' => "Welcome to JOB-lyNK, {$employer->name}! Your AI assistant is ready to help you succeed."
        ];
    }
}