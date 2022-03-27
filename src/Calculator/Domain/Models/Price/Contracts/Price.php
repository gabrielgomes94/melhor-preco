<?php

namespace Src\Calculator\Domain\Models\Price\Contracts;

use Money\Money;
use Src\Calculator\Domain\Models\Product\Contracts\ProductData;
use Src\Calculator\Domain\Models\Price\Commission\Commission;
use Src\Calculator\Domain\Models\Price\Costs\CostPrice;
use Src\Calculator\Domain\Models\Price\Freight\BaseFreight;
use Src\Marketplaces\Domain\Models\Contracts\Marketplace;

interface Price
{
    public function get(): Money;

    public function getCommission(): Commission;

    public function getCostPrice(): CostPrice;

    public function getCosts(): Money;

    public function getDifferenceICMS(): Money;

    public function getFreight(): BaseFreight;

    public function getMargin(): float;

    public function getProductData(): ProductData;

    public function getProfit(): Money;

    public function getPurchasePrice(): Money;

    public function getSimplesNacional(): Money;

    public function isProfitable(): bool;

    public function __toString(): string;
}
