<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkillToCashProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'categories',
        'what_you_can_do',
        'tools',
        'tasks',
        'visibility_settings',
        'is_active',
        'last_updated'
    ];

    protected $casts = [
        'categories' => 'array',
        'tools' => 'array',
        'tasks' => 'array',
        'visibility_settings' => 'array',
        'is_active' => 'boolean',
        'last_updated' => 'datetime'
    ];

    /**
     * Get the user that owns the skill profile
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get profile completion percentage
     */
    public function getCompletionPercentageAttribute()
    {
        $completion = 0;
        
        if (!empty($this->categories)) $completion += 25;
        if (!empty($this->what_you_can_do) && strlen($this->what_you_can_do) >= 10) $completion += 25;
        if (!empty($this->tools)) $completion += 25;
        if (!empty($this->tasks)) $completion += 25;
        
        return $completion;
    }

    /**
     * Check if profile is complete
     */
    public function getIsCompleteAttribute()
    {
        return $this->completion_percentage >= 100;
    }

    /**
     * Get formatted categories
     */
    public function getFormattedCategoriesAttribute()
    {
        if (empty($this->categories)) {
            return 'No categories selected';
        }
        
        return implode(', ', $this->categories);
    }

    /**
     * Get tools count
     */
    public function getToolsCountAttribute()
    {
        return is_array($this->tools) ? count($this->tools) : 0;
    }

    /**
     * Get tasks count
     */
    public function getTasksCountAttribute()
    {
        return is_array($this->tasks) ? count($this->tasks) : 0;
    }

    /**
     * Check if profile is visible to employers
     */
    public function getIsVisibleAttribute()
    {
        $visibility = $this->visibility_settings ?? [];
        return ($visibility['profileVisible'] ?? false) && $this->is_active;
    }

    /**
     * Check if direct contact is allowed
     */
    public function getAllowsDirectContactAttribute()
    {
        $visibility = $this->visibility_settings ?? [];
        return $visibility['allowDirectContact'] ?? false;
    }

    /**
     * Check if job alerts are enabled
     */
    public function getReceivesJobAlertsAttribute()
    {
        $visibility = $this->visibility_settings ?? [];
        return $visibility['receiveJobAlerts'] ?? false;
    }

    /**
     * Scope for active profiles
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for visible profiles
     */
    public function scopeVisible($query)
    {
        return $query->where('is_active', true)
                    ->whereJsonContains('visibility_settings->profileVisible', true);
    }

    /**
     * Scope for profiles that allow direct contact
     */
    public function scopeAllowsContact($query)
    {
        return $query->whereJsonContains('visibility_settings->allowDirectContact', true);
    }

    /**
     * Get profiles by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->whereJsonContains('categories', $category);
    }

    /**
     * Get profiles by tool
     */
    public function scopeByTool($query, $tool)
    {
        return $query->whereJsonContains('tools', $tool);
    }

    /**
     * Search profiles by keywords
     */
    public function scopeSearch($query, $keywords)
    {
        return $query->where(function($q) use ($keywords) {
            $q->where('what_you_can_do', 'LIKE', "%{$keywords}%")
              ->orWhereJsonContains('categories', $keywords)
              ->orWhereJsonContains('tools', $keywords);
        });
    }
}