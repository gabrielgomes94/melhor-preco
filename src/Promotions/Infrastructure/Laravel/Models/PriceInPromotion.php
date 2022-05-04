<?php

namespace Src\Promotions\Infrastructure\Laravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Src\Marketplaces\Application\Models\Marketplace;
use Src\Math\Percentage;
use Src\Math\ProfitMargin;
use Src\Prices\Domain\Models\Contracts\Price;
use Src\Products\Domain\Models\Product\Product;

class PriceInPromotion extends Model implements Price
{
    protected $fillable = [
        'profit',
        'value',
        'price_id',
        'promotion_uuid',
        'uuid',
    ];

    protected $primaryKey = 'uuid';

    public $keyType = 'string';

    protected $table = 'prices_in_promotions';

    public function price(): HasOne
    {
        return $this->hasOne(\Src\Prices\Domain\Models\Price::class, 'id', 'price_id');
    }

    public function product(): HasOneThrough
    {
        return $this->hasOneThrough(Product::class, \Src\Prices\Domain\Models\Price::class);
    }

    public function promotion(): BelongsTo
    {
        return $this->belongsTo(Promotion::class, 'promotion_uuid', 'uuid');
    }

    public function getCommission(): Percentage
    {
        return Percentage::fromFraction($this->price->commission);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getMargin(): Percentage
    {
        return ProfitMargin::calculate($this->profit, $this->value);
    }

    public function getMarketplace(): Marketplace
    {
        return $this->price->marketplace;
    }

    public function getMarketplaceErpId(): string
    {
        return $this->price->marketplace_erp_id;
    }

    public function getProduct(): Product
    {
        return $this->price->product;
    }

    public function getProductSku(): string
    {
        return $this->price->product_sku;
    }

    public function getProfit(): float
    {
        return $this->profit;
    }

    public function getStoreSkuId(): string
    {
        return $this->price->store_sku_id;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function isProfitable(): bool
    {
        return $this->profit > 0;
    }
}
