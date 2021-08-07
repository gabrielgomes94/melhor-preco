<?php

namespace App\Repositories\Pricing\Product;

use App\Factories\Product\Product as ProductFactory;
use App\Models\Product as ProductModel;
use App\Repositories\Product\BaseList;
use App\Repositories\Product\Options\Options;

class ListDB extends BaseList
{
    protected function getProducts(Options $options): array
    {
        $store = $options->store();

        return ProductModel::leftJoin('prices', 'prices.product_id', '=', 'products.id')
            ->whereNull('parent_sku')
            ->whereNotNull('product_id')
            ->where('store', $store)
            ->get()
            ->sortBy('product_id')
            ->all();
    }

    protected function mapProducts(array $products, Options $options): array
    {
        return array_map(function (ProductModel $product) {
            return ProductFactory::buildWithPrice($product);
        }, $products);
    }
}
