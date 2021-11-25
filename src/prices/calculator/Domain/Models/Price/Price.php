<?php

namespace Src\Prices\Calculator\Domain\Models\Price;

use Src\Math\Percentage;
use Src\Prices\Calculator\Domain\Services\Contracts\CalculatorOptions;
use Src\Prices\Calculator\Domain\Transformer\PercentageTransformer;
use Money\Money;
use Src\Prices\Calculator\Domain\Transformer\MoneyTransformer;
use Src\Prices\Calculator\Domain\Models\Product\Contracts\ProductData;
use Src\Prices\Calculator\Domain\Models\Price\Commission\Commission;
use Src\Prices\Calculator\Domain\Models\Price\Commission\Factories\Factory as CommissionFactory;
use Src\Prices\Calculator\Domain\Models\Price\Costs\CostPrice;
use Src\Prices\Calculator\Domain\Models\Price\Freight\BaseFreight;
use Src\Prices\Calculator\Domain\Models\Price\Freight\Factories\Factory;
use Src\Products\Domain\Models\Store\Store;

class Price implements Contracts\Price
{
    private float $commissionRate;
    private BaseFreight $freight;
    private Commission $commission;
    private CostPrice $costPrice;
    private Money $costs;
    private Money $profit;
    private Money $value;
    private ProductData $product;
    private Store $store;

    public function __construct(ProductData $product, Store $store, float $value, float $commission, array $options = [])
    {
        $this->setParameters($product, $store, $value, $commission, $options);

        $this->calculate();
    }

    public function get(): Money
    {
        return $this->value;
    }

    public function getCommission(): Commission
    {
        return $this->commission;
    }

    public function getCostPrice(): CostPrice
    {
        return $this->costPrice;
    }

    public function getCosts(): Money
    {
        return $this->costs;
    }

    public function getDifferenceICMS(): Money
    {
        return $this->costPrice->differenceICMS();
    }

    public function getFreight(): BaseFreight
    {
        return $this->freight;
    }

    public function getMargin(): float
    {
        $margin = 0.0;

        if (!$this->value->isZero()) {
            $margin = $this->profit->ratioOf($this->value);
        }

        return round($margin * 100, 2);
    }

    public function getProductData(): ProductData
    {
        return $this->product;
    }

    public function getProfit(): Money
    {
        return $this->profit;
    }

    public function getPurchasePrice(): Money
    {
        return $this->costPrice->purchasePrice();
    }

    public function getSimplesNacional(): Money
    {
        return $this->value->multiply($this->taxSimplesNacional());
    }

    public function getStore(): Store
    {
        return $this->store;
    }

    public function __toString(): string
    {
        return MoneyTransformer::toString($this->value);
    }

    private function calculate(): void
    {
        $this->costs = $this->getCostPrice()->get()
            ->add($this->getCommission()->get())
            ->add($this->getSimplesNacional())
            ->add($this->getFreight()->get());

        $this->profit = $this->value->subtract($this->costs);
    }

    private function setParameters(
        ProductData $product,
        Store $store,
        float $value,
        float $commission,
        array $options = []
    ): void {
        $this->product = $product;
        $this->store = $store;
        $this->commissionRate = $commission;

        $this->setCostPrice($product);
        $this->setValue(
            $value,
            $options[CalculatorOptions::DISCOUNT_RATE] ?? Percentage::fromPercentage(0)
        );
        $this->setCommission($store->getSlug());

        $ignoreFreight = $options[CalculatorOptions::IGNORE_FREIGHT] ?? false;
        $this->setFreight($product, $store->getSlug(), $ignoreFreight);
    }

    private function setCommission(string $store): void
    {
        $this->commission = CommissionFactory::make($store, $this->value, $this->commissionRate);
    }

    private function setCostPrice(ProductData $product): void
    {
        // To Do: verificar questão dos custos adicionais. Talvez seja interessante criar uma factory que recebe o objeto custos e cria um CostPrice
        $this->costPrice = new CostPrice(
            MoneyTransformer::toMoney($product->getCosts()->purchasePrice()),
            MoneyTransformer::toMoney($product->getCosts()->additionalCosts()),
            PercentageTransformer::toPercentage($product->getCosts()->taxICMS())
        );
    }

    private function setFreight(ProductData $product, string $store, bool $ignoreFreight): void
    {
        $this->freight = Factory::make($store, $product->getDimensions(), $this->value, $ignoreFreight);
    }

    private function setValue(float $value, $discount)
    {
        $discountRate = $discount->get();

        $this->value = MoneyTransformer::toMoney($value)->multiply(1 - $discountRate);
    }

    private function taxSimplesNacional(): float
    {
        return PercentageTransformer::toPercentage(config('taxes.simples_nacional'));
    }
}
