<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Src\Costs\Infrastructure\Laravel\Jobs\SyncCosts;
use Src\Prices\Infrastructure\Laravel\Jobs\SyncPrices;
use Src\Products\Infrastructure\Laravel\Services\SynchronizeData;
use Src\Products\Infrastructure\Laravel\Console\Commands\SyncProducts;
use Src\Sales\Infrastructure\Laravel\Jobs\SyncSales;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SyncProducts::class,
    ];

    /**
     * Define the application's command schedule.
     * @todo: fix this
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(new SyncSales)->everyTenMinutes();

        $schedule->call(function () {
            $syncProducts = app(SynchronizeData::class);
            $syncProducts->sync();
        })->weekdays()->daily();

        $schedule->job(new SyncCosts)->weekdays()->daily();
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
