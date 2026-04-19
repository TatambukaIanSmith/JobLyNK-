<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Services\CacheManagerService;

class SessionManagerService
{
    protected $cacheManager;

    public function __construct(CacheManagerService $cacheManager)
    {
        $this->cacheManager = $cacheManager;
    }

    /**
     * Invalidate current session and create new one
     */
    public function invalidateAndRegenerate(): void
    {
        $oldSessionId = Session::getId();
        
        // Clear cache for old session
        $this->cacheManager->invalidateSessionCache($oldSessionId);
        
        // Invalidate current session
        Session::invalidate();
        
        // Regenerate session ID
        Session::regenerate(true);
        
        Log::info("Session invalidated and regenerated", [
            'old_session' => $oldSessionId,
            'new_session' => Session::getId(),
            'user_id' => Auth::id()
        ]);
    }

    /**
     * Forget user-specific session data
     */
    public function forgetUserData(int $userId): void
    {
        $userSessionKeys = [
            'user.dashboard.last_visit',
            'user.jobs.filters',
            'user.applications.filters',
            'user.payments.filters',
            'employer.dashboard.preferences',
            'employer.notifications',
        ];

        foreach ($userSessionKeys as $key) {
            Session::forget($key);
        }

        // Clear user-based cache
        $this->cacheManager->invalidateUserCache($userId);

        Log::info("User session data forgotten for user: {$userId}");
    }

    /**
     * Clean up expired sessions from database
     */
    public function cleanupExpiredSessions(): void
    {
        try {
            $expiredCount = DB::table('sessions')
                ->where('last_activity', '<', now()->subMinutes(config('session.lifetime', 120))->timestamp)
                ->delete();

            Log::info("Cleaned up {$expiredCount} expired sessions");
        } catch (\Exception $e) {
            Log::error("Failed to cleanup expired sessions: " . $e->getMessage());
        }
    }

    /**
     * Revoke all sessions for a user except current
     */
    public function revokeOtherSessions(int $userId): void
    {
        $currentSessionId = Session::getId();
        
        try {
            $revokedCount = DB::table('sessions')
                ->where('user_id', $userId)
                ->where('id', '!=', $currentSessionId)
                ->delete();

            Log::info("Revoked {$revokedCount} sessions for user: {$userId}");
        } catch (\Exception $e) {
            Log::error("Failed to revoke sessions for user {$userId}: " . $e->getMessage());
        }
    }

    /**
     * Get active sessions for a user
     */
    public function getActiveSessions(int $userId): array
    {
        try {
            return DB::table('sessions')
                ->where('user_id', $userId)
                ->where('last_activity', '>=', now()->subMinutes(config('session.lifetime', 120))->timestamp)
                ->select('id', 'ip_address', 'user_agent', 'last_activity')
                ->get()
                ->toArray();
        } catch (\Exception $e) {
            Log::error("Failed to get active sessions for user {$userId}: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Set session security flags
     */
    public function setSecurityFlags(): void
    {
        // Set secure session configuration
        Session::put('_security_timestamp', now()->timestamp);
        Session::put('_user_agent_hash', hash('sha256', request()->userAgent()));
        Session::put('_ip_hash', hash('sha256', request()->ip()));
        
        Log::info("Session security flags set", [
            'session_id' => Session::getId(),
            'user_id' => Auth::id()
        ]);
    }

    /**
     * Validate session security
     */
    public function validateSecurity(): bool
    {
        $currentUserAgent = hash('sha256', request()->userAgent());
        $currentIp = hash('sha256', request()->ip());
        
        $sessionUserAgent = Session::get('_user_agent_hash');
        $sessionIp = Session::get('_ip_hash');
        
        if ($sessionUserAgent !== $currentUserAgent || $sessionIp !== $currentIp) {
            Log::warning("Session security validation failed", [
                'session_id' => Session::getId(),
                'user_id' => Auth::id(),
                'ip_mismatch' => $sessionIp !== $currentIp,
                'user_agent_mismatch' => $sessionUserAgent !== $currentUserAgent
            ]);
            
            return false;
        }
        
        return true;
    }
}