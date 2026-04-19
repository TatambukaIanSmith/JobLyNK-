<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkerAvailabilityZone extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
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
        'last_location_update',
    ];

    protected function casts(): array
    {
        return [
            'available_from' => 'date',
            'available_until' => 'date',
            'available_days' => 'array',
            'preferred_job_types' => 'array',
            'minimum_pay' => 'decimal:2',
            'instant_notifications' => 'boolean',
            'last_location_update' => 'datetime',
        ];
    }

    /**
     * Get the worker user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if worker is currently available
     */
    public function isAvailable(): bool
    {
        if ($this->status !== 'available') {
            return false;
        }

        $now = now();

        if ($this->available_from && $now->lt($this->available_from)) {
            return false;
        }

        if ($this->available_until && $now->gt($this->available_until)) {
            return false;
        }

        return true;
    }

    /**
     * Check if worker is available on a specific day
     */
    public function isAvailableOnDay(int $dayOfWeek): bool
    {
        if (!$this->available_days) {
            return true;
        }

        return in_array($dayOfWeek, $this->available_days);
    }

    /**
     * Check if job matches worker preferences
     */
    public function matchesJobPreferences($job): bool
    {
        // Check minimum pay
        if ($this->minimum_pay && $job->budget < $this->minimum_pay) {
            return false;
        }

        // Check preferred job types
        if ($this->preferred_job_types && !in_array($job->job_type, $this->preferred_job_types)) {
            return false;
        }

        return true;
    }
}
