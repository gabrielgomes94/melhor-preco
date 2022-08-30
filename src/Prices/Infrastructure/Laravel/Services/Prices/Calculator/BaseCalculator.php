<?php

namespace Src\Prices\Infrastructure\Laravel\Services\Prices\Calculator;

use Money\Money;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\CommissionRepository;
use Src\Marketplaces\Infrastructure\Laravel\Repositories\FreightRepository;
use Src\Math\MoneyTransformer;
use Src\Prices\Infrastructure\Laravel\Models\Price;

class BaseCalculator
{
    public function __construct(
        private CommissionRepository $commissionRepository,
        private FreightRepository $freightRepository
    )
    {}

    protected function getCommission(Price $price, Money $desiredPrice): Money
    {
        $commission = $this->commissionRepository->get(
            $price->getMarketplace(),
            $price->getProduct(),
            MoneyTransformer::toFloat($desiredPrice)
        );

        return MoneyTransformer::toMoney($commission);
    }

    protected function getFreight(Price $price, Money $desiredPrice): float
    {
        return $this->freightRepository->get(
            $price->getMarketplace(),
            $price->getProduct()->getCubicWeight(),
            MoneyTransformer::toFloat($desiredPrice)
        );
    }
}
