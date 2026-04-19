<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type'); // 'application', 'job_view', 'message', 'interview', etc.
            $table->string('title');
            $table->text('description');
            $table->json('metadata')->nullable(); // Store additional data like job_id, application_id, etc.
            $table->boolean('is_read')->default(false);
            $table->timestamps();
            
            $table->index(['user_id', 'created_at']);
            $table->index(['user_id', 'is_read']);
            $table->index(['type', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};