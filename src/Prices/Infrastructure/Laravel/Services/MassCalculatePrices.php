<?php

namespace Src\Prices\Infrastructure\Laravel\Services;

use Error;
use Illuminate\Support\Collection;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Math\Percentage;
use Src\Prices\Domain\DataTransfer\ListPricesCalculated;
use Src\Prices\Domain\DataTransfer\MassCalculationTypes;
use Src\Prices\Domain\DataTransfer\MassCalculatorForm;
use Src\Prices\Domain\DataTransfer\PriceCalculatedFromProduct;
use Src\Prices\Domain\Models\Calculator\CalculatedPrice;
use Src\Prices\Domain\Services\MassCalculatePrices as MassCalculatePricesInterface;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Prices\Infrastructure\Laravel\Services\Calculator\CalculateFromMarkup;
use Src\Prices\Infrastructure\Laravel\Services\Calculator\CalculateWithAddition;
use Src\Prices\Infrastructure\Laravel\Services\Calculator\CalculateWithDiscount;

class MassCalculatePrices implements MassCalculatePricesInterface
{
    public function __construct(
        private readonly CalculateFromMarkup $markup,
        private readonly CalculateWithAddition $calculateWithAddition,
        private readonly CalculateWithDiscount $calculateWithDiscount
    )
    {}

    public function calculate(Marketplace $marketplace, MassCalculatorForm $form): ListPricesCalculated
    {
        $prices = $marketplace->getPrices();
        $prices = $this->filterProducts($prices, $form);

        foreach ($prices as $price) {
            $calculatedPrices[] = PriceCalculatedFromProduct::fromPrice(
                $price,
                $this->getCalculatedPrice($price, $form)
            );
        }

        return new ListPricesCalculated($marketplace, $calculatedPrices ?? []);
    }

    private function filterProducts(Collection $prices, MassCalculatorForm $form): Collection
    {
        if (!$category = $form->category) {
            return $prices;
        }

        return $prices->filter(function(Price $price) use ($category) {
            $product = $price->getProduct();
            $product->getCategoryId() == $category;
        });
    }

    private function getCalculatedPrice(Price $price, MassCalculatorForm $form): CalculatedPrice
    {
        if ($form->calculationType === MassCalculationTypes::Markup) {
            return $this->markup->get($price, $form->value);
        }

        if ($form->calculationType === MassCalculationTypes::Addition) {
            return $this->calculateWithAddition->get($price, Percentage::fromPercentage($form->value));
        }

        if ($form->calculationType === MassCalculationTypes::Discount) {
            return $this->calculateWithDiscount->get($price, Percentage::fromPercentage($form->value));
        }

        throw new Error('Invalid calculation type');
    }
}
