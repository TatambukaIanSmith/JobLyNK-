<?php

namespace App\Observers;

use App\Models\UserSkill;
use App\Services\JobMatchingService;
use App\Services\QueryOptimizationService;

class UserSkillObserver
{
    public function __construct(
        private JobMatchingService $matchingService,
        private QueryOptimizationService $optimizationService
    ) {}

    /**
     * Handle the UserSkill "created" event.
     */
    public function created(UserSkill $userSkill): void
    {
        // Invalidate worker's job matches cache
        $this->matchingService->invalidateWorkerMatchCache($userSkill->user);
        
        // Invalidate static skill cache
        $this->optimizationService->invalidateStaticCache();
    }

    /**
     * Handle the UserSkill "updated" event.
     */
    public function updated(UserSkill $userSkill): void
    {
        // Invalidate worker's job matches cache
        $this->matchingService->invalidateWorkerMatchCache($userSkill->user);
    }

    /**
     * Handle the UserSkill "deleted" event.
     */
    public function deleted(UserSkill $userSkill): void
    {
        // Invalidate worker's job matches cache
        $this->matchingService->invalidateWorkerMatchCache($userSkill->user);
    }
}
