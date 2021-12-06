<?php

namespace Src\Sales\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Src\Products\Domain\Models\Product\Product;

class Item extends Model
{
    protected $fillable = [
        'sku',
        'name',
        'quantity',
        'unit_value',
        'discount',
    ];

    protected $casts = [
        'sku' => 'string',
    ];

    protected $table = 'sales_items';

    public function product()
    {
        return $this->hasOne(Product::class, 'sku', 'sku');
    }

    public function saleOrder()
    {
        return $this->belongsTo(SaleOrder::class);
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function getTotalValue(): float
    {
        return ($this->unit_value - $this->discount) * $this->quantity;
    }
}
