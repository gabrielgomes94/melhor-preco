<?php

namespace Src\Prices\Domain\Models\Calculator\Contracts;

use Money\Money;
use Src\Calculator\Domain\Models\Product\Contracts\ProductData;
use Src\Calculator\Domain\Models\Price\Commission\Commission;
use Src\Prices\Domain\Models\Calculator\CostPrice;
use Src\Calculator\Domain\Models\Price\Freight\BaseFreight;
use Src\Marketplaces\Domain\Models\Marketplace;

interface CalculatedPrice
{
    public function get(): Money;

    public function getCommission(): Commission|Money;

    public function getCostPrice(): CostPrice;

    public function getCosts(): Money;

    public function getDifferenceICMS(): Money;

    public function getFreight(): BaseFreight|Money;

    public function getMargin(): float;

//    public function getProductData(): ProductData;

    public function getProfit(): Money;

    public function getPurchasePrice(): Money;

    public function getSimplesNacional(): Money;

    public function isProfitable(): bool;

//    public function __toString(): string;
}
