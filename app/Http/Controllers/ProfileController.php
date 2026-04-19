<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Job;
use App\Models\JobNotification;
use App\Services\JobMatchingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => [
                'nullable', 
                'string', 
                'max:255',
                Rule::unique('users')->ignore($user->id)->whereNotNull('phone'),
            ],
            'location' => ['nullable', 'string', 'max:500'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'profile_picture' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ], [
            'name.required' => 'Please enter your full name.',
            'phone.unique' => 'This phone number is already in use by another account.',
            'profile_picture.image' => 'Profile picture must be an image.',
            'profile_picture.max' => 'Profile picture must not be larger than 2MB.',
        ]);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            
            // Store new profile picture
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $validated['profile_picture'] = $path;
        }

        // Update user profile
        $user->fill($validated);
        $user->save();

        // Check if this is an AJAX request (for profile picture upload)
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully!',
                'profile_picture_url' => $user->getProfilePictureUrl()
            ]);
        }

        // Redirect back based on user role (for form submissions)
        $redirectRoute = match($user->role) {
            'employer' => 'employerDashboard',
            'worker' => 'worker',
            'admin' => 'admin',
            default => 'dashboard',
        };

        return redirect()->route($redirectRoute)->with('success', 'Profile updated successfully!');
    }

    /**
     * Update only the user's profile picture.
     */
    public function updateProfilePicture(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        
        \Log::info('Profile picture update request received', [
            'user_id' => $user->id,
            'has_file' => $request->hasFile('profile_picture'),
            'file_info' => $request->hasFile('profile_picture') ? [
                'name' => $request->file('profile_picture')->getClientOriginalName(),
                'size' => $request->file('profile_picture')->getSize(),
                'mime' => $request->file('profile_picture')->getMimeType(),
            ] : null
        ]);
        
        $validated = $request->validate([
            'profile_picture' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ], [
            'profile_picture.required' => 'Please select a profile picture.',
            'profile_picture.image' => 'Profile picture must be an image.',
            'profile_picture.max' => 'Profile picture must not be larger than 2MB.',
        ]);

        // Delete old profile picture if exists
        if ($user->profile_picture) {
            \Log::info('Deleting old profile picture', ['old_path' => $user->profile_picture]);
            Storage::disk('public')->delete($user->profile_picture);
        }
        
        // Store new profile picture
        $path = $request->file('profile_picture')->store('profile-pictures', 'public');
        \Log::info('New profile picture stored', ['new_path' => $path]);
        
        // Check if file was actually stored
        $fullStoragePath = storage_path('app/public/' . $path);
        $publicStoragePath = public_path('storage/' . $path);
        
        \Log::info('File storage check', [
            'stored_path' => $path,
            'full_storage_path' => $fullStoragePath,
            'public_storage_path' => $publicStoragePath,
            'file_exists_in_storage' => file_exists($fullStoragePath),
            'file_exists_in_public' => file_exists($publicStoragePath),
            'storage_disk_exists' => Storage::disk('public')->exists($path)
        ]);
        
        // Update user profile picture
        $user->profile_picture = $path;
        $user->save();
        
        // Refresh the user model to ensure the change is persisted
        $user->refresh();
        
        // Small delay to ensure file system has processed the file
        usleep(100000); // 0.1 seconds
        
        \Log::info('User profile updated', [
            'user_id' => $user->id,
            'profile_picture_path' => $user->profile_picture,
            'profile_picture_url' => $user->getProfilePictureUrl(),
            'file_exists_after_save' => file_exists(public_path('storage/' . $path))
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Profile picture updated successfully!',
            'profile_picture_url' => $user->getProfilePictureUrl(),
            'debug_info' => [
                'stored_path' => $path,
                'expected_url' => asset('storage/' . $path),
                'actual_url_from_method' => $user->getProfilePictureUrl(),
                'file_exists_public' => file_exists(public_path('storage/' . $path)),
                'file_exists_storage' => file_exists(storage_path('app/public/' . $path)),
                'storage_disk_exists' => Storage::disk('public')->exists($path),
                'public_storage_path' => public_path('storage/' . $path),
                'full_storage_path' => storage_path('app/public/' . $path),
                'user_profile_picture_field' => $user->profile_picture
            ]
        ]);
    }

    /**
     * Add a skill to the user's profile
     */
    public function addSkill(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        
        $validated = $request->validate([
            'skill' => ['required', 'string', 'max:100'],
        ]);

        $skill = trim($validated['skill']);
        
        if (!empty($skill)) {
            $user->addSkill($skill);
            
            // Trigger job matching for workers when they add a skill
            if ($user->role === 'worker') {
                $this->findMatchingJobsForWorker($user);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Skill added successfully!',
                'skills' => $user->getSkillsArray()
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Please enter a valid skill.'
        ], 400);
    }

    /**
     * Remove a skill from the user's profile
     */
    public function removeSkill(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        
        $validated = $request->validate([
            'skill' => ['required', 'string'],
        ]);

        $user->removeSkill($validated['skill']);
        
        return response()->json([
            'success' => true,
            'message' => 'Skill removed successfully!',
            'skills' => $user->getSkillsArray()
        ]);
    }

    /**
     * Upload a professional certificate
     */
    public function uploadCertificate(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        
        $validated = $request->validate([
            'certificate' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'], // 5MB max
            'certificate_name' => ['required', 'string', 'max:255'],
        ], [
            'certificate.required' => 'Please select a certificate file.',
            'certificate.mimes' => 'Certificate must be a PDF or image file (JPG, PNG).',
            'certificate.max' => 'Certificate file must not be larger than 5MB.',
            'certificate_name.required' => 'Please enter a certificate name.',
        ]);

        try {
            // Store the certificate file
            $path = $request->file('certificate')->store('certificates', 'public');
            
            // Get existing certificates or initialize empty array
            $certificates = $user->certificates ? json_decode($user->certificates, true) : [];
            
            // Add new certificate
            $certificates[] = [
                'name' => $validated['certificate_name'],
                'path' => $path,
                'original_name' => $request->file('certificate')->getClientOriginalName(),
                'uploaded_at' => now()->toISOString(),
                'file_size' => $request->file('certificate')->getSize(),
                'mime_type' => $request->file('certificate')->getMimeType(),
            ];
            
            // Update user certificates
            $user->certificates = json_encode($certificates);
            $user->save();
            
            \Log::info('Certificate uploaded successfully', [
                'user_id' => $user->id,
                'certificate_name' => $validated['certificate_name'],
                'file_path' => $path
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Certificate uploaded successfully!',
                'certificates' => $certificates
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Certificate upload failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload certificate. Please try again.'
            ], 500);
        }
    }

    /**
     * Delete a professional certificate
     */
    public function deleteCertificate(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        
        $validated = $request->validate([
            'certificate_index' => ['required', 'integer', 'min:0'],
        ]);

        try {
            $certificates = $user->certificates ? json_decode($user->certificates, true) : [];
            $index = $validated['certificate_index'];
            
            if (!isset($certificates[$index])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Certificate not found.'
                ], 404);
            }
            
            // Delete the file from storage
            $certificateToDelete = $certificates[$index];
            if (isset($certificateToDelete['path'])) {
                Storage::disk('public')->delete($certificateToDelete['path']);
            }
            
            // Remove certificate from array
            array_splice($certificates, $index, 1);
            
            // Update user certificates
            $user->certificates = json_encode($certificates);
            $user->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Certificate deleted successfully!',
                'certificates' => $certificates
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Certificate deletion failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete certificate. Please try again.'
            ], 500);
        }
    }

    /**
     * Get user's saved/bookmarked jobs
     */
    public function getSavedJobs()
    {
        /** @var User $user */
        $user = Auth::user();
        
        try {
            $savedJobs = $user->getBookmarkedJobs();
            
            return response()->json([
                'success' => true,
                'jobs' => $savedJobs->map(function ($job) {
                    return [
                        'id' => $job->id,
                        'title' => $job->title,
                        'company' => $job->employer->name ?? 'Unknown Company',
                        'location' => $job->location,
                        'salary' => $job->salary,
                        'salary_type' => $job->salary_type,
                        'job_type' => $job->job_type,
                        'description' => \Str::limit($job->description, 150),
                        'created_at' => $job->created_at->format('M d, Y'),
                        'category' => $job->category->name ?? 'General',
                        'status' => $job->status,
                    ];
                })
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Failed to get saved jobs', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to load saved jobs. Please try again.'
            ], 500);
        }
    }

    /**
     * Remove a job from user's saved/bookmarked jobs
     */
    public function unsaveJob(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        
        $validated = $request->validate([
            'job_id' => ['required', 'integer', 'exists:job_postings,id'],
        ]);

        try {
            $jobId = $validated['job_id'];
            $bookmarkedJobs = $user->bookmarked_jobs ?? [];
            
            // Remove job from bookmarked jobs
            $bookmarkedJobs = array_filter($bookmarkedJobs, function($id) use ($jobId) {
                return $id != $jobId;
            });
            
            // Update user bookmarked jobs
            $user->bookmarked_jobs = array_values($bookmarkedJobs);
            $user->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Job removed from saved jobs successfully!'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Failed to unsave job', [
                'user_id' => $user->id,
                'job_id' => $validated['job_id'] ?? null,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove job from saved jobs. Please try again.'
            ], 500);
        }
    }

    /**
     * Get user's job applications
     */
    public function getMyApplications()
    {
        /** @var User $user */
        $user = Auth::user();
        
        try {
            $applications = $user->applications()
                ->with(['job', 'job.employer', 'job.category'])
                ->orderBy('created_at', 'desc')
                ->get();
            
            return response()->json([
                'success' => true,
                'applications' => $applications->map(function ($application) {
                    return [
                        'id' => $application->id,
                        'job_title' => $application->job->title ?? 'Unknown Job',
                        'company' => $application->job->employer->name ?? 'Unknown Company',
                        'location' => $application->job->location ?? 'Unknown Location',
                        'salary' => $application->job->budget ?? 0,
                        'job_type' => $application->job->job_type ?? 'Unknown',
                        'category' => $application->job->category->name ?? 'General',
                        'status' => $application->status ?? 'pending',
                        'applied_at' => $application->created_at->format('M d, Y'),
                        'applied_time' => $application->created_at->format('h:i A'),
                        'applied_datetime' => $application->created_at->format('M d, Y \a\t h:i A'),
                        'job_id' => $application->job_id,
                        'cover_letter' => $application->cover_letter ?? '',
                        'days_ago' => $application->created_at->diffForHumans(),
                    ];
                }),
                'total_applications' => $applications->count()
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Failed to get user applications', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to load applications. Please try again.'
            ], 500);
        }
    }

    /**
     * Find matching jobs for a worker and create notifications
     */
    private function findMatchingJobsForWorker(User $worker)
    {
        try {
            Log::info('Finding matching jobs for worker: ' . $worker->id);
            
            // Get worker's skills
            $workerSkills = $worker->userSkills()->pluck('skill_id')->toArray();
            
            if (empty($workerSkills)) {
                Log::info('Worker has no skills yet');
                return;
            }
            
            Log::info('Worker skills: ' . implode(', ', $workerSkills));
            
            // Find all active jobs that require any of the worker's skills
            $matchingJobs = Job::where('status', 'active')
                ->whereHas('jobSkills', function ($query) use ($workerSkills) {
                    $query->whereIn('skill_id', $workerSkills);
                })
                ->with(['jobSkills', 'employer'])
                ->get();
            
            Log::info('Found ' . $matchingJobs->count() . ' potentially matching jobs');
            
            $notificationsCreated = 0;
            
            foreach ($matchingJobs as $job) {
                // Get required skills for this job
                $jobSkillIds = $job->jobSkills->pluck('skill_id')->toArray();
                
                if (empty($jobSkillIds)) {
                    continue;
                }
                
                // Calculate match percentage
                $matchingSkillIds = array_intersect($workerSkills, $jobSkillIds);
                $matchPercentage = (count($matchingSkillIds) / count($jobSkillIds)) * 100;
                
                Log::info("Job {$job->id} ({$job->title}): {$matchPercentage}% match");
                
                // Only create notification if match is 50% or higher
                if ($matchPercentage >= 50) {
                    // Check if notification already exists
                    $existingNotification = JobNotification::where('user_id', $worker->id)
                        ->where('job_id', $job->id)
                        ->where('type', 'job_match')
                        ->first();
                    
                    if (!$existingNotification) {
                        JobNotification::create([
                            'user_id' => $worker->id,
                            'job_id' => $job->id,
                            'type' => 'job_match',
                            'match_score' => $matchPercentage,
                            'is_read' => false,
                            'is_sent' => false
                        ]);
                        
                        $notificationsCreated++;
                        Log::info("Created notification for job {$job->id}");
                    } else {
                        Log::info("Notification already exists for job {$job->id}");
                    }
                }
            }
            
            Log::info("Created {$notificationsCreated} new job match notifications");
            
        } catch (\Exception $e) {
            Log::error('Error finding matching jobs: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }
}
