<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin user already exists
        $adminExists = User::where('email', 'admin@joblink.com')->exists();

        if (!$adminExists) {
            User::create([
                'name' => 'System Administrator',
                'email' => 'admin@joblink.com',
                'password' => Hash::make('admin123!@#'), // Change this in production
                'role' => 'admin',
                'phone' => '+256 700 000 000',
                'bio' => 'System Administrator for JOB-lyNK platform',
                'location' => 'Kampala, Uganda',
                'email_verified_at' => now(),
            ]);

            $this->command->info('Admin user created successfully!');
            $this->command->info('Email: admin@joblink.com');
            $this->command->info('Password: admin123!@#');
            $this->command->warn('Please change the admin password after first login!');
        } else {
            $this->command->info('Admin user already exists.');
        }
    }
}
