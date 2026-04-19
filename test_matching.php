<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Testing M & M Enterprises Ltd and MJ Johnson Match ===\n\n";

// Find M & M Enterprises employer
$employer = DB::table('users')
    ->where('name', 'LIKE', '%M & M%')
    ->orWhere('company_name', 'LIKE', '%M & M%')
    ->where('account_type', 'employer')
    ->first(['id', 'name', 'company_name']);

if (!$employer) {
    echo "Employer 'M & M Enterprises Ltd' not found.\n";
    exit;
}

echo "Employer: " . ($employer->company_name ?: $employer->name) . " (ID: {$employer->id})\n\n";

// Find M & M Enterprises jobs
$jobs = DB::table('job_postings')
    ->where('user_id', $employer->id)
    ->get(['id', 'title', 'status']);

echo "Jobs from M & M Enterprises Ltd:\n";
foreach ($jobs as $job) {
    echo "- Job ID: {$job->id} | Title: {$job->title} | Status: {$job->status}\n";
    
    // Get job skills
    $jobSkills = DB::table('job_skills')
        ->join('skills', 'job_skills.skill_id', '=', 'skills.id')
        ->where('job_skills.job_id', $job->id)
        ->pluck('skills.name')
        ->toArray();
    
    echo "  Required Skills: " . (empty($jobSkills) ? "None" : implode(', ', $jobSkills)) . "\n";
}

echo "\n";

// Find MJ Johnson
$worker = DB::table('users')
    ->where('name', 'LIKE', '%Johnson%')
    ->orWhere('name', 'LIKE', '%MJ%')
    ->first(['id', 'name', 'email']);

if ($worker) {
    echo "Worker: {$worker->name} (ID: {$worker->id})\n";
    
    // Get worker skills
    $workerSkills = DB::table('user_skills')
        ->join('skills', 'user_skills.skill_id', '=', 'skills.id')
        ->where('user_skills.user_id', $worker->id)
        ->pluck('skills.name')
        ->toArray();
    
    echo "Worker Skills: " . (empty($workerSkills) ? "None" : implode(', ', $workerSkills)) . "\n\n";
    
    // Check matches
    echo "=== Match Analysis ===\n";
    foreach ($jobs as $job) {
        $jobSkills = DB::table('job_skills')
            ->join('skills', 'job_skills.skill_id', '=', 'skills.id')
            ->where('job_skills.job_id', $job->id)
            ->pluck('skills.name')
            ->toArray();
        
        if (empty($jobSkills)) {
            echo "Job '{$job->title}': No skills required - Cannot match\n";
            continue;
        }
        
        $matchingSkills = array_intersect($jobSkills, $workerSkills);
        $matchPercentage = (count($matchingSkills) / count($jobSkills)) * 100;
        
        echo "Job '{$job->title}':\n";
        echo "  - Required: " . implode(', ', $jobSkills) . "\n";
        echo "  - Matching: " . (empty($matchingSkills) ? "None" : implode(', ', $matchingSkills)) . "\n";
        echo "  - Match %: " . round($matchPercentage, 2) . "%\n";
        echo "  - Result: " . ($matchPercentage >= 50 ? "✓ MATCH (≥50%)" : "✗ NO MATCH (<50%)") . "\n\n";
    }
} else {
    echo "Worker 'MJ Johnson' not found in database.\n";
}
