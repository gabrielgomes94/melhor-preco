<?php

namespace App\Repositories\Pricing\PriceLog;

use App\Factories\Pricing\PriceLog\PriceLog;
use App\Models\Product as ProductModel;
use App\Repositories\Product\BaseList;
use Barrigudinha\Product\Entities\ProductsCollection;
use Barrigudinha\Product\Utils\Contracts\Options;
use Illuminate\Database\Eloquent\Builder;

class ListDB extends BaseList
{
    public function count(Options $options): int
    {
        return $this->query($options)->count();
    }

    protected function get(?Options $options = null): array
    {
        return $this->query($options)
            ->paginate(perPage: $options->perPage(), page: $options->page())
            ->items();
    }

    protected function map(array $products, Options $options): ProductsCollection
    {
        $products = array_map(function (ProductModel $product) {
            return PriceLog::buildProduct($product);
        }, $products);

        return new ProductsCollection($products);
    }

    private function query(Options $options): Builder
    {
        return ProductModel::leftJoin('prices', 'prices.product_id', '=', 'products.id')
            ->whereNull('parent_sku')
            ->where('is_active', true)
            ->where('prices.store', $options->store())
            ->orderBy('prices.updated_at', 'desc');
    }
}
