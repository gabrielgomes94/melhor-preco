<?php

namespace Src\Marketplaces\Domain\UseCases\Contracts;

use Src\Marketplaces\Application\Exceptions\MarketplaceNotFoundException;
use Src\Marketplaces\Domain\Models\Contracts\Marketplace;

interface GetMarketplace
{
    /**
     * @throws MarketplaceNotFoundException
     */
    public function getByUuid(string $marketplaceUuid): Marketplace;
}
