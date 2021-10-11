<?php

namespace Src\Products\Infrastructure\Repositories;

use App\Factories\Product\Product as ProductFactory;
use App\Models\Product as ProductModel;
use Barrigudinha\Product\Entities\Product;

class GetDB
{
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
