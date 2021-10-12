<?php

namespace Src\Products\Infrastructure\Repositories;

use Src\Products\Application\Factories\Product as ProductFactory;
use Src\Products\Domain\Models\Product as ProductModel;
use Src\Products\Domain\Entities\Product;

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
