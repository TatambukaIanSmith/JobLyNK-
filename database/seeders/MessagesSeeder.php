<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Message;
use App\Models\User;

class MessagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some users for testing
        $worker = User::where('role', 'worker')->first();
        $employer = User::where('role', 'employer')->first();
        $admin = User::where('role', 'admin')->first();

        if (!$worker || !$employer) {
            $this->command->info('No worker or employer found. Skipping messages seeding.');
            return;
        }

        // Create sample conversation between worker and employer
        $messages = [
            [
                'sender_id' => $employer->id,
                'receiver_id' => $worker->id,
                'message' => 'Hello! I saw your profile and I\'m interested in discussing a potential opportunity with our company.',
                'is_read' => true,
                'read_at' => now()->subHours(2),
                'created_at' => now()->subHours(3),
                'updated_at' => now()->subHours(3),
            ],
            [
                'sender_id' => $worker->id,
                'receiver_id' => $employer->id,
                'message' => 'Hi! Thank you for reaching out. I\'d be happy to learn more about the opportunity.',
                'is_read' => true,
                'read_at' => now()->subHours(2),
                'created_at' => now()->subHours(2)->subMinutes(30),
                'updated_at' => now()->subHours(2)->subMinutes(30),
            ],
            [
                'sender_id' => $employer->id,
                'receiver_id' => $worker->id,
                'message' => 'Great! We have a senior developer position that might be perfect for you. Are you available for a quick call this week?',
                'is_read' => true,
                'read_at' => now()->subHours(1),
                'created_at' => now()->subHours(2),
                'updated_at' => now()->subHours(2),
            ],
            [
                'sender_id' => $worker->id,
                'receiver_id' => $employer->id,
                'message' => 'That sounds interesting! I\'m available Tuesday or Wednesday afternoon. What time works best for you?',
                'is_read' => false,
                'read_at' => null,
                'created_at' => now()->subHour(),
                'updated_at' => now()->subHour(),
            ],
        ];

        foreach ($messages as $messageData) {
            Message::create($messageData);
        }

        // Create a message from admin if admin exists
        if ($admin) {
            Message::create([
                'sender_id' => $admin->id,
                'receiver_id' => $worker->id,
                'message' => 'Welcome to JOB-lyNK! If you have any questions or need assistance, feel free to reach out.',
                'is_read' => false,
                'read_at' => null,
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ]);
        }

        $this->command->info('Sample messages created successfully!');
    }
}