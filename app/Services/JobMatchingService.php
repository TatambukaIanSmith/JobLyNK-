<?php

namespace App\Services;

use App\Models\User;
use App\Models\Job;
use App\Models\JobNotification;
use App\Models\UserSkill;
use App\Models\JobSkill;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class JobMatchingService
{
    private const CACHE_TTL = 3600; // 1 hour

    /**
     * Find matching workers for a job
     */
    public function findMatchingWorkers(Job $job, int $limit = 50): Collection
    {
        $cacheKey = "job:{$job->id}:matching:workers:{$limit}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($job, $limit) {
            $jobSkills = $job->jobSkills()->with('skill')->get();
            
            if ($jobSkills->isEmpty()) {
                return collect();
            }

            // Get all workers who have at least one matching skill
            $skillIds = $jobSkills->pluck('skill_id')->toArray();
            
            $workers = User::where('role', 'worker')
                ->where('is_suspended', false)
                ->whereHas('userSkills', function ($query) use ($skillIds) {
                    $query->whereIn('skill_id', $skillIds);
                })
                ->with(['userSkills.skill', 'jobPreferences'])
                ->get();

            // Calculate match scores for each worker
            $matchedWorkers = $workers->map(function ($worker) use ($job, $jobSkills) {
                $matchScore = $this->calculateWorkerJobMatchScore($worker, $job, $jobSkills);
                
                if ($matchScore > 0) {
                    return [
                        'worker' => $worker,
                        'match_score' => $matchScore,
                        'matching_skills' => $this->getMatchingSkills($worker, $jobSkills)
                    ];
                }
                
                return null;
            })->filter()->sortByDesc('match_score')->take($limit);

            return $matchedWorkers;
        });
    }

    /**
     * Find matching jobs for a worker
     */
    public function findMatchingJobs(User $worker, int $limit = 50): Collection
    {
        $cacheKey = "worker:{$worker->id}:matching:jobs:{$limit}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($worker, $limit) {
            if ($worker->role !== 'worker') {
                return collect();
            }

            $workerSkills = $worker->userSkills()->with('skill')->get();
            
            if ($workerSkills->isEmpty()) {
                return collect();
            }

            // Get worker preferences
            $preferences = $worker->jobPreferences;

            // Get all active jobs that require skills the worker has
            $skillIds = $workerSkills->pluck('skill_id')->toArray();
            
            $jobs = Job::where('status', 'active')
                ->whereHas('jobSkills', function ($query) use ($skillIds) {
                    $query->whereIn('skill_id', $skillIds);
                })
                ->with(['jobSkills.skill', 'employer', 'category'])
                ->get();

            // Calculate match scores for each job
            $matchedJobs = $jobs->map(function ($job) use ($worker, $workerSkills, $preferences) {
                $matchScore = $this->calculateJobWorkerMatchScore($job, $worker, $workerSkills, $preferences);
                
                if ($matchScore > 0) {
                    return [
                        'job' => $job,
                        'match_score' => $matchScore,
                        'matching_skills' => $this->getJobMatchingSkills($job, $workerSkills)
                    ];
                }
                
                return null;
            })->filter()->sortByDesc('match_score')->take($limit);

            return $matchedJobs;
        });
    }

    /**
     * Calculate match score between worker and job
     */
    private function calculateWorkerJobMatchScore(User $worker, Job $job, Collection $jobSkills): float
    {
        $workerSkills = $worker->userSkills()->with('skill')->get();
        $preferences = $worker->jobPreferences;
        
        $totalScore = 0;
        $maxPossibleScore = 0;

        // Skills matching (70% of total score)
        $skillsScore = $this->calculateSkillsMatchScore($workerSkills, $jobSkills);
        $totalScore += $skillsScore * 0.7;
        $maxPossibleScore += 100 * 0.7;

        // Preferences matching (30% of total score)
        if ($preferences) {
            $preferencesScore = $this->calculatePreferencesMatchScore($preferences, $job);
            $totalScore += $preferencesScore * 0.3;
        }
        $maxPossibleScore += 100 * 0.3;

        return $maxPossibleScore > 0 ? ($totalScore / $maxPossibleScore) * 100 : 0;
    }

    /**
     * Calculate match score between job and worker
     */
    private function calculateJobWorkerMatchScore(Job $job, User $worker, Collection $workerSkills, $preferences): float
    {
        $jobSkills = $job->jobSkills()->with('skill')->get();
        
        $totalScore = 0;
        $maxPossibleScore = 0;

        // Skills matching (70% of total score)
        $skillsScore = $this->calculateSkillsMatchScore($workerSkills, $jobSkills);
        $totalScore += $skillsScore * 0.7;
        $maxPossibleScore += 100 * 0.7;

        // Preferences matching (30% of total score)
        if ($preferences) {
            $preferencesScore = $this->calculatePreferencesMatchScore($preferences, $job);
            $totalScore += $preferencesScore * 0.3;
        }
        $maxPossibleScore += 100 * 0.3;

        return $maxPossibleScore > 0 ? ($totalScore / $maxPossibleScore) * 100 : 0;
    }

    /**
     * Calculate skills match score
     */
    private function calculateSkillsMatchScore(Collection $workerSkills, Collection $jobSkills): float
    {
        if ($jobSkills->isEmpty()) {
            return 0;
        }

        $totalJobSkillsWeight = 0;
        $matchedSkillsWeight = 0;

        foreach ($jobSkills as $jobSkill) {
            $weight = $jobSkill->is_required ? 2 : 1; // Required skills have double weight
            $totalJobSkillsWeight += $weight;

            $workerSkill = $workerSkills->firstWhere('skill_id', $jobSkill->skill_id);
            
            if ($workerSkill) {
                $proficiencyMatch = $this->calculateProficiencyMatch(
                    $workerSkill->proficiency_level,
                    $jobSkill->required_level
                );
                
                $matchedSkillsWeight += $weight * $proficiencyMatch;
            }
        }

        return $totalJobSkillsWeight > 0 ? ($matchedSkillsWeight / $totalJobSkillsWeight) * 100 : 0;
    }

    /**
     * Calculate proficiency match between worker and job requirement
     */
    private function calculateProficiencyMatch(string $workerLevel, string $requiredLevel): float
    {
        $levels = [
            'Beginner' => 1,
            'Intermediate' => 2,
            'Advanced' => 3,
            'Expert' => 4
        ];

        $workerScore = $levels[$workerLevel] ?? 1;
        $requiredScore = $levels[$requiredLevel] ?? 1;

        if ($workerScore >= $requiredScore) {
            return 1.0; // Perfect match or overqualified
        } else {
            return $workerScore / $requiredScore; // Partial match
        }
    }

    /**
     * Calculate preferences match score
     */
    private function calculatePreferencesMatchScore($preferences, Job $job): float
    {
        $score = 0;
        $factors = 0;

        // Job category match
        if ($preferences->job_category_ids && $job->category_id) {
            $factors++;
            if (in_array($job->category_id, $preferences->job_category_ids)) {
                $score += 100;
            }
        }

        // Salary match
        if ($preferences->min_salary || $preferences->max_salary) {
            $factors++;
            if ($preferences->matchesSalaryRange($job->budget)) {
                $score += 100;
            }
        }

        // Location match
        if ($preferences->preferred_location || $preferences->remote_work_preference) {
            $factors++;
            if ($preferences->matchesLocation($job->location, $job->job_type === 'remote')) {
                $score += 100;
            }
        }

        return $factors > 0 ? $score / $factors : 100;
    }

    /**
     * Get matching skills between worker and job
     */
    private function getMatchingSkills(User $worker, Collection $jobSkills): Collection
    {
        $workerSkills = $worker->userSkills()->with('skill')->get();
        
        return $jobSkills->filter(function ($jobSkill) use ($workerSkills) {
            return $workerSkills->contains('skill_id', $jobSkill->skill_id);
        })->map(function ($jobSkill) use ($workerSkills) {
            $workerSkill = $workerSkills->firstWhere('skill_id', $jobSkill->skill_id);
            
            return [
                'skill' => $jobSkill->skill,
                'worker_level' => $workerSkill->proficiency_level,
                'required_level' => $jobSkill->required_level,
                'is_required' => $jobSkill->is_required,
                'match_quality' => $this->calculateProficiencyMatch(
                    $workerSkill->proficiency_level,
                    $jobSkill->required_level
                )
            ];
        });
    }

    /**
     * Get matching skills between job and worker
     */
    private function getJobMatchingSkills(Job $job, Collection $workerSkills): Collection
    {
        $jobSkills = $job->jobSkills()->with('skill')->get();
        
        return $workerSkills->filter(function ($workerSkill) use ($jobSkills) {
            return $jobSkills->contains('skill_id', $workerSkill->skill_id);
        })->map(function ($workerSkill) use ($jobSkills) {
            $jobSkill = $jobSkills->firstWhere('skill_id', $workerSkill->skill_id);
            
            return [
                'skill' => $workerSkill->skill,
                'worker_level' => $workerSkill->proficiency_level,
                'required_level' => $jobSkill->required_level,
                'is_required' => $jobSkill->is_required,
                'match_quality' => $this->calculateProficiencyMatch(
                    $workerSkill->proficiency_level,
                    $jobSkill->required_level
                )
            ];
        });
    }

    /**
     * Create job notifications for matching workers
     */
    public function createJobNotifications(Job $job, float $minMatchScore = 50): int
    {
        $matchingWorkers = $this->findMatchingWorkers($job);
        $notificationsCreated = 0;

        foreach ($matchingWorkers as $match) {
            if ($match['match_score'] >= $minMatchScore) {
                $worker = $match['worker'];
                
                // Check if worker wants notifications
                $preferences = $worker->jobPreferences;
                if ($preferences && !$preferences->receive_notifications) {
                    continue;
                }

                // Create notification if it doesn't exist
                $notification = JobNotification::firstOrCreate([
                    'user_id' => $worker->id,
                    'job_id' => $job->id,
                    'type' => 'job_match'
                ], [
                    'match_score' => $match['match_score']
                ]);

                if ($notification->wasRecentlyCreated) {
                    $notificationsCreated++;
                }
            }
        }

        return $notificationsCreated;
    }

    /**
     * Create worker notifications for matching jobs
     */
    public function createWorkerNotifications(User $worker, float $minMatchScore = 50): int
    {
        if ($worker->role !== 'worker') {
            return 0;
        }

        $matchingJobs = $this->findMatchingJobs($worker);
        $notificationsCreated = 0;

        foreach ($matchingJobs as $match) {
            if ($match['match_score'] >= $minMatchScore) {
                $job = $match['job'];
                
                // Create notification for employer about this worker
                // For worker_match notifications:
                // - user_id = worker who matches (so we can get worker details)
                // - job_id = the job that the worker matches
                // - The employer is found through job->employer relationship
                $notification = JobNotification::firstOrCreate([
                    'user_id' => $worker->id,  // The worker who matches
                    'job_id' => $job->id,
                    'type' => 'worker_match'
                ], [
                    'match_score' => $match['match_score']
                ]);

                if ($notification->wasRecentlyCreated) {
                    $notificationsCreated++;
                }
            }
        }

        return $notificationsCreated;
    }

    /**
     * Invalidate matching cache for a job
     */
    public function invalidateJobMatchCache(Job $job): void
    {
        Cache::forget("job:{$job->id}:matching:workers:50");
        Cache::forget("job:{$job->id}:matching:workers:20");
        Cache::forget("job:{$job->id}:matching:workers:10");
    }

    /**
     * Invalidate matching cache for a worker
     */
    public function invalidateWorkerMatchCache(User $worker): void
    {
        Cache::forget("worker:{$worker->id}:matching:jobs:50");
        Cache::forget("worker:{$worker->id}:matching:jobs:20");
        Cache::forget("worker:{$worker->id}:matching:jobs:10");
    }
}