<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\WorkerAvailabilityZone;
use App\Services\LocationMatchingService;
use App\Services\GeohashService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LocationJobController extends Controller
{
    protected $locationService;

    public function __construct(LocationMatchingService $locationService)
    {
        $this->locationService = $locationService;
    }

    /**
     * Get nearby jobs for current worker
     */
    public function getNearbyJobs(Request $request)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'worker') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $radius = $request->input('radius', $user->preferred_radius ?? 10);
        $limit = $request->input('limit', 20);

        $jobs = $this->locationService->findNearbyJobs($user, $radius, $limit);

        return response()->json([
            'success' => true,
            'jobs' => $jobs->values(),
            'count' => $jobs->count(),
            'radius' => $radius,
        ]);
    }

    /**
     * Update worker location
     */
    public function updateWorkerLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $user = Auth::user();

        if (!$user || $user->role !== 'worker') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $success = $this->locationService->updateLocation(
            $user,
            $request->latitude,
            $request->longitude
        );

        // Update last location update timestamp
        $availability = WorkerAvailabilityZone::firstOrCreate(
            ['user_id' => $user->id],
            ['status' => 'available']
        );
        $availability->update(['last_location_update' => now()]);

        return response()->json([
            'success' => $success,
            'message' => $success ? 'Location updated successfully' : 'Failed to update location',
            'geohash' => $user->fresh()->geohash,
        ]);
    }

    /**
     * Update job location
     */
    public function updateJobLocation(Request $request, $jobId)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $job = Job::findOrFail($jobId);

        if ($job->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $success = $this->locationService->updateLocation(
            $job,
            $request->latitude,
            $request->longitude
        );

        return response()->json([
            'success' => $success,
            'message' => $success ? 'Job location updated successfully' : 'Failed to update location',
            'geohash' => $job->fresh()->geohash,
        ]);
    }

    /**
     * Get worker availability zone settings
     */
    public function getAvailabilityZone()
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'worker') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $availability = WorkerAvailabilityZone::firstOrCreate(
            ['user_id' => $user->id],
            [
                'status' => 'available',
                'max_travel_distance' => 10,
                'instant_notifications' => true,
            ]
        );

        return response()->json([
            'success' => true,
            'availability' => $availability,
        ]);
    }

    /**
     * Update worker availability zone
     */
    public function updateAvailabilityZone(Request $request)
    {
        $request->validate([
            'status' => 'sometimes|in:available,busy,unavailable',
            'available_from' => 'nullable|date',
            'available_until' => 'nullable|date|after_or_equal:available_from',
            'preferred_start_time' => 'nullable|date_format:H:i',
            'preferred_end_time' => 'nullable|date_format:H:i',
            'available_days' => 'nullable|array',
            'available_days.*' => 'integer|between:1,7',
            'max_travel_distance' => 'nullable|integer|min:1|max:100',
            'preferred_job_types' => 'nullable|array',
            'minimum_pay' => 'nullable|numeric|min:0',
            'instant_notifications' => 'nullable|boolean',
        ]);

        $user = Auth::user();

        if (!$user || $user->role !== 'worker') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $availability = WorkerAvailabilityZone::updateOrCreate(
            ['user_id' => $user->id],
            $request->only([
                'status',
                'available_from',
                'available_until',
                'preferred_start_time',
                'preferred_end_time',
                'available_days',
                'max_travel_distance',
                'preferred_job_types',
                'minimum_pay',
                'instant_notifications',
            ])
        );

        return response()->json([
            'success' => true,
            'message' => 'Availability zone updated successfully',
            'availability' => $availability,
        ]);
    }

    /**
     * Get job radar view (nearby jobs with distances)
     */
    public function getJobRadar(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if (!$user->latitude || !$user->longitude) {
            return response()->json([
                'success' => false,
                'message' => 'Please enable location sharing to see nearby jobs',
                'user_location' => [
                    'latitude' => $user->latitude,
                    'longitude' => $user->longitude,
                ],
            ], 400);
        }

        $radius = $request->input('radius', $user->preferred_radius ?? 10);
        $sortBy = $request->input('sort_by', 'distance'); // distance, newest, pay

        $jobs = $this->locationService->findNearbyJobs($user, $radius, 50);

        // Apply sorting
        switch ($sortBy) {
            case 'newest':
                $jobs = $jobs->sortByDesc('created_at');
                break;
            case 'pay':
                $jobs = $jobs->sortByDesc('budget');
                break;
            default:
                $jobs = $jobs->sortBy('distance');
        }

        return response()->json([
            'success' => true,
            'jobs' => $jobs->values(),
            'worker_location' => [
                'latitude' => $user->latitude,
                'longitude' => $user->longitude,
            ],
            'radius' => $radius,
            'sort_by' => $sortBy,
        ]);
    }

    /**
     * Calculate distance between worker and job
     */
    public function calculateDistance(Request $request)
    {
        $request->validate([
            'job_id' => 'required|exists:job_postings,id',
        ]);

        $user = Auth::user();
        $job = Job::findOrFail($request->job_id);

        if (!$user->latitude || !$user->longitude || !$job->latitude || !$job->longitude) {
            return response()->json([
                'success' => false,
                'message' => 'Location data not available',
            ], 400);
        }

        $distance = $this->locationService->calculateDistance(
            $user->latitude,
            $user->longitude,
            $job->latitude,
            $job->longitude
        );

        return response()->json([
            'success' => true,
            'distance' => round($distance, 2),
            'unit' => 'km',
        ]);
    }
}
