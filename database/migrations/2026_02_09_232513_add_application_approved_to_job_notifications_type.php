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
        // Modify the enum to add 'application_approved'
        DB::statement("ALTER TABLE job_notifications MODIFY COLUMN type ENUM('job_match', 'worker_match', 'application_approved') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values
        DB::statement("ALTER TABLE job_notifications MODIFY COLUMN type ENUM('job_match', 'worker_match') NOT NULL");
    }
};
