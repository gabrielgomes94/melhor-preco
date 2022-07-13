<?php

namespace Src\Prices\Domain\Models\Calculator\Contracts;

use Money\Money;
use Src\Prices\Domain\Models\Calculator\CostPrice;

interface CalculatedPrice
{
    public function get(): Money;

    public function getCommission(): Money;

    public function getCostPrice(): CostPrice;

    public function getCosts(): Money;

    public function getDifferenceICMS(): Money;

    public function getFreight(): Money;

    public function getMargin(): float;

    public function getProfit(): Money;

    public function getPurchasePrice(): Money;

    public function getSimplesNacional(): Money;

    public function isProfitable(): bool;
}
