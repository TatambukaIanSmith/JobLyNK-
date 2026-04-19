# Database Query Optimization & Caching Strategy

## Current Issues Identified

### 1. N+1 Query Problems
- **employerDashboardController::employers()** - Multiple queries in loops
  - `getMonthlyPerformance()` runs 6 queries (one per month)
  - `getPaymentStats()` queries payments without eager loading
  - Bookmarks/Likes counted separately with `whereIn()`

- **JobMatchingService** - Heavy computation without caching
  - `findMatchingWorkers()` calculates scores for every worker
  - `findMatchingJobs()` calculates scores for every job
  - No caching of skill relationships

### 2. Missing Eager Loading
- Applications loaded without user/job relationships
- Messages loaded without sender/receiver
- Jobs loaded without category/skills

### 3. Inefficient Calculations
- Monthly performance recalculated on every dashboard load
- Payment stats recalculated every time
- Skill matching scores recalculated for every request

## Optimization Strategy

### Phase 1: Query Optimization (Immediate)
1. Add eager loading to all queries
2. Use `withCount()` for aggregations
3. Batch queries where possible
4. Use database-level calculations

### Phase 2: Caching Layer (Short-term)
1. Cache frequently accessed data (skills, categories)
2. Cache user-specific data (dashboard stats, job matches)
3. Implement cache invalidation on data changes
4. Use Redis for performance-critical data

### Phase 3: Advanced Optimization (Long-term)
1. Implement materialized views for analytics
2. Add database indexes for common queries
3. Implement query result caching
4. Add background jobs for heavy computations

## Implementation Plan

### Cache Keys Strategy
```
user:{userId}:dashboard:stats
user:{userId}:job:matches
job:{jobId}:skill:matches
skill:all
category:all
user:{userId}:monthly:performance
```

### TTL Strategy
- Static data (skills, categories): 24 hours
- User-specific data: 1 hour
- Real-time data (messages, applications): 5 minutes
- Analytics: 30 minutes

### Cache Invalidation Events
- User updates profile → invalidate user cache
- Job created/updated → invalidate job matches
- Application submitted → invalidate job stats
- Skill added → invalidate skill cache
