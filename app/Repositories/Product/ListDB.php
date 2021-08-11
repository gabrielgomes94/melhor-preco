<?php

namespace App\Repositories\Product;

use App\Factories\Product\Product as ProductFactory;
use App\Models\Product as ProductModel;
use App\Repositories\Pricing\Product\Filters\Active;
use App\Repositories\Pricing\Product\Filters\Contracts\Filter;
use Barrigudinha\Product\Entities\ProductsCollection;
use Barrigudinha\Product\Repositories\Contracts\Options;

class ListDB extends BaseList
{
    /**
     * @var Filter[] $filters
     */
    protected array $filters = [
        Active::class,
    ];

    protected function getProducts(?Options $options = null): array
    {
        if (!$options || !$options->page()) {
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

    public function count(?Options $options = null): int
    {
        return ProductModel::whereNull('parent_sku')->count();
    }

    protected function mapProducts(array $products, ?Options $options = null): ProductsCollection
    {
        $products = array_map(function (ProductModel $product) {
            return ProductFactory::buildFromModel($product);
        }, $products);

        return new ProductsCollection($products);
    }
}
