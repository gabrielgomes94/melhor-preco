<?php

namespace Src\Costs\Application\UseCases;

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

            $operationNature = $data['NFe']['infNFe']['ide']['natOp'];
            $items = $data['NFe']['infNFe']['det']['prod'];

            $product = $data['NFe']['infNFe']['det'];
            dd($product);
//            dd($data, $data['NFe'], $operationNature, $product);

            $operationNature = $data['NFe']['ide']['natOp'];

            dd($xml->children('NFe'));
            $purchaseItem[] = [
                'unit_price',
                'quantity'

            ];
        }
    }
}
