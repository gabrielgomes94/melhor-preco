<?php

namespace Src\Prices\Price\Domain\Models;

use Src\Products\Domain\Models\Product;
use Barrigudinha\Utils\Helpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        $profit = Helpers::floatToMoney($this->profit);
        $value = Helpers::floatToMoney($this->value);

        if ($value->isZero()) {
            return 0.0;
        }

        return $profit->ratioOf($value);
    }

    public function isProfitMarginInRange(float $minimumProfit, float $maximumProfit): bool
    {
        $minimumProfit = Helpers::percentage($minimumProfit);
        $maximumProfit = Helpers::percentage($maximumProfit);

        return $minimumProfit <= $this->margin() && $this->margin() <= $maximumProfit;
    }
}
