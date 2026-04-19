<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AIAgentActivity extends Model
{
    use HasFactory;

    protected $table = 'ai_agent_activities';

    protected $fillable = [
        'employer_id',
        'activity_type',
        'data',
        'alerts_count',
        'recommendations_count',
        'performance_score',
        'engagement_level',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'alerts_count' => 'integer',
            'recommendations_count' => 'integer',
            'performance_score' => 'integer',
        ];
    }

    /**
     * Get the employer that owns the activity
     */
    public function employer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    /**
     * Scope for recent activities
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Scope for specific activity type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('activity_type', $type);
    }
}