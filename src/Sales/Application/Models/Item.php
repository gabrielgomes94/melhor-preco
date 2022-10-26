<?php

namespace Src\Sales\Application\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;

class Item extends Model
{
    protected $fillable = [
        'sku',
        'name',
        'quantity',
        'unit_value',
        'discount',
        'sale_order_id',
    ];

    protected $casts = [
        'sku' => 'string',
    ];

    protected $table = 'sales_items';

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_uuid', 'uuid');
    }

    public function saleOrder()
    {
        return $this->belongsTo(SaleOrder::class, 'sale_order_uuid', 'uuid');
    }

    public function getMarketplace(): ?Marketplace
    {
        return $this?->getSaleOrder()?->getMarketplace();
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function getSaleOrder(): ?SaleOrder
    {
        return $this->saleOrder;
    }

    public function getSelledAt(): ?Carbon
    {
        return $this?->getSaleOrder()?->getSelledAt();
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function getTotalValue(): float
    {
        return ($this->unit_value - $this->discount) * $this->quantity;
    }

    public function getUnitValue(): float
    {
        return $this->unit_value;
    }

    public function getDiscount(): float
    {
        return $this->discount;
    }
}
