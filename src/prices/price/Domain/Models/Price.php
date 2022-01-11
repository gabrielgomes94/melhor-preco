<?php

namespace Src\Prices\Price\Domain\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Src\Prices\Calculator\Domain\Transformer\MoneyTransformer;
use Src\Prices\Calculator\Domain\Transformer\PercentageTransformer;
use Illuminate\Database\Eloquent\Model;
use Src\Products\Domain\Models\Product\Product;

class Price extends Model
{
    protected $fillable = [
        'commission',
        'profit',
        'store',
        'store_sku_id',
        'value',
        'additional_costs',
        'product_sku',
    ];

    protected $casts = [
        'product_sku' => 'string',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_sku', 'sku');
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

    public function getValue(): float
    {
        return $this->value;
    }

    public function isProfitable(): bool
    {
        if (!$post = $this->product->getPost($this->store)) {
            return false;
        }

        return $post->isProfitable();
    }

//    public function product()
//    {
//        return $this->belongsTo(Product::class, 'product_id');
//    }

    public function margin(): float
    {
        $profit = MoneyTransformer::toMoney($this->profit);
        $value = MoneyTransformer::toMoney($this->value);

        if ($value->isZero()) {
            return 0.0;
        }

        return $profit->ratioOf($value);
    }

    public function isProfitMarginInRange(float $minimumProfit, float $maximumProfit): bool
    {
        $minimumProfit = PercentageTransformer::toPercentage($minimumProfit);
        $maximumProfit = PercentageTransformer::toPercentage($maximumProfit);

        return $minimumProfit <= $this->margin() && $this->margin() <= $maximumProfit;
    }
}
