<?php

namespace Src\Prices\Domain\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Src\Marketplaces\Application\Models\Marketplace;
use Illuminate\Database\Eloquent\Model;
use Src\Math\Percentage;
use Src\Math\ProfitMargin;
use Src\Prices\Domain\Models\Contracts\Price as PriceInterface;
use Src\Products\Domain\Models\Product\Product;

class Price extends Model implements PriceInterface
{
    protected $fillable = [
        'commission',
        'profit',
        'store',
        'store_sku_id',
        'value',
        'additional_costs',
        'product_sku',
        'marketplace_erp_id',
    ];

    protected $casts = [
        'product_sku' => 'string',
    ];

    public $keyType = 'string';

    public function marketplace(): BelongsTo
    {
        return $this->belongsTo(Marketplace::class, 'marketplace_erp_id', 'erp_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_sku', 'sku');
    }

    public function getCommission(): Percentage
    {
        return Percentage::fromFraction($this->commission);
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
        return $this->marketplace;
    }

    public function getMarketplaceErpId(): string
    {
        return $this->marketplace_erp_id;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getProductSku(): string
    {
        return $this->product_sku;
    }

    public function getProfit(): float
    {
        return $this->profit;
    }

    public function getStore(): string
    {
        return $this->store;
    }

    public function getStoreSkuId(): string
    {
        return $this->store_sku_id;
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
