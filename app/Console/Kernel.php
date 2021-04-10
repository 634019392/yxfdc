<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        $schedule->command('cron:customer-failure')
            ->cron('0 1 * * *');
        $schedule->command('cron:clean-excel')
            ->cron('50 0 * * *');

        $schedule->command('cron:crawl-area')
            ->cron('00 22 * * *');
        $schedule->command('cron:crawl-data')
            ->cron('02 22 * * *');
        $schedule->command('cron:crawl-qsfx')
            ->cron('04 22 * * *');
        $schedule->command('cron:crawl-hslxfx')
            ->cron('00 21 * * *');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
