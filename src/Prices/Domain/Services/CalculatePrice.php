<?php

namespace Src\Prices\Domain\Services;

use Money\Money;
use Src\Prices\Domain\DataTransfer\CalculatorForm;
use Src\Prices\Domain\Models\Calculator\Contracts\CalculatedPrice as CalculatedPriceInterface;
use Src\Prices\Domain\Models\Calculator\CostPrice;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\CommissionRepository;
use Src\Math\MoneyTransformer;
use Src\Prices\Domain\Models\Calculator\CalculatedPrice;
use Src\Products\Domain\Models\Product\Product;

class CalculatePrice
{
    public function __construct(
        private CommissionRepository $commissionRepository,
    ) {
    }

    public function calculate(
        Product $product,
        Marketplace $marketplace,
        CalculatorForm $options
    ): CalculatedPriceInterface {
        return new CalculatedPrice(
            CostPrice::fromProduct($product),
            $this->getValue($options),
            $this->getCommission($marketplace, $product, $options),
            MoneyTransformer::toMoney($options->freight),
        );
    }

    private function getCommission(
        Marketplace $marketplace,
        Product $product,
        CalculatorForm $options,
    ): Money
    {
        $commission = $options->commission ?: $this->commissionRepository->get(
            $marketplace,
            $product->getCategoryId()
        );

        $value = $this->getValue($options);
        $commissionValue = $value->multiply((string) $commission->getFraction());
        $commissionObject = $marketplace->getCommission();

        if (!$commissionObject->hasMaximumValueCap()) {
            return $commissionValue;
        }

        $maximumValueCap = MoneyTransformer::toMoney(
            $commissionObject->getMaximumValueCap()
        );

        if ($commissionValue->greaterThan($maximumValueCap)) {
            return $maximumValueCap;
        }

        return $commissionValue;
    }

    private function getValue(CalculatorForm $options): Money
    {
        $value = MoneyTransformer::toMoney($options->desiredPrice);

        return $value->multiply(
            (string) (1 - $options->discount->getFraction())
        );
    }
}
