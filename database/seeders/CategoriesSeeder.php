<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Construction & Building',
                'slug' => 'construction-building',
                'description' => 'Construction work, building, renovation, and related services',
                'icon' => 'fas fa-hard-hat',
                'is_active' => true,
            ],
            [
                'name' => 'Cleaning & Maintenance',
                'slug' => 'cleaning-maintenance',
                'description' => 'Cleaning services, maintenance, and facility management',
                'icon' => 'fas fa-broom',
                'is_active' => true,
            ],
            [
                'name' => 'Transportation & Delivery',
                'slug' => 'transportation-delivery',
                'description' => 'Driving, delivery, logistics, and transportation services',
                'icon' => 'fas fa-truck',
                'is_active' => true,
            ],
            [
                'name' => 'Security & Safety',
                'slug' => 'security-safety',
                'description' => 'Security guards, safety officers, and protection services',
                'icon' => 'fas fa-shield-alt',
                'is_active' => true,
            ],
            [
                'name' => 'Hospitality & Events',
                'slug' => 'hospitality-events',
                'description' => 'Event staff, catering, hospitality, and service roles',
                'icon' => 'fas fa-glass-cheers',
                'is_active' => true,
            ],
            [
                'name' => 'Technical & Repair',
                'slug' => 'technical-repair',
                'description' => 'Technical services, repairs, electrical, plumbing work',
                'icon' => 'fas fa-tools',
                'is_active' => true,
            ],
            [
                'name' => 'Agriculture & Farming',
                'slug' => 'agriculture-farming',
                'description' => 'Farm work, agriculture, gardening, and outdoor labor',
                'icon' => 'fas fa-seedling',
                'is_active' => true,
            ],
            [
                'name' => 'General Labor',
                'slug' => 'general-labor',
                'description' => 'General labor, manual work, and miscellaneous tasks',
                'icon' => 'fas fa-user-hard-hat',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}