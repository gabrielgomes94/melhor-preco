<?php

namespace Src\Calculator\Application\Services;

use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Marketplaces\Domain\UseCases\Contracts\GetCommission;
use Src\Math\Percentage;
use Src\Calculator\Domain\Models\Price\Price;
use Src\Calculator\Domain\Models\Product\ProductData;
use Src\Calculator\Domain\Services\Contracts\CalculateItem as CalculateItemInterface;
use Src\Sales\Domain\Models\Item;

class CalculateItem implements CalculateItemInterface
{
    private CalculatePrice $calculatePrice;
    private MarketplaceRepository $marketplaceRepository;
    private GetCommission $getCommission;

    public function __construct(
        CalculatePrice $calculatePrice,
        MarketplaceRepository $marketplaceRepository,
        GetCommission $getCommission
    ) {
        $this->calculatePrice = $calculatePrice;
        $this->marketplaceRepository = $marketplaceRepository;
        $this->getCommission = $getCommission;
    }

    public function calculate(Item $item): Price
    {
        $marketplace = $this->marketplaceRepository->getByErpId($item->saleOrder->getIdentifiers()->storeId());

        return $this->calculatePrice->calculate(
            productData: ProductData::fromModel($item->product),
            marketplace: $marketplace,
            value: $item->getTotalValue(),
            commission: Percentage::fromPercentage($this->getCommission->get(
                $marketplace->getErpId(),
                $item->product->getSku()
            ))
        );
    }
}
