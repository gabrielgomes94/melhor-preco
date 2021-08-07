<?php

namespace App\Repositories\Product;

use App\Factories\Product\Product as ProductFactory;
use App\Models\Product as ProductModel;
use App\Repositories\Product\Options\Options;

class ListDB extends BaseList
{
    protected function getProducts(?Options $options = null): array
    {
        return ProductModel::whereNull('parent_sku')
            ->get()
            ->sortBy('id')
            ->all();
    }

    protected function mapProducts(array $products, ?Options $options = null): array
    {
        return array_map(function (ProductModel $product) {
            return ProductFactory::buildFromModel($product);
        }, $products);
    }
}
