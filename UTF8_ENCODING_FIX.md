# UTF-8 Encoding Fix for Location API

## Issue
The `/api/location/job-radar` endpoint was returning a 500 Internal Server Error with the message:
```
Malformed UTF-8 characters, possibly incorrectly encoded
```

## Root Cause
Some job records in the database contain invalid UTF-8 characters in fields like:
- `title`
- `description`
- `location`

When Laravel tries to encode these as JSON, it fails because JSON requires valid UTF-8.

## Solution
Added UTF-8 sanitization to both location API endpoints:

### 1. `getJobRadar()` method
### 2. `getNearbyJobs()` method

Both methods now:
1. Fetch jobs from the database
2. Map through each job and sanitize text fields using `mb_convert_encoding()`
3. Return only the necessary fields with clean UTF-8 data

## Code Changes

**File**: `app/Http/Controllers/LocationJobController.php`

```php
// Sanitize job data to ensure valid UTF-8
$sanitizedJobs = $jobs->map(function ($job) {
    return [
        'id' => $job->id,
        'title' => mb_convert_encoding($job->title ?? '', 'UTF-8', 'UTF-8'),
        'description' => mb_convert_encoding($job->description ?? '', 'UTF-8', 'UTF-8'),
        'location' => mb_convert_encoding($job->location ?? '', 'UTF-8', 'UTF-8'),
        'latitude' => $job->latitude,
        'longitude' => $job->longitude,
        'distance' => $job->distance,
        'budget' => $job->budget,
        'job_type' => $job->job_type,
        'status' => $job->status,
        'created_at' => $job->created_at,
        'updated_at' => $job->updated_at,
    ];
})->values();
```

## Benefits

1. **Prevents JSON encoding errors** - All text is guaranteed to be valid UTF-8
2. **Selective field exposure** - Only returns necessary fields, improving security
3. **Consistent data structure** - All jobs have the same fields
4. **Handles null values** - Uses null coalescing operator (`??`) to prevent errors

## Testing

After applying this fix:
1. Clear cache: `php artisan config:clear && php artisan cache:clear`
2. Visit `/nearby-jobs`
3. Allow location access
4. Jobs should now load successfully

## Long-term Solution

To prevent this issue in the future, consider:

1. **Database Cleanup**: Find and fix records with invalid UTF-8
```sql
-- Find jobs with invalid UTF-8 in title
SELECT id, title FROM job_postings 
WHERE title != CONVERT(CAST(CONVERT(title USING latin1) AS BINARY) USING utf8mb4);
```

2. **Input Validation**: Add UTF-8 validation when creating/updating jobs
```php
$request->validate([
    'title' => 'required|string|max:255',
    'description' => 'required|string',
    'location' => 'required|string',
]);

// Sanitize before saving
$job->title = mb_convert_encoding($request->title, 'UTF-8', 'UTF-8');
```

3. **Database Charset**: Ensure database uses `utf8mb4` charset
```sql
ALTER TABLE job_postings CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

## Status
✅ **Fixed** - Location API now returns valid JSON with sanitized UTF-8 data
