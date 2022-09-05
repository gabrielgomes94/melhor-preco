<?php

namespace Src\Prices\Infrastructure\Laravel\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Src\Integrations\Bling\Products\Requests\Config;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Prices\Infrastructure\Laravel\Services\SynchronizeFromMarketplace;
use Src\Products\Infrastructure\Bling\ProductRepository as BlingRepository;

final class SyncPrices implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private readonly Marketplace $marketplace,
        private readonly int $page,
        private readonly string $status
    )
    {}

    public function handle(SynchronizeFromMarketplace $synchronizeFromMarketplace): void
    {
        $result = $synchronizeFromMarketplace->sync($this->marketplace, $this->page, $this->status);

        if (!$result && $this->page > 10) {
            return;
        }

        SyncPrices::dispatch($this->marketplace, $this->page + 1, $this->status);
    }
}
