<?php

namespace Src\Prices\Application\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Src\Integrations\Bling\Products\Requests\Config;
use Src\Marketplaces\Domain\Models\Contracts\Marketplace;
use Src\Prices\Application\Services\Prices\SavePrices;
use Src\Prices\Application\UseCases\SynchronizePrices;
use Src\Products\Infrastructure\Bling\ProductRepository as BlingRepository;

class SyncPrices implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private Marketplace $marketplace;
    private int $page;

    public function __construct(
        Marketplace $marketplace,
        int $page
    )
    {
        $this->marketplace = $marketplace;
        $this->page = $page;
    }

    public function handle(BlingRepository $erpRepository, SavePrices $savePrices): void
    {
        $prices = $erpRepository->allInMarketplace(
            $this->marketplace,
            Config::ACTIVE,
            $this->page
        );

        if (empty($prices->data())) {
            return;
        }

        $savePrices->save($prices);
        SyncPrices::dispatch($this->marketplace, $this->page + 1);
    }
}
