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
        Schema::table('users', function (Blueprint $table) {
            // Add latitude and longitude columns
            $table->decimal('latitude', 10, 7)->nullable()->after('location');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            
            // Add geohash for fast proximity searches
            $table->string('geohash', 12)->nullable()->index()->after('longitude');
            
            // Add preferred search radius in kilometers (default 10km)
            $table->integer('preferred_radius')->default(10)->after('geohash');
            
            // Add location sharing preference
            $table->boolean('share_location')->default(false)->after('preferred_radius');
        });

        // Add spatial column using raw SQL (MySQL POINT type) with default value
        // We'll set coordinates when latitude/longitude are provided
        DB::statement('ALTER TABLE users ADD coordinates POINT NULL AFTER geohash');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude', 'geohash', 'preferred_radius', 'share_location']);
        });
        
        // Drop coordinates column
        DB::statement('ALTER TABLE users DROP COLUMN coordinates');
    }
};
