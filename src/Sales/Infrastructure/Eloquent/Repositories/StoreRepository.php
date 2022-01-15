<?php

namespace Src\Sales\Infrastructure\Eloquent\Repositories;

use Src\Products\Domain\Models\Store\Store;
use Src\Sales\Domain\Models\SaleOrder;
use Src\Sales\Infrastructure\Logging\Logging;

class StoreRepository
{
    public function get(SaleOrder $saleOrder): ?Store
    {
        if (!$store = $saleOrder->getStore()) {
            Logging::storeNotFound($saleOrder);

            return null;
        }

        return $store;
    }
}
