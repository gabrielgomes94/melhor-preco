<?php

namespace Src\Prices\Infrastructure\Laravel\Services;

use Money\Money;
use Src\Marketplaces\Domain\Exceptions\MarketplaceNotFoundException;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Marketplaces\Infrastructure\Laravel\Repositories\CommissionRepository;
use Src\Marketplaces\Infrastructure\Laravel\Repositories\FreightRepository;
use Src\Math\MoneyTransformer;
use Src\Prices\Domain\DataTransfer\CalculatorForm;
use Src\Prices\Domain\DataTransfer\PriceCalculatedFromProduct;
use Src\Prices\Domain\Exceptions\ProductHasNoPriceInMarketplace;
use Src\Prices\Domain\Models\Calculator\CalculatedPrice;
use Src\Prices\Domain\Services\CalculatePriceFromProduct as CalculatePriceFromProductInterface;
use Src\Products\Domain\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Models\Product;
use Src\Products\Domain\Repositories\ProductRepository;

class CalculatePriceFromProduct implements CalculatePriceFromProductInterface
{
    public function __construct(
        private readonly MarketplaceRepository $marketplaceRepository,
        private readonly ProductRepository $productRepository,
        private readonly FreightRepository $freightRepository,
        private readonly CommissionRepository $commissionRepository
    ) {}

    /**
     * @throws MarketplaceNotFoundException
     * @throws ProductNotFoundException
     * @throws ProductHasNoPriceInMarketplace
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
            $price = $product->getPrice($marketplace)?->getValue();

            if (is_null($price)) {
                throw new ProductHasNoPriceInMarketplace($product, $marketplace);
            }

            $freight = $this->getFreight($marketplace, $product, $price);

            $calculatorForm = new CalculatorForm(
                desiredPrice: $price,
                freight: $freight
            );

            return $this->getPriceCalculatedFromProduct($marketplace, $product, $calculatorForm);
        }

        return $this->getPriceCalculatedFromProduct($marketplace, $product, $calculatorForm);
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

    private function getFreight(Marketplace $marketplace, Product $product, float $value): float
    {
        return $this->freightRepository->get(
            $marketplace,
            $product->getCubicWeight(),
            $value
        );
    }

    private function getPriceCalculatedFromProduct(
        Marketplace $marketplace,
        Product $product,
        CalculatorForm $calculatorForm
    ): PriceCalculatedFromProduct
    {
        $commission = $this->getCommission($calculatorForm, $marketplace, $product);

        return new PriceCalculatedFromProduct(
            $product,
            $marketplace,
            CalculatedPrice::fromProduct(
                $product,
                $commission,
                $calculatorForm
            )
        );
    }

    public function getCommission(CalculatorForm $calculatorForm, Marketplace $marketplace, Product $product): Money
    {
        if (!$calculatorForm->commission) {
            $commission = $this->commissionRepository->get(
                $marketplace,
                $product,
                MoneyTransformer::toFloat($calculatorForm->getPrice())
            );

            return MoneyTransformer::toMoney($commission);
        }

        return $calculatorForm->getPrice()->multiply(
            (string) $calculatorForm->commission->getFraction()
        );
    }
}
