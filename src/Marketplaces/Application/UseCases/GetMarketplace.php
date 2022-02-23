<?php

namespace Src\Marketplaces\Application\UseCases;

use Src\Marketplaces\Application\Exceptions\MarketplaceNotFoundException;
use Src\Marketplaces\Domain\Models\Contracts\Marketplace;
use Src\Marketplaces\Infrastructure\Laravel\Eloquent\MarketplaceRepository;

class GetMarketplace
{
    public function __construct(
        private MarketplaceRepository $marketplaceRepository
    ) {}

    /**
     * @throws MarketplaceNotFoundException
     */
    public function get(string $marketplaceId): Marketplace
    {
        $marketplace = $this->marketplaceRepository->getByErpId($marketplaceId);

        if (!$marketplace) {
            throw new MarketplaceNotFoundException($marketplaceId);
        }

        return $marketplace;
    }
}
