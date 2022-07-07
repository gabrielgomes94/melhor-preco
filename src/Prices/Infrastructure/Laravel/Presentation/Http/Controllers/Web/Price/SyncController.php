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
        $userId = auth()->user()->getAuthIdentifier();
        $this->synchronizePrices->syncMarketplace($storeSlug, $userId);

        return redirect()->back();
    }

    public function syncAll(): RedirectResponse
    {
        $userId = auth()->user()->getAuthIdentifier();
        $this->synchronizePrices->syncAll($userId);

        return redirect()->back();
    }
}
