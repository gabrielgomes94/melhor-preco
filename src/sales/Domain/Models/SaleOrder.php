<?php

namespace Src\Sales\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Src\Sales\Domain\Models\Concerns\SaleOrderGetters;
use Src\Sales\Domain\Models\Concerns\SaleOrderRelationships;
use Src\Sales\Domain\Models\Concerns\SaleOrderScopes;
use Src\Sales\Domain\Models\Contracts\SaleOrder as SaleOrderInterface;

class SaleOrder extends Model implements SaleOrderInterface
{
    use SaleOrderGetters;
    use SaleOrderRelationships;
    use SaleOrderScopes;

    protected $casts = [
        'sale_order_id' => 'integer',
        'selled_at' => 'datetime',
        'dispatched_at' => 'datetime',
        'expected_arrival_at' => 'datetime',
    ];

    protected $fillable = [
        'sale_order_id',
        'purchase_order_id',
        'integration',
        'store_id',
        'store_sale_order_id',
        'selled_at',
        'dispatched_at',
        'expected_arrival_at',
        'discount',
        'freight',
        'status',
        'total_products',
        'total_profit',
        'total_value',
    ];
}
