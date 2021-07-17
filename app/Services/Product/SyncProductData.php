<?php

namespace App\Services\Product;

use App\Repositories\Pricing\Product\Creator;
use App\Repositories\Product\FinderBling;
use App\Repositories\Product\FinderDB;
use App\Repositories\Pricing\Product\Updator;
use Barrigudinha\Product\Services\Update;

class SyncProductData
{
    private FinderDB $dbRepository;
    private FinderBling $erpRepository;
    private Updator $updator;
    private Creator $creator;
//    private Update $updateService;
    private UpdateCosts $updateService;

    public function __construct(FinderDB $dbRepository, FinderBling $erpRepository, Updator $updator, Creator $creator, UpdateCosts $updateService)
    {
        $this->dbRepository = $dbRepository;
        $this->erpRepository = $erpRepository;
        $this->updator = $updator;
        $this->creator = $creator;
        $this->updateService = $updateService;
    }

    public function sync(): void
    {
        $products = $this->erpRepository->all();

//        dd(count($products));
        foreach ($products as $product) {
            $productModel = $this->dbRepository->getModel($product->sku());

            if (!$productModel) {
                $this->creator->create($product);
                continue;
            }

            $productObject = $productModel->toDomainObject();

//            $product = $this->updateService->updateCosts($product, [
//                'purchasePrice' => $productObject->costs()->purchasePrice(),
//                'additionalCosts' => $productObject->costs()->additionalCosts(),
//                'taxICMS' => $productObject->costs()->taxICMS(),
//            ]);
//            $this->updator->sync($product, $productModel);

            $this->updateService->execute($product->sku(), [
                'purchasePrice' => $productObject->costs()->purchasePrice(),
                'additionalCosts' => $productObject->costs()->additionalCosts(),
                'taxICMS' => $productObject->costs()->taxICMS(),
            ]);
        }
    }
}
