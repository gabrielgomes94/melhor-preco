<?php

namespace Src\Sales\Infrastructure\Laravel\Services;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Src\Math\MathPresenter;
use Src\Sales\Infrastructure\Laravel\Presenters\ListSalesPresenter;
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

        $userId = auth()->user()->getAuthIdentifier();

        return [
            'saleOrders' => $this->presenter->listSaleOrder($sales->items(), $userId),
            'meta' => $this->getMetaData($beginDate, $endDate, $userId),
            'paginator' => $this->getPaginator($sales, $options),
        ];
    }

    private function getMetaData(Carbon $beginDate, Carbon $endDate, string $userId): array
    {
        $totalValue = $this->repository->getTotalValueSum($beginDate, $endDate);
        $totalProfit = $this->repository->getTotalProfitSum($beginDate, $endDate);
        $salesCount = $this->repository->getTotalSalesCount($beginDate, $endDate);
        $productsCount = $this->repository->getTotalProductsCount($beginDate, $endDate);
        $storesCount = $this->repository->getTotalStoresCount($beginDate, $endDate, $userId);

        return [
            'beginDate' => $beginDate->format('d/m/Y'),
            'endDate' => $endDate->format('d/m/Y'),
            'salesCount' => $salesCount,
            'productsCount' => $productsCount,
            'storesCount' => $storesCount,
            'value' => MathPresenter::money($totalValue),
            'profit' => MathPresenter::money($totalProfit),
        ];
    }

    private function getPaginator($sales, ListSalesFilter $options): LengthAwarePaginator
    {
        return new LengthAwarePaginator(
            $sales->items(),
            $sales->total(),
            $options->getPerPage(),
            $options->getPage(),
            [
                'path' => $options->getUrl(),
            ]
        );
    }
}
