<?php

namespace Src\Prices\Presentation\Http\Controllers\Web\Price;

use App\Http\Controllers\Controller;
use Src\Prices\Domain\UseCases\Contracts\SynchronizePrices;

class SyncController extends Controller
{
    private SynchronizePrices $synchronizePrices;

    public function __construct(SynchronizePrices $synchronizePrices)
    {
        $this->synchronizePrices = $synchronizePrices;
    }

    public function sync(string $storeSlug)
    {
        $this->synchronizePrices->syncMarketplace($storeSlug);

        return redirect()->back();
    }
}
