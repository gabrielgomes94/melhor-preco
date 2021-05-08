<?php

namespace App\Services\Product;

use App\Repositories\Pricing\Product\FinderBling;
use App\Repositories\Pricing\Product\FinderDB;
use App\Repositories\Pricing\Product\Updator;
use Integrations\Bling\Products\StoreClient as ProductClient;

class SyncProductData
{
    private FinderDB $dbRepository;
    private FinderBling $erpRepository;
    private Updator $updator;

    public function __construct(FinderDB $dbRepository, FinderBling $erpRepository, Updator $updator)
    {
        $this->dbRepository = $dbRepository;
        $this->erpRepository = $erpRepository;
        $this->updator = $updator;
    }

    public function sync(): void
    {
        $products = $this->dbRepository->all();

        foreach($products as $product) {
            $data = $this->erpRepository->get($product->sku())->toArray();
            $this->updator->update($product->id(), $data);
        }
    }
}
