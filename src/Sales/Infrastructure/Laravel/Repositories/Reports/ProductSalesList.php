<?php

namespace Src\Sales\Infrastructure\Laravel\Repositories\Reports;

use Illuminate\Support\Collection;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Infrastructure\Laravel\Repositories\MarketplaceRepository;
use Src\Products\Domain\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Models\Product;
use Src\Products\Domain\Repositories\ProductRepository;
use Src\Sales\Domain\DataTransfer\SalesFilter;
use Src\Sales\Domain\DataTransfer\Reports\Marketplaces\MarketplaceSales;
use Src\Sales\Domain\DataTransfer\Reports\Products\ProductReport;
use Src\Sales\Domain\DataTransfer\Reports\Products\SalesInMarketplaces;
use Src\Sales\Domain\DataTransfer\SaleItemsCollection;
use Src\Sales\Infrastructure\Laravel\Models\Item;
use Src\Sales\Infrastructure\Laravel\Repositories\Reports\Factories\ProductSalesFactory;

class ProductSalesList
{
    public function __construct(
        private readonly MarketplaceRepository $marketplaceRepository,
        private readonly ProductRepository $productRepository,
        private readonly ProductSalesFactory $productSalesFactory
    ) {
    }

    public function report(string $sku, SalesFilter $options): ProductReport
    {
        $product = $this->productRepository->get($sku, $options->getUserId());

        if (!$product) {
            throw new ProductNotFoundException($sku);
        }

        $salesInMarketplaces = $this->getSaleItemsInAllMarketplaces($product, $options->getUserId());
        $lastSales = $this->getLastSaleItems($product);
        $totalItemsSelled = $this->getTotalSaleItems($product);


        return new ProductReport(
            salesInMarketplaces: $salesInMarketplaces,
            productSales: $this->productSalesFactory->make($totalItemsSelled),
            lastSales: $lastSales,
        );
    }

    private function getLastSaleItems(Product $product, int $limit = 5): SaleItemsCollection
    {
        $sales = $product->getSaleItems();

        $sales = $sales->sortByDesc(function (Item $saleItem) {
            return $saleItem->getSelledAt();
        })->take($limit);

        return new SaleItemsCollection($sales->toArray());
    }

    private function getSaleItemsInAllMarketplaces(Product $product, string $userId): SalesInMarketplaces
    {
        $marketplaces = $this->marketplaceRepository->list($userId);
        $marketplaces = collect($marketplaces);

        $salesInMarketplaces = $marketplaces->map(
            function (Marketplace $marketplace) use ($product) {
                return $this->getSaleItemsByMarketplace($product, $marketplace);
            }
        );

        return new SalesInMarketplaces($salesInMarketplaces);
    }

    private function getSaleItemsByMarketplace(Product $product, Marketplace $marketplace): MarketplaceSales
    {
        $sales = $product->getSaleItems();

        $sales = $sales->filter(function (Item $saleItem) use ($marketplace) {
            if (!$saleOrder = $saleItem->getSaleOrder()) {
                return false;
            }

            $slug = $saleOrder->getMarketplace()?->getSlug() ?? '';

            return $marketplace->getSlug() === $slug;
        });

        return new MarketplaceSales(
            $marketplace,
            new SaleItemsCollection($sales->toArray())
        );
    }

    private function getTotalSaleItems(Product $product): Collection
    {
        return $product->getSaleItems();
    }
}
