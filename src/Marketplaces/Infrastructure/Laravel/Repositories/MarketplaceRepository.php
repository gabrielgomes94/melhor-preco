<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Marketplaces\Domain\DataTransfer\MarketplaceSettings;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository as MarketplaceRepositoryInterface;

class MarketplaceRepository implements MarketplaceRepositoryInterface
{
    public function create(MarketplaceSettings $data): Marketplace
    {
        $data = $this->prepareData($data);

        return Marketplace::create(
            array_merge($data, [
                'uuid' => Uuid::uuid4(),
            ])
        );
    }

    public function exists(string $marketplaceUuid): bool
    {
        $marketplace = Marketplace::where('uuid', $marketplaceUuid)->get();

        return $marketplace->count() > 0;
    }

    public function getByErpId(string $marketplaceErpId): ?Marketplace
    {
        return Marketplace::where('erp_id', $marketplaceErpId)->first();
    }

    public function getBySlug(string $marketplaceSlug): ?Marketplace
    {
        return Marketplace::where('slug', $marketplaceSlug)->first();
    }

    public function getByUuid(string $marketplaceUuid): ?Marketplace
    {
        return Marketplace::where('uuid', $marketplaceUuid)->first();
    }

    public function list(): Collection
    {
        return Marketplace::all();
    }

    public function update(MarketplaceSettings $data, string $marketplaceId): bool
    {
        $marketplace = $this->getByUuid($marketplaceId);

        if (!$marketplace) {
            return false;
        }

        $data = $this->prepareData($data);
        $marketplace->fill($data);

        return $marketplace->save();
    }

    private function prepareData(MarketplaceSettings $data): array
    {
        $slug = Str::slug($data->name);

        return [
            'erp_id' => $data->erpId,
            'erp_name' => 'bling',
            'extra' => [
                'commissionType' => $data->commissionType,
            ],
            'is_active' => $data->isActive,
            'name' => $data->name,
            'slug' => $slug,
            'user_id' => $data->userId
        ];
    }
}
