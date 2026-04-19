<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobCategory;

class JobCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Web Development',
                'description' => 'Website and web application development projects',
                'icon' => 'fas fa-code'
            ],
            [
                'name' => 'Mobile Development',
                'description' => 'Mobile app development for iOS and Android',
                'icon' => 'fas fa-mobile-alt'
            ],
            [
                'name' => 'Graphic Design',
                'description' => 'Visual design, logos, branding, and creative work',
                'icon' => 'fas fa-palette'
            ],
            [
                'name' => 'Digital Marketing',
                'description' => 'Online marketing, SEO, social media, and advertising',
                'icon' => 'fas fa-bullhorn'
            ],
            [
                'name' => 'Content Writing',
                'description' => 'Blog posts, articles, copywriting, and content creation',
                'icon' => 'fas fa-pen'
            ],
            [
                'name' => 'Data Entry',
                'description' => 'Data input, processing, and administrative tasks',
                'icon' => 'fas fa-keyboard'
            ],
            [
                'name' => 'Virtual Assistant',
                'description' => 'Remote administrative support and assistance',
                'icon' => 'fas fa-headset'
            ],
            [
                'name' => 'Video & Animation',
                'description' => 'Video editing, motion graphics, and animation',
                'icon' => 'fas fa-video'
            ],
            [
                'name' => 'Photography',
                'description' => 'Professional photography and photo editing',
                'icon' => 'fas fa-camera'
            ],
            [
                'name' => 'Translation',
                'description' => 'Language translation and localization services',
                'icon' => 'fas fa-language'
            ],
            [
                'name' => 'Accounting & Finance',
                'description' => 'Bookkeeping, accounting, and financial services',
                'icon' => 'fas fa-calculator'
            ],
            [
                'name' => 'Customer Service',
                'description' => 'Customer support and client relations',
                'icon' => 'fas fa-users'
            ],
            [
                'name' => 'Tutoring & Education',
                'description' => 'Online tutoring and educational services',
                'icon' => 'fas fa-graduation-cap'
            ],
            [
                'name' => 'Research & Analysis',
                'description' => 'Market research, data analysis, and reporting',
                'icon' => 'fas fa-chart-bar'
            ],
            [
                'name' => 'Sales & Lead Generation',
                'description' => 'Sales support and lead generation services',
                'icon' => 'fas fa-handshake'
            ]
        ];

        foreach ($categories as $category) {
            JobCategory::firstOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}