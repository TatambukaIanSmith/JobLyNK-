<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserJobPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_category_ids',
        'min_salary',
        'max_salary',
        'preferred_location',
        'remote_work_preference',
        'employment_type',
        'receive_notifications'
    ];

    protected $casts = [
        'job_category_ids' => 'array',
        'min_salary' => 'decimal:2',
        'max_salary' => 'decimal:2',
        'remote_work_preference' => 'boolean',
        'receive_notifications' => 'boolean'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobCategories()
    {
        if (!$this->job_category_ids) {
            return collect();
        }
        
        return JobCategory::whereIn('id', $this->job_category_ids)->get();
    }

    // Helper methods
    public function matchesSalaryRange($jobSalary)
    {
        if (!$jobSalary) return true;
        
        if ($this->min_salary && $jobSalary < $this->min_salary) {
            return false;
        }
        
        if ($this->max_salary && $jobSalary > $this->max_salary) {
            return false;
        }
        
        return true;
    }

    public function matchesLocation($jobLocation, $isRemote = false)
    {
        if ($this->remote_work_preference && $isRemote) {
            return true;
        }
        
        if (!$this->preferred_location) {
            return true;
        }
        
        return stripos($jobLocation, $this->preferred_location) !== false;
    }
}