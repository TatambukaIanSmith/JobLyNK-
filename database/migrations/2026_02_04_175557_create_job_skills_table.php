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
        Schema::create('job_skills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_id');
            $table->foreignId('skill_id')->constrained()->onDelete('cascade');
            $table->enum('required_level', ['Beginner', 'Intermediate', 'Advanced', 'Expert'])->default('Beginner');
            $table->boolean('is_required')->default(true); // Required vs Nice to have
            $table->timestamps();
            
            $table->foreign('job_id')->references('id')->on('job_postings')->onDelete('cascade');
            $table->unique(['job_id', 'skill_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_skills');
    }
};