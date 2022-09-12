<?php

namespace Src\Prices\Infrastructure\Laravel\Http\Controllers\Web\Price;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Prices\Domain\Services\SynchronizeFromMarketplace;
use Src\Prices\Infrastructure\Laravel\Jobs\SyncPrices;

class SyncController extends Controller
{
    public function __construct(
        private readonly MarketplaceRepository $marketplaceRepository
    ) {}

    public function sync(string $marketplaceSlug): RedirectResponse
    {
        $marketplace = $this->marketplaceRepository->getBySlug($marketplaceSlug, $this->getUserId());
        $this->syncMarketplace($marketplace);

        return redirect()->back();
    }

    public function syncAll(): RedirectResponse
    {
        $marketplaces = $this->marketplaceRepository->list($this->getUserId());

        foreach ($marketplaces as $marketplace) {
            $this->syncMarketplace($marketplace);
        }

        return redirect()->back();
    }

    private function syncMarketplace(Marketplace $marketplace): void
    {
        SyncPrices::dispatch($marketplace, 1, SynchronizeFromMarketplace::ACTIVE);
        SyncPrices::dispatch($marketplace, 1, SynchronizeFromMarketplace::INACTIVE);
    }
}
