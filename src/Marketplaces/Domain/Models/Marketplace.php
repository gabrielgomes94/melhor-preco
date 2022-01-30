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

    public function getCommissions(): array
    {
        return $this->extra['commissionValues'] ?? [];
    }

    public function getCommissionByCategory(?string $categoryId = null): ?Percentage
    {
        if (!$this->hasCommissionByCategory()) {
            throw new \Exception('Marketplace não possui comissões por categorias.');
        }

        $commissions = $this->getCommissions();

        foreach ($commissions as $data) {
            if ($data['categoryId'] === $categoryId) {
                return Percentage::fromPercentage($data['commission']);
            }
        }

        return null;
    }

    public function getUniqueCommission(): ?Percentage
    {
        if (!$this->hasUniqueCommission()) {
            throw new \Exception('Marketplace possui varias commissões');
        }

        $commissions = $this->getCommissions();
        $data = array_shift($commissions);

        if (empty($data['commission'])) {
            return null;
        }

        return Percentage::fromPercentage($data['commission']);
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

    public function hasUniqueCommission(): bool
    {
        return $this->getCommissionType() === CommissionType::UNIQUE_COMMISSION;
    }

    public function hasCommissionByCategory(): bool
    {
        return $this->getCommissionType() === CommissionType::CATEGORY_COMMISSION;
    }
}
