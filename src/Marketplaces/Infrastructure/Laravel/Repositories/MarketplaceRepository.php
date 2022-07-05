<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Repositories;

use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use Src\Marketplaces\Domain\Exceptions\MarketplaceSlugAlreadyExists;
use Src\Marketplaces\Infrastructure\Laravel\Models\Commission;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Marketplaces\Domain\DataTransfer\MarketplaceSettings;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository as MarketplaceRepositoryInterface;

class MarketplaceRepository implements MarketplaceRepositoryInterface
{
    /**
     * @throws MarketplaceSlugAlreadyExists
     * @throws \Exception
     */
    public function create(MarketplaceSettings $settings): Marketplace
    {
        $data = array_merge(
            $this->prepareData($settings),
            ['uuid' => Uuid::uuid4()]
        );
        $marketplace = new Marketplace($data);
        $marketplace->user_id = $settings->userId;

        if ($marketplace->slugsExists()) {
            throw new MarketplaceSlugAlreadyExists($marketplace);
        }

        $marketplace->save();

        return $marketplace->refresh();
    }

    public function getByErpId(string $marketplaceErpId, string $userId): ?Marketplace
    {
        return Marketplace::withErpId($marketplaceErpId)
            ->withUser($userId)
            ->first();
    }

    public function getBySlug(string $marketplaceSlug, string $userId): ?Marketplace
    {
        return Marketplace::withSlug($marketplaceSlug)
            ->withUser($userId)
            ->first();
    }

    public function list(string $userId): array
    {
        return Marketplace::withUser($userId)
            ->get()
            ->all();
    }

    /**
     * @throws MarketplaceSlugAlreadyExists
     */
    public function update(Marketplace $marketplace, MarketplaceSettings $data): bool
    {
        $data = $this->prepareData($data);
        $marketplace->fill($data);

        if ($marketplace->slugsExists()) {
            throw new MarketplaceSlugAlreadyExists($marketplace);
        }

        return $marketplace->save();
    }

    /**
     * @throws \Exception
     */
    private function prepareData(MarketplaceSettings $data): array
    {
        return [
            'erp_id' => $data->erpId,
            'erp_name' => 'bling',
            'commission' => Commission::fromArray($data->commissionType, []),
            'is_active' => $data->isActive,
            'name' => $data->name,
            'slug' => Str::slug($data->name),
        ];
    }
}
