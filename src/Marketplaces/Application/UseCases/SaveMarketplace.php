<?php

namespace Src\Marketplaces\Application\UseCases;

use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Marketplaces\Domain\UseCases\Contracts\SaveMarketplace as SaveMarketplaceInterface;

class SaveMarketplace implements SaveMarketplaceInterface
{
    public function __construct(private MarketplaceRepository $marketplaceRepository)
    {}

    public function save(array $data, ?string $marketplaceId = null): bool
    {
        if ($marketplaceId && $this->marketplaceRepository->exists($marketplaceId)) {
            return $this->marketplaceRepository->update($data, $marketplaceId);
        }

        return $this->marketplaceRepository->create($data);
    }
}
