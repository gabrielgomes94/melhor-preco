<?php

namespace Src\Sales\Application\Presenters;

use Src\Math\Transformers\MoneyTransformer;
use Src\Math\Percentage;
use Src\Sales\Domain\Reports\Product\ProductSales;
use Src\Sales\Domain\Reports\Product\ProductSalesCollection;

class ProductSalesPresenter
{
    public function present(ProductSalesCollection $productSalesCollection): array
    {
        $collection = collect($productSalesCollection->get());

        return $collection->transform(
            fn (ProductSales $productSales) => [
                'sku' => $productSales->product->getSku(),
                'name' => $productSales->product->getName(),
                'count' => $productSales->count(),
                'average_price' => $this->formatPrice($productSales->getAveragePrice()),
                'average_profit' => $this->formatPrice($productSales->getAverageProfit()),
                'average_margin' => $this->formatPercentage($productSales->getAverageMargin()),
                'total_revenue' => $this->formatPrice($productSales->getTotalRevenue()),
                'total_profit' => $this->formatPrice($productSales->getTotalProfit()),
            ]
        )->toArray();
    }

    private function formatPercentage(float $fraction): string
    {
        return (string) Percentage::fromFraction($fraction);
    }

    private function formatPrice(float $price): string
    {
        return MoneyTransformer::toText(
            MoneyTransformer::toMoney($price)
        );
    }
}
