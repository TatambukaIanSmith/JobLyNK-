<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SystemReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'week_start_date',
        'week_end_date',
        'total_new_users',
        'total_jobs_posted',
        'total_applications',
        'total_workers_hired',
        'total_transactions',
        'total_revenue',
        'most_active_employer',
        'most_active_worker',
        'system_errors',
        'average_response_time',
        'pdf_path',
    ];

    protected $casts = [
        'week_start_date' => 'date',
        'week_end_date' => 'date',
        'total_revenue' => 'decimal:2',
        'average_response_time' => 'decimal:2',
    ];

    /**
     * Get formatted revenue
     */
    public function getFormattedRevenueAttribute()
    {
        return 'UGX ' . number_format($this->total_revenue, 0);
    }

    /**
     * Get week range as string
     */
    public function getWeekRangeAttribute()
    {
        return $this->week_start_date->format('M d') . ' - ' . $this->week_end_date->format('M d, Y');
    }
}
