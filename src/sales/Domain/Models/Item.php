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

    protected $table = 'sales_items';

    public function product()
    {
        return $this->belongsTo(Product::class, 'sku', 'sku');
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }
}
