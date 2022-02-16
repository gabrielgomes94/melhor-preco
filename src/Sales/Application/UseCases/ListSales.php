<?php

namespace Src\Sales\Application\UseCases;

use Src\Sales\Presentation\Presenters\ListSalesPresenter;
use Src\Sales\Domain\Repositories\Contracts\Repository;
use Src\Sales\Domain\UseCases\Contracts\Filters\ListSalesFilter;
use Src\Sales\Domain\UseCases\Contracts\ListSales as ListSalesInterface;

class ListSales implements ListSalesInterface
{
    private ListSalesPresenter $presenter;
    private Repository $repository;

    public function __construct(ListSalesPresenter $presenter, Repository $repository)
    {
        $this->presenter = $presenter;
        $this->repository = $repository;
    }

    public function list(ListSalesFilter $options): array
    {
        $beginDate = $options->getBeginDate();
        $endDate = $options->getEndDate();

        $sales = $this->repository->listPaginate(
            beginDate: $beginDate,
            endDate: $endDate,
            page: $options->getPage(),
        );

        $totalValue = $this->repository->getTotalValueSum($beginDate, $endDate);
        $totalProfit = $this->repository->getTotalProfitSum($beginDate, $endDate);
        $salesCount = $this->repository->getTotalSalesCount($beginDate, $endDate);
        $productsCount = $this->repository->getTotalProductsCount($beginDate, $endDate);
        $storesCount = $this->repository->getTotalStoresCount($beginDate, $endDate);

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
