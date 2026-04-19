<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Job;
use App\Models\Skill;
use App\Models\UserSkill;
use App\Models\JobSkill;
use App\Services\JobMatchingService;

class TestNotificationSystem extends Command
{
    protected $signature = 'test:notifications';
    protected $description = 'Test the job notification system';

    public function handle()
    {
        $this->info('🧪 Testing Job Notification System...');
        
        // Find a worker and employer
        $worker = User::where('role', 'worker')->first();
        $employer = User::where('role', 'employer')->first();
        
        if (!$worker) {
            $this->error('❌ No worker found. Create a worker account first.');
            return;
        }
        
        if (!$employer) {
            $this->error('❌ No employer found. Create an employer account first.');
            return;
        }
        
        $this->info("👤 Testing with Worker: {$worker->name}");
        $this->info("🏢 Testing with Employer: {$employer->name}");
        
        // Get a skill to test with
        $skill = Skill::first();
        if (!$skill) {
            $this->error('❌ No skills found. Run the seeder first.');
            return;
        }
        
        $this->info("🛠️ Testing with Skill: {$skill->name}");
        
        // Add skill to worker if not already added
        $userSkill = UserSkill::firstOrCreate([
            'user_id' => $worker->id,
            'skill_id' => $skill->id
        ], [
            'proficiency_level' => 'Intermediate',
            'years_experience' => 2
        ]);
        
        $this->info("✅ Added skill '{$skill->name}' to worker");
        
        // Create a test job
        $job = Job::create([
            'user_id' => $employer->id,
            'category_id' => 1,
            'title' => 'Test Job for Notification System',
            'description' => 'This is a test job to verify notifications work',
            'location' => 'Test Location',
            'job_type' => 'one-time',
            'payment_type' => 'fixed',
            'budget' => 100,
            'start_date' => now()->addDay(),
            'urgency' => 'normal',
            'status' => 'active'
        ]);
        
        $this->info("📝 Created test job: {$job->title}");
        
        // Add the skill requirement to the job
        JobSkill::create([
            'job_id' => $job->id,
            'skill_id' => $skill->id,
            'required_level' => 'Beginner',
            'is_required' => true
        ]);
        
        $this->info("🎯 Added skill requirement to job");
        
        // Test the matching service
        $matchingService = app(JobMatchingService::class);
        
        // Find matching workers for the job
        $matchingWorkers = $matchingService->findMatchingWorkers($job);
        $this->info("🔍 Found {$matchingWorkers->count()} matching workers");
        
        // Create notifications
        $notificationsCreated = $matchingService->createJobNotifications($job);
        $this->info("🔔 Created {$notificationsCreated} job notifications");
        
        // Check if notification was created for our test worker
        $notification = \App\Models\JobNotification::where('user_id', $worker->id)
            ->where('job_id', $job->id)
            ->where('type', 'job_match')
            ->first();
            
        if ($notification) {
            $this->info("✅ SUCCESS: Notification created for worker!");
            $this->info("   Match Score: {$notification->match_score}%");
            $this->info("   Created: {$notification->created_at}");
        } else {
            $this->error("❌ FAILED: No notification created for worker");
        }
        
        // Test finding matching jobs for worker
        $matchingJobs = $matchingService->findMatchingJobs($worker);
        $this->info("🎯 Found {$matchingJobs->count()} matching jobs for worker");
        
        // Clean up test data
        $job->delete();
        $this->info("🧹 Cleaned up test job");
        
        $this->info("🎉 Notification system test completed!");
    }
}