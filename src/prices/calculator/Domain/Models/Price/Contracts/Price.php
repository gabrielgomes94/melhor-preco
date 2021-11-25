<?php

namespace Src\Prices\Calculator\Domain\Models\Price\Contracts;

use Money\Money;
use Src\Prices\Calculator\Domain\Models\Product\Contracts\ProductData;
use Src\Prices\Calculator\Domain\Models\Price\Commission\Commission;
use Src\Prices\Calculator\Domain\Models\Price\Costs\CostPrice;
use Src\Prices\Calculator\Domain\Models\Price\Freight\BaseFreight;
use Src\Products\Domain\Models\Store\Store;

interface Price
{
    public function __construct(
        ProductData $product,
        Store $store,
        float $value,
        float $commission,
        array $options = []
    );

    public function get(): Money;

    public function getCommission(): Commission;

    public function getCostPrice(): CostPrice;

    public function getCosts(): Money;

    public function getDifferenceICMS(): Money;

    public function getFreight(): BaseFreight;

    public function getMargin(): float;

    public function getProductData(): \Src\Prices\Calculator\Domain\Models\Product\Contracts\ProductData;

    public function getProfit(): Money;

    public function getPurchasePrice(): Money;

    public function getSimplesNacional(): Money;

    public function getStore(): Store;

    public function __toString(): string;
}
