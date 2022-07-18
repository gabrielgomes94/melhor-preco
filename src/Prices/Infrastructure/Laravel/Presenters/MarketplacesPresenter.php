<?php

namespace Src\Prices\Infrastructure\Laravel\Presenters;

use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;

class MarketplacesPresenter
{
    public function __construct(
        private readonly MarketplaceRepository $marketplaceRepository
    ) {
    }

    public function present(string $userId): array
    {
        $marketplaces = $this->marketplaceRepository->list($userId);
        $marketplaces = collect($marketplaces);

        return $marketplaces->map(
            fn (Marketplace $marketplace) => [
                'slug' => $marketplace->getSlug(),
                'name' => $marketplace->getName(),
            ]
        )->toArray();
    }
}
