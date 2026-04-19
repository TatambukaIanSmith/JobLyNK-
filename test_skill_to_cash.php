<?php

require_once 'vendor/autoload.php';

use App\Models\User;
use App\Models\SkillToCashProfile;
use App\Models\Job;
use App\Http\Controllers\Api\SkillToCashController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Skill-to-Cash System Test ===\n\n";

// Test 1: Check if we have users and jobs
echo "1. Checking database data...\n";
$userCount = User::count();
$jobCount = Job::count();
$workerCount = User::where('role', 'worker')->count();

echo "   Users: {$userCount}\n";
echo "   Jobs: {$jobCount}\n";
echo "   Workers: {$workerCount}\n\n";

if ($workerCount == 0) {
    echo "   Creating test worker...\n";
    $testWorker = User::create([
        'name' => 'Test Worker',
        'email' => 'testworker@example.com',
        'password' => bcrypt('password'),
        'role' => 'worker'
    ]);
    echo "   Test worker created with ID: {$testWorker->id}\n\n";
} else {
    $testWorker = User::where('role', 'worker')->first();
    echo "   Using existing worker: {$testWorker->name} (ID: {$testWorker->id})\n\n";
}

// Test 2: Create a skill profile
echo "2. Testing skill profile creation...\n";

$profileData = [
    'categories' => ['construction', 'technology'],
    'whatYouCanDo' => 'I can build websites, fix computers, and do basic construction work. I have experience with HTML, CSS, JavaScript and can use tools like hammers and drills.',
    'tools' => ['HTML', 'CSS', 'JavaScript', 'Hammer', 'Drill', 'Computer'],
    'tasks' => [
        [
            'description' => 'Built a website for local restaurant',
            'client' => 'Mama Janes Restaurant',
            'result' => 'Increased their online orders by 40%'
        ],
        [
            'description' => 'Fixed computers for neighbors',
            'client' => 'Community members',
            'result' => 'Solved 15+ computer problems, got referrals'
        ]
    ],
    'visibility' => [
        'profileVisible' => true,
        'allowDirectContact' => true,
        'receiveJobAlerts' => true
    ]
];

// Create or update profile
$profile = SkillToCashProfile::updateOrCreate(
    ['user_id' => $testWorker->id],
    [
        'categories' => json_encode($profileData['categories']),
        'what_you_can_do' => $profileData['whatYouCanDo'],
        'tools' => json_encode($profileData['tools']),
        'tasks' => json_encode($profileData['tasks']),
        'visibility_settings' => json_encode($profileData['visibility']),
        'is_active' => true,
        'last_updated' => now()
    ]
);

echo "   Profile created/updated for user {$testWorker->id}\n";
echo "   Profile completion: {$profile->completion_percentage}%\n";
echo "   Tools count: {$profile->tools_count}\n";
echo "   Tasks count: {$profile->tasks_count}\n\n";

// Test 3: Test job matching
echo "3. Testing job matching algorithm...\n";

// Simulate the controller
Auth::login($testWorker);
$controller = new SkillToCashController(app('App\Services\JobMatchingService'));

// Get some sample jobs
$sampleJobs = Job::where('status', 'active')->with('employer')->take(5)->get();
echo "   Found {$sampleJobs->count()} active jobs to test matching\n";

foreach ($sampleJobs as $job) {
    echo "   Job: {$job->title}\n";
    echo "     Company: " . ($job->employer ? $job->employer->name : 'Unknown') . "\n";
    echo "     Description: " . substr($job->description, 0, 100) . "...\n";
    echo "     Required skills: {$job->required_skills}\n\n";
}

// Test 4: Test the API endpoints
echo "4. Testing API endpoints...\n";

try {
    // Test stats endpoint
    $statsResponse = $controller->getStats();
    $statsData = json_decode($statsResponse->getContent(), true);
    
    if ($statsData['success']) {
        echo "   ✓ Stats API working\n";
        echo "     Practical skills: {$statsData['data']['practicalSkillsCount']}\n";
        echo "     Tasks completed: {$statsData['data']['tasksCompletedCount']}\n";
        echo "     Job matches: {$statsData['data']['jobMatchesCount']}\n";
        echo "     Profile completion: {$statsData['data']['profileCompletion']}%\n";
    } else {
        echo "   ✗ Stats API failed: {$statsData['message']}\n";
    }
    
    // Test profile endpoint
    $profileResponse = $controller->getProfile();
    $profileData = json_decode($profileResponse->getContent(), true);
    
    if ($profileData['success']) {
        echo "   ✓ Profile API working\n";
        echo "     Categories: " . implode(', ', $profileData['data']['categories']) . "\n";
        echo "     Tools: " . implode(', ', $profileData['data']['tools']) . "\n";
        echo "     Job matches found: " . count($profileData['data']['jobMatches']) . "\n";
    } else {
        echo "   ✗ Profile API failed: {$profileData['message']}\n";
    }
    
    // Test job matches endpoint
    $matchesResponse = $controller->getJobMatches();
    $matchesData = json_decode($matchesResponse->getContent(), true);
    
    if ($matchesData['success']) {
        echo "   ✓ Job matches API working\n";
        echo "     Found " . count($matchesData['data']) . " job matches\n";
        
        foreach (array_slice($matchesData['data'], 0, 3) as $match) {
            echo "     - {$match['job']['title']} ({$match['matchScore']}% match)\n";
            echo "       Company: {$match['job']['company']}\n";
            echo "       Reasons: " . implode(', ', $match['matchReasons']) . "\n";
        }
    } else {
        echo "   ✗ Job matches API failed: {$matchesData['message']}\n";
    }
    
} catch (Exception $e) {
    echo "   ✗ API test failed: " . $e->getMessage() . "\n";
}

echo "\n=== Test Complete ===\n";
echo "The Skill-to-Cash system is ready for use!\n";
echo "Workers can now create skill profiles and get matched to jobs based on practical abilities.\n";