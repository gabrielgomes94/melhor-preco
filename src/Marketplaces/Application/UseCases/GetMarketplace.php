<?php

namespace Src\Marketplaces\Application\UseCases;

use Src\Marketplaces\Application\Exceptions\MarketplaceNotFoundException;
use Src\Marketplaces\Domain\Models\Contracts\Marketplace;
use Src\Marketplaces\Infrastructure\Laravel\Eloquent\MarketplaceRepository;
use Src\Marketplaces\Domain\UseCases\Contracts\GetMarketplace as GetMarketplaceInterface;

class GetMarketplace implements GetMarketplaceInterface
{
    public function __construct(
        private MarketplaceRepository $marketplaceRepository
    ) {}

    /**
     * @throws MarketplaceNotFoundException
     */
    public function getByUuid(string $marketplaceUuid): Marketplace
    {
        $marketplace = $this->marketplaceRepository->getByUuid($marketplaceUuid);

        if (!$marketplace) {
            throw new MarketplaceNotFoundException($marketplaceUuid);
        }

        return $marketplace;
    }
}
