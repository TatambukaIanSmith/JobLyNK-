<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bookmark extends Model
{
    protected $fillable = [
        'user_id',
        'job_id',
    ];

    /**
     * Get the user who bookmarked the job
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the bookmarked job
     */
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }
}
