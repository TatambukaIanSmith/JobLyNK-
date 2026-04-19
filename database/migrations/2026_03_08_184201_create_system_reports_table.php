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
        Schema::create('system_reports', function (Blueprint $table) {
            $table->id();
            $table->date('week_start_date');
            $table->date('week_end_date');
            $table->integer('total_new_users')->default(0);
            $table->integer('total_jobs_posted')->default(0);
            $table->integer('total_applications')->default(0);
            $table->integer('total_workers_hired')->default(0);
            $table->integer('total_transactions')->default(0);
            $table->decimal('total_revenue', 15, 2)->default(0);
            $table->string('most_active_employer')->nullable();
            $table->string('most_active_worker')->nullable();
            $table->integer('system_errors')->default(0);
            $table->decimal('average_response_time', 8, 2)->nullable();
            $table->string('pdf_path')->nullable();
            $table->timestamps();
            
            // Indexes for performance
            $table->index('week_start_date');
            $table->index('week_end_date');
            $table->unique(['week_start_date', 'week_end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_reports');
    }
};
