<?php

namespace Src\Marketplaces\Domain\UseCases\Contracts;

interface SaveMarketplace
{
    public function save(array $data, ?string $marketplaceId = null): bool;
}
