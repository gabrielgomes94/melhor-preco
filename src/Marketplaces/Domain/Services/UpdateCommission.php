<?php

namespace Src\Marketplaces\Domain\Services;

interface UpdateCommission
{
    public function massUpdate(string $marketplaceSlug, array $data): bool;

    public function update(string $marketplaceSlug, float $commission): bool;
}
