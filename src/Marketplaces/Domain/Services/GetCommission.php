<?php

namespace Src\Marketplaces\Domain\Services;

use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Users\Domain\Entities\User;

interface GetCommission
{
    public function get(string $marketplaceErpId, string $productSku, string $userId): float;

    public function getFromPrice(Price $price, User $user): float;
}
