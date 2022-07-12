<?php

namespace Src\Prices\Infrastructure\Laravel\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Src\Integrations\Bling\Products\Requests\Config;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Prices\Infrastructure\Laravel\Services\Prices\SynchronizeFromMarketplace;
use Src\Products\Infrastructure\Bling\ProductRepository as BlingRepository;

class SyncPrices implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private Marketplace $marketplace;
    private int $page;
    private string $status;

    public function __construct(
        Marketplace $marketplace,
        int $page,
        string $status
    )
    {
        $this->marketplace = $marketplace;
        $this->page = $page;
        $this->status = $status;
    }

    public function handle(SynchronizeFromMarketplace $synchronizeFromMarketplace): void
    {
        $result = $synchronizeFromMarketplace->sync($this->marketplace, $this->page, $this->status);

        if (!$result) {
            return;
        }

        SyncPrices::dispatch($this->marketplace, $this->page + 1, $this->status);
    }
}
