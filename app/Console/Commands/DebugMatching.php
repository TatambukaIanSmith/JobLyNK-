<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Job;
use App\Models\UserSkill;
use App\Models\JobSkill;
use App\Models\JobNotification;

class DebugMatching extends Command
{
    protected $signature = 'debug:matching';
    protected $description = 'Debug why matching is not working';

    public function handle()
    {
        $this->info('🔍 Debugging Matching System...');
        
        // Check recent workers with skills
        $this->info("\n📊 WORKERS WITH SKILLS:");
        $workersWithSkills = User::where('role', 'worker')
            ->whereHas('userSkills')
            ->with(['userSkills.skill'])
            ->get();
            
        foreach ($workersWithSkills as $worker) {
            $this->info("👤 {$worker->name} ({$worker->email}):");
            foreach ($worker->userSkills as $userSkill) {
                $this->info("   - {$userSkill->skill->name} ({$userSkill->proficiency_level}, {$userSkill->years_experience} years)");
            }
        }
        
        // Check recent jobs with skills
        $this->info("\n📊 JOBS WITH SKILL REQUIREMENTS:");
        $jobsWithSkills = Job::where('status', 'active')
            ->whereHas('jobSkills')
            ->with(['jobSkills.skill', 'employer'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        foreach ($jobsWithSkills as $job) {
            $this->info("💼 {$job->title} (by {$job->employer->name}):");
            foreach ($job->jobSkills as $jobSkill) {
                $this->info("   - Requires: {$jobSkill->skill->name} ({$jobSkill->required_level}, " . ($jobSkill->is_required ? 'Required' : 'Preferred') . ")");
            }
        }
        
        // Check notifications
        $this->info("\n📊 RECENT NOTIFICATIONS:");
        $notifications = JobNotification::with(['user', 'job'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
            
        if ($notifications->count() > 0) {
            foreach ($notifications as $notification) {
                $jobTitle = $notification->job ? $notification->job->title : 'Job Deleted';
                $this->info("🔔 {$notification->type}: {$notification->user->name} -> {$jobTitle} ({$notification->match_score}%)");
            }
        } else {
            $this->error("❌ NO NOTIFICATIONS FOUND!");
        }
        
        // Check ALL notifications by type
        $this->info("\n📊 ALL NOTIFICATIONS BY TYPE:");
        $allNotifications = JobNotification::with(['user', 'job'])->get();
        $jobMatches = $allNotifications->where('type', 'job_match');
        $workerMatches = $allNotifications->where('type', 'worker_match');
        
        $this->info("👤 Job matches for workers: " . $jobMatches->count());
        foreach ($jobMatches as $notification) {
            $jobTitle = $notification->job ? $notification->job->title : 'Job Deleted';
            $this->info("   - {$notification->user->name} -> {$jobTitle} ({$notification->match_score}%)");
        }
        
        $this->info("💼 Worker matches for employers: " . $workerMatches->count());
        foreach ($workerMatches as $notification) {
            $jobTitle = $notification->job ? $notification->job->title : 'Job Deleted';
            $this->info("   - {$notification->user->name} -> {$jobTitle} ({$notification->match_score}%)");
        }
        
        // Check if job posting is triggering notifications
        $this->info("\n🔍 CHECKING LATEST JOB...");
        $latestJob = Job::with(['jobSkills.skill', 'employer'])
            ->orderBy('created_at', 'desc')
            ->first();
            
        if ($latestJob) {
            $this->info("📝 Latest Job: {$latestJob->title}");
            $this->info("   Posted by: {$latestJob->employer->name}");
            $this->info("   Status: {$latestJob->status}");
            $this->info("   Created: {$latestJob->created_at}");
            
            if ($latestJob->jobSkills->count() > 0) {
                $this->info("   Required Skills:");
                foreach ($latestJob->jobSkills as $jobSkill) {
                    $this->info("     - {$jobSkill->skill->name}");
                }
                
                // Test matching manually
                $matchingService = app(\App\Services\JobMatchingService::class);
                $matchingWorkers = $matchingService->findMatchingWorkers($latestJob);
                $this->info("   🎯 Found {$matchingWorkers->count()} matching workers");
                
                foreach ($matchingWorkers as $match) {
                    $this->info("     - {$match['worker']->name}: {$match['match_score']}% match");
                }
            } else {
                $this->error("   ❌ No skills attached to this job!");
            }
        }
        
        // Check if the job posting controller is calling the matching service
        $this->info("\n🔍 DEBUGGING TIPS:");
        $this->info("1. Check if job posting form is sending skills data");
        $this->info("2. Verify JobSkill records are being created");
        $this->info("3. Ensure matching service is called after job creation");
        $this->info("4. Check browser network tab for API errors");
    }
}