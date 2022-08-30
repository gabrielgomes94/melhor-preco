<?php

namespace Src\Sales\Infrastructure\Laravel\Services;

use Src\Marketplaces\Infrastructure\Laravel\Repositories\CommissionRepository;
use Src\Math\MoneyTransformer;
use Src\Prices\Domain\DataTransfer\CalculatorForm;
use Src\Prices\Domain\Models\Calculator\CalculatedPrice;
use Src\Prices\Domain\Models\Calculator\Contracts\CalculatedPrice as CalculatedPriceInterface;
use Src\Marketplaces\Domain\Exceptions\MarketplaceNotFoundException;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Sales\Domain\Services\CalculateItem as CalculateItemInterface;
use Src\Sales\Infrastructure\Laravel\Models\Item;

class CalculateItem implements CalculateItemInterface
{
    public function __construct(
        private readonly MarketplaceRepository $marketplaceRepository,
        private readonly CommissionRepository $commissionRepository
    ) {
    }

    public function calculate(Item $item): CalculatedPriceInterface
    {
        $marketplaceErpId = $item->saleOrder?->getIdentifiers()?->storeId() ?? '';
        $product = $item->getProduct();
        $userId = $product->getUser()->getId();

        $marketplace = $this->marketplaceRepository->getByErpId($marketplaceErpId, $userId);

        if (!$marketplace) {
            throw new MarketplaceNotFoundException($marketplaceErpId);
        }

        $options = new CalculatorForm($item->getTotalValue());
        $commission = $this->commissionRepository->get(
            $marketplace,
            $product,
            MoneyTransformer::toFloat($options->getPrice())
        );

        return CalculatedPrice::fromProduct(
            $product,
            MoneyTransformer::toMoney($commission),
            $options
        );
    }
}
