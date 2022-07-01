<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use Src\Marketplaces\Domain\Exceptions\MarketplaceSlugAlreadyExists;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Marketplaces\Domain\DataTransfer\MarketplaceSettings;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository as MarketplaceRepositoryInterface;

class MarketplaceRepository implements MarketplaceRepositoryInterface
{
    /**
     * @throws MarketplaceSlugAlreadyExists
     */
    public function create(MarketplaceSettings $data): Marketplace
    {
        $data = $this->prepareData($data);
        $marketplace = new Marketplace([
            array_merge($data, [
                'uuid' => Uuid::uuid4(),
            ])
        ]);

        if ($marketplace->slugsExists()) {
            throw new MarketplaceSlugAlreadyExists($marketplace);
        }

        $marketplace->save();

        return $marketplace->refresh();
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

    private function prepareData(MarketplaceSettings $data): array
    {
        return [
            'erp_id' => $data->erpId,
            'erp_name' => 'bling',
            'extra' => [
                'commissionType' => $data->commissionType,
            ],
            'is_active' => $data->isActive,
            'name' => $data->name,
            'slug' => Str::slug($data->name),
            'user_id' => $data->userId
        ];
    }
}
