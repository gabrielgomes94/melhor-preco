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
    protected $commands = [];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
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
