<?php

namespace Src\Prices\Infrastructure\Laravel\Services;

use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Infrastructure\Laravel\Repositories\CommissionRepository;
use Src\Marketplaces\Infrastructure\Laravel\Repositories\FreightRepository;
use Src\Math\MoneyCalculator;
use Src\Prices\Domain\DataTransfer\CalculatorForm;
use Src\Prices\Domain\DataTransfer\PriceCalculatedFromProduct;
use Src\Prices\Domain\Exceptions\ProductHasNoPriceInMarketplace;
use Src\Prices\Domain\Models\Calculator\CalculatedPrice;
use Src\Prices\Domain\Services\CalculatePriceFromProduct as CalculatePriceFromProductInterface;
use Src\Products\Domain\Models\Product;

class CalculatePriceFromProduct implements CalculatePriceFromProductInterface
{
    public function __construct(
        private readonly FreightRepository $freightRepository,
        private readonly CommissionRepository $commissionRepository
    ) {}

    /**
     * @throws ProductHasNoPriceInMarketplace
     */
    public function calculate(
        Marketplace $marketplace,
        Product $product,
        ?CalculatorForm $calculatorForm = null
    ): PriceCalculatedFromProduct
    {
        if (!$calculatorForm) {
            $price = $product->getPrice($marketplace)?->getValue();

            if (is_null($price)) {
                throw new ProductHasNoPriceInMarketplace($product, $marketplace);
            }

            $calculatorForm = new CalculatorForm(
                desiredPrice: $price,
                freight: $this->getFreight($marketplace, $product, $price)
            );

            return $this->getPriceCalculatedFromProduct($marketplace, $product, $calculatorForm);
        }

        return $this->getPriceCalculatedFromProduct($marketplace, $product, $calculatorForm);
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

    private function getCommission(CalculatorForm $calculatorForm, Marketplace $marketplace, Product $product): float
    {
        if (!$calculatorForm->commission) {
            return $this->commissionRepository->get(
                $marketplace,
                $product,
                $calculatorForm->getPrice()
            );
        }

        return MoneyCalculator::multiply(
            $calculatorForm->getPrice(),
            $calculatorForm->commission->getFraction()
        );
    }
}
