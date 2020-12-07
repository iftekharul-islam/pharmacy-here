<?php

namespace App\Console;

use App\Console\Commands\PurchaseReminder;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Modules\Products\Console\ImportProducts;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \Modules\Locations\Console\ImportLocationsCommand::class,
        \App\Console\Commands\ImportProducts::class,
        Commands\PurchaseReminder::class,
        Commands\ForwardPendingOrders::class,


    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        // $schedule->command('inspire')->hourly();
//        $schedule->command('sent:reminder')->dailyAt('11:00');
        $schedule->command('sent:reminder')->everyFiveMinutes();
        $schedule->command('backup:clean')->quarterly();
        $schedule->command('backup:run')->dailyAt('00:00');
//        $schedule->command('run:pending-order-Forward')->hourly();
        $schedule->command('run:pending-order-Forward')->everyFiveMinutes();
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
