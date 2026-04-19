<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_id',
        'type',
        'match_score',
        'is_read',
        'is_sent',
        'sent_at'
    ];

    protected $casts = [
        'match_score' => 'decimal:2',
        'is_read' => 'boolean',
        'is_sent' => 'boolean',
        'sent_at' => 'datetime'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeUnsent($query)
    {
        return $query->where('is_sent', false);
    }

    public function scopeJobMatches($query)
    {
        return $query->where('type', 'job_match');
    }

    public function scopeWorkerMatches($query)
    {
        return $query->where('type', 'worker_match');
    }

    public function scopeHighMatch($query, $threshold = 70)
    {
        return $query->where('match_score', '>=', $threshold);
    }

    // Helper methods
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }

    public function markAsSent()
    {
        $this->update([
            'is_sent' => true,
            'sent_at' => now()
        ]);
    }

    public function getMatchPercentage()
    {
        return round($this->match_score, 1) . '%';
    }
}