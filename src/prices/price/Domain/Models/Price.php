<?php

namespace Src\Prices\Price\Domain\Models;

use Src\Prices\Calculator\Domain\Transformer\MoneyTransformer;
use Src\Prices\Calculator\Domain\Transformer\PercentageTransformer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Products\Domain\Product\Models\Product;

class Price extends Model
{
    use HasFactory;

    protected $fillable = [
        'commission',
        'profit',
        'store',
        'store_sku_id',
        'value',
        'additional_costs',
    ];

    public function getProductSku(): string
    {
        return $this->product_id;
    }

    public function getProfit(): float
    {
        return $this->profit;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function isProfitable(): bool
    {
        return $this->profit > 0.0;
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

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

    public static function listProducts(string $storeSlug)
    {

    }
}
