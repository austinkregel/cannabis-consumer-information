<?php

namespace App\Console;

use App\Jobs\SyncAllRecalledProducts;
use App\Jobs\SyncMichiganRecallsJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(SyncMichiganRecallsJob::class)->dailyAt('08:00');
        $schedule->job(SyncAllRecalledProducts::class)->dailyAt('09:00');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
