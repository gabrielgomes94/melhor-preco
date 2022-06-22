<?php

namespace Src\Costs\Infrastructure\Laravel\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Src\Costs\Domain\UseCases\SynchronizePurchaseInvoices;
use Src\Costs\Domain\UseCases\SynchronizePurchaseItems;

class SyncCosts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private string $userId)
    {}


    public function handle(
        SynchronizePurchaseInvoices $syncPurchaseInvoices,
        SynchronizePurchaseItems $syncPurchaseItems
    ): void {
        $syncPurchaseInvoices->sync($this->userId);
        $syncPurchaseItems->sync();
    }
}
