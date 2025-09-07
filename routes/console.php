<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule log cleanup to run daily at 2 AM
Schedule::command('logs:cleanup')->dailyAt('02:00')->withoutOverlapping();
