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
        $i = 0;
        foreach ($data as $purchaseInvoice) {
            $xml = $this->repository->getXml($purchaseInvoice);
            $items = $this->nfeReader->getItems($xml);

            foreach ($items as $product) {
                if (empty($product)) {
                    continue;
                }


                $item = $this->getItem($product);
                $this->savePurchaseItem($item, $purchaseInvoice);
            }
        }
    }

    private function getItem(array $product): array
    {
        $name = $this->nfeReader->getName($product);
        $price = $this->nfeReader->getPrice($product);
        $quantity = $this->nfeReader->getQuantity($product);
        $freightValue = $this->nfeReader->getFreightValue($product);
        $insuranceValue = $this->nfeReader->getInsuranceValue($product);
        $discount = $this->nfeReader->getDiscount($product);
        $taxes = $this->nfeReader->getTaxes($product);

        return [
            'name' => $name,
            'unit_price' => $price,
            'unit_cost' => 0.0,
            'quantity' => $quantity,
            'freight_cost' => $freightValue,
            'insurance_cost' => $insuranceValue,
            'discount' => $discount,
            'taxes_cost' => 0.0,
            'taxes' => $taxes,
        ];
    }

    private function savePurchaseItem(array $item, PurchaseInvoice $purchaseInvoice): bool
    {
        $purchaseItem = new PurchaseItems($item);

        try {
            $purchaseInvoice->items()->save($purchaseItem);

            Log::info('[CUSTOS] Sucesso na sincronização de items: ', [
                'invoice' => $purchaseInvoice->getUuid(),
                'item' => $item,
            ]);
        } catch (Throwable $exception) {
            Log::error('[CUSTOS] Erro na sincronização de items: ', [
                'invoice' => $purchaseInvoice->getUuid(),
                'exception' => get_class($exception),
                'message' => $exception->getMessage(),
                'item' => $item,
                'items' => $purchaseItem,
            ]);
        }

        return false;
    }
}
