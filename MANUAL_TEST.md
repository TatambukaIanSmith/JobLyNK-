# Manual Testing Guide

## Quick Test in Tinker

Run these commands one by one in `php artisan tinker`:

### Test 1: Verify Cache Works
```php
Cache::put('test_key', 'test_value', 60);
Cache::get('test_key'); // Should return 'test_value'
```

### Test 2: Verify QueryOptimizationService Loads
```php
$service = app(\App\Services\QueryOptimizationService::class);
echo "Service loaded successfully!";
```

### Test 3: Get All Skills (Cached)
```php
$skills = app(\App\Services\QueryOptimizationService::class)->getAllSkills();
echo "Skills count: " . $skills->count();
```

### Test 4: Get All Categories (Cached)
```php
$categories = app(\App\Services\QueryOptimizationService::class)->getAllCategories();
echo "Categories count: " . $categories->count();
```

### Test 5: Test Dashboard Stats
```php
$employer = \App\Models\User::where('role', 'employer')->first();
if ($employer) {
    $stats = app(\App\Services\QueryOptimizationService::class)->getEmployerDashboardStats($employer);
    dd($stats);
} else {
    echo "No employer found. Create one first.";
}
```

### Test 6: Verify Cache Invalidation
```php
// Get a job
$job = \App\Models\Job::first();
if ($job) {
    // Get stats to populate cache
    $stats = app(\App\Services\QueryOptimizationService::class)->getEmployerDashboardStats($job->employer);
    
    // Check cache exists
    $cacheKey = "user:{$job->user_id}:dashboard:stats";
    echo "Cache exists before update: " . (Cache::has($cacheKey) ? "YES" : "NO") . "\n";
    
    // Update job
    $job->update(['title' => 'Updated Title']);
    
    // Check cache is cleared
    echo "Cache exists after update: " . (Cache::has($cacheKey) ? "YES" : "NO") . "\n";
} else {
    echo "No jobs found.";
}
```

### Test 7: Verify Database Indexes
```php
$indexes = DB::select('SHOW INDEXES FROM job_postings');
$indexNames = collect($indexes)->pluck('Key_name')->unique();
echo "Indexes found:\n";
$indexNames->each(fn($name) => echo "  - $name\n");
```

### Test 8: Performance Comparison
```php
// Enable query logging
DB::enableQueryLog();

// Get employer
$employer = \App\Models\User::where('role', 'employer')->first();

// First call - should hit database
$stats = app(\App\Services\QueryOptimizationService::class)->getEmployerDashboardStats($employer);
$queriesFirst = count(DB::getQueryLog());
echo "Queries on first call: $queriesFirst\n";

// Second call - should use cache
DB::flushQueryLog();
$stats = app(\App\Services\QueryOptimizationService::class)->getEmployerDashboardStats($employer);
$queriesSecond = count(DB::getQueryLog());
echo "Queries on second call (cached): $queriesSecond\n";
echo "Improvement: " . (($queriesFirst - $queriesSecond) / $queriesFirst * 100) . "%\n";
```

## Browser Testing

### Test Dashboard Performance

1. **Open Developer Tools** (F12)
2. **Go to Network tab**
3. **Navigate to employer dashboard**
4. **Check:**
   - Page load time (should be < 500ms)
   - Number of database queries (should be 2-3)
   - Response time (should be < 300ms)

### Test Job Matching Performance

1. **Open Developer Tools** (F12)
2. **Go to Network tab**
3. **Navigate to job suggestions/matching page**
4. **Check:**
   - Page load time (should be < 500ms)
   - Response time (should be < 200ms)

### Test Analytics Performance

1. **Open Developer Tools** (F12)
2. **Go to Network tab**
3. **Navigate to job analytics**
4. **Check:**
   - Page load time (should be < 300ms)
   - Response time (should be < 100ms)

## Expected Results

### Cache Tests
✅ Cache put/get works
✅ Service loads without errors
✅ Skills and categories return data
✅ Dashboard stats return array with keys

### Invalidation Tests
✅ Cache exists before update
✅ Cache is cleared after update
✅ Cache is cleared after delete

### Index Tests
✅ All custom indexes exist:
- idx_jobs_user_status
- idx_jobs_status_created
- idx_jobs_category
- idx_apps_job_status
- idx_apps_user_status
- idx_msgs_sender_receiver
- idx_user_skills_composite
- idx_job_skills_composite
- idx_payments_user_status
- idx_bookmarks_composite
- idx_likes_composite
- idx_activity_user_created
- idx_notifications_user_read

### Performance Tests
✅ First call: 5-10 queries
✅ Second call: 0 queries (cached)
✅ Improvement: 100% (from cache)

## Troubleshooting

### Cache Not Working
```php
// Check cache driver
config('cache.default'); // Should be 'database' or 'redis'

// Check cache table exists
Schema::hasTable('cache'); // Should return true

// Clear cache
Cache::flush();
```

### Indexes Not Found
```php
// Check if migration ran
DB::select('SHOW INDEXES FROM job_postings');

// If not, run migration
php artisan migrate --path=database/migrations/2026_03_06_122538_add_performance_indexes.php
```

### Service Not Loading
```php
// Check if file exists
file_exists(app_path('Services/QueryOptimizationService.php'));

// Check if class is correct
class_exists(\App\Services\QueryOptimizationService::class);
```

## Performance Metrics to Track

1. **Query Count**
   - Before: 12+ queries per dashboard load
   - After: 2-3 queries (first time), 0 (cached)

2. **Response Time**
   - Before: 2-3 seconds
   - After: 200-300ms

3. **Cache Hit Rate**
   - Target: > 80%
   - Monitor: Cache::get() vs Cache::miss()

4. **Database Load**
   - Before: High (many queries)
   - After: Low (cached results)

## Next Steps After Testing

1. ✅ Verify all tests pass
2. ✅ Monitor performance in production
3. ✅ Adjust cache TTL if needed
4. ✅ Add more indexes if needed
5. ✅ Document findings
