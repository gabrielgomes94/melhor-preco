<?php

namespace Src\Sales\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Src\Products\Domain\Models\Product\Product;
use Src\Sales\Domain\Models\Item as ItemModel;
use Src\Sales\Domain\Models\ValueObjects\Items\Item as ItemData;

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
        return $this->belongsTo(SaleOrder::class, 'sale_order_id', 'sale_order_id');
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function getTotalValue(): float
    {
        return ($this->unit_value - $this->discount) * $this->quantity;
    }

    public static function fromValueObject(ItemData $item): self
    {
        return new self([
            'sku' => $item->sku(),
            'name' => $item->name(),
            'quantity' => $item->quantity(),
            'unit_value' => $item->unitValue(),
            'discount' => $item->discount(),
        ]);
    }
}
