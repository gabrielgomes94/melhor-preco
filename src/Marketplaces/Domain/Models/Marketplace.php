<?php

namespace Src\Marketplaces\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Src\Marketplaces\Domain\Models\Contracts\CommissionType;
use Src\Marketplaces\Domain\Models\Contracts\Marketplace as MarketplaceInterface;
use Src\Math\Percentage;

class Marketplace extends Model implements MarketplaceInterface
{
    public $incrementing = false;

    protected $fillable = [
        'erp_id',
        'erp_name',
        'name',
        'slug',
        'extra',
        'uuid',
    ];

    protected $casts = [
        'extra' => 'json',
    ];

    protected $primaryKey = 'uuid';

    public $keyType = 'string';

    public function getCommissionType(): string
    {
        return $this->extra['commissionType'];
    }

    public function getErpId(): string
    {
        return $this->erp_id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getCommissionValues(): array
    {
        $commissions = $this->getCommissions();

        foreach ($commissions as $data) {
            $commissionList[] = $data['commission'] ?? null;
        }

        return array_unique($commissionList ?? []);
    }

    public function getCommissions()
    {
        return $this->extra['commissionValues'] ?? [];
    }

    public function getCommission(?string $categoryId = null): ?Percentage
    {
        if ($this->getCommissionType() === CommissionType::CATEGORY_COMMISSION) {
            $commissions = $this->getCommissions();

            foreach ($commissions as $data) {
                if ($data['categoryId'] === $categoryId) {
                    return Percentage::fromPercentage($data['commission']);
                }
            }
        }

        return null;
    }

    public function setCommissionByCategory(Collection $commissions)
    {
        foreach ($commissions as $categoryCommission) {
            $extra['commissionValues'][] = [
                'categoryId' => $categoryCommission->categoryId,
                'commission' => $categoryCommission->commission->get()
            ];
        }

        $this->extra = array_merge($this->extra, $extra);
    }

    public function setCommissionByUniqueValue(float $commission)
    {
        $extra['commissionValues'] = [
            [
                'categoryId' => null,
                'commission' => $commission,
            ],
        ];

        $this->extra = array_merge($this->extra, $extra);
    }
}
