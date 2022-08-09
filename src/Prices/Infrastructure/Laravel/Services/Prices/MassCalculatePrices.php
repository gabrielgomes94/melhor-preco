<?php

namespace Src\Prices\Infrastructure\Laravel\Services\Prices;

use Illuminate\Support\Collection;
use Src\Marketplaces\Domain\Exceptions\MarketplaceNotFoundException;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Math\Percentage;
use Src\Prices\Domain\DataTransfer\ListPricesCalculated;
use Src\Prices\Domain\DataTransfer\MassCalculatorForm;
use Src\Prices\Domain\DataTransfer\PriceCalculatedFromProduct;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Prices\Infrastructure\Laravel\Services\Prices\Calculator\CalculateFromMarkup;
use Src\Prices\Infrastructure\Laravel\Services\Prices\Calculator\CalculateWithAddition;
use Src\Prices\Infrastructure\Laravel\Services\Prices\Calculator\CalculateWithDiscount;

class MassCalculatePrices
{
    public function __construct(
        private MarketplaceRepository $marketplaceRepository,
        private CalculateFromMarkup   $markup,
        private CalculateWithAddition $calculateWithAddition,
        private CalculateWithDiscount $calculateWithDiscount
    )
    {}

    public function calculate(string $marketplaceSlug, string $userId, MassCalculatorForm $form)
    {
        $marketplace = $this->marketplaceRepository->getBySlug($marketplaceSlug, $userId);

        if (!$marketplace) {
            throw new MarketplaceNotFoundException($marketplaceSlug);
        }

        $prices = $marketplace->getPrices();
        $prices = $this->filterProducts($prices, $form);

        foreach ($prices as $price) {
            if ($form->calculationType === 'markup') {
                $calculatedPrices[] = PriceCalculatedFromProduct::fromPrice(
                    $price,
                    $this->markup->get($price, $form->value)
                );

                continue;
            }

            if ($form->calculationType === 'addition') {
                $calculatedPrices[] = PriceCalculatedFromProduct::fromPrice(
                    $price,
                    $this->calculateWithAddition->get(
                        $price,
                        Percentage::fromPercentage($form->value)
                    )
                );

                continue;
            }

            $calculatedPrices[] = PriceCalculatedFromProduct::fromPrice(
                $price,
                $this->calculateWithDiscount->get(
                    $price,
                    Percentage::fromPercentage($form->value)
                )
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
}
