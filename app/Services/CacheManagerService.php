<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class CacheManagerService
{
    /**
     * Invalidate all user-based cache keys
     */
    public function invalidateUserCache(int $userId): void
    {
        $userCacheKeys = [
            "user.{$userId}.dashboard",
            "user.{$userId}.jobs",
            "user.{$userId}.applications",
            "user.{$userId}.payments",
            "user.{$userId}.stats",
            "user.{$userId}.analytics",
            "employer.{$userId}.dashboard",
            "employer.{$userId}.jobs.active",
            "employer.{$userId}.jobs.draft",
            "employer.{$userId}.recent_applications",
            "employer.{$userId}.payment_stats",
        ];

        foreach ($userCacheKeys as $key) {
            Cache::forget($key);
        }

        // Clear Redis-based session cache if using Redis
        if (config('cache.default') === 'redis') {
            try {
                Redis::del("laravel_cache:user.{$userId}.*");
            } catch (\Exception $e) {
                Log::warning("Failed to clear Redis cache for user {$userId}: " . $e->getMessage());
            }
        }

        Log::info("Cache invalidated for user: {$userId}");
    }

    /**
     * Invalidate session-based cache
     */
    public function invalidateSessionCache(string $sessionId): void
    {
        $sessionCacheKeys = [
            "session.{$sessionId}.data",
            "session.{$sessionId}.flash",
            "session.{$sessionId}.csrf",
        ];

        foreach ($sessionCacheKeys as $key) {
            Cache::forget($key);
        }

        Log::info("Session cache invalidated: {$sessionId}");
    }

    /**
     * Clear all employer-related cache
     */
    public function clearEmployerCache(): void
    {
        $patterns = [
            'employer.*',
            'jobs.*',
            'applications.*',
            'payments.*',
        ];

        foreach ($patterns as $pattern) {
            if (config('cache.default') === 'redis') {
                try {
                    $keys = Redis::keys("laravel_cache:{$pattern}");
                    if (!empty($keys)) {
                        Redis::del($keys);
                    }
                } catch (\Exception $e) {
                    Log::warning("Failed to clear Redis cache pattern {$pattern}: " . $e->getMessage());
                }
            }
        }

        Log::info("Employer cache cleared");
    }

    /**
     * Get cached data with user-specific key
     */
    public function getUserCache(int $userId, string $key, callable $callback, int $ttl = 3600)
    {
        $cacheKey = "user.{$userId}.{$key}";
        
        return Cache::remember($cacheKey, $ttl, $callback);
    }

    /**
     * Set user-specific cache
     */
    public function setUserCache(int $userId, string $key, $data, int $ttl = 3600): void
    {
        $cacheKey = "user.{$userId}.{$key}";
        Cache::put($cacheKey, $data, $ttl);
    }

    /**
     * Event-based cache cleanup
     */
    public function eventBasedCleanup(string $event, array $data = []): void
    {
        switch ($event) {
            case 'job.created':
            case 'job.updated':
            case 'job.deleted':
                if (isset($data['user_id'])) {
                    $this->invalidateUserCache($data['user_id']);
                }
                break;

            case 'application.created':
            case 'application.updated':
                if (isset($data['job_user_id'])) {
                    $this->invalidateUserCache($data['job_user_id']);
                }
                break;

            case 'payment.completed':
            case 'payment.failed':
                if (isset($data['user_id'])) {
                    $this->invalidateUserCache($data['user_id']);
                }
                break;

            case 'user.logout':
                if (isset($data['user_id'])) {
                    $this->invalidateUserCache($data['user_id']);
                }
                if (isset($data['session_id'])) {
                    $this->invalidateSessionCache($data['session_id']);
                }
                break;
        }

        Log::info("Event-based cache cleanup executed for: {$event}");
    }
}