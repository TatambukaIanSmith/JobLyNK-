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
        Schema::table('job_postings', function (Blueprint $table) {
            // Check if columns don't exist before adding
            if (!Schema::hasColumn('job_postings', 'latitude')) {
                $table->decimal('latitude', 10, 7)->nullable()->after('location');
            }
            if (!Schema::hasColumn('job_postings', 'longitude')) {
                $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            }
            if (!Schema::hasColumn('job_postings', 'geohash')) {
                $table->string('geohash', 12)->nullable()->index()->after('longitude');
            }
            if (!Schema::hasColumn('job_postings', 'search_radius')) {
                $table->integer('search_radius')->default(10)->after('geohash');
            }
        });

        // Check if coordinates column exists
        $hasCoordinates = DB::select("SHOW COLUMNS FROM job_postings LIKE 'coordinates'");
        if (empty($hasCoordinates)) {
            // Add spatial column using raw SQL (MySQL POINT type) with default value
            DB::statement('ALTER TABLE job_postings ADD coordinates POINT NULL AFTER geohash');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_postings', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude', 'geohash', 'search_radius']);
        });
        
        // Drop coordinates column
        DB::statement('ALTER TABLE job_postings DROP COLUMN coordinates');
    }
};
