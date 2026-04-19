<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule weekly system report generation
// Runs every Sunday at 11:59 PM
Schedule::command('report:weekly')->weeklyOn(0, '23:59');
