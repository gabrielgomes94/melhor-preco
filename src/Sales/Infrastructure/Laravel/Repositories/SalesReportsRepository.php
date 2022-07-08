<?php

namespace Src\Sales\Infrastructure\Laravel\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Sales\Domain\DataTransfer\ListSalesFilter;
use Src\Sales\Domain\DataTransfer\Reports\ListMetadata;
use Src\Sales\Domain\DataTransfer\Reports\ListReport;
use Src\Sales\Domain\DataTransfer\Reports\MarketplaceSalesReport;
use Src\Sales\Domain\Models\SaleOrder;

class SalesReportsRepository
{
    public function __construct(
        private readonly MarketplaceRepository $marketplaceRepository
    )
    {
    }

    public function list(ListSalesFilter $options): ListReport
    {
        $beginDate = $options->getBeginDate();
        $endDate = $options->getEndDate();

        $salesQuery = $this->getQuery($beginDate, $endDate);
        $metadata = $this->getMetadata($salesQuery, $options);

        $salesQuery = $this->getQuery($beginDate, $endDate);
        $sales = $salesQuery->paginate(
            perPage: $options->getPerPage(),
            page: $options->getPage()
        );

        return new ListReport(
            $metadata,
            $options,
            $sales->items(),
            $sales->total()
        );
    }

    private function getMetadata(Builder $salesQuery, ListSalesFilter $options): ListMetadata
    {
        $salesCollection = $salesQuery->get();
        $salesCount = $salesCollection->count();
        $productsCount = $salesCollection->sum(
            function(SaleOrder $saleOrder) {
                return $saleOrder->items->count();
            });

        $marketplacesCount = $this->getMarketplacesCount($options, $salesQuery);
        $totalValue = $salesCollection->sum('total_value');
        $totalProfit = $salesCollection->sum('total_profit');

        return new ListMetadata(
            $salesCount,
            $productsCount,
            $marketplacesCount,
            $totalValue,
            $totalProfit
        );
    }

    /**
     * @todo: fix marketplace query
     */
    public function getMarketplacesCount(ListSalesFilter $options, Builder $salesQuery): array
    {
        $marketplaces = $this->marketplaceRepository->list($options->getUserId());
        $marketplaces = collect($marketplaces);

        return $marketplaces->map(
            function (Marketplace $marketplace) use ($salesQuery) {
                return new MarketplaceSalesReport(
                    $marketplace,
                    $salesQuery->where('store_id', $marketplace->getErpId())
                        ->count()
                );
            })->all();
    }

    private function getQuery(Carbon $beginDate, Carbon $endDate): Builder
    {
        return SaleOrder::valid()
            ->inDateInterval($beginDate, $endDate)
            ->defaultOrder();
    }
}
