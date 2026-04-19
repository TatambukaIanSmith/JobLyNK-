<?php

namespace App\Services;

use App\Models\Job;
use App\Models\User;
use App\Models\Category;
use App\Models\Skill;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class QueryOptimizationService
{
    private const CACHE_TTL = 3600; // 1 hour
    private const STATIC_CACHE_TTL = 86400; // 24 hours

    /**
     * Get all skills with caching
     */
    public function getAllSkills(): Collection
    {
        return Cache::remember('skills:all', self::STATIC_CACHE_TTL, function () {
            return Skill::select('id', 'name', 'category')->get();
        });
    }

    /**
     * Get all categories with caching
     */
    public function getAllCategories(): Collection
    {
        return Cache::remember('categories:all', self::STATIC_CACHE_TTL, function () {
            return Category::where('is_active', true)
                ->select('id', 'name', 'slug', 'icon')
                ->get();
        });
    }

    /**
     * Get employer dashboard stats with optimized queries
     */
    public function getEmployerDashboardStats(User $employer): array
    {
        $cacheKey = "user:{$employer->id}:dashboard:stats";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($employer) {
            // Single query with all relationships and counts
            $jobs = Job::where('user_id', $employer->id)
                ->select('id', 'user_id', 'status', 'created_at', 'views', 'applications_count')
                ->withCount('applications')
                ->with(['category:id,name'])
                ->get();

            // Calculate all stats from loaded data
            $totalJobs = $jobs->count();
            $activeJobs = $jobs->where('status', 'active')->count();
            $draftJobs = $jobs->where('status', 'draft')->count();
            $pausedJobs = $jobs->where('status', 'paused')->count();
            $totalApplications = $jobs->sum('applications_count');
            $totalViews = $jobs->sum('views');
            $jobsThisMonth = $jobs->where('created_at', '>=', now()->startOfMonth())->count();

            // Get bookmarks and likes in single queries
            $totalBookmarks = DB::table('bookmarks')
                ->whereIn('job_id', $jobs->pluck('id'))
                ->count();

            $totalLikes = DB::table('likes')
                ->whereIn('job_id', $jobs->pluck('id'))
                ->count();

            // Get recent applications with eager loading
            $recentApplications = DB::table('applications')
                ->whereIn('job_id', $jobs->pluck('id'))
                ->select('id', 'job_id', 'user_id', 'status', 'created_at')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            return [
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
        });
    }

    /**
     * Get monthly performance with optimized query
     */
    public function getMonthlyPerformance(User $employer): array
    {
        $cacheKey = "user:{$employer->id}:monthly:performance";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($employer) {
            // Single query for all months
            $jobStats = DB::table('job_postings')
                ->where('user_id', $employer->id)
                ->select(
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('COUNT(*) as jobs_count')
                )
                ->where('created_at', '>=', now()->subMonths(6))
                ->groupBy('year', 'month')
                ->get()
                ->keyBy(fn($row) => "{$row->year}-{$row->month}");

            $applicationStats = DB::table('applications')
                ->join('job_postings', 'applications.job_id', '=', 'job_postings.id')
                ->where('job_postings.user_id', $employer->id)
                ->select(
                    DB::raw('YEAR(applications.created_at) as year'),
                    DB::raw('MONTH(applications.created_at) as month'),
                    DB::raw('COUNT(*) as applications_count')
                )
                ->where('applications.created_at', '>=', now()->subMonths(6))
                ->groupBy('year', 'month')
                ->get()
                ->keyBy(fn($row) => "{$row->year}-{$row->month}");

            $months = [];
            for ($i = 5; $i >= 0; $i--) {
                $date = now()->subMonths($i);
                $key = $date->format('Y-m');

                $months[] = [
                    'month' => $date->format('M Y'),
                    'jobs' => $jobStats[$key]->jobs_count ?? 0,
                    'applications' => $applicationStats[$key]->applications_count ?? 0,
                ];
            }

            return $months;
        });
    }

    /**
     * Get payment statistics with optimized query
     */
    public function getPaymentStats(User $employer): array
    {
        $cacheKey = "user:{$employer->id}:payment:stats";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($employer) {
            $stats = DB::table('payments')
                ->where('user_id', $employer->id)
                ->select(
                    DB::raw('SUM(amount) as total_spent'),
                    DB::raw('SUM(CASE WHEN status = "pending" THEN amount ELSE 0 END) as pending_payments'),
                    DB::raw('COUNT(*) as total_transactions')
                )
                ->first();

            $recentPayments = DB::table('payments')
                ->where('user_id', $employer->id)
                ->select('id', 'amount', 'status', 'created_at')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            return [
                'total_spent' => $stats->total_spent ?? 0,
                'pending_payments' => $stats->pending_payments ?? 0,
                'total_transactions' => $stats->total_transactions ?? 0,
                'recent_payments' => $recentPayments,
            ];
        });
    }

    /**
     * Get job analytics with optimized queries
     */
    public function getJobAnalytics(Job $job): array
    {
        $cacheKey = "job:{$job->id}:analytics";

        return Cache::remember($cacheKey, 300, function () use ($job) { // 5 min cache for analytics
            $applicationStats = DB::table('applications')
                ->where('job_id', $job->id)
                ->select(
                    DB::raw('COUNT(*) as total'),
                    DB::raw('SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending'),
                    DB::raw('SUM(CASE WHEN status = "approved" THEN 1 ELSE 0 END) as approved'),
                    DB::raw('SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as rejected')
                )
                ->first();

            $bookmarksCount = DB::table('bookmarks')
                ->where('job_id', $job->id)
                ->count();

            $likesCount = DB::table('likes')
                ->where('job_id', $job->id)
                ->count();

            $totalApplications = $applicationStats->total ?? 0;
            $conversionRate = $job->views > 0 ? round(($totalApplications / $job->views) * 100, 1) : 0;

            return [
                'total_applications' => $totalApplications,
                'pending_applications' => $applicationStats->pending ?? 0,
                'approved_applications' => $applicationStats->approved ?? 0,
                'rejected_applications' => $applicationStats->rejected ?? 0,
                'bookmarks_count' => $bookmarksCount,
                'likes_count' => $likesCount,
                'conversion_rate' => $conversionRate,
                'total_views' => $job->views ?? 0,
            ];
        });
    }

    /**
     * Invalidate user cache
     */
    public function invalidateUserCache(int $userId): void
    {
        Cache::forget("user:{$userId}:dashboard:stats");
        Cache::forget("user:{$userId}:monthly:performance");
        Cache::forget("user:{$userId}:payment:stats");
    }

    /**
     * Invalidate job cache
     */
    public function invalidateJobCache(int $jobId): void
    {
        Cache::forget("job:{$jobId}:analytics");
        Cache::forget("job:{$jobId}:skill:matches");
    }

    /**
     * Invalidate static caches
     */
    public function invalidateStaticCache(): void
    {
        Cache::forget('skills:all');
        Cache::forget('categories:all');
    }
}
