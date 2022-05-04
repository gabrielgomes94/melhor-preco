<?php

namespace Src\Promotions\Infrastructure\Laravel\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Src\Math\Percentage;
use Src\Products\Domain\Models\Product\Product;
use Src\Promotions\Domain\Data\Entities\Promotion as PromotionInterface;

class Promotion extends Model implements PromotionInterface
{
    protected $fillable = [
        'name',
        'discount',
        'begin_date',
        'end_date',
        'max_products_limit',
        'marketplace_subsidy',
    ];

    protected $casts = [
        'begin_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    protected $primaryKey = 'uuid';

    public $keyType = 'string';

    public function prices(): HasMany
    {
        return $this->hasMany(PriceInPromotion::class);
    }

    public function products(): HasManyThrough
    {
        return $this->hasManyThrough(Product::class, PriceInPromotion::class);
    }

    public function getProducts()
    {
        return $this->products;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMarketplace(): string
    {
        return 'magalu';
    }

    public function getDiscount(): Percentage
    {
        return Percentage::fromPercentage($this->discount);
    }

    public function getBeginDate(): DateTime
    {
        return $this->begin_date;
    }

    public function getEndDate(): DateTime
    {
        return $this->end_date;
    }

    public function getProductsLimit(): int
    {
        return $this->max_products_limit;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getMarketplaceSubsidy(): Percentage
    {
        return Percentage::fromPercentage($this->marketplace_subsidy ?? 0);
    }
}
