<?php

namespace Src\Products\Domain\Product\Contracts\Models\Data\Price;

use Src\Products\Domain\Store\Contracts\Store;

interface Price
{
    public function getId(): string;

    public function getAdditionalCosts(): float;

    public function getCommission(): float;

    public function getPrice(): float;

    public function getProfit(): float;

    public function getStore(): Store;
}
