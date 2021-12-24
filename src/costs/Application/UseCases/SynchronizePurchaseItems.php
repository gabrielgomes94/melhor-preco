<?php

namespace Src\Costs\Application\UseCases;

use Illuminate\Support\Facades\Log;
use Src\Costs\Domain\Repositories\DbRepository;
use Src\Costs\Domain\UseCases\SyncPurchaseItems;

class SynchronizePurchaseItems implements SyncPurchaseItems
{
    private DbRepository $repository;

    public function __construct(DbRepository $repository)
    {
        $this->repository = $repository;
    }

    public function sync(): void
    {
        $data = $this->repository->listPurchaseInvoice();

        foreach ($data as $purchaseInvoice) {
            $xml = $this->repository->getXml($purchaseInvoice);

            $data = json_encode($xml, true);
            $data = json_decode($data, true);

            $items = $data['NFe']['infNFe']['det'];
            Log::debug('xml de nota fiscal', ['xml' => $data['NFe']]);

            if (is_array($items) and isset($items['@attributes'])) {
                $name = $this->getName($items);
                $price = $this->getPrice($items);
                $quantity = $this->getQuantity($items);
                $freightValue = $this->getFreightValue($items);
                $insuranceValue = (float) $items['prod']['vSeg'] ?? 0.0;
                $discount = (float) $items['prod']['vDesc'] ?? 0.0;

                $purchaseItem[] = [
                    'name' => $name,
                    'unit_price' => $price,
                    'quantity' => $quantity,
                    'purchase_invoice_uuid' => $purchaseInvoice->getUuid(),
                    'freight_value' => $freightValue,
                    'insurance_value' => $insuranceValue,
                    'discount' => $discount,
                ];

                continue;
            }

            foreach ($items as $product) {
                $name = $this->getName($product['prod']['xProd']);
                $price = (float) $product['prod']['vUnCom'];
                $quantity = (float) $product['prod']['qTrib'];
                $freightValue = $this->getFreightValue($items['prod']['vFrete']);
                $insuranceValue = (float) $items['prod']['vSeg'] ?? 0.0;
                $discount = (float) $items['prod']['vDesc'] ?? 0.0;

                $purchaseItem[] = [
                    'name' => $name,
                    'unit_price' => $price,
                    'quantity' => $quantity,
                    'purchase_invoice_uuid' => $purchaseInvoice->getUuid(),
                    'freight_value' => $freightValue,
                    'insurance_value' => $insuranceValue,
                    'discount' => $discount,
                ];
                continue;
            }
        }

        dump($purchaseItem[880]);
    }

    private function getPrice(array $data): float
    {
        return (float) $data['prod']['vUnCom'] ?? $data['prod']['vUnTrib'];
    }

    private function getName(array $data): string
    {
        return $data['prod']['xProd'];
    }

    private function getQuantity(array $data): float
    {
        return (float) $data['prod']['qCom'] ?? $data['prod']['qTrib'];
    }

    private function getFreightValue($data): float
    {
        return (float) $data['prod']['vFrete'] ?? 0.0;
    }
}
