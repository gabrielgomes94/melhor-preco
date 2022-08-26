<?php

namespace Tests\Data\Models\Costs;

use Src\Costs\Infrastructure\Laravel\Models\PurchaseInvoice;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseItem;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;

class PurchaseItemsData
{
    public static function make(array $data = []):  PurchaseItem
    {
        $purchaseItem = new PurchaseItem(
            array_replace(
                self::getPayload(),
                $data
            )
        );

        if (isset($data['uuid'])) {
            $purchaseItem->uuid = $data['uuid'];
        }

        return $purchaseItem;
    }

    public static function makePersisted(PurchaseInvoice $purchaseInvoice, array $data = [], ?Product $product = null): PurchaseItem
    {
        $purchaseItem = self::make($data);
        $purchaseItem->invoice()->associate($purchaseInvoice);
        $purchaseItem->product()->associate($product);
        $purchaseItem->save();

        return $purchaseItem;
    }

    public static function getPayload(): array
    {
        return [
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
        ];
    }
}
