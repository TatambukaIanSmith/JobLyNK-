<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            // Programming & Development
            ['name' => 'PHP', 'category' => 'Programming', 'description' => 'Server-side scripting language'],
            ['name' => 'Laravel', 'category' => 'Programming', 'description' => 'PHP web application framework'],
            ['name' => 'JavaScript', 'category' => 'Programming', 'description' => 'Client-side scripting language'],
            ['name' => 'React', 'category' => 'Programming', 'description' => 'JavaScript library for building user interfaces'],
            ['name' => 'Vue.js', 'category' => 'Programming', 'description' => 'Progressive JavaScript framework'],
            ['name' => 'Node.js', 'category' => 'Programming', 'description' => 'JavaScript runtime environment'],
            ['name' => 'Python', 'category' => 'Programming', 'description' => 'High-level programming language'],
            ['name' => 'Java', 'category' => 'Programming', 'description' => 'Object-oriented programming language'],
            ['name' => 'C#', 'category' => 'Programming', 'description' => 'Microsoft programming language'],
            ['name' => 'HTML/CSS', 'category' => 'Programming', 'description' => 'Web markup and styling languages'],
            ['name' => 'SQL', 'category' => 'Programming', 'description' => 'Database query language'],
            ['name' => 'MySQL', 'category' => 'Programming', 'description' => 'Relational database management system'],
            ['name' => 'MongoDB', 'category' => 'Programming', 'description' => 'NoSQL document database'],
            ['name' => 'Git', 'category' => 'Programming', 'description' => 'Version control system'],

            // Design & Creative
            ['name' => 'Graphic Design', 'category' => 'Design', 'description' => 'Visual communication design'],
            ['name' => 'UI/UX Design', 'category' => 'Design', 'description' => 'User interface and experience design'],
            ['name' => 'Adobe Photoshop', 'category' => 'Design', 'description' => 'Image editing software'],
            ['name' => 'Adobe Illustrator', 'category' => 'Design', 'description' => 'Vector graphics software'],
            ['name' => 'Figma', 'category' => 'Design', 'description' => 'Collaborative design tool'],
            ['name' => 'Logo Design', 'category' => 'Design', 'description' => 'Brand identity design'],
            ['name' => 'Web Design', 'category' => 'Design', 'description' => 'Website visual design'],
            ['name' => 'Video Editing', 'category' => 'Design', 'description' => 'Video post-production'],
            ['name' => 'Animation', 'category' => 'Design', 'description' => 'Motion graphics and animation'],

            // Marketing & Sales
            ['name' => 'Digital Marketing', 'category' => 'Marketing', 'description' => 'Online marketing strategies'],
            ['name' => 'Social Media Marketing', 'category' => 'Marketing', 'description' => 'Social platform marketing'],
            ['name' => 'SEO', 'category' => 'Marketing', 'description' => 'Search engine optimization'],
            ['name' => 'Content Marketing', 'category' => 'Marketing', 'description' => 'Content strategy and creation'],
            ['name' => 'Email Marketing', 'category' => 'Marketing', 'description' => 'Email campaign management'],
            ['name' => 'Google Ads', 'category' => 'Marketing', 'description' => 'Google advertising platform'],
            ['name' => 'Facebook Ads', 'category' => 'Marketing', 'description' => 'Facebook advertising platform'],
            ['name' => 'Sales', 'category' => 'Marketing', 'description' => 'Sales techniques and processes'],

            // Writing & Content
            ['name' => 'Content Writing', 'category' => 'Writing', 'description' => 'Web and marketing content creation'],
            ['name' => 'Copywriting', 'category' => 'Writing', 'description' => 'Persuasive marketing copy'],
            ['name' => 'Blog Writing', 'category' => 'Writing', 'description' => 'Blog post creation'],
            ['name' => 'Technical Writing', 'category' => 'Writing', 'description' => 'Technical documentation'],
            ['name' => 'Proofreading', 'category' => 'Writing', 'description' => 'Text editing and correction'],
            ['name' => 'Translation', 'category' => 'Writing', 'description' => 'Language translation services'],

            // Business & Admin
            ['name' => 'Data Entry', 'category' => 'Administrative', 'description' => 'Data input and management'],
            ['name' => 'Virtual Assistant', 'category' => 'Administrative', 'description' => 'Remote administrative support'],
            ['name' => 'Customer Service', 'category' => 'Administrative', 'description' => 'Customer support and relations'],
            ['name' => 'Project Management', 'category' => 'Administrative', 'description' => 'Project planning and execution'],
            ['name' => 'Accounting', 'category' => 'Administrative', 'description' => 'Financial record keeping'],
            ['name' => 'Bookkeeping', 'category' => 'Administrative', 'description' => 'Financial transaction recording'],
            ['name' => 'Excel', 'category' => 'Administrative', 'description' => 'Spreadsheet software proficiency'],

            // Mobile Development
            ['name' => 'Android Development', 'category' => 'Mobile', 'description' => 'Android app development'],
            ['name' => 'iOS Development', 'category' => 'Mobile', 'description' => 'iOS app development'],
            ['name' => 'Flutter', 'category' => 'Mobile', 'description' => 'Cross-platform mobile framework'],
            ['name' => 'React Native', 'category' => 'Mobile', 'description' => 'Cross-platform mobile development'],

            // Other Skills
            ['name' => 'Photography', 'category' => 'Creative', 'description' => 'Professional photography'],
            ['name' => 'Driving', 'category' => 'Transport services', 'description' => 'Professional driver'],
            ['name' => 'Voice Over', 'category' => 'Creative', 'description' => 'Voice recording services'],
            ['name' => 'Tutoring', 'category' => 'Education', 'description' => 'Educational instruction'],
            ['name' => 'Research', 'category' => 'Research', 'description' => 'Information gathering and analysis'],
            ['name' => 'Data Analysis', 'category' => 'Research', 'description' => 'Data interpretation and insights'],
        ];

        foreach ($skills as $skill) {
            Skill::firstOrCreate(
                ['name' => $skill['name']],
                $skill
            );
        }
    }
}