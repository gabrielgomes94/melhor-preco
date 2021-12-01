<?php


namespace Src\Prices\Price\Application\Jobs;


use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Src\Prices\Price\Application\Services\Synchronization\SynchronizePrices;

class SyncPrices
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function handle(SynchronizePrices $syncService): void
    {
        $syncService->sync();
    }
}
