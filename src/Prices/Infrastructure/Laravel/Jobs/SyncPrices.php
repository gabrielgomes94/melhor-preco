<?php

namespace Src\Prices\Infrastructure\Laravel\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Src\Integrations\Bling\Products\Requests\Config;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Prices\Infrastructure\Laravel\Services\Prices\SynchronizeFromMarketplace;
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
        $page = $this->page;

        do {
            $result = $synchronizeFromMarketplace->sync($this->marketplace, $page, $this->status);
            $page++;
        } while ($result || $page < 100);
    }
}
