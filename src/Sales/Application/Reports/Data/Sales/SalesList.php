<?php

namespace Src\Sales\Application\Reports\Data\Sales;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;
use Src\Sales\Domain\Models\Collections\SaleOrdersCollection;
use Src\Sales\Infrastructure\Laravel\Models\SaleOrder;

class SalesList
{
    public readonly Collection $sales;
    public readonly array $marketplaceSales;
    public readonly Paginator $paginator;

    public function __construct(
        SaleOrdersCollection $sales,
        array $marketplaceSales,
        Paginator $paginator
    )
    {
        $this->sales = collect($sales->get());
        $this->marketplaceSales = $marketplaceSales;
        $this->paginator = $paginator;
    }

    public function count(): int
    {
        return $this->sales->count();
    }

    public function getMarketplaceSales(): array
    {
        return $this->marketplaceSales;
    }

    public function getProductsCount(): int
    {
        return $this->sales->sum(
            fn (SaleOrder $saleOrder) => $saleOrder->items->count()
        );
    }

    public function getSaleOrders(): SaleOrdersCollection
    {
        return new SaleOrdersCollection($this->sales->all());
    }

    public function getTotalProfit(): float
    {
        return $this->sales->sum('total_value');
    }

    public function getTotalValue(): float
    {
        return $this->sales->sum('total_profit');
    }
}
