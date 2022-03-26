<?php

namespace Src\Marketplaces\Application\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Collection;
use Src\Marketplaces\Application\Models\ValueObjects\CategoryCommission;
use Src\Marketplaces\Domain\Models\Contracts\CommissionType;
use Src\Marketplaces\Domain\Models\Contracts\Marketplace as MarketplaceInterface;
use Src\Math\Percentage;
use Src\Prices\Domain\Models\Price;
use Src\Products\Domain\Models\Product\Product;

class Marketplace extends Model implements MarketplaceInterface
{
    public $incrementing = false;

    protected $fillable = [
        'erp_id',
        'erp_name',
        'name',
        'slug',
        'extra',
        'is_active',
        'uuid',
    ];

    protected $casts = [
        'extra' => 'json',
    ];

    protected $primaryKey = 'uuid';

    public $keyType = 'string';

    public function products(): HasManyThrough
    {
        return $this->hasManyThrough(
            Product::class,
            Price::class,
            'marketplace_erp_id',
            'sku',
            'erp_id',
            'product_sku'
        );
    }

    public function prices(): HasMany
    {
        return $this->hasMany(Price::class, 'marketplace_erp_id', 'erp_id');
    }

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

    public function setCommissionByCategory(CategoryCommission $categoryCommission)
    {
        // @todo: add logic

    }

    public function setCommissionsByCategory(Collection $commissions)
    {
        $extra['commissionValues'] = $commissions->map(
            function (CategoryCommission $categoryCommission) {
                return [
                    'categoryId' => $categoryCommission->categoryId,
                    'commission' => $categoryCommission->commission->get()
                ];
            })->toArray();

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

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function getPrices(): iterable
    {
        return $this->prices;
    }
}
