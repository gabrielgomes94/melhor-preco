<?php

namespace Src\Sales\Application\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Shipment extends Model
{
    protected $fillable = [
        'name',
        'sale_order_id',
        'street',
        'number',
        'complement',
        'district',
        'city',
        'state',
        'zipcode',
    ];

    protected $table = 'sales_shipments';

    public function saleOrder()
    {
        return $this->belongsTo(SaleOrder::class, 'sale_order_uuid', 'uuid');
    }
}
