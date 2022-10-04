<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Src\Marketplaces\Domain\Models\Freight\Freight;
use Src\Marketplaces\Domain\Models\Commission\Base\Commission;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValuesCollection;
use Src\Marketplaces\Domain\Models\Marketplace as MarketplaceInterface;
use Src\Marketplaces\Infrastructure\Laravel\Models\Casts\CommissionCast;
use Src\Marketplaces\Infrastructure\Laravel\Models\Casts\FreightCast;
use Src\Marketplaces\Infrastructure\Laravel\Models\Concerns\MarketplaceRelationships;
use Src\Marketplaces\Infrastructure\Laravel\Models\Concerns\MarketplaceScopes;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Users\Infrastructure\Laravel\Models\User;

class Marketplace extends Model implements MarketplaceInterface
{
    use MarketplaceRelationships;
    use MarketplaceScopes;

    public $incrementing = false;

    protected $fillable = [
        'erp_id',
        'erp_name',
        'name',
        'slug',
        'commission',
        'freight',
        'is_active',
        'uuid',
        'user_id',
    ];

    protected $casts = [
        'commission' => CommissionCast::class,
        'freight' => FreightCast::class,
    ];

    protected $primaryKey = 'uuid';

    public $keyType = 'string';

    public function getCommission(): Commission
    {
        return $this->commission;
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

    public function getUser(): User
    {
        return $this->user;
    }

    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }

    public function getPrice(string $productSku): ?Price
    {
        $prices = $this->getPrices();

        /**
         * @var Price $price
         */
        foreach ($prices as $price) {
            if ($price->getProductSku() === $productSku) {
                return $price;
            }
        }

        return null;
    }

    public function getPrices(): Collection
    {
        return $this->prices;
    }

    public function slugsExists(): bool
    {
        $userId = $this->getUser()->getId();

        $count = self::fromUser($userId)
            ->withSlug($this->getSlug())
            ->where('uuid', '!=',  $this->getUuid())
            ->count();

        return $count > 0;
    }

    public function getUserId(): string
    {
        return $this->getUser()->getId();
    }

    public function getFreight(): Freight
    {
        return $this->freight;
    }

    public function setCommissions(CommissionValuesCollection $commissions): void
    {
        $this->commission = Commission::build(
            $this->getCommission()->getType(),
            $commissions,
            $commissions->getMaximumCapValue()
        );
    }

    public function setFreight(Freight $freight): void
    {
        $this->freight = $freight;
    }
}
