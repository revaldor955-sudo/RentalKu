
<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Membuat atau memperbarui denda keterlambatan setiap hari pukul 00.05
Schedule::command('dendas:generate-late')->dailyAt('00:05');
