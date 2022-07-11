<?php

namespace Src\Calculator\Application\Services;

use Src\Calculator\Domain\Models\Price\Contracts\Price;
use Src\Marketplaces\Domain\Exceptions\MarketplaceNotFoundException;
use Src\Marketplaces\Domain\Repositories\CommissionRepository;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Math\Percentage;
use Src\Calculator\Domain\Models\Product\ProductData;
use Src\Calculator\Domain\Services\Contracts\CalculateItem as CalculateItemInterface;
use Src\Sales\Infrastructure\Laravel\Models\Item;

/**
 * @todo: talvez valha a pena contextualizar esse serviço em Sales
 */
class CalculateItem implements CalculateItemInterface
{
    public function __construct(
        private CalculatePrice $calculatePrice,
        private CommissionRepository $commissionRepository,
        private MarketplaceRepository $marketplaceRepository,
    ) {
    }

    /**
     * @todo: fix the user contextualization later
     */
    public function calculate(Item $item): Price
    {
        $marketplaceErpId = $item->saleOrder->getIdentifiers()->storeId() ?? '';

        $userId = auth()->user()->getAuthIdentifier();
        $marketplace = $this->marketplaceRepository->getByErpId($marketplaceErpId, $userId);

        if (!$marketplace) {
            throw new MarketplaceNotFoundException($marketplaceErpId);
        }

        $commission = $this->commissionRepository->get(
            $marketplace,
            $item->product->getCategoryId()
        );

        return $this->calculatePrice->calculate(
            productData: ProductData::fromModel($item->getProduct()),
            marketplace: $marketplace,
            value: $item->getTotalValue(),
            commission: $commission
        );
    }
}
