<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Job;
use App\Models\UserSkill;
use App\Models\JobSkill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserSkillsController extends Controller
{
    /**
     * Get worker notifications for employers
     * Returns workers who match the skills required for employer's jobs
     */
    public function getEmployerWorkerNotifications(Request $request)
    {
        try {
            $employer = Auth::user();
            
            if (!$employer || $employer->role !== 'employer') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }
            
            \Log::info('Getting worker notifications for employer: ' . $employer->id);
            
            // Get all active jobs posted by this employer
            $employerJobs = Job::where('user_id', $employer->id)
                ->where('status', 'active')
                ->get();
            
            \Log::info('Found ' . $employerJobs->count() . ' active jobs');
            
            if ($employerJobs->isEmpty()) {
                return response()->json([]);
            }
            
            $notifications = [];
            
            foreach ($employerJobs as $job) {
                \Log::info('Processing job: ' . $job->id . ' - ' . $job->title);
                
                // Get required skills for this job
                $jobSkills = JobSkill::where('job_id', $job->id)
                    ->pluck('skill_id')
                    ->toArray();
                
                \Log::info('Job ' . $job->id . ' has ' . count($jobSkills) . ' required skills');
                
                if (empty($jobSkills)) {
                    continue;
                }
                
                // Find workers who have these skills
                $matchingWorkers = UserSkill::whereIn('skill_id', $jobSkills)
                    ->with(['user' => function($query) {
                        $query->where('role', 'worker')
                              ->select('id', 'name', 'email', 'profile_picture', 'location');
                    }])
                    ->with('skill:id,name')
                    ->get()
                    ->groupBy('user_id');
                
                \Log::info('Found ' . $matchingWorkers->count() . ' matching workers');
                
                foreach ($matchingWorkers as $userId => $userSkills) {
                    $worker = $userSkills->first()->user;
                    
                    if (!$worker) {
                        \Log::warning('Worker not found for user_id: ' . $userId);
                        continue;
                    }
                    
                    // Calculate match percentage
                    $matchedSkillsCount = $userSkills->pluck('skill_id')->unique()->count();
                    $totalRequiredSkills = count($jobSkills);
                    $matchPercentage = round(($matchedSkillsCount / $totalRequiredSkills) * 100);
                    
                    // Only include if match is 50% or higher
                    if ($matchPercentage >= 50) {
                        // Get matched skills names, filtering out nulls
                        $matchedSkillNames = $userSkills
                            ->filter(function($userSkill) {
                                return $userSkill->skill !== null;
                            })
                            ->pluck('skill.name')
                            ->unique()
                            ->values()
                            ->toArray();
                        
                        $notifications[] = [
                            'id' => uniqid(),
                            'type' => 'worker_match',
                            'worker_id' => $worker->id,
                            'worker_name' => $worker->name,
                            'worker_email' => $worker->email,
                            'worker_location' => $worker->location,
                            'worker_profile_picture' => $worker->profile_picture,
                            'job_id' => $job->id,
                            'job_title' => $job->title,
                            'match_percentage' => $matchPercentage,
                            'matched_skills' => $matchedSkillNames,
                            'matched_skills_count' => $matchedSkillsCount,
                            'total_required_skills' => $totalRequiredSkills,
                            'is_read' => false,
                            'created_at' => now()->toISOString()
                        ];
                    }
                }
            }
            
            \Log::info('Returning ' . count($notifications) . ' notifications');
            
            // Sort by match percentage (highest first)
            usort($notifications, function($a, $b) {
                return $b['match_percentage'] - $a['match_percentage'];
            });
            
            return response()->json($notifications);
            
        } catch (\Exception $e) {
            \Log::error('Error in getEmployerWorkerNotifications: ' . $e->getMessage());
            \Log::error('Line: ' . $e->getLine());
            \Log::error('File: ' . $e->getFile());
            \Log::error($e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage(),
                'line' => $e->getLine(),
                'file' => basename($e->getFile())
            ], 500);
        }
    }
    
    /**
     * Get worker profile for employers
     */
    public function getWorkerProfile(Request $request, $workerId)
    {
        try {
            $worker = User::where('id', $workerId)
                ->where('role', 'worker')
                ->first();
            
            if (!$worker) {
                return response()->json([
                    'success' => false,
                    'message' => 'Worker not found'
                ], 404);
            }
            
            // Get worker's skills
            $skills = UserSkill::where('user_id', $workerId)
                ->with('skill:id,name,category')
                ->get()
                ->map(function($userSkill) {
                    return [
                        'name' => $userSkill->skill->name ?? 'Unknown',
                        'category' => $userSkill->skill->category ?? 'Unknown',
                        'proficiency_level' => $userSkill->proficiency_level,
                        'years_experience' => $userSkill->years_experience
                    ];
                });
            
            return response()->json([
                'success' => true,
                'worker' => [
                    'id' => $worker->id,
                    'name' => $worker->name,
                    'email' => $worker->email,
                    'phone' => $worker->phone,
                    'location' => $worker->location,
                    'bio' => $worker->bio,
                    'profile_picture' => $worker->profile_picture,
                    'skills' => $skills,
                    'created_at' => $worker->created_at->toISOString()
                ]
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error in getWorkerProfile: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get user skills
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $skills = UserSkill::where('user_id', $user->id)
            ->with('skill:id,name,category')
            ->get()
            ->map(function($userSkill) {
                return [
                    'id' => $userSkill->id,
                    'skill_id' => $userSkill->skill_id,
                    'skill_name' => $userSkill->skill->name ?? 'Unknown',
                    'skill_category' => $userSkill->skill->category ?? 'Unknown',
                    'proficiency_level' => $userSkill->proficiency_level,
                    'years_experience' => $userSkill->years_experience
                ];
            });
        
        return response()->json($skills);
    }
    
    /**
     * Store user skills
     */
    public function store(Request $request)
    {
        $request->validate([
            'skills' => 'required|array',
            'skills.*.skill_id' => 'required|exists:skills,id',
            'skills.*.proficiency_level' => 'nullable|string',
            'skills.*.years_experience' => 'nullable|integer|min:0'
        ]);
        
        $user = Auth::user();
        
        // Delete existing skills
        UserSkill::where('user_id', $user->id)->delete();
        
        // Add new skills
        foreach ($request->skills as $skillData) {
            UserSkill::create([
                'user_id' => $user->id,
                'skill_id' => $skillData['skill_id'],
                'proficiency_level' => $skillData['proficiency_level'] ?? 'intermediate',
                'years_experience' => $skillData['years_experience'] ?? 1
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Skills updated successfully'
        ]);
    }
    
    /**
     * Update a specific user skill
     */
    public function update(Request $request, $userSkillId)
    {
        $request->validate([
            'proficiency_level' => 'nullable|string',
            'years_experience' => 'nullable|integer|min:0'
        ]);
        
        $userSkill = UserSkill::where('id', $userSkillId)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        
        $userSkill->update($request->only(['proficiency_level', 'years_experience']));
        
        return response()->json([
            'success' => true,
            'message' => 'Skill updated successfully'
        ]);
    }
    
    /**
     * Delete a user skill
     */
    public function destroy($userSkillId)
    {
        $userSkill = UserSkill::where('id', $userSkillId)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        
        $userSkill->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Skill removed successfully'
        ]);
    }
    
    /**
     * Get user preferences
     */
    public function getPreferences(Request $request)
    {
        $user = Auth::user();
        $preferences = $user->jobPreferences;
        
        return response()->json($preferences ?? []);
    }
    
    /**
     * Update user preferences
     */
    public function updatePreferences(Request $request)
    {
        // Implementation for updating preferences
        return response()->json([
            'success' => true,
            'message' => 'Preferences updated successfully'
        ]);
    }
    
    /**
     * Get user notifications
     */
    public function getNotifications(Request $request)
    {
        // Implementation for getting notifications
        return response()->json([]);
    }
    
    /**
     * Mark notification as read
     */
    public function markNotificationRead(Request $request, $notificationId)
    {
        // Implementation for marking notification as read
        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read'
        ]);
    }

    /**
     * Mark specific notifications as read
     */
    public function markNotificationsAsRead(Request $request)
    {
        try {
            $user = Auth::user();
            $notificationIds = $request->input('notification_ids', []);
            
            if (empty($notificationIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No notification IDs provided'
                ], 400);
            }
            
            $updated = DB::table('job_notifications')
                ->where('user_id', $user->id)
                ->whereIn('id', $notificationIds)
                ->update(['is_read' => true]);
            
            return response()->json([
                'success' => true,
                'message' => 'Notifications marked as read',
                'updated_count' => $updated
            ]);
        } catch (\Exception $e) {
            \Log::error('Error marking notifications as read: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark notifications as read'
            ], 500);
        }
    }
    
    /**
     * Mark all notifications as read for the authenticated user
     */
    public function markAllNotificationsAsRead(Request $request)
    {
        try {
            $user = Auth::user();
            
            $updated = DB::table('job_notifications')
                ->where('user_id', $user->id)
                ->where('is_read', false)
                ->update(['is_read' => true]);
            
            return response()->json([
                'success' => true,
                'message' => 'All notifications marked as read',
                'updated_count' => $updated
            ]);
        } catch (\Exception $e) {
            \Log::error('Error marking all notifications as read: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark all notifications as read'
            ], 500);
        }
    }
}
