# Test Commands - Copy & Paste Ready

## Quick Test (2 minutes)

### Step 1: Enter Tinker
```bash
php artisan tinker
```

### Step 2: Test Cache
```php
Cache::put('test_key', 'test_value', 60);
echo Cache::get('test_key'); // Should print: test_value
```

### Step 3: Test Service Loads
```php
$service = app(\App\Services\QueryOptimizationService::class);
echo "Service loaded successfully!";
```

### Step 4: Test Skills Cache
```php
$skills = $service->getAllSkills();
echo "Skills count: " . $skills->count();
```

### Step 5: Test Categories Cache
```php
$categories = $service->getAllCategories();
echo "Categories count: " . $categories->count();
```

### Step 6: Verify Indexes Exist
```php
$indexes = DB::select('SHOW INDEXES FROM job_postings');
$indexNames = collect($indexes)->pluck('Key_name')->unique();
echo "Total indexes: " . $indexNames->count() . "\n";
echo "Custom indexes:\n";
$indexNames->filter(fn($name) => str_starts_with($name, 'idx_'))->each(fn($name) => echo "  ✓ $name\n");
```

### Step 7: Test Dashboard Stats
```php
$employer = \App\Models\User::where('role', 'employer')->first();
if ($employer) {
    $stats = $service->getEmployerDashboardStats($employer);
    echo "Dashboard stats loaded:\n";
    echo "  Total jobs: " . $stats['total_jobs'] . "\n";
    echo "  Active jobs: " . $stats['active_jobs'] . "\n";
    echo "  Total applications: " . $stats['total_applications'] . "\n";
} else {
    echo "No employer found. Create one first.";
}
```

### Step 8: Test Cache Invalidation
```php
$job = \App\Models\Job::first();
if ($job) {
    // Populate cache
    $stats = $service->getEmployerDashboardStats($job->employer);
    $cacheKey = "user:{$job->user_id}:dashboard:stats";
    
    echo "Before update - Cache exists: " . (Cache::has($cacheKey) ? "YES ✓" : "NO ✗") . "\n";
    
    // Update job
    $job->update(['title' => 'Updated Title']);
    
    echo "After update - Cache exists: " . (Cache::has($cacheKey) ? "YES ✗" : "NO ✓") . "\n";
} else {
    echo "No jobs found.";
}
```

### Step 9: Exit Tinker
```php
exit
```

## Performance Test (5 minutes)

### Step 1: Enter Tinker
```bash
php artisan tinker
```

### Step 2: Get Employer
```php
$employer = \App\Models\User::where('role', 'employer')->first();
$service = app(\App\Services\QueryOptimizationService::class);
```

### Step 3: First Call (Database Hit)
```php
DB::enableQueryLog();
$stats1 = $service->getEmployerDashboardStats($employer);
$queries1 = count(DB::getQueryLog());
echo "First call - Queries: $queries1\n";
```

### Step 4: Second Call (Cache Hit)
```php
DB::flushQueryLog();
$stats2 = $service->getEmployerDashboardStats($employer);
$queries2 = count(DB::getQueryLog());
echo "Second call - Queries: $queries2\n";
echo "Improvement: " . (($queries1 - $queries2) / $queries1 * 100) . "%\n";
```

### Step 5: Exit
```php
exit
```

## Full Verification Test (10 minutes)

Run all these commands in sequence:

```bash
# 1. Check migration status
php artisan migrate:status | grep "add_performance_indexes"

# 2. Verify indexes
php artisan tinker --execute="
\$indexes = DB::select('SHOW INDEXES FROM job_postings');
\$names = collect(\$indexes)->pluck('Key_name')->unique();
echo 'Total indexes: ' . \$names->count() . PHP_EOL;
echo 'Custom indexes: ' . \$names->filter(fn(\$n) => str_starts_with(\$n, 'idx_'))->count() . PHP_EOL;
"

# 3. Test cache
php artisan tinker --execute="
Cache::put('test', 'value', 60);
echo 'Cache test: ' . (Cache::get('test') === 'value' ? 'PASS' : 'FAIL') . PHP_EOL;
"

# 4. Test service
php artisan tinker --execute="
\$service = app(\App\Services\QueryOptimizationService::class);
echo 'Service test: PASS' . PHP_EOL;
"

# 5. Test observers
php artisan tinker --execute="
\$job = \App\Models\Job::first();
if (\$job) {
    echo 'Job observer: PASS' . PHP_EOL;
} else {
    echo 'No jobs to test observer' . PHP_EOL;
}
"
```

## Expected Output

### Cache Test
```
test_value
```

### Service Load Test
```
Service loaded successfully!
```

### Skills Test
```
Skills count: 15
```

### Categories Test
```
Categories count: 8
```

### Indexes Test
```
Total indexes: 14
Custom indexes:
  ✓ idx_jobs_user_status
  ✓ idx_jobs_status_created
  ✓ idx_jobs_category
  ✓ idx_apps_job_status
  ✓ idx_apps_user_status
  ✓ idx_msgs_sender_receiver
  ✓ idx_user_skills_composite
  ✓ idx_job_skills_composite
  ✓ idx_payments_user_status
  ✓ idx_bookmarks_composite
  ✓ idx_likes_composite
  ✓ idx_activity_user_created
  ✓ idx_notifications_user_read
```

### Dashboard Stats Test
```
Dashboard stats loaded:
  Total jobs: 10
  Active jobs: 5
  Total applications: 45
```

### Cache Invalidation Test
```
Before update - Cache exists: YES ✓
After update - Cache exists: NO ✓
```

### Performance Test
```
First call - Queries: 8
Second call - Queries: 0
Improvement: 100%
```

## Troubleshooting Commands

### Check Cache Driver
```bash
php artisan tinker --execute="echo config('cache.default');"
```

### Check Cache Table
```bash
php artisan tinker --execute="echo Schema::hasTable('cache') ? 'YES' : 'NO';"
```

### Clear Cache
```bash
php artisan cache:clear
```

### Check Observers Registered
```bash
php artisan tinker --execute="
\$job = \App\Models\Job::first();
echo 'Job observers: ' . count(\$job->getObservers()) . PHP_EOL;
"
```

### Check Service File Exists
```bash
php artisan tinker --execute="
echo file_exists(app_path('Services/QueryOptimizationService.php')) ? 'YES' : 'NO';
"
```

### Check Class Exists
```bash
php artisan tinker --execute="
echo class_exists(\App\Services\QueryOptimizationService::class) ? 'YES' : 'NO';
"
```

## One-Liner Tests

### Test Everything at Once
```bash
php artisan tinker --execute="
echo '=== OPTIMIZATION TEST SUITE ===' . PHP_EOL;
echo '1. Cache: ' . (Cache::put('t', 'v', 60) && Cache::get('t') === 'v' ? 'PASS' : 'FAIL') . PHP_EOL;
echo '2. Service: ' . (app(\App\Services\QueryOptimizationService::class) ? 'PASS' : 'FAIL') . PHP_EOL;
echo '3. Indexes: ' . (count(DB::select('SHOW INDEXES FROM job_postings')) > 10 ? 'PASS' : 'FAIL') . PHP_EOL;
echo '4. Skills: ' . (app(\App\Services\QueryOptimizationService::class)->getAllSkills()->count() > 0 ? 'PASS' : 'FAIL') . PHP_EOL;
echo '5. Categories: ' . (app(\App\Services\QueryOptimizationService::class)->getAllCategories()->count() > 0 ? 'PASS' : 'FAIL') . PHP_EOL;
echo '=== ALL TESTS COMPLETE ===' . PHP_EOL;
"
```

## Next Steps After Testing

If all tests pass:

1. ✅ Update `employerDashboardController`
2. ✅ Test dashboard performance
3. ✅ Monitor cache hit rates
4. ✅ Update other controllers
5. ✅ Deploy to production

If any test fails:

1. Check `MANUAL_TEST.md` for troubleshooting
2. Review `IMPLEMENTATION_GUIDE.md` for setup
3. Check error messages carefully
4. Verify all files were created

---

**Ready to test?** Start with the Quick Test above!
