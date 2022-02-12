<?php

namespace Src\Marketplaces\Application\UseCases;

use Src\Marketplaces\Application\Models\ValueObjects\CategoryCommission;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Marketplaces\Domain\UseCases\Contracts\UpdateCommission as UpdateCommissionInterface;

class UpdateCommission implements UpdateCommissionInterface
{
    private MarketplaceRepository $marketplaceRepository;

    public function __construct(MarketplaceRepository $marketplaceRepository)
    {
        $this->marketplaceRepository = $marketplaceRepository;
    }

    public function massUpdate(string $marketplaceSlug, array $data): bool
    {
        $marketplace = $this->marketplaceRepository->getBySlug($marketplaceSlug);

        $data = collect($data)->map(function (array $commission) {
            return new CategoryCommission($commission);
        });

        $marketplace->setCommissionsByCategory($data);

        return $marketplace->save();
    }

    public function update(string $marketplaceSlug, float $commission): bool
    {
        $marketplace = $this->marketplaceRepository->getBySlug($marketplaceSlug);
        $marketplace->setCommissionByUniqueValue($commission);

        return $marketplace->save();
    }
}
