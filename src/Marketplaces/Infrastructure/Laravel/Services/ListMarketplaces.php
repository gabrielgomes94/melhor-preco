<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Services;

use Illuminate\Support\Collection;
use Src\Marketplaces\Domain\UseCases\Contracts\ListMarketplaces as ListMarketplacesInterface;
use Src\Marketplaces\Infrastructure\Laravel\Repositories\MarketplaceRepository;

class ListMarketplaces implements ListMarketplacesInterface
{
    public function __construct(
        private MarketplaceRepository $marketplaceRepository,
    ) {}

    public function list(): Collection
    {
        return $this->marketplaceRepository->list();
    }
}
