<?php

namespace Tests\Data\Models\Sales;

use Src\Sales\Application\Models\SaleOrder;
use Src\Sales\Application\Models\Shipment;

class ShipmentData
{
    public static function build(SaleOrder $saleOrder): Shipment
    {
        return new Shipment([
            'name' => 'João da Silva',
            'sale_order_id' => $saleOrder->getIdentifiers()->saleOrderId(),
            'street' => 'Rua Grapecica',
            'number' => '115',
            'complement' => '2 andar',
            'district' => 'Brooklyn',
            'city' => 'São Paulo',
            'state' => 'SP',
            'zipcode' => 04562040,
        ]);
    }
}
