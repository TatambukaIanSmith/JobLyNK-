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
        Schema::create('job_postings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // employer
            $table->foreignId('category_id')->constrained('categories')->onDelete('restrict');
            $table->string('title');
            $table->text('description');
            $table->string('location');
            $table->enum('job_type', ['one-time', 'recurring', 'project'])->default('one-time');
            $table->enum('payment_type', ['hourly', 'fixed', 'negotiable'])->default('hourly');
            $table->decimal('budget', 10, 2)->nullable();
            $table->string('duration')->nullable(); // e.g., "3-5 hours", "full-day"
            $table->date('start_date');
            $table->enum('urgency', ['normal', 'urgent', 'asap'])->default('normal');
            $table->json('required_skills')->nullable(); // array of skills
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_urgent')->default(false);
            $table->boolean('requires_background_check')->default(false);
            $table->enum('status', ['draft', 'active', 'filled', 'cancelled', 'completed'])->default('draft');
            $table->integer('views')->default(0);
            $table->integer('applications_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['status', 'created_at']);
            $table->index(['category_id', 'status']);
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_postings');
    }
};
