<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Eloquent;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use Src\Marketplaces\Application\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository as MarketplaceRepositoryInterface;

class MarketplaceRepository implements MarketplaceRepositoryInterface
{
    public function create(array $data): bool
    {
        $slug = Str::slug($data['name']);

        return Marketplace::create([
            'erp_id' => $data['erpId'],
            'erp_name' => 'bling',
            'name' => $data['name'],
            'slug' => $slug,
            'extra' => [
                'commissionType' => $data['commissionType'],
            ],
            'uuid' => Uuid::uuid4(),
        ]);
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

    public function update(array $data, string $marketplaceId): bool
    {
        $marketplace = $this->getByUuid($marketplaceId);

        if (!$marketplace) {
            return false;
        }

        $slug = Str::slug($data['name']);
        $marketplace->fill([
            'erp_id' => $data['erpId'],
            'erp_name' => 'bling',
            'name' => $data['name'],
            'slug' => $slug,
            'extra' => [
                'commissionType' => $data['commissionType'],
            ],
        ]);

        return $marketplace->save();
    }
}
