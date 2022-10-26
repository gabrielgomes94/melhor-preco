<?php

namespace Src\Sales\Application\Reports\Factories;

use Carbon\Carbon;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Sales\Application\Reports\Data\Marketplace\MarketplaceSales;
use Src\Sales\Application\Repositories\MarketplaceSalesRepository;

class MarketplaceSalesReport
{
    public function __construct(
        private readonly MarketplaceRepository $marketplaceRepository,
        private readonly MarketplaceSalesRepository $marketplaceSalesRepository
    ) {}

    /**
     * @return MarketplaceSales[]
     */
    public function report(
        string $userId,
        ?Carbon $beginDate = null,
        ?Carbon $endDate = null
    ): array
    {
        $marketplaces = $this->marketplaceRepository->list($userId);
        $marketplaces = collect($marketplaces);

        return $marketplaces->map(
            fn (Marketplace $marketplace) => $this->marketplaceSalesRepository->getSales(
                $marketplace,
                $beginDate,
                $endDate
            )
        )->all();
    }
}
