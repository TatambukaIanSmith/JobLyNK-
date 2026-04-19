<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SkillToCashProfile;
use App\Models\Job;
use App\Services\JobMatchingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SkillToCashController extends Controller
{
    protected $jobMatchingService;

    public function __construct(JobMatchingService $jobMatchingService)
    {
        $this->jobMatchingService = $jobMatchingService;
    }

    /**
     * Get user's skill-to-cash profile
     */
    public function getProfile()
    {
        $user = Auth::user();
        $profile = SkillToCashProfile::where('user_id', $user->id)->first();

        if (!$profile) {
            return response()->json([
                'success' => false,
                'message' => 'No skill profile found',
                'data' => null
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'categories' => json_decode($profile->categories, true) ?? [],
                'whatYouCanDo' => $profile->what_you_can_do,
                'tools' => json_decode($profile->tools, true) ?? [],
                'tasks' => json_decode($profile->tasks, true) ?? [],
                'visibility' => json_decode($profile->visibility_settings, true) ?? [],
                'profileCompletion' => $this->calculateProfileCompletion($profile),
                'jobMatches' => $this->getJobMatches($profile)
            ]
        ]);
    }

    /**
     * Save or update skill-to-cash profile
     */
    public function saveProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'categories' => 'required|array|min:1',
            'whatYouCanDo' => 'required|string|min:10',
            'tools' => 'required|array|min:1',
            'tasks' => 'required|array|min:1',
            'visibility' => 'required|array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();

        // Create or update profile
        $profile = SkillToCashProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'categories' => json_encode($request->categories),
                'what_you_can_do' => $request->whatYouCanDo,
                'tools' => json_encode($request->tools),
                'tasks' => json_encode($request->tasks),
                'visibility_settings' => json_encode($request->visibility),
                'is_active' => true,
                'last_updated' => now()
            ]
        );

        // Calculate profile completion
        $completion = $this->calculateProfileCompletion($profile);

        // Find job matches
        $jobMatches = $this->findJobMatches($profile);

        // Send notifications to employers if profile is visible
        if ($request->visibility['profileVisible'] ?? false) {
            $this->notifyEmployersOfNewProfile($profile);
        }

        return response()->json([
            'success' => true,
            'message' => 'Skill profile saved successfully!',
            'data' => [
                'profileCompletion' => $completion,
                'jobMatches' => $jobMatches,
                'matchCount' => count($jobMatches)
            ]
        ]);
    }

    /**
     * Get job matches for user's skill profile
     */
    public function getJobMatches()
    {
        $user = Auth::user();
        $profile = SkillToCashProfile::where('user_id', $user->id)->first();

        if (!$profile) {
            return response()->json([
                'success' => false,
                'message' => 'No skill profile found'
            ]);
        }

        $matches = $this->findJobMatches($profile);

        return response()->json([
            'success' => true,
            'data' => $matches
        ]);
    }

    /**
     * Update profile visibility settings
     */
    public function updateVisibility(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profileVisible' => 'required|boolean',
            'allowDirectContact' => 'required|boolean',
            'receiveJobAlerts' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();
        $profile = SkillToCashProfile::where('user_id', $user->id)->first();

        if (!$profile) {
            return response()->json([
                'success' => false,
                'message' => 'No skill profile found'
            ]);
        }

        $profile->update([
            'visibility_settings' => json_encode($request->all()),
            'is_active' => $request->profileVisible
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Visibility settings updated successfully'
        ]);
    }

    /**
     * Calculate profile completion percentage
     */
    private function calculateProfileCompletion($profile)
    {
        $completion = 0;
        $totalFields = 4;

        // Check categories
        $categories = json_decode($profile->categories, true);
        if (!empty($categories)) $completion += 25;

        // Check description
        if (!empty($profile->what_you_can_do) && strlen($profile->what_you_can_do) >= 10) {
            $completion += 25;
        }

        // Check tools
        $tools = json_decode($profile->tools, true);
        if (!empty($tools)) $completion += 25;

        // Check tasks
        $tasks = json_decode($profile->tasks, true);
        if (!empty($tasks)) $completion += 25;

        return $completion;
    }

    /**
     * Find job matches based on skill profile
     */
    private function findJobMatches($profile)
    {
        $categories = json_decode($profile->categories, true) ?? [];
        $tools = json_decode($profile->tools, true) ?? [];
        $description = $profile->what_you_can_do;

        // Get active jobs
        $jobs = Job::where('status', 'active')
            ->with('employer') // Load the employer relationship
            ->get();

        $matches = [];

        foreach ($jobs as $job) {
            $matchScore = $this->calculateJobMatchScore($job, $categories, $tools, $description);
            
            if ($matchScore > 0) {
                $matches[] = [
                    'job' => [
                        'id' => $job->id,
                        'title' => $job->title,
                        'company' => $job->employer ? $job->employer->name : 'Unknown Company',
                        'location' => $job->location,
                        'budget' => $job->budget ? 'UGX ' . number_format($job->budget) : 'Negotiable',
                        'payment_type' => $job->payment_type,
                        'job_type' => $job->job_type,
                        'description' => substr($job->description, 0, 150) . '...',
                        'posted_at' => $job->created_at->diffForHumans()
                    ],
                    'matchScore' => $matchScore,
                    'matchReasons' => $this->getMatchReasons($job, $categories, $tools, $description)
                ];
            }
        }

        // Sort by match score
        usort($matches, function($a, $b) {
            return $b['matchScore'] <=> $a['matchScore'];
        });

        return array_slice($matches, 0, 10); // Return top 10 matches
    }

    /**
     * Calculate match score between job and skill profile
     */
    private function calculateJobMatchScore($job, $categories, $tools, $description)
    {
        $score = 0;
        $jobText = strtolower($job->title . ' ' . $job->description . ' ' . $job->required_skills);

        // Category matching (40% weight)
        foreach ($categories as $category) {
            if (strpos($jobText, strtolower($category)) !== false) {
                $score += 40;
                break;
            }
        }

        // Tool matching (30% weight)
        $toolMatches = 0;
        foreach ($tools as $tool) {
            if (strpos($jobText, strtolower($tool)) !== false) {
                $toolMatches++;
            }
        }
        if ($toolMatches > 0) {
            $score += min(30, $toolMatches * 10);
        }

        // Description keyword matching (30% weight)
        $descriptionWords = explode(' ', strtolower($description));
        $keywordMatches = 0;
        foreach ($descriptionWords as $word) {
            if (strlen($word) > 3 && strpos($jobText, $word) !== false) {
                $keywordMatches++;
            }
        }
        if ($keywordMatches > 0) {
            $score += min(30, $keywordMatches * 5);
        }

        return min(100, $score); // Cap at 100%
    }

    /**
     * Get reasons why job matches the profile
     */
    private function getMatchReasons($job, $categories, $tools, $description)
    {
        $reasons = [];
        $jobText = strtolower($job->title . ' ' . $job->description . ' ' . $job->required_skills);

        // Check category matches
        foreach ($categories as $category) {
            if (strpos($jobText, strtolower($category)) !== false) {
                $reasons[] = "Matches your {$category} skills";
            }
        }

        // Check tool matches
        foreach ($tools as $tool) {
            if (strpos($jobText, strtolower($tool)) !== false) {
                $reasons[] = "Requires {$tool} which you know";
            }
        }

        // Check description matches
        $descriptionWords = array_filter(explode(' ', strtolower($description)), function($word) {
            return strlen($word) > 4;
        });
        
        foreach (array_slice($descriptionWords, 0, 3) as $word) {
            if (strpos($jobText, $word) !== false) {
                $reasons[] = "Matches your experience with " . ucfirst($word);
            }
        }

        return array_slice($reasons, 0, 3); // Return top 3 reasons
    }

    /**
     * Notify employers about new skill profile
     */
    private function notifyEmployersOfNewProfile($profile)
    {
        // This would integrate with your notification system
        // For now, we'll just log it
        \Log::info('New skill profile created for user: ' . $profile->user_id);
        
        // TODO: Implement employer notifications
        // - Find employers with matching job requirements
        // - Send notifications about new skilled worker
        // - Create activity log entries
    }

    /**
     * Get profile statistics
     */
    public function getStats()
    {
        $user = Auth::user();
        $profile = SkillToCashProfile::where('user_id', $user->id)->first();

        if (!$profile) {
            return response()->json([
                'success' => false,
                'message' => 'No skill profile found'
            ]);
        }

        $tools = json_decode($profile->tools, true) ?? [];
        $tasks = json_decode($profile->tasks, true) ?? [];
        $matches = $this->findJobMatches($profile);

        return response()->json([
            'success' => true,
            'data' => [
                'practicalSkillsCount' => count($tools),
                'tasksCompletedCount' => count($tasks),
                'jobMatchesCount' => count($matches),
                'profileCompletion' => $this->calculateProfileCompletion($profile)
            ]
        ]);
    }
}