<?php

namespace Src\Sales\Application\UseCases;

use Src\Sales\Application\Services\Service;
use Src\Sales\Domain\Contracts\UseCases\ListSales as ListSalesInterface;
use Src\Sales\Domain\Models\SaleOrder;
use Src\Sales\Infrastructure\Bling\Repository;

class ListSales implements ListSalesInterface
{
    private Service $service;
    private Repository $repository;

    public function __construct(Service $service, Repository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }

    public function list(int $page = 1): array
    {
        $sales = SaleOrder::valid()
            ->orderBy('selled_at', 'desc')
            ->orderBy('sale_order_id', 'desc')
            ->paginate(page: $page, perPage: 40);

        return $this->service->listSaleOrder($sales);
    }
}
