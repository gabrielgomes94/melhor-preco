<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Services;

use Src\Marketplaces\Domain\DataTransfer\MarketplaceSettings;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Marketplaces\Domain\UseCases\Contracts\SaveMarketplace as SaveMarketplaceInterface;

class SaveMarketplace implements SaveMarketplaceInterface
{
    public function __construct(private MarketplaceRepository $marketplaceRepository)
    {
    }

    public function save(MarketplaceSettings $data, ?string $marketplaceId = null): bool
    {
        if ($marketplaceId && $this->marketplaceRepository->exists($marketplaceId)) {
            return $this->marketplaceRepository->update($data, $marketplaceId);
        }

        return (bool) $this->marketplaceRepository->create($data);
    }
}
