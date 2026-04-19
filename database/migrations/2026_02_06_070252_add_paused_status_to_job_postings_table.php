<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify the status enum to include 'paused'
        DB::statement("ALTER TABLE job_postings MODIFY COLUMN status ENUM('draft', 'active', 'paused', 'filled', 'cancelled', 'completed') DEFAULT 'draft'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values
        DB::statement("ALTER TABLE job_postings MODIFY COLUMN status ENUM('draft', 'active', 'filled', 'cancelled', 'completed') DEFAULT 'draft'");
    }
};
