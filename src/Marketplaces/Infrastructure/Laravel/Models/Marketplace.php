<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Models;

use Illuminate\Database\Eloquent\Model;
use Src\Marketplaces\Domain\DataTransfer\Collections\CommissionValues;
use Src\Marketplaces\Domain\Models\Commission\Commission;
use Src\Marketplaces\Domain\Models\Marketplace as MarketplaceInterface;
use Src\Marketplaces\Infrastructure\Laravel\Models\Casts\CommissionCast;
use Src\Marketplaces\Infrastructure\Laravel\Models\Concerns\MarketplaceRelationships;
use Src\Marketplaces\Infrastructure\Laravel\Models\Concerns\MarketplaceScopes;
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
        'is_active',
        'uuid',
        'user_id',
    ];

    protected $casts = [
        'commission' => CommissionCast::class,
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
        return $this->is_active;
    }

    public function getPrices(): iterable
    {
        return $this->prices;
    }

    public function slugsExists(): bool
    {
        $userId = $this->getUser()->getId();

        $count = self::withUser($userId)
            ->withSlug($this->getSlug())
            ->where('uuid', '!=',  $this->getUuid())
            ->count();

        return $count > 0;
    }

    public function getUserId(): string
    {
        return $this->getUser()->getId();
    }

    public function setCommissions(CommissionValues $commissions): void
    {
        $this->commission = Commission::fromArray(
            $this->getCommission()->getType(),
            $commissions
        );
    }
}
