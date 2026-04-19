<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    protected $fillable = [
        'user_id',
        'job_id',
    ];

    /**
     * Get the user who liked the job
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the liked job
     */
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }
}
