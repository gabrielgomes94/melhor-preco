<?php

namespace Src\Prices\Domain\Models\Calculator\Contracts;

use Money\Money;
use Src\Prices\Domain\Models\Calculator\CostPrice;

interface CalculatedPrice
{
    public function get(): float;

    public function getCommission(): float;

    public function getCostPrice(): CostPrice;

    public function getCosts(): float;

    public function getDifferenceICMS(): float;

    public function getFreight(): float;

    public function getMargin(): float;

    public function getProfit(): float;

    public function getPurchasePrice(): float;

    public function getSimplesNacional(): float;

    public function isProfitable(): bool;
}
