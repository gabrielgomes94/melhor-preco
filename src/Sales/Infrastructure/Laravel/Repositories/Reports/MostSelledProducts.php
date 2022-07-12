<?php

namespace Src\Sales\Infrastructure\Laravel\Repositories\Reports;

use Illuminate\Support\Collection;
use Src\Sales\Domain\DataTransfer\SalesFilter;
use Src\Sales\Domain\DataTransfer\Reports\Products\ProductSales;
use Src\Sales\Domain\DataTransfer\Reports\Products\ProductSalesCollection;
use Src\Sales\Domain\Repositories\SaleItemsRepository;
use Src\Sales\Infrastructure\Laravel\Repositories\Reports\Factories\ProductSalesFactory;

class MostSelledProducts
{
    public function __construct(
        private readonly SaleItemsRepository $itemsRepository,
        private readonly ProductSalesFactory $productSalesFactory
    )
    {
    }

    /**
     * @return ProductSalesFactory[]
     */
    public function report(SalesFilter $options): ProductSalesCollection
    {
        $items = $this->itemsRepository->groupSaleItemsByProduct($options);

        $data = $items->transform(
            fn (Collection $itemsCollection) => $this->productSalesFactory->make($itemsCollection)
        )->filter(
            fn (?ProductSales $item) => !empty($item)
        );

        return new ProductSalesCollection(
            $data->toArray()
        );
    }
}
