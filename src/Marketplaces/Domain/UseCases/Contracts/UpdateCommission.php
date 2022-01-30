<?php

namespace Src\Marketplaces\Domain\UseCases\Contracts;

interface UpdateCommission
{
    public function massUpdate(string $marketplaceSlug, array $data): bool;

    public function update(string $marketplaceSlug, float $commission): bool;
}
