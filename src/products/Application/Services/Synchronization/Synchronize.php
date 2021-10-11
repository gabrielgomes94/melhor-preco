<?php

namespace Src\Products\Application\Services\Synchronization;

use Src\Prices\Infrastructure\Repositories\Product\Creator;
use Src\Products\Infrastructure\Repositories\GetDB;
use Src\Products\Application\Services\Update\UpdateProduct;
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
