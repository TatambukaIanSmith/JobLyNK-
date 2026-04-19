<?php

namespace App\Providers;

use App\Models\Job;
use App\Models\UserSkill;
use App\Models\Application;
use App\Observers\JobObserver;
use App\Observers\UserSkillObserver;
use App\Observers\ApplicationObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register model observers for cache invalidation
        Job::observe(JobObserver::class);
        UserSkill::observe(UserSkillObserver::class);
        Application::observe(ApplicationObserver::class);
    }
}
