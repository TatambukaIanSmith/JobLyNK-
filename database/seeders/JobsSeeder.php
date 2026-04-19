<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;

class JobsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some employers to assign jobs to
        $employers = User::where('role', 'employer')->get();
        
        if ($employers->isEmpty()) {
            // Create a sample employer if none exist
            $employer = User::create([
                'name' => 'Sample Construction Company',
                'email' => 'employer@example.com',
                'password' => 'password',
                'role' => 'employer',
                'phone' => '+256 700 000 001',
                'bio' => 'Leading construction company in Kampala',
                'location' => 'Kampala, Uganda',
            ]);
            $employers = collect([$employer]);
        }

        $categories = Category::all();

        $sampleJobs = [
            [
                'title' => 'Construction Worker - Building Project',
                'description' => 'We are looking for experienced construction workers to join our team for a major building project in Kampala. The project involves residential construction and will last approximately 3 months. Candidates should have experience with concrete work, masonry, and general construction tasks.',
                'location' => 'Kampala, Central Division',
                'job_type' => 'project',
                'payment_type' => 'fixed',
                'budget' => 50000,
                'duration' => '3 months',
                'start_date' => now()->addDays(7),
                'urgency' => 'normal',
                'required_skills' => 'Construction, Masonry, Concrete Work',
                'is_featured' => false,
                'is_urgent' => false,
                'requires_background_check' => false,
                'status' => 'active',
                'category_name' => 'Construction & Building',
            ],
            [
                'title' => 'Security Guard - Night Shift',
                'description' => 'Reliable security guard needed for night shift duties at our commercial facility. Responsibilities include monitoring premises, conducting regular patrols, and maintaining security logs. Previous security experience preferred but not required. Training will be provided.',
                'location' => 'Ntinda, Kampala',
                'job_type' => 'recurring',
                'payment_type' => 'fixed',
                'budget' => 400000,
                'duration' => 'ongoing',
                'start_date' => now()->addDays(3),
                'urgency' => 'urgent',
                'required_skills' => 'Security, Night Shift, Vigilance',
                'is_featured' => true,
                'is_urgent' => true,
                'requires_background_check' => true,
                'status' => 'active',
                'category_name' => 'Security & Safety',
            ],
            [
                'title' => 'House Cleaning Service',
                'description' => 'Professional house cleaner needed for weekly cleaning of a 4-bedroom house. Tasks include general cleaning, kitchen and bathroom deep cleaning, and organizing. Must be reliable, trustworthy, and detail-oriented. Cleaning supplies will be provided.',
                'location' => 'Kololo, Kampala',
                'job_type' => 'recurring',
                'payment_type' => 'fixed',
                'budget' => 80000,
                'duration' => 'ongoing',
                'start_date' => now()->addDays(2),
                'urgency' => 'normal',
                'required_skills' => 'Cleaning, Organization, Reliability',
                'is_featured' => false,
                'is_urgent' => false,
                'requires_background_check' => false,
                'status' => 'active',
                'category_name' => 'Cleaning & Maintenance',
            ],
            [
                'title' => 'Delivery Driver - Motorcycle',
                'description' => 'Motorcycle delivery driver needed for food and package delivery services in Kampala. Must have own motorcycle, valid driving license, and good knowledge of Kampala roads. Flexible working hours and competitive pay per delivery.',
                'location' => 'Kampala Metropolitan',
                'job_type' => 'recurring',
                'payment_type' => 'hourly',
                'budget' => 5000,
                'duration' => 'ongoing',
                'start_date' => now()->addDays(1),
                'urgency' => 'urgent',
                'required_skills' => 'Motorcycle Driving, Navigation, Customer Service',
                'is_featured' => true,
                'is_urgent' => true,
                'requires_background_check' => false,
                'status' => 'active',
                'category_name' => 'Transportation & Delivery',
            ],
            [
                'title' => 'Plumber - Emergency Repairs',
                'description' => 'Experienced plumber needed for emergency repair services. Must be available for call-outs and have experience with pipe repairs, installations, and general plumbing maintenance. Own tools required. Excellent rates for quality work.',
                'location' => 'Entebbe, Wakiso',
                'job_type' => 'one-time',
                'payment_type' => 'hourly',
                'budget' => 25000,
                'duration' => '1 month',
                'start_date' => now()->addDays(1),
                'urgency' => 'asap',
                'required_skills' => 'Plumbing, Pipe Repair, Emergency Response',
                'is_featured' => false,
                'is_urgent' => true,
                'requires_background_check' => false,
                'status' => 'active',
                'category_name' => 'Technical & Repair',
            ],
            [
                'title' => 'Event Staff - Wedding Setup',
                'description' => 'Event setup crew needed for wedding ceremonies and receptions. Responsibilities include tent setup, decoration arrangement, table and chair setup, and cleanup. Weekend work required. Great opportunity for reliable workers.',
                'location' => 'Munyonyo, Kampala',
                'job_type' => 'one-time',
                'payment_type' => 'fixed',
                'budget' => 35000,
                'duration' => '2 weeks',
                'start_date' => now()->addDays(5),
                'urgency' => 'normal',
                'required_skills' => 'Event Setup, Decoration, Teamwork',
                'is_featured' => false,
                'is_urgent' => false,
                'requires_background_check' => false,
                'status' => 'active',
                'category_name' => 'Hospitality & Events',
            ],
            [
                'title' => 'Farm Worker - Crop Harvesting',
                'description' => 'Seasonal farm workers needed for crop harvesting. Work involves manual harvesting, sorting, and packing of vegetables and fruits. Accommodation can be provided for workers from outside the area. Physical fitness required.',
                'location' => 'Mukono District',
                'job_type' => 'project',
                'payment_type' => 'fixed',
                'budget' => 20000,
                'duration' => '1 month',
                'start_date' => now()->addDays(10),
                'urgency' => 'normal',
                'required_skills' => 'Farm Work, Physical Fitness, Harvesting',
                'is_featured' => false,
                'is_urgent' => false,
                'requires_background_check' => false,
                'status' => 'active',
                'category_name' => 'Agriculture & Farming',
            ],
            [
                'title' => 'General Laborer - Warehouse',
                'description' => 'General laborers needed for warehouse operations including loading, unloading, sorting, and organizing inventory. Must be physically fit and able to lift heavy items. Full-time position with benefits available.',
                'location' => 'Industrial Area, Kampala',
                'job_type' => 'recurring',
                'payment_type' => 'fixed',
                'budget' => 350000,
                'duration' => 'ongoing',
                'start_date' => now()->addDays(7),
                'urgency' => 'normal',
                'required_skills' => 'Physical Labor, Warehouse Operations, Teamwork',
                'is_featured' => false,
                'is_urgent' => false,
                'requires_background_check' => false,
                'status' => 'active',
                'category_name' => 'General Labor',
            ],
        ];

        foreach ($sampleJobs as $jobData) {
            $category = $categories->where('name', $jobData['category_name'])->first();
            $employer = $employers->random();

            if ($category) {
                Job::create([
                    'user_id' => $employer->id,
                    'category_id' => $category->id,
                    'title' => $jobData['title'],
                    'description' => $jobData['description'],
                    'location' => $jobData['location'],
                    'job_type' => $jobData['job_type'],
                    'payment_type' => $jobData['payment_type'],
                    'budget' => $jobData['budget'],
                    'duration' => $jobData['duration'],
                    'start_date' => $jobData['start_date'],
                    'urgency' => $jobData['urgency'],
                    'required_skills' => $jobData['required_skills'],
                    'is_featured' => $jobData['is_featured'],
                    'is_urgent' => $jobData['is_urgent'],
                    'requires_background_check' => $jobData['requires_background_check'],
                    'status' => $jobData['status'],
                    'views' => rand(5, 50),
                    'applications_count' => rand(0, 8),
                ]);
            }
        }
    }
}