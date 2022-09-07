<?php

namespace Src\Prices\Infrastructure\Laravel\Services\Calculator;

use Money\Money;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\CommissionRepository;
use Src\Marketplaces\Infrastructure\Laravel\Repositories\FreightRepository;
use Src\Math\MoneyTransformer;
use Src\Prices\Infrastructure\Laravel\Models\Price;

abstract class BaseCalculator
{
    public function __construct(
        private readonly CommissionRepository $commissionRepository,
        private readonly FreightRepository $freightRepository
    )
    {}

    protected function getCommission(Price $price, float $desiredPrice): float
    {
        return $this->commissionRepository->get(
            $price->getMarketplace(),
            $price->getProduct(),
            $desiredPrice
        );
    }

    protected function getFreight(Price $price, float $desiredPrice): float
    {
        return $this->freightRepository->get(
            $price->getMarketplace(),
            $price->getProduct()->getCubicWeight(),
            $desiredPrice
        );
    }
}
