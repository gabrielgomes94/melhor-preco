<?php

namespace Src\Prices\Infrastructure\Laravel\Presentation\Http\Controllers\Web\Price;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Src\Marketplaces\Infrastructure\Laravel\Repositories\MarketplaceRepository;
use Src\Prices\Domain\UseCases\Price\SynchronizePrices;

class SyncController extends Controller
{
    public function __construct(
        private SynchronizePrices $synchronizePrices,
        private MarketplaceRepository $marketplaceRepository
    ) {
    }

    public function sync(string $storeSlug): RedirectResponse
    {
        $this->synchronizePrices->syncMarketplace($storeSlug);

        return redirect()->back();
    }

    public function syncAll(): RedirectResponse
    {
        $marketplaces = $this->marketplaceRepository->list();

        foreach ($marketplaces as $marketplace) {
            $this->synchronizePrices->syncMarketplace($marketplace->getSlug());
        }

        return redirect()->back();
    }
}
