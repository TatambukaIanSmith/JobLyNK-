<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('worker_availability_zones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Availability status
            $table->enum('status', ['available', 'busy', 'unavailable'])->default('available');
            
            // Availability schedule
            $table->date('available_from')->nullable();
            $table->date('available_until')->nullable();
            
            // Time preferences
            $table->time('preferred_start_time')->nullable();
            $table->time('preferred_end_time')->nullable();
            
            // Days of week availability (JSON array: [1,2,3,4,5] for Mon-Fri)
            $table->json('available_days')->nullable();
            
            // Maximum distance willing to travel (km)
            $table->integer('max_travel_distance')->default(10);
            
            // Preferred job types
            $table->json('preferred_job_types')->nullable();
            
            // Minimum acceptable pay
            $table->decimal('minimum_pay', 10, 2)->nullable();
            
            // Instant notifications enabled
            $table->boolean('instant_notifications')->default(true);
            
            // Last location update
            $table->timestamp('last_location_update')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index(['user_id', 'status']);
            $table->index('available_from');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worker_availability_zones');
    }
};
