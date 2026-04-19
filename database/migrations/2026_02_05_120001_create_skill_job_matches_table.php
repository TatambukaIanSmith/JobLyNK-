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
        Schema::create('skill_job_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('job_id')->constrained('job_postings')->onDelete('cascade');
            $table->integer('match_score')->default(0); // 0-100 match percentage
            $table->json('match_reasons')->nullable(); // Why this job matches
            $table->boolean('is_viewed')->default(false);
            $table->boolean('is_applied')->default(false);
            $table->timestamp('matched_at');
            $table->timestamps();

            // Indexes
            $table->index(['user_id', 'match_score']);
            $table->index(['job_id', 'match_score']);
            $table->index('matched_at');
            $table->unique(['user_id', 'job_id']); // Prevent duplicate matches
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skill_job_matches');
    }
};