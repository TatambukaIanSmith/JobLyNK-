<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->enum('stage', ['applied', 'screening', 'interview', 'hired', 'rejected'])
                  ->default('applied')
                  ->after('status');
            $table->integer('score')->nullable()->after('stage');
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn(['stage', 'score']);
        });
    }
};