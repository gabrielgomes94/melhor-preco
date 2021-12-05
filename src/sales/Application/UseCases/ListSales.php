<?php

namespace Src\Sales\Application\UseCases;

use Src\Sales\Application\Presenters\ListSalesPresenter;
use Src\Sales\Domain\UseCases\Contracts\Filters\ListSalesFilter;
use Src\Sales\Domain\UseCases\Contracts\ListSales as ListSalesInterface;
use Src\Sales\Infrastructure\Eloquent\Repository;

class ListSales implements ListSalesInterface
{
    private ListSalesPresenter $presenter;

    public function __construct(ListSalesPresenter $presenter)
    {
        $this->presenter = $presenter;
    }

    public function list(ListSalesFilter $options): array
    {
        $beginDate = $options->getBeginDate();
        $endDate = $options->getEndDate();

        $sales = Repository::listPaginate(
            beginDate: $beginDate,
            endDate: $endDate,
            page: $options->getPage(),
        );

        $totalValue = Repository::getTotalValueSum($beginDate, $endDate);
        $totalProfit = Repository::getTotalProfitSum($beginDate, $endDate);
        $salesCount = Repository::getTotalSalesCount($beginDate, $endDate);
        $productsCount = Repository::getTotalProductsCount($beginDate, $endDate);
        $storesCount = Repository::getTotalStoresCount($beginDate, $endDate);

        $saleOrders = $this->presenter->listSaleOrder($sales->items());

        return [
            'saleOrders' => $saleOrders ?? [],
            'meta' => [
                'beginDate' => $beginDate->format('d/m/Y'),
                'endDate' => $endDate->format('d/m/Y'),
                'salesCount' => $salesCount,
                'productsCount' => $productsCount,
                'storesCount' => $storesCount,
                'value' => $totalValue,
                'profit' => $totalProfit,
            ],
            'paginator' => $sales,
        ];
    }
}
