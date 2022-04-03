<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Src\Costs\Infrastructure\Laravel\Jobs\SyncCosts;
use Src\Prices\Application\Jobs\SyncPrices;
use Src\Products\Application\UseCases\SynchronizeProducts;
use Src\Products\Presentation\Console\Commands\SyncProducts;
use Src\Sales\Application\Jobs\SyncSales;

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
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(new SyncSales)->everyTenMinutes();

        $schedule->call(function () {
            $syncProducts = app(SynchronizeProducts::class);
            $syncProducts->sync();
        })->weekdays()->daily();
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
