<?php

namespace App\Services\Product;

use App\Repositories\Pricing\Product\Creator;
use App\Repositories\Product\FinderDB;
use App\Services\Product\Update\UpdateProduct;
use Integrations\Bling\Products\Repositories\Repository as BlingRepository;

class Synchronize
{
    private FinderDB $dbRepository;
    private BlingRepository $erpRepository;
    private Creator $creator;
    private UpdateProduct $productUpdator;

    public function __construct(
        FinderDB $dbRepository,
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
