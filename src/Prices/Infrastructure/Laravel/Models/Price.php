<?php

namespace Src\Prices\Infrastructure\Laravel\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Math\MoneyTransformer;
use Src\Math\Percentage;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Src\Users\Infrastructure\Laravel\Models\User;

class Price extends Model
{
    protected $fillable = [
        'commission',
        'margin',
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
        return $this->belongsTo(Product::class, 'product_uuid', 'uuid');
    }

    public function getCommission(): Percentage
    {
        return Percentage::fromFraction($this->commission);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLastUpdate(): Carbon
    {
        return $this->updated_at;
    }

    public function getMargin(): ?Percentage
    {
        return $this->margin ? Percentage::fromPercentage($this->margin) : null;
    }

    public function getMarketplace(): ?Marketplace
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

    public function getProfit(): ?float
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

    /**
     * @deprecated
     */
    public function margin(): float
    {
        $profit = MoneyTransformer::toMoney($this->profit);
        $value = MoneyTransformer::toMoney($this->value);

        if ($value->isZero()) {
            return 0.0;
        }

        return $profit->ratioOf($value);
    }
}
