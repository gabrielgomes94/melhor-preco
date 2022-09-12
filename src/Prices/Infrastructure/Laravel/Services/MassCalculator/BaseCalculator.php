<?php

namespace Src\Prices\Infrastructure\Laravel\Services\MassCalculator;

use Money\Money;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\CommissionRepository;
use Src\Marketplaces\Infrastructure\Laravel\Repositories\FreightRepository;
use Src\Math\MoneyTransformer;
use Src\Math\Percentage;
use Src\Prices\Domain\DataTransfer\CalculatorForm;
use Src\Prices\Domain\Models\Calculator\CalculatedPrice;
use Src\Prices\Infrastructure\Laravel\Models\Price;

abstract class BaseCalculator
{
    public function __construct(
        private readonly CommissionRepository $commissionRepository,
        private readonly FreightRepository $freightRepository
    )
    {}

    protected function calculate(Price $price, float $desiredPrice): CalculatedPrice
    {
        $commission = $this->getCommission($price, $desiredPrice);
        $freight = $this->getFreight($price, $desiredPrice);

        return CalculatedPrice::fromProduct(
            $price->getProduct(),
            $commission,
            new CalculatorForm(
                desiredPrice: $desiredPrice,
                freight: $freight
            )
        );
    }

    private function getCommission(Price $price, float $desiredPrice): float
    {
        return $this->commissionRepository->get(
            $price->getMarketplace(),
            $price->getProduct(),
            $desiredPrice
        );
    }

    private function getFreight(Price $price, float $desiredPrice): float
    {
        return $this->freightRepository->get(
            $price->getMarketplace(),
            $price->getProduct()->getCubicWeight(),
            $desiredPrice
        );
    }
}
