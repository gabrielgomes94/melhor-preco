<?php

namespace Tests\Data\Models\Costs;

use Src\Costs\Infrastructure\Laravel\Models\PurchaseInvoice;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseItem;

class PurchaseItemsData
{
    public static function make(array $data = []):  PurchaseItem
    {
        $data = array_merge(
            [
                'freight_cost' => 10,
                'insurance_cost' => 0,
                'name' => 'Canguru Balbi Vermelho',
                'quantity' => 5,
                'discount' => 0.0,
                'unit_cost' => 100.0,
                'unit_price' => 150.0,
                'taxes' => [
                    'icms' => [
                        'value' => 0.0,
                        'percentage' => 0,
                    ],
                    'ipi' => [
                        'value' => 40.0,
                        'percentage' => 0.4,
                    ],
                    'totalTaxes' => 40.0
                ],
                'product_sku' => 1,
                'ean' => '12345678910',
            ],
            $data
        );
        return new PurchaseItem($data);
    }

    public static function makePersisted(PurchaseInvoice $purchaseInvoice, array $data = []): PurchaseItem
    {
        $purchaseItem = self::make($data);
        $purchaseItem->invoice()->associate($purchaseInvoice);
        $purchaseItem->save();

        if (isset($data['uuid'])) {
            $purchaseItem->uuid = $data['uuid'];
            $purchaseItem->save();
        }

        return $purchaseItem;
    }
}
