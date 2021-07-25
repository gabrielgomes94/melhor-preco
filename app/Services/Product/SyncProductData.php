<?php

namespace App\Services\Product;

use App\Repositories\Pricing\Product\Creator;
use App\Repositories\Product\FinderBling;
use App\Repositories\Product\FinderDB;
use Barrigudinha\Pricing\Price\Services\CalculateProduct;

class SyncProductData
{
    private FinderDB $dbRepository;
    private FinderBling $erpRepository;
    private Creator $creator;
    private UpdateCosts $updateService;
    private CalculateProduct $calculateProduct;

    public function __construct(
        FinderDB $dbRepository,
        FinderBling $erpRepository,
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
            $product = $this->calculateProduct->recalculate($product);

            if (!$productModel) {
                $this->creator->create($product);

                continue;
            }

            $productObject = $productModel->toDomainObject();

            $this->updateService->execute($product->sku(), [
                'purchasePrice' => $productObject->costs()->purchasePrice(),
                'additionalCosts' => $productObject->costs()->additionalCosts(),
                'taxICMS' => $productObject->costs()->taxICMS(),
            ]);
        }
    }
}
