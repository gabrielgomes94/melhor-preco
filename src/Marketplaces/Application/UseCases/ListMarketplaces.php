<?php

namespace Src\Marketplaces\Application\UseCases;

use Src\Marketplaces\Domain\UseCases\Contracts\ListMarketplaces as ListMarketplacesInterface;
use Src\Marketplaces\Infrastructure\Laravel\Eloquent\MarketplaceRepository;
use Src\Marketplaces\Presentation\Presenters\MarketplacePresenter;

class ListMarketplaces implements ListMarketplacesInterface
{
    private MarketplaceRepository $marketplaceRepository;
    private MarketplacePresenter $marketplacePresenter;

    public function __construct(
        MarketplaceRepository $marketplaceRepository,
        MarketplacePresenter $marketplacePresenter
    ) {
        $this->marketplaceRepository = $marketplaceRepository;
        $this->marketplacePresenter = $marketplacePresenter;
    }

    public function list(): array
    {
        $marketplaces = $this->marketplaceRepository->list();

        return $this->marketplacePresenter->present($marketplaces);
    }
}
