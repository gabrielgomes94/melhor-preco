<?php

namespace Src\Marketplaces\Domain\UseCases\Contracts;

use Src\Prices\Infrastructure\Laravel\Models\Price;

interface GetCommission
{
    public function get(string $marketplaceErpId, string $productSku): float;

    public function getFromPrice(Price $price): float;
}
