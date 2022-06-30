<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Services;

use Src\Marketplaces\Domain\DataTransfer\CategoryCommission;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Marketplaces\Domain\Services\UpdateCommission as UpdateCommissionInterface;

class UpdateCommission implements UpdateCommissionInterface
{
    public function __construct(
        private readonly MarketplaceRepository $marketplaceRepository
    ) {
    }

    public function massUpdate(string $marketplaceSlug, array $data): bool
    {
        $marketplace = $this->marketplaceRepository->getBySlug($marketplaceSlug);
        $marketplace->setCommissionsByCategory(collect($data));

        return $marketplace->save();
    }

    public function update(string $marketplaceSlug, float $commission): bool
    {
        $marketplace = $this->marketplaceRepository->getBySlug($marketplaceSlug);
        $marketplace->setCommissionByUniqueValue($commission);

        return $marketplace->save();
    }
}
