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
        Schema::create('skill_to_cash_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->json('categories')->nullable(); // Skill categories selected
            $table->text('what_you_can_do')->nullable(); // Description of abilities
            $table->json('tools')->nullable(); // Tools and equipment they can use
            $table->json('tasks')->nullable(); // Real tasks they've completed
            $table->json('visibility_settings')->nullable(); // Profile visibility preferences
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_updated')->nullable();
            $table->timestamps();

            // Indexes for better performance
            $table->index('user_id');
            $table->index('is_active');
            $table->index('last_updated');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skill_to_cash_profiles');
    }
};