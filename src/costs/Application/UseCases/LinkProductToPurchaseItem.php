<?php

namespace Src\Costs\Application\UseCases;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Src\Costs\Domain\Models\PurchaseItems;

class LinkProductToPurchaseItem
{
    public function linkManyProducts(Collection $data): void
    {
        foreach ($data as $itemUuid => $sku) {
            if (!$sku) {
                continue;
            }

            $this->link($itemUuid, $sku);
        }
    }

    public function link(string $itemUuid, string $productSku): void
    {
        $item = PurchaseItems::where('uuid', $itemUuid)->first();
        if (!$item) {
            return;
        }

        $item->product_sku = $productSku;
        $item->save();

        Log::info('[CUSTOS] Produto vinculado à nota fiscal', [
            'sku' => $productSku,
            'itemUuid' => $item->getUuid(),
        ]);
    }
}
