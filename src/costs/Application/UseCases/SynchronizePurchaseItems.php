<?php

namespace Src\Costs\Application\UseCases;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use SimpleXMLElement;
use Src\Costs\Domain\Models\PurchaseInvoice;
use Src\Costs\Domain\Models\PurchaseItems;
use Src\Costs\Domain\Repositories\DbRepository;
use Src\Costs\Domain\UseCases\SyncPurchaseItems;
use Src\Costs\Infrastructure\NFe\XmlReader;
use Throwable;

class SynchronizePurchaseItems implements SyncPurchaseItems
{
    private DbRepository $repository;
    private XmlReader $nfeReader;

    public function __construct(DbRepository $repository, XmlReader $nfeReader)
    {
        $this->repository = $repository;
        $this->nfeReader = $nfeReader;
    }

    public function sync(): void
    {
        $data = $this->repository->listPurchaseInvoice();
        $this->execute($data);
    }

    // @todo: bloquear natOp Entrada de mercadoria (devolucao de mercadoria fora estado)
    private function execute(Collection $data): void
    {
        foreach ($data as $purchaseInvoice) {
            if ($purchaseInvoice->hasItems()) {
                continue;
            }

            $this->insertItems($purchaseInvoice, $this->getItems($purchaseInvoice));
        }
    }

    private function getItems(PurchaseInvoice $purchaseInvoice): array
    {
        $xml = $this->repository->getXml($purchaseInvoice);

        return $this->nfeReader->getItems($xml);
    }

    private function insertItems(PurchaseInvoice $purchaseInvoice, array $items): void
    {
        foreach ($items as $item) {
            if (empty($item)) {
                continue;
            }

            $item = $this->transformItem($item);
            $this->repository->insertPurchaseItem($purchaseInvoice, $item);
        }
    }

    // @todo: move to services
    private function transformItem(array $item): array
    {
        $product = $this->nfeReader->getProductData($item);
        $ean = $this->nfeReader->getEan($product);
        $name = $this->nfeReader->getName($product);
        $price = $this->nfeReader->getPrice($product);
        $quantity = $this->nfeReader->getQuantity($product);
        $freightValue = $this->nfeReader->getFreightValue($product);
        $insuranceValue = $this->nfeReader->getInsuranceValue($product);
        $discount = $this->nfeReader->getDiscount($product);
        $taxes = $this->nfeReader->getTaxes($item);
        $totalTaxes = $taxes['totalTaxes'] ?? 0.0;
        $ipiValue = $taxes['ipi']['value'] / $quantity;
        $unitCost = $price + $freightValue + $insuranceValue - $discount + $totalTaxes + $ipiValue;

        return [
            'name' => $name,
            'unit_price' => $price,
            'unit_cost' => $unitCost,
            'quantity' => $quantity,
            'freight_cost' => $freightValue,
            'insurance_cost' => $insuranceValue,
            'discount' => $discount,
            'taxes' => $taxes,
            'ean' => $ean,
        ];
    }}
