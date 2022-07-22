<?php

namespace Src\Prices\Infrastructure\Laravel\Services\Prices;

use Src\Marketplaces\Domain\Exceptions\MarketplaceNotFoundException;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Math\Percentage;
use Src\Prices\Domain\DataTransfer\CalculatorForm;
use Src\Prices\Domain\DataTransfer\CalculatorOptions;
use Src\Prices\Domain\DataTransfer\PriceCalculatedFromProduct;
use Src\Prices\Domain\Models\Calculator\Contracts\CalculatedPrice;
use Src\Prices\Domain\Services\CalculatePrice;
use Src\Products\Domain\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Models\Product\Product;
use Src\Products\Domain\Repositories\ProductRepository;

class CalculatePriceFromProduct
{
    public function __construct(
        private MarketplaceRepository $marketplaceRepository,
        private ProductRepository $productRepository,
        private CalculatePrice $calculatePrice,
    ) {}

    /**
     * @throws MarketplaceNotFoundException
     * @throws ProductNotFoundException
     */
    public function calculate(
        string $productSku,
        string $marketplaceSlug,
        string $userId,
        ?CalculatorForm $calculatorForm
    ): PriceCalculatedFromProduct
    {
        $marketplace = $this->getMarketplace($marketplaceSlug, $userId);
        $product = $this->getProduct($productSku, $userId);

        if (!$calculatorForm) {
            $calculatedPrice = $this->calculatePrice->calculate(
                $product,
                $marketplace,
                $product->getPrice($marketplace)->getValue(),
                new CalculatorOptions()
            );

            return new PriceCalculatedFromProduct(
                $product,
                $marketplace,
                $calculatedPrice
            );
        }

        $calculatedPrice = $this->calculatePrice->calculate(
            $product,
            $marketplace,
            $calculatorForm->desiredPrice,
            new CalculatorOptions(
                $calculatorForm->discount,
                $calculatorForm->commission,
            )
        );

        return new PriceCalculatedFromProduct(
            $product,
            $marketplace,
            $calculatedPrice
        );
    }

    /**
     * @throws MarketplaceNotFoundException
     */
    public function getMarketplace(string $marketplaceSlug, string $userId): Marketplace
    {
        $marketplace = $this->marketplaceRepository->getBySlug($marketplaceSlug, $userId);

        if (!$marketplace) {
            throw new MarketplaceNotFoundException($marketplaceSlug);
        }

        return $marketplace;
    }

    /**
     * @throws ProductNotFoundException
     */
    public function getProduct(string $productSku, string $userId): Product
    {
        $product = $this->productRepository->get($productSku, $userId);

        if (!$product) {
            throw new ProductNotFoundException($productSku, $userId);
        }

        return $product;
    }
}
