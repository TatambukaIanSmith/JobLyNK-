<?php

namespace App\Services;

use App\Models\User;
use App\Models\Job;
use App\Models\JobNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

class JobNotificationService
{
    protected JobMatchingService $matchingService;

    public function __construct(JobMatchingService $matchingService)
    {
        $this->matchingService = $matchingService;
    }

    /**
     * Send job match notifications to workers
     */
    public function sendJobMatchNotifications(Job $job): int
    {
        $notificationsSent = 0;
        
        // Get unsent job match notifications for this job
        $notifications = JobNotification::where('job_id', $job->id)
            ->where('type', 'job_match')
            ->where('is_sent', false)
            ->with(['user', 'job.employer'])
            ->get();

        foreach ($notifications as $notification) {
            try {
                $this->sendJobMatchEmail($notification);
                $notification->markAsSent();
                $notificationsSent++;
            } catch (\Exception $e) {
                Log::error('Failed to send job match notification', [
                    'notification_id' => $notification->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return $notificationsSent;
    }

    /**
     * Send worker match notifications to employers
     */
    public function sendWorkerMatchNotifications(User $worker): int
    {
        $notificationsSent = 0;
        
        // Get unsent worker match notifications for this worker
        $notifications = JobNotification::whereHas('job', function ($query) use ($worker) {
                $query->whereHas('jobSkills', function ($skillQuery) use ($worker) {
                    $skillQuery->whereIn('skill_id', $worker->userSkills()->pluck('skill_id'));
                });
            })
            ->where('type', 'worker_match')
            ->where('is_sent', false)
            ->with(['user', 'job'])
            ->get();

        foreach ($notifications as $notification) {
            try {
                $this->sendWorkerMatchEmail($notification, $worker);
                $notification->markAsSent();
                $notificationsSent++;
            } catch (\Exception $e) {
                Log::error('Failed to send worker match notification', [
                    'notification_id' => $notification->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return $notificationsSent;
    }

    /**
     * Send job match email to worker
     */
    private function sendJobMatchEmail(JobNotification $notification): void
    {
        $worker = $notification->user;
        $job = $notification->job;
        
        // Get matching skills for context
        $matchingSkills = $this->matchingService->findMatchingJobs($worker, 1)
            ->first()['matching_skills'] ?? collect();

        $emailData = [
            'worker_name' => $worker->name,
            'job_title' => $job->title,
            'employer_name' => $job->employer->name,
            'job_location' => $job->location,
            'job_budget' => $job->budget,
            'match_score' => $notification->getMatchPercentage(),
            'matching_skills' => $matchingSkills,
            'job_url' => route('jobs.show', $job->id),
            'job_description' => substr(strip_tags($job->description), 0, 200) . '...'
        ];

        // For now, we'll log the email content. In production, use Mail::send()
        Log::info('Job Match Email', [
            'to' => $worker->email,
            'subject' => "New Job Match: {$job->title}",
            'data' => $emailData
        ]);

        // Uncomment when email templates are ready:
        // Mail::send('emails.job-match', $emailData, function ($message) use ($worker, $job) {
        //     $message->to($worker->email, $worker->name)
        //             ->subject("New Job Match: {$job->title}");
        // });
    }

    /**
     * Send worker match email to employer
     */
    private function sendWorkerMatchEmail(JobNotification $notification, User $worker): void
    {
        $employer = $notification->user;
        $job = $notification->job;
        
        // Get matching skills for context
        $matchingSkills = $this->matchingService->findMatchingWorkers($job, 1)
            ->where('worker.id', $worker->id)
            ->first()['matching_skills'] ?? collect();

        $emailData = [
            'employer_name' => $employer->name,
            'worker_name' => $worker->name,
            'job_title' => $job->title,
            'worker_location' => $worker->location,
            'match_score' => $notification->getMatchPercentage(),
            'matching_skills' => $matchingSkills,
            'worker_profile_url' => route('worker.profile', $worker->id),
            'worker_bio' => substr($worker->bio ?? '', 0, 200) . '...'
        ];

        // For now, we'll log the email content. In production, use Mail::send()
        Log::info('Worker Match Email', [
            'to' => $employer->email,
            'subject' => "Qualified Worker Found: {$worker->name}",
            'data' => $emailData
        ]);

        // Uncomment when email templates are ready:
        // Mail::send('emails.worker-match', $emailData, function ($message) use ($employer, $worker) {
        //     $message->to($employer->email, $employer->name)
        //             ->subject("Qualified Worker Found: {$worker->name}");
        // });
    }

    /**
     * Process all pending notifications
     */
    public function processPendingNotifications(): array
    {
        $results = [
            'job_matches_sent' => 0,
            'worker_matches_sent' => 0,
            'errors' => 0
        ];

        try {
            // Process job match notifications
            $jobMatchNotifications = JobNotification::where('type', 'job_match')
                ->where('is_sent', false)
                ->with(['job'])
                ->get()
                ->groupBy('job_id');

            foreach ($jobMatchNotifications as $jobId => $notifications) {
                $job = $notifications->first()->job;
                $sent = $this->sendJobMatchNotifications($job);
                $results['job_matches_sent'] += $sent;
            }

            // Process worker match notifications  
            $workerMatchNotifications = JobNotification::where('type', 'worker_match')
                ->where('is_sent', false)
                ->with(['user'])
                ->get()
                ->groupBy('user_id');

            foreach ($workerMatchNotifications as $userId => $notifications) {
                $worker = User::find($userId);
                if ($worker && $worker->role === 'worker') {
                    $sent = $this->sendWorkerMatchNotifications($worker);
                    $results['worker_matches_sent'] += $sent;
                }
            }

        } catch (\Exception $e) {
            Log::error('Error processing pending notifications', [
                'error' => $e->getMessage()
            ]);
            $results['errors']++;
        }

        return $results;
    }

    /**
     * Get notification summary for user
     */
    public function getNotificationSummary(User $user): array
    {
        $unreadCount = $user->unreadJobNotifications()->count();
        
        $recentNotifications = $user->jobNotifications()
            ->with(['job.employer'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return [
            'unread_count' => $unreadCount,
            'recent_notifications' => $recentNotifications,
            'total_notifications' => $user->jobNotifications()->count()
        ];
    }

    /**
     * Mark notifications as read for user
     */
    public function markNotificationsAsRead(User $user, array $notificationIds = []): int
    {
        $query = $user->jobNotifications()->where('is_read', false);
        
        if (!empty($notificationIds)) {
            $query->whereIn('id', $notificationIds);
        }
        
        return $query->update(['is_read' => true]);
    }
}