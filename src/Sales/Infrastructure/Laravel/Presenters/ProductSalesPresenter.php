<?php

namespace Src\Sales\Infrastructure\Laravel\Presenters;

use Src\Math\Money;
use Src\Math\Percentage;
use Src\Sales\Domain\DataTransfer\Reports\Products\ProductSales;
use Src\Sales\Domain\DataTransfer\Reports\Products\ProductSalesCollection;

class ProductSalesPresenter
{
    public function present(ProductSalesCollection $productSalesCollection): array
    {
        $collection = collect($productSalesCollection->get());

        return $collection->transform(
            fn (ProductSales $productSales) => [
                'sku' => $productSales->product->getSku(),
                'name' => $productSales->product->getName(),
                'count' => $productSales->count,
                'average_price' => $this->formatPrice($productSales->averagePrice),
                'average_profit' => $this->formatPrice($productSales->averageProfit),
                'average_margin' => $this->formatPercentage($productSales->averageMargin),
                'total_revenue' => $this->formatPrice($productSales->totalRevenue),
                'total_profit' => $this->formatPrice($productSales->totalProfit),
            ]
        )->toArray();
    }

    private function formatPercentage(float $fraction): string
    {
        return (string) Percentage::fromFraction($fraction);
    }

    private function formatPrice(float $price): string
    {
        return (string) Money::fromFloat($price);
    }
}
