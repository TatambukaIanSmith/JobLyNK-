<?php

namespace App\Services;

use App\Models\User;
use App\Models\Job;
use App\Models\Application;
use App\Models\Payment;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ReportService
{
    /**
     * Generate weekly report data
     */
    public function generateWeeklyReport($startDate, $endDate)
    {
        try {
            $data = [
                'week_start_date' => $startDate,
                'week_end_date' => $endDate,
                'total_new_users' => $this->getTotalNewUsers($startDate, $endDate),
                'total_jobs_posted' => $this->getTotalJobsPosted($startDate, $endDate),
                'total_applications' => $this->getTotalApplications($startDate, $endDate),
                'total_workers_hired' => $this->getTotalWorkersHired($startDate, $endDate),
                'total_transactions' => $this->getTotalTransactions($startDate, $endDate),
                'total_revenue' => $this->getTotalRevenue($startDate, $endDate),
                'most_active_employer' => $this->getMostActiveEmployer($startDate, $endDate),
                'most_active_worker' => $this->getMostActiveWorker($startDate, $endDate),
                'system_errors' => $this->getSystemErrors($startDate, $endDate),
                'average_response_time' => $this->getAverageResponseTime($startDate, $endDate),
            ];

            return $data;
        } catch (\Exception $e) {
            Log::error('Error generating weekly report: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get total new users registered during the week
     */
    private function getTotalNewUsers($startDate, $endDate)
    {
        return User::whereBetween('created_at', [$startDate, $endDate])->count();
    }

    /**
     * Get total jobs posted during the week
     */
    private function getTotalJobsPosted($startDate, $endDate)
    {
        return Job::whereBetween('created_at', [$startDate, $endDate])->count();
    }

    /**
     * Get total applications submitted during the week
     */
    private function getTotalApplications($startDate, $endDate)
    {
        return Application::whereBetween('created_at', [$startDate, $endDate])->count();
    }

    /**
     * Get total workers hired (accepted applications)
     */
    private function getTotalWorkersHired($startDate, $endDate)
    {
        return Application::where('status', 'accepted')
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->count();
    }

    /**
     * Get total transactions during the week
     */
    private function getTotalTransactions($startDate, $endDate)
    {
        return Payment::whereBetween('created_at', [$startDate, $endDate])->count();
    }

    /**
     * Get total revenue during the week
     */
    private function getTotalRevenue($startDate, $endDate)
    {
        return Payment::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('amount') ?? 0;
    }

    /**
     * Get most active employer (most jobs posted)
     */
    private function getMostActiveEmployer($startDate, $endDate)
    {
        $employer = Job::select('user_id', DB::raw('COUNT(*) as job_count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('user_id')
            ->orderByDesc('job_count')
            ->first();

        if ($employer) {
            $user = User::find($employer->user_id);
            return $user ? $user->name : 'N/A';
        }

        return 'N/A';
    }

    /**
     * Get most active worker (most applications)
     */
    private function getMostActiveWorker($startDate, $endDate)
    {
        $worker = Application::select('user_id', DB::raw('COUNT(*) as app_count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('user_id')
            ->orderByDesc('app_count')
            ->first();

        if ($worker) {
            $user = User::find($worker->user_id);
            return $user ? $user->name : 'N/A';
        }

        return 'N/A';
    }

    /**
     * Get system errors count from logs
     */
    private function getSystemErrors($startDate, $endDate)
    {
        // Count ERROR level logs from Laravel log file
        $logFile = storage_path('logs/laravel.log');
        
        if (!file_exists($logFile)) {
            return 0;
        }

        try {
            $content = file_get_contents($logFile);
            $lines = explode("\n", $content);
            $errorCount = 0;

            foreach ($lines as $line) {
                if (preg_match('/^\[(\d{4}-\d{2}-\d{2}).*\] \w+\.ERROR:/', $line, $matches)) {
                    $logDate = Carbon::parse($matches[1]);
                    if ($logDate->between($startDate, $endDate)) {
                        $errorCount++;
                    }
                }
            }

            return $errorCount;
        } catch (\Exception $e) {
            Log::warning('Could not count system errors: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get average response time (placeholder - implement based on your metrics)
     */
    private function getAverageResponseTime($startDate, $endDate)
    {
        // This is a placeholder. Implement based on your actual response time tracking
        // You might track this in activity_logs or a separate metrics table
        return null;
    }

    /**
     * Generate report summary text
     */
    public function generateSummary($reportData)
    {
        $startDate = Carbon::parse($reportData['week_start_date'])->format('M d');
        $endDate = Carbon::parse($reportData['week_end_date'])->format('M d, Y');

        return "During the week of {$startDate} – {$endDate}:\n" .
               "{$reportData['total_new_users']} users registered,\n" .
               "{$reportData['total_jobs_posted']} jobs were posted,\n" .
               "{$reportData['total_applications']} applications submitted,\n" .
               "{$reportData['total_workers_hired']} workers hired.";
    }
}
