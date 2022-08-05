<?php

namespace Src\Prices\Infrastructure\Laravel\Services\Prices;

use Illuminate\Support\Collection;
use InvalidArgumentException;
use Src\Marketplaces\Domain\Exceptions\MarketplaceNotFoundException;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Prices\Domain\DataTransfer\ListPricesCalculated;
use Src\Prices\Domain\DataTransfer\MassCalculatorForm;
use Src\Prices\Domain\DataTransfer\PriceCalculatedFromProduct;
use Src\Prices\Infrastructure\Laravel\Models\Price;

class MassCalculatePrices
{
    public function __construct(
        private MarketplaceRepository $marketplaceRepository,
        private CalculatePriceFromMarkup $markup
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
            $product = $price->getProduct();

            try {
                $calculatedPrices[] = new PriceCalculatedFromProduct(
                    $product,
                    $marketplace,
                    $this->markup->get($product, $marketplace, $form->markup)
                );
            } catch (InvalidArgumentException $exception) {
                continue;
            }
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
