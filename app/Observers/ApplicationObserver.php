<?php

namespace App\Observers;

use App\Models\Application;
use App\Services\QueryOptimizationService;

class ApplicationObserver
{
    public function __construct(private QueryOptimizationService $optimizationService) {}

    /**
     * Handle the Application "created" event.
     */
    public function created(Application $application): void
    {
        // Invalidate job analytics cache
        $this->optimizationService->invalidateJobCache($application->job_id);
        
        // Invalidate employer's dashboard cache
        $this->optimizationService->invalidateUserCache($application->job->user_id);
    }

    /**
     * Handle the Application "updated" event.
     */
    public function updated(Application $application): void
    {
        // Invalidate job analytics cache
        $this->optimizationService->invalidateJobCache($application->job_id);
        
        // Invalidate employer's dashboard cache
        $this->optimizationService->invalidateUserCache($application->job->user_id);
    }

    /**
     * Handle the Application "deleted" event.
     */
    public function deleted(Application $application): void
    {
        // Invalidate job analytics cache
        $this->optimizationService->invalidateJobCache($application->job_id);
        
        // Invalidate employer's dashboard cache
        $this->optimizationService->invalidateUserCache($application->job->user_id);
    }
}
