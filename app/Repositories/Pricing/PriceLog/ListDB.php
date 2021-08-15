<?php

namespace App\Repositories\Pricing\PriceLog;

use App\Factories\Pricing\PriceLog\PriceLog;
use App\Models\Product as ProductModel;
use App\Repositories\Product\BaseList;
use App\Repositories\Product\Options\Options;
use Barrigudinha\Product\Entities\ProductsCollection;
use Barrigudinha\Product\Repositories\Contracts\Options as OptionsInterface;

class ListDB extends BaseList
{
    public function count(?OptionsInterface $options = null): int
    {
        // TODO: Implement count() method.
    }

    protected function get(?Options $options = null): array
    {
        $query = ProductModel::leftJoin('prices', 'prices.product_id', '=', 'products.id')
            ->whereNull('parent_sku')
            ->where('is_active', true)
            ->orderBy('prices.updated_at', 'desc')
            ->paginate(perPage: $options->perPage(), page: $options->page())
            ->all();

        return $query;
    }

    protected function map(array $products, Options $options): ProductsCollection
    {
        $products = array_map(function (ProductModel $product) {
            return PriceLog::buildProduct($product);
        }, $products);

        return new ProductsCollection($products);
    }
}
