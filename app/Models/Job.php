<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'job_postings';

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'location',
        'latitude',
        'longitude',
        'geohash',
        'search_radius',
        'job_type',
        'payment_type',
        'budget',
        'duration',
        'start_date',
        'urgency',
        'required_skills',
        'is_featured',
        'is_urgent',
        'requires_background_check',
        'status',
        'views',
        'applications_count',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_urgent' => 'boolean',
            'requires_background_check' => 'boolean',
            'budget' => 'decimal:2',
            'start_date' => 'date',
            'views' => 'integer',
            'applications_count' => 'integer',
        ];
    }

    /**
     * Get the employer who posted this job
     */
    public function employer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the category for this job
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all applications for this job
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Get all messages for this job
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Get all payments for this job
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Check if job is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if job payment is completed
     */
    public function isPaymentCompleted(): bool
    {
        return $this->payments()->where('status', 'completed')->exists();
    }

    /**
     * Get the latest payment for this job
     */
    public function getLatestPayment()
    {
        return $this->payments()->latest()->first();
    }

    /**
     * Check if job requires payment
     */
    public function requiresPayment(): bool
    {
        return in_array($this->status, ['draft', 'pending_payment']);
    }

    /**
     * Mark job as paid and activate it
     */
    public function markAsPaid(): void
    {
        $this->update([
            'status' => 'active',
            'payment_status' => 'paid',
            'published_at' => now(),
        ]);
    }

    /**
     * Get payment URL for this job
     */
    public function getPaymentUrl(): string
    {
        return route('payment', ['job_id' => $this->id]);
    }

    /**
     * Check if job is filled
     */
    public function isFilled(): bool
    {
        return $this->status === 'filled';
    }

    // New skill-based relationships
    public function jobSkills()
    {
        return $this->hasMany(JobSkill::class);
    }

    public function skillsRequired()
    {
        return $this->belongsToMany(Skill::class, 'job_skills')
                    ->withPivot('required_level', 'is_required')
                    ->withTimestamps();
    }

    public function requiredSkills()
    {
        return $this->belongsToMany(Skill::class, 'job_skills')
                    ->wherePivot('is_required', true)
                    ->withPivot('required_level', 'is_required')
                    ->withTimestamps();
    }

    public function optionalSkills()
    {
        return $this->belongsToMany(Skill::class, 'job_skills')
                    ->wherePivot('is_required', false)
                    ->withPivot('required_level', 'is_required')
                    ->withTimestamps();
    }

    public function jobNotifications()
    {
        return $this->hasMany(JobNotification::class);
    }
}