<?php

namespace Src\Marketplaces\Domain\UseCases\Contracts;

interface GetCommission
{
    public function get(string $marketplaceErpId, string $productSku): float;
}
