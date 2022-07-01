<?php

namespace Src\Marketplaces\Domain\Services;

use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;

interface GetCategoriesWithCommissions
{
    public function get(Marketplace $marketplace, string $userId): array;
}
