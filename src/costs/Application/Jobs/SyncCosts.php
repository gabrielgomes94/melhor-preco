<?php

namespace Src\Costs\Application\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Src\Costs\Application\UseCases\SynchronizePurchaseInvoices;
use Src\Costs\Application\UseCases\SynchronizePurchaseItems;

class SyncCosts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(
        SynchronizePurchaseInvoices $syncPurchaseInvoices,
        SynchronizePurchaseItems $syncPurchaseItems
    ): void {
        $syncPurchaseInvoices->sync();
        $syncPurchaseItems->sync();
    }
}
