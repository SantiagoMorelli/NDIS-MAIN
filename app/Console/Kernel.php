<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Storage;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        Commands\TrackingProgress::class,
        Commands\ClearAssigned::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $file=storage_path().'\logs\progress.log';
        // Manual Device Activation Notification Cron
        $schedule->command('nids:manualdeviceactivate')->daily();
        // Refresh Device Cron
        $schedule->command('nids:refreshdevice')->daily();
        // Update Order Item Status Cron
        $schedule->command('nids:updateorderitemstatus')->hourly();
        // Delete Logs Cron
        $schedule->command('nids:deletelogs')->monthly();

        $schedule->command('tracking:progress')
        ->everyThreeMinutes()->appendOutputTo($file);
        $schedule->command('clear:assigned')->weekly()->appendOutputTo($file);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
