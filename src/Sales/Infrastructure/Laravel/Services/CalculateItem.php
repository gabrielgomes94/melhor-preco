<?php

namespace Src\Sales\Infrastructure\Laravel\Services;

use Src\Prices\Domain\Models\Calculator\Contracts\Price;
use Src\Marketplaces\Domain\Exceptions\MarketplaceNotFoundException;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Calculator\Domain\Services\Contracts\CalculateItem as CalculateItemInterface;
use Src\Prices\Domain\DataTransfer\CalculatorOptions;
use Src\Prices\Domain\Services\CalculatePrice;
use Src\Sales\Infrastructure\Laravel\Models\Item;

class CalculateItem implements CalculateItemInterface
{
    public function __construct(
        private CalculatePrice $calculatePrice,
        private MarketplaceRepository $marketplaceRepository,
    ) {
    }

    public function calculate(Item $item): Price
    {
        $marketplaceErpId = $item->saleOrder->getIdentifiers()->storeId() ?? '';
        $product = $item->getProduct();
        $userId = $product->getUser()->getId();

        $marketplace = $this->marketplaceRepository->getByErpId($marketplaceErpId, $userId);

        if (!$marketplace) {
            throw new MarketplaceNotFoundException($marketplaceErpId);
        }

        return $this->calculatePrice->calculate(
            product: $product,
            marketplace: $marketplace,
            value: $item->getTotalValue(),
            options: new CalculatorOptions()
        );
    }
}
