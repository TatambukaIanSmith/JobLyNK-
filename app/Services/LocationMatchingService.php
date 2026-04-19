<?php

namespace App\Services;

use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LocationMatchingService
{
    /**
     * Find nearby jobs for a worker
     *
     * @param User $worker
     * @param int $radiusKm
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findNearbyJobs(User $worker, int $radiusKm = null, int $limit = 20)
    {
        if (!$worker->latitude || !$worker->longitude) {
            return collect();
        }

        $radius = $radiusKm ?? $worker->preferred_radius ?? 10;
        $geohashPrefix = GeohashService::getPrefixForRadius($worker->latitude, $worker->longitude, $radius);

        // First filter by geohash prefix for fast search
        $jobs = Job::where('status', 'active')
            ->where('geohash', 'LIKE', $geohashPrefix . '%')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        // Then calculate precise distance and filter
        $nearbyJobs = $jobs->map(function ($job) use ($worker) {
            $distance = $this->calculateDistance(
                $worker->latitude,
                $worker->longitude,
                $job->latitude,
                $job->longitude
            );
            
            $job->distance = round($distance, 2);
            return $job;
        })
        ->filter(function ($job) use ($radius) {
            return $job->distance <= $radius;
        })
        ->sortBy('distance')
        ->take($limit);

        return $nearbyJobs;
    }

    /**
     * Find nearby workers for a job
     *
     * @param Job $job
     * @param int $radiusKm
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findNearbyWorkers(Job $job, int $radiusKm = null, int $limit = 50)
    {
        if (!$job->latitude || !$job->longitude) {
            return collect();
        }

        $radius = $radiusKm ?? $job->search_radius ?? 10;
        $geohashPrefix = GeohashService::getPrefixForRadius($job->latitude, $job->longitude, $radius);

        // First filter by geohash prefix
        $workers = User::where('role', 'worker')
            ->where('share_location', true)
            ->where('geohash', 'LIKE', $geohashPrefix . '%')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        // Calculate precise distance and filter
        $nearbyWorkers = $workers->map(function ($worker) use ($job) {
            $distance = $this->calculateDistance(
                $job->latitude,
                $job->longitude,
                $worker->latitude,
                $worker->longitude
            );
            
            $worker->distance = round($distance, 2);
            return $worker;
        })
        ->filter(function ($worker) use ($radius) {
            return $worker->distance <= $radius;
        })
        ->sortBy('distance')
        ->take($limit);

        return $nearbyWorkers;
    }

    /**
     * Find available workers near a job
     *
     * @param Job $job
     * @param int $radiusKm
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findAvailableWorkersNearJob(Job $job, int $radiusKm = null)
    {
        if (!$job->latitude || !$job->longitude) {
            return collect();
        }

        $radius = $radiusKm ?? $job->search_radius ?? 10;

        // Use spatial query for better performance
        $workers = DB::table('users')
            ->join('worker_availability_zones', 'users.id', '=', 'worker_availability_zones.user_id')
            ->select(
                'users.*',
                'worker_availability_zones.status as availability_status',
                'worker_availability_zones.max_travel_distance',
                DB::raw("ST_Distance_Sphere(
                    users.coordinates,
                    POINT({$job->longitude}, {$job->latitude})
                ) / 1000 AS distance")
            )
            ->where('users.role', 'worker')
            ->where('users.share_location', true)
            ->where('worker_availability_zones.status', 'available')
            ->whereNotNull('users.coordinates')
            ->whereRaw("ST_Distance_Sphere(
                users.coordinates,
                POINT({$job->longitude}, {$job->latitude})
            ) / 1000 <= ?", [$radius])
            ->whereRaw("ST_Distance_Sphere(
                users.coordinates,
                POINT({$job->longitude}, {$job->latitude})
            ) / 1000 <= worker_availability_zones.max_travel_distance")
            ->orderBy('distance')
            ->limit(50)
            ->get();

        return $workers;
    }

    /**
     * Calculate distance between two coordinates using Haversine formula
     *
     * @param float $lat1
     * @param float $lon1
     * @param float $lat2
     * @param float $lon2
     * @return float Distance in kilometers
     */
    public function calculateDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371; // Earth's radius in kilometers

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    /**
     * Update location for user or job
     *
     * @param mixed $model (User or Job)
     * @param float $latitude
     * @param float $longitude
     * @return bool
     */
    public function updateLocation($model, float $latitude, float $longitude): bool
    {
        try {
            $geohash = GeohashService::encode($latitude, $longitude);

            $model->update([
                'latitude' => $latitude,
                'longitude' => $longitude,
                'geohash' => $geohash,
            ]);

            // Update spatial coordinates
            DB::statement(
                "UPDATE {$model->getTable()} SET coordinates = POINT(?, ?) WHERE id = ?",
                [$longitude, $latitude, $model->id]
            );

            return true;
        } catch (\Exception $e) {
            Log::error('Location update failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get jobs within radius using spatial query (fastest method)
     *
     * @param float $latitude
     * @param float $longitude
     * @param int $radiusKm
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function getJobsWithinRadius(float $latitude, float $longitude, int $radiusKm, int $limit = 20)
    {
        $jobs = DB::table('job_postings')
            ->select(
                '*',
                DB::raw("ST_Distance_Sphere(
                    coordinates,
                    POINT(?, ?)
                ) / 1000 AS distance", [$longitude, $latitude])
            )
            ->where('status', 'active')
            ->whereNotNull('coordinates')
            ->whereRaw("ST_Distance_Sphere(
                coordinates,
                POINT(?, ?)
            ) / 1000 <= ?", [$longitude, $latitude, $radiusKm])
            ->orderBy('distance')
            ->limit($limit)
            ->get();

        return $jobs;
    }
}
