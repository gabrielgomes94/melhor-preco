<?php

namespace Src\Sales\Infrastructure\Laravel\Repositories\Reports;

use Illuminate\Support\Collection;
use Src\Sales\Application\Reports\Data\Product\ProductSales;
use Src\Sales\Domain\DataTransfer\SalesFilter;
use Src\Sales\Domain\Reports\Product\ProductSalesCollection;
use Src\Sales\Domain\Models\Collections\SaleItemsCollection;
use Src\Sales\Domain\Repositories\SaleItemsRepository;
use Src\Sales\Infrastructure\Laravel\Services\CalculateItem;

class MostSelledProducts
{
    public function __construct(
        private readonly SaleItemsRepository $itemsRepository,
        private readonly CalculateItem $calculateItem,
    )
    {}

    public function report(SalesFilter $options): ProductSalesCollection
    {
        $items = $this->itemsRepository->groupSaleItemsByProduct($options);

        $data = $items->transform(
            function (Collection $saleItemsCollection) {
                if (!$product = $saleItemsCollection->first()?->product) {
                    return null;
                }

                $saleItemsCollection = new SaleItemsCollection($saleItemsCollection->toArray());
                return new ProductSales(
                    $product,
                    $saleItemsCollection,
                    $this->calculateItem
                );
            }
        )->filter(
            fn (?ProductSales $item) => !empty($item)
        );

        return new ProductSalesCollection(
            $data->toArray()
        );
    }
}
