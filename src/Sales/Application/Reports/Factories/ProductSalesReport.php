<?php

namespace Src\Sales\Application\Reports\Factories;

use Carbon\Carbon;
use Src\Products\Domain\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Repositories\ProductRepository;
use Src\Sales\Application\Reports\Data\Product\ProductSales;
use Src\Sales\Application\Repositories\ProductSalesRepository;
use Src\Sales\Domain\Models\Collections\SaleItemsCollection;
use Src\Sales\Infrastructure\Laravel\Services\CalculateItem;

class ProductSalesReport
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly ProductSalesRepository $productSalesRepository,
        private readonly CalculateItem $calculateItem
    ) {
    }

    /**
     * @throws ProductNotFoundException
     */
    public function report(
        string $sku,
        string $userId,
        ?Carbon $beginDate = null,
        ?Carbon $endDate = null
    ): ProductSales
    {
        $product = $this->productRepository->get($sku, $userId);

        if (!$product) {
            throw new ProductNotFoundException($sku, $userId);
        }

        $itemsSelled = $this->productSalesRepository->getItemsSelled($product, $beginDate, $endDate);

        return new ProductSales(
            $product,
            new SaleItemsCollection($itemsSelled),
            $this->calculateItem
        );
    }
}
