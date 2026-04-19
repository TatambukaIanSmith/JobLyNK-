<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Relationships
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_skills')
                    ->withPivot('proficiency_level', 'years_experience')
                    ->withTimestamps();
    }

    public function jobs()
    {
        return $this->belongsToMany(JobPosting::class, 'job_skills')
                    ->withPivot('required_level', 'is_required')
                    ->withTimestamps();
    }

    public function userSkills()
    {
        return $this->hasMany(UserSkill::class);
    }

    public function jobSkills()
    {
        return $this->hasMany(JobSkill::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}