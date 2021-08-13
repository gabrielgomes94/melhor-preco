<?php

namespace App\Repositories\Product;

use App\Factories\Product\Product as ProductFactory;
use App\Models\Product as ProductModel;
use Barrigudinha\Product\Entities\Product;
use Barrigudinha\Store\Repositories\StoreRepository;

class GetDB
{
    protected StoreRepository $storeRepository;

    public function __construct(StoreRepository $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    public function get(string $sku): ?Product
    {
        if ($model = $this->getModel($sku)) {
            return ProductFactory::buildFromModel($model);
        }

        return null;
    }

    public function getModel(string $sku): ?ProductModel
    {
        return ProductModel::find($sku);
    }
}
