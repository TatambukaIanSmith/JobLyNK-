<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed categories first
        $this->call([
            CategoriesSeeder::class,
        ]);

        // Create test users
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test Worker',
                'password' => 'password',
                'role' => 'worker',
                'email_verified_at' => now(),
                'phone' => '+256 700 000 001',
                'bio' => 'Experienced construction worker',
                'location' => 'Kampala, Uganda',
            ]
        );

        User::firstOrCreate(
            ['email' => 'employer@example.com'],
            [
                'name' => 'Test Employer',
                'password' => 'password',
                'role' => 'employer',
                'email_verified_at' => now(),
                'phone' => '+256 700 000 002',
                'bio' => 'Construction company owner',
                'location' => 'Kampala, Uganda',
            ]
        );

        // Seed sample jobs
        $this->call([
            JobsSeeder::class,
        ]);
    }
}
