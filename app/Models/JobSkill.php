<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobSkill extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'skill_id',
        'required_level',
        'is_required'
    ];

    protected $casts = [
        'is_required' => 'boolean'
    ];

    // Relationships
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    // Scopes
    public function scopeRequired($query)
    {
        return $query->where('is_required', true);
    }

    public function scopeOptional($query)
    {
        return $query->where('is_required', false);
    }

    // Helper methods
    public function getRequiredLevelScore()
    {
        $scores = [
            'Beginner' => 1,
            'Intermediate' => 2,
            'Advanced' => 3,
            'Expert' => 4
        ];

        return $scores[$this->required_level] ?? 1;
    }

    public function matchesUserSkill(UserSkill $userSkill)
    {
        return $userSkill->getProficiencyScore() >= $this->getRequiredLevelScore();
    }
}