<?php

namespace Tests\Feature;

use App\Models\Job;
use App\Models\User;
use App\Models\Category;
use App\Models\Skill;
use App\Services\QueryOptimizationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class OptimizationTest extends TestCase
{
    use RefreshDatabase;

    protected QueryOptimizationService $optimizationService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->optimizationService = app(QueryOptimizationService::class);
    }

    public function test_cache_is_working(): void
    {
        Cache::put('test_key', 'test_value', 60);
        $this->assertEquals('test_value', Cache::get('test_key'));
    }

    public function test_query_optimization_service_loads(): void
    {
        $this->assertNotNull($this->optimizationService);
    }

    public function test_get_all_skills_with_caching(): void
    {
        // Create test skills
        Skill::factory()->count(5)->create();

        // First call - should query database
        DB::enableQueryLog();
        $skills1 = $this->optimizationService->getAllSkills();
        $queriesFirst = count(DB::getQueryLog());

        // Second call - should use cache
        DB::flushQueryLog();
        $skills2 = $this->optimizationService->getAllSkills();
        $queriesSecond = count(DB::getQueryLog());

        $this->assertEquals(5, $skills1->count());
        $this->assertEquals($skills1->count(), $skills2->count());
        $this->assertGreater($queriesFirst, 0);
        $this->assertEquals(0, $queriesSecond); // Should be cached
    }

    public function test_get_all_categories_with_caching(): void
    {
        // Create test categories
        Category::factory()->count(3)->create(['is_active' => true]);

        // First call - should query database
        DB::enableQueryLog();
        $categories1 = $this->optimizationService->getAllCategories();
        $queriesFirst = count(DB::getQueryLog());

        // Second call - should use cache
        DB::flushQueryLog();
        $categories2 = $this->optimizationService->getAllCategories();
        $queriesSecond = count(DB::getQueryLog());

        $this->assertEquals(3, $categories1->count());
        $this->assertEquals($categories1->count(), $categories2->count());
        $this->assertGreater($queriesFirst, 0);
        $this->assertEquals(0, $queriesSecond); // Should be cached
    }

    public function test_employer_dashboard_stats_with_caching(): void
    {
        // Create test employer
        $employer = User::factory()->create(['role' => 'employer']);

        // Create test jobs
        Job::factory()->count(5)->create(['user_id' => $employer->id, 'status' => 'active']);
        Job::factory()->count(2)->create(['user_id' => $employer->id, 'status' => 'draft']);

        // First call - should query database
        DB::enableQueryLog();
        $stats1 = $this->optimizationService->getEmployerDashboardStats($employer);
        $queriesFirst = count(DB::getQueryLog());

        // Second call - should use cache
        DB::flushQueryLog();
        $stats2 = $this->optimizationService->getEmployerDashboardStats($employer);
        $queriesSecond = count(DB::getQueryLog());

        $this->assertEquals(5, $stats1['active_jobs']);
        $this->assertEquals(2, $stats1['draft_jobs']);
        $this->assertEquals(7, $stats1['total_jobs']);
        $this->assertEquals($stats1, $stats2);
        $this->assertGreater($queriesFirst, 0);
        $this->assertEquals(0, $queriesSecond); // Should be cached
    }

    public function test_cache_invalidation_on_job_update(): void
    {
        $employer = User::factory()->create(['role' => 'employer']);
        $job = Job::factory()->create(['user_id' => $employer->id]);

        // Get stats to populate cache
        $stats1 = $this->optimizationService->getEmployerDashboardStats($employer);
        $cacheKey = "user:{$employer->id}:dashboard:stats";
        $this->assertTrue(Cache::has($cacheKey));

        // Update job - should invalidate cache
        $job->update(['status' => 'paused']);
        $this->assertFalse(Cache::has($cacheKey));
    }

    public function test_monthly_performance_with_caching(): void
    {
        $employer = User::factory()->create(['role' => 'employer']);
        Job::factory()->count(3)->create(['user_id' => $employer->id]);

        // First call
        DB::enableQueryLog();
        $performance1 = $this->optimizationService->getMonthlyPerformance($employer);
        $queriesFirst = count(DB::getQueryLog());

        // Second call - should use cache
        DB::flushQueryLog();
        $performance2 = $this->optimizationService->getMonthlyPerformance($employer);
        $queriesSecond = count(DB::getQueryLog());

        $this->assertCount(6, $performance1); // Last 6 months
        $this->assertEquals($performance1, $performance2);
        $this->assertGreater($queriesFirst, 0);
        $this->assertEquals(0, $queriesSecond); // Should be cached
    }

    public function test_payment_stats_with_caching(): void
    {
        $employer = User::factory()->create(['role' => 'employer']);

        // First call
        DB::enableQueryLog();
        $stats1 = $this->optimizationService->getPaymentStats($employer);
        $queriesFirst = count(DB::getQueryLog());

        // Second call - should use cache
        DB::flushQueryLog();
        $stats2 = $this->optimizationService->getPaymentStats($employer);
        $queriesSecond = count(DB::getQueryLog());

        $this->assertIsArray($stats1);
        $this->assertEquals($stats1, $stats2);
        $this->assertGreater($queriesFirst, 0);
        $this->assertEquals(0, $queriesSecond); // Should be cached
    }

    public function test_job_analytics_with_caching(): void
    {
        $job = Job::factory()->create();

        // First call
        DB::enableQueryLog();
        $analytics1 = $this->optimizationService->getJobAnalytics($job);
        $queriesFirst = count(DB::getQueryLog());

        // Second call - should use cache
        DB::flushQueryLog();
        $analytics2 = $this->optimizationService->getJobAnalytics($job);
        $queriesSecond = count(DB::getQueryLog());

        $this->assertIsArray($analytics1);
        $this->assertEquals($analytics1, $analytics2);
        $this->assertGreater($queriesFirst, 0);
        $this->assertEquals(0, $queriesSecond); // Should be cached
    }

    public function test_cache_invalidation_on_job_delete(): void
    {
        $employer = User::factory()->create(['role' => 'employer']);
        $job = Job::factory()->create(['user_id' => $employer->id]);

        // Get stats to populate cache
        $this->optimizationService->getEmployerDashboardStats($employer);
        $cacheKey = "user:{$employer->id}:dashboard:stats";
        $this->assertTrue(Cache::has($cacheKey));

        // Delete job - should invalidate cache
        $job->delete();
        $this->assertFalse(Cache::has($cacheKey));
    }

    public function test_database_indexes_exist(): void
    {
        $indexes = DB::select('SHOW INDEXES FROM job_postings');
        $indexNames = collect($indexes)->pluck('Key_name')->unique()->toArray();

        // Check for our custom indexes
        $this->assertContains('idx_jobs_user_status', $indexNames);
        $this->assertContains('idx_jobs_status_created', $indexNames);
        $this->assertContains('idx_jobs_category', $indexNames);
    }
}
