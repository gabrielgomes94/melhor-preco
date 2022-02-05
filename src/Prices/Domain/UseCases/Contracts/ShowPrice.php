<?php

namespace Src\Prices\Domain\UseCases\Contracts;

interface ShowPrice
{
    public function show(string $productId, string $marketplaceSlug): array;
}
