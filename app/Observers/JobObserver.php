<?php

namespace App\Observers;

use App\Models\Job;
use App\Services\JobMatchingService;
use App\Services\QueryOptimizationService;
use Illuminate\Support\Facades\Cache;

class JobObserver
{
    public function __construct(
        private JobMatchingService $matchingService,
        private QueryOptimizationService $optimizationService
    ) {}

    /**
     * Handle the Job "created" event.
     */
    public function created(Job $job): void
    {
        // Invalidate employer's dashboard cache
        $this->optimizationService->invalidateUserCache($job->user_id);
        
        // Invalidate static caches as job count changed
        Cache::forget('categories:all');
    }

    /**
     * Handle the Job "updated" event.
     */
    public function updated(Job $job): void
    {
        // Invalidate job-specific caches
        $this->optimizationService->invalidateJobCache($job->id);
        $this->matchingService->invalidateJobMatchCache($job);
        
        // Invalidate employer's dashboard cache
        $this->optimizationService->invalidateUserCache($job->user_id);
    }

    /**
     * Handle the Job "deleted" event.
     */
    public function deleted(Job $job): void
    {
        // Invalidate job-specific caches
        $this->optimizationService->invalidateJobCache($job->id);
        $this->matchingService->invalidateJobMatchCache($job);
        
        // Invalidate employer's dashboard cache
        $this->optimizationService->invalidateUserCache($job->user_id);
    }

    /**
     * Handle the Job "restored" event.
     */
    public function restored(Job $job): void
    {
        // Invalidate caches on restore
        $this->optimizationService->invalidateUserCache($job->user_id);
    }

    /**
     * Handle the Job "force deleted" event.
     */
    public function forceDeleted(Job $job): void
    {
        // Invalidate caches on force delete
        $this->optimizationService->invalidateUserCache($job->user_id);
    }
}
