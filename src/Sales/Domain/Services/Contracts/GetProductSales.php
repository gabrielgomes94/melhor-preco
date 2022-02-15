<?php

namespace Src\Sales\Domain\Services\Contracts;

use Illuminate\Support\Collection;
use Src\Marketplaces\Application\Models\Marketplace;
use Src\Products\Domain\Models\Product\Contracts\Product;
use Src\Sales\Application\Data\MarketplaceSales;

// @todo: avaliar a possibilidade de permitir a passagem de um parâmetro do tipo DateInterval
interface GetProductSales
{
    public function getLastSales(Product $product, int $limit = 5): Collection;

    public function getSalesByMarketplace(Product $product, Marketplace $marketplace): MarketplaceSales;

    public function getSalesInAllMarketplaces(Product $product): Collection;

    public function getTotalSales(Product $product): Collection;
}
