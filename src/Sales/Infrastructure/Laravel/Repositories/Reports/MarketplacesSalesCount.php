<?php

namespace Src\Sales\Infrastructure\Laravel\Repositories\Reports;

use Carbon\Carbon;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Sales\Domain\DataTransfer\ListSalesFilter;
use Src\Sales\Domain\DataTransfer\Reports\MarketplaceSalesReport;
use Src\Sales\Domain\Models\SaleOrder;

class MarketplacesSalesCount
{
    public function __construct(
        private readonly MarketplaceRepository $marketplaceRepository
    )
    {
    }

    /*
     * @return MarketplaceSalesReport[]
     */
    public function report(ListSalesFilter $options): array
    {
        $marketplaces = $this->marketplaceRepository->list($options->getUserId());
        $marketplaces = collect($marketplaces);

        return $marketplaces->map(
            function (Marketplace $marketplace) use ($options) {
                $query = SaleOrder::valid()
                    ->inDateInterval(
                        $options->getBeginDate(),
                        $options->getEndDate()
                    )
                    ->defaultOrder();

                return new MarketplaceSalesReport(
                    $marketplace,
                    $query->where('store_id', $marketplace->getErpId())
                        ->count()
                );
            })->all();
    }
}
