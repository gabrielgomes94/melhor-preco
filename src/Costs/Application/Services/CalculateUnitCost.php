<?php

namespace Src\Costs\Application\Services;

use Src\Costs\Domain\Repositories\NFeRepository;
use Src\Costs\Infrastructure\NFe\XmlReader;
use Src\Math\Money;
use Src\Prices\Calculator\Domain\Transformer\MoneyTransformer;

class CalculateUnitCost
{
    private NFeRepository $nfeReader;

    public function __construct(NFeRepository $nfeReader)
    {
        $this->nfeReader = $nfeReader;
    }

    public function calculate(array $item): float
    {
        $product = $this->nfeReader->getProductData($item);

        $price = $this->getPrice($product);
        $freightValue = $this->getFreightValue($product);
        $insuranceValue = $this->getInsuranceValue($product);
        $discount = $this->getDiscount($product);
        $quantity = $this->getQuantity($product);
        $taxes = $this->getTaxes($item);
        $ipiValue = $this->getIpiValue($taxes['ipi']['value'], $quantity);

        $unitCost = $price->add($freightValue)
            ->add($insuranceValue)
            ->add($ipiValue)
            ->subtract($discount);

        return MoneyTransformer::toFloat($unitCost);
    }

    private function getMoney(float $value): \Money\Money
    {
        return Money::fromFloat($value)->get();
    }

    private function getPrice(array $product): \Money\Money
    {
        return $this->getMoney(
            $this->nfeReader->getPrice($product)
        );
    }

    private function getFreightValue(array $product): \Money\Money
    {
        return $this->getMoney(
            $this->nfeReader->getFreightValue($product)
        );
    }

    private function getInsuranceValue(array $product): \Money\Money
    {
        return $this->getMoney(
            $this->nfeReader->getInsuranceValue($product)
        );
    }

    private function getDiscount(array $product): \Money\Money
    {
        return $this->getMoney(
            $this->nfeReader->getDiscount($product)
        );
    }

    private function getQuantity(array $product): float
    {
        return $this->nfeReader->getQuantity($product);
    }

    private function getTaxes(array $item): array
    {
        return $this->nfeReader->getTaxes($item);
    }

    private function getIpiValue(float $value, float $quantity): \Money\Money
    {
        return ($this->getMoney($value))->divide($quantity);
    }
}
