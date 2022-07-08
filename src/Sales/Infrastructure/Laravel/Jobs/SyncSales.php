<?php

namespace Src\Sales\Infrastructure\Laravel\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Src\Sales\Infrastructure\Laravel\Services\Synchronization\CalculateTotalProfit;
use Src\Sales\Infrastructure\Laravel\Services\Synchronization\SynchronizeSales;
use Src\Sales\Domain\Repositories\Contracts\ErpRepository;

class SyncSales implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private CalculateTotalProfit $calculateTotalProfit;

    public function __construct(private string $userId)
    {
    }

    public function handle(SynchronizeSales $synchronizeService): void
    {
        $synchronizeService->sync($this->userId);
    }
}
