<?php

namespace Src\Sales\Domain\Repositories;

use Carbon\Carbon;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Products\Domain\Models\Product;
use Src\Sales\Application\Reports\Data\Marketplace\MarketplaceSales;

interface MarketplaceSalesRepository
{
    public function getSales(
        Marketplace $marketplace,
        ?Carbon $beginDate = null,
        ?Carbon $endDate = null
    ): MarketplaceSales;

    public function getSalesByProduct(
        Product $product,
        Marketplace $marketplace,
        ?Carbon $beginDate = null,
        ?Carbon $endDate = null
    ): MarketplaceSales;
}
