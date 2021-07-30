<?php

namespace App\Services\Product;

use App\Repositories\Pricing\Product\Creator;
use App\Repositories\Product\FinderBling;
use App\Repositories\Product\FinderDB;
use Barrigudinha\Pricing\Price\Services\CalculateProduct;
use Integrations\Bling\Products\Repositories\Repository as BlingRepository;

class SyncProductData
{
    private FinderDB $dbRepository;
    private BlingRepository $erpRepository;
    private Creator $creator;
    private UpdateCosts $updateService;
    private CalculateProduct $calculateProduct;

    public function __construct(
        FinderDB $dbRepository,
        BlingRepository $erpRepository,
        Creator $creator,
        UpdateCosts $updateService,
        CalculateProduct $calculateProduct
    ) {
        $this->dbRepository = $dbRepository;
        $this->erpRepository = $erpRepository;
        $this->creator = $creator;
        $this->updateService = $updateService;
        $this->calculateProduct = $calculateProduct;
    }

    public function sync(): void
    {
        $products = $this->erpRepository->all();

        foreach ($products as $product) {
            $productModel = $this->dbRepository->getModel($product->sku());

            if (!$productModel) {
                $this->creator->createFromArray($product->toArray());
            }

            /**
             * To Do:
             *  - Mergear dados da base local com a base do Bling
             *  - Atualizar dados na base local
             */
        }
    }
}
