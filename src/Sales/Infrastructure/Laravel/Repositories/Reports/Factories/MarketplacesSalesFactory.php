<?php

namespace Src\Sales\Infrastructure\Laravel\Repositories\Reports\Factories;

use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Sales\Domain\DataTransfer\SalesFilter;
use Src\Sales\Domain\DataTransfer\Reports\Marketplaces\MarketplaceSales;
use Src\Sales\Domain\DataTransfer\SaleItemsCollection;
use Src\Sales\Infrastructure\Laravel\Models\SaleOrder;

class MarketplacesSalesFactory
{
    public function __construct(
        private readonly MarketplaceRepository $marketplaceRepository
    )
    {
    }

    /*
     * @return MarketplaceSaleItems[]
     */
    public function report(SalesFilter $options): array
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

                return new MarketplaceSales(
                    $marketplace,
                    new SaleItemsCollection(
                        $query->where('store_id', $marketplace->getErpId())
                        ->get()
                        ->toArray()
                    )
                );
            })->all();
    }
}
