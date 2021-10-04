<?php

namespace App\Services\Product\Synchronization;

use Src\Prices\Infrastructure\Repositories\Product\Creator;
use App\Repositories\Product\GetDB;
use App\Services\Product\Update\UpdateProduct;
use Integrations\Bling\Products\Repositories\Repository as BlingRepository;

class Synchronize
{
    private GetDB $dbRepository;
    private BlingRepository $erpRepository;
    private Creator $creator;
    private UpdateProduct $productUpdator;

    public function __construct(
        GetDB $dbRepository,
        BlingRepository $erpRepository,
        Creator $creator,
        UpdateProduct $productUpdator
    ) {
        $this->dbRepository = $dbRepository;
        $this->erpRepository = $erpRepository;
        $this->creator = $creator;
        $this->productUpdator = $productUpdator;
    }

    public function sync(): void
    {
        $products = $this->erpRepository->all();

        foreach ($products->data() as $erpProduct) {
            $product = $this->dbRepository->get($erpProduct->sku());
            $data = $erpProduct->toArray();

            if (!$product) {
                $this->creator->createFromArray($data);

                continue;
            }

            $this->productUpdator->execute($product, $data);
        }
    }
}
