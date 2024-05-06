<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class MonitorJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly Collection $monitors)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        foreach ($this->monitors as $monitor) {
            $now = Carbon::now();
            $response = Http::timeout(5)
                ->{$monitor->method}($monitor->url, $monitor->body);
            $monitor->update([
                'last_run_at' =>  $now ,
                'should_run_at' =>  $now->addMinutes($monitor->interval)
            ]);
            $monitor->histories()->create([
                'start_date' => $now,
                'end_date' => Carbon::now(),
                'status_code' =>  $response->status(),
                'response' => $response->body()
            ]);
        }
    }
}
