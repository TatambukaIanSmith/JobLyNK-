<?php

namespace App\Listeners;

use App\Services\CacheManagerService;
use App\Services\SessionManagerService;
use App\Services\TokenRevocationService;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Log;

class CacheCleanupListener
{
    protected $cacheManager;
    protected $sessionManager;
    protected $tokenRevocation;

    public function __construct(
        CacheManagerService $cacheManager,
        SessionManagerService $sessionManager,
        TokenRevocationService $tokenRevocation
    ) {
        $this->cacheManager = $cacheManager;
        $this->sessionManager = $sessionManager;
        $this->tokenRevocation = $tokenRevocation;
    }

    /**
     * Handle user login events
     */
    public function handleLogin(Login $event): void
    {
        $user = $event->user;
        
        // Set session security flags
        $this->sessionManager->setSecurityFlags();
        
        // Clean up old sessions (optional - keep only last 5 sessions)
        $this->cleanupOldSessions($user->id);
        
        Log::info("Login cache cleanup completed for user: {$user->id}");
    }

    /**
     * Handle user logout events
     */
    public function handleLogout(Logout $event): void
    {
        if ($event->user) {
            $userId = $event->user->id;
            
            // Invalidate user cache
            $this->cacheManager->eventBasedCleanup('user.logout', [
                'user_id' => $userId,
                'session_id' => session()->getId()
            ]);
            
            // Forget user session data
            $this->sessionManager->forgetUserData($userId);
            
            Log::info("Logout cache cleanup completed for user: {$userId}");
        }
    }

    /**
     * Handle job-related events
     */
    public function handleJobEvent(string $eventType, $job): void
    {
        $this->cacheManager->eventBasedCleanup($eventType, [
            'user_id' => $job->user_id,
            'job_id' => $job->id
        ]);
    }

    /**
     * Handle application events
     */
    public function handleApplicationEvent(string $eventType, $application): void
    {
        $this->cacheManager->eventBasedCleanup($eventType, [
            'job_user_id' => $application->job->user_id ?? null,
            'applicant_id' => $application->user_id
        ]);
    }

    /**
     * Handle payment events
     */
    public function handlePaymentEvent(string $eventType, $payment): void
    {
        $this->cacheManager->eventBasedCleanup($eventType, [
            'user_id' => $payment->user_id,
            'payment_id' => $payment->id
        ]);
    }

    /**
     * Clean up old sessions, keeping only the most recent ones
     */
    protected function cleanupOldSessions(int $userId, int $keepCount = 5): void
    {
        try {
            $sessions = $this->sessionManager->getActiveSessions($userId);
            
            if (count($sessions) > $keepCount) {
                // Sort by last activity and keep only the most recent
                usort($sessions, function($a, $b) {
                    return $b->last_activity <=> $a->last_activity;
                });
                
                $sessionsToDelete = array_slice($sessions, $keepCount);
                
                foreach ($sessionsToDelete as $session) {
                    \DB::table('sessions')->where('id', $session->id)->delete();
                }
                
                Log::info("Cleaned up " . count($sessionsToDelete) . " old sessions for user: {$userId}");
            }
        } catch (\Exception $e) {
            Log::error("Failed to cleanup old sessions for user {$userId}: " . $e->getMessage());
        }
    }
}