<?php

namespace Src\Prices\Infrastructure\Laravel\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Math\Transformers\MoneyTransformer;
use Src\Math\Percentage;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Src\Users\Infrastructure\Laravel\Models\User;

/**
 * @todo: remover os campos store, product_sku e marketplace_erp_id
 */
class Price extends Model
{
    protected $fillable = [
        'additional_costs',
        'commission',
        'margin',
        'profit',
        'store_sku_id',
        'value',
    ];

    public $keyType = 'string';

    private string $productSku = '';

    public function marketplace(): BelongsTo
    {
        return $this->belongsTo(Marketplace::class, 'marketplace_uuid', 'uuid');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_uuid', 'uuid');
    }

    public function getCommission(): Percentage
    {
        return Percentage::fromPercentage($this->commission);
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

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function getProductSku(): string
    {
        return empty($this->productSku)
            ? $this->getProduct()?->getSku() ?? ''
            : $this->productSku;
    }

    public function getProfit(): ?float
    {
        return $this->profit;
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

    public function setProductSku(string $sku): void
    {
        $this->productSku = $sku;
    }
}
