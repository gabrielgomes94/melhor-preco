<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Services;

use Src\Marketplaces\Domain\Exceptions\MarketplaceNotFoundException;
use Src\Marketplaces\Domain\Models\Contracts\Marketplace;
use Src\Marketplaces\Infrastructure\Laravel\Repositories\MarketplaceRepository;
use Src\Marketplaces\Domain\UseCases\Contracts\GetMarketplace as GetMarketplaceInterface;

/**
 * @deprecated Use repository instead
 */
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
