<?php

namespace Src\Marketplaces\Application\UseCases;

use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Marketplaces\Domain\UseCases\Contracts\GetCommissionType as GetCommissionTypeInterface;

class GetCommissionType implements GetCommissionTypeInterface
{
    private MarketplaceRepository $marketplaceRepository;

    public function __construct(MarketplaceRepository $marketplaceRepository)
    {
        $this->marketplaceRepository = $marketplaceRepository;
    }

    public function get(string $marketplaceSlug): string
    {
        $marketplace = $this->marketplaceRepository->getBySlug($marketplaceSlug);

        if (!$marketplace) {
            throw new \Exception('Markeplace not found');
        }

        return $marketplace->getCommissionType();
    }
}