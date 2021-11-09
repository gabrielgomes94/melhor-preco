<?php

namespace Src\Products\Application\Services\Synchronization;

class Synchronize
{
    private SynchronizePrices $sinchronizePrices;
    private SynchronizeProducts $sinchronizeProducts;

    public function __construct(
        SynchronizePrices $sinchronizePrices,
        SynchronizeProducts $sinchronizeProducts,
    ) {
        $this->sinchronizePrices = $sinchronizePrices;
        $this->sinchronizeProducts = $sinchronizeProducts;
    }

    public function sync(): void
    {
        $this->sinchronizeProducts->sync();
        $this->sinchronizePrices->sync();
    }
}
