<?php

namespace Src\Calculator\Domain\Models\Price;

use Src\Marketplaces\Domain\Models\Contracts\Marketplace;
use Src\Math\Percentage;
use Src\Calculator\Domain\Services\Contracts\CalculatorOptions;
use Src\Calculator\Domain\Transformer\PercentageTransformer;
use Money\Money;
use Src\Math\MoneyTransformer;
use Src\Calculator\Domain\Models\Product\Contracts\ProductData;
use Src\Calculator\Domain\Models\Price\Commission\Commission;
use Src\Calculator\Domain\Models\Price\Commission\Factories\Factory as CommissionFactory;
use Src\Calculator\Domain\Models\Price\Costs\CostPrice;
use Src\Calculator\Domain\Models\Price\Freight\BaseFreight;
use Src\Calculator\Domain\Models\Price\Freight\Factories\Factory;

// @todo: instanciar essa classe através de um factory e delegar as lógicas de definição de atributos para esse factory
class Price implements \Src\Calculator\Domain\Models\Price\Contracts\Price
{
    private float $commissionRate;
    private BaseFreight $freight;
    private Commission $commission;
    private CostPrice $costPrice;
    private Money $costs;
    private Money $profit;
    private Money $value;
    private ProductData $product;
    private Marketplace $marketplace;

    public function __construct(
        ProductData $product,
        Marketplace $marketplace,
        float $value,
        float $commission,
        array $options = []
    ) {
        $this->setParameters($product, $marketplace, $value, $commission, $options);

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
        Marketplace $marketplace,
        float $value,
        float $commission,
        array $options = []
    ): void {
        $this->product = $product;
//        $this->store = $marketplace;

        $this->setCostPrice($product);
        $this->setValue(
            $value,
            $options[CalculatorOptions::DISCOUNT_RATE] ?? Percentage::fromPercentage(0)
        );
        $this->setCommission($marketplace->getSlug(), $commission);

        $ignoreFreight = !$options[CalculatorOptions::FREE_FREIGHT];
        $this->setFreight($product, $marketplace->getSlug(), $ignoreFreight);
    }

    private function setCommission(string $store, float $commission): void
    {
        $this->commissionRate = $commission;
//        dd($this->commissionRate, CommissionFactory::make($store, $this->value, $this->commissionRate));
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
