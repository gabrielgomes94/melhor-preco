<?php

namespace Src\Prices\Calculator\Application\Services;

use Src\Products\Domain\Models\Store\Factory;

// To Do: Retornar instância de Percentage. Talvez definir uma interface aqui
class GetCommission
{
    public function get(string $sku, string $store): float
    {
        $store = Factory::make($store);

        return $store->getDefaultCommission() ?? 0.0;
    }
}
