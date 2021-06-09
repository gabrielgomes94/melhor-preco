<?php

namespace App\Services\Product;

use App\Repositories\Pricing\Product\Creator;
use App\Repositories\Product\FinderBling;
use App\Repositories\Product\FinderDB;
use App\Repositories\Pricing\Product\Updator;

class SyncProductData
{
    private FinderDB $dbRepository;
    private FinderBling $erpRepository;
    private Updator $updator;
    private Creator $creator;

    public function __construct(FinderDB $dbRepository, FinderBling $erpRepository, Updator $updator, Creator $creator)
    {
        $this->dbRepository = $dbRepository;
        $this->erpRepository = $erpRepository;
        $this->updator = $updator;
        $this->creator = $creator;
    }

    public function sync(): void
    {
        $products = $this->erpRepository->all();

        foreach ($products as $product) {
            $productData = $this->dbRepository->get($product->sku);

            if (!$productData) {
                $this->creator->create($product);
                continue;
            }


            // TODO: Criar método para sincronizar dados do bling com o banco
//            $this->updator->sync($productData, $product);
//            $this->updator->update($productData->id(), $productData->toArray());
        }
    }
}
