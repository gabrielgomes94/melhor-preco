<?php

namespace Src\Prices\Infrastructure\Laravel\Presentation\Http\Controllers\Web\Price;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Src\Prices\Domain\UseCases\Price\SynchronizePrices;

class SyncController extends Controller
{
    public function __construct(
        private SynchronizePrices $synchronizePrices,
    ) {}

    public function sync(string $storeSlug): RedirectResponse
    {
        $this->synchronizePrices->syncMarketplace($storeSlug);

        return redirect()->back();
    }

    public function syncAll(): RedirectResponse
    {
        $this->synchronizePrices->syncAll();

        return redirect()->back();
    }
}
