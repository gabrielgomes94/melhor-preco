<?php

namespace Src\Prices\Calculator\Application\UseCases;

use Src\Products\Domain\Store\Factory;

class GetCommission
{
    public function get(string $sku, string $store): float
    {
        $store = Factory::make($store);

        return $store->getDefaultCommission() ?? 0.0;
    }
}
