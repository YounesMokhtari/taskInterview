<?php

use App\Jobs\MonitorJob;
use App\Models\Monitor;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::Job(
    new MonitorJob(Monitor::query()
        ->where('should_run_at', Carbon::now())
        ->get())
)->everyMinute();
