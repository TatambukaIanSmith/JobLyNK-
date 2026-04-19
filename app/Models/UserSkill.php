<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSkill extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'skill_id',
        'proficiency_level',
        'years_experience'
    ];

    protected $casts = [
        'years_experience' => 'integer'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    // Scopes
    public function scopeByProficiency($query, $level)
    {
        return $query->where('proficiency_level', $level);
    }

    public function scopeMinExperience($query, $years)
    {
        return $query->where('years_experience', '>=', $years);
    }

    // Helper methods
    public function getProficiencyScore()
    {
        $scores = [
            'Beginner' => 1,
            'Intermediate' => 2,
            'Advanced' => 3,
            'Expert' => 4
        ];

        return $scores[$this->proficiency_level] ?? 1;
    }
}