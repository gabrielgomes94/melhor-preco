<?php

namespace Src\Prices\Domain\Services;

use Money\Money;
use Src\Prices\Domain\Models\Calculator\Contracts\CalculatedPrice as CalculatedPriceInterface;
use Src\Prices\Domain\Models\Calculator\CostPrice;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\CommissionRepository;
use Src\Marketplaces\Infrastructure\Laravel\Repositories\FreightRepository;
use Src\Math\MoneyTransformer;
use Src\Math\Percentage;
use Src\Prices\Domain\DataTransfer\CalculatorOptions;
use Src\Prices\Domain\Models\Calculator\CalculatedPrice;
use Src\Products\Domain\Models\Product\Product;

class CalculatePrice
{
    public function __construct(
        private CommissionRepository $commissionRepository,
        private FreightRepository $freightRepository
    ) {
    }

    public function calculate(
        Product $product,
        Marketplace $marketplace,
        float $value,
        CalculatorOptions $options
    ): CalculatedPriceInterface {
        return new CalculatedPrice(
            $this->getCostPrice($product),
            $this->getValue($value, $options),
            $this->getCommission($marketplace, $product, $options),
            $this->getFreight($marketplace, $product, $value)
        );
    }

    private function getCommission(
        Marketplace $marketplace,
        Product $product,
        CalculatorOptions $options
    ): Percentage
    {
        if ($options->overridenCommission) {
            return $options->overridenCommission;
        }

        return $this->commissionRepository->get(
            $marketplace,
            $product->getCategoryId()
        );
    }

    private function getCostPrice(Product $product): CostPrice
    {
        $costs = $product->getCosts();
        $user = $product->getUser();

        return new CostPrice(
            MoneyTransformer::toMoney($costs->purchasePrice()),
            MoneyTransformer::toMoney($costs->additionalCosts()),
            Percentage::fromPercentage($costs->taxICMS()),
            Percentage::fromPercentage($user->getIcmsInnerStateTaxRate()),
            Percentage::fromPercentage($user->getSimplesNacionalTaxRate())
        );
    }

    private function getValue(float $value, CalculatorOptions $options): Money
    {
        $value = MoneyTransformer::toMoney($value);

        return $value->multiply(1 - $options->discountRate->getFraction());
    }

    private function getFreight(Marketplace $marketplace, Product $product, float $value): Money
    {
        $freight = $this->freightRepository->get(
            $marketplace,
            $product->getDimensions()->cubicWeight(),
            $value
        );

        return MoneyTransformer::toMoney($freight);
    }
}
