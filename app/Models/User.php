<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'bio',
        'location',
        'latitude',
        'longitude',
        'geohash',
        'preferred_radius',
        'share_location',
        'age',
        'profile_picture',
        'skills',
        'certificates',
        'bookmarked_jobs',
        'is_suspended',
        'suspended_until',
        'suspension_reason',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'skills' => 'array',
            'certificates' => 'array',
            'bookmarked_jobs' => 'array',
            'is_suspended' => 'boolean',
            'suspended_until' => 'datetime',
        ];
    }

    /**
     * Get all job postings posted by this user (if employer)
     */
    public function jobs()
    {
        return $this->hasMany(Job::class, 'user_id');
    }

    /**
     * Get all applications made by this user (if worker)
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Get all messages sent by this user
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Get all messages received by this user
     */
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * Get all payments made by this user
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Check if user is an employer
     */
    public function isEmployer(): bool
    {
        return $this->role === 'employer';
    }

    /**
     * Check if user is a worker
     */
    public function isWorker(): bool
    {
        return $this->role === 'worker';
    }

    /**
     * Check if user is an admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    /**
     * Get the user's profile picture URL
     */
    public function getProfilePictureUrl(): string
    {
        if ($this->profile_picture) {
            // Handle both old and new profile picture paths
            $path = $this->profile_picture;
            
            // Ensure the path doesn't start with 'storage/' to avoid double path
            if (strpos($path, 'storage/') === 0) {
                $path = substr($path, 8); // Remove 'storage/' prefix
            }
            
            // Check if file actually exists before returning URL
            $fullPath = public_path('storage/' . $path);
            if (file_exists($fullPath)) {
                // Build the URL with proper storage path
                $url = asset('storage/' . $path);
                
                // Add cache busting parameter to ensure fresh images
                $url .= '?v=' . ($this->updated_at ? $this->updated_at->timestamp : time());
                
                return $url;
            }
            
            // File doesn't exist, clear the profile_picture field and return default
            // We'll do this silently to avoid breaking the page
        }
        
        // Return default avatar with user's initials
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=ffffff&background=1e40af&size=150';
    }

    /**
     * Get user skills as array
     */
    public function getSkillsArray(): array
    {
        return $this->skills ?? [];
    }

    /**
     * Add a skill to user's skills
     */
    public function addSkill(string $skill): void
    {
        // Add to old JSON column for backward compatibility
        $skills = $this->getSkillsArray();
        if (!in_array($skill, $skills)) {
            $skills[] = $skill;
            $this->skills = $skills;
            $this->save();
        }
        
        // Also add to user_skills table for matching system
        // First, find or create the skill
        $skillModel = Skill::firstOrCreate(
            ['name' => $skill],
            ['category' => 'General', 'is_active' => true]
        );
        
        // Then create the user_skill relationship if it doesn't exist
        UserSkill::firstOrCreate([
            'user_id' => $this->id,
            'skill_id' => $skillModel->id
        ]);
    }

    /**
     * Remove a skill from user's skills
     */
    public function removeSkill(string $skill): void
    {
        // Remove from old JSON column
        $skills = $this->getSkillsArray();
        $skills = array_filter($skills, fn($s) => $s !== $skill);
        $this->skills = array_values($skills);
        $this->save();
        
        // Also remove from user_skills table
        $skillModel = Skill::where('name', $skill)->first();
        if ($skillModel) {
            UserSkill::where('user_id', $this->id)
                ->where('skill_id', $skillModel->id)
                ->delete();
        }
    }

    /**
     * Get user's bookmarked jobs
     */
    public function getBookmarkedJobs()
    {
        if (empty($this->bookmarked_jobs)) {
            return collect();
        }

        return Job::whereIn('id', $this->bookmarked_jobs)
            ->where('status', 'active')
            ->with(['employer', 'category'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Check if user has bookmarked a job
     */
    public function hasBookmarked(int $jobId): bool
    {
        return in_array($jobId, $this->bookmarked_jobs ?? []);
    }

    /**
     * Get user's applications
     */
    public function jobApplications()
    {
        return $this->hasMany(Application::class, 'user_id');
    }

    /**
     * Check if user is currently suspended
     */
    public function isSuspended(): bool
    {
        if (!$this->is_suspended) {
            return false;
        }

        // If suspended_until is null, it's a permanent suspension
        if ($this->suspended_until === null) {
            return true;
        }

        // Check if suspension period has expired
        if ($this->suspended_until->isPast()) {
            // Auto-unsuspend the user
            $this->update([
                'is_suspended' => false,
                'suspended_until' => null,
                'suspension_reason' => null
            ]);
            return false;
        }

        return true;
    }

    // New skill-based relationships
    public function userSkills()
    {
        return $this->hasMany(UserSkill::class);
    }

    public function skillsWithProficiency()
    {
        return $this->belongsToMany(Skill::class, 'user_skills')
                    ->withPivot('proficiency_level', 'years_experience')
                    ->withTimestamps();
    }

    public function jobPreferences()
    {
        return $this->hasOne(UserJobPreference::class);
    }

    public function jobNotifications()
    {
        return $this->hasMany(JobNotification::class);
    }

    public function unreadJobNotifications()
    {
        return $this->hasMany(JobNotification::class)->where('is_read', false);
    }

    /**
     * Get user's skill-to-cash profile
     */
    public function skillToCashProfile()
    {
        return $this->hasOne(SkillToCashProfile::class);
    }

    /**
     * Check if user has a skill-to-cash profile
     */
    public function hasSkillToCashProfile(): bool
    {
        return $this->skillToCashProfile()->exists();
    }

    /**
     * Get skill-to-cash profile completion percentage
     */
    public function getSkillToCashCompletion(): int
    {
        $profile = $this->skillToCashProfile;
        return $profile ? $profile->completion_percentage : 0;
    }
}
