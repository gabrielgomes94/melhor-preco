<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Repositories;

use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use Src\Marketplaces\Domain\DataTransfer\MarketplaceSettings;
use Src\Marketplaces\Domain\Exceptions\InvalidCommissionTypeException;
use Src\Marketplaces\Domain\Exceptions\MarketplaceSlugAlreadyExists;
use Src\Marketplaces\Domain\Models\Commission\Base\Commission;
use Src\Marketplaces\Domain\Models\Freight\Freight;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository as MarketplaceRepositoryInterface;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValuesCollection;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace as MarketplaceModel;

class MarketplaceRepository implements MarketplaceRepositoryInterface
{
    /**
     * @throws MarketplaceSlugAlreadyExists
     */
    public function create(MarketplaceSettings $settings): Marketplace
    {
        $data = array_merge(
            $this->prepareData($settings),
            ['uuid' => Uuid::uuid4()]
        );
        $marketplace = new MarketplaceModel($data);
        $marketplace->user_id = $settings->userId;
        $marketplace->setFreight(new Freight(0.0));

        if ($marketplace->slugsExists()) {
            throw new MarketplaceSlugAlreadyExists($marketplace);
        }

        $marketplace->save();

        return $marketplace->refresh();
    }

    public function getByErpId(string $marketplaceErpId, string $userId): ?Marketplace
    {
        return MarketplaceModel::withErpId($marketplaceErpId)
            ->fromUser($userId)
            ->first();
    }

    public function getBySlug(string $marketplaceSlug, string $userId): ?Marketplace
    {
        return MarketplaceModel::withSlug($marketplaceSlug)
            ->fromUser($userId)
            ->first();
    }

    public function list(string $userId): array
    {
        return MarketplaceModel::fromUser($userId)
            ->orderBy('slug')
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
     * @throws InvalidCommissionTypeException
     */
    private function prepareData(MarketplaceSettings $data): array
    {
        return [
            'erp_id' => $data->erpId,
            'erp_name' => 'bling',
            'commission' => Commission::build(
                $data->commissionType,
                new CommissionValuesCollection([])
            ),
            'is_active' => $data->isActive,
            'name' => $data->name,
            'slug' => Str::slug($data->name),
        ];
    }

    public function first(string $userId): ?Marketplace
    {
        return MarketplaceModel::fromUser($userId)->get()?->first();
    }
}
