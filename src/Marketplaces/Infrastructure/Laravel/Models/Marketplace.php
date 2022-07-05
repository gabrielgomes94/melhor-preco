<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Src\Marketplaces\Domain\DataTransfer\Collections\CommissionValues;
use Src\Marketplaces\Domain\Models\Commission\Commission;
use Src\Marketplaces\Domain\Models\Marketplace as MarketplaceInterface;
use Src\Marketplaces\Infrastructure\Laravel\Models\Casts\CommissionCast;
use Src\Marketplaces\Infrastructure\Laravel\Models\Concerns\MarketplaceScopes;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Src\Users\Infrastructure\Laravel\Models\User;

class Marketplace extends Model implements MarketplaceInterface
{
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

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

    public function setCommissions(CommissionValues $commissions)
    {
        $this->commission = Commission::fromArray(
            $this->getCommission()->getType(),
            $commissions
        );
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

        $count = self::where('user_id', $userId)
            ->where('slug', $this->getSlug())
            ->where('uuid', '!=',  $this->getUuid())
            ->count();

        return $count > 0;
    }

    public function getUserId(): string
    {
        return $this->getUser()->getId();
    }
}
