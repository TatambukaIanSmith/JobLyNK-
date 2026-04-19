<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Construction',
                'description' => 'Building, renovation, and construction work',
                'icon' => 'fas fa-hard-hat',
            ],
            [
                'name' => 'Cleaning',
                'description' => 'House cleaning, office cleaning, and maintenance',
                'icon' => 'fas fa-broom',
            ],
            [
                'name' => 'Delivery',
                'description' => 'Package delivery, food delivery, and transport services',
                'icon' => 'fas fa-truck',
            ],
            [
                'name' => 'Gardening',
                'description' => 'Landscaping, garden maintenance, and plant care',
                'icon' => 'fas fa-seedling',
            ],
            [
                'name' => 'Domestic Help',
                'description' => 'Household assistance, cooking, and personal care',
                'icon' => 'fas fa-home',
            ],
            [
                'name' => 'Hospitality',
                'description' => 'Event services, catering, and customer service',
                'icon' => 'fas fa-utensils',
            ],
            [
                'name' => 'Logistics',
                'description' => 'Moving, transportation, and logistics support',
                'icon' => 'fas fa-boxes',
            ],
            [
                'name' => 'Security',
                'description' => 'Security services, guarding, and safety',
                'icon' => 'fas fa-shield-alt',
            ],
            [
                'name' => 'Maintenance',
                'description' => 'Repairs, maintenance, and technical services',
                'icon' => 'fas fa-tools',
            ],
            [
                'name' => 'Other',
                'description' => 'Miscellaneous jobs and services',
                'icon' => 'fas fa-ellipsis-h',
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::firstOrCreate(
                ['slug' => Str::slug($categoryData['name'])],
                [
                    'name' => $categoryData['name'],
                    'description' => $categoryData['description'],
                    'icon' => $categoryData['icon'],
                    'is_active' => true,
                ]
            );
        }
    }
}