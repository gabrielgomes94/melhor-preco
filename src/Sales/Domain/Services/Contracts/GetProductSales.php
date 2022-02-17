<?php

namespace Src\Sales\Domain\Services\Contracts;

use Src\Marketplaces\Application\Models\Marketplace;
use Src\Products\Domain\Models\Product\Contracts\Product;
use Src\Sales\Application\Data\MarketplaceSaleItems;
use Src\Sales\Application\Data\Reports\SaleItemsInMarketplaces;
use Src\Sales\Application\Data\SaleItemsCollection;

// @todo: avaliar a possibilidade de permitir a passagem de um parâmetro do tipo DateInterval
interface GetProductSales
{
    public function getLastSaleItems(Product $product, int $limit = 5): SaleItemsCollection;

    public function getSaleItemsByMarketplace(Product $product, Marketplace $marketplace): MarketplaceSaleItems;

    public function getSaleItemsInAllMarketplaces(Product $product): SaleItemsInMarketplaces;

    public function getTotalSaleItems(Product $product): SaleItemsCollection;
}
