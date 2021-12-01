<?php

namespace Src\Sales\Application\UseCases;

use Src\Sales\Application\Presenters\ListSalesPresenter;
use Src\Sales\Domain\UseCases\Contracts\Filters\ListSalesFilter;
use Src\Sales\Domain\UseCases\Contracts\ListSales as ListSalesInterface;
use Src\Sales\Infrastructure\Bling\Repository as ErpRepository;
use Src\Sales\Infrastructure\Eloquent\Repository;

class ListSales implements ListSalesInterface
{
    private ListSalesPresenter $presenter;
    private ErpRepository $repository;

    public function __construct(ListSalesPresenter $presenter, ErpRepository $repository)
    {
        $this->presenter = $presenter;
        $this->repository = $repository;
    }

    public function list(ListSalesFilter $options): array
    {
        $sales = Repository::listPaginate(
            page: $options->getPage(),
            beginDate: $options->getBeginDate(),
            endDate: $options->getEndDate(),
        );
        $totalValue = Repository::getTotalValueSum();
        $totalProfit = Repository::getTotalProfitSum();
        $saleOrders = $this->presenter->listSaleOrder($sales->items());

        return [
            'saleOrders' => $saleOrders ?? [],
            'meta' => [
                'value' => $totalValue,
                'profit' => $totalProfit,
            ],
            'paginator' => $sales,
        ];
    }
}
