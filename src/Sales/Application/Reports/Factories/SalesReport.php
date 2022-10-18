<?php

namespace Src\Sales\Application\Reports\Factories;

use Carbon\Carbon;
use Src\Sales\Application\Reports\Data\Sales\SalesList;
use Src\Sales\Domain\DataTransfer\SalesFilter;
use Src\Sales\Domain\Models\Collections\SaleOrdersCollection;
use Src\Sales\Domain\Repositories\SaleOrderRepository;

class SalesReport
{
    public function __construct(
        private readonly SaleOrderRepository $saleOrderRepository,
        private readonly MarketplaceSalesReport $marketplaceSalesReport
    )
    {}

    public function report(SalesFilter $filter): SalesList
    {
        $sales = $this->saleOrderRepository->listPaginate($filter);
        $marketplaceSales = $this->marketplaceSalesReport->report(
            $filter->getUserId(),
            $filter->getBeginDate(),
            $filter->getEndDate()
        );

        return new SalesList(
            new SaleOrdersCollection($sales->all()),
            $marketplaceSales,
            $sales
        );
    }
}
