<?php

namespace Src\Sales\Domain\Services\Contracts;

use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Products\Domain\Models\Product\Product;
use Src\Sales\Domain\DataTransfer\MarketplaceSaleItems;
use Src\Sales\Domain\DataTransfer\Reports\SaleItemsInMarketplaces;
use Src\Sales\Domain\DataTransfer\SaleItemsCollection;

// @todo: avaliar a possibilidade de permitir a passagem de um parâmetro do tipo DateInterval
interface GetProductSales
{
    public function getLastSaleItems(Product $product, int $limit = 5): SaleItemsCollection;

    public function getSaleItemsByMarketplace(Product $product, Marketplace $marketplace): MarketplaceSaleItems;

    public function getSaleItemsInAllMarketplaces(Product $product): SaleItemsInMarketplaces;

    public function getTotalSaleItems(Product $product): SaleItemsCollection;
}
