<?php

namespace Src\Marketplaces\Domain\UseCases\Contracts;

use Src\Marketplaces\Domain\Exceptions\MarketplaceNotFoundException;
use Src\Marketplaces\Domain\Models\Contracts\Marketplace;

interface GetMarketplace
{
    /**
     * @throws MarketplaceNotFoundException
     */
    public function getByUuid(string $marketplaceUuid): Marketplace;
}
