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
        // Job postings indexes
        Schema::table('job_postings', function (Blueprint $table) {
            $table->index(['user_id', 'status'], 'idx_jobs_user_status');
            $table->index(['status', 'created_at'], 'idx_jobs_status_created');
            $table->index(['category_id'], 'idx_jobs_category');
        });

        // Applications indexes
        Schema::table('applications', function (Blueprint $table) {
            $table->index(['job_id', 'status'], 'idx_apps_job_status');
            $table->index(['user_id', 'status'], 'idx_apps_user_status');
            $table->index(['created_at'], 'idx_apps_created');
        });

        // Messages indexes
        Schema::table('messages', function (Blueprint $table) {
            $table->index(['sender_id', 'receiver_id'], 'idx_msgs_sender_receiver');
            $table->index(['receiver_id', 'is_read'], 'idx_msgs_receiver_read');
            $table->index(['created_at'], 'idx_msgs_created');
        });

        // User skills indexes
        Schema::table('user_skills', function (Blueprint $table) {
            $table->index(['user_id', 'skill_id'], 'idx_user_skills_composite');
            $table->index(['skill_id'], 'idx_user_skills_skill');
        });

        // Job skills indexes
        Schema::table('job_skills', function (Blueprint $table) {
            $table->index(['job_id', 'skill_id'], 'idx_job_skills_composite');
            $table->index(['skill_id'], 'idx_job_skills_skill');
        });

        // Payments indexes
        Schema::table('payments', function (Blueprint $table) {
            $table->index(['user_id', 'status'], 'idx_payments_user_status');
            $table->index(['created_at'], 'idx_payments_created');
        });

        // Bookmarks indexes
        Schema::table('bookmarks', function (Blueprint $table) {
            $table->index(['user_id', 'job_id'], 'idx_bookmarks_composite');
            $table->index(['job_id'], 'idx_bookmarks_job');
        });

        // Likes indexes
        Schema::table('likes', function (Blueprint $table) {
            $table->index(['user_id', 'job_id'], 'idx_likes_composite');
            $table->index(['job_id'], 'idx_likes_job');
        });

        // Activity logs indexes
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->index(['user_id', 'created_at'], 'idx_activity_user_created');
            $table->index(['type'], 'idx_activity_type');
        });

        // Job notifications indexes
        Schema::table('job_notifications', function (Blueprint $table) {
            $table->index(['user_id', 'is_read'], 'idx_notifications_user_read');
            $table->index(['job_id'], 'idx_notifications_job');
            $table->index(['type'], 'idx_notifications_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_postings', function (Blueprint $table) {
            $table->dropIndex('idx_jobs_user_status');
            $table->dropIndex('idx_jobs_status_created');
            $table->dropIndex('idx_jobs_category');
        });

        Schema::table('applications', function (Blueprint $table) {
            $table->dropIndex('idx_apps_job_status');
            $table->dropIndex('idx_apps_user_status');
            $table->dropIndex('idx_apps_created');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->dropIndex('idx_msgs_sender_receiver');
            $table->dropIndex('idx_msgs_receiver_read');
            $table->dropIndex('idx_msgs_created');
        });

        Schema::table('user_skills', function (Blueprint $table) {
            $table->dropIndex('idx_user_skills_composite');
            $table->dropIndex('idx_user_skills_skill');
        });

        Schema::table('job_skills', function (Blueprint $table) {
            $table->dropIndex('idx_job_skills_composite');
            $table->dropIndex('idx_job_skills_skill');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex('idx_payments_user_status');
            $table->dropIndex('idx_payments_created');
        });

        Schema::table('bookmarks', function (Blueprint $table) {
            $table->dropIndex('idx_bookmarks_composite');
            $table->dropIndex('idx_bookmarks_job');
        });

        Schema::table('likes', function (Blueprint $table) {
            $table->dropIndex('idx_likes_composite');
            $table->dropIndex('idx_likes_job');
        });

        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropIndex('idx_activity_user_created');
            $table->dropIndex('idx_activity_type');
        });

        Schema::table('job_notifications', function (Blueprint $table) {
            $table->dropIndex('idx_notifications_user_read');
            $table->dropIndex('idx_notifications_job');
            $table->dropIndex('idx_notifications_type');
        });
    }
};
