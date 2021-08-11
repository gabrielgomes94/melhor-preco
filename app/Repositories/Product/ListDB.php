<?php

namespace App\Repositories\Product;

use App\Factories\Product\Product as ProductFactory;
use App\Models\Product as ProductModel;
use App\Repositories\Product\Options\Options;

class ListDB extends BaseList
{
    protected function getProducts(?Options $options = null): array
    {
        if (!$options->page()) {
            return ProductModel::whereNull('parent_sku')
                ->get()
                ->sortBy('sku')
                ->all();
        }

        return ProductModel::whereNull('parent_sku')
            ->paginate(perPage: $options->perPage(), page: $options->page())
            ->sortBy('sku')
            ->all();
    }

    protected function countProducts(Options $options): int
    {
        return ProductModel::whereNull('parent_sku')->count();
    }

    protected function mapProducts(array $products, ?Options $options = null): array
    {
        return array_map(function (ProductModel $product) {
            return ProductFactory::buildFromModel($product);
        }, $products);
    }
}
